<?php 
/**
 * Donation notice.
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
 * Donation Notice class.
 */
class DonateNotice
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
			|| '1' === get_option( 'wplmi_plugin_dismiss_donate_notice' )
			|| ! current_user_can( 'manage_options' )
			|| apply_filters( 'wplmi/hide_sticky_donate_notice', false ) ) {
			return;
		}
	
		$dismiss = wp_nonce_url( add_query_arg( 'wplmi_donate_notice_action', 'dismiss_donate_true' ), 'wplmi_dismiss_donate_true' ); 
		$no_thanks = wp_nonce_url( add_query_arg( 'wplmi_donate_notice_action', 'no_thanks_donate_true' ), 'wplmi_no_thanks_donate_true' ); ?>
		
		<div class="notice notice-success">
			<p><?php _e( 'Hey, I noticed you\'ve been using WP Last Modified Info for more than 2 week – that’s awesome! If you like WP Last Modified Info and you are satisfied with the plugin, isn’t that worth a coffee or two? Please consider donating. Donations help me to continue support and development of this free plugin! Thank you very much!', 'wp-last-modified-info' ); ?></p>
			<p><a href="https://www.paypal.me/iamsayan" target="_blank" class="button button-secondary"><?php _e( 'Donate Now', 'wp-last-modified-info' ); ?></a>&nbsp;
			<a href="<?php echo $dismiss; ?>" class="already-did"><strong><?php _e( 'I already donated', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
			<a href="<?php echo $no_thanks; ?>" class="later"><strong><?php _e( 'Nope&#44; maybe later', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
			<a href="<?php echo $dismiss; ?>" class="hide"><strong><?php _e( 'I don\'t want to donate', 'wp-last-modified-info' ); ?></strong></a></p>
		</div>
	<?php
	}
	
	/**
	 * Dismiss admin notices.
	 */
	public function dismiss_notice()
	{
		if( get_option( 'wplmi_plugin_no_thanks_donate_notice' ) === '1' ) {
			if ( get_option( 'wplmi_plugin_dismissed_time_donate' ) > strtotime( '-360 hours' ) ) {
				return;
			}
			delete_option( 'wplmi_plugin_dismiss_donate_notice' );
			delete_option( 'wplmi_plugin_no_thanks_donate_notice' );
		}
	
		if ( ! isset( $_REQUEST['wplmi_donate_notice_action'] ) ) {
			return;
		}
	
		if ( 'dismiss_donate_true' === $_REQUEST['wplmi_donate_notice_action'] ) {
			check_admin_referer( 'wplmi_dismiss_donate_true' );
			update_option( 'wplmi_plugin_dismiss_donate_notice', '1' );
		}
	
		if ( 'no_thanks_donate_true' === $_REQUEST['wplmi_donate_notice_action'] ) {
			check_admin_referer( 'wplmi_no_thanks_donate_true' );
			update_option( 'wplmi_plugin_no_thanks_donate_notice', '1' );
			update_option( 'wplmi_plugin_dismiss_donate_notice', '1' );
			update_option( 'wplmi_plugin_dismissed_time_donate', time() );
		}
	
		wp_redirect( remove_query_arg( 'wplmi_donate_notice_action' ) );
		exit;
	}
	
	/**
	 * Calculate install time.
	 */
	private function calculate_time()
	{
		$installed_time = get_option( 'wplmi_plugin_installed_time_donate' );
		
		if ( ! $installed_time ) {
			$installed_time = time();
			update_option( 'wplmi_plugin_installed_time_donate', $installed_time );
		}
		
		return $installed_time;
	}
}