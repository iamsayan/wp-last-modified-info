<?php 
/**
 * Shortcode
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

add_shortcode('lmt-post-modified-info', 'lmt_post_modified_info_shortcode');
add_shortcode('lmt-page-modified-info', 'lmt_page_modified_info_shortcode');

function lmt_post_modified_info_shortcode() {

    include 'post.php';
    if( is_single() && (get_the_modified_time('U') > get_the_time('U')) && isset($modified_content) ) {
        return $modified_content;
    }
    return;
}

function lmt_page_modified_info_shortcode() {

    include 'page.php';
    if( is_page() && (get_the_modified_time('U') > get_the_time('U')) && isset($modified_content) ) {
        return $modified_content;
    }
    return;
}


?>