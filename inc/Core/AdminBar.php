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
	 * Show original publish info.
	 *
	 * @param string  $content  Original Content
	 *
	 * @return string $content  Filtered Content
	 */
	public function admin_bar( $wp_admin_bar ) {
		global $post;

		if ( ! $post instanceof \WP_Post ) {
			return;
		}

		if ( ! $this->is_enabled( 'enable_on_admin_bar_cb' ) ) {
			return;
		}

        // If it's admin page, then get out!
        if ( ! is_singular() || ! current_user_can( 'publish_posts' ) ) {
			return;
		}

        if ( 'auto-draft' === get_post_status() ) {
    		return;
        }

        $object = get_post_type_object( get_post_type() );
        $args = array(
            'id'     => 'wplmi-update',
            'parent' => 'top-secondary',
            'title'  => $this->title(),
            'href'   => $this->revision(),
            'meta'   => array(
				/* translators: %1$s: Post Type Label, %2$s: Post Modified Date, %3$s: Post Modified Time, %4$s: POst Modified Author */
                'title'  => sprintf( __( 'This %1$s was last updated on %2$s at %3$s by %4$s', 'wp-last-modified-info' ), esc_html( $object->labels->singular_name ), $this->get_modified_date(), $this->get_modified_date( get_option( 'time_format' ) ), get_the_modified_author() ),
                'target' => '_blank',
            ),
        );

        $wp_admin_bar->add_node( $args );
	}

	/**
	 * Generate title to show on admin bar
	 */
	private function title() {
		// retrive date time formats
		$cur_time = current_time( 'U' );
		$mod_time = $this->get_modified_date( 'U' );
		$org_time = get_post_time( 'U', false, get_the_ID(), true );

		if ( $mod_time > $cur_time || $org_time > $mod_time ) {
			/* translators: %s: date time info */
			return sprintf( __( 'Updated on %1$s at %2$s', 'wp-last-modified-info' ), $this->get_modified_date( 'M j' ), $this->get_modified_date( get_option( 'time_format' ) ) );
		}

		/* translators: %s: time diff */
		return sprintf( __( 'Updated %s ago', 'wp-last-modified-info' ), human_time_diff( $this->get_modified_date( 'U' ), $cur_time ) );
	}

	/**
	 * Generate revision url to show on admin bar
	 */
	private function revision() {
		global $post;

		if ( ! $post instanceof \WP_Post ) {
			return;
		}

		// If user can't edit post, then don't show
		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return;
		}

		$revision = wp_get_post_revisions( $post->ID );
		$latest_revision = array_shift( $revision );
		$url = '';

		if ( wp_revisions_enabled( $post ) && count( $revision ) >= 1 ) {
			$url = get_admin_url() . 'revision.php?revision=' . $latest_revision->ID;
		}

		return $url;
	}
}
