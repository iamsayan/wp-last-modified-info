<?php 
/**
 * Template Tags
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @since     v2.0.0
 * @license   http://www.gnu.org/licenses/gpl.html
 */


function get_last_modified_info () {

    $options = get_option('lmt_plugin_global_settings');
    if($options['lmt_tt_set_format_box']) {
        $last_modified_tt = get_the_modified_time($options['lmt_tt_set_format_box']);
    } else {
        $last_modified_tt = get_the_modified_time('F jS, Y @ h:i a');
    }
                   
        
    if(($options['lmt_tt_class_box'])) {

        $get_custom_class = get_option('lmt_plugin_global_settings')['lmt_tt_class_box'];              
        
            echo '<time class="'. $get_custom_class .'" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $last_modified_tt . '</time>';

        } else {

            echo '<time class="last-modified-tt" itemprop="dateModified" datetime="'. get_post_modified_time('c') .'">' . $last_modified_tt . '</time>';

        }
    
}

?>