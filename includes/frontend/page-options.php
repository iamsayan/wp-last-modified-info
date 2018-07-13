<?php 
/**
 * Runs on Pages Frontend
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

add_filter( 'the_content', 'lmt_print_last_modified_info_page' );

function lmt_print_last_modified_info_page( $content ) {

    include 'page.php';

    if( isset($options['lmt_show_last_modified_time_date_page']) && ( $options['lmt_show_last_modified_time_date_page'] == 'Manual' ) ) {
        return $content;
    }

    if( is_page() && (get_the_modified_time('U') > get_the_time('U')) && isset($modified_content) ) {

        if( isset($options['lmt_show_last_modified_time_date_page']) && ($options['lmt_show_last_modified_time_date_page'] == 'Before Content') ) {
            $fullcontent = $modified_content . $content;
        }
        elseif( isset($options['lmt_show_last_modified_time_date_page']) && ($options['lmt_show_last_modified_time_date_page'] == 'After Content') ) {
            $fullcontent = $content . $modified_content;
        }
        elseif( isset($options['lmt_show_last_modified_time_date_page']) && ($options['lmt_show_last_modified_time_date_page'] == 'Manual') ) {
            $fullcontent = $modified_content;
        } 
    }

    if ( isset($fullcontent) && is_page() && !get_post_meta( get_the_ID(), '_lmt_disable', true ) == 'yes' ) { 
        return $fullcontent;
    }
    return $content;
}

?>