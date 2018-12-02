<?php 
/**
 * Template Tags
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @since     v1.2.0
 * @license   http://www.gnu.org/licenses/gpl.html
 */

function get_the_last_modified_info () {

    // get plugin options
    $options = get_option('lmt_plugin_global_settings');
    
    if(!empty($options['lmt_tt_set_format_box'])) {
        $last_modified_tt = get_the_modified_time(esc_html($options['lmt_tt_set_format_box']));
    } else {
        $last_modified_tt = get_the_modified_time('F jS, Y @ h:i a');
    }

    if(!empty($options['lmt_tt_updated_text_box'])) {
        $last_modified_text = esc_html($options['lmt_tt_updated_text_box']);
    } else {
        $last_modified_text = '';
    }

    if(!empty($options['lmt_post_author_sep'])) {
        $author_sep_tt = esc_html($options['lmt_post_author_sep']);
    } else {
        $author_sep_tt = ' by';
    }

    if(!empty($options['lmt_replace_ago_text_with_tt'])) {
        $replace_ago_tt = esc_html($options['lmt_replace_ago_text_with_tt']);
    } else {
        $replace_ago_tt = ' ago';
    }

    if( isset($options['lmt_show_author_tt_cb']) && ($options['lmt_show_author_tt_cb'] == 'do_not_show' ) ) {
        $lmt_tt_uca = '';
    
    } elseif( isset($options['lmt_show_author_tt_cb']) && ($options['lmt_show_author_tt_cb'] == 'default' ) ) {

        $author_id = get_post_meta(get_the_ID(), '_edit_last', true);

        if( isset($options['lmt_enable_tt_author_hyperlink']) && ($options['lmt_enable_tt_author_hyperlink'] == 'author_page' ) ) {
            $lmt_tt_uca = $author_sep_tt . ' <a href="' . get_author_posts_url($author_id) . '" target="_blank" rel="author">' . get_the_modified_author() . '</a>';
        } elseif( isset($options['lmt_enable_tt_author_hyperlink']) && ($options['lmt_enable_tt_author_hyperlink'] == 'author_email' ) ) {
            $lmt_tt_uca = $author_sep_tt . ' <a href="mailto:' . get_the_author_meta('user_email') . '" rel="author">' . get_the_modified_author() . '</a>';
        } elseif( isset($options['lmt_enable_tt_author_hyperlink']) && ($options['lmt_enable_tt_author_hyperlink'] == 'none' ) ) {
            $lmt_tt_uca = $author_sep_tt . ' ' . get_the_modified_author();
        }
    
    } elseif( isset($options['lmt_show_author_tt_cb']) && ($options['lmt_show_author_tt_cb'] == 'custom' ) ) {
        
        $get_author = $options['lmt_show_author_list_tt'];
        
        if( isset($options['lmt_enable_tt_author_hyperlink']) && ($options['lmt_enable_tt_author_hyperlink'] == 'author_page' ) ) {
            $lmt_tt_uca = $author_sep_tt . ' <a href="' . get_author_posts_url( $get_author ) . '" target="_blank" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a>';
        }elseif( isset($options['lmt_enable_tt_author_hyperlink']) && ($options['lmt_enable_tt_author_hyperlink'] == 'author_email' ) ) {
            $lmt_tt_uca = $author_sep_tt . ' <a href="mailto:' . get_the_author_meta('user_email', $get_author) . '" rel="author">' . get_the_author_meta( 'display_name', $get_author ) . '</a>';
        } elseif( isset($options['lmt_enable_tt_author_hyperlink']) && ($options['lmt_enable_tt_author_hyperlink'] == 'none' ) ) {
            $lmt_tt_uca = $author_sep_tt . ' ' . get_the_author_meta( 'display_name', $get_author );
        }
    }

    if( isset($options['lmt_tt_enable_schema_cb']) && ($options['lmt_tt_enable_schema_cb'] == 1 ) ) {
        $schema_tt = ' itemprop="dateModified" datetime="'. get_post_modified_time( apply_filters( 'wplmi_template_tags_schema_format', 'c' ) ) .'"';
    } else {
        $schema_tt = '';
    }

    if( isset($options['lmt_last_modified_format_tt']) && ($options['lmt_last_modified_format_tt'] == 'human_readable' ) ) {
        $lmt_tt_ud = human_time_diff(get_the_modified_time( 'U' ), current_time( 'U' )) . $replace_ago_tt;
    } else {
        $lmt_tt_ud = $last_modified_tt;
    }
                   
    if(!empty($options['lmt_tt_class_box'])) {

        $get_custom_class = esc_html($options['lmt_tt_class_box']);              
        $lmt_template_tag = '<span class="'. $get_custom_class .'">' . $last_modified_text . '<time' . $schema_tt . '>' . $lmt_tt_ud . '</time>' . $lmt_tt_uca . '</span>';

    } else {
        $lmt_template_tag = '<span>' . $last_modified_text . '<time' . $schema_tt . '>' . $lmt_tt_ud . '</time>' . $lmt_tt_uca . '</span>';
    }
    return $lmt_template_tag;
}

function the_last_modified_info () {
    //displays/echos the last modified info.
    echo get_the_last_modified_info();
}



?>