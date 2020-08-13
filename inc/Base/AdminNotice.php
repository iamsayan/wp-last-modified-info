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
	public function register()
	{
		$this->action( 'admin_notices', 'install_notice' );
	}
	
	/**
	 * Show internal admin notices.
	 */
	public function install_notice()
	{
		// Show a warning to sites running PHP < 5.6
		if ( version_compare( PHP_VERSION, '5.6', '<' ) ) {
			deactivate_plugins( $this->plugin );
			echo '<div class="error"><p>' . __( 'Your version of PHP is below the minimum version of PHP required by WP Last Modified Info plugin. Please contact your host and request that your version be upgraded to 5.6 or later.', 'wp-last-modified-info' ) . '</p></div>';
		}
	
		// Check transient, if available display notice
		if ( get_transient( 'wplmi-show-notice-on-activation' ) !== false ) { 
			if ( version_compare( PHP_VERSION, '5.6', '>=' ) ) { ?>
			    <div class="notice notice-success">
				    <p><strong><?php printf( __( 'Thanks for installing %1$s v%2$s plugin. Click <a href="%3$s">here</a> to configure plugin settings.', 'wp-last-modified-info' ), 'WP Last Modified Info', $this->version, admin_url( 'options-general.php?page=wp-last-modified-info' ) ); ?></strong></p>
			    </div> <?php
			}
			delete_transient( 'wplmi-show-notice-on-activation' );
		}
	}
}