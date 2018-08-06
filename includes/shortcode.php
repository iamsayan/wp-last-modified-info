<?php 
/**
 * Shortcode
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

// add shortcodes
add_shortcode('lmt-post-modified-info', 'lmt_post_modified_info_shortcode');
add_shortcode('lmt-page-modified-info', 'lmt_page_modified_info_shortcode');

function lmt_post_modified_info_shortcode() {

    include plugin_dir_path( __FILE__ ) . 'frontend/post.php';

    // get date time formats
    $pub_time = get_the_time('U');
    $mod_time = get_the_modified_time( 'U' );

    // If it's not post page, then get out!
    if ( !is_single() ) return;
    
    // If modified_content is not set, then get out
    if ( ! isset($modified_content) ) return;
    
    // if modified time is equal to published time, do not show
    if ( $mod_time <= $pub_time+apply_filters( 'wplmi_date_time_diff_post', '0' ) ) return;
    
    return $modified_content;
}

function lmt_page_modified_info_shortcode() {

    include plugin_dir_path( __FILE__ ) . 'frontend/page.php';

    // get date time formats
    $pub_time = get_the_time('U');
    $mod_time = get_the_modified_time( 'U' );

    // If it's not page, then get out!
    if ( !is_page() ) return;
    
    // If modified_content is not set, then get out
    if ( ! isset($modified_content) ) return;
    
    // if modified time is equal to published time, do not show
    if ( $mod_time <= $pub_time+apply_filters( 'wplmi_date_time_diff_page', '0' ) ) return;
    
    return $modified_content;
}

?>