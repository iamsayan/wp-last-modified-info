<?php
/*
Plugin Name: WP Last Modified Info
Plugin URI: https://iamsayan.github.io/wp-last-modified-info/
Description: Show or hide last update date and time on pages and posts very easily. You can use shortcode also to dispaly last modified info anywhere.
Version: 1.2.3
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
    wp_enqueue_style( 'lmt-admin-style', plugins_url( 'css/admin-style.min.css', __FILE__ ) );
    wp_enqueue_style( 'lmt-cb-style', plugins_url( 'css/style.min.css', __FILE__ ) );    
    wp_enqueue_script( 'lmt-script', plugins_url( 'js/main.min.js', __FILE__ ) );
    }

}
add_action( 'admin_enqueue_scripts', 'lmt_custom_admin_styles_scripts' );
/* ============================================================================================== 
                                           Start functions
============================================================================================== */

// add settings page
function lmt_plug_settings_page() {
    
    // start post fields
    add_settings_section("lmt_post_option_section", "Post Options<p><hr></p>", null, "lmt_post_option");
        add_settings_field("lmt_enable_last_modified_cb", "<label for='post-enable'>Enable for Posts on Frontend:</label>", "lmt_enable_last_modified_cb_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_enable_human_format_cb", "<label for='post-human'>Show as &#39;Days Ago&#39; Format:</label>", "lmt_enable_human_format_cb_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_enable_last_modified_time_cb", "<label for='post-enable-time'>Show Last Modified Time:</label>", "lmt_enable_last_modified_time_cb_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_custom_post_time_format", "<label for='custom-post-time-format'>Custom Time Format:</label>", "lmt_custom_post_time_format_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_enable_last_modified_date_cb", "<label for='post-enable-date'>Show Last Modified Date:</label>", "lmt_enable_last_modified_date_cb_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_custom_post_date_format", "<label for='custom-post-date-format'>Custom Date Format:</label>", "lmt_custom_post_date_format_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_post_date_time_sep", "<label for='post-dt-sep'>Post Date / Time Seperator:</label>", "lmt_post_date_time_sep_display", "lmt_post_option", "lmt_post_option_section"); 
        add_settings_field("lmt_show_last_modified_time_date_post", "<label for='post-show-status'>Last Modified Info position:</label>", "lmt_show_last_modified_time_date_post_display", "lmt_post_option", "lmt_post_option_section");
        add_settings_field("lmt_post_custom_text", "<label for='post-custom-text'>Set Custom Message for Posts:</label>", "lmt_post_custom_text_display", "lmt_post_option", "lmt_post_option_section"); 
        add_settings_field("lmt_show_author_cb", "<label for='post-sa'>Last Modified Author Name:</label>", "lmt_show_author_cb_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_use_as_sc_cb", "<label for='post-sc'>Use as Shortcode on Posts:</label>", "lmt_use_as_sc_cb_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_post_disable_auto_insert", "<label for='post-disable-auto-insert'>Disable Auto Insert on Post ID:</label>", "lmt_post_disable_auto_insert_display", "lmt_post_option", "lmt_post_option_section"); 
        
    // start page fields
    add_settings_section("lmt_page_option_section", "Page Options<p><hr></p>", null, "lmt_page_option");    
        add_settings_field("lmt_enable_last_modified_page_cb", "<label for='page-enable'>Enable for Pages on Frontend:</label>", "lmt_enable_last_modified_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
        add_settings_field("lmt_enable_human_format_page_cb", "<label for='page-human'>Show as &#39;Days Ago&#39; Format:</label>", "lmt_enable_human_format_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
        add_settings_field("lmt_enable_last_modified_time_page_cb", "<label for='page-enable-time'>Show Last Modified Time:</label>", "lmt_enable_last_modified_time_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
        add_settings_field("lmt_custom_page_time_format", "<label for='custom-page-time-format'>Custom Time Format:</label>", "lmt_custom_page_time_format_display", "lmt_page_option", "lmt_page_option_section");  
        add_settings_field("lmt_enable_last_modified_date_page_cb", "<label for='page-enable-date'>Show Last Modified Date:</label>", "lmt_enable_last_modified_date_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
        add_settings_field("lmt_custom_page_date_format", "<label for='custom-page-date-format'>Custom Date Format:</label>", "lmt_custom_page_date_format_display", "lmt_page_option", "lmt_page_option_section");  
        add_settings_field("lmt_page_date_time_sep", "<label for='page-dt-sep'>Page Date / Time Seperator:</label>", "lmt_page_date_time_sep_display", "lmt_page_option", "lmt_page_option_section"); 
        add_settings_field("lmt_show_last_modified_time_date_page", "<label for='page-show-status'>Last Modified Info position:</label>", "lmt_show_last_modified_time_date_page_display", "lmt_page_option", "lmt_page_option_section");
        add_settings_field("lmt_page_custom_text", "<label for='page-custom-text'>Set Custom Message for Pages:</label>", "lmt_page_custom_text_display", "lmt_page_option", "lmt_page_option_section"); 
        add_settings_field("lmt_show_author_page_cb", "<label for='page-sa'>Last Modified Author Name:</label>", "lmt_show_author_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
        add_settings_field("lmt_use_as_sc_page_cb", "<label for='page-sc'>Use as Shortcode for Pages:</label>", "lmt_use_as_sc_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
        add_settings_field("lmt_page_disable_auto_insert", "<label for='page-disable-auto-insert'>Disable Auto Insert on Page ID:</label>", "lmt_page_disable_auto_insert_display", "lmt_page_option", "lmt_page_option_section"); 
        
    // start dashboard fields
    add_settings_section("lmt_dashboard_option_section", "Dashboard Options<p><hr></p>", null, "lmt_dashboard_option");
        add_settings_field("lmt_enable_on_dashboard_cb", "<label for='dashboard-display'>Show Info on Dashboard:</label>", "lmt_enable_on_dashboard_cb_display", "lmt_dashboard_option", "lmt_dashboard_option_section");  
        add_settings_field("lmt_enable_on_admin_bar_cb", "<label for='admin-bar-display'>Show Info on Admin Bar:</label>", "lmt_enable_on_admin_bar_cb_display", "lmt_dashboard_option", "lmt_dashboard_option_section");
        add_settings_field("lmt_set_widget_post_num", "<label for='widget-post-no'>No. of Posts on Widget:</label>", "lmt_set_widget_post_num_display", "lmt_dashboard_option", "lmt_dashboard_option_section");
        
    // start template tags
    add_settings_section("lmt_template_tag_section", "Template Tags Options<p><hr></p>", null, "lmt_template_tag_option");
        add_settings_field("lmt_tt_enable_cb", "<label for='lmt-tt'>Enable Template Tags:</label>", "lmt_tt_enable_cb_display", "lmt_template_tag_option", "lmt_template_tag_section");  
        add_settings_field("lmt_enable_human_format_tt_cb", "<label for='lmt-tt-human'>Show as &#39;Days Ago&#39; Format:</label>", "lmt_enable_human_format_tt_cb_display", "lmt_template_tag_option", "lmt_template_tag_section");  
        add_settings_field("lmt_tt_set_format_box", "<label for='lmt-tt-format'>Set Modified date/time format:</label>", "lmt_tt_set_format_box_display", "lmt_template_tag_option", "lmt_template_tag_section");  
        add_settings_field("lmt_tt_updated_text_box", "<label for='lmt-tt-updated-text'>Set Custom Message:</label>", "lmt_tt_updated_text_box_display", "lmt_template_tag_option", "lmt_template_tag_section");  
        add_settings_field("lmt_show_author_tt_cb", "<label for='lmt-tt-sa'>Last Modified Author Name:</label>", "lmt_show_author_tt_cb_display", "lmt_template_tag_option", "lmt_template_tag_section");  
        add_settings_field("lmt_tt_class_box", "<label for='lmt-tt-class'>Set Custom CSS Class:</label>", "lmt_tt_class_box_display", "lmt_template_tag_option", "lmt_template_tag_section");  
        
    // start custom css field
    add_settings_section("lmt_cus_style_section", "Custom CSS<p><hr></p>", null, "lmt_cus_style_option");
        add_settings_field("lmt_custom_style_box", "<label for='lmt-cus-style'>Write Custom CSS Here:</label>", "lmt_custom_style_box_display", "lmt_cus_style_option", "lmt_cus_style_section");  
    
    // register settings
    register_setting("lmt_post_page_plugin_section", "lmt_plugin_global_settings");

}

/* ============================================================================================== 
                                           post options
============================================================================================== */

function lmt_enable_last_modified_cb_display() {
   ?>   <label class="switch">
        <input type="checkbox" id="post-enable" name="lmt_plugin_global_settings[lmt_enable_last_modified_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_cb'])); ?> /> 
        <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on single posts page."><span title="" class="dashicons dashicons-editor-help"></span></span>
   <?php
}

function lmt_enable_human_format_cb_display() {
    ?>  <label class="switch">
        <input type="checkbox" id="post-human" name="lmt_plugin_global_settings[lmt_enable_human_format_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_human_format_cb'])); ?> /> 
        <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on posts as human readable format i.e. days/weeks/years ago."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_last_modified_time_cb_display() {
    ?>  <label class="switch">
        <input type="checkbox" id="post-enable-time" name="lmt_plugin_global_settings[lmt_enable_last_modified_time_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_time_cb'])); ?> /> 
        <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified time on posts. Also keep this option on if &#39;Days Ago Format&#39; is enabled."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_custom_post_time_format_display() {
    ?>  <input id="custom-post-time-format" name="lmt_plugin_global_settings[lmt_custom_post_time_format]" type="text" size="10" style="width:10%;" placeholder="h:i a" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_post_time_format'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_post_time_format']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter custom time format here. Default: h:i a. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_last_modified_date_cb_display() {
    ?>  <label class="switch">
        <input type="checkbox" id="post-enable-date" name="lmt_plugin_global_settings[lmt_enable_last_modified_date_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_date_cb'])); ?> /> 
        <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified date on posts."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_custom_post_date_format_display() {
    ?>  <input id="custom-post-date-format" name="lmt_plugin_global_settings[lmt_custom_post_date_format]" type="text" size="10" style="width:10%;" placeholder="F jS, Y" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_post_date_format'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_post_date_format']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter custom date format here. Default: F, jS, Y. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_post_date_time_sep_display() {
    ?>  <input id="post-dt-sep" name="lmt_plugin_global_settings[lmt_post_date_time_sep]" type="text" size="8" style="width:8%;" placeholder="at" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_post_date_time_sep'])) { echo get_option('lmt_plugin_global_settings')['lmt_post_date_time_sep']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="If you want to customize date/time seperator on posts, set custom date and time seperator from here. Default: at."><span title="" class="dashicons dashicons-editor-help"></span></span>
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
    ?>  <input id="post-custom-text" name="lmt_plugin_global_settings[lmt_post_custom_text]" type="text" size="30" style="width:30%;" placeholder="Last Updated on" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_post_custom_text'])) { echo get_option('lmt_plugin_global_settings')['lmt_post_custom_text']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter your custom text which will be shown on single posts page. You can also set a custom style from 'Custom CSS tab' for this. Use 'post-last-modified' as css class."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_show_author_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_author_cb'])){
        $options['lmt_show_author_cb'] = 'Do not show';
    }

    $items = array("Do not show", "Show only", "Show with Link");
    echo "<select id='post-sa' name='lmt_plugin_global_settings[lmt_show_author_cb]'>";
    foreach($items as $item) {
        $selected = ($options['lmt_show_author_cb'] == $item) ? 'selected="selected"' : '';
        echo "<option value='$item' $selected>$item</option>";
    }
    echo "</select>";
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="Set how you want to display last modified author name on posts."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_use_as_sc_cb_display() {
    ?>  <label class="switch">
        <input type="checkbox" id="post-sc" name="lmt_plugin_global_settings[lmt_use_as_sc_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_use_as_sc_cb'])); ?> /> 
        <div class="slider round"></div></label>&nbsp;&nbsp;Shortcode: <code>[lmt-post-modified-info]</code>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on posts using only shortcode. It will disable auto insert process."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_post_disable_auto_insert_display() {
    ?>  <input id="post-disable-auto-insert" name="lmt_plugin_global_settings[lmt_post_disable_auto_insert]" type="text" size="50" style="width:50%;" placeholder="Enter post ids separated by commas" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_post_disable_auto_insert'])) { echo get_option('lmt_plugin_global_settings')['lmt_post_disable_auto_insert']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter comma separated list of Post IDs to exclude them from auto insert process."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

/* ============================================================================================== 
                                           page options
============================================================================================== */

function lmt_enable_last_modified_page_cb_display() {
    ?>  <label class="switch-pg">
        <input type="checkbox" id="page-enable" name="lmt_plugin_global_settings[lmt_enable_last_modified_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_page_cb'])); ?> /> 
        <div class="slider-pg round-pg"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on pages."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_human_format_page_cb_display() {
    ?>  <label class="switch-pg">
        <input type="checkbox" id="page-human" name="lmt_plugin_global_settings[lmt_enable_human_format_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_human_format_page_cb'])); ?> /> 
        <div class="slider-pg round-pg"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on pages as human readable format i.e. days/weeks/years ago."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_last_modified_time_page_cb_display() {
    ?>  <label class="switch-pg">
        <input type="checkbox" id="page-enable-time" name="lmt_plugin_global_settings[lmt_enable_last_modified_time_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_time_page_cb'])); ?> /> 
        <div class="slider-pg round-pg"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified time on pages. Also keep this option on if &#39;Days Ago Format&#39; is enabled."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_custom_page_time_format_display() {
    ?>  <input id="custom-page-time-format" name="lmt_plugin_global_settings[lmt_custom_page_time_format]" type="text" size="10" style="width:10%;" placeholder="h:i a" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_page_time_format'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_page_time_format']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter custom time format here. Default: h:i a. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_last_modified_date_page_cb_display() {
    ?>  <label class="switch-pg">
        <input type="checkbox" id="page-enable-date" name="lmt_plugin_global_settings[lmt_enable_last_modified_date_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_date_page_cb'])); ?> /> 
        <div class="slider-pg round-pg"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified date on pages."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_custom_page_date_format_display() {
    ?>  <input id="custom-page-date-format" name="lmt_plugin_global_settings[lmt_custom_page_date_format]" type="text" size="10" style="width:10%;" placeholder="F jS, Y" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_page_date_format'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_page_date_format']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter custom date format here. Default: F, jS, Y. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_page_date_time_sep_display() {
    ?>  <input id="page-dt-sep" name="lmt_plugin_global_settings[lmt_page_date_time_sep]" type="text" size="8" style="width:8%;" placeholder="at" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_page_date_time_sep'])) { echo get_option('lmt_plugin_global_settings')['lmt_page_date_time_sep']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="If you want to customize date/time seperator on pages, set custom date and time seperator from here. Default: at."><span title="" class="dashicons dashicons-editor-help"></span></span>
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
    ?> <input id="page-custom-text" name="lmt_plugin_global_settings[lmt_page_custom_text]" type="text" size="30" style="width:30%;" placeholder="Last Updated on" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_page_custom_text'])) { echo get_option('lmt_plugin_global_settings')['lmt_page_custom_text']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter your custom text which will be shown on single page. You can also set a custom style from 'Custom CSS tab' for this. Use 'page-last-modified' as css class."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_show_author_page_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_author_page_cb'])){
        $options['lmt_show_author_page_cb'] = 'Do not show';
    }

    $items = array("Do not show", "Show only", "Show with Link");
    echo "<select id='page-sa' name='lmt_plugin_global_settings[lmt_show_author_page_cb]'>";
    foreach($items as $item) {
        $selected = ($options['lmt_show_author_page_cb'] == $item) ? 'selected="selected"' : '';
        echo "<option value='$item' $selected>$item</option>";
    }
    echo "</select>";
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="Set how you want to display last modified author name on pages."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_use_as_sc_page_cb_display() {
    ?>  <label class="switch-pg">
        <input type="checkbox" id="page-sc" name="lmt_plugin_global_settings[lmt_use_as_sc_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_use_as_sc_page_cb'])); ?> /> 
        <div class="slider-pg round-pg"></div></label>&nbsp;&nbsp;Shortcode: <code>[lmt-page-modified-info]</code>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on pages using shortcode. It will disable auto insert function."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_page_disable_auto_insert_display() {
    ?>  <input id="page-disable-auto-insert" name="lmt_plugin_global_settings[lmt_page_disable_auto_insert]" type="text" size="50" style="width:50%;" placeholder="Separated by commas" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_page_disable_auto_insert'])) { echo get_option('lmt_plugin_global_settings')['lmt_page_disable_auto_insert']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter comma separated list of Page IDs to exclude them from auto insert process."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

/* ============================================================================================== 
                                           dashboard options
============================================================================================== */

function lmt_enable_on_dashboard_cb_display() {
    ?>  <label class="switch-db">
        <input type="checkbox" id="dashboard-display" name="lmt_plugin_global_settings[lmt_enable_on_dashboard_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_on_dashboard_cb'])); ?> /> 
        <div class="slider-db round-db"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to display last modified info on all posts, pages admin column, publish meta box and on the dashboard widget."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_on_admin_bar_cb_display() {
    ?>  <label class="switch-db">
        <input type="checkbox" id="admin-bar-display" name="lmt_plugin_global_settings[lmt_enable_on_admin_bar_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_on_admin_bar_cb'])); ?> /> 
        <div class="slider-db round-db"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on wordpress admin bar."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_set_widget_post_num_display() {
    ?>  <input id="widget-post-no" name="lmt_plugin_global_settings[lmt_set_widget_post_num]" type="number" size="6" style="width:6%;" placeholder="5" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_set_widget_post_num'])) { echo get_option('lmt_plugin_global_settings')['lmt_set_widget_post_num']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Set the number of posts you want to display on dashboard widget."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

/* ============================================================================================== 
                                         template tags options
============================================================================================== */

function lmt_tt_enable_cb_display() {
    ?>  <label class="switch-tt">
        <input type="checkbox" id="lmt-tt" name="lmt_plugin_global_settings[lmt_tt_enable_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_tt_enable_cb'])); ?> /> 
        <div class="slider-tt round-tt"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to use template tag functionality. Go to Help tab for more info."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_human_format_tt_cb_display() {
    ?>  <label class="switch-tt">
        <input type="checkbox" id="lmt-tt-human" name="lmt_plugin_global_settings[lmt_enable_human_format_tt_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_human_format_tt_cb'])); ?> /> 
        <div class="slider-tt round-tt"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info as human readable format i.e. days/weeks/years ago using template tags."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_tt_set_format_box_display() {
    ?> <input id="lmt-tt-format" name="lmt_plugin_global_settings[lmt_tt_set_format_box]" type="text" size="20" style="width:20%;" placeholder="e.g. F jS, Y @ h:i a" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_tt_set_format_box'])) { echo get_option('lmt_plugin_global_settings')['lmt_tt_set_format_box']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Set custom date/time format here. Default: F jS, Y @ h:i a. go to help tab for details."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_tt_updated_text_box_display() {
    ?> <input id="lmt-tt-updated-text" name="lmt_plugin_global_settings[lmt_tt_updated_text_box]" type="text" size="30" style="width:30%;" placeholder="e.g. updated on" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_tt_updated_text_box'])) { echo get_option('lmt_plugin_global_settings')['lmt_tt_updated_text_box']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="If you want to display any message before last modified date/time, set here."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_show_author_tt_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_author_tt_cb'])){
        $options['lmt_show_author_tt_cb'] = 'Do not show';
    }

    $items = array("Do not show", "Show only", "Show with Link");
    echo "<select id='lmt-tt-sa' name='lmt_plugin_global_settings[lmt_show_author_tt_cb]'>";
    foreach($items as $item) {
        $selected = ($options['lmt_show_author_tt_cb'] == $item) ? 'selected="selected"' : '';
        echo "<option value='$item' $selected>$item</option>";
    }
    echo "</select>";
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="Set how you want to display last modified author name using template tags."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_tt_class_box_display() {
    ?> <input id="lmt-tt-class" name="lmt_plugin_global_settings[lmt_tt_class_box]" type="text" size="40" style="width:40%;" placeholder="e.g. entry-time" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_tt_class_box'])) { echo get_option('lmt_plugin_global_settings')['lmt_tt_class_box']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="If you want to set any CSS Class, write here."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}
/* ============================================================================================== 
                                            custom css 
============================================================================================== */

function lmt_custom_style_box_display() {
    ?>
    <textarea id="lmt-cus-style" placeholder="Write your custom css here." name="lmt_plugin_global_settings[lmt_custom_style_box]" rows="12" cols="100" style="width:90%;"><?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_style_box'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_style_box']; } ?></textarea>
    <?php
}

// add settings page
add_action("admin_init", "lmt_plug_settings_page");

/* ============================================================================================== 
                                        Start plugin functions
============================================================================================== */

// add custom css
add_action ('wp_head','lmt_style_hook_inHeader', 10);
function lmt_style_hook_inHeader() {
    if( !empty( get_option('lmt_plugin_global_settings')['lmt_custom_style_box']) ) {
    echo '<style type="text/css" id="lmt-custom-css">' . get_option('lmt_plugin_global_settings')['lmt_custom_style_box'] . '</style>'."\n";
    }
}

// page elements
function lmt_show_page() {

    include plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';

    function lmt_remove_footer_admin () {

        // fetch plugin version
        $lmtpluginfo = get_plugin_data(__FILE__);
        $lmtversion = $lmtpluginfo['Version'];    
            // pring plugin version
            echo 'Thanks for using <strong>WP Last Modified Info v'. $lmtversion .'</strong> | Developed with <span style="color: #e25555;">♥</span> by <a href="https://profiles.wordpress.org/infosatech/" target="_blank" style="font-weight: 500;">Sayan Datta</a> | <a href="https://github.com/iamsayan/wp-last-modified-info" target="_blank" style="font-weight: 500;">GitHub</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank" style="font-weight: 500;">Support</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/" target="_blank" style="font-weight: 500;">Rate it</a> (&#9733;&#9733;&#9733;&#9733;&#9733;), if you like this plugin.';
    }

    /*function lmt_remove_footer_admin_version () {  
        
        $lmtpluginfo = get_plugin_data(__FILE__);
        $lmtversion = $lmtpluginfo['Version'];  
            // pring plugin version
            echo 'Version '. $lmtversion;
    }*/

    add_filter('admin_footer_text', 'lmt_remove_footer_admin');    
    //add_filter( 'update_footer', 'lmt_remove_footer_admin_version');
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
            array( '<a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank">' . __('Support') . '</a>' ),
            array( '<a href="https://bit.ly/2I0Gj60" target="_blank">' . __('Donate') . '</a>' )
            
		);
	return $links;
}

add_filter( 'plugin_row_meta', 'lmt_plugin_meta_links', 10, 2 );

?>