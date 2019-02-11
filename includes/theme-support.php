<?php 

/**
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

/**
 * GeneratePress Theme Support
 */

$options = get_option('lmt_plugin_global_settings');

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
add_action( 'template_redirect', 'lmt_remove_hentry_support_generatepress' );

function lmt_remove_hentry_support_generatepress() {
    ob_start();
    ob_start( 'lmt_remove_hentry_support_generatepress_ob_callback' );
}

function lmt_remove_hentry_support_generatepress_ob_callback( $buffer ) {
    if( defined( 'GENERATE_VERSION' ) ) {
        $buffer = str_replace( array( 'hfeed ', 'hentry ' ), '', $buffer );
    }
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