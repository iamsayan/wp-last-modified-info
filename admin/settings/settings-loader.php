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
    add_settings_section('lmt_post_option_section', __( 'Post Options', 'wp-lmi' ) . '<p><hr></p>', null, 'lmt_post_option');
        add_settings_field('lmt_enable_last_modified_cb',  __( 'Enable for Posts on Frontend:', 'wp-lmi' ), 'lmt_enable_last_modified_cb_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-enable' ));  
        add_settings_field('lmt_enable_human_format_cb',  __( 'Show as Human Readable Format:', 'wp-lmi' ), 'lmt_enable_human_format_cb_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-human' ));  
        add_settings_field('lmt_enable_last_modified_time_cb',  __( 'Show Last Modified Time on Posts:', 'wp-lmi' ), 'lmt_enable_last_modified_time_cb_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-enable-time', 'class' => 'post-time' ));  
        add_settings_field('lmt_enable_last_modified_date_cb',  __( 'Show Last Modified Date on Posts:', 'wp-lmi' ), 'lmt_enable_last_modified_date_cb_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-enable-date', 'class' => 'post-date' ));  
        add_settings_field('lmt_post_date_time_sep',  __( 'Date / Time Seperator on Posts:', 'wp-lmi' ), 'lmt_post_date_time_sep_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-dt-sep', 'class' => 'post-sep' )); 
        add_settings_field('lmt_show_last_modified_time_date_post',  __( 'Last Modified Info Display Method:', 'wp-lmi' ), 'lmt_show_last_modified_time_date_post_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-show-status' ));
        add_settings_field('lmt_post_custom_text',  __( 'Custom Message to Display on Posts:', 'wp-lmi' ), 'lmt_post_custom_text_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-custom-text' )); 
        add_settings_field('lmt_show_author_cb',  __( 'Display Last Modified Author Name:', 'wp-lmi' ), 'lmt_show_author_cb_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'post-sa' ));  
        add_settings_field('lmt_custom_post_types_list',  __( 'Include Custom Post Types (if any):', 'wp-lmi' ), 'lmt_custom_post_types_list_display', 'lmt_post_option', 'lmt_post_option_section', array( 'label_for' => 'cpt' ));  
        
    // start page fields
    add_settings_section('lmt_page_option_section', __( 'Page Options', 'wp-lmi' ) . '<p><hr></p>', null, 'lmt_page_option');    
        add_settings_field('lmt_enable_last_modified_page_cb', __( 'Enable for Pages on Frontend:', 'wp-lmi' ), 'lmt_enable_last_modified_page_cb_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-enable' ));  
        add_settings_field('lmt_enable_human_format_page_cb', __( 'Show as Human Readable Format:', 'wp-lmi' ), 'lmt_enable_human_format_page_cb_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-human' ));  
        add_settings_field('lmt_enable_last_modified_time_page_cb', __( 'Show Last Modified Time on Pages:', 'wp-lmi' ), 'lmt_enable_last_modified_time_page_cb_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-enable-time', 'class' => 'page-time' ));  
        add_settings_field('lmt_enable_last_modified_date_page_cb', __( 'Show Last Modified Date on Pages:', 'wp-lmi' ), 'lmt_enable_last_modified_date_page_cb_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-enable-date', 'class' => 'page-date' ));  
        add_settings_field('lmt_page_date_time_sep', __( 'Date / Time Seperator on Pages:', 'wp-lmi' ), 'lmt_page_date_time_sep_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-dt-sep', 'class' => 'page-sep' )); 
        add_settings_field('lmt_show_last_modified_time_date_page', __( 'Last Modified Info Display Method:', 'wp-lmi' ), 'lmt_show_last_modified_time_date_page_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-show-status' ));
        add_settings_field('lmt_page_custom_text', __( 'Custom Message to Display on Pages:', 'wp-lmi' ), 'lmt_page_custom_text_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-custom-text' )); 
        add_settings_field('lmt_show_author_page_cb', __( 'Display Last Modified Author Name:', 'wp-lmi' ), 'lmt_show_author_page_cb_display', 'lmt_page_option', 'lmt_page_option_section', array( 'label_for' => 'page-sa' ));  
            
    // start template tags
    add_settings_section('lmt_template_tag_section', __( 'Template Tags Options', 'wp-lmi' ) . '<p><hr></p>', null, 'lmt_template_tag_option');
        add_settings_field('lmt_tt_enable_cb', __( 'Enable Template Tags Functionality:', 'wp-lmi' ), 'lmt_tt_enable_cb_display', 'lmt_template_tag_option', 'lmt_template_tag_section', array( 'label_for' => 'lmt-tt' ));  
        add_settings_field('lmt_enable_human_format_tt_cb', __( 'Show as Human Readable Format:', 'wp-lmi' ), 'lmt_enable_human_format_tt_cb_display', 'lmt_template_tag_option', 'lmt_template_tag_section', array( 'label_for' => 'lmt-tt-human' ));  
        add_settings_field('lmt_tt_set_format_box', __( 'Last Modified date/time format:', 'wp-lmi' ), 'lmt_tt_set_format_box_display', 'lmt_template_tag_option', 'lmt_template_tag_section', array( 'label_for' => 'lmt-tt-format', 'class' => 'lmt-tt-format' ));  
        add_settings_field('lmt_tt_updated_text_box', __( 'Custom Message before Modified Info:', 'wp-lmi' ), 'lmt_tt_updated_text_box_display', 'lmt_template_tag_option', 'lmt_template_tag_section', array( 'label_for' => 'lmt-tt-updated-text' ));  
        add_settings_field('lmt_show_author_tt_cb', __( 'Display Last Modified Author Name:', 'wp-lmi' ), 'lmt_show_author_tt_cb_display', 'lmt_template_tag_option', 'lmt_template_tag_section', array( 'label_for' => 'lmt-tt-sa' ));  
        add_settings_field('lmt_tt_class_box', __( 'Set Custom CSS Class (if applicable):', 'wp-lmi' ), 'lmt_tt_class_box_display', 'lmt_template_tag_option', 'lmt_template_tag_section', array( 'label_for' => 'lmt-tt-class' ));  
        
    // start custom css field
    add_settings_section('lmt_misc_section', __( 'Miscellaneous Options', 'wp-lmi' ) . '<p><hr></p>', null, 'lmt_misc_option');
        add_settings_field('lmt_enable_on_admin_bar_cb', __( 'Show Modified Info on Admin Bar:', 'wp-lmi' ), 'lmt_enable_on_admin_bar_cb_display', 'lmt_misc_option', 'lmt_misc_section', array( 'label_for' => 'admin-bar-display' ));
        add_settings_field('lmt_custom_style_box', __( 'Write Custom CSS Here:', 'wp-lmi' ), 'lmt_custom_style_box_display', 'lmt_misc_option', 'lmt_misc_section', array( 'label_for' => 'lmt-cus-style' ));  
    
    // register settings
    register_setting('lmt_post_page_plugin_section', 'lmt_plugin_global_settings');

}

?>