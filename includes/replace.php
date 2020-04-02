<?php 

/**
 * 
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

add_action( 'init', 'lmt_replace_old_post_date' );

// Handles find and replace on frontend
add_action( 'template_redirect', 'lmt_html_replace_ob' );
add_action( 'template_redirect', 'lmt_replace_published_date_with_mod_date' );

function lmt_html_replace_ob() {
    if( ! is_admin() ) {
        ob_start( 'lmt_html_replace_ob_callback' );
    }
}

function lmt_html_replace_ob_callback( $buffer ) {
    global $post;

    if ( ! is_object( $post ) ) return $buffer;

    if( ! is_singular() ) return $buffer;

    $options = get_option( 'lmt_plugin_global_settings' );

    $format = apply_filters( 'wplmi_replace_post_date_format', '' );
    $mod_format = apply_filters( 'wplmi_replace_post_modified_date_format', $format );

    $find = !empty( $options['lmt_tt_replace_published_date'] ) ? $options['lmt_tt_replace_published_date'] : '';
    $find = str_replace( "\r", "", $find );
    $find = str_replace( '%published_date%', get_the_date( $format ), $find );
    $find = str_replace( '%modified_date%', get_the_modified_date( $mod_format ), $find );
    $find = str_replace( '%post_link%', get_the_permalink(), $find );

    $buffer = str_replace( $find, html_entity_decode( get_the_last_modified_info() ), $buffer );
    
    return $buffer;
}

function lmt_replace_published_date_with_mod_date() {
    $options = get_option( 'lmt_plugin_global_settings' );
    if( isset( $options['lmt_enable_jsonld_markup_cb'] ) && ( $options['lmt_enable_jsonld_markup_cb'] == 'comp_mode' ) ) {
        if( !is_admin() ) {
            ob_start( 'lmt_replace_published_date_with_mod_date_ob_callback' );
        }
    }
}

function lmt_replace_published_date_with_mod_date_ob_callback( $buffer ) {
    global $post;

    if ( ! is_object( $post ) ) return $buffer;

    if( ! is_singular() ) return $buffer;

    // All in One SEO Pack Meta Compatibility
    $buffer = str_replace( date( 'Y-m-d\TH:i:s\Z', mysql2date( 'U', $post->post_date_gmt ) ), date( 'Y-m-d\TH:i:s\Z', mysql2date( 'U', $post->post_modified_gmt ) ), $buffer );
    // Yoast SEO Compatibility
    $buffer = str_replace( get_post_time( 'Y-m-d\TH:i:sP', true ), get_post_modified_time( 'Y-m-d\TH:i:sP', true ), $buffer );
    // Rank Math, All in One SEO Pack SEO & Newspaper theme Compatibility
    $buffer = str_replace( apply_filters( 'wplmi_custom_schema_post_date_fotmat', array( get_post_time( 'Y-m-d\TH:i:sP', false ), date( DATE_W3C, get_the_time('U') ), mysql2date( DATE_W3C, $post->post_modified_gmt, false ) ) ), get_post_modified_time( 'Y-m-d\TH:i:sP', false ), $buffer );
    
    return $buffer;
}

function lmt_replace_old_post_date() {
    $options = get_option('lmt_plugin_global_settings');
    if( isset( $options['lmt_replace_original_published_date'] ) && ( $options['lmt_replace_original_published_date'] == 1 ) ) {
        if( ! is_admin() ) {
            add_filter( 'get_the_time', 'lmt_replace_post_original_time', 10, 3 );
            add_filter( 'get_the_date', 'lmt_replace_post_original_date', 10, 3 );
        }
    }
}

// add action links
function lmt_replace_post_original_time( $the_time, $format, $post ) {
    return get_the_modified_time( $format, $post );
}


// add action links
function lmt_replace_post_original_date( $the_time, $format, $post ) {
    return get_the_modified_date( $format, $post );
}