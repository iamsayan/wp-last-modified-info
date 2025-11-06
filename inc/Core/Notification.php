<?php
/**
 * Send notification on every post update.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Core;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Notification class.
 */
class Notification
{
	use HelperFunctions;
    use Hooker;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( 'post_updated', 'email', 10, 3 );
	}

	/**
	 * Send email notification when a post is updated.
	 *
	 * @param int     $post_id      Post ID.
	 * @param \WP_Post $post_after  Post object following the update.
	 * @param \WP_Post $post_before Post object before the update.
	 * @return void
	 */
	public function email( $post_id, $post_after, $post_before ) {
		// Early bailouts for common edge cases.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! isset( $post_before->ID, $post_after->ID ) || $post_before->ID !== $post_after->ID ) {
			return;
		}

		if ( ! $this->is_enabled( 'enable_notification_cb' ) ) {
			return;
		}

		// Skip auto-draft → publish transitions.
		if ( 'auto-draft' === $post_before->post_status && 'publish' === $post_after->post_status ) {
			return;
		}

		// Skip if both sides are drafts and draft notifications are disabled.
		if ( ! $this->is_enabled( 'lmt_enable_draft_noti_cb' )
			&& in_array( $post_before->post_status, [ 'draft', 'auto-draft' ], true )
			&& 'draft' === $post_after->post_status
		) {
			return;
		}

		$post_types = (array) $this->get_data( 'lmt_enable_noti_post_types', [ 'post' ] );
		if ( ! in_array( $post_before->post_type, $post_types, true ) ) {
			return;
		}

		// Skip if no revision exists (brand-new post).
		if ( ! wp_get_post_revisions( $post_id, [ 'numberposts' => 1 ] ) ) {
			return;
		}

		// Build diff text only for changed fields.
		$diff = [];

		if ( $post_before->post_title !== $post_after->post_title ) {
			$diff[] = $this->diff_line( __( 'Title', 'wp-last-modified-info' ), $post_before->post_title, $post_after->post_title );
		}

		if ( $post_before->post_content !== $post_after->post_content ) {
			$diff[] = $this->diff_line( __( 'Content', 'wp-last-modified-info' ), $post_before->post_content, $post_after->post_content );
		}

		if ( $post_before->post_excerpt !== $post_after->post_excerpt ) {
			$diff[] = $this->diff_line( __( 'Excerpt', 'wp-last-modified-info' ), $post_before->post_excerpt, $post_after->post_excerpt );
		}

		if ( $post_before->post_author != $post_after->post_author ) {
			$diff[] = $this->diff_line( __( 'Author', 'wp-last-modified-info' ), $this->author_name( $post_before->post_author ), $this->author_name( $post_after->post_author ) );
		}

		if ( $post_before->post_name !== $post_after->post_name ) {
			$diff[] = $this->diff_line( __( 'Link', 'wp-last-modified-info' ), $this->permalink( $post_before ), $this->permalink( $post_after ) );
		}

		if ( $post_before->comment_status !== $post_after->comment_status ) {
			$diff[] = $this->diff_line( __( 'Comment Status', 'wp-last-modified-info' ), $post_before->comment_status, $post_after->comment_status );
		}

		if ( $post_before->ping_status !== $post_after->ping_status ) {
			$diff[] = $this->diff_line( __( 'Ping Status', 'wp-last-modified-info' ), $post_before->ping_status, $post_after->ping_status );
		}

		$text = implode( "\n", $diff );
		$text = $this->do_filter( 'notification_content', $text, $post_id, $post_before, $post_after );

		if ( '' === $text ) {
			return; // Nothing changed.
		}

		// Collect recipients.
		$recipients = array_filter( array_map( 'trim', explode( ',', $this->get_data( 'lmt_email_recipient', '' ) ) ) );
		if ( $this->is_enabled( 'enable_author_noti_cb' ) ) {
			$author_email = get_the_author_meta( 'email', $post_before->post_author );
			if ( $author_email && ! in_array( $author_email, $recipients, true ) ) {
				$recipients[] = $author_email;
			}
		}
		$recipients = array_unique( array_filter( $recipients, 'is_email' ) );

		if ( ! $recipients ) {
			return;
		}

		$subject = $this->generate_html( $this->get_data( 'lmt_email_subject' ), $post_id, $post_before );
		$body    = $this->generate_html( $this->get_data( 'lmt_email_message' ), $post_id, $post_before, $text, 'body' );
		$headers = $this->do_filter( 'email_headers', [ 'Content-Type: text/html; charset=UTF-8' ] );

		wp_mail( $recipients, $subject, $body, $headers );
	}

	/**
	 * Helper to produce a single diff line.
	 *
	 * @param string $label
	 * @param string $old
	 * @param string $new
	 * @return string
	 */
	private function diff_line( $label, $old, $new ) {
		return sprintf(
			'<strong>%1$s:</strong><br>%2$s<br>%3$s',
			esc_html( $label ),
			esc_html( __( 'Old:', 'wp-last-modified-info' ) ) . ' ' . esc_html( $old ),
			esc_html( __( 'New:', 'wp-last-modified-info' ) ) . ' ' . esc_html( $new )
		);
	}

	/**
	 * Helper to get author display name.
	 *
	 * @param int $user_id
	 * @return string
	 */
	private function author_name( $user_id ) {
		return get_the_author_meta( 'display_name', $user_id ) ?: __( 'Unknown', 'wp-last-modified-info' );
	}

	/**
	 * Helper to get permalink for a post object.
	 *
	 * @param \WP_Post $post
	 * @return string
	 */
	private function permalink( $post ) {
		return esc_url( get_permalink( $post ) );
	}

	/**
	 * Replace email template variables.
	 *
	 * @param string   $text       Template text.
	 * @param int      $post_id    Post ID.
	 * @param \WP_Post $post       Post object.
	 * @param string   $diff_html  Diff HTML for body.
	 * @param string   $type       'subject' or 'body'.
	 * @return string
	 */
	private function generate_html( $text, $post_id, $post, $diff_html = '', $type = 'subject' ) {
		$text = stripslashes( $text );

		$replacements = [
			'%author_name%'          => $this->author_name( $post->post_author ),
			'%modified_author_name%' => $this->author_name( $this->get_meta( $post_id, '_edit_last' ) ),
			'%post_title%'           => $post->post_title,
			'%post_type%'              => get_post_type( $post_id ),
			'%current_time%'           => date_i18n( $this->do_filter( 'notification_datetime_format', 'j F, Y @ g:i a', $post_id ), current_time( 'timestamp', 0 ) ),
			'%site_name%'              => wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ),
			'%site_url%'               => esc_url( home_url() ),
		];

		if ( 'body' === $type ) {
			$replacements += [
				'%post_link%'      => esc_url( get_permalink( $post_id ) ),
				'%post_edit_link%' => esc_url( get_edit_post_link( $post_id ) ),
				'%admin_email%'    => sanitize_email( get_bloginfo( 'admin_email' ) ),
				'%post_diff%'      => nl2br( $diff_html ),
			];
		}

		$text = str_replace( array_keys( $replacements ), array_values( $replacements ), $text );

		return 'subject' === $type
			? wp_strip_all_tags( stripslashes( $text ) )
			: stripslashes( htmlspecialchars_decode( $text ) );
	}
}
