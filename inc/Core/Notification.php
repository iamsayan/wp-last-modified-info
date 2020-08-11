<?php
/**
 * Send notification on every post update.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core
 * @author     Sayan Datta <hello@sayandatta.in>
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
	use HelperFunctions, Hooker;

	/**
	 * Register functions.
	 */
	public function register()
	{
		$this->action( 'post_updated', 'email', 10, 3 );
	}

	/**
	 * Show original publish info.
	 * 
	 * @param string  $content  Original Content
	 * 
	 * @return string $content  Filtered Content
	 */
	public function email( $post_id, $post_after, $post_before )
	{
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! $this->is_enabled( 'enable_notification_cb' ) ) {
			return;
		}
	
		// Transitioning from an Auto Draft to Published shouldn't result in a notification.
		if ( $post_before->post_status === 'auto-draft' && $post_after->post_status === 'publish' ) {
			return;
		}
	
		// If we're purely saving a draft, and don't have the draft option enabled, skip. If we're transitioning one way or the other, send a notification.
		if ( ! $this->is_enabled( 'lmt_enable_draft_noti_cb' ) && in_array( $post_before->post_status, [ 'draft', 'auto-draft' ] ) && 'draft' === $post_after->post_status ) {
			return;
		}
	
		$post_types = $this->get_data( 'lmt_enable_noti_post_types', [ 'post' ] );
		if ( ! in_array( $post_before->post_type, $post_types ) ) {
			return;
		}
	
		// If this is a new post, skip.
		$child_posts = wp_get_post_revisions( $post_id, [ 'numberposts' => 1 ] );
		if ( count( $child_posts ) == 0 ) {
			return;
		}
	
		if ( ! $post_before || ! $post_after ) {
			return;
		}
	
		$text = '';
		if ( $post_before->post_title !== $post_after->post_title ) {
			$text .= sprintf( '<strong>%1$s:</strong> %2$s', __( 'Old Title:', 'wp-last-modified-info' ), $post_before->post_title ) . "\n";
			$text .= sprintf( '<strong>%1$s:</strong> %2$s', __( 'New Title:', 'wp-last-modified-info' ), $post_after->post_title ) . "\n";
		}
	
		if ( $post_before->post_content !== $post_after->post_content ) {
			$text .= sprintf( '<strong>%1$s:</strong> %2$s', __( 'Old Post Content:', 'wp-last-modified-info' ), $post_before->post_content ) . "\n";
			$text .= sprintf( '<strong>%1$s:</strong> %2$s', __( 'New Post Content:', 'wp-last-modified-info' ), $post_after->post_content ) . "\n";
		}
	
		if ( $post_before->post_excerpt !== $post_after->post_excerpt ) {
			$text .= sprintf( '<strong>%1$s:</strong> %2$s', __( 'Old Excerpt:', 'wp-last-modified-info' ), $post_before->post_excerpt ) . "\n";
			$text .= sprintf( '<strong>%1$s:</strong> %2$s', __( 'New Excerpt:', 'wp-last-modified-info' ), $post_after->post_excerpt ) . "\n";
		}
	
		if ( $post_before->post_author !== $post_after->post_author ) {
			$text .= sprintf( '<strong>%1$s:</strong> %2$s', __( 'Old Author:', 'wp-last-modified-info' ), $post_before->post_author ) . "\n";
			$text .= sprintf( '<strong>%1$s:</strong> %2$s', __( 'New Author:', 'wp-last-modified-info' ), $post_after->post_author ) . "\n";
		}
	
		if ( $post_before->post_name !== $post_after->post_name ) {
			$text .= sprintf( '<strong>%1$s:</strong> %2$s', __( 'Old Link:', 'wp-last-modified-info' ), esc_url( str_replace( $post_after->post_name, $post_before->post_name, get_permalink( $post_before->ID ) ) ) ) . "\n";
			$text .= sprintf( '<strong>%1$s:</strong> %2$s', __( 'New Link:', 'wp-last-modified-info' ), esc_url( get_permalink( $post_after->ID ) ) ) . "\n";
		}
	
		if ( $post_before->comment_status !== $post_after->comment_status ) {
			$text .= sprintf( '<strong>%1$s:</strong> %2$s', __( 'Old Comment Status:', 'wp-last-modified-info' ), $post_before->comment_status ) . "\n";
			$text .= sprintf( '<strong>%1$s:</strong> %2$s', __( 'New Comment Status:', 'wp-last-modified-info' ), $post_after->comment_status ) . "\n";
		}
	
		if ( $post_before->ping_status !== $post_after->ping_status ) {
			$text .= sprintf( '<strong>%1$s:</strong> %2$s', __( 'Old Ping Status:', 'wp-last-modified-info' ), $post_before->ping_status ) . "\n";
			$text .= sprintf( '<strong>%1$s:</strong> %2$s', __( 'New Ping Status:', 'wp-last-modified-info' ), $post_after->ping_status ) . "\n";
		}
	
		$text = $this->do_filter( 'notification_content', $text, $post_id, $post_before, $post_after );
		$post_author = get_user_by( 'id', $post_before->post_author );
		
		$recipients = [];
		$recipients = explode( ',', $this->get_data( 'lmt_email_recipient', [] ) );
		if ( $this->is_enabled( 'enable_author_noti_cb' ) ) {
			if ( ! in_array( $post_author->data->user_email, $recipients ) ) {
				$recipients[] = filter_var( $post_author->data->user_email, FILTER_SANITIZE_EMAIL );
			}
		}

		$subject = $this->generate_html( $this->get_data( 'lmt_email_subject' ), $post_id, $post_before );
		$body = $this->generate_html( $this->get_data( 'lmt_email_message' ), $post_id, $post_before, $text, 'body' );
		$headers = [ 'Content-Type: text/html; charset=UTF-8' ];
		$headers = $this->do_filter( 'email_headers', $headers );
	
		if ( ! empty( $text ) && ! empty( $recipients ) ) {
			wp_mail( $recipients, $subject, $body, $headers );
		}
	}

	/**
	 * Replace email variables.
	 *
	 * @param string  $text  Input data.
	 * @param object  $post  WP Post object.
	 * @param string  $type  Sting type. Default subject.
	 * 
	 * @return string
	 */
	private function generate_html( $text, $post_id, $post_before, $html = '', $type = 'subject' )
	{
		$text = stripslashes( $text );
		$text = str_replace( '%author_name%', get_the_author_meta( 'display_name', $post_before->post_author ), $text );
		$text = str_replace( '%modified_author_name%', get_the_author_meta( 'display_name', $this->get_meta( $post_id, '_edit_last' ) ), $text ); 
		$text = str_replace( '%post_title%', $post_before->post_title, $text ); 
		$text = str_replace( '%post_type%', get_post_type( $post_id ), $text ); 
		$text = str_replace( '%current_time%', date_i18n( $this->do_filter( 'notification_datetime_format', 'j F, Y @ g:i a', $post_id ), current_time( 'timestamp', 0 ) ), $text );
		$text = str_replace( '%site_name%', wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ), $text ); 
		$text = str_replace( '%site_url%', esc_url( get_bloginfo( 'url' ) ), $text );
		
		if ( $type == 'subject' ) {
            return stripslashes( wp_strip_all_tags( $text ) );
		}

		$text = str_replace( '%post_link%', esc_url( get_the_permalink( $post_id ) ), $text ); 
		$text = str_replace( '%post_edit_link%', esc_url( get_edit_post_link( $post_id ) ), $text );
		$text = str_replace( '%admin_email%', filter_var( get_bloginfo( 'admin_email' ), FILTER_SANITIZE_EMAIL ), $text );
        $text = str_replace( '%post_diff%', str_replace( "\n", '<br>', $html ), $text );

		return stripslashes( htmlspecialchars_decode( $text ) );
	}
}