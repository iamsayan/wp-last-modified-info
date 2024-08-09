<?php
/**
 * External Functions.
 *
 * @since      1.8.0
 * @package    WP Last Modified Info
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

if ( ! function_exists( 'get_the_last_modified_info' ) ) {

    /**
     * Call the republish function directly
     *
     * @since 1.8.0
     * @param bool   $escape     Escape true|false
     * @param bool   $only_date  Return only date true|false
     */
    function get_the_last_modified_info( $escape = false, $only_date = false ) {
        $template = new \Wplmi\Core\Frontend\TemplateTags( compact( 'escape', 'only_date' ) );

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
     * @param bool   $escape   Escape true|false
     * @param bool   $date     Return only date true|false
     */
    function the_last_modified_info( $escape = false, $date = false ) {
        // displays/echos the last modified info.
        echo get_the_last_modified_info( $escape, $date ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
