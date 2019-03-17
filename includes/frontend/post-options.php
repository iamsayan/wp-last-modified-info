<?php 
/**
 * Runs on Posts Frontend
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

add_action( 'init', 'lmt_plugin_init_post' );

function lmt_plugin_init_post() {

    $priority = 10;
    $priority = apply_filters( 'wplmi_display_priority_post', $priority );
    
    add_filter( 'the_content', 'lmt_print_last_modified_info_post', $priority );
}

function lmt_print_last_modified_info_post( $content ) {

    include( plugin_dir_path( __FILE__ ) . 'post.php' );

    $gap = 0;
    if( isset($options['lmt_gap_on_post']) ) {
        $gap = $options['lmt_gap_on_post'];
    }
    $gap = apply_filters( 'wplmi_date_time_diff_post', $gap );

    if ( ! in_the_loop() ) {
        return $content;
    }

    if( get_the_modified_time('U') < ( get_the_time('U') + $gap ) ) {
        return $content;
    }

    if( isset($options['lmt_show_last_modified_time_date_post']) && ($options['lmt_show_last_modified_time_date_post'] == 'manual') ) {    
        return $content;
    }

    if( isset( $modified_content ) ) {
        if( isset($options['lmt_show_last_modified_time_date_post']) && ($options['lmt_show_last_modified_time_date_post'] == 'before_content') ) {
            $fullcontent = $modified_content . $content; 
        }
        elseif( isset($options['lmt_show_last_modified_time_date_post']) && ($options['lmt_show_last_modified_time_date_post'] == 'after_content') ) {
            $fullcontent = $content . $modified_content;
        }
    } 

    if ( isset( $fullcontent ) && is_singular( 'post' ) && !get_post_meta( get_the_ID(), '_lmt_disable', true ) == 'yes' ) { 
        if( apply_filters( 'wplmi_disable_post_output', false ) ) {
            return $content;
        }
        return $fullcontent;
    }

    if( isset($options['lmt_show_on_homepage']) && ($options['lmt_show_on_homepage'] == 'yes') ) {
        if ( isset( $fullcontent ) && ( is_home() && apply_filters( 'wplmi_enable_home_page', true ) || is_author() && apply_filters( 'wplmi_enable_author_archive', true ) || is_category() && apply_filters( 'wplmi_enable_category_archive', true ) || is_tag() && apply_filters( 'wplmi_enable_tag_archive', true ) ) && !get_post_meta( get_the_ID(), '_lmt_disable', true ) == 'yes' ) { 
            return $fullcontent;
        }
    }

    if( isset($options['lmt_custom_post_types_list']) ) {
        $post_types = $options['lmt_custom_post_types_list'];
        //foreach( $post_types as $post_type ) {
            if ( isset( $fullcontent ) && is_singular( $post_types ) && !get_post_meta( get_the_ID(), '_lmt_disable', true ) == 'yes' ) { 
                return $fullcontent;
            }
        //}
    }
    return $content;
}

?>