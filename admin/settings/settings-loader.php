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
    // get custom public post types
    $post_types = get_post_types( array(
        'public'   => true,
        '_builtin' => false
    ), 'names' );

    // add post section
    add_settings_section('lmt_post_option', __( 'Post Options', 'wp-last-modified-info' ) . '<p><hr></p>', null, 'lmt_post_section');
        add_settings_field('lmt_enable_last_modified_cb',  __( 'Enable for Posts on Frontend:', 'wp-last-modified-info' ), 'lmt_enable_last_modified_cb_display', 'lmt_post_section', 'lmt_post_option', array( 'label_for' => 'post-enable' ));  
        add_settings_field('lmt_enable_schema_on_post_cb',  __( 'Enable Inline Schema Markup:', 'wp-last-modified-info' ), 'lmt_enable_schema_on_post_cb_display', 'lmt_post_section', 'lmt_post_option', array( 'label_for' => 'post-enable-schema', 'class' => 'post-enable-schema' ));  
        add_settings_field('lmt_show_last_modified_time_date_post',  __( 'Last Modified Info Display Method:', 'wp-last-modified-info' ), 'lmt_show_last_modified_time_date_post_display', 'lmt_post_section', 'lmt_post_option', array( 'label_for' => 'post-show-status' ));
        add_settings_field('lmt_post_custom_text',  __( 'Custom Message to Display on Posts:', 'wp-last-modified-info' ), 'lmt_post_custom_text_display', 'lmt_post_section', 'lmt_post_option', array( 'label_for' => 'post-custom-text' )); 
        add_settings_field('lmt_last_modified_format_post',  __( 'Last Modified Info Format for Posts:', 'wp-last-modified-info' ), 'lmt_last_modified_format_post_display', 'lmt_post_section', 'lmt_post_option', array( 'label_for' => 'post-format' ));  
        add_settings_field('lmt_last_modified_default_format_post',  __( 'Date and Time Visibility on Posts:', 'wp-last-modified-info' ), 'lmt_last_modified_default_format_post_display', 'lmt_post_section', 'lmt_post_option', array( 'label_for' => 'post-default-format', 'class' => 'post-default-format' ));  
        add_settings_field('lmt_gap_on_post',  __( 'Published Time & Modified Time Gap:', 'wp-last-modified-info' ), 'lmt_gap_on_post_display', 'lmt_post_section', 'lmt_post_option', array( 'label_for' => 'post-gap' ));  
        add_settings_field('lmt_show_author_cb',  __( 'Display Last Modified Author Name:', 'wp-last-modified-info' ), 'lmt_show_author_cb_display', 'lmt_post_section', 'lmt_post_option', array( 'label_for' => 'post-sa' ));  
        if( count( $post_types ) >= 1 ) {
            add_settings_field('lmt_custom_post_types_list',  __( 'Enable on this Custom Post Types:', 'wp-last-modified-info' ), 'lmt_custom_post_types_list_display', 'lmt_post_section', 'lmt_post_option', array( 'label_for' => 'cpt', 'class' => 'cpt' ));  
        }
        
    // add page section
    add_settings_section('lmt_page_option', __( 'Page Options', 'wp-last-modified-info' ) . '<p><hr></p>', null, 'lmt_page_section');    
        add_settings_field('lmt_enable_last_modified_page_cb', __( 'Enable for Pages on Frontend:', 'wp-last-modified-info' ), 'lmt_enable_last_modified_page_cb_display', 'lmt_page_section', 'lmt_page_option', array( 'label_for' => 'page-enable' ));  
        add_settings_field('lmt_enable_schema_on_page_cb',  __( 'Enable Inline Schema Markup:', 'wp-last-modified-info' ), 'lmt_enable_schema_on_page_cb_display', 'lmt_page_section', 'lmt_page_option', array( 'label_for' => 'page-enable-schema', 'class' => 'page-enable-schema' ));  
        add_settings_field('lmt_show_last_modified_time_date_page', __( 'Last Modified Info Display Method:', 'wp-last-modified-info' ), 'lmt_show_last_modified_time_date_page_display', 'lmt_page_section', 'lmt_page_option', array( 'label_for' => 'page-show-status' ));
        add_settings_field('lmt_page_custom_text', __( 'Custom Message to Display on Pages:', 'wp-last-modified-info' ), 'lmt_page_custom_text_display', 'lmt_page_section', 'lmt_page_option', array( 'label_for' => 'page-custom-text' )); 
        add_settings_field('lmt_last_modified_format_page',  __( 'Last Modified Info Format for Pages:', 'wp-last-modified-info' ), 'lmt_last_modified_format_page_display', 'lmt_page_section', 'lmt_page_option', array( 'label_for' => 'page-format' ));  
        add_settings_field('lmt_last_modified_default_format_page',  __( 'Date and Time Visibility on Pages:', 'wp-last-modified-info' ), 'lmt_last_modified_default_format_page_display', 'lmt_page_section', 'lmt_page_option', array( 'label_for' => 'page-default-format', 'class' => 'page-default-format' ));  
        add_settings_field('lmt_gap_on_page',  __( 'Published Time & Modified Time Gap:', 'wp-last-modified-info' ), 'lmt_gap_on_page_display', 'lmt_page_section', 'lmt_page_option', array( 'label_for' => 'page-gap' ));  
        add_settings_field('lmt_show_author_page_cb', __( 'Display Last Modified Author Name:', 'wp-last-modified-info' ), 'lmt_show_author_page_cb_display', 'lmt_page_section', 'lmt_page_option', array( 'label_for' => 'page-sa' ));  
        
    // add template tags section
    add_settings_section('lmt_template_tag_option', __( 'Template Tags Options', 'wp-last-modified-info' ) . '<p><hr></p>', null, 'lmt_template_tag_section');
        if( defined( 'GENERATE_VERSION' ) ) {
            add_settings_field('lmt_tt_generatepress_theme_mod', __( 'Enable GeneratePress Theme Support:', 'wp-last-modified-info' ), 'lmt_tt_generatepress_theme_mod_display', 'lmt_template_tag_section', 'lmt_template_tag_option', array( 'label_for' => 'lmt-tt-gpmod' ));  
        }
        if( defined( 'ASTRA_THEME_VERSION' ) ) {
            add_settings_field('lmt_tt_astra_theme_mod', __( 'Enable Astra Theme Support:', 'wp-last-modified-info' ), 'lmt_tt_astra_theme_mod_display', 'lmt_template_tag_section', 'lmt_template_tag_option', array( 'label_for' => 'lmt-tt-astramod' ));  
        }
        add_settings_field('lmt_tt_updated_text_box', __( 'Text before Last Modified Info:', 'wp-last-modified-info' ), 'lmt_tt_updated_text_box_display', 'lmt_template_tag_section', 'lmt_template_tag_option', array( 'label_for' => 'lmt-tt-updated-text' ));  
        add_settings_field('lmt_last_modified_format_tt',  __( 'Last Modified Info Format:', 'wp-last-modified-info' ), 'lmt_last_modified_format_tt_display', 'lmt_template_tag_section', 'lmt_template_tag_option', array( 'label_for' => 'tt-format' ));  
        add_settings_field('lmt_show_author_tt_cb', __( 'Display Last Modified Author Name:', 'wp-last-modified-info' ), 'lmt_show_author_tt_cb_display', 'lmt_template_tag_section', 'lmt_template_tag_option', array( 'label_for' => 'lmt-tt-sa' ));  
        add_settings_field('lmt_tt_class_box', __( 'Set Custom CSS Class (if required):', 'wp-last-modified-info' ), 'lmt_tt_class_box_display', 'lmt_template_tag_section', 'lmt_template_tag_option', array( 'label_for' => 'lmt-tt-class' ));  
        add_settings_field('lmt_tt_replace_published_date', __( 'Enter text or HTML to Replace:', 'wp-last-modified-info' ), 'lmt_tt_replace_published_date_display', 'lmt_template_tag_section', 'lmt_template_tag_option', array( 'label_for' => 'lmt-tt-replace' ));  
        
    // add schema section
    add_settings_section('lmt_schema_option', __( 'Schema Options', 'wp-last-modified-info' ) . '<p><hr></p>', null, 'lmt_schema_section');
        add_settings_field('lmt_enable_jsonld_markup_cb', __( 'JSON-LD Schema Markup Mode:', 'wp-last-modified-info' ), 'lmt_enable_jsonld_markup_cb_display', 'lmt_schema_section', 'lmt_schema_option', array( 'label_for' => 'schema-jsonld' ));
        add_settings_field('lmt_enable_jsonld_markup_post_types', __( 'Select Post Types for JSON-LD Markup:', 'wp-last-modified-info' ), 'lmt_enable_jsonld_markup_post_types_display', 'lmt_schema_section', 'lmt_schema_option', array( 'label_for' => 'schema-jsonld-pt', 'class' => 'schema-jsonld-pt' ));
        add_settings_field('lmt_enable_schema_support_cb', __( 'Enable Enhanced Schema Support:', 'wp-last-modified-info' ), 'lmt_enable_schema_support_cb_display', 'lmt_schema_section', 'lmt_schema_option', array( 'label_for' => 'schema-support', 'class' => 'schema-support' ));
        
    // add notification section
    add_settings_section('lmt_notification_option', __( 'Email Notification', 'wp-last-modified-info' ) . '<p><hr></p>', null, 'lmt_notification_section');
        add_settings_field('lmt_enable_notification_cb', __( 'Enable Notification on Post Update?', 'wp-last-modified-info' ), 'lmt_enable_notification_cb_display', 'lmt_notification_section', 'lmt_notification_option', array( 'label_for' => 'noti-enable' ));
        add_settings_field('lmt_enable_author_noti_cb', __( 'Send Notification to Post Author?', 'wp-last-modified-info' ), 'lmt_enable_author_noti_cb_display', 'lmt_notification_section', 'lmt_notification_option', array( 'label_for' => 'noti-author' ));  
        add_settings_field('lmt_enable_draft_noti_cb', __( 'Send Notification when Draft Changes?', 'wp-last-modified-info' ), 'lmt_enable_draft_noti_cb_display', 'lmt_notification_section', 'lmt_notification_option', array( 'label_for' => 'noti-draft' ));  
        add_settings_field('lmt_email_recipient', __( 'Send Email to these Email Recipient(s):', 'wp-last-modified-info' ), 'lmt_email_recipient_display', 'lmt_notification_section', 'lmt_notification_option', array( 'label_for' => 'noti-email-receive' ));  
        add_settings_field('lmt_enable_noti_post_types', __( 'Select Posts Types for Diff Detection:', 'wp-last-modified-info' ), 'lmt_enable_noti_post_types_display', 'lmt_notification_section', 'lmt_notification_option', array( 'label_for' => 'noti-pt' ));  
        add_settings_field('lmt_email_subject', __( 'Notification Email Subject:', 'wp-last-modified-info' ), 'lmt_email_subject_display', 'lmt_notification_section', 'lmt_notification_option', array( 'label_for' => 'email-sub' ));
        add_settings_field('lmt_email_message', __( 'Notification Email Message Body:', 'wp-last-modified-info' ), 'lmt_email_message_display', 'lmt_notification_section', 'lmt_notification_option', array( 'label_for' => 'email-msg' ));  

    // start custom css field
    add_settings_section('lmt_misc_option', __( 'Miscellaneous Options', 'wp-last-modified-info' ) . '<p><hr></p>', null, 'lmt_misc_section');
        add_settings_field('lmt_enable_on_admin_bar_cb', __( 'Show Modified Info on Admin Bar:', 'wp-last-modified-info' ), 'lmt_enable_on_admin_bar_cb_display', 'lmt_misc_section', 'lmt_misc_option', array( 'label_for' => 'admin-bar-display' ));
        add_settings_field('lmt_replace_original_published_date', __( 'Change Original Time to Modified Time:', 'wp-last-modified-info' ), 'lmt_replace_original_published_date_display', 'lmt_misc_section', 'lmt_misc_option', array( 'label_for' => 'lmt-replace' ));  
        add_settings_field('lmt_admin_default_sort_order', __( 'Default Admin Post Sorting Order:', 'wp-last-modified-info' ), 'lmt_admin_default_sort_order_display', 'lmt_misc_section', 'lmt_misc_option', array( 'label_for' => 'lmt-admin-order' ));  
        add_settings_field('lmt_default_sort_order', __( 'Default Frontend Post Sorting Order:', 'wp-last-modified-info' ), 'lmt_default_sort_order_display', 'lmt_misc_section', 'lmt_misc_option', array( 'label_for' => 'lmt-order' ));  
        add_settings_field('lmt_custom_style_box', __( 'Custom CSS Code:', 'wp-last-modified-info' ), 'lmt_custom_style_box_display', 'lmt_misc_section', 'lmt_misc_option', array( 'label_for' => 'lmt-cus-style' ));  
        add_settings_field('lmt_del_plugin_data_cb', __( 'Delete Plugin Data upon Uninstallation:', 'wp-last-modified-info' ), 'lmt_del_plugin_data_cb_display', 'lmt_misc_section', 'lmt_misc_option', array( 'label_for' => 'del-data' ));
        
    // register settings
    register_setting('lmt_post_page_plugin_section', 'lmt_plugin_global_settings');

}

?>