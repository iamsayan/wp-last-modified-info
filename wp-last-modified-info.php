<?php
/**
 * Plugin Name: WP Last Modified Info
 * Plugin URI: https://iamsayan.github.io/wp-last-modified-info/
 * Description: Show or hide last update date and time on pages and posts very easily. You can use shortcode also to display last modified info anywhere.
 * Version: 1.2.11
 * Author: Sayan Datta
 * Author URI: https://profiles.wordpress.org/infosatech/
 * License: GPLv3
 * Text Domain: wp-lmi
 * 
 * WP Last Modified Info is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
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
 * @author   Sayan Datta
 * @license  http://www.gnu.org/licenses/ GNU General Public License
 * @link     https://iamsayan.github.io/wp-last-modified-info/
 */

//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// todo
//add_action( 'plugins_loaded', 'lmt_plugin_load_textdomain' );
/**
 * Load plugin textdomain.
 * 
 * @since 1.2.11
 */
/*function lmt_plugin_load_textdomain() {
    load_plugin_textdomain( 'wp-lmi', false, plugin_dir_path( __FILE__ ) . '/languages' ); 
}*/

//add admin styles and scripts
function lmt_custom_admin_styles_scripts() {

    // get current screen
    $current_screen = get_current_screen();
    if ( strpos($current_screen->base, 'wp-last-modified-info') !== false ) {
        wp_enqueue_style( 'lmt-admin', plugins_url( 'admin/assets/css/admin-style.min.css', __FILE__ ) );
        wp_enqueue_style( 'lmt-cb', plugins_url( 'admin/assets/css/style.min.css', __FILE__ ) );
        wp_enqueue_script( 'lmt-admin-script', plugins_url( 'admin/assets/js/admin.min.js', __FILE__ ) );

        wp_enqueue_style( 'lmt-select2', plugins_url( 'admin/assets/lib/select2/css/select2.min.css', __FILE__ ) ); 
        wp_enqueue_script( 'lmt-select2-script', plugins_url( 'admin/assets/lib/select2/js/select2.min.js', __FILE__ ) );
    }
}

function lmt_shortcode_admin_styles_scripts( $hook ) {

    global $post;
    // check if post edit screen
    if ( $hook == 'post-new.php' || $hook == 'post.php' ) { 
        wp_enqueue_style( 'lmt-shortcode', plugins_url( 'admin/assets/css/shortcode.min.css', __FILE__ ) );    
        wp_enqueue_script( 'lmt-shortcode-script', plugins_url( 'admin/assets/js/shortcode.min.js', __FILE__ ) );
    }
}

function lmt_ajax_save_admin_scripts() {
    if ( is_admin() ) { 
        // Embed the Script on our Plugin's Option Page Only
        if ( isset($_GET['page']) && $_GET['page'] == 'wp-last-modified-info' ) {
            wp_enqueue_script('jquery');
            wp_enqueue_script( 'jquery-form' );
        }
    }
}

add_action( 'admin_enqueue_scripts', 'lmt_custom_admin_styles_scripts' );
add_action( 'admin_enqueue_scripts', 'lmt_shortcode_admin_styles_scripts' );
add_action( 'admin_init', 'lmt_ajax_save_admin_scripts' );


/**
 * File that triggers main plugin data.
 */
require_once plugin_dir_path( __FILE__ ) . 'admin/loader.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/trigger.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcode.php';

function lmt_remove_footer_admin() {

    // fetch plugin version
    $lmtpluginfo = get_plugin_data(__FILE__);
    $lmtversion = $lmtpluginfo['Version'];    
	return $lmtversion;
}

// add action links
function lmt_add_action_links ( $links ) {
    $lmtlinks = array(
        '<a href="' . admin_url( 'options-general.php?page=wp-last-modified-info' ) . '">Settings</a>',
    );
    return array_merge( $lmtlinks, $links );
}

function lmt_plugin_meta_links($links, $file) {
	$plugin = plugin_basename(__FILE__);
	if ($file == $plugin) // only for this plugin
		return array_merge( $links, 
            array( '<a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank">' . __('Support') . '</a>' ),
            array( '<a href="http://bit.ly/2I0Gj60" target="_blank">' . __('Donate') . '</a>' )
		);
	return $links;
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'lmt_add_action_links', 10, 2 );
add_filter( 'plugin_row_meta', 'lmt_plugin_meta_links', 10, 2 );


?>