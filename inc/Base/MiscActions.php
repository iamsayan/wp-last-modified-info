<?php
/**
 * Action links.
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
 * Action links class.
 */
class MiscActions extends BaseController
{
	use Hooker;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( "plugin_action_links_$this->plugin", 'settings_link', 10, 1 );
		$this->action( 'plugin_row_meta', 'meta_links', 10, 2 );
	}

	/**
	 * Register settings link.
	 */
	public function settings_link( $links ) {
		$wplmilinks = [
			'<a href="' . admin_url( 'options-general.php?page=wp-last-modified-info' ) . '">' . __( 'Settings', 'wp-last-modified-info' ) . '</a>',
		];
		
		return array_merge( $wplmilinks, $links );
	}

	/**
	 * Register meta links.
	 */
	public function meta_links( $links, $file ) {
		if ( $file === $this->plugin ) { // only for this plugin
			$links[] = '<a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank">' . __( 'Support', 'wp-last-modified-info' ) . '</a>';
			$links[] = '<a href="https://www.paypal.me/iamsayan/" target="_blank">' . __( 'Donate', 'wp-last-modified-info' ) . '</a>';
		}

		return $links;
	}
}