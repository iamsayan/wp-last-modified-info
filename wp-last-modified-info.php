<?php
/*
Plugin Name: WP Last Modified Info
Plugin URI: https://iamsayan.github.io/wp-last-modified-info/
Description: Show or hide last update date and time on pages and posts very easily. You can use shortcode also to display last modified info anywhere.
Version: 1.2.6
Author: Sayan Datta
Author URI: https://profiles.wordpress.org/infosatech/
License: GPLv3
Text Domain: wp-last-modified-info
*/

/*  This plugin helps to add anything as WordPress Page Extention.

    Copyright 2018 Sayan Datta

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
	
*/

//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//add admin styles and scripts
function lmt_custom_admin_styles_scripts() {

    $current_screen = get_current_screen();

    if ( strpos($current_screen->base, 'wp-last-modified-info') !== false) {
        wp_enqueue_style( 'lmt-admin-style', plugins_url( 'css/admin-style.min.css', __FILE__ ) );
        wp_enqueue_style( 'lmt-cb-style', plugins_url( 'css/style.min.css', __FILE__ ) );    
        wp_enqueue_script( 'lmt-script', plugins_url( 'js/main.min.js', __FILE__ ) );
    }

}
add_action( 'admin_enqueue_scripts', 'lmt_custom_admin_styles_scripts' );

function lmt_ajax_save_admin_scripts() {
    if ( is_admin() ) { 
    // Embed the Script on our Plugin's Option Page Only
        if ( isset($_GET['page']) && $_GET['page'] == 'wp-last-modified-info' ) {
            wp_enqueue_script('jquery');
            wp_enqueue_script( 'jquery-form' );
        }
    }
}
add_action( 'admin_init', 'lmt_ajax_save_admin_scripts' );
// caling tools
include plugin_dir_path( __FILE__ ) . 'admin/tools.php';
include plugin_dir_path( __FILE__ ) . 'admin/settings-loader.php';
include plugin_dir_path( __FILE__ ) . 'admin/settings-fields.php';

// add settings page
add_action("admin_init", "lmt_plug_settings_page");

// add custom css
add_action ('wp_head','lmt_style_hook_inHeader', 10);
function lmt_style_hook_inHeader() {
    if( !empty( get_option('lmt_plugin_global_settings')['lmt_custom_style_box']) ) {
    echo '<style type="text/css" id="lmt-custom-css">' . get_option('lmt_plugin_global_settings')['lmt_custom_style_box'] . '</style>'."\n";
    }
}

function lmt_remove_footer_admin () {

    // fetch plugin version
    $lmtpluginfo = get_plugin_data(__FILE__);
    $lmtversion = $lmtpluginfo['Version'];    
        // pring plugin version
        echo 'Thanks for using <strong>WP Last Modified Info v'. $lmtversion .'</strong> | Developed with <span style="color:#e25555;">♥</span> by <a href="https://profiles.wordpress.org/infosatech/" target="_blank" style="font-weight: 500;">Sayan Datta</a> | <a href="https://github.com/iamsayan/wp-last-modified-info" target="_blank" style="font-weight: 500;">GitHub</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank" style="font-weight: 500;">Support</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/" target="_blank" style="font-weight: 500;">Rate it</a> (<span style="color:#ffa000;">&#9733;&#9733;&#9733;&#9733;&#9733;</span>), if you like this plugin.';
}

// page elements
function lmt_show_page() {

    include plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
    add_filter('admin_footer_text', 'lmt_remove_footer_admin');    
}

// add menu options
function lmt_menu_item_options() {
    add_submenu_page("options-general.php", "WP Last Modified Info", "Last Modified Info", "manage_options", "wp-last-modified-info", "lmt_show_page"); 
}

if(!is_network_admin()) {
    add_action('admin_menu', 'lmt_menu_item_options');
}

$options = get_option('lmt_plugin_global_settings');


// lmi output for posts
if( isset($options['lmt_enable_last_modified_cb']) && ($options['lmt_enable_last_modified_cb'] == 1) ) {
    include plugin_dir_path( __FILE__ ) . 'inc/class-post-options.php';
}

