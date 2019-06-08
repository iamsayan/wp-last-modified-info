<?php 

/**
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

 /**
 * Remove Genesis schema markups
 */

add_filter( 'genesis_attr_entry-time', 'lmt_genesis_schema_attributes_removal', 20 );
add_filter( 'genesis_attr_entry-modified-time',	'lmt_genesis_schema_attributes_removal', 20 );

function lmt_genesis_schema_attributes_removal( $attributes ) {
    $attributes['role']	= '';
    $attributes['itemprop']	= '';
    $attributes['itemscope'] = '';
    $attributes['itemtype'] = ''; 
        
    return $attributes;
}

/**
 * Remove GeneratePress and Astra schema markups
 */

add_filter( 'generate_post_date_output', 'lmt_generatepress_astra_theme_schema_fix' );
add_filter( 'astra_post_date', 'lmt_generatepress_astra_theme_schema_fix' );

function lmt_generatepress_astra_theme_schema_fix( $time_string ) {
    return str_replace( array( ' itemprop="datePublished"', ' itemprop="dateModified"' ), '', $time_string );
}