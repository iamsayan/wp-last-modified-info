<?php 

/**
 * Shortcodes
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

 /**
 * Callback to register shortcodes.
 *
 * @param array $atts Shortcode attributes.
 * @return string Shortcode output.
 */

add_shortcode( 'lmt-post-modified-info', 'lmt_post_modified_info_shortcode' );
add_shortcode( 'lmt-page-modified-info', 'lmt_page_modified_info_shortcode' );
add_shortcode( 'lmt-site-modified-info', 'lmt_global_modified_info_shortcode' );

function lmt_post_modified_info_shortcode( $atts ) {
    $options = get_option('lmt_plugin_global_settings');
    
    $tf = !empty($options['lmt_custom_post_time_format']) ? esc_html($options['lmt_custom_post_time_format']) : 'h:i a';
    $df = !empty($options['lmt_custom_post_date_format']) ? esc_html($options['lmt_custom_post_date_format']) : 'F jS, Y';
    $text = !empty($options['lmt_post_custom_text']) ? html_entity_decode($options['lmt_post_custom_text']) : 'Last Updated on';
    $sep = !empty($options['lmt_post_date_time_sep']) ? html_entity_decode($options['lmt_post_date_time_sep']) : 'at';
    $ago = !empty($options['lmt_replace_ago_text_with']) ? html_entity_decode($options['lmt_replace_ago_text_with']) : ' ago';
    $a_sep = !empty($options['lmt_post_author_sep']) ? html_entity_decode($options['lmt_post_author_sep']) : ' by';
    $htmltag = isset($options['lmt_html_tag_post']) ? $options['lmt_html_tag_post'] : 'p';
    $schema = isset($options['lmt_enable_schema_on_post_cb']) ? $options['lmt_enable_schema_on_post_cb'] : '';
    $show_author = isset($options['lmt_show_author_cb']) ? $options['lmt_show_author_cb'] : 'do_not_show';
    $author_href = isset($options['lmt_enable_author_hyperlink']) ? $options['lmt_enable_author_hyperlink'] : 'none';
    $author_id = isset($options['lmt_show_author_list']) ? $options['lmt_show_author_list'] : 1;
    $archive = isset($options['lmt_show_on_homepage']) ? $options['lmt_show_on_homepage'] : 'no';
    $format = isset($options['lmt_last_modified_format_post']) ? $options['lmt_last_modified_format_post'] : 'default';
    $display = isset($options['lmt_last_modified_default_format_post']) ? $options['lmt_last_modified_default_format_post'] : 'only_date';
    $gap = isset($options['lmt_gap_on_post']) ? $options['lmt_gap_on_post'] : 0;
    $lt = isset( $options['lmt_enable_author_hyperlink_target'] ) && $options['lmt_enable_author_hyperlink_target'] == 'self' ? '_self' : '_blank';
    
    $atts = shortcode_atts(
		array(
            'id'           => get_the_ID(),
            'time_format'  => $tf,
            'date_format'  => $df,
            'text'         => $text,
            'sep'          => $sep,
            'ago'          => $ago,
            'author_sep'   => $a_sep,
            'html_tag'     => $htmltag,
            'schema'       => $schema,
            'show_author'  => $show_author,
            'author_link'  => $author_href,
            'author_id'    => $author_id,
            'is_home'      => 1,
            'is_author'    => 1,
            'is_category'  => 1,
            'is_tag'       => 1,
            'is_search'    => 1,
            'archive'      => $archive,
            'format'       => $format,
            'display'      => $display,
            'filter'       => 'no',
            'filter_id'    => array(),
            'link_target'  => $lt,
            'gap'          => $gap,
        ), $atts, 'lmt-post-modified-info' );

    $updated_time = get_the_modified_time( $atts['time_format'], $atts['id'] );
    $updated_date = get_the_modified_date( $atts['date_format'], $atts['id'] );
    
    $options_post = $atts['text'];
    $options_post_sep = $atts['sep'];
    $replace_ago = ' ' . $atts['ago'];
    $author_sep = ' ' . $atts['author_sep'];
    $html_tag = $atts['html_tag'];

    // get date time formats
    $pub_time = get_the_time( 'U', $atts['id'] );
    $mod_time = get_the_modified_time( 'U', $atts['id'] );

    $gap = 0;
    if( isset($atts['gap']) ) {
        $gap = $atts['gap'];
    }
    $gap = apply_filters( 'wplmi_date_time_diff_post', $gap );
    // if modified time is equal to published time, do not show
    if ( $mod_time < ( $pub_time + $gap ) ) return;

    $schema_post = '';
    if( isset($atts['schema']) && ($atts['schema'] == 1) ) {
        $schema_post = ' itemprop="dateModified" datetime="'. get_post_modified_time( 'Y-m-d\TH:i:sP', true, $atts['id'] ) .'"';
        if ( is_archive() || is_home() || is_front_page() || is_search() || is_404() ) {
            $schema_post = '';
        }
    }
   
    if( isset($atts['show_author']) && ($atts['show_author'] == 'do_not_show' ) ) {
        $lmt_post_uca = '';
    }
    elseif( isset($atts['show_author']) && ($atts['show_author'] == 'default' ) ) {
            
        $author_id = get_post_meta( $atts['id'], '_edit_last', true );
    
        if( isset($atts['author_link']) && ($atts['author_link'] == 'author_page' ) ) {
            $lmt_post_uca = $author_sep . ' <span class="post-modified-author"><a href="' . get_author_posts_url( $author_id ) . '" target="' . $atts['link_target'] . '" rel="author">' . get_the_author_meta( 'display_name', $author_id ) . '</a></span>';
        } elseif( isset($atts['author_link']) && ($atts['author_link'] == 'author_website' ) ) {
            $lmt_post_uca = $author_sep . ' <span class="post-modified-author"><a href="' . get_the_author_meta( 'url', $author_id ) . '" target="' . $atts['link_target'] . '" rel="author">' . get_the_author_meta( 'display_name', $author_id ) . '</a></span>';
        } elseif( isset($atts['author_link']) && ($atts['author_link'] == 'author_email' ) ) {
            $lmt_post_uca = $author_sep . ' <span class="post-modified-author"><a href="mailto:' . get_the_author_meta( 'user_email', $author_id ) . '" rel="author">' . get_the_author_meta( 'display_name', $author_id ) . '</a></span>';
        } elseif( isset($atts['author_link']) && ($atts['author_link'] == 'none' ) ) {
            $lmt_post_uca = $author_sep . ' <span class="post-modified-author">' . get_the_author_meta( 'display_name', $author_id ) . '</span>';
        }
    } 
    elseif( isset($atts['show_author']) && ($atts['show_author'] == 'custom' ) ) {
            
        $get_author = $atts['author_id'];
    
        if( isset($atts['author_link']) && ($atts['author_link'] == 'author_page' ) ) {
            $lmt_post_uca = $author_sep . ' <span class="post-modified-author"><a href="' . get_author_posts_url( $get_author ) . '" target="' . $atts['link_target'] . '" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a></span>';
        } elseif( isset($atts['author_link']) && ($atts['author_link'] == 'author_website' ) ) {
            $lmt_post_uca = $author_sep . ' <span class="post-modified-author"><a href="' . get_the_author_meta( 'url', $get_author ) . '" target="' . $atts['link_target'] . '" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a></span>';
        } elseif( isset($atts['author_link']) && ($atts['author_link'] == 'author_email' ) ) {
            $lmt_post_uca = $author_sep . ' <span class="post-modified-author"><a href="mailto:' . get_the_author_meta( 'user_email', $get_author ) . '" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a></span>';
        } elseif( isset($atts['author_link']) && ($atts['author_link'] == 'none' ) ) {
            $lmt_post_uca = $author_sep . ' <span class="post-modified-author">' . get_the_author_meta( 'display_name', $get_author ) . '</span>';
        }
    }
    
    if( isset( $options_post ) && ( isset( $updated_time ) || isset( $updated_date ) || isset( $lmt_post_uca ) || isset( $options_post_sep ) ) ) {
       
        if( isset($atts['format']) && ($atts['format'] == 'human_readable' ) ) {
            $html_content = '<' . $html_tag . ' class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td"'. $schema_post .'>' . human_time_diff( get_the_modified_time( 'U', $atts['id'] ), current_time( 'U' ) ) . $replace_ago . '</time>' . $lmt_post_uca . '</' . $html_tag . '>';        
        }
        elseif( isset($atts['format']) && ($atts['format'] == 'default' ) ) {
            if( isset($atts['display']) && ($atts['display'] == 'only_time' ) ) {
                $html_content = '<' . $html_tag . ' class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td"'. $schema_post .'>' . $updated_time . '</time>' . $lmt_post_uca . '</' . $html_tag . '>';
            }
            elseif( isset($atts['display']) && ($atts['display'] == 'only_date' ) ) {
                $html_content = '<' . $html_tag . ' class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td"'. $schema_post .'>' . $updated_date . '</time>' . $lmt_post_uca . '</' . $html_tag . '>';
            }
            elseif( isset($atts['display']) && ($atts['display'] == 'show_both' ) ) {
                $html_content = '<' . $html_tag . ' class="post-last-modified">' . $options_post . ' <time class="post-last-modified-td"'. $schema_post .'>' . $updated_date . ' ' . $options_post_sep . ' ' . $updated_time . '</time>' . $lmt_post_uca . '</' . $html_tag . '>';
            }
        }
    }
    
    if( isset($options['lmt_enable_last_modified_cb']) && ($options['lmt_enable_last_modified_cb'] == 1) ) {
        if ( isset( $html_content ) && is_single() ) {
            if( isset($atts['filter']) && ($atts['filter'] == 'yes') && !empty($atts['filter_id']) ) {
                if( is_single( explode( ',', $atts['filter_id'] ) ) ) {
                    return;
                }
            }
            return $html_content;
        }
    
        if( isset($atts['archive']) && ($atts['archive'] == 'yes') ) {
            if ( isset( $html_content ) && ( ( $atts['is_home'] == 1 && is_home() ) || ( $atts['is_author'] == 1 && is_author() ) || ( $atts['is_category'] == 1 && is_category() ) || ( $atts['is_tag'] == 1 && is_tag() ) || ( $atts['is_search'] == 1 && is_search() ) ) ) { 
                return $html_content;
            }
        }
    }
}

