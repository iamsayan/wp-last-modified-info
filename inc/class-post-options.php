<?php 
/**
 * Runs on Posts Frontend
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

if( isset($options['lmt_use_as_sc_cb']) && ($options['lmt_use_as_sc_cb'] == 1 ) ) {
    add_shortcode('lmt-post-modified-info', 'lmt_print_last_modified_info_post');
} else {

    function lmt_post_exception_id() {
      
        $options = get_option('lmt_plugin_global_settings');
        if ( !is_single ( array_map('trim', explode(',', $options['lmt_post_disable_auto_insert'])) ) ) { 
            add_filter( 'the_content', 'lmt_print_last_modified_info_post' );
        }
    }

    add_action( 'wp', 'lmt_post_exception_id' );
    
}


function lmt_print_last_modified_info_post( $content ) {

    $options = get_option('lmt_plugin_global_settings');

    if(!empty($options['lmt_custom_post_time_format'])) {
        $updated_time = get_the_modified_time($options['lmt_custom_post_time_format']);
    } else {
        $updated_time = get_the_modified_time('h:i a');
    }

    if(!empty($options['lmt_custom_post_date_format'])) {
        $updated_day = get_the_modified_time($options['lmt_custom_post_date_format']);
    } else {
        $updated_day = get_the_modified_time('F jS, Y');
    }

    if(!empty($options['lmt_post_custom_text'])) {
        $options_post = get_option('lmt_plugin_global_settings')['lmt_post_custom_text'];
    } else {
        $options_post = 'Last Updated on ';
    }

    if(!empty($options['lmt_post_date_time_sep'])) {
        $options_post_sep = get_option('lmt_plugin_global_settings')['lmt_post_date_time_sep'];
    } else {
        $options_post_sep = 'at';
    }


if( isset($options['lmt_enable_human_format_cb']) && ($options['lmt_enable_human_format_cb'] == 1 ) ) {

    $lmt_post_ut = human_time_diff(get_the_modified_time( 'U' ), current_time( 'U' )) . ' ago';
    $lmt_post_ud = '';
    $lmt_post_us = '';

} else {

    $lmt_post_ut = $updated_time;
    $lmt_post_ud = $updated_day;
    $lmt_post_us = ' '.$options_post_sep.' ';

}       
        
    if(isset($options_post) && (isset($lmt_post_ud) || isset($lmt_post_ut) || isset($lmt_post_us))) {

        if( (isset($options['lmt_enable_last_modified_time_cb']) == 1) && (isset($options['lmt_enable_last_modified_date_cb']) != 1) ) {

            $modified_content = '<p class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $lmt_post_ut . '</time></p>';
        
        } elseif( (isset($options['lmt_enable_last_modified_date_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_cb']) != 1) ) {

            $modified_content = '<p class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $lmt_post_ud . '</time></p>';

        } elseif( (isset($options['lmt_enable_last_modified_date_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_cb']) == 1) ) {

            $modified_content = '<p class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $lmt_post_ud . $lmt_post_us . $lmt_post_ut . '</time></p>';

        }

    }

    $options = get_option('lmt_plugin_global_settings');
    if( isset($options['lmt_show_last_modified_time_date_post']) && ($options['lmt_show_last_modified_time_date_post'] == 'Before Content') ) {
        
        if(get_the_modified_time('U') > get_the_time('U') && is_single() && isset($modified_content)) {
            $fullcontent = $modified_content . $content;
        } else {
            $fullcontent = $content;
        }
        return $fullcontent;
              
    } elseif( isset($options['lmt_show_last_modified_time_date_post']) && ($options['lmt_show_last_modified_time_date_post'] == 'After Content') ) {
        if(get_the_modified_time('U') > get_the_time('U') && is_single() && isset($modified_content)) {
            $fullcontent = $content . $modified_content;
        } else {
            $fullcontent = $content;
        }
        return $fullcontent;             
    }
}

?>