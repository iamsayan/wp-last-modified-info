<?php
/**
 * Show Original Republish Data.
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
 * Republish info class.
 */
class AdminBar
{
	use HelperFunctions, Hooker;

	/**
	 * Register functions.
	 */
	public function register()
	{
		$this->action( 'admin_bar_menu', 'admin_bar' );
	}

	/**
	 * Show original publish info.
	 * 
	 * @param string  $content  Original Content
	 * 
	 * @return string $content  Filtered Content
	 */
	public function admin_bar( $wp_admin_bar )
	{
		global $post;

		if ( ! $this->is_enabled( 'enable_on_admin_bar_cb' ) ) {
			return;
		}

        // If it's admin page, then get out!
        if ( ! is_singular() ) {
			return;
		}
    
        // If user can't publish posts, then get out
        if ( ! current_user_can( 'publish_posts' ) ) {
			return;
		}
    
        if ( get_post_status() === 'auto-draft' ) {
    		return;
        }
        
        $object = get_post_type_object( get_post_type() );
        $args = array(
            'id' => 'wplmi-update',
            'parent' => 'top-secondary',
            'title'  => $this->title(),
            'href'   => $this->revision(),
            'meta' => array(
                'title'  => sprintf( __( 'This %1$s was last updated on %2$s at %3$s by %4$s', 'wp-last-modified-info' ), get_post_type(), get_the_modified_date(), get_the_modified_time(), get_the_modified_author() ),
                'target' => '_blank',
            )
        );
    
        $wp_admin_bar->add_node( $args );
	}
	
	private function title()
	{
		// retrive date time formats
		$cur_time = current_time('U');
		$mod_time = get_the_modified_time( 'U' );
		$org_time = get_the_time('U');
	
		if ( $mod_time > $cur_time || $org_time > $mod_time ) {
			return sprintf( __( 'Updated on %1$s at %2$s', 'wp-last-modified-info' ), get_the_modified_date( 'M j' ), get_the_modified_time() );
		}
		return sprintf( __( 'Updated %s ago', 'wp-last-modified-info' ), human_time_diff( get_the_modified_time( 'U' ), $cur_time ) );
	}

	private function revision()
	{
		global $post;
		$post_id = $post->ID;
	
		// If user can't edit post, then don't show
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	
		$revision = wp_get_post_revisions( $post_id );
		$latest_revision = array_shift( $revision );
	
		if ( wp_revisions_enabled( $post ) && count( $revision ) >= 1 ) {
			return get_admin_url() . 'revision.php?revision=' . $latest_revision->ID;
		}
	
		return;
	}
}