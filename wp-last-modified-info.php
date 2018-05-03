<?php
/*
Plugin Name: WP Last Modified Info
Plugin URI: https://wordpress.org/plugins/wp-last-modified-info/
Description: Show or hide last update date and time on pages and posts very easily. You can use shortcode also to dispaly last modified info anywhere.
Version: 1.1.2
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

// add settings page
function lmt_plug_settings_page() {

    add_settings_section("lmt_post_option_section", "Post Options<hr>", null, "lmt_post_option");
    
    // start post fields
    add_settings_field("lmt_enable_last_modified_cb", "<label for='post-enable'>Enable Last Modified Info for Posts on Frontend:</label>", "lmt_enable_last_modified_cb_display", "lmt_post_option", "lmt_post_option_section");  
    add_settings_field("lmt_use_as_sc_cb", "<label for='post-sc'>Enable Shortcode for Posts:</label>", "lmt_use_as_sc_cb_display", "lmt_post_option", "lmt_post_option_section");  
    add_settings_field("lmt_enable_revision_tag_output_cb", "<label for='post-revised'>Enable 'revised' Meta Tag Output for Posts:</label>", "lmt_enable_revision_tag_output_cb_display", "lmt_post_option", "lmt_post_option_section");  
    add_settings_field("lmt_enable_last_modified_time_cb", "<label for='post-enable-time'>Show Last Modified Time:</label>", "lmt_enable_last_modified_time_cb_display", "lmt_post_option", "lmt_post_option_section");  
    add_settings_field("lmt_custom_post_time_format", "<label for='custom-post-time-format'>Custom Time Format:</label>", "lmt_custom_post_time_format_display", "lmt_post_option", "lmt_post_option_section");  
    add_settings_field("lmt_enable_last_modified_date_cb", "<label for='post-enable-date'>Show Last Modified Date:</label>", "lmt_enable_last_modified_date_cb_display", "lmt_post_option", "lmt_post_option_section");  
    add_settings_field("lmt_custom_post_date_format", "<label for='custom-post-date-format'>Custom Date Format:</label>", "lmt_custom_post_date_format_display", "lmt_post_option", "lmt_post_option_section");  
    add_settings_field("lmt_show_last_modified_time_date_post", "<label for='post-show-status'>Show Last Modified Time & Date:</label>", "lmt_show_last_modified_time_date_post_display", "lmt_post_option", "lmt_post_option_section");
    add_settings_field("lmt_post_custom_text", "<label for='post-custom-text'>Your Custom Text for Posts:</label>", "lmt_post_custom_text_display", "lmt_post_option", "lmt_post_option_section"); 
    

    add_settings_section("lmt_page_option_section", "Page Options<hr>", null, "lmt_page_option");
    
    // start page fields
    add_settings_field("lmt_enable_last_modified_page_cb", "<label for='page-enable'>Enable Last Modified Info for Pages on Frontend:</label>", "lmt_enable_last_modified_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
    add_settings_field("lmt_use_as_sc_page_cb", "<label for='page-sc'>Enable Shortcode for Pages:</label>", "lmt_use_as_sc_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
    add_settings_field("lmt_enable_revision_tag_output_page_cb", "<label for='page-revised'>Enable 'revised' Meta Tag Output for Pages:</label>", "lmt_enable_revision_tag_output_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
    add_settings_field("lmt_enable_last_modified_time_page_cb", "<label for='page-enable-time'>Show Last Modified Time:</label>", "lmt_enable_last_modified_time_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
    add_settings_field("lmt_custom_page_time_format", "<label for='custom-page-time-format'>Custom Time Format:</label>", "lmt_custom_page_time_format_display", "lmt_page_option", "lmt_page_option_section");  
    add_settings_field("lmt_enable_last_modified_date_page_cb", "<label for='page-enable-date'>Show Last Modified Date:</label>", "lmt_enable_last_modified_date_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
    add_settings_field("lmt_custom_page_date_format", "<label for='custom-page-date-format'>Custom Date Format:</label>", "lmt_custom_page_date_format_display", "lmt_page_option", "lmt_page_option_section");  
    add_settings_field("lmt_show_last_modified_time_date_page", "<label for='page-show-status'>Show Last Modified Time & Date:</label>", "lmt_show_last_modified_time_date_page_display", "lmt_page_option", "lmt_page_option_section");
    add_settings_field("lmt_page_custom_text", "<label for='page-custom-text'>Your Custom Text for Pages:</label>", "lmt_page_custom_text_display", "lmt_page_option", "lmt_page_option_section"); 
    

    add_settings_section("lmt_dashboard_option_section", "Dashboard Options<hr>", null, "lmt_dashboard_option");
    
    add_settings_field("lmt_enable_on_post_cb", "<label for='post-enable-dashboard'>Show Last Modified Info on Posts:</label>", "lmt_enable_on_post_cb_display", "lmt_dashboard_option", "lmt_dashboard_option_section");  
    add_settings_field("lmt_enable_on_page_cb", "<label for='page-enable-dashboard'>Show Last Modified Info on Pages:</label>", "lmt_enable_on_page_cb_display", "lmt_dashboard_option", "lmt_dashboard_option_section");
    add_settings_field("lmt_enable_lmi_on_users_cb", "<label for='enable-user-info'>Show Last Modified Profile & Last Login Info of Users:</label>", "lmt_enable_lmi_on_users_cb_display", "lmt_dashboard_option", "lmt_dashboard_option_section");
    
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

function lmt_custom_post_time_format_display() {
    ?>

    <input id="custom-post-time-format" name="lmt_plugin_global_settings[lmt_custom_post_time_format]" type="text" size="8" placeholder="e.g. h:i a" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_post_time_format'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_post_time_format']; } ?>" />
    &nbsp;&nbsp;<span class="tooltip" title="Enter custom time format here. Default: h:i a. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    
    <?php
}

function lmt_enable_last_modified_date_cb_display() {
    ?>
         
         <label class="switch">
         <input type="checkbox" id="post-enable-date" name="lmt_plugin_global_settings[lmt_enable_last_modified_date_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_date_cb'])); ?> /> 
         <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified date on posts."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_custom_post_date_format_display() {
    ?>

    <input id="custom-post-date-format" name="lmt_plugin_global_settings[lmt_custom_post_date_format]" type="text" size="8" placeholder="e.g. F jS, Y" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_post_date_format'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_post_date_format']; } ?>" />
    &nbsp;&nbsp;<span class="tooltip" title="Enter custom date format here. Default: F, jS, Y. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    
    <?php
}

function lmt_show_last_modified_time_date_post_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_last_modified_time_date_post'])){
        $options['lmt_show_last_modified_time_date_post'] = 'Before Content';
    }

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
    &nbsp;&nbsp;<span class="tooltip" title="Enter your custom text which will be shown on single posts page. You can also set a custom style from 'Custom CSS tab' for this. Use 'post-last-modified' as css class."><span title="" class="dashicons dashicons-editor-help"></span></span>
    
    <?php
}


/*
============

page options

============
*/

