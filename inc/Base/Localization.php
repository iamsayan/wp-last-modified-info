<?php
/**
 * Localization loader.
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
 * Localizationclass.
 */
class Localization extends BaseController
{
	use Hooker;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( 'init', 'load_textdomain' );
	}

	/**
	 * Load textdomain.
	 */
	public function load_textdomain() {
		$locale = get_user_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'wp-last-modified-info' );

		unload_textdomain( 'wp-last-modified-info' );
		if ( false === load_textdomain( 'wp-last-modified-info', WP_LANG_DIR . '/plugins/wp-last-modified-info-' . $locale . '.mo' ) ) {
			load_textdomain( 'wp-last-modified-info', WP_LANG_DIR . '/wp-last-modified-info/wp-last-modified-info-' . $locale . '.mo' );
		}
		load_plugin_textdomain( 'wp-last-modified-info', false, dirname( $this->plugin ) . '/languages/' ); 
	}
}