<?php
/**
 * Runs on Pages Frontend
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

// get plugin options
$options = get_option('lmt_plugin_global_settings');

if(!empty($options['lmt_custom_page_time_format'])) {
    $updated_time_page = get_the_modified_time(esc_html($options['lmt_custom_page_time_format']));
}
else {
    $updated_time_page = get_the_modified_time('h:i a');
}
    
if(!empty($options['lmt_custom_page_date_format'])) {
    $updated_day_page = get_the_modified_time(esc_html($options['lmt_custom_page_date_format']));
}
else {
    $updated_day_page = get_the_modified_time('F jS, Y');
}

if(!empty($options['lmt_page_custom_text'])) {
    $options_page = esc_html($options['lmt_page_custom_text']);
}
else {
    $options_page = 'Last Updated on ';
}

if(!empty($options['lmt_page_date_time_sep'])) {
    $options_page_sep = esc_html($options['lmt_page_date_time_sep']);
}
else {
    $options_page_sep = 'at';
}

if( isset($options['lmt_show_author_page_cb']) && ($options['lmt_show_author_page_cb'] == 'Do not show' ) ) {
    $lmt_page_uca = '';
}
elseif( isset($options['lmt_show_author_page_cb']) && ($options['lmt_show_author_page_cb'] == 'Default' ) ) {
        
    $author_id = get_post_meta(get_the_ID(), '_edit_last', true);
    
    if( isset($options['lmt_enable_page_author_hyperlink']) && ($options['lmt_enable_page_author_hyperlink'] == 1 ) ) {
        $lmt_page_uca = ' by <span class="page-modified-author"><a href="' . get_author_posts_url($author_id) . '" target="_blank" rel="author">' . get_the_modified_author() . '</a></span>';
    }
    else {
        $lmt_page_uca = ' by <span class="page-modified-author">' . get_the_modified_author() . '</span>';
    }
}
elseif( isset($options['lmt_show_author_page_cb']) && ($options['lmt_show_author_page_cb'] == 'Custom' ) ) {
    
    $get_author = $options['lmt_show_author_list_page'];
    $theauthor = get_user_by( 'id', $get_author );

    if( isset($options['lmt_enable_page_author_hyperlink']) && ($options['lmt_enable_page_author_hyperlink'] == 1 ) ) {
        $lmt_page_uca = ' by <span class="page-modified-author"><a href="' . get_author_posts_url($get_author) . '" target="_blank" rel="author">' . $theauthor->display_name . '</a></span>';
    }
    else {
        $lmt_page_uca = ' by <span class="page-modified-author">' . $theauthor->display_name . '</span>';
    }
}      
        
if(isset($options_page) && (isset($updated_time_page) || isset($updated_day_page) || isset($lmt_page_us) || isset($lmt_page_uca))) {

    if( isset($options['lmt_enable_human_format_page_cb']) && ($options['lmt_enable_human_format_page_cb'] == 1 ) ) {
        $modified_content = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td">' . human_time_diff(get_the_modified_time( 'U' ), current_time( 'U' )) . ' ago' . '</time>' . $lmt_page_uca . '</p>';
    }
    else {
        if( (isset($options['lmt_enable_last_modified_time_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_date_page_cb']) != 1) ) {
            $modified_content = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td">' . $updated_time_page . '</time>' . $lmt_page_uca . '</p>';
        }
        elseif( (isset($options['lmt_enable_last_modified_date_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_page_cb']) != 1) ) {
            $modified_content = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td">' . $updated_day_page . '</time>' . $lmt_page_uca . '</p>';
        }
        elseif( (isset($options['lmt_enable_last_modified_date_page_cb']) == 1) && (isset($options['lmt_enable_last_modified_time_page_cb']) == 1) ) {
            $modified_content = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td">' . $updated_day_page . ' ' . $options_page_sep . ' ' . $updated_time_page . '</time>' . $lmt_page_uca . '</p>';
        }
    }
}