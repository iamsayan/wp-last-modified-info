<?php 

if( isset($options['lmt_use_as_sc_cb']) && ($options['lmt_use_as_sc_cb'] == 1 ) ) {
    add_shortcode('lmt-post-modified-info', 'lmt_print_last_modified_info_post');
} else {
   add_filter( 'the_content', 'lmt_print_last_modified_info_post' );
}
    function lmt_print_last_modified_info_post( $content ) {

        $options = get_option('lmt_plugin_global_settings');

            if($options['lmt_custom_post_time_format']) {
                $updated_time = get_the_modified_time(get_option('lmt_plugin_global_settings')['lmt_custom_post_time_format']);
            } else {
                $updated_time = get_the_modified_time('h:i a');
            }


            if($options['lmt_custom_post_date_format']) {
                $updated_day = get_the_modified_time(get_option('lmt_plugin_global_settings')['lmt_custom_post_date_format']);
            } else {
                $updated_day = get_the_modified_time('F jS, Y');
            }
        
            
        
            if((isset($options['lmt_post_custom_text'])) == get_option('lmt_plugin_global_settings')['lmt_post_custom_text']) {

                $options_post = get_option('lmt_plugin_global_settings')['lmt_post_custom_text'];
                if( (isset($options['lmt_enable_last_modified_time_cb']) == 1) && (isset($options['lmt_enable_last_modified_date_cb']) != 1) ) {

                    $modified_content = '<p class="post-last-modified">' . $options_post . ' <span class="post-last-modified-td">' . $updated_time . '</span></p>';
        
                } elseif( (isset($options['lmt_enable_last_modified_date_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_cb']) != 1) ) {

                    $modified_content = '<p class="post-last-modified">' . $options_post . ' <span class="post-last-modified-td">' . $updated_day . '</span></p>';

                } elseif( (isset($options['lmt_enable_last_modified_date_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_cb']) == 1) ) {

                    $modified_content = '<p class="post-last-modified">' . $options_post . ' <span class="post-last-modified-td">' . $updated_day . ' at ' . $updated_time . '</span></p>';

                }

            } else {
              
                if( (isset($options['lmt_enable_last_modified_time_cb']) == 1) && (isset($options['lmt_enable_last_modified_date_cb']) != 1) ) {

                    $modified_content = '<p class="post-last-modified">Last Updated on <span class="post-last-modified-td">' . $updated_time . '</span></p>';
        
                } elseif( (isset($options['lmt_enable_last_modified_date_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_cb']) != 1) ) {

                    $modified_content = '<p class="post-last-modified">Last Updated on <span class="post-last-modified-td">' . $updated_day . '</span></p>';

                } elseif( (isset($options['lmt_enable_last_modified_date_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_cb']) == 1) ) {

                    $modified_content = '<p class="post-last-modified">Last Updated on <span class="post-last-modified-td">' . $updated_day . ' at ' . $updated_time . '</span></p>';

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