<?php
/**
 * Plugin Name: Easy Header Footer
 * Plugin URI: https://wordpress.org/plugins/remove-wp-meta-tags/
 * Description: It is a very lightweight plugin for customize wordpress header, add custom code and enable, disable or remove the unwanted meta tags and links from the source code.
 * Version: 3.1.3
 * Author: Sayan Datta
 * Author URI: https://profiles.wordpress.org/infosatech/
 * License: GPLv3
 * Text Domain: remove-wp-meta-tags
 * Domain Path: /languages
 * 
 * Easy Header Footer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Easy Header Footer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Easy Header Footer. If not, see <http://www.gnu.org/licenses/>.
 *
 * @category Core
 * @package  Easy Header Footer
 * @author   Sayan Datta
 * @license  http://www.gnu.org/licenses/ GNU General Public License
 * @link     https://wordpress.org/plugins/remove-wp-meta-tags/
 */


//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Internationalization
add_action( 'plugins_loaded', 'rm_plugin_load_textdomain' );
/**
 * Load plugin textdomain.
 * 
 * @since 3.1.1
 */
function rm_plugin_load_textdomain() {
    load_plugin_textdomain( 'remove-wp-meta-tags', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}

//define( 'RM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

function rm_print_plugin_version() {
    // fetch plugin version
    $rmpluginfo = get_plugin_data(__FILE__);
    $rmversion = $rmpluginfo['Version'];
    return $rmversion;
}

// load admin styles
function rm_custom_admin_styles_scripts() {

    $current_screen = get_current_screen();

    if ( strpos( $current_screen->base, 'easy-header-footer') !== false ) {
        wp_enqueue_style( 'rm-admin', plugins_url( 'admin/assets/css/admin.min.css', __FILE__ ), array(), rm_print_plugin_version() );
        wp_enqueue_style( 'rm-style', plugins_url( 'admin/assets/css/style.min.css', __FILE__ ), array(), rm_print_plugin_version() );
        wp_enqueue_script( 'rm-admin-script', plugins_url( 'admin/assets/js/admin.min.js', __FILE__ ), array(), rm_print_plugin_version() );
    }
}

add_action( 'admin_enqueue_scripts', 'rm_custom_admin_styles_scripts' );

function rm_ajax_save_admin_scripts() {
    if ( is_admin() ) { 
    // Embed the Script on our Plugin's Option Page Only
        if ( isset($_GET['page']) && $_GET['page'] == 'easy-header-footer' ) {
            wp_enqueue_script('jquery');
            wp_enqueue_script( 'jquery-form' );
        }
    }
}
add_action( 'admin_init', 'rm_ajax_save_admin_scripts' );

require_once plugin_dir_path( __FILE__ ) . 'admin/settings-loader.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/settings-fields.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/meta-box.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/tools.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/notice.php';

// add settings page
add_action('admin_init', 'rm_plug_settings_page');

// page elements
function rw_show_page() {
    require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
    add_filter('admin_footer_text', 'rm_remove_footer_admin');
}

// add menu options
function rm_menu_item() {
    add_submenu_page('options-general.php', __( 'Easy Header Footer', 'remove-wp-meta-tags' ), __( 'Easy Header Footer', 'remove-wp-meta-tags' ), 'manage_options', 'easy-header-footer', 'rw_show_page'); 
}
add_action('admin_menu', 'rm_menu_item');

$options = get_option('rm_plugin_global_settings');

require_once plugin_dir_path( __FILE__ ) . 'includes/meta-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/disable-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/security-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/privacy-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/header-footer.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/minify-settings.php';

function rm_remove_footer_admin() {
    // pring plugin version
    echo 'Thanks for using <strong>Easy Header Footer v' . rm_print_plugin_version() . '</strong> | Developed with <span style="color: #e25555;">♥</span> by <a href="https://profiles.wordpress.org/infosatech/" target="_blank" style="font-weight: 500;">Sayan Datta</a> | <a href="https://github.com/iamsayan/remove-wp-meta-tags" target="_blank" style="font-weight: 500;">GitHub</a> | <a href="https://wordpress.org/support/plugin/remove-wp-meta-tags" target="_blank" style="font-weight: 500;">Support</a> | <a href="https://wordpress.org/support/plugin/remove-wp-meta-tags/reviews/?rate=5#new-post" target="_blank" style="font-weight: 500;">Rate it</a> (<span style="color:#ffa000;">&#9733;&#9733;&#9733;&#9733;&#9733;</span>) on WordPress.org, if you like this plugin.';
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'rm_add_action_links', 10, 2 );

function rm_add_action_links( $links ) {
    $rmlinks = array(
        '<a href="' . admin_url( 'options-general.php?page=easy-header-footer' ) . '">' . __( 'Settings', 'remove-wp-meta-tags' ) . '</a>',
    );
    return array_merge( $rmlinks, $links );
}

function rm_plugin_meta_links( $links, $file ) {
	$plugin = plugin_basename(__FILE__);
	if ($file == $plugin) // only for this plugin
		return array_merge( $links, 
            array( '<a href="https://wordpress.org/support/plugin/remove-wp-meta-tags" target="_blank">' . __( 'Support', 'remove-wp-meta-tags'  ) . '</a>' ),
            array( '<a href="http://bit.ly/2I0Gj60" target="_blank">' . __( 'Donate', 'remove-wp-meta-tags' ) . '</a>' )
		);
	return $links;
}

// plugin row elements
add_filter( 'plugin_row_meta', 'rm_plugin_meta_links', 10, 2 );


?>