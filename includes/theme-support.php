<?php 

/**
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

$options = get_option('lmt_plugin_global_settings');

/**
 * GeneratePress Theme Support
 */
if( isset($options['lmt_tt_generatepress_theme_mod']) && ($options['lmt_tt_generatepress_theme_mod'] == 'replace') ) {
    add_filter( 'generate_post_date_output', 'lmt_generatepress_theme_replace_meta' );
    add_filter( 'generate_post_author_output', 'lmt_generatepress_theme_replace_author_meta' );
}

function lmt_generatepress_theme_replace_meta() {
	return get_the_last_modified_info();
}

function lmt_generatepress_theme_replace_author_meta() { 
    return '';
}

// Handles hentry find and replace on frontend
if( apply_filters( 'wplmi_switch_global_replace_hook', false ) ) {
    add_action( 'init', 'lmt_remove_hentry_support_generatepress', 1 );
} else {
    add_action( 'template_redirect', 'lmt_remove_hentry_support_generatepress' );
}

function lmt_remove_hentry_support_generatepress() {
    if( defined( 'GENERATE_VERSION' ) && !is_admin() ) {
        ob_start( 'lmt_remove_hentry_support_generatepress_ob_callback' );
    }
}

function lmt_remove_hentry_support_generatepress_ob_callback( $buffer ) {
    $buffer = str_replace( array( 'hfeed ', 'hentry ' ), '', $buffer );
    
    return $buffer;
}

/**
 * Display only last modified date in the post metadata.
 *
 * @param String $output Markup for the last modified date.
 * @return void
 */
if( isset($options['lmt_tt_astra_theme_mod']) && ($options['lmt_tt_astra_theme_mod'] == 'replace') ) {
	add_filter( 'astra_post_date', 'lmt_astra_modified_post_date' );
}

function lmt_astra_modified_post_date( $output ) {
	$output = '';
	$output .= '<span class="posted-on">';
	$output .= '<span class="post-updated"> ' . get_the_last_modified_info() . '</span>';
    $output .= '</span>';
    
	return $output;
}