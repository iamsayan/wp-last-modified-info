<?php
/**
 * Shows last modified info on admin bar.
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
 * Admin Bar class.
 */
class AdminBar
{
	use HelperFunctions;
    use Hooker;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( 'admin_bar_menu', 'admin_bar' );
	}

	/**
	 * Add last-modified node to the admin bar on the frontend.
	 *
	 * @param \WP_Admin_Bar $wp_admin_bar Admin-bar instance.
	 * @return void
	 */
	public function admin_bar( $wp_admin_bar ) {
		// Ensure we are on a singular view and have a valid post.
		$post = get_queried_object();
		if ( ! $post instanceof \WP_Post ) {
			return;
		}

		// Feature toggle.
		if ( ! $this->is_enabled( 'enable_on_admin_bar_cb' ) ) {
			return;
		}

		// Capability check.
		if ( ! current_user_can( 'publish_posts' ) ) {
			return;
		}

		// Exclude auto-drafts.
		if ( 'auto-draft' === $post->post_status ) {
			return;
		}

		// Post-type object.
		$pto = get_post_type_object( $post->post_type );
		if ( ! $pto ) {
			return;
		}

		// Build tooltip.
		$tooltip = sprintf(
			/* translators: 1: post-type singular name, 2: modified date, 3: modified time, 4: modified author */
			__( 'This %1$s was last updated on %2$s at %3$s by %4$s', 'wp-last-modified-info' ),
			esc_html( $pto->labels->singular_name ),
			$this->get_modified_date( '', $post->ID ),
			$this->get_modified_date( get_option( 'time_format' ), $post->ID ),
			esc_html( get_the_modified_author( $post ) )
		);

		$wp_admin_bar->add_node( [
			'id'     => 'wplmi-update',
			'parent' => 'top-secondary',
			'title'  => $this->build_title( $post ),
			'href'   => $this->build_revision_url( $post ),
			'meta'   => [
				'title'  => $tooltip,
				'target' => $this->build_revision_url( $post ) ? '_blank' : '',
			],
		] );
	}

	/**
	 * Build the text shown in the admin-bar node.
	 *
	 * @param \WP_Post $post Post object.
	 * @return string
	 */
	private function build_title( \WP_Post $post ) {
		$now = current_time( 'timestamp' );
		$mod = mysql2date( 'G', $post->post_modified, false );
		$pub = mysql2date( 'G', $post->post_date, false );

		// Future or invalid timestamps: show absolute date/time.
		if ( $mod > $now || $pub > $mod ) {
			return sprintf(
				/* translators: 1: date, 2: time */
				__( 'Updated on %1$s at %2$s', 'wp-last-modified-info' ),
				$this->get_modified_date( 'M j', $post->ID ),
				$this->get_modified_date( get_option( 'time_format' ), $post->ID )
			);
		}

		// Default: human time diff.
		return sprintf(
			/* translators: %s: human-readable time difference */
			__( 'Updated %s ago', 'wp-last-modified-info' ),
			human_time_diff( $mod, $now )
		);
	}

	/**
	 * Return the revision URL for the post if available.
	 *
	 * @param \WP_Post $post Post object.
	 * @return string URL or empty string.
	 */
	private function build_revision_url( \WP_Post $post ) {
		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return '';
		}

		if ( ! wp_revisions_enabled( $post ) ) {
			return '';
		}

		$revisions = wp_get_post_revisions( $post->ID, [ 'posts_per_page' => 1 ] );
		if ( empty( $revisions ) ) {
			return '';
		}

		$revision = reset( $revisions );
		return admin_url( 'revision.php?revision=' . $revision->ID );
	}
}