function lmt_page_modified_info_shortcode( $atts ) {
    $options = get_option('lmt_plugin_global_settings');
    
    $tf = !empty($options['lmt_custom_page_time_format']) ? esc_html($options['lmt_custom_page_time_format']) : 'h:i a';
    $df = !empty($options['lmt_custom_page_date_format']) ? esc_html($options['lmt_custom_page_date_format']) : 'F jS, Y';
    $text = !empty($options['lmt_page_custom_text']) ? html_entity_decode($options['lmt_page_custom_text']) : 'Last Updated on';
    $sep = !empty($options['lmt_page_date_time_sep']) ? html_entity_decode($options['lmt_page_date_time_sep']) : 'at';
    $ago = !empty($options['lmt_replace_ago_text_with_page']) ? html_entity_decode($options['lmt_replace_ago_text_with_page']) : ' ago';
    $a_sep = !empty($options['lmt_page_author_sep']) ? html_entity_decode($options['lmt_page_author_sep']) : ' by';
    $htmltag = isset($options['lmt_html_tag_page']) ? $options['lmt_html_tag_page'] : 'p';
    $schema = isset($options['lmt_enable_schema_on_page_cb']) ? $options['lmt_enable_schema_on_page_cb'] : '';
    $show_author = isset($options['lmt_show_author_page_cb']) ? $options['lmt_show_author_page_cb'] : 'do_not_show';
    $author_href = isset($options['lmt_enable_page_author_hyperlink']) ? $options['lmt_enable_page_author_hyperlink'] : 'none';
    $author_id = isset($options['lmt_show_author_list_page']) ? $options['lmt_show_author_list_page'] : 1;
    $format = isset($options['lmt_last_modified_format_page']) ? $options['lmt_last_modified_format_page'] : 'default';
    $display = isset($options['lmt_last_modified_default_format_page']) ? $options['lmt_last_modified_default_format_page'] : 'only_date';
    $gap = isset($options['lmt_gap_on_page']) ? $options['lmt_gap_on_page'] : '0';
    $lt = isset( $options['lmt_enable_page_author_hyperlink_target'] ) && $options['lmt_enable_page_author_hyperlink_target'] == 'self' ? '_self' : '_blank';
    
    $atts = shortcode_atts(
		array(
            'id'           => get_the_ID(),
            'time_format'  => $tf,
            'date_format'  => $df,
            'text'         => $text,
            'sep'          => $sep,
            'ago'          => $ago,
            'author_sep'   => $a_sep,
            'html_tag'     => $htmltag,
            'schema'       => $schema,
            'show_author'  => $show_author,
            'author_link'  => $author_href,
            'author_id'    => $author_id,
            'format'       => $format,
            'display'      => $display,
            'filter'       => 'no',
            'filter_id'    => array(),
            'link_target'  => $lt,
            'gap'          => $gap,
        ), $atts, 'lmt-page-modified-info' );

    $updated_time = get_the_modified_time( $atts['time_format'], $atts['id'] );
    $updated_date = get_the_modified_date( $atts['date_format'], $atts['id'] );
    
    $options_page = $atts['text'];
    $options_page_sep = $atts['sep'];
    $replace_ago = ' ' . $atts['ago'];
    $author_sep = ' ' . $atts['author_sep'];
    $html_tag = $atts['html_tag'];

    // get date time formats
    $pub_time = get_the_time( 'U', $atts['id'] );
    $mod_time = get_the_modified_time( 'U', $atts['id'] );

    $gap = 0;
    if( isset($atts['gap']) ) {
        $gap = $atts['gap'];
    }
    $gap = apply_filters( 'wplmi_date_time_diff_page', $gap );
    // if modified time is equal to published time, do not show
    if ( $mod_time < ( $pub_time + $gap ) ) return;

    $schema_page = '';
    if( isset($atts['schema']) && ($atts['schema'] == 1) ) {
        $schema_page = ' itemprop="dateModified" datetime="'. get_post_modified_time( 'Y-m-d\TH:i:sP', true, $atts['id'] ) .'"';
    }
   
    if( isset($atts['show_author']) && ($atts['show_author'] == 'do_not_show' ) ) {
        $lmt_page_uca = '';
    }
    elseif( isset($atts['show_author']) && ($atts['show_author'] == 'default' ) ) {
            
        $author_id = get_post_meta( $atts['id'], '_edit_last', true );
    
        if( isset($atts['author_link']) && ($atts['author_link'] == 'author_page' ) ) {
            $lmt_page_uca = $author_sep . ' <span class="page-modified-author"><a href="' . get_author_posts_url( $author_id ) . '" target="' . $atts['link_target'] . '" rel="author">' . get_the_author_meta( 'display_name', $author_id ) . '</a></span>';
        } elseif( isset($atts['author_link']) && ($atts['author_link'] == 'author_website' ) ) {
            $lmt_page_uca = $author_sep . ' <span class="page-modified-author"><a href="' . get_the_author_meta( 'url', $author_id ) . '" target="' . $atts['link_target'] . '" rel="author">' . get_the_author_meta( 'display_name', $author_id ) . '</a></span>';
        } elseif( isset($atts['author_link']) && ($atts['author_link'] == 'author_email' ) ) {
            $lmt_page_uca = $author_sep . ' <span class="page-modified-author"><a href="mailto:' . get_the_author_meta( 'user_email', $author_id ) . '" rel="author">' . get_the_author_meta( 'display_name', $author_id ) . '</a></span>';
        } elseif( isset($atts['author_link']) && ($atts['author_link'] == 'none' ) ) {
            $lmt_page_uca = $author_sep . ' <span class="page-modified-author">' . get_the_author_meta( 'display_name', $author_id ) . '</span>';
        }
    } 
    elseif( isset($atts['show_author']) && ($atts['show_author'] == 'custom' ) ) {
            
        $get_author = $atts['author_id'];
    
        if( isset($atts['author_link']) && ($atts['author_link'] == 'author_page' ) ) {
            $lmt_page_uca = $author_sep . ' <span class="page-modified-author"><a href="' . get_author_posts_url( $get_author ) . '" target="' . $atts['link_target'] . '" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a></span>';
        } elseif( isset($atts['author_link']) && ($atts['author_link'] == 'author_website' ) ) {
            $lmt_page_uca = $author_sep . ' <span class="page-modified-author"><a href="' . get_the_author_meta( 'url', $get_author ) . '" target="' . $atts['link_target'] . '" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a></span>';
        } elseif( isset($atts['author_link']) && ($atts['author_link'] == 'author_email' ) ) {
            $lmt_page_uca = $author_sep . ' <span class="page-modified-author"><a href="mailto:' . get_the_author_meta( 'user_email', $get_author ) . '" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a></span>';
        } elseif( isset($atts['author_link']) && ($atts['author_link'] == 'none' ) ) {
            $lmt_page_uca = $author_sep . ' <span class="page-modified-author">' . get_the_author_meta( 'display_name', $get_author ) . '</span>';
        }
    }
    
    if( isset( $options_page ) && ( isset( $updated_time ) || isset( $updated_date ) || isset( $lmt_page_uca ) || isset( $options_page_sep ) ) ) {
       
        if( isset($atts['format']) && ($atts['format'] == 'human_readable' ) ) {
            $html_content = '<' . $html_tag . ' class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td"'. $schema_page .'>' . human_time_diff( get_the_modified_time( 'U', $atts['id'] ), current_time( 'U' ) ) . $replace_ago . '</time>' . $lmt_page_uca . '</' . $html_tag . '>';        
        }
        elseif( isset($atts['format']) && ($atts['format'] == 'default' ) ) {
            if( isset($atts['display']) && ($atts['display'] == 'only_time' ) ) {
                $html_content = '<' . $html_tag . ' class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td"'. $schema_page .'>' . $updated_time . '</time>' . $lmt_page_uca . '</' . $html_tag . '>';
            }
            elseif( isset($atts['display']) && ($atts['display'] == 'only_date' ) ) {
                $html_content = '<' . $html_tag . ' class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td"'. $schema_page .'>' . $updated_date . '</time>' . $lmt_page_uca . '</' . $html_tag . '>';
            }
            elseif( isset($atts['display']) && ($atts['display'] == 'show_both' ) ) {
                $html_content = '<' . $html_tag . ' class="page-last-modified">' . $options_page . ' <time class="page-last-modified-td"'. $schema_page .'>' . $updated_date . ' ' . $options_page_sep . ' ' . $updated_time . '</time>' . $lmt_page_uca . '</' . $html_tag . '>';
            }
        }
    }
    
    if( isset($options['lmt_enable_last_modified_page_cb']) && ($options['lmt_enable_last_modified_page_cb'] == 1) ) {
        if ( isset( $html_content ) && is_page() ) {
            if( isset($atts['filter']) && ($atts['filter'] == 'yes') && !empty($atts['filter_id']) ) {
                if( is_page( explode( ',', $atts['filter_id'] ) ) ) {
                    return;
                }
            }
            return $html_content;
        }
    }
}

function lmt_global_modified_info_shortcode( $atts ) {
    $option = get_option('wplmi_site_global_update_info');
    $atts = shortcode_atts(
		array(
            'format'  => get_option('date_format') . ' ' . get_option('time_format'),
        ), $atts, 'lmt-site-modified-info' );
    
    return get_date_from_gmt( date( 'Y-m-d H:i:s', $option ), $atts['format'] );
}

?>