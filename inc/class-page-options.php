<?php 
/**
 * Runs on Pages Frontend
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

if( isset($options['lmt_use_as_sc_page_cb']) && ($options['lmt_use_as_sc_page_cb'] == 1 ) ) {
    add_shortcode('lmt-page-modified-info', 'lmt_print_last_modified_info_page');
} else {

    function lmt_page_exception_id() {
      
        $options = get_option('lmt_plugin_global_settings');
        if ( !is_page ( array_map('trim', explode(',', $options['lmt_page_disable_auto_insert'])) ) ) { 
            add_filter( 'the_content', 'lmt_print_last_modified_info_page' );
        }
    }

    add_action( 'wp', 'lmt_page_exception_id' );
    
}

function lmt_print_last_modified_info_page( $contentp ) {

    $options = get_option('lmt_plugin_global_settings');
    
    if(!empty($options['lmt_custom_page_time_format'])) {
        $updated_time_page = get_the_modified_time($options['lmt_custom_page_time_format']);
    } else {
        $updated_time_page = get_the_modified_time('h:i a');
    }
    
    if(!empty($options['lmt_custom_page_date_format'])) {
        $updated_day_page = get_the_modified_time($options['lmt_custom_page_date_format']);
    } else {
        $updated_day_page = get_the_modified_time('F jS, Y');
    }

    if(!empty($options['lmt_page_custom_text'])) {
        $options_page = get_option('lmt_plugin_global_settings')['lmt_page_custom_text'];
    } else {
        $options_page = 'Last Updated on ';
    }

    if(!empty($options['lmt_page_date_time_sep'])) {
        $options_page_sep = get_option('lmt_plugin_global_settings')['lmt_page_date_time_sep'];
    } else {
        $options_page_sep = 'at';
    }

   
if( isset($options['lmt_show_author_page_cb']) && ($options['lmt_show_author_page_cb'] == 'Do not show' ) ) {
    $lmt_page_uca = '';

} elseif( isset($options['lmt_show_author_page_cb']) && ($options['lmt_show_author_page_cb'] == 'Show only' ) ) {
    $lmt_page_uca = ' <span class="page-modified-author">by ' . get_the_modified_author() . '</span>';

} elseif( isset($options['lmt_show_author_page_cb']) && ($options['lmt_show_author_page_cb'] == 'Show with Link' ) ) {
    global $post;
        if ($id = get_post_meta($post->ID, '_edit_last', true)) {
            $lmt_page_uca = ' <span class="page-modified-author">by <a href="' . get_author_posts_url($id) . '" rel="author">' . get_the_modified_author() . '</a></span>';
        }
}

if( isset($options['lmt_enable_human_format_page_cb']) && ($options['lmt_enable_human_format_page_cb'] == 1 ) ) {

    $lmt_page_ut = human_time_diff(get_the_modified_time( 'U' ), current_time( 'U' )) . ' ago';
    $lmt_page_ud = '';
    $lmt_page_us = '';

} else {

    $lmt_page_ut = $updated_time_page;
    $lmt_page_ud = $updated_day_page;
    $lmt_page_us = ' '.$options_page_sep.' ';

} 
            
        
    if(isset($options_page) && (isset($lmt_page_ut) || isset($lmt_page_ud) || isset($lmt_page_us) || isset($lmt_page_uca))) {

        if( (isset($options['lmt_enable_last_modified_time_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_date_page_cb']) != 1) ) {

            $modified_content_page = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td">' . $lmt_page_ut . '</time>' . $lmt_page_uca . '</p>';
        
        } elseif( (isset($options['lmt_enable_last_modified_date_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_page_cb']) != 1) ) {

            $modified_content_page = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td">' . $lmt_page_ud . '</time>' . $lmt_page_uca . '</p>';

        } elseif( (isset($options['lmt_enable_last_modified_date_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_page_cb']) == 1) ) {

            $modified_content_page = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td">' . $lmt_page_ud . $lmt_page_us . $lmt_page_ut . '</time>' . $lmt_page_uca . '</p>';

        }

    }


    $options = get_option('lmt_plugin_global_settings');
    if( isset($options['lmt_show_last_modified_time_date_page']) && ($options['lmt_show_last_modified_time_date_page'] == 'Before Content') ) {
        if(get_the_modified_time('U') > get_the_time('U') && is_page() && isset($modified_content_page)) {
            $fullcontent_page = $modified_content_page . $contentp;
        } else {
            $fullcontent_page = $contentp;
        }
        return $fullcontent_page;
              
    } elseif( isset($options['lmt_show_last_modified_time_date_page']) && ($options['lmt_show_last_modified_time_date_page'] == 'After Content') ) {
        if(get_the_modified_time('U') > get_the_time('U') && is_page() && isset($modified_content_page)) {
            $fullcontent_page = $contentp . $modified_content_page;
        } else {
            $fullcontent_page = $contentp;
        }
        return $fullcontent_page;                           
    }
}


?>