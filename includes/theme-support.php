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
    add_filter( 'generate_post_date', 'lmt_generatepress_theme_replace_meta' );
    add_filter( 'generate_post_author', '__return_false' );
}

function lmt_generatepress_theme_replace_meta() { 
    echo get_the_last_modified_info();
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