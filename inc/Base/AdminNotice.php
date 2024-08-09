<?php
/**
 * Admin notices.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Base
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Base;

use Wplmi\Helpers\Hooker;
use Wplmi\Base\BaseController;

defined( 'ABSPATH' ) || exit;

/**
 * Admin Notice class.
 */
class AdminNotice extends BaseController
{
	use Hooker;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( 'admin_notices', 'notice' );
		$this->action( 'admin_init', 'dismiss_notice' );
	}

	/**
	 * Show internal admin notices.
	 */
	public function notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Show a warning to sites running PHP < 5.6
		if ( version_compare( PHP_VERSION, '5.6', '<' ) ) {
			deactivate_plugins( $this->plugin );
			if ( isset( $_GET['activate'] ) ) { // phpcs:ignore
				unset( $_GET['activate'] ); // phpcs:ignore
			}
			echo '<div class="error"><p>' . esc_html__( 'Your version of PHP is below the minimum version of PHP required by WP Last Modified Info plugin. Please contact your host and request that your version be upgraded to 5.6 or later.', 'wp-last-modified-info' ) . '</p></div>';
			return;
		}

		// Check transient, if available display notice
		if ( get_transient( 'wplmi-show-notice-on-activation' ) !== false ) { ?>
			<div class="notice notice-success">
				<p><strong><?php
				/* translators: %s: 1. Plugin Name, 2. Version, 3. Link */
				printf( esc_html__( 'Thanks for installing %1$s v%2$s plugin. Click <a href="%3$s">here</a> to configure plugin settings.', 'wp-last-modified-info' ), 'WP Last Modified Info', esc_html( $this->version ), esc_url( admin_url( 'options-general.php?page=wp-last-modified-info' ) ) ); ?></strong></p>
			</div> <?php
			delete_transient( 'wplmi-show-notice-on-activation' );
		}

		$show_rating = true;
		if ( $this->calculate_time() > strtotime( '-10 days' )
	    	|| '1' === get_option( 'wplmi_plugin_dismiss_rating_notice' )
			|| apply_filters( 'wplmi/hide_sticky_rating_notice', false ) ) {
			$show_rating = false;
        }

		if ( $show_rating ) {
			$dismiss = wp_nonce_url( add_query_arg( 'wplmi_notice_action', 'dismiss_rating' ), 'wplmi_notice_nonce' );
			$no_thanks = wp_nonce_url( add_query_arg( 'wplmi_notice_action', 'no_thanks_rating' ), 'wplmi_notice_nonce' ); ?>

			<div class="notice notice-success">
				<p><?= wp_kses_post( 'Hey, I noticed you\'ve been using WP Last Modified Info for more than 1 week – that’s awesome! Could you please do me a BIG favor and give it a <strong>5-star</strong> rating on WordPress? Just to help us spread the word and boost my motivation.', 'wp-last-modified-info' ); ?></p>
            	<p><a href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?filter=5#new-post" target="_blank" class="button button-secondary" rel="noopener"><?php esc_html_e( 'Ok, you deserve it', 'wp-last-modified-info' ); ?></a>&nbsp;
				<a href="<?= esc_url( $dismiss ); ?>" class="already-did"><strong><?php esc_html_e( 'I already did', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
				<a href="<?= esc_url( $no_thanks ); ?>" class="later"><strong><?php esc_html_e( 'Nope&#44; maybe later', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
				<a href="<?= esc_url( $dismiss ); ?>" class="hide"><strong><?php esc_html_e( 'I don\'t want to rate', 'wp-last-modified-info' ); ?></strong></a></p>
			</div>
			<?php
		}

		$show_donate = true;
		if ( $this->calculate_time() > strtotime( '-240 hours' )
			|| '1' === get_option( 'wplmi_plugin_dismiss_donate_notice' )
			|| apply_filters( 'wplmi/hide_sticky_donate_notice', false ) ) {
			$show_donate = false;
		}

		if ( $show_donate ) {
			$dismiss = wp_nonce_url( add_query_arg( 'wplmi_notice_action', 'dismiss_donate' ), 'wplmi_notice_nonce' );
			$no_thanks = wp_nonce_url( add_query_arg( 'wplmi_notice_action', 'no_thanks_donate' ), 'wplmi_notice_nonce' ); ?>

			<div class="notice notice-success">
				<p><?= wp_kses_post( 'Hey, I noticed you\'ve been using WP Last Modified Info for more than 2 week – that’s awesome! If you like WP Last Modified Info and you are satisfied with the plugin, isn’t that worth a coffee or two? Please consider donating. Donations help me to continue support and development of this free plugin! Thank you very much!', 'wp-last-modified-info' ); ?></p>
				<p><a href="https://www.paypal.me/iamsayan" target="_blank" class="button button-secondary" rel="noopener"><?php esc_html_e( 'Donate Now', 'wp-last-modified-info' ); ?></a>&nbsp;
				<a href="<?= esc_url( $dismiss ); ?>" class="already-did"><strong><?php esc_html_e( 'I already donated', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
				<a href="<?= esc_url( $no_thanks ); ?>" class="later"><strong><?php esc_html_e( 'Nope&#44; maybe later', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
				<a href="<?= esc_url( $dismiss ); ?>" class="hide"><strong><?php esc_html_e( 'I don\'t want to donate', 'wp-last-modified-info' ); ?></strong></a></p>
			</div>
			<?php
		}
	}

	/**
	 * Dismiss admin notices.
	 */
	public function dismiss_notice() {
		// Check for Rating Notice
		if ( get_option( 'wplmi_plugin_no_thanks_rating_notice' ) === '1'
			&& get_option( 'wplmi_plugin_dismissed_time' ) <= strtotime( '-14 days' ) ) {
			delete_option( 'wplmi_plugin_dismiss_rating_notice' );
			delete_option( 'wplmi_plugin_no_thanks_rating_notice' );
		}

		// Check for Donate Notice
		if ( get_option( 'wplmi_plugin_no_thanks_donate_notice' ) === '1'
			&& get_option( 'wplmi_plugin_dismissed_time_donate' ) <= strtotime( '-15 days' ) ) {
			delete_option( 'wplmi_plugin_dismiss_donate_notice' );
			delete_option( 'wplmi_plugin_no_thanks_donate_notice' );
		}

		if ( empty( $_REQUEST['wplmi_notice_action'] ) ) {
			return;
		}

		check_admin_referer( 'wplmi_notice_nonce' );

		$notice = sanitize_text_field( $_REQUEST['wplmi_notice_action'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash
		$notice = explode( '_', $notice );
		$notice_type = end( $notice );
		array_pop( $notice );
		$notice_action = join( '_', $notice );

		if ( 'dismiss' === $notice_action ) {
			update_option( 'wplmi_plugin_dismiss_' . $notice_type . '_notice', '1', false );
		}

		if ( 'no_thanks' === $notice_action ) {
			update_option( 'wplmi_plugin_no_thanks_' . $notice_type . '_notice', '1', false );
			update_option( 'wplmi_plugin_dismiss_' . $notice_type . '_notice', '1', false );
			if ( 'donate' === $notice_type ) {
				update_option( 'wplmi_plugin_dismissed_time_donate', time(), false );
			} else {
				update_option( 'wplmi_plugin_dismissed_time', time(), false );
			}
		}

		wp_safe_redirect( remove_query_arg( [ 'wplmi_notice_action', '_wpnonce' ] ) );
		exit;
	}

	/**
	 * Calculate install time.
	 */
	private function calculate_time() {
		$installed_time = get_option( 'wplmi_plugin_installed_time' );

		if ( ! $installed_time ) {
            $installed_time = time();
            update_option( 'wplmi_plugin_installed_time', $installed_time, false );
		}

        return $installed_time;
	}
}
