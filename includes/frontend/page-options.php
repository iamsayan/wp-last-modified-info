<?php 
/**
 * Runs on Pages Frontend
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

add_action( 'init', 'lmt_plugin_init_page' );

function lmt_plugin_init_page() {

    $priority = 10;
    $priority = apply_filters( 'wplmi_display_priority_page', $priority );
    
    add_filter( 'the_content', 'lmt_print_last_modified_info_page', $priority );
}

function lmt_print_last_modified_info_page( $content ) {

    include( plugin_dir_path( __FILE__ ) . 'page.php' );

    if ( ! in_the_loop() ) {
        return $content;
    }

    if( get_the_modified_time('U') < get_the_time('U')+apply_filters( 'wplmi_date_time_diff_page', '0' ) ) {
        return $content;
    }

    if( isset($options['lmt_show_last_modified_time_date_page']) && ($options['lmt_show_last_modified_time_date_page'] == 'manual') ) {
        return $content;
    }

    if( isset( $modified_content ) ) {

        if( isset($options['lmt_show_last_modified_time_date_page']) && ($options['lmt_show_last_modified_time_date_page'] == 'before_content') ) {
            $fullcontent = $modified_content . $content;
        }
        elseif( isset($options['lmt_show_last_modified_time_date_page']) && ($options['lmt_show_last_modified_time_date_page'] == 'after_content') ) {
            $fullcontent = $content . $modified_content;
        }
    }

    if ( isset($fullcontent) && is_page() && !get_post_meta( get_the_ID(), '_lmt_disable', true ) == 'yes' ) { 
        return $fullcontent;
    }
    return $content;
}

?>