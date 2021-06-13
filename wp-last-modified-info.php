<?php
/**
 * Plugin Name: WP Last Modified Info
 * Plugin URI: https://wordpress.org/plugins/wp-last-modified-info/
 * Description: 🔥 Ultimate Last Modified Solution for WordPress. Adds last modified date and time automatically on pages and posts very easily. It is possible to use shortcodes to display last modified info anywhere on a WordPress site running 4.7 and beyond.
 * Version: 1.7.7
 * Author: Sayan Datta
 * Author URI: https://sayandatta.in
 * License: GPLv3
 * Text Domain: wp-last-modified-info
 * Domain Path: /languages
 * 
 * WP Last Modified Info is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * WP Last Modified Info is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WP Last Modified Info. If not, see <http://www.gnu.org/licenses/>.
 * 
 * @category Core
 * @package  WP Last Modified Info
 * @author   Sayan Datta <hello@sayandatta.in>
 * @license  http://www.gnu.org/licenses/ GNU General Public License
 * @link     https://wordpress.org/plugins/wp-last-modified-info/
 * 
 */

// If this file is called firectly, abort!!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function wplmi_plugin_activation() {
	Wplmi\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'wplmi_plugin_activation' );

/**
 * The code that runs during plugin deactivation
 */
function wplmi_plugin_deactivation() {
	Wplmi\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'wplmi_plugin_deactivation' );

/**
 * The code that runs during plugin uninstalltion
 */
function wplmi_plugin_uninstallation() {
	Wplmi\Base\Uninstall::uninstall();
}
register_uninstall_hook( __FILE__, 'wplmi_plugin_uninstallation' );

/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'Wplmi\WPLMILoader' ) ) {
	Wplmi\WPLMILoader::register_services();
}

/**
 * The code that returns the template tag output
 */
if ( ! function_exists( 'get_the_last_modified_info' ) ) {
    function get_the_last_modified_info( $escape = false, $date = false ) {
	    $html = apply_filters( 'wplmi/template_tags_output', '', $escape, $date );
	    return $html;
    }
}

/**
 * The code that prints the template tag output
 */
if ( ! function_exists( 'the_last_modified_info' ) ) {
    function the_last_modified_info( $escape = false, $date = false ) {
        //displays/echos the last modified info.
        echo get_the_last_modified_info( $escape, $date );
    }
}