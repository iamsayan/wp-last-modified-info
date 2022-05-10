<?php
/**
 * External Functions.
 *
 * @since      1.8.0
 * @package    WP Last Modified Info
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

use Wplmi\Core\Frontend\TemplateTags;

if ( ! function_exists( 'get_the_last_modified_info' ) ) {

    /**
     * Call the republish function directly
     * 
     * @since 1.8.0
     * @param int    $post_id  Post ID
     * @param array  $args     Republish args
     */
    function get_the_last_modified_info( $escape = false, $only_date = false ) {
        $template = new TemplateTags( compact( 'escape', 'only_date' ) );

        return $template->output();
    }
}

/**
 * The code that prints the template tag output
 */
if ( ! function_exists( 'the_last_modified_info' ) ) {

    /**
     * Call the republish function directly
     * 
     * @since 1.8.0
     * @param int    $post_id  Post ID
     * @param array  $args     Republish args
     */
    function the_last_modified_info( $escape = false, $date = false ) {
        // displays/echos the last modified info.
        echo get_the_last_modified_info( $escape, $date );
    }
}