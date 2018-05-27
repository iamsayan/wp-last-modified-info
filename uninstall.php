<?php
/**
 * Runs on Uninstall of WP Last Modified Info
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */
// Check that we should be doing this
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit; // Exit if accessed directly
}

$plugin_option = 'lmt_plugin_global_settings';
delete_option( $plugin_option );