function lmt_enable_last_modified_page_cb_display() {
    ?>
         
         <label class="switch-pg">
         <input type="checkbox" id="page-enable" name="lmt_plugin_global_settings[lmt_enable_last_modified_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_page_cb'])); ?> /> 
         <div class="slider-pg round-pg"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on pages."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_use_as_sc_page_cb_display() {
    ?>
         
         <label class="switch-pg">
         <input type="checkbox" id="page-sc" name="lmt_plugin_global_settings[lmt_use_as_sc_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_use_as_sc_page_cb'])); ?> /> 
         <div class="slider-pg round-pg"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on pages using shortcode. It will disable auto insert function."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_enable_revision_tag_output_page_cb_display() {
    ?>
         
         <label class="switch-pg">
         <input type="checkbox" id="page-revised" name="lmt_plugin_global_settings[lmt_enable_revision_tag_output_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_revision_tag_output_page_cb'])); ?> /> 
         <div class="slider-pg round-pg"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want display page's last modified info in source code as 'revised' meta tag."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_enable_last_modified_time_page_cb_display() {
    ?>
         
         <label class="switch-pg">
         <input type="checkbox" id="page-enable-time" name="lmt_plugin_global_settings[lmt_enable_last_modified_time_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_time_page_cb'])); ?> /> 
         <div class="slider-pg round-pg"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified time on pagess."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_custom_page_time_format_display() {
    ?>

    <input id="custom-page-time-format" name="lmt_plugin_global_settings[lmt_custom_page_time_format]" type="text" size="8" placeholder="e.g. h:i a" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_page_time_format'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_page_time_format']; } ?>" />
    &nbsp;&nbsp;<span class="tooltip" title="Enter custom time format here. Default: h:i a. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    
    <?php
}

