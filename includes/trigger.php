<?php
/**
 * Trigger plugins functions
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

// get plugin options
$options = get_option('lmt_plugin_global_settings');

// lmi output for posts
if( isset($options['lmt_enable_last_modified_cb']) && ($options['lmt_enable_last_modified_cb'] == 1) ) {
    require_once plugin_dir_path( __FILE__ ) . 'frontend/post-options.php';
}

// enable lmi output for pages
if( isset($options['lmt_enable_last_modified_page_cb']) && ($options['lmt_enable_last_modified_page_cb'] == 1) ) {
    require_once plugin_dir_path( __FILE__ ) . 'frontend/page-options.php';
}

// enable template tags functionality
require_once plugin_dir_path( __FILE__ ) . 'frontend/template-tags.php';

// prrint custom css in  wp head
function lmt_style_hook_in_header() {
    $options = get_option('lmt_plugin_global_settings');
    if( !empty( $options['lmt_custom_style_box']) ) {
        echo '<style type="text/css" id="lmt-custom-css">'."\n". $options['lmt_custom_style_box'] ."\n".'</style>'."\n";
    }
}

// show on admin bar
if( isset($options['lmt_enable_on_admin_bar_cb']) && ($options['lmt_enable_on_admin_bar_cb'] == 1) ) {
    require_once plugin_dir_path( __FILE__ ) . 'frontend/admin-bar.php';
}

// require plugin files
require_once plugin_dir_path( __FILE__ ) . 'backend/dashboard-column.php';
require_once plugin_dir_path( __FILE__ ) . 'backend/dashboard-users.php';
require_once plugin_dir_path( __FILE__ ) . 'backend/dashboard-widget.php';
require_once plugin_dir_path( __FILE__ ) . 'backend/dashboard-edit-screen.php';
require_once plugin_dir_path( __FILE__ ) . 'backend/gutenburg-edit-screen.php';

function lmt_print_admin_post_css() {
    echo '<style type="text/css"> .fixed .column-modified { width:18%; } </style>'."\n";
}

function lmt_print_admin_users_css() { ?>
    <style type="text/css"> .fixed .column-last-updated, .fixed .column-last-login { width:12%; } </style>
    <?php
}

function lmt_add_custom_field_lmi( $post_id ) {

    // get wordpress date time format
    $get_df = get_option( 'date_format' );
    $get_tf = get_option( 'time_format' );
    // get post meta data
    $m_orig	= get_post_field( 'post_modified', $post_id, 'raw' );
    $m_stamp = strtotime( $m_orig );
    $modified = date_i18n( apply_filters( 'wplmi_custom_field_date_time_format', $get_df . ' @ ' . $get_tf ), $m_stamp );
    
    $parameter = '';
    if( apply_filters( 'wplmi_shortcode_on_cf_raw', false ) ) {
        $parameter = ' raw="1"';
    }

    $shortcode = '[lmt-post-modified-info' . $parameter . ']';
    if( is_page() ) {
        $shortcode = '[lmt-page-modified-info' . $parameter . ']';
    }

    // check post meta if not exists
    if ( !add_post_meta( $post_id, 'wp_last_modified_info', $modified, true ) ) {
        // update post meta
        update_post_meta( $post_id, 'wp_last_modified_info', $modified );
    }

    // check post meta if not exists
    if ( !add_post_meta( $post_id, 'wplmi_shortcode', $shortcode, true ) ) {
        // update post meta
        update_post_meta( $post_id, 'wplmi_shortcode', $shortcode );
    }
}

function lmt_post_updated_messages( $messages ) {
    
    // define globally
    global $post;

    // get plugin options
    $options = get_option('lmt_plugin_global_settings');

    // get wordpress date time format
    $get_df = get_option( 'date_format' );
    $get_tf = get_option( 'time_format' );

    $m_orig	= get_post_field( 'post_modified', $post->ID, 'raw' );
    $m_stamp = strtotime( $m_orig );
    $modified = date_i18n( apply_filters( 'wplmi_post_updated_date_time_format', $get_df . ' @ ' . $get_tf ), $m_stamp );

    // get post types returns object
    $object = get_post_type_object( get_post_type( $post ) );
    $args = array(
        'public'   => true,
        //'_builtin' => false
    );
    $post_types = get_post_types( $args, 'names');
    foreach ( $post_types as $screen ) {
        $messages[$screen][1] = esc_html( $object->labels->singular_name ) . ' ' . sprintf(__( 'updated on <strong>%1$s</strong>. <a href="%2$s" target="_blank">View %3$s<a/>', 'wp-last-modified-info' ), $modified, esc_url( get_permalink( $post->ID ) ), $object->capability_type );
    }
    return $messages;
}

// add custom css
add_action( 'wp_head','lmt_style_hook_in_header', 10 );
// add css to admin page
add_action( 'admin_print_styles-edit.php', 'lmt_print_admin_post_css' ); 
add_action( 'admin_print_styles-users.php', 'lmt_print_admin_users_css' ); 
// add last modified timestamp/shortcode in custom field
add_action( 'save_post', 'lmt_add_custom_field_lmi', 10, 1 );
// add last modified timestamp on post/page updated message
add_filter( 'post_updated_messages', 'lmt_post_updated_messages' );

// debug
//add_filter( 'wplmi_shortcode_on_cf_raw', '__return_true' );
?>