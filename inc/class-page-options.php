<?php 
/**
 * Runs on Pages Frontend
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

if( isset($options['lmt_show_last_modified_time_date_page']) && ( $options['lmt_show_last_modified_time_date_page'] == 'Using Shortcode' ) ) {
    
    function lmt_hide_disablecb_onpage_using_css() { 
        $pt = get_current_screen()->post_type;
        if ( $pt == 'page' ) { ?>
            <style type="text/css">
                label[for="lmt_status"] {
                    display: none !important;
                }
            </style>
            <?php
        }
    }
    add_action('admin_print_styles-post.php', 'lmt_hide_disablecb_onpage_using_css', 10);
    add_action('admin_print_styles-post-new.php', 'lmt_hide_disablecb_onpage_using_css', 10);

} else {
    function lmt_page_exception_id() {
      
        global $post;
        //check if post is object otherwise you're not in singular post
        if( !is_object($post) ) 
        return;

        if ( is_page() && !get_post_meta( $post->ID, '_lmt_disable', true ) == 'yes' ) { 
            add_filter( 'the_content', 'lmt_print_last_modified_info_page' );
        }
    }
    add_action( 'wp', 'lmt_page_exception_id' );
}

function lmt_print_last_modified_info_page( $content ) {

    $options = get_option('lmt_plugin_global_settings');
    
    if(!empty($options['lmt_custom_page_time_format'])) {
        $updated_time_page = get_the_modified_time(esc_html($options['lmt_custom_page_time_format']));
    } else {
        $updated_time_page = get_the_modified_time('h:i a');
    }
    
    if(!empty($options['lmt_custom_page_date_format'])) {
        $updated_day_page = get_the_modified_time(esc_html($options['lmt_custom_page_date_format']));
    } else {
        $updated_day_page = get_the_modified_time('F jS, Y');
    }

    if(!empty($options['lmt_page_custom_text'])) {
        $options_page = esc_html(get_option('lmt_plugin_global_settings')['lmt_page_custom_text']);
    } else {
        $options_page = 'Last Updated on ';
    }

    if(!empty($options['lmt_page_date_time_sep'])) {
        $options_page_sep = esc_html(get_option('lmt_plugin_global_settings')['lmt_page_date_time_sep']);
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
        } else {
            $lmt_page_uca = '';
        }
    }       
        
    if(isset($options_page) && (isset($updated_time_page) || isset($updated_day_page) || isset($lmt_page_us) || isset($lmt_page_uca))) {

        if( isset($options['lmt_enable_human_format_page_cb']) && ($options['lmt_enable_human_format_page_cb'] == 1 ) ) {
            $modified_content_page = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td">' . human_time_diff(get_the_modified_time( 'U' ), current_time( 'U' )) . ' ago' . '</time>' . $lmt_page_uca . '</p>';
        } else {
            if( (isset($options['lmt_enable_last_modified_time_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_date_page_cb']) != 1) ) {
                $modified_content_page = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td">' . $updated_time_page . '</time>' . $lmt_page_uca . '</p>';
            } elseif( (isset($options['lmt_enable_last_modified_date_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_page_cb']) != 1) ) {
                $modified_content_page = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td">' . $updated_day_page . '</time>' . $lmt_page_uca . '</p>';
            } elseif( (isset($options['lmt_enable_last_modified_date_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_page_cb']) == 1) ) {
                $modified_content_page = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td">' . $updated_day_page . ' ' . $options_page_sep . ' ' . $updated_time_page . '</time>' . $lmt_page_uca . '</p>';
            }
        }
    }

    if( get_the_modified_time('U') > get_the_time('U') && is_page() && isset($modified_content_page) ) {

        if( isset($options['lmt_show_last_modified_time_date_page']) && ($options['lmt_show_last_modified_time_date_page'] == 'Before Content') ) {
        
            $fullcontent_page = $modified_content_page . $content;

        } elseif( isset($options['lmt_show_last_modified_time_date_page']) && ($options['lmt_show_last_modified_time_date_page'] == 'After Content') ) {
        
            $fullcontent_page = $content . $modified_content_page;
            
        } elseif( isset($options['lmt_show_last_modified_time_date_page']) && ($options['lmt_show_last_modified_time_date_page'] == 'Using Shortcode') ) {
        
            $fullcontent_page = $modified_content_page;
        } 
    } else {
        $fullcontent_page = $content;
    }
    return $fullcontent_page; 
}

add_shortcode('lmt-page-modified-info', 'lmt_print_last_modified_info_page');

?>