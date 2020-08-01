<?php
/**
 * Deactivation.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Base
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Base;

/**
 * Deactivation class.
 */
class Deactivate
{
	/**
	 * Run plugin deactivation process.
	 */
	public static function deactivate() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		delete_option( 'wplmi_plugin_dismiss_rating_notice' );
        delete_option( 'wplmi_plugin_no_thanks_rating_notice' );
        delete_option( 'wplmi_plugin_installed_time' );
        delete_option( 'wplmi_plugin_installed_time_donate' );
	}
}