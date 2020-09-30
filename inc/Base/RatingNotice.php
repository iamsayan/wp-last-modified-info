<?php 
/**
 * Rating notice.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Base
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Base;

use Wplmi\Helpers\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * Rating notice class.
 */
class RatingNotice
{
	use Hooker;

	/**
	 * Register functions.
	 */
	public function register()
	{
		$this->action( 'admin_notices', 'show_notice' );
		$this->action( 'admin_init', 'dismiss_notice' );
	}
	
	/**
	 * Show admin notices.
	 */
	public function show_notice()
	{
		// Show notice after 240 hours (10 days) from installed time.
		if ( $this->calculate_time() > strtotime( '-360 hours' )
	    	|| '1' === get_option( 'wplmi_plugin_dismiss_rating_notice' )
            || ! current_user_can( 'manage_options' )
			|| apply_filters( 'wplmi/hide_sticky_rating_notice', false ) ) {
            return;
        }
    
        $dismiss = wp_nonce_url( add_query_arg( 'wplmi_rating_notice_action', 'dismiss_true' ), 'dismiss_true' ); 
        $no_thanks = wp_nonce_url( add_query_arg( 'wplmi_rating_notice_action', 'no_thanks_true' ), 'no_thanks_true' ); ?>
        
        <div class="notice notice-success">
            <p><?php _e( 'Hey, I noticed you\'ve been using WP Last Modified Info for more than 1 week – that’s awesome! Could you please do me a BIG favor and give it a <strong>5-star</strong> rating on WordPress? Just to help us spread the word and boost my motivation.', 'wp-last-modified-info' ); ?></p>
            <p><a href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?filter=5#new-post" target="_blank" class="button button-secondary"><?php _e( 'Ok, you deserve it', 'wp-last-modified-info' ); ?></a>&nbsp;
            <a href="<?php echo $dismiss; ?>" class="already-did"><strong><?php _e( 'I already did', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
            <a href="<?php echo $no_thanks; ?>" class="later"><strong><?php _e( 'Nope&#44; maybe later', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
            <a href="<?php echo $dismiss; ?>" class="hide"><strong><?php _e( 'I don\'t want to rate', 'wp-last-modified-info' ); ?></strong></a></p>
        </div>
	<?php
	}
	
	/**
	 * Dismiss admin notices.
	 */
	public function dismiss_notice()
	{
		if ( get_option( 'wplmi_plugin_no_thanks_rating_notice' ) === '1' ) {
			if ( get_option( 'wplmi_plugin_dismissed_time' ) > strtotime( '-360 hours' ) ) {
				return;
			}
			delete_option( 'wplmi_plugin_dismiss_rating_notice' );
			delete_option( 'wplmi_plugin_no_thanks_rating_notice' );
		}
	
		if ( ! isset( $_REQUEST['wplmi_rating_notice_action'] ) ) {
			return;
		}
	
		if ( 'dismiss_true' === $_REQUEST['wplmi_rating_notice_action'] ) {
			check_admin_referer( 'dismiss_true' );
			update_option( 'wplmi_plugin_dismiss_rating_notice', '1' );
		}
	
		if ( 'no_thanks_true' === $_REQUEST['wplmi_rating_notice_action'] ) {
			check_admin_referer( 'no_thanks_true' );
			update_option( 'wplmi_plugin_no_thanks_rating_notice', '1' );
			update_option( 'wplmi_plugin_dismiss_rating_notice', '1' );
			update_option( 'wplmi_plugin_dismissed_time', time() );
		}
	
		wp_redirect( remove_query_arg( 'wplmi_rating_notice_action' ) );
		exit;
	}
	
	/**
	 * Calculate install time.
	 */
	private function calculate_time()
	{
		$installed_time = get_option( 'wplmi_plugin_installed_time' );
		
		if ( ! $installed_time ) {
            $installed_time = time();
            update_option( 'wplmi_plugin_installed_time', $installed_time );
		}
		
        return $installed_time;
	}
}