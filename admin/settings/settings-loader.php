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
    add_settings_section('lmt_post_option_section', __( 'Post Options', 'wp-last-modified-info' ) . '<p><hr></p>', null, 'lmt_post_option');
        add_settings_field('lmt_enable_last_modified_cb',  __( 'Enable for Posts on Frontend:', 'wp-last-modified-info' ), 'lmt_enable_last_modified_cb_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-enable' ));  
        add_settings_field('lmt_enable_schema_on_post_cb',  __( 'Last Modified Schema Markup Type:', 'wp-last-modified-info' ), 'lmt_enable_schema_on_post_cb_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-enable-schema' ));  
        add_settings_field('lmt_show_last_modified_time_date_post',  __( 'Last Modified Info Display Method:', 'wp-last-modified-info' ), 'lmt_show_last_modified_time_date_post_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-show-status' ));
        add_settings_field('lmt_post_custom_text',  __( 'Custom Message to Display on Posts:', 'wp-last-modified-info' ), 'lmt_post_custom_text_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-custom-text' )); 
        add_settings_field('lmt_last_modified_format_post',  __( 'Last Modified Info Format for Posts:', 'wp-last-modified-info' ), 'lmt_last_modified_format_post_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-format' ));  
        add_settings_field('lmt_last_modified_default_format_post',  __( 'Date and Time Visibility on Posts:', 'wp-last-modified-info' ), 'lmt_last_modified_default_format_post_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-default-format', 'class' => 'post-default-format' ));  
        add_settings_field('lmt_show_author_cb',  __( 'Display Last Modified Author Name:', 'wp-last-modified-info' ), 'lmt_show_author_cb_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-sa' ));  
        add_settings_field('lmt_custom_post_types_list',  __( 'Include Custom Post Types (if required):', 'wp-last-modified-info' ), 'lmt_custom_post_types_list_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'cpt', 'class' => 'cpt' ));  
        
    // start page fields
    add_settings_section('lmt_page_option_section', __( 'Page Options', 'wp-last-modified-info' ) . '<p><hr></p>', null, 'lmt_page_option');    
        add_settings_field('lmt_enable_last_modified_page_cb', __( 'Enable for Pages on Frontend:', 'wp-last-modified-info' ), 'lmt_enable_last_modified_page_cb_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-enable' ));  
        add_settings_field('lmt_enable_schema_on_page_cb',  __( 'Last Modified Schema Markup Type:', 'wp-last-modified-info' ), 'lmt_enable_schema_on_page_cb_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-enable-schema' ));  
        add_settings_field('lmt_show_last_modified_time_date_page', __( 'Last Modified Info Display Method:', 'wp-last-modified-info' ), 'lmt_show_last_modified_time_date_page_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-show-status' ));
        add_settings_field('lmt_page_custom_text', __( 'Custom Message to Display on Pages:', 'wp-last-modified-info' ), 'lmt_page_custom_text_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-custom-text' )); 
        add_settings_field('lmt_last_modified_format_page',  __( 'Last Modified Info Format for Pages:', 'wp-last-modified-info' ), 'lmt_last_modified_format_page_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-format' ));  
        add_settings_field('lmt_last_modified_default_format_page',  __( 'Date and Time Visibility on Pages:', 'wp-last-modified-info' ), 'lmt_last_modified_default_format_page_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-default-format', 'class' => 'page-default-format' ));  
        add_settings_field('lmt_show_author_page_cb', __( 'Display Last Modified Author Name:', 'wp-last-modified-info' ), 'lmt_show_author_page_cb_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-sa' ));  
        
    // start template tags
    add_settings_section('lmt_template_tag_section', __( 'Template Tags Options', 'wp-last-modified-info' ) . '<p><hr></p>', null, 'lmt_template_tag_option');
        add_settings_field('lmt_tt_updated_text_box', __( 'Custom Message before Modified Info:', 'wp-last-modified-info' ), 'lmt_tt_updated_text_box_display', 'lmt_template_tag_option', 'lmt_template_tag_section', array( 'label_for' => 'lmt-tt-updated-text' ));  
        add_settings_field('lmt_last_modified_format_tt',  __( 'Last Modified Info Format:', 'wp-last-modified-info' ), 'lmt_last_modified_format_tt_display', 'lmt_template_tag_option', 'lmt_template_tag_section', array( 'label_for' => 'tt-format' ));  
        add_settings_field('lmt_show_author_tt_cb', __( 'Display Last Modified Author Name:', 'wp-last-modified-info' ), 'lmt_show_author_tt_cb_display', 'lmt_template_tag_option', 'lmt_template_tag_section', array( 'label_for' => 'lmt-tt-sa' ));  
        add_settings_field('lmt_tt_class_box', __( 'Set Custom CSS Class (if applicable):', 'wp-last-modified-info' ), 'lmt_tt_class_box_display', 'lmt_template_tag_option', 'lmt_template_tag_section', array( 'label_for' => 'lmt-tt-class' ));  
        
    // start custom css field
    add_settings_section('lmt_misc_section', __( 'Miscellaneous Options', 'wp-last-modified-info' ) . '<p><hr></p>', null, 'lmt_misc_option');
        add_settings_field('lmt_enable_on_admin_bar_cb', __( 'Show Modified Info on Admin Bar:', 'wp-last-modified-info' ), 'lmt_enable_on_admin_bar_cb_display', 'lmt_misc_option', 'lmt_misc_section', array( 'label_for' => 'admin-bar-display' ));
        add_settings_field('lmt_enable_schema_support_cb', __( 'Enable Enhanced Schema Support:', 'wp-last-modified-info' ), 'lmt_enable_schema_support_cb_display', 'lmt_misc_option', 'lmt_misc_section', array( 'label_for' => 'schema-support' ));
        add_settings_field('lmt_custom_style_box', __( 'Custom CSS Code:', 'wp-last-modified-info' ), 'lmt_custom_style_box_display', 'lmt_misc_option', 'lmt_misc_section', array( 'label_for' => 'lmt-cus-style' ));  
        add_settings_field('lmt_del_plugin_data_cb', __( 'Delete Plugin Data upon Uninstallation:', 'wp-last-modified-info' ), 'lmt_del_plugin_data_cb_display', 'lmt_misc_option', 'lmt_misc_section', array( 'label_for' => 'del-data' ));
        
    // register settings
    register_setting('lmt_post_page_plugin_section', 'lmt_plugin_global_settings');

}

?>