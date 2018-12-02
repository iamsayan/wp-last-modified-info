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
} else {
    $updated_time_page = get_the_modified_time('h:i a');
}
    
if(!empty($options['lmt_custom_page_date_format'])) {
    $updated_day_page = get_the_modified_time(esc_html($options['lmt_custom_page_date_format']));
} else {
    $updated_day_page = get_the_modified_time('F jS, Y');
}

if(!empty($options['lmt_page_custom_text'])) {
    $options_page = esc_html($options['lmt_page_custom_text']);
} else {
    $options_page = 'Last Updated on ';
}

if(!empty($options['lmt_page_date_time_sep'])) {
    $options_page_sep = esc_html($options['lmt_page_date_time_sep']);
} else {
    $options_page_sep = 'at';
}

if(!empty($options['lmt_replace_ago_text_with_page'])) {
    $replace_ago_page = esc_html($options['lmt_replace_ago_text_with_page']);
} else {
    $replace_ago_page = ' ago';
}

if(!empty($options['lmt_page_author_sep'])) {
    $author_sep_page = esc_html($options['lmt_page_author_sep']);
} else {
    $author_sep_page = ' by';
}

if( isset($options['lmt_show_author_page_cb']) && ($options['lmt_show_author_page_cb'] == 'do_not_show' ) ) {
    $lmt_page_uca = '';
}
elseif( isset($options['lmt_show_author_page_cb']) && ($options['lmt_show_author_page_cb'] == 'default' ) ) {
        
    $author_id = get_post_meta(get_the_ID(), '_edit_last', true);
    
    if( isset($options['lmt_enable_page_author_hyperlink']) && ($options['lmt_enable_page_author_hyperlink'] == 'author_page' ) ) {
        $lmt_page_uca = $author_sep_page . ' <span class="page-modified-author"><a href="' . get_author_posts_url($author_id) . '" target="_blank" rel="author">' . get_the_modified_author() . '</a></span>';
    } elseif( isset($options['lmt_enable_page_author_hyperlink']) && ($options['lmt_enable_page_author_hyperlink'] == 'author_email' ) ) {
        $lmt_page_uca = $author_sep_page . ' <span class="page-modified-author"><a href="mailto:' . get_the_author_meta('user_email') . '" rel="author">' . get_the_modified_author() . '</a></span>';
    } elseif( isset($options['lmt_enable_page_author_hyperlink']) && ($options['lmt_enable_page_author_hyperlink'] == 'none' ) ) {
        $lmt_page_uca = $author_sep_page . ' <span class="page-modified-author">' . get_the_modified_author() . '</span>';
    }
}
elseif( isset($options['lmt_show_author_page_cb']) && ($options['lmt_show_author_page_cb'] == 'custom' ) ) {
    
    $get_author = $options['lmt_show_author_list_page'];

    if( isset($options['lmt_enable_page_author_hyperlink']) && ($options['lmt_enable_page_author_hyperlink'] == 'author_page' ) ) {
        $lmt_page_uca = $author_sep_page . ' <span class="page-modified-author"><a href="' . get_author_posts_url( $get_author ) . '" target="_blank" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a></span>';
    } elseif( isset($options['lmt_enable_page_author_hyperlink']) && ($options['lmt_enable_page_author_hyperlink'] == 'author_email' ) ) {
        $lmt_page_uca = $author_sep_page . ' <span class="page-modified-author"><a href="mailto:' . get_the_author_meta('user_email', $get_author) . '" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a></span>';
    } elseif( isset($options['lmt_enable_page_author_hyperlink']) && ($options['lmt_enable_page_author_hyperlink'] == 'none' ) ) {
        $lmt_page_uca = $author_sep_page . ' <span class="page-modified-author">' . get_the_author_meta( 'display_name', $get_author ) . '</span>';
    }
}      
        
if( isset( $options_page ) && ( isset( $updated_time_page ) || isset( $updated_day_page ) || isset( $lmt_page_us ) || isset( $lmt_page_uca ) ) ) {

    if( isset($options['lmt_enable_schema_on_page_cb']) && ($options['lmt_enable_schema_on_page_cb'] == 1 ) ) {
        $schema_page = ' itemprop="dateModified" datetime="'. get_post_modified_time( apply_filters( 'wplmi_page_schema_format', 'c' ) ) .'"';
    } else {
        $schema_page = '';
    }

    if( isset($options['lmt_last_modified_format_page']) && ($options['lmt_last_modified_format_page'] == 'human_readable' ) ) {
        $modified_content = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td"'. $schema_page .'>' . human_time_diff(get_the_modified_time( 'U' ), current_time( 'U' )) . $replace_ago_page . '</time>' . $lmt_page_uca . '</p>';
    }
    elseif( isset($options['lmt_last_modified_format_page']) && ($options['lmt_last_modified_format_page'] == 'default' ) ) {
        if( isset($options['lmt_last_modified_default_format_page']) && ($options['lmt_last_modified_default_format_page'] == 'only_time' ) ) {
            $modified_content = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td"'. $schema_page .'>' . $updated_time_page . '</time>' . $lmt_page_uca . '</p>';
        }
        elseif( isset($options['lmt_last_modified_default_format_page']) && ($options['lmt_last_modified_default_format_page'] == 'only_date' ) ) {
            $modified_content = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td"'. $schema_page .'>' . $updated_day_page . '</time>' . $lmt_page_uca . '</p>';
        }
        elseif( isset($options['lmt_last_modified_default_format_page']) && ($options['lmt_last_modified_default_format_page'] == 'show_both' ) ) {
            $modified_content = '<p class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td"'. $schema_page .'>' . $updated_day_page . ' ' . $options_page_sep . ' ' . $updated_time_page . '</time>' . $lmt_page_uca . '</p>';
        }
    }
}
