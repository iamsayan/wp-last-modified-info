<?php 
/**
 * Runs on Posts Frontend
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */
 
// get plugin options
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
    $options_post = html_entity_decode($options['lmt_post_custom_text']);
} else {
    $options_post = 'Last Updated on';
}

if(!empty($options['lmt_post_date_time_sep'])) {
    $options_post_sep = html_entity_decode($options['lmt_post_date_time_sep']);
} else {
    $options_post_sep = 'at';
}

if(!empty($options['lmt_replace_ago_text_with'])) {
    $replace_ago = ' ' . html_entity_decode($options['lmt_replace_ago_text_with']);
} else {
    $replace_ago = ' ago';
}

if(!empty($options['lmt_post_author_sep'])) {
    $author_sep = ' ' . html_entity_decode($options['lmt_post_author_sep']);
} else {
    $author_sep = ' by';
}

if( isset( $options['lmt_html_tag_post'] ) ) {
    $html_tag = $options['lmt_html_tag_post'];
} else {
    $html_tag = 'p';
}

if( isset( $options['lmt_enable_author_hyperlink_target'] ) && $options['lmt_enable_author_hyperlink_target'] == 'self' ) {
    $target = '_self';
} else {
    $target = '_blank';
}

$schema_post = '';
if( isset($options['lmt_enable_schema_on_post_cb']) && ($options['lmt_enable_schema_on_post_cb'] == 1) ) {
    $schema_post = ' itemprop="dateModified" datetime="'. get_post_modified_time( 'Y-m-d\TH:i:sP', true ) .'"';
    if( is_archive() || is_home() || is_front_page() || is_search() || is_404() ) {
        $schema_post = '';
    }
}

if( isset($options['lmt_show_author_cb']) && ($options['lmt_show_author_cb'] == 'do_not_show' ) ) {
    
    $lmt_post_uca = '';
    $author_sep = '';
    
} elseif( isset($options['lmt_show_author_cb']) && ($options['lmt_show_author_cb'] == 'default' ) ) {
        
    $author_id = get_post_meta(get_the_ID(), '_edit_last', true);

    if( isset($options['lmt_enable_author_hyperlink']) && ($options['lmt_enable_author_hyperlink'] == 'author_page' ) ) {
        
        $lmt_post_uca = '<a href="' . get_author_posts_url( $author_id ) . '" target="' . $target . '" rel="author">' . get_the_author_meta( 'display_name', $author_id ) . '</a>';
    
    } elseif( isset($options['lmt_enable_author_hyperlink']) && ($options['lmt_enable_author_hyperlink'] == 'author_website' ) ) {
        
        $lmt_post_uca = '<a href="' . get_the_author_meta( 'url', $author_id ) . '" target="' . $target . '" rel="author">' . get_the_author_meta( 'display_name', $author_id ) . '</a>';
    
    } elseif( isset($options['lmt_enable_author_hyperlink']) && ($options['lmt_enable_author_hyperlink'] == 'author_email' ) ) {
       
        $lmt_post_uca = '<a href="mailto:' . get_the_author_meta( 'user_email', $author_id ) . '" rel="author">' . get_the_author_meta( 'display_name', $author_id ) . '</a>';
    
    } elseif( isset($options['lmt_enable_author_hyperlink']) && ($options['lmt_enable_author_hyperlink'] == 'none' ) ) {
        
        $lmt_post_uca = get_the_author_meta( 'display_name', $author_id );
    
    }

} elseif( isset($options['lmt_show_author_cb']) && ($options['lmt_show_author_cb'] == 'custom' ) ) {
        
    $get_author = $options['lmt_show_author_list'];

    if( isset($options['lmt_enable_author_hyperlink']) && ($options['lmt_enable_author_hyperlink'] == 'author_page' ) ) {
        
        $lmt_post_uca = '<a href="' . get_author_posts_url( $get_author ) . '" target="' . $target . '" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a>';
    
    } elseif( isset($options['lmt_enable_author_hyperlink']) && ($options['lmt_enable_author_hyperlink'] == 'author_website' ) ) {
       
        $lmt_post_uca = '<a href="' . get_the_author_meta( 'url', $get_author ) . '" target="' . $target . '" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a>';
   
    } elseif( isset($options['lmt_enable_author_hyperlink']) && ($options['lmt_enable_author_hyperlink'] == 'author_email' ) ) {
        
        $lmt_post_uca = '<a href="mailto:' . get_the_author_meta( 'user_email', $get_author ) . '" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a>';
    
    } elseif( isset($options['lmt_enable_author_hyperlink']) && ($options['lmt_enable_author_hyperlink'] == 'none' ) ) {
        
        $lmt_post_uca = get_the_author_meta( 'display_name', $get_author );
    
    }
}

if( isset( $options_post ) && ( isset( $updated_time ) || isset( $updated_day ) || isset( $lmt_post_uca ) || isset( $options_post_sep ) ) ) {
   
    if( isset($options['lmt_last_modified_format_post']) && ($options['lmt_last_modified_format_post'] == 'human_readable' ) ) {
        
        $format = human_time_diff(get_the_modified_time( 'U' ), current_time( 'U' )) . $replace_ago;        
   
    } elseif( isset($options['lmt_last_modified_format_post']) && ($options['lmt_last_modified_format_post'] == 'default' ) ) {
        
        if( isset($options['lmt_last_modified_default_format_post']) && ($options['lmt_last_modified_default_format_post'] == 'only_time' ) ) {
           
            $format = $updated_time;
        
        } elseif( isset($options['lmt_last_modified_default_format_post']) && ($options['lmt_last_modified_default_format_post'] == 'only_date' ) ) {
            
            $format = $updated_day;
        
        } elseif( isset($options['lmt_last_modified_default_format_post']) && ($options['lmt_last_modified_default_format_post'] == 'show_both' ) ) {
            
            $format = $updated_day . ' ' . $options_post_sep . ' ' . $updated_time;
        
        }

    }

    $modified_content = '<' . $html_tag . ' class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td"'. $schema_post .'>' . $format . '</time>' . $author_sep . ' <span class="post-modified-author">' . $lmt_post_uca . '</span></' . $html_tag . '>';

}