// enable lmi output for pages
if( isset($options['lmt_enable_last_modified_page_cb']) && ($options['lmt_enable_last_modified_page_cb'] == 1) ) {
    require plugin_dir_path( __FILE__ ) . 'inc/class-page-options.php';
}


// last modified info of posts column
if( isset($options['lmt_enable_on_dashboard_cb']) && ($options['lmt_enable_on_dashboard_cb'] == 1 ) ) {
    
    include plugin_dir_path( __FILE__ ) . 'inc/class-dashboard-post.php';
    include plugin_dir_path( __FILE__ ) . 'inc/class-dashboard-page.php';
    include plugin_dir_path( __FILE__ ) . 'inc/class-dashboard-last-login.php';
    include plugin_dir_path( __FILE__ ) . 'inc/class-dashboard-profile-modified.php';
    include plugin_dir_path( __FILE__ ) . 'inc/class-dashboard-widget.php';
    
    function lmt_show_on_dashboard () {
        
        $lmt_updated_time = get_the_modified_time('M j, Y @ H:i');
        if (get_the_modified_time('U') > get_the_time('U')) {
            echo '<div class="misc-pub-section curtime misc-pub-last-updated"><span id="lmt-timestamp"> Updated on: <b>' . $lmt_updated_time . '</b></span></div>';
        }
    }
    add_action( 'post_submitbox_misc_actions', 'lmt_show_on_dashboard');

    function lmt_print_admin_css() {
        echo '<style type="text/css">
                .fixed .column-modified {
                    width:18%;
                }
                .fixed .column-last-updated {
                    width:12%;
                }
                .fixed .column-last-login {
                    width:12%;
                }
                .curtime #lmt-timestamp:before {
                    content:"\f469";
                    font: 400 20px/1 dashicons;
                    speak: none;
                    display: inline-block;
                    margin-left: -1px;
                    padding-right: 3px;
                    vertical-align: top;
                    -webkit-font-smoothing: antialiased;
                    color: #82878c;
                }
              </style>'."\n";
    }
    add_action( 'admin_head', 'lmt_print_admin_css' );
}

// showw on admin bar
if( isset($options['lmt_enable_on_admin_bar_cb']) && ($options['lmt_enable_on_admin_bar_cb'] == 1) ) {
    require plugin_dir_path( __FILE__ ) . 'inc/class-admin-bar.php';
}


// enable template tags functionality
if( isset($options['lmt_tt_enable_cb']) && ($options['lmt_tt_enable_cb'] == 1) ) {
    require plugin_dir_path( __FILE__ ) . 'inc/class-template-tags.php';
}

// enable template tags functionality
if( isset($options['lmt_enable_custom_field_cb']) && ($options['lmt_enable_custom_field_cb'] == 1) ) {
    
    add_action('save_post', 'lmt_add_custom_field_lmi');
    
    function lmt_add_custom_field_lmi( $post_id ) {

        $m_orig	= get_post_field( 'post_modified', $post_id, 'raw' );
        $m_stamp = strtotime( $m_orig );
        //$modified = date(get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' ), $m_stamp );
        if( !empty( get_option('lmt_plugin_global_settings')['lmt_custom_field_format']) ) {
            $modified = date(get_option('lmt_plugin_global_settings')['lmt_custom_field_format'], $m_stamp );
        } else {
            $modified = date(get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' ), $m_stamp );
        }

        if ( ! add_post_meta( $post_id, 'last_modified_info', $modified, true ) ) {
            update_post_meta( $post_id, 'last_modified_info', $modified );
        }
    }
}

// add action links
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'lmt_add_action_links', 10, 2 );

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
            array( '<a href="https://github.com/iamsayan/wp-last-modified-info" target="_blank">' . __('GitHub') . '</a>' ),
            array( '<a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank">' . __('Support') . '</a>' ),
            array( '<a href="https://www.paypal.me/iamsayan" target="_blank">' . __('Donate') . '</a>' )
            
		);
	return $links;
}

add_filter( 'plugin_row_meta', 'lmt_plugin_meta_links', 10, 2 );

?>