<?php 
/**
 * Runs on Posts Frontend
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

$options = get_option('lmt_plugin_global_settings');

if(!empty($options['lmt_custom_post_time_format'])) {
    $updated_time = get_the_modified_time(esc_html($options['lmt_custom_post_time_format']));
}
else {
    $updated_time = get_the_modified_time('h:i a');
}

if(!empty($options['lmt_custom_post_date_format'])) {
    $updated_day = get_the_modified_time(esc_html($options['lmt_custom_post_date_format']));
}
else {
    $updated_day = get_the_modified_time('F jS, Y');
}

if(!empty($options['lmt_post_custom_text'])) {
    $options_post = esc_html(get_option('lmt_plugin_global_settings')['lmt_post_custom_text']);
}
else {
    $options_post = 'Last Updated on ';
}

if(!empty($options['lmt_post_date_time_sep'])) {
    $options_post_sep = esc_html(get_option('lmt_plugin_global_settings')['lmt_post_date_time_sep']);
}
else {
    $options_post_sep = 'at';
}
   
if( isset($options['lmt_show_author_cb']) && ($options['lmt_show_author_cb'] == 'Do not show' ) ) {
    $lmt_post_uca = '';
}
elseif( isset($options['lmt_show_author_cb']) && ($options['lmt_show_author_cb'] == 'Default' ) ) {
        
    $author_id = get_post_meta(get_the_ID(), '_edit_last', true);
    if( isset($options['lmt_enable_author_hyperlink']) && ($options['lmt_enable_author_hyperlink'] == 1 ) ) {
        $lmt_post_uca = ' by <span class="post-modified-author"><a href="' . get_author_posts_url($author_id) . '" target="_blank" rel="author">' . get_the_modified_author() . '</a></span>';
    }
    else {
        $lmt_post_uca = ' by <span class="post-modified-author">' . get_the_modified_author() . '</span>';
    }
} 
elseif( isset($options['lmt_show_author_cb']) && ($options['lmt_show_author_cb'] == 'Custom' ) ) {
        
    $get_author = $options['lmt_show_author_list'];
    $theauthor = get_user_by( 'id', $get_author );
    if( isset($options['lmt_enable_author_hyperlink']) && ($options['lmt_enable_author_hyperlink'] == 1 ) ) {
        $lmt_post_uca = ' by <span class="post-modified-author"><a href="' . get_author_posts_url($get_author) . '" target="_blank" rel="author">' . $theauthor->display_name . '</a></span>';
    }
    else {
        $lmt_post_uca = ' by <span class="post-modified-author">' . $theauthor->display_name . '</span>';
    }
}
        
if(isset($options_post) && (isset($updated_time) || isset($updated_day) || isset($lmt_post_uca) || isset($options_post_sep))) {

    if( isset($options['lmt_enable_human_format_cb']) && ($options['lmt_enable_human_format_cb'] == 1 ) ) {
        $modified_content = '<p class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . human_time_diff(get_the_modified_time( 'U' ), current_time( 'U' )) . ' ago' . '</time>' . $lmt_post_uca . '</p>';        
    }
    else {
        if( (isset($options['lmt_enable_last_modified_time_cb']) == 1) && (isset($options['lmt_enable_last_modified_date_cb']) != 1) ) {
            $modified_content = '<p class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $updated_time . '</time>' . $lmt_post_uca . '</p>';
        }
        elseif( (isset($options['lmt_enable_last_modified_date_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_cb']) != 1) ) {
            $modified_content = '<p class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $updated_day . '</time>' . $lmt_post_uca . '</p>';
        }
        elseif( (isset($options['lmt_enable_last_modified_date_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_cb']) == 1) ) {
            $modified_content = '<p class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $updated_day . ' ' . $options_post_sep . ' ' . $updated_time . '</time>' . $lmt_post_uca . '</p>';
        }
    }
}