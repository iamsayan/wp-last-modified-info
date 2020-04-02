<?php 
/**
 * Runs on Posts Frontend
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

add_action( 'init', 'lmt_plugin_init_post' );

function lmt_plugin_init_post() {// get plugin options
    $options = get_option( 'lmt_plugin_global_settings' );
    $priority = apply_filters( 'wplmi_display_priority_post', 10 );

    if( isset( $options['lmt_enable_last_modified_cb'] ) && ( $options['lmt_enable_last_modified_cb'] == 1 ) ) {
        add_filter( 'the_content', 'lmt_print_last_modified_info_post', $priority );
    }
}

function lmt_print_last_modified_info_post( $content ) {
    // get plugin options
    $options = get_option('lmt_plugin_global_settings');
    
    if( !empty( $options['lmt_custom_post_time_format'] ) ) {
        $updated_time = get_the_modified_time( esc_html( $options['lmt_custom_post_time_format'] ) );
    } else {
        $updated_time = get_the_modified_time( 'h:i a' );
    }
    
    if( !empty( $options['lmt_custom_post_date_format'] ) ) {
        $updated_day = get_the_modified_time( esc_html( $options['lmt_custom_post_date_format'] ) );
    } else {
        $updated_day = get_the_modified_time( 'F jS, Y' );
    }
    
    if( !empty( $options['lmt_post_custom_text'] ) ) {
        $options_post = esc_html( $options['lmt_post_custom_text'] );
    } else {
        $options_post = 'Last Updated on';
    }
    
    if( !empty( $options['lmt_post_date_time_sep'] ) ) {
        $options_post_sep = esc_html( $options['lmt_post_date_time_sep'] );
    } else {
        $options_post_sep = 'at';
    }
    
    if( !empty( $options['lmt_replace_ago_text_with'] ) ) {
        $replace_ago = ' ' . esc_html( $options['lmt_replace_ago_text_with'] );
    } else {
        $replace_ago = ' ago';
    }
    
    if( !empty( $options['lmt_post_author_sep'] ) ) {
        $author_sep = ' ' . esc_html( $options['lmt_post_author_sep'] );
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

    $gap = 0;
    if( isset( $options['lmt_gap_on_post'] ) ) {
        $gap = $options['lmt_gap_on_post'];
    }
    $gap = apply_filters( 'wplmi_date_time_diff_post', $gap );
    
    $schema_post = '';
    if( isset( $options['lmt_enable_schema_on_post_cb'] ) && ( $options['lmt_enable_schema_on_post_cb'] == 1 ) ) {
        $schema_post = ' itemprop="dateModified" datetime="'. get_post_modified_time( 'Y-m-d\TH:i:sP', false ) .'"';
        if( is_archive() || is_home() || is_front_page() || is_search() || is_404() ) {
            $schema_post = '';
        }
    }
    
    if( isset( $options['lmt_show_author_cb'] ) && ( $options['lmt_show_author_cb'] == 'default' ) ) {
            
        $author_id = get_post_meta( get_the_ID(), '_edit_last', true );
    
        if( isset( $options['lmt_enable_author_hyperlink'] ) && ( $options['lmt_enable_author_hyperlink'] == 'author_page' ) ) {
            $lmt_post_uca = '<a href="' . get_author_posts_url( $author_id ) . '" target="' . $target . '" rel="author">' . get_the_author_meta( 'display_name', $author_id ) . '</a>';
        } elseif( isset( $options['lmt_enable_author_hyperlink'] ) && ( $options['lmt_enable_author_hyperlink'] == 'author_website' ) ) {
            $lmt_post_uca = '<a href="' . get_the_author_meta( 'url', $author_id ) . '" target="' . $target . '" rel="author">' . get_the_author_meta( 'display_name', $author_id ) . '</a>';
        } elseif( isset( $options['lmt_enable_author_hyperlink'] ) && ( $options['lmt_enable_author_hyperlink'] == 'author_email' ) ) {
            $lmt_post_uca = '<a href="mailto:' . get_the_author_meta( 'user_email', $author_id ) . '" rel="author">' . get_the_author_meta( 'display_name', $author_id ) . '</a>';
        } elseif( isset( $options['lmt_enable_author_hyperlink'] ) && ( $options['lmt_enable_author_hyperlink'] == 'none' ) ) {
            $lmt_post_uca = get_the_author_meta( 'display_name', $author_id );
        }
    
    } elseif( isset( $options['lmt_show_author_cb'] ) && ( $options['lmt_show_author_cb'] == 'custom' ) ) {
            
        $get_author = $options['lmt_show_author_list'];
    
        if( isset( $options['lmt_enable_author_hyperlink'] ) && ( $options['lmt_enable_author_hyperlink'] == 'author_page' ) ) {
            $lmt_post_uca = '<a href="' . get_author_posts_url( $get_author ) . '" target="' . $target . '" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a>';
        } elseif( isset( $options['lmt_enable_author_hyperlink'] ) && ( $options['lmt_enable_author_hyperlink'] == 'author_website' ) ) { 
            $lmt_post_uca = '<a href="' . get_the_author_meta( 'url', $get_author ) . '" target="' . $target . '" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a>';
        } elseif( isset( $options['lmt_enable_author_hyperlink'] ) && ( $options['lmt_enable_author_hyperlink'] == 'author_email' ) ) {
            $lmt_post_uca = '<a href="mailto:' . get_the_author_meta( 'user_email', $get_author ) . '" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a>';
        } elseif( isset( $options['lmt_enable_author_hyperlink'] ) && ( $options['lmt_enable_author_hyperlink'] == 'none' ) ) {
            $lmt_post_uca = get_the_author_meta( 'display_name', $get_author );
        }
    }
    
    if( isset( $options['lmt_show_author_cb'] ) && ( $options['lmt_show_author_cb'] == 'do_not_show' ) ) {
        $lmt_postauthor = '';
    } else {
        $lmt_postauthor = $author_sep . ' <span class="post-modified-author">' . $lmt_post_uca . '</span>';
    }
    
    if( isset( $options_post ) && ( isset( $updated_time ) || isset( $updated_day ) || isset( $lmt_post_uca ) || isset( $options_post_sep ) ) ) {
        if( isset( $options['lmt_last_modified_format_post'] ) && ( $options['lmt_last_modified_format_post'] == 'human_readable' ) ) {
            $format = human_time_diff(get_the_modified_time( 'U' ), current_time( 'U' )) . $replace_ago;        
        } elseif( isset( $options['lmt_last_modified_format_post'] ) && ( $options['lmt_last_modified_format_post'] == 'default' ) ) {
            if( isset( $options['lmt_last_modified_default_format_post'] ) && ( $options['lmt_last_modified_default_format_post'] == 'only_time' ) ) {
                $format = $updated_time;
            } elseif( isset( $options['lmt_last_modified_default_format_post'] ) && ( $options['lmt_last_modified_default_format_post'] == 'only_date' ) ) {
                $format = $updated_day;
            } elseif( isset( $options['lmt_last_modified_default_format_post'] ) && ( $options['lmt_last_modified_default_format_post'] == 'show_both' ) ) {
                $format = $updated_day . ' ' . $options_post_sep . ' ' . $updated_time;
            }
        }
        $modified_content = '<' . $html_tag . ' class="post-last-modified"><span class="post-last-modified-text">' . $options_post . '</span> <time class="post-last-modified-td"'. $schema_post .'>' . $format . '</time>' . $lmt_postauthor . '</' . $html_tag . '>';
    }
    
    if ( ! in_the_loop() ) {
        return $content;
    }

    if( get_the_modified_time( 'U' ) < ( get_the_time( 'U' ) + $gap ) ) {
        return $content;
    }

    if( isset( $options['lmt_show_last_modified_time_date_post'] ) && ( $options['lmt_show_last_modified_time_date_post'] == 'manual' ) ) {    
        return $content;
    }

    if( isset( $modified_content ) ) {
        if( isset( $options['lmt_show_last_modified_time_date_post'] ) && ( $options['lmt_show_last_modified_time_date_post'] == 'before_content' ) ) {
            $fullcontent = $modified_content . $content; 
        }
        elseif( isset( $options['lmt_show_last_modified_time_date_post'] ) && ( $options['lmt_show_last_modified_time_date_post'] == 'after_content' ) ) {
            $fullcontent = $content . $modified_content;
        }
    } 

    if ( isset( $fullcontent ) && is_singular( 'post' ) && !get_post_meta( get_the_ID(), '_lmt_disable', true ) == 'yes' ) { 
        if( apply_filters( 'wplmi_disable_post_output', false ) ) {
            return $content;
        }
        return $fullcontent;
    }

    if( isset( $options['lmt_show_on_homepage'] ) && ( $options['lmt_show_on_homepage'] == 'yes' ) ) {
        if ( isset( $fullcontent ) && ( ( is_home() && apply_filters( 'wplmi_enable_home_page', true ) ) || ( is_author() && apply_filters( 'wplmi_enable_author_archive', true ) ) || ( is_category() && apply_filters( 'wplmi_enable_category_archive', true ) ) || ( is_tag() && apply_filters( 'wplmi_enable_tag_archive', true ) ) || ( is_search() && apply_filters( 'wplmi_enable_on_search_page', true ) ) ) && !get_post_meta( get_the_ID(), '_lmt_disable', true ) == 'yes' ) { 
            return $fullcontent;
        }
    }

    if( !empty( $options['lmt_custom_post_types_list'] ) ) {
        $post_types = $options['lmt_custom_post_types_list'];
        if ( isset( $fullcontent ) && is_singular( $post_types ) && !get_post_meta( get_the_ID(), '_lmt_disable', true ) == 'yes' ) { 
            return $fullcontent;
        }
    }

    return $content;
}

?>