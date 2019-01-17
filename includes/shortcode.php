<?php 
/**
 * Shortcode
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

// get plugin options
$options = get_option('lmt_plugin_global_settings');

// lmi output for posts
if( isset($options['lmt_enable_last_modified_cb']) && ($options['lmt_enable_last_modified_cb'] == 1) ) {
    add_shortcode('lmt-post-modified-info', 'lmt_post_modified_info_shortcode');
}

// enable lmi output for pages
if( isset($options['lmt_enable_last_modified_page_cb']) && ($options['lmt_enable_last_modified_page_cb'] == 1) ) {
    add_shortcode('lmt-page-modified-info', 'lmt_page_modified_info_shortcode');
}

function lmt_post_modified_info_shortcode( $atts ) {

    require plugin_dir_path( __FILE__ ) . 'frontend/post.php';

    // get date time formats
    $pub_time = get_the_time('U');
    $mod_time = get_the_modified_time( 'U' );

    // if modified time is equal to published time, do not show
    if ( $mod_time < $pub_time+apply_filters( 'wplmi_date_time_diff_post', '0' ) ) return;

    $html_output = 0;
    $atts = shortcode_atts(
		array(
			'raw' => $html_output,
        ), $atts, 'lmt-post-modified-info' );
        
    if ( isset( $modified_content ) && is_single() ) {
        if( isset( $atts['raw'] ) && $atts['raw'] == '1' ) {
            return strip_tags( $modified_content, '<span><time><a>' );
        }
        return $modified_content;
    }

    if( isset($options['lmt_show_on_homepage']) && ($options['lmt_show_on_homepage'] == 'yes') ) {
        if ( isset( $modified_content ) && ( is_home() || is_author() || is_category() || is_tag() ) ) { 
            if( isset( $atts['raw'] ) && $atts['raw'] == '1' ) {
                return strip_tags( $modified_content, '<span><time><a>' );
            }
            return $modified_content;
        }
    }
}

function lmt_page_modified_info_shortcode( $atts ) {

    require plugin_dir_path( __FILE__ ) . 'frontend/page.php';

    // get date time formats
    $pub_time = get_the_time('U');
    $mod_time = get_the_modified_time( 'U' );

    // if modified time is equal to published time, do not show
    if ( $mod_time < $pub_time+apply_filters( 'wplmi_date_time_diff_page', '0' ) ) return;
    
    $html_output = 0;
    $atts = shortcode_atts(
		array(
			'raw' => $html_output,
		), $atts, 'lmt-page-modified-info' );
    
    if ( isset( $modified_content ) && is_page() ) {
        if( isset( $atts['raw'] ) && $atts['raw'] == '1' ) {
            return strip_tags( $modified_content, '<span><time><a>' );
        }
        return $modified_content;
    }
}

?>