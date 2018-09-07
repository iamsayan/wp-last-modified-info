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

    if( isset($options['lmt_show_author_tt_cb']) && ($options['lmt_show_author_tt_cb'] == 'Do not show' ) ) {
        $lmt_tt_uca = '';
    
    } elseif( isset($options['lmt_show_author_tt_cb']) && ($options['lmt_show_author_tt_cb'] == 'Default' ) ) {

        $author_id = get_post_meta(get_the_ID(), '_edit_last', true);
        if( isset($options['lmt_enable_tt_author_hyperlink']) && ($options['lmt_enable_tt_author_hyperlink'] == 1 ) ) {
            $lmt_tt_uca = ' by <a href="' . get_author_posts_url($author_id) . '" target="_blank" rel="author">' . get_the_modified_author() . '</a>';
        }
        else {
            $lmt_tt_uca = ' by ' . get_the_modified_author();
        }
    
    } elseif( isset($options['lmt_show_author_tt_cb']) && ($options['lmt_show_author_tt_cb'] == 'Custom' ) ) {
        
        $get_author = $options['lmt_show_author_list_tt'];
        $theauthor = get_user_by( 'id', $get_author );
        if( isset($options['lmt_enable_tt_author_hyperlink']) && ($options['lmt_enable_tt_author_hyperlink'] == 1 ) ) {
            $lmt_tt_uca = ' by <a href="' . get_author_posts_url($get_author) . '" target="_blank" rel="author">' . $theauthor->display_name . '</a>';
        }
        else {
            $lmt_tt_uca = ' by ' . $theauthor->display_name;
        }
    }

    if( isset($options['lmt_enable_human_format_tt_cb']) && ($options['lmt_enable_human_format_tt_cb'] == 1 ) ) {
        $lmt_tt_ud = human_time_diff(get_the_modified_time( 'U' ), current_time( 'U' )) . ' ago';
    } else {
        $lmt_tt_ud = $last_modified_tt;
    }
                   
        
    if(!empty($options['lmt_tt_class_box'])) {

        $get_custom_class = esc_html($options['lmt_tt_class_box']);              
        
        $lmt_template_tag = '<span class="'. $get_custom_class .'">' . $last_modified_text . '<time itemprop="dateModified" datetime="'. get_post_modified_time( apply_filters( 'wplmi_post_schema_format', 'c' ) ) .'">' . $lmt_tt_ud . '</time>' . $lmt_tt_uca . '</span>';

    } else {

        $lmt_template_tag = '<span>' . $last_modified_text . '<time itemprop="dateModified" datetime="'. get_post_modified_time( apply_filters( 'wplmi_post_schema_format', 'c' ) ) .'">' . $lmt_tt_ud . '</time>' . $lmt_tt_uca . '</span>';

    }

    return $lmt_template_tag;
}

function the_last_modified_info () {

    //displays/echos the last modified info.
    echo get_the_last_modified_info();

}



?>