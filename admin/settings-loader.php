<?php

/**
 * Plugin settings fields loader
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

// add settings page
function lmt_plug_settings_page() {
    
    // start post fields
    add_settings_section("lmt_post_option_section", "Post Options<p><hr></p>", null, "lmt_post_option");
        add_settings_field("lmt_enable_last_modified_cb", "<label for='post-enable'>Enable for Posts on Frontend:</label>", "lmt_enable_last_modified_cb_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_enable_human_format_cb", "<label for='post-human'>Show as Human Readable Format:</label>", "lmt_enable_human_format_cb_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_enable_last_modified_time_cb", "<label for='post-enable-time'>Show Last Modified Time on Posts:</label>", "lmt_enable_last_modified_time_cb_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_custom_post_time_format", "<label for='custom-post-time-format'>Custom Time Format for Posts:</label>", "lmt_custom_post_time_format_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_enable_last_modified_date_cb", "<label for='post-enable-date'>Show Last Modified Date on Posts:</label>", "lmt_enable_last_modified_date_cb_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_custom_post_date_format", "<label for='custom-post-date-format'>Custom Date Format for Posts:</label>", "lmt_custom_post_date_format_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_post_date_time_sep", "<label for='post-dt-sep'>Post Date / Time Seperator:</label>", "lmt_post_date_time_sep_display", "lmt_post_option", "lmt_post_option_section"); 
        add_settings_field("lmt_show_last_modified_time_date_post", "<label for='post-show-status'>Last Modified Info Display Method:</label>", "lmt_show_last_modified_time_date_post_display", "lmt_post_option", "lmt_post_option_section");
        add_settings_field("lmt_post_custom_text", "<label for='post-custom-text'>Custom Message to Display on Posts:</label>", "lmt_post_custom_text_display", "lmt_post_option", "lmt_post_option_section"); 
        add_settings_field("lmt_show_author_cb", "<label for='post-sa'>Display Last Modified Author Name:</label>", "lmt_show_author_cb_display", "lmt_post_option", "lmt_post_option_section");  
        add_settings_field("lmt_enable_custom_post_types", "<label for='cpt'>Select Custom Post Types (if any):</label>", "lmt_enable_custom_post_types_display", "lmt_post_option", "lmt_post_option_section");  
        
    // start page fields
    add_settings_section("lmt_page_option_section", "Page Options<p><hr></p>", null, "lmt_page_option");    
        add_settings_field("lmt_enable_last_modified_page_cb", "<label for='page-enable'>Enable for Pages on Frontend:</label>", "lmt_enable_last_modified_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
        add_settings_field("lmt_enable_human_format_page_cb", "<label for='page-human'>Show as Human Readable Format:</label>", "lmt_enable_human_format_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
        add_settings_field("lmt_enable_last_modified_time_page_cb", "<label for='page-enable-time'>Show Last Modified Time on Pages:</label>", "lmt_enable_last_modified_time_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
        add_settings_field("lmt_custom_page_time_format", "<label for='custom-page-time-format'>Custom Time Format for Pages:</label>", "lmt_custom_page_time_format_display", "lmt_page_option", "lmt_page_option_section");  
        add_settings_field("lmt_enable_last_modified_date_page_cb", "<label for='page-enable-date'>Show Last Modified Date on Pages:</label>", "lmt_enable_last_modified_date_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
        add_settings_field("lmt_custom_page_date_format", "<label for='custom-page-date-format'>Custom Date Format for Pages:</label>", "lmt_custom_page_date_format_display", "lmt_page_option", "lmt_page_option_section");  
        add_settings_field("lmt_page_date_time_sep", "<label for='page-dt-sep'>Page Date / Time Seperator:</label>", "lmt_page_date_time_sep_display", "lmt_page_option", "lmt_page_option_section"); 
        add_settings_field("lmt_show_last_modified_time_date_page", "<label for='page-show-status'>Last Modified Info Display Position:</label>", "lmt_show_last_modified_time_date_page_display", "lmt_page_option", "lmt_page_option_section");
        add_settings_field("lmt_page_custom_text", "<label for='page-custom-text'>Custom Message to Display on Pages:</label>", "lmt_page_custom_text_display", "lmt_page_option", "lmt_page_option_section"); 
        add_settings_field("lmt_show_author_page_cb", "<label for='page-sa'>Display Last Modified Author Name:</label>", "lmt_show_author_page_cb_display", "lmt_page_option", "lmt_page_option_section");  
        
    // start dashboard fields
    add_settings_section("lmt_dashboard_option_section", "Dashboard Options<p><hr></p>", null, "lmt_dashboard_option");
        add_settings_field("lmt_enable_on_dashboard_cb", "<label for='dashboard-display'>Display Last Modified Info on Dashboard:</label>", "lmt_enable_on_dashboard_cb_display", "lmt_dashboard_option", "lmt_dashboard_option_section");  
        add_settings_field("lmt_enable_on_admin_bar_cb", "<label for='admin-bar-display'>Show Last Modified Info on Admin Bar:</label>", "lmt_enable_on_admin_bar_cb_display", "lmt_dashboard_option", "lmt_dashboard_option_section");
        add_settings_field("lmt_set_widget_post_num", "<label for='widget-post-no'>Posts to Show on Dashboard Widget:</label>", "lmt_set_widget_post_num_display", "lmt_dashboard_option", "lmt_dashboard_option_section");
        add_settings_field("lmt_custom_field_format", "<label for='custom-dtf'>Date/Time Format on Custom Field:</label>", "lmt_custom_field_format_display", "lmt_dashboard_option", "lmt_dashboard_option_section");
        
    // start template tags
    add_settings_section("lmt_template_tag_section", "Template Tags Options<p><hr></p>", null, "lmt_template_tag_option");
        add_settings_field("lmt_tt_enable_cb", "<label for='lmt-tt'>Enable Template Tags Functionality:</label>", "lmt_tt_enable_cb_display", "lmt_template_tag_option", "lmt_template_tag_section");  
        add_settings_field("lmt_enable_human_format_tt_cb", "<label for='lmt-tt-human'>Show as Human Readable Format:</label>", "lmt_enable_human_format_tt_cb_display", "lmt_template_tag_option", "lmt_template_tag_section");  
        add_settings_field("lmt_tt_set_format_box", "<label for='lmt-tt-format'>Last Modified date/time format:</label>", "lmt_tt_set_format_box_display", "lmt_template_tag_option", "lmt_template_tag_section");  
        add_settings_field("lmt_tt_updated_text_box", "<label for='lmt-tt-updated-text'>Custom Message before Modified Info:</label>", "lmt_tt_updated_text_box_display", "lmt_template_tag_option", "lmt_template_tag_section");  
        add_settings_field("lmt_show_author_tt_cb", "<label for='lmt-tt-sa'>Display Last Modified Author Name:</label>", "lmt_show_author_tt_cb_display", "lmt_template_tag_option", "lmt_template_tag_section");  
        add_settings_field("lmt_tt_class_box", "<label for='lmt-tt-class'>Set Custom CSS Class (if applicable):</label>", "lmt_tt_class_box_display", "lmt_template_tag_option", "lmt_template_tag_section");  
        
    // start custom css field
    add_settings_section("lmt_cus_style_section", "Custom CSS<p><hr></p>", null, "lmt_cus_style_option");
        add_settings_field("lmt_custom_style_box", "<label for='lmt-cus-style'>Write Custom CSS Here:</label>", "lmt_custom_style_box_display", "lmt_cus_style_option", "lmt_cus_style_section");  
    
    // register settings
    register_setting("lmt_post_page_plugin_section", "lmt_plugin_global_settings");

}

?>