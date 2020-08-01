<?php
/**
 * Localization loader.
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
 * Localizationclass.
 */
class Localization extends BaseController
{
	use Hooker;

	/**
	 * Register functions.
	 */
	public function register() 
	{
		$this->action( 'plugins_loaded', 'load_textdomain' );
	}

	/**
	 * Load textdomain.
	 */
	public function load_textdomain()
	{
		load_plugin_textdomain( 'wp-last-modified-info', false, dirname( $this->plugin ) . '/languages/' ); 
	}
}