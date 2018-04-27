<?php
/*
Plugin Name: WP Last Modified Info
Plugin URI: https://wordpress.org/plugins/wp-last-modified-info/
Description: Show or hide last update date and time on pages and posts very easily. You can use shortcode also to dispaly last modified info anywhere.
Version: 1.0.6
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

    if ( strpos($current_screen->base, 'wp-last-modified-info') === false) {
        return;
    } else {
    wp_enqueue_style( 'lmt-admin-style', plugins_url( 'css/admin-style.css', __FILE__ ) );
    wp_enqueue_style( 'lmt-cb-style', plugins_url( 'css/style.css', __FILE__ ) );
    wp_enqueue_script( 'lmt-script', plugins_url( 'js/main.js', __FILE__ ) );
    }
}

add_action( 'admin_enqueue_scripts', 'lmt_custom_admin_styles_scripts' );

// add footer text promo
function lmt_remove_footer_admin () {
    
    $lmtpluginfo = get_plugin_data(__FILE__);
    $lmtversion=$lmtpluginfo['Version'];

    $current_screen = get_current_screen();
    if ( strpos($current_screen->base, 'wp-last-modified-info') === false) {
        echo '<span id="footer-thankyou">Thank you for creating with <a href="//wordpress.org" target="_blank"> WordPress</a>.</span>';
    } else {
    echo 'Thanks for using <strong>WP Last Modified Info v' . $lmtversion . '</strong> | Developed with <span style="color: #e25555;">♥</span> by <a href="https://profiles.wordpress.org/infosatech/" target="_blank" style="font-weight: 500;">Sayan Datta</a> | <a href="https://github.com/iamsayan/wp-last-modified-info" target="_blank" style="font-weight: 500;">GitHub</a> | <a href="https://wordpress.org/plugins/wp-last-modified-info/#reviews" target="_blank" style="font-weight: 500;">Leave a Review</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/" target="_blank" style="font-weight: 500;">Rate it</a> (&#9733;&#9733;&#9733;&#9733;&#9733;), if you like this plugin.';
    }
}
add_filter('admin_footer_text', 'lmt_remove_footer_admin');

// add settings page
function lmt_plug_settings_page() {

    add_settings_section("lmt_post_option_section", "Post Options<hr>", null, "lmt_post_option");
    
    add_settings_field("lmt_enable_last_modified_cb", "<label for='post-enable'>Enable Last Modified Info for Posts:</label>", "lmt_enable_last_modified_cb_display", "lmt_post_option", "lmt_post_option_section");  
    add_settings_field("lmt_use_as_sc_cb", "<label for='post-sc'>Enable Shortcode for Posts:</label>", "lmt_use_as_sc_cb_display", "lmt_post_option", "lmt_post_option_section");  
    add_settings_field("lmt_enable_revision_tag_output_cb", "<label for='post-revised'>Enable 'revised' Meta Tag Output for Posts:</label>", "lmt_enable_revision_tag_output_cb_display", "lmt_post_option", "lmt_post_option_section");  
    add_settings_field("lmt_enable_last_modified_time_cb", "<label for='post-enable-time'>Show Last Modified Time:</label>", "lmt_enable_last_modified_time_cb_display", "lmt_post_option", "lmt_post_option_section");  
    add_settings_field("lmt_enable_last_modified_date_cb", "<label for='post-enable-date'>Show Last Modified Date:</label>", "lmt_enable_last_modified_date_cb_display", "lmt_post_option", "lmt_post_option_section");  
    add_settings_field("lmt_show_last_modified_time_date_post", "<label for='post-show-status'>Show Last Modified Time & Date:</label>", "lmt_show_last_modified_time_date_post_display", "lmt_post_option", "lmt_post_option_section");
    add_settings_field("lmt_post_custom_text", "<label for='post-custom-text'>Your Custom Text for Posts:</label>", "lmt_post_custom_text_display", "lmt_post_option", "lmt_post_option_section"); 
    
    add_settings_section("lmt_page_option_section", "Page Options<hr>", null, "lmt_page_option");
    
    add_settings_field("lmt_enable_last_modified_page_cb", "<label for='page-enable'>Enable Last Modified Info for Pages:</label>", "lmt_enable_last_modified_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
    add_settings_field("lmt_use_as_sc_page_cb", "<label for='page-sc'>Enable Shortcode for Pages:</label>", "lmt_use_as_sc_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
    add_settings_field("lmt_enable_revision_tag_output_page_cb", "<label for='page-revised'>Enable 'revised' Meta Tag Output for Pages:</label>", "lmt_enable_revision_tag_output_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
    add_settings_field("lmt_enable_last_modified_time_page_cb", "<label for='page-enable-time'>Show Last Modified Time:</label>", "lmt_enable_last_modified_time_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
    add_settings_field("lmt_enable_last_modified_date_page_cb", "<label for='page-enable-date'>Show Last Modified Date:</label>", "lmt_enable_last_modified_date_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
    add_settings_field("lmt_show_last_modified_time_date_page", "<label for='page-show-status'>Show Last Modified Time & Date:</label>", "lmt_show_last_modified_time_date_page_display", "lmt_page_option", "lmt_page_option_section");
    add_settings_field("lmt_page_custom_text", "<label for='page-custom-text'>Your Custom Text for Pages:</label>", "lmt_page_custom_text_display", "lmt_page_option", "lmt_page_option_section"); 
    
    add_settings_section("lmt_dashboard_option_section", "Dashboard Options<hr>", null, "lmt_dashboard_option");
    
    add_settings_field("lmt_enable_on_post_cb", "<label for='post-enable-dashboard'>Show Last Modified Info on Post Column:</label>", "lmt_enable_on_post_cb_display", "lmt_dashboard_option", "lmt_dashboard_option_section");  
    add_settings_field("lmt_enable_on_page_cb", "<label for='page-enable-dashboard'>Show Last Modified Info on Page Column:</label>", "lmt_enable_on_page_cb_display", "lmt_dashboard_option", "lmt_dashboard_option_section");
    add_settings_field("lmt_enable_lmi_on_users_cb", "<label for='enable-user-info'>Show Last Modified Info of Users:</label>", "lmt_enable_lmi_on_users_cb_display", "lmt_dashboard_option", "lmt_dashboard_option_section");
    add_settings_field("lmt_enable_lmi_header_cb", "<label for='enable-header'>Enable Last Modified Header:</label>", "lmt_enable_lmi_header_cb_display", "lmt_dashboard_option", "lmt_dashboard_option_section");

    add_settings_section("lmt_cus_style_section", "Custom CSS<hr>", null, "lmt_cus_style_option");
    
    add_settings_field("lmt_custom_style_box", "<label for='lmt-cus-style'>Write Custom CSS Here:</label>", "lmt_custom_style_box_display", "lmt_cus_style_option", "lmt_cus_style_section");  
    
    
    register_setting("lmt_post_page_plugin_section", "lmt_plugin_global_settings");

}

/*
============

post options

============
*/

