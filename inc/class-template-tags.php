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

    $options = get_option('lmt_plugin_global_settings');
    if(!empty($options['lmt_tt_set_format_box'])) {
        $last_modified_tt = get_the_modified_time($options['lmt_tt_set_format_box']);
    } else {
        $last_modified_tt = get_the_modified_time('F jS, Y @ h:i a');
    }

    if(!empty($options['lmt_tt_updated_text_box'])) {
        $last_modified_text = $options['lmt_tt_updated_text_box'];
    } else {
        $last_modified_text = '';
    }

    if( isset($options['lmt_enable_human_format_tt_cb']) && ($options['lmt_enable_human_format_tt_cb'] == 1 ) ) {

        $lmt_tt_ud = human_time_diff(get_the_modified_time( 'U' ), current_time( 'U' )) . ' ago';

    } else {

        $lmt_tt_ud = $last_modified_tt;
    }
                   
        
    if(!empty($options['lmt_tt_class_box'])) {

        $get_custom_class = get_option('lmt_plugin_global_settings')['lmt_tt_class_box'];              
        
        $lmt_template_tag = '<time class="'. $get_custom_class .'" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $last_modified_text . $lmt_tt_ud . '</time>';

    } else {

        $lmt_template_tag = '<time itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $last_modified_text . $lmt_tt_ud . '</time>';

    }
    //returns the last modified info
    return $lmt_template_tag;    
}

function the_last_modified_info () {

    //displays/echos the last modified info.
    echo get_the_last_modified_info();

}



?>