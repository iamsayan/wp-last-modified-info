<?php
/**
 * Trigger plugins functions
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

// get plugin settings
$options = get_option('lmt_plugin_global_settings');

// lmi output for posts
if( isset($options['lmt_enable_last_modified_cb']) && ($options['lmt_enable_last_modified_cb'] == 1) ) {
    require plugin_dir_path( __FILE__ ) . 'frontend/post-options.php';
}

// enable lmi output for pages
if( isset($options['lmt_enable_last_modified_page_cb']) && ($options['lmt_enable_last_modified_page_cb'] == 1) ) {
    require plugin_dir_path( __FILE__ ) . 'frontend/page-options.php';
}

// enable template tags functionality
if( isset($options['lmt_tt_enable_cb']) && ($options['lmt_tt_enable_cb'] == 1) ) {
    require plugin_dir_path( __FILE__ ) . 'frontend/template-tags.php';
}

// prrint custom css in  wp head
function lmt_style_hook_in_header() {
    if( !empty( get_option('lmt_plugin_global_settings')['lmt_custom_style_box']) ) {
        echo '<style type="text/css" id="lmt-custom-css">'."\n". get_option('lmt_plugin_global_settings')['lmt_custom_style_box'] ."\n".'</style>'."\n";
    }
}

// show on admin bar
if( isset($options['lmt_enable_on_admin_bar_cb']) && ($options['lmt_enable_on_admin_bar_cb'] == 1) ) {
    require plugin_dir_path( __FILE__ ) . 'frontend/admin-bar.php';
}

require plugin_dir_path( __FILE__ ) . 'backend/dashboard-column.php';
require plugin_dir_path( __FILE__ ) . 'backend/dashboard-users.php';
require plugin_dir_path( __FILE__ ) . 'backend/dashboard-widget.php';

function lmt_show_on_dashboard () {
    // get modified time with a particular format
    $lmt_updated_time = get_the_modified_time('M j, Y @ H:i');
    if ( get_the_modified_time('U') > get_the_time('U') ) {
        echo '<div class="misc-pub-section curtime misc-pub-last-updated"><span id="lmt-timestamp"> Updated on: <b>' . $lmt_updated_time . '</b></span></div>';
    }
}

function lmt_print_admin_post_css() {
    echo '<style type="text/css"> .fixed .column-modified { width:18%; } </style>'."\n";
}

function lmt_print_admin_users_css() {
    echo '<style type="text/css"> .fixed .column-last-updated, .fixed .column-last-login { width:12%; } </style>'."\n";
}

function lmt_print_admin_meta_box_css() {
    echo '<style type="text/css">
            .curtime #lmt-timestamp:before {
                content:"\f469";
                font: 400 20px/1 dashicons;
                speak: none;
                display: inline-block;
                margin-left: -1px;
                padding-right: 3px;
                vertical-align: top;
                -webkit-font-smoothing: antialiased;
                color: #82878c;
            }
        </style>'."\n";
}

function lmt_add_custom_field_lmi( $post_id ) {
    // get post meta data
    $m_orig	= get_post_field( 'post_modified', $post_id, 'raw' );
    $m_stamp = strtotime( $m_orig );
    $modified = date(apply_filters('custom_field_date_time_format', get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' )), $m_stamp );
    
    if ( !add_post_meta( $post_id, 'wp_last_modified_info', $modified, true ) ) {
        update_post_meta( $post_id, 'wp_last_modified_info', $modified );
    }
}

function lmt_post_updated_messages( $messages ) {
    // define globally
    global $post, $post_ID;
    $options = get_option('lmt_plugin_global_settings');
    $object = get_post_type_object( get_post_type( $post ) );
    $args = array(
        'public'   => true,
        //'_builtin' => false
    );
    $post_types = get_post_types( $args, 'names');
    foreach ( $post_types as $screen ) {
        $messages[$screen][1] = esc_html( $object->labels->singular_name ) . ' updated on <strong>' . get_the_modified_time( apply_filters('post_updated_date_time_format', get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' ) ) ) . '</strong>. ' . sprintf( __('<a href="%s">View ' . $object->capability_type . '</a>'), esc_url( get_permalink( $post_ID ) ) );
    }
    return $messages;
}

// add custom css
add_action( 'wp_head','lmt_style_hook_in_header', 10 );
// add post publish box item
add_action( 'post_submitbox_misc_actions', 'lmt_show_on_dashboard');
// add css to post edit page
add_action( 'admin_print_styles-post.php', 'lmt_print_admin_meta_box_css' ); 
//add_action( 'admin_print_styles-post-new.php', 'lmt_print_admin_meta_box_css' );
add_action( 'admin_print_styles-edit.php', 'lmt_print_admin_post_css' ); 
add_action( 'admin_print_styles-users.php', 'lmt_print_admin_users_css' ); 
// add last modified timestamp in custom field
add_action( 'save_post', 'lmt_add_custom_field_lmi', 10, 2 );
// add last modified timestamp on post/page updated message
add_filter( 'post_updated_messages', 'lmt_post_updated_messages' );


function lmt_custom_field_date_time_format() {

    // You can change this if you want to set custom format.
    $format = 'F jS Y @ h:i a';
    return $format;
}

//add_filter( 'custom_field_date_time_format', 'lmt_custom_field_date_time_format' );
?>