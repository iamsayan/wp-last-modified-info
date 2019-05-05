<?php 

/**
 * 
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

// Handles find and replace on frontend
add_action( 'template_redirect', 'lmt_html_replace_ob' );

function lmt_html_replace_ob() {
    ob_start( 'lmt_html_replace_ob_callback' );
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