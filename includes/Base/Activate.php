<?php
/**
 * Activation.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Base
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Base;

/**
 * Activation class.
 */
class Activate
{
	/**
	 * Run plugin activation process.
	 */
	public static function activate() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		
		set_transient( 'wplmi-show-notice-on-activation', true );
	}
}