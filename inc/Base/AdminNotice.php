<?php 
/**
 * Admin notices.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Base
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Base;

use WP_Dismiss_Notice;
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
	 * Notice.
	 */
	private $notice;
	
	/**
	 * Register functions.
	 */
	public function register() {
		$this->notice = new WP_Dismiss_Notice();

		$this->action( 'admin_notices', 'notice' );
		$this->action( 'admin_footer', 'dismiss_action', 99 );
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
			echo '<div class="error"><p>' . __( 'Your version of PHP is below the minimum version of PHP required by WP Last Modified Info plugin. Please contact your host and request that your version be upgraded to 5.6 or later.', 'wp-last-modified-info' ) . '</p></div>';
			return;
		}
	
		// Check transient, if available display notice
		if ( get_transient( 'wplmi-show-notice-on-activation' ) !== false ) { ?>
			<div class="notice notice-success">
				<p><strong><?php 
				/* translators: %s: 1. Plugin Name, 2. Version, 3. Link */
				printf( __( 'Thanks for installing %1$s v%2$s plugin. Click <a href="%3$s">here</a> to configure plugin settings.', 'wp-last-modified-info' ), 'WP Last Modified Info', $this->version, admin_url( 'options-general.php?page=wp-last-modified-info' ) ); ?></strong></p>
			</div> <?php
			delete_transient( 'wplmi-show-notice-on-activation' );
		}

		if ( $this->notice::is_admin_notice_active( 'wplmi-rating-notice-forever' ) ) { ?>
			<div class="notice notice-success is-dismissible wplmi-notice" data-dismissible="wplmi-rating-notice-forever">
				<p><?php echo wp_kses_post( 'Hey, I noticed you\'ve been using WP Last Modified Info for more than 1 week – that’s awesome! Could you please do me a BIG favor and give it a <strong>5-star</strong> rating on WordPress? Just to help us spread the word and boost my motivation.', 'wp-last-modified-info' ); ?></p>
            	<p>
					<a href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?filter=5#new-post" target="_blank" rel="noopener" class="button button-secondary"><?php esc_html_e( 'Ok, you deserve it', 'wp-last-modified-info' ); ?></a>&nbsp;
					<a href="#" data-dismissible="wplmi-rating-notice-forever"><strong><?php esc_html_e( 'I already did', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
					<a href="#" data-dismissible="wplmi-rating-notice-10"><strong><?php esc_html_e( 'Nope&#44; maybe later', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
					<a href="#" data-dismissible="wplmi-rating-notice-forever"><strong><?php esc_html_e( 'I don\'t want to rate', 'wp-last-modified-info' ); ?></strong></a>
				</p>
			</div>
			<?php
		}

		if ( $this->notice::is_admin_notice_active( 'wplmi-donate-notice-forever' ) ) { ?>
			<div class="notice notice-success is-dismissible wplmi-notice" data-dismissible="wplmi-donate-notice-forever">
				<p><?php echo wp_kses_post( 'Hey, I noticed you\'ve been using WP Last Modified Info for more than 2 week – that’s awesome! If you like WP Last Modified Info and you are satisfied with the plugin, isn’t that worth a coffee or two? Please consider donating. Donations help me to continue support and development of this free plugin! Thank you very much!', 'wp-last-modified-info' ); ?></p>
				<p>
					<a href="https://www.paypal.me/iamsayan" target="_blank" rel="noopener" class="button button-secondary"><?php esc_html_e( 'Donate Now', 'wp-last-modified-info' ); ?></a>&nbsp;
					<a href="#" data-dismissible="wplmi-donate-notice-forever"><strong><?php esc_html_e( 'I already donated', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
					<a href="#" data-dismissible="wplmi-donate-notice-7"><strong><?php esc_html_e( 'Nope&#44; maybe later', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
					<a href="#" data-dismissible="wplmi-donate-notice-forever"><strong><?php esc_html_e( 'I don\'t want to donate', 'wp-last-modified-info' ); ?></strong></a>
				</p>
			</div>
			<?php
		}
	}

	/**
	 * Load JS.
	 */
	public function dismiss_action() { ?>
		<script type="text/javascript">
			jQuery( document ).ready( function( $ ) {
				$( '.wplmi-notice a:not(.button)' ).on( 'click', function( e ) {
					e.preventDefault();
					$( '.wplmi-notice' ).attr( 'data-dismissible', $( this ).data( 'dismissible' ) );
					$( '.wplmi-notice button.notice-dismiss' ).trigger( 'click' );
				} )
			} );
		</script>
		<?php
	}
}