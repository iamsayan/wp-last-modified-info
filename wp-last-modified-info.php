<?php
/**
 * Plugin Name: WP Last Modified Info
 * Plugin URI: https://iamsayan.github.io/wp-last-modified-info/
 * Description: 🔥 Ultimate Last Modified Solution for WordPress. Adds last modified date and time automatically on pages and posts very easily. It is possible to use shortcodes to display last modified info anywhere on a WordPress site running 4.0 and beyond.
 * Version: 1.6.6
 * Author: Sayan Datta
 * Author URI: https://about.me/iamsayan
 * License: GPLv3
 * Text Domain: wp-last-modified-info
 * Domain Path: /languages
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
 * @author   Sayan Datta <iamsayan@pm.me>
 * @license  http://www.gnu.org/licenses/ GNU General Public License
 * @link     https://iamsayan.github.io/wp-last-modified-info/
 */

//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LMT_PLUGIN_VERSION', '1.6.6' );

// debug scripts
//define( 'LMT_PLUGIN_ENABLE_DEBUG', 'true' );

// Internationalization
add_action( 'plugins_loaded', 'lmt_plugin_load_textdomain' );
/**
 * Load plugin textdomain.
 * 
 * @since 1.2.11
 */
function lmt_plugin_load_textdomain() {
    load_plugin_textdomain( 'wp-last-modified-info', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}

// register activation hook
register_activation_hook( __FILE__, 'lmt_plugin_run_on_activation' );

function lmt_plugin_run_on_activation() {
    if ( ! current_user_can( 'activate_plugins' ) ) {
        return;
    }
    set_transient( 'lmt-admin-notice-on-activation', true );
}

// register deactivation hook
register_deactivation_hook( __FILE__, 'lmt_plugin_run_on_deactivation' );

function lmt_plugin_run_on_deactivation() {
    if ( ! current_user_can( 'activate_plugins' ) ) {
        return;
    }
    delete_option( 'lmt_plugin_dismiss_rating_notice' );
    delete_option( 'lmt_plugin_no_thanks_rating_notice' );
    delete_option( 'lmt_plugin_installed_time' );
    delete_option( 'lmt_plugin_installed_time_donate' );
}

add_action( 'admin_enqueue_scripts', 'lmt_custom_admin_styles_scripts' );

//add admin styles and scripts
function lmt_custom_admin_styles_scripts() {
    $ver = LMT_PLUGIN_VERSION;
    if( defined( 'LMT_PLUGIN_ENABLE_DEBUG' ) ) {
        $ver = time();
    }
    // get current screen
    $current_screen = get_current_screen();
    if ( strpos($current_screen->base, 'wp-last-modified-info') !== false ) {
        wp_enqueue_style( 'lmt-admin', plugins_url( 'admin/assets/css/admin.min.css', __FILE__ ), array(), $ver );
        wp_enqueue_script( 'lmt-admin-script', plugins_url( 'admin/assets/js/admin.min.js', __FILE__ ), array(), $ver );

        wp_enqueue_style( 'lmt-selectize', plugins_url( 'admin/assets/lib/selectize/css/selectize.min.css', __FILE__ ), array(), '0.12.6' ); 
        wp_enqueue_script( 'lmt-selectize-js', plugins_url( 'admin/assets/lib/selectize/js/selectize.min.js', __FILE__ ), array(), '0.12.6' );
    }
}

add_action( 'admin_enqueue_scripts', 'lmt_shortcode_admin_styles_scripts' );

function lmt_shortcode_admin_styles_scripts( $hook ) {
    global $wp_version;

    $ver = LMT_PLUGIN_VERSION;
    if( defined( 'LMT_PLUGIN_ENABLE_DEBUG' ) ) {
        $ver = time();
    }

    // check if post edit screen
    if( $hook == 'post-new.php' || $hook == 'post.php' ) {
        wp_enqueue_style( 'lmt-post', plugins_url( 'admin/assets/css/post.min.css', __FILE__ ), array(), $ver );
        if( version_compare( $wp_version,'5.3' ) >= 0 ) {
            wp_enqueue_style( 'lmt-post-edit-v2', plugins_url( 'admin/assets/css/edit-v2.min.css', __FILE__ ), array(), $ver );
        } else {
            wp_enqueue_style( 'lmt-post-edit-v1', plugins_url( 'admin/assets/css/edit-v1.min.css', __FILE__ ), array(), $ver );
        }
    }

    if( $hook == 'edit.php' ) {
        if( version_compare( $wp_version,'5.3' ) >= 0 ) {
            wp_enqueue_style( 'lmt-post-edit-v2', plugins_url( 'admin/assets/css/edit-v2.min.css', __FILE__ ), array(), $ver );
        } else {
            wp_enqueue_style( 'lmt-post-edit-v1', plugins_url( 'admin/assets/css/edit-v1.min.css', __FILE__ ), array(), $ver );
        }
        wp_enqueue_script( 'lmt-post-edit', plugins_url( 'admin/assets/js/edit.min.js', __FILE__ ), array( 'jquery' ), $ver, true );
    }
}

add_action( 'admin_init', 'lmt_ajax_save_admin_scripts' );

function lmt_ajax_save_admin_scripts() {
    if( is_admin() ) { 
        // Embed the Script on our Plugin's Option Page Only
        if ( isset($_GET['page']) && $_GET['page'] == 'wp-last-modified-info' ) {
            wp_enqueue_script('jquery');
            wp_enqueue_script( 'jquery-form' );
        }
    }
}

add_action( 'admin_notices', 'lmt_new_plugin_install_notice' );

function lmt_new_plugin_install_notice() { 
    // Show a warning to sites running PHP < 5.6
    if( version_compare( PHP_VERSION, '5.6', '<' ) ) {
	    echo '<div class="error"><p>' . __( 'Your version of PHP is below the minimum version of PHP required by WP Last Modified Info plugin. Please contact your host and request that your version be upgraded to 5.6 or later.', 'wp-last-modified-info' ) . '</p></div>';
    }

    // Check transient, if available display notice
    if( get_transient( 'lmt-admin-notice-on-activation' ) ) { ?>
        <div class="notice notice-success">
            <p><strong><?php printf( __( 'Thanks for installing %1$s v%2$s plugin. Click <a href="%3$s">here</a> to configure plugin settings.', 'wp-last-modified-info' ), 'WP Last Modified Info', LMT_PLUGIN_VERSION, admin_url( 'options-general.php?page=wp-last-modified-info' ) ); ?></strong></p>
        </div> <?php
        delete_transient( 'lmt-admin-notice-on-activation' );
    }
}

/**
 * File that contains main plugin data.
 */
require_once plugin_dir_path( __FILE__ ) . 'admin/loader.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/notice.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/donate.php';

require_once plugin_dir_path( __FILE__ ) . 'includes/trigger.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/rest-api.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/replace.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcode.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/schema-remove.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/theme-support.php';

// plugin action links
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'lmt_add_action_links', 10, 2 );

// add action links
function lmt_add_action_links( $links ) {
    $lmtlinks = array(
        '<a href="' . admin_url( 'options-general.php?page=wp-last-modified-info' ) . '">' . __( 'Settings', 'wp-last-modified-info' ) . '</a>',
    );
    return array_merge( $lmtlinks, $links );
}

// plugin row elements
add_filter( 'plugin_row_meta', 'lmt_plugin_meta_links', 10, 2 );

function lmt_plugin_meta_links( $links, $file ) {
	$plugin = plugin_basename(__FILE__);
	if ( $file == $plugin ) // only for this plugin
		return array_merge( $links, 
            array( '<a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank">' . __( 'Support', 'wp-last-modified-info' ) . '</a>' ),
            array( '<a href="https://www.paypal.me/iamsayan/" target="_blank">' . __( 'Donate', 'wp-last-modified-info' ) . '</a>' )
		);
	return $links;
}

?>