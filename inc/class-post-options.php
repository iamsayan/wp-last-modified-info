<?php 
/**
 * Runs on Posts Frontend
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

if( isset($options['lmt_show_last_modified_time_date_post']) && ( $options['lmt_show_last_modified_time_date_post'] == 'Using Shortcode' ) ) {
    
    function lmt_hide_disablecb_using_css() { 
        $pt = get_current_screen()->post_type;
        if ( $pt != 'page' ) { ?>
            <style type="text/css">
                label[for="lmt_status"] {
                    display: none !important;
                }
            </style>
            <?php
        }
    }
    add_action('admin_print_styles-post.php', 'lmt_hide_disablecb_using_css', 10);
    add_action('admin_print_styles-post-new.php', 'lmt_hide_disablecb_using_css', 10);

} else {
    function lmt_post_exception_id() {
      
        $options = get_option('lmt_plugin_global_settings');

        global $post;
        //check if post is object otherwise you're not in singular post
        if( !is_object($post) ) 
        return;

       /* if( isset($options['lmt_enable_custom_post_types']) && ($options['lmt_enable_custom_post_types'] == 'Enable' ) ) {
            if ( !get_post_meta( $post->ID, '_lmt_disable', true ) == 'yes' ) { 
                add_filter( 'the_content', 'lmt_print_last_modified_info_post' );
            }
        } */
        if ( is_singular( 'post' ) && !get_post_meta( $post->ID, '_lmt_disable', true ) == 'yes' ) { 
            add_filter( 'the_content', 'lmt_print_last_modified_info_post' );
        }
        
        if( isset($options['lmt_enable_custom_post_types']) ) {
            $post_types = $options['lmt_enable_custom_post_types'];
            foreach($post_types as $item) {
                if ( is_singular( $item ) && !get_post_meta( $post->ID, '_lmt_disable', true ) == 'yes' ) { 
                    add_filter( 'the_content', 'lmt_print_last_modified_info_post' );
                }
            }
        }
    }
    add_action( 'wp', 'lmt_post_exception_id' );
}

function lmt_print_last_modified_info_post( $content ) {

    $options = get_option('lmt_plugin_global_settings');

    if(!empty($options['lmt_custom_post_time_format'])) {
        $updated_time = get_the_modified_time(esc_html($options['lmt_custom_post_time_format']));
    } else {
        $updated_time = get_the_modified_time('h:i a');
    }

    if(!empty($options['lmt_custom_post_date_format'])) {
        $updated_day = get_the_modified_time(esc_html($options['lmt_custom_post_date_format']));
    } else {
        $updated_day = get_the_modified_time('F jS, Y');
    }

    if(!empty($options['lmt_post_custom_text'])) {
        $options_post = esc_html(get_option('lmt_plugin_global_settings')['lmt_post_custom_text']);
    } else {
        $options_post = 'Last Updated on ';
    }

    if(!empty($options['lmt_post_date_time_sep'])) {
        $options_post_sep = esc_html(get_option('lmt_plugin_global_settings')['lmt_post_date_time_sep']);
    } else {
        $options_post_sep = 'at';
    }
   
    if( isset($options['lmt_show_author_cb']) && ($options['lmt_show_author_cb'] == 'Do not show' ) ) {
        $lmt_post_uca = '';
    } elseif( isset($options['lmt_show_author_cb']) && ($options['lmt_show_author_cb'] == 'Show only' ) ) {
        $lmt_post_uca = ' <span class="post-modified-author">by ' . get_the_modified_author() . '</span>';
    } elseif( isset($options['lmt_show_author_cb']) && ($options['lmt_show_author_cb'] == 'Show with Link' ) ) {
        global $post;
        if ($id = get_post_meta($post->ID, '_edit_last', true)) {
            $lmt_post_uca = ' <span class="post-modified-author">by <a href="' . get_author_posts_url($id) . '" rel="author">' . get_the_modified_author() . '</a></span>';
        } else {
            $lmt_post_uca = '';
        }
    }  
        
    if(isset($options_post) && (isset($updated_time) || isset($updated_day) || isset($lmt_post_uca) || isset($options_post_sep))) {

        if( isset($options['lmt_enable_human_format_cb']) && ($options['lmt_enable_human_format_cb'] == 1 ) ) {
            $modified_content = '<p class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . human_time_diff(get_the_modified_time( 'U' ), current_time( 'U' )) . ' ago' . '</time>' . $lmt_post_uca . '</p>';
        } else {
            if( (isset($options['lmt_enable_last_modified_time_cb']) == 1) && (isset($options['lmt_enable_last_modified_date_cb']) != 1) ) {
                $modified_content = '<p class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $updated_time . '</time>' . $lmt_post_uca . '</p>';
            } elseif( (isset($options['lmt_enable_last_modified_date_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_cb']) != 1) ) {
                $modified_content = '<p class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $updated_day . '</time>' . $lmt_post_uca . '</p>';
            } elseif( (isset($options['lmt_enable_last_modified_date_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_cb']) == 1) ) {
                $modified_content = '<p class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $updated_day . ' ' . $options_post_sep . ' ' . $updated_time . '</time>' . $lmt_post_uca . '</p>';
            }
        }
    }

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

    } elseif( isset($options['lmt_show_last_modified_time_date_post']) && ($options['lmt_show_last_modified_time_date_post'] == 'Do not show') ) {
        
        if(get_the_modified_time('U') > get_the_time('U') && is_single() && isset($modified_content)) {
            $fullcontent = $modified_content;
        } else {
            $fullcontent = $content;
        }
        return $fullcontent;   
    }
}

add_shortcode('lmt-post-modified-info', 'lmt_print_last_modified_info_post');

?>