function lmt_enable_last_modified_cb_display() {
   ?>
        
        <label class="switch">
        <input type="checkbox" id="post-enable" name="lmt_plugin_global_settings[lmt_enable_last_modified_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_cb'])); ?> /> 
        <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on single posts page."><span title="" class="dashicons dashicons-editor-help"></span></span>

   <?php
}

function lmt_use_as_sc_cb_display() {
    ?>
         
         <label class="switch">
         <input type="checkbox" id="post-sc" name="lmt_plugin_global_settings[lmt_use_as_sc_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_use_as_sc_cb'])); ?> /> 
         <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on single posts page using shortcode. It will disable auto insert function."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_enable_revision_tag_output_cb_display() {
    ?>
         
         <label class="switch">
         <input type="checkbox" id="post-revised" name="lmt_plugin_global_settings[lmt_enable_revision_tag_output_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_revision_tag_output_cb'])); ?> /> 
         <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to display post's last modified info in source code as 'revised' meta tag."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}


function lmt_enable_last_modified_time_cb_display() {
    ?>
         
         <label class="switch">
         <input type="checkbox" id="post-enable-time" name="lmt_plugin_global_settings[lmt_enable_last_modified_time_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_time_cb'])); ?> /> 
         <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified time on posts."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_enable_last_modified_date_cb_display() {
    ?>
         
         <label class="switch">
         <input type="checkbox" id="post-enable-date" name="lmt_plugin_global_settings[lmt_enable_last_modified_date_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_date_cb'])); ?> /> 
         <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified date on posts."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
 }
 

function lmt_show_last_modified_time_date_post_display() {
    $options = get_option('lmt_plugin_global_settings');

    $items = array("Before Content", "After Content");
    echo "<select id='post-show-status' name='lmt_plugin_global_settings[lmt_show_last_modified_time_date_post]'>";
    foreach($items as $item) {
        $selected = ($options['lmt_show_last_modified_time_date_post'] == $item) ? 'selected="selected"' : '';
        echo "<option value='$item' $selected>$item</option>";
    }
    echo "</select>";
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="Select where you want to show last modified info on a single posts page."><span title="" class="dashicons dashicons-editor-help"></span></span>
        
   <?php
}

function lmt_post_custom_text_display() {
    ?>

    <input id="post-custom-text" name="lmt_plugin_global_settings[lmt_post_custom_text]" type="text" size="60" placeholder="Last Updated on" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_post_custom_text'])) { echo get_option('lmt_plugin_global_settings')['lmt_post_custom_text']; } ?>" />
    &nbsp;&nbsp;<span class="tooltip" title="Enter your custom text which will be shown on single posts page. You can aslo set a custom style from 'Custom CSS tab' for this. Use 'post-last-modified' as css class."><span title="" class="dashicons dashicons-editor-help"></span></span>
    
    <?php
}


/*
============

page options

============
*/

function lmt_enable_last_modified_page_cb_display() {
    ?>
         
         <label class="switch">
         <input type="checkbox" id="page-enable" name="lmt_plugin_global_settings[lmt_enable_last_modified_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_page_cb'])); ?> /> 
         <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on pages."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_use_as_sc_page_cb_display() {
    ?>
         
         <label class="switch">
         <input type="checkbox" id="page-sc" name="lmt_plugin_global_settings[lmt_use_as_sc_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_use_as_sc_page_cb'])); ?> /> 
         <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on pages using shortcode. It will disable auto insert function."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_enable_revision_tag_output_page_cb_display() {
    ?>
         
         <label class="switch">
         <input type="checkbox" id="page-revised" name="lmt_plugin_global_settings[lmt_enable_revision_tag_output_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_revision_tag_output_page_cb'])); ?> /> 
         <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want display page's last modified info in source code as 'revised' meta tag."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_enable_last_modified_time_page_cb_display() {
    ?>
         
         <label class="switch">
         <input type="checkbox" id="page-enable-time" name="lmt_plugin_global_settings[lmt_enable_last_modified_time_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_time_page_cb'])); ?> /> 
         <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified time on pagess."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_enable_last_modified_date_page_cb_display() {
    ?>
         
         <label class="switch">
         <input type="checkbox" id="page-enable-date" name="lmt_plugin_global_settings[lmt_enable_last_modified_date_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_date_page_cb'])); ?> /> 
         <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified date on pages."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}
 
function lmt_show_last_modified_time_date_page_display() {
    $options = get_option('lmt_plugin_global_settings');

    $items = array("Before Content", "After Content");
    echo "<select id='page-show-status' name='lmt_plugin_global_settings[lmt_show_last_modified_time_date_page]'>";
    foreach($items as $item) {
        $selected = ($options['lmt_show_last_modified_time_date_page'] == $item) ? 'selected="selected"' : '';
        echo "<option value='$item' $selected>$item</option>";
    }
    echo "</select>";
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="Select where you want to show last modified info on a single page."><span title="" class="dashicons dashicons-editor-help"></span></span>
         
    <?php
 }
 
 function lmt_page_custom_text_display() {
     ?>
 
     <input id="page-custom-text" name="lmt_plugin_global_settings[lmt_page_custom_text]" type="text" size="60" placeholder="Last Updated on" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_page_custom_text'])) { echo get_option('lmt_plugin_global_settings')['lmt_page_custom_text']; } ?>" />
     &nbsp;&nbsp;<span class="tooltip" title="Enter your custom text which will be shown on single page. You can also set a custom style from 'Custom CSS tab' for this. Use 'page-last-modified' as css class."><span title="" class="dashicons dashicons-editor-help"></span></span>
     
     <?php
 }


/*
============

dashboard options

============
*/

function lmt_enable_on_post_cb_display() {
    ?>
         
         <label class="switch">
         <input type="checkbox" id="post-enable-dashboard" name="lmt_plugin_global_settings[lmt_enable_on_post_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_on_post_cb'])); ?> /> 
         <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on posts(Posts > All Posts) page. You can sort posts by last modified info."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_enable_on_page_cb_display() {
    ?>
         
         <label class="switch">
         <input type="checkbox" id="page-enable-dashboard" name="lmt_plugin_global_settings[lmt_enable_on_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_on_page_cb'])); ?> /> 
         <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on pages(Pages > All Pages) column. You can sort pages by last modified info."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_enable_lmi_on_users_cb_display() {
    ?>
         
         <label class="switch">
         <input type="checkbox" id="enable-user-info" name="lmt_plugin_global_settings[lmt_enable_lmi_on_users_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_lmi_on_users_cb'])); ?> /> 
         <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on users page(Users > All Users) column."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_enable_lmi_header_cb_display() {
    ?>
         
         <label class="switch">
         <input type="checkbox" id="enable-header" name="lmt_plugin_global_settings[lmt_enable_lmi_header_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_lmi_header_cb'])); ?> /> 
         <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable 'last modified' header output. Some time it returns 304 header response."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

/*
============

custom style

============
*/

function lmt_custom_style_box_display() {
    ?>
    <textarea id="lmt-cus-style" placeholder="Write your custom css here." name="lmt_plugin_global_settings[lmt_custom_style_box]" rows="10" cols="100"><?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_style_box'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_style_box']; } ?></textarea>
    &nbsp;&nbsp;<span class="tooltip" title="Write your custom css. Do not add <style></style> tag, as it is already added."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

// add settings page
add_action("admin_init", "lmt_plug_settings_page");

// add custom css
add_action ('wp_head','lmt_style_hook_inHeader', 10);
function lmt_style_hook_inHeader() {
    echo '<style type="text/css" id="lmt-custom-css">' . get_option('lmt_plugin_global_settings')['lmt_custom_style_box'] . '</style>';
}

// page elements
function lmt_show_page() {

    include plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
}

// add menu options
function lmt_menu_item_options() {

  add_submenu_page("options-general.php", "WP Last Modified Info", "Last Modified Info", "manage_options", "wp-last-modified-info", "lmt_show_page"); 

}
add_action("admin_menu", "lmt_menu_item_options");


$options = get_option('lmt_plugin_global_settings');


// lmi output for posts
if( isset($options['lmt_enable_last_modified_cb']) && ($options['lmt_enable_last_modified_cb'] == 1) ) {

    include plugin_dir_path( __FILE__ ) . 'inc/class-post-options.php';

    // revison tag output of posts
if( isset($options['lmt_enable_revision_tag_output_cb']) && ($options['lmt_enable_revision_tag_output_cb'] == 1) ) {

    add_action ('wp_head','lmt_post_revised_hook_inHeader', 10);
        function lmt_post_revised_hook_inHeader() {

        $updated_post_info = get_the_modified_time('l, F jS, Y, h:i a');
        if (get_the_modified_time('U') > get_the_time('U') && is_single()) {
        echo '<meta name="revised" content="' . $updated_post_info . '">';
        }
    }
}

}

// enable lmi output for pages
if( isset($options['lmt_enable_last_modified_page_cb']) && ($options['lmt_enable_last_modified_page_cb'] == 1) ) {

    require plugin_dir_path( __FILE__ ) . 'inc/class-page-options.php';

    //revision tag output for pages
if( isset($options['lmt_enable_revision_tag_output_page_cb']) && ($options['lmt_enable_revision_tag_output_page_cb'] == 1) ) {

    add_action ('wp_head','lmt_page_revised_hook_inHeader', 10);
        function lmt_page_revised_hook_inHeader() {

        $updated_pg_info = get_the_modified_time('l, F jS, Y, h:i a');
        if (get_the_modified_time('U') > get_the_time('U') && is_page()) {
        echo '<meta name="revised" content="' . $updated_pg_info . '">';
        }
    }
}

}


// last modified info of posts column
if( isset($options['lmt_enable_on_post_cb']) && ($options['lmt_enable_on_post_cb'] == 1 ) ) {
    
    include plugin_dir_path( __FILE__ ) . 'inc/class-dashboard-post.php';
    
}


// last modified info of pages column
if( isset($options['lmt_enable_on_page_cb']) && ($options['lmt_enable_on_page_cb'] == 1 ) ) {
    
    include plugin_dir_path( __FILE__ ) . 'inc/class-dashboard-page.php';

}


// last modified info of user profiles
if( isset($options['lmt_enable_lmi_on_users_cb']) && ($options['lmt_enable_lmi_on_users_cb'] == 1 ) ) {
    
    function lmt_update_profile_modified( $user_id ) {
        update_user_meta( $user_id, 'profile_last_modified', current_time( 'mysql' ) );
    }
    
    add_action( 'profile_update', 'lmt_update_profile_modified' );
    
    function lmt_add_extra_user_column( $columns ) {
        return array_merge( $columns,
        array( 'last-modified' => __( 'Last Modified' ) ) );
    }
    
    add_action( 'manage_users_columns', 'lmt_add_extra_user_column' );
    
    function lmt_manage_users_custom_column( $custom_column, $column_name, $user_id ) {
        if ( 'last-modified' == $column_name ) {
            $user_info = get_userdata( $user_id );
            $profile_last_modified = $user_info->profile_last_modified;
            $custom_column = "\t{$profile_last_modified}\n";
        }
        return $custom_column;
    }
    
    add_action( 'manage_users_custom_column', 'lmt_manage_users_custom_column', 10, 3 );

}


// last modified headers
if( isset($options['lmt_enable_lmi_header_cb']) && ($options['lmt_enable_lmi_header_cb'] == 1 ) ) {
    
    add_action('wp', 'lmt_add_last_modified_header');
    
    function lmt_add_last_modified_header() {
        
        header("Last-Modified: " . get_the_modified_time('D, d M Y H:i:s') . " GMT");
        
    }

}



// add action links
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'lmt_add_action_links' );

function lmt_add_action_links ( $links ) {
 $mylinks = array(
 '<a href="' . admin_url( 'options-general.php?page=wp-last-modified-info' ) . '">Settings</a>',
 );
return array_merge( $links, $mylinks );
}

function my_plugin_links($links, $file) {
	$plugin = plugin_basename(__FILE__);

	if ($file == $plugin) // only for this plugin
		return array_merge( $links, 
			array( '<a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank">' . __('Support') . '</a>' )
		);
	return $links;
}

add_filter( 'plugin_row_meta', 'my_plugin_links', 10, 2 );

?>