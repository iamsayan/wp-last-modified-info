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
    if($options['lmt_custom_post_time_format']) {
        $updated_time = get_the_modified_time($options['lmt_custom_post_time_format']);
    } else {
        $updated_time = get_the_modified_time('h:i a');
    }


    if($options['lmt_custom_post_date_format']) {
        $updated_day = get_the_modified_time($options['lmt_custom_post_date_format']);
    } else {
        $updated_day = get_the_modified_time('F jS, Y');
    }
                   
        
    if((isset($options['lmt_post_custom_text'])) == get_option('lmt_plugin_global_settings')['lmt_post_custom_text']) {

        $options_post = get_option('lmt_plugin_global_settings')['lmt_post_custom_text'];
        if( (isset($options['lmt_enable_last_modified_time_cb']) == 1) && (isset($options['lmt_enable_last_modified_date_cb']) != 1) ) {

            $modified_content = '<p class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $updated_time . '</time></p>';
        
        } elseif( (isset($options['lmt_enable_last_modified_date_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_cb']) != 1) ) {

            $modified_content = '<p class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $updated_day . '</time></p>';

        } elseif( (isset($options['lmt_enable_last_modified_date_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_cb']) == 1) ) {

            $modified_content = '<p class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $updated_day . ' at ' . $updated_time . '</time></p>';

        }

    } else {
              
        if( (isset($options['lmt_enable_last_modified_time_cb']) == 1) && (isset($options['lmt_enable_last_modified_date_cb']) != 1) ) {

            $modified_content = '<p class="post-last-modified">Last Updated on <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $updated_time . '</time></p>';
        
        } elseif( (isset($options['lmt_enable_last_modified_date_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_cb']) != 1) ) {

            $modified_content = '<p class="post-last-modified">Last Updated on <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $updated_day . '</time></p>';

        } elseif( (isset($options['lmt_enable_last_modified_date_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_cb']) == 1) ) {

            $modified_content = '<p class="post-last-modified">Last Updated on <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $updated_day . ' at ' . $updated_time . '</time></p>';

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