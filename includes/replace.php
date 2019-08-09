<?php 

/**
 * 
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

// Handles find and replace on frontend
if( apply_filters( 'wplmi_switch_global_replace_hook', false ) ) {
    // add into init action hook
    add_action( 'init', 'lmt_html_replace_ob', 1 );
    add_action( 'init', 'lmt_replace_published_date_with_mod_date', 1 );
} else {
    add_action( 'template_redirect', 'lmt_html_replace_ob' );
    add_action( 'template_redirect', 'lmt_replace_published_date_with_mod_date' );
}

function lmt_html_replace_ob() {
    if( ! is_admin() ) {
        ob_start( 'lmt_html_replace_ob_callback' );
    }
}

function lmt_html_replace_ob_callback( $buffer ) {
    $options = get_option('lmt_plugin_global_settings');

    $format = apply_filters( 'wplmi_replace_post_date_format', '' );

    $find = !empty($options['lmt_tt_replace_published_date']) ? $options['lmt_tt_replace_published_date'] : '';
    $find = str_replace( "\r", "", $find );
    $find = str_replace( '%published_date%', get_the_date( $format ), $find );
    $find = str_replace( '%modified_date%', get_the_modified_date( $format ), $find );

    $buffer = str_replace( $find, html_entity_decode( get_the_last_modified_info() ), $buffer );
    
    return $buffer;
}

function lmt_replace_published_date_with_mod_date() {
    $options = get_option('lmt_plugin_global_settings');
    
    if( isset($options['lmt_enable_jsonld_markup_cb']) && ($options['lmt_enable_jsonld_markup_cb'] == 'comp_mode') && !is_admin() ) {
        ob_start( 'lmt_replace_published_date_with_mod_date_ob_callback' );
    }
}

function lmt_replace_published_date_with_mod_date_ob_callback( $buffer ) {
    $buffer = str_replace( apply_filters( 'wplmi_custom_schema_post_date_fotmat', array( get_post_time( 'Y-m-d\TH:i:sP', true ), get_the_time('c'), date( DATE_W3C, get_the_time('U') ) ) ), get_post_modified_time( 'Y-m-d\TH:i:sP', true ), $buffer );
    
    return $buffer;
}