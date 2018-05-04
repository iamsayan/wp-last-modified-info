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
    
                if($options['lmt_custom_page_time_format']) {
                    $updated_time_page = get_the_modified_time($options['lmt_custom_page_time_format']);
                } else {
                    $updated_time_page = get_the_modified_time('h:i a');
                }
    
                if($options['lmt_custom_page_date_format']) {
                    $updated_day_page = get_the_modified_time($options['lmt_custom_page_date_format']);
                } else {
                    $updated_day_page = get_the_modified_time('F jS, Y');
                }
            
        
            if((isset($options['lmt_page_custom_text'])) == get_option('lmt_plugin_global_settings')['lmt_page_custom_text']) {

                $options_page = get_option('lmt_plugin_global_settings')['lmt_page_custom_text'];
                if( (isset($options['lmt_enable_last_modified_time_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_date_page_cb']) != 1) ) {

                    $modified_content_page = '<p class="page-last-modified">' . $options_page . ' <span class="page-last-modified-td">' . $updated_time_page . '</span></p>';
        
                } elseif( (isset($options['lmt_enable_last_modified_date_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_page_cb']) != 1) ) {

                    $modified_content_page = '<p class="page-last-modified">' . $options_page . ' <span class="page-last-modified-td">' . $updated_day_page . '</span></p>';

                } elseif( (isset($options['lmt_enable_last_modified_date_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_page_cb']) == 1) ) {

                    $modified_content_page = '<p class="page-last-modified">' . $options_page . ' <span class="page-last-modified-td">' . $updated_day_page . ' at ' . $updated_time_page . '</span></p>';

                }

            } else {
              
                if( (isset($options['lmt_enable_last_modified_time_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_date_page_cb']) != 1) ) {

                    $modified_content_page = '<p class="page-last-modified">Last Updated on <span class="page-last-modified-td">' . $updated_time_page . '</span></p>';
        
                } elseif( (isset($options['lmt_enable_last_modified_date_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_page_cb']) != 1) ) {

                    $modified_content_page = '<p class="page-last-modified">Last Updated on <span class="page-last-modified-td">' . $updated_day_page . '</span></p>';

                } elseif( (isset($options['lmt_enable_last_modified_date_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_page_cb']) == 1) ) {

                    $modified_content_page = '<p class="page-last-modified">Last Updated on <span class="page-last-modified-td">' . $updated_day_page . ' at ' . $updated_time_page . '</span></p>';

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