function lmt_enable_last_modified_date_page_cb_display() {
    ?>
         
         <label class="switch-pg">
         <input type="checkbox" id="page-enable-date" name="lmt_plugin_global_settings[lmt_enable_last_modified_date_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_date_page_cb'])); ?> /> 
         <div class="slider-pg round-pg"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified date on pages."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_custom_page_date_format_display() {
    ?>

    <input id="custom-page-date-format" name="lmt_plugin_global_settings[lmt_custom_page_date_format]" type="text" size="8" placeholder="e.g. F jS, Y" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_page_date_format'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_page_date_format']; } ?>" />
    &nbsp;&nbsp;<span class="tooltip" title="Enter custom date format here. Default: F, jS, Y. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    
    <?php
}
 
function lmt_show_last_modified_time_date_page_display() {
    $options = get_option('lmt_plugin_global_settings');

    if(!isset($options['lmt_show_last_modified_time_date_page'])){
        $options['lmt_show_last_modified_time_date_page'] = 'Before Content';
    }

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
         
         <label class="switch-db">
         <input type="checkbox" id="post-enable-dashboard" name="lmt_plugin_global_settings[lmt_enable_on_post_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_on_post_cb'])); ?> /> 
         <div class="slider-db round-db"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on all posts page. You can sort posts by last modified info."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_enable_on_page_cb_display() {
    ?>
         
         <label class="switch-db">
         <input type="checkbox" id="page-enable-dashboard" name="lmt_plugin_global_settings[lmt_enable_on_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_on_page_cb'])); ?> /> 
         <div class="slider-db round-db"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on pages (Pages > All Pages) column. You can sort pages by last modified info."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
    <?php
}

function lmt_enable_lmi_on_users_cb_display() {
    ?>
         
         <label class="switch-db">
         <input type="checkbox" id="enable-user-info" name="lmt_plugin_global_settings[lmt_enable_lmi_on_users_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_lmi_on_users_cb'])); ?> /> 
         <div class="slider-db round-db"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified profile and login info on users page (Users > All Users) column. Resave profile and relogin to your wordpress dashboard after activate this option."><span title="" class="dashicons dashicons-editor-help"></span></span>
 
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
    if( !empty( get_option('lmt_plugin_global_settings')['lmt_custom_style_box']) ) {
    echo '<style type="text/css" id="lmt-custom-css">' . get_option('lmt_plugin_global_settings')['lmt_custom_style_box'] . '</style>';
    }
}

// page elements
function lmt_show_page() {

    include plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';

    // fetch plugin version
    $lmtpluginfo = get_plugin_data(__FILE__);
    $lmtversion=$lmtpluginfo['Version'];
    // pring plugin version
    echo '<p>&nbsp;Thanks for using <strong>WP Last Modified Info v' . $lmtversion . '</strong> | Developed with <span style="color: #e25555;">♥</span> by <a href="https://profiles.wordpress.org/infosatech/" target="_blank" style="font-weight: 500;">Sayan Datta</a> | <a href="https://github.com/iamsayan/wp-last-modified-info" target="_blank" style="font-weight: 500;">GitHub</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/" target="_blank" style="font-weight: 500;">Rate it</a> (&#9733;&#9733;&#9733;&#9733;&#9733;), if you like this plugin.</p>';
 
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
    
    function lmt_custom_post_meta () {
        
        $lmt_updated_time = get_the_modified_time('M j, Y @ H:i');
        if (get_the_modified_time('U') > get_the_time('U') && (get_post_type() != 'page')) {
        echo '<div class="misc-pub-section misc-pub-section-last-updated"><span id="timestamp"><font color="#82878C"><span class="dashicons dashicons-calendar"></span></font>&nbsp;Updated on: <b>' . $lmt_updated_time . '</b></span></div>';
        }
    }
    add_action( 'post_submitbox_misc_actions', 'lmt_custom_post_meta');

}


// last modified info of pages column
if( isset($options['lmt_enable_on_page_cb']) && ($options['lmt_enable_on_page_cb'] == 1 ) ) {
    
    include plugin_dir_path( __FILE__ ) . 'inc/class-dashboard-page.php';

    function lmt_custom_page_meta () {
        
        $lmt_updated_time_page = get_the_modified_time('M j, Y @ H:i');
        if (get_the_modified_time('U') > get_the_time('U') && (get_post_type() == 'page')) {
        echo '<div class="misc-pub-section misc-pub-section-last-updated"><span id="timestamp"><font color="#82878C"><span class="dashicons dashicons-calendar"></span></font>&nbsp;Updated on: <b>' . $lmt_updated_time_page . '</b></span></div>';
        }
    }
    add_action( 'post_submitbox_misc_actions', 'lmt_custom_page_meta');

}


// last modified info of user profiles
if( isset($options['lmt_enable_lmi_on_users_cb']) && ($options['lmt_enable_lmi_on_users_cb'] == 1 ) ) {
    

    // profile modified info
    function lmt_update_profile_modified( $user_id ) {
        update_user_meta( $user_id, 'profile_last_modified', current_time( get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' ) ) );
    }
    
    add_action( 'profile_update', 'lmt_update_profile_modified' );
    
    function lmt_add_extra_user_column( $columns ) {
        return array_merge( $columns,
        array( 'last-modified' => __( 'Last Updated' ) ) );
    }
    
    add_action( 'manage_users_columns', 'lmt_add_extra_user_column' );
    
    function lmt_manage_users_custom_column( $profile_update_get_value, $profile_column_name, $user_id ) {
        if ( 'last-modified' == $profile_column_name ) {
            $user_info = get_userdata( $user_id );
            $profile_last_modified = $user_info->profile_last_modified;
            $profile_update_get_value = "\t{$profile_last_modified}\n";
        }
        return $profile_update_get_value;
    }
    
    add_action( 'manage_users_custom_column', 'lmt_manage_users_custom_column', 10, 3 );


    // last login info
    function lmt_user_last_login( $user_login, $user ) {
        update_user_meta( $user->ID, 'last_login', current_time( get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' ) ) );
    }
    add_action( 'wp_login', 'lmt_user_last_login', 10, 2 );
    
    function lmt_add_last_login_user_column( $columns ) {
       return array_merge( $columns,
       array( 'last-login' => __( 'Last Login' ) ) );
       }
    add_action( 'manage_users_columns', 'lmt_add_last_login_user_column' );
     
    function lmt_main_lastlogin($get_login_value, $login_column_name, $user_id) { 
      if ( 'last-login' == $login_column_name ) {
        $user_info = get_userdata( $user_id );
        $last_login_info = $user_info->last_login;
        $get_login_value = "\t{$last_login_info}\n";
      }
        return $get_login_value; 
    } 
    
    add_action( 'manage_users_custom_column', 'lmt_main_lastlogin', 10, 3 );

}


// add action links
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'lmt_add_action_links' );

function lmt_add_action_links ( $links ) {
 $mylinks = array(
 '<a href="' . admin_url( 'options-general.php?page=wp-last-modified-info' ) . '">Settings</a>',
 );
return array_merge( $links, $mylinks );
}

function lmt_plugin_meta_links($links, $file) {
	$plugin = plugin_basename(__FILE__);

	if ($file == $plugin) // only for this plugin
		return array_merge( $links, 
            array( '<a href="https://github.com/iamsayan/wp-last-modified-info" target="_blank">' . __('GitHub') . '</a>' ),
            array( '<a href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/" target="_blank">' . __('Leave a Review') . '</a>' ),
            array( '<a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank">' . __('Support') . '</a>' )
		);
	return $links;
}

add_filter( 'plugin_row_meta', 'lmt_plugin_meta_links', 10, 2 );

?>