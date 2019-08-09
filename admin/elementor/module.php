<?php

/**
 * Elementor Dynamic Tags Support
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @since     v1.2.0
 * @license   http://www.gnu.org/licenses/gpl.html
 */

if( function_exists( '_is_elementor_installed' ) && defined( 'ELEMENTOR_PRO_VERSION' ) ) {

    add_action( 'elementor/frontend/the_content', 'lmt_disable_schema_markup_conversion_unicode' );

    add_action( 'elementor/widget/render_content', 'lmt_disable_schema_markup_conversion_unicode' );

    add_action( 'elementor/dynamic_tags/register_tags', function( $dynamic_tags ) {
    	// register that group as well before the tag
    	\Elementor\Plugin::$instance->dynamic_tags->register_group( 'wplmi-module', [
    		'title' => __( 'WP Last Modified Info', 'wp-last-modified-info' )
    	] );
    
    	// Include the Dynamic tag class files
        include_once( plugin_dir_path( __FILE__ ) . 'class/modified-date.php' );
        include_once( plugin_dir_path( __FILE__ ) . 'class/modified-time.php' );
        include_once( plugin_dir_path( __FILE__ ) . 'class/modified-author.php' );
        include_once( plugin_dir_path( __FILE__ ) . 'class/modified-author-url.php' );
    
    	// Finally register the tags
        $dynamic_tags->register_tag( 'WPLMI_Elementor_Register_Dynamic_Date_Tag' );
        $dynamic_tags->register_tag( 'WPLMI_Elementor_Register_Dynamic_Time_Tag' );
        $dynamic_tags->register_tag( 'WPLMI_Elementor_Register_Dynamic_Author_Tag' );
        $dynamic_tags->register_tag( 'WPLMI_Elementor_Register_Dynamic_Author_URL_Tag' );
        
    } );

    add_action( 'elementor/query/wplmi_elementor_widget_query_filter', function( $query ) {
	    // ordered by post modified date
	    $query->set( 'orderby', 'modified' );
    } );

}

function lmt_disable_schema_markup_conversion_unicode( $content ) {
    $before_raw = '</time itemprop=/"dateModified/" datetime=/"'. get_post_modified_time( 'Y-m-d\TH:i:sP', true ) .'/">';
    $after_raw = '<//time>';

    $before = htmlentities( $before_raw );
    $after = htmlentities( $after_raw );

    $before_replace = str_replace( '/', '', html_entity_decode( $before_raw ) );
    $after_replace = str_replace( '//', '/', html_entity_decode( $after_raw ) );

    $content = str_replace( $before, $before_replace, $content );
    $content = str_replace( $after, $after_replace, $content );
    
    return $content;
}