<?php
/**
 * Trigger plugins functions
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

// add custom css
add_action( 'wp_head','lmt_style_hook_in_header', 10 );

// add css to admin page
add_action( 'admin_print_styles-edit.php', 'lmt_print_admin_post_css' ); 
add_action( 'admin_print_styles-users.php', 'lmt_print_admin_users_css' );
add_action( 'admin_print_footer_scripts-post-new.php', 'lmt_print_admin_cb_auto_check_script' );
add_action( 'admin_print_footer_scripts-post.php', 'lmt_print_admin_du_cb_auto_check_script' );
add_action( 'admin_init', 'lmt_post_do_admin_actions' );

// create action in pre_get_posts hook
add_action( 'pre_get_posts', 'lmt_post_sorting_order_backend' );
add_action( 'pre_get_posts', 'lmt_post_sorting_order_frontend' );

function lmt_post_do_admin_actions() {
    // add last modified timestamp/shortcode in custom field
    add_action( 'save_post', 'lmt_run_action_on_save_post', 10, 3 );
    // add last modified timestamp on post/page updated message
    add_filter( 'post_updated_messages', 'lmt_post_updated_messages', 10, 1 );
}

// prrint custom css in wp head
function lmt_style_hook_in_header() {
    $options = get_option('lmt_plugin_global_settings');
    if( !empty( $options['lmt_custom_style_box']) ) {
        echo '<style type="text/css">'."\n". $options['lmt_custom_style_box'] ."\n".'</style>'."\n";
    }
}

function lmt_print_admin_post_css() {
    echo '<style type="text/css"> .fixed .column-lastmodified { width:18%; } </style>'."\n";
}

function lmt_print_admin_users_css() {
    echo '<style type="text/css"> .fixed .column-last-updated, .fixed .column-last-login { width:12%; } </style>'."\n";
}

function lmt_print_admin_cb_auto_check_script() {
    if( apply_filters( 'wplmi_post_edit_default_check', false ) ) {
        echo "<script>jQuery(document).ready(function ($) { $('#lmt_status').prop( 'checked', true ); });</script>"."\n";
    }
}

function lmt_print_admin_du_cb_auto_check_script() {
    if( apply_filters( 'wplmi_post_disable_update_default_check', false ) ) { ?>
        <script>
            jQuery(document).ready(function ($) {
                $('#lmt_disable').prop( 'checked', true );
                $('input[name="disableupdatehidden"]').val('1');
                $('input[name="disableupdategutenburghidden"]').val('yes');
                $('#change-modified').val('yes');
            });
        </script>
    <?php }
}

function lmt_post_updated_messages( $messages ) {
    // define globally
    global $post;

    if( ! is_object( $post ) ) {
        if( isset( $_GET['post'] ) ) {
            $post_id = $_GET['post'];
            $post = get_post( $post_id );
        }
    }

    // get plugin options
    $options = get_option('lmt_plugin_global_settings');

    // get wordpress date time format
    $get_df = get_option( 'date_format' );
    $get_tf = get_option( 'time_format' );

    $m_orig	= get_post_field( 'post_modified', $post->ID, 'raw' );
    $m_stamp = strtotime( $m_orig );
    $modified = date_i18n( apply_filters( 'wplmi_post_updated_date_time_format', $get_df . ' @ ' . $get_tf ), $m_stamp );

    // get post types returns object
    $object = get_post_type_object( $post->post_type );
    if( is_post_type_viewable( $post->post_type ) ) {
        $link = sprintf(__( ' <a href="%1$s" target="_blank">View %2$s</a>', 'wp-last-modified-info' ), esc_url( get_permalink( $post->ID ) ), $object->capability_type );
    } else {
        $link = '';
    }
    $messages[$post->post_type][1] = esc_html( $object->labels->singular_name ) . ' ' . sprintf(__( 'updated on <strong>%s</strong>.', 'wp-last-modified-info' ), $modified ) . $link;
    
    return $messages;
}

function lmt_run_action_on_save_post( $post_id, $post, $update ) {
    // get wordpress date time format
    $get_df = get_option( 'date_format' );
    $get_tf = get_option( 'time_format' );
    // get post meta data
    $m_orig	= get_post_field( 'post_modified', $post_id, 'raw' );
    $m_stamp = strtotime( $m_orig );
    $modified = date_i18n( apply_filters( 'wplmi_custom_field_date_time_format', $get_df . ' @ ' . $get_tf ), $m_stamp );
    
    $shortcode = '[lmt-post-modified-info]';
    if( is_page() ) {
        $shortcode = '[lmt-page-modified-info]';
    }

    // check post meta if not exists
    if ( ! add_post_meta( $post_id, 'wp_last_modified_info', $modified, true ) ) {
        // update post meta
        update_post_meta( $post_id, 'wp_last_modified_info', $modified );
    }

    // check post meta if not exists
    if ( ! add_post_meta( $post_id, 'wplmi_shortcode', $shortcode, true ) ) {
        // update post meta
        update_post_meta( $post_id, 'wplmi_shortcode', $shortcode );
    }

    // update global site update time
    update_option( 'wplmi_site_global_update_info', time() );
}

function lmt_post_sorting_order_backend( $query ) {
	global $pagenow;
	
    // get plugin options
    $options = get_option('lmt_plugin_global_settings');

    $order = 'desc';
    if( isset($options['lmt_admin_default_sort_order']) && $options['lmt_admin_default_sort_order'] == 'published' ) {
        $order = 'asc';
    }

    if( isset($options['lmt_admin_default_sort_order']) && $options['lmt_admin_default_sort_order'] != 'default' ) {
		if ( is_admin() && 'edit.php' === $pagenow && !isset( $_GET['orderby'] ) ) {
	        $query->set( 'orderby', 'modified' );
            $query->set( 'order', $order );
		}
    }
}

function lmt_post_sorting_order_frontend( $query ) {
	// get plugin options
    $options = get_option('lmt_plugin_global_settings');

    $order = 'desc';
    if( isset($options['lmt_default_sort_order']) && $options['lmt_default_sort_order'] == 'published' ) {
        $order = 'asc';
    }

    if( isset($options['lmt_default_sort_order']) && $options['lmt_default_sort_order'] != 'default' ) {
		if ( $query->is_main_query() && !is_admin() ) {
	        if ( $query->is_home() || $query->is_category() || $query->is_tag() ) {
                $query->set( 'orderby', 'modified' );
                $query->set( 'order', $order );
            }
		}
    }
}

// require plugin files
require_once plugin_dir_path( __FILE__ ) . 'frontend/post.php';
require_once plugin_dir_path( __FILE__ ) . 'frontend/page.php';
require_once plugin_dir_path( __FILE__ ) . 'frontend/template-tags.php';
require_once plugin_dir_path( __FILE__ ) . 'frontend/schema.php';
require_once plugin_dir_path( __FILE__ ) . 'frontend/admin-bar.php';
require_once plugin_dir_path( __FILE__ ) . 'backend/column.php';
require_once plugin_dir_path( __FILE__ ) . 'backend/users.php';
require_once plugin_dir_path( __FILE__ ) . 'backend/widget.php';
require_once plugin_dir_path( __FILE__ ) . 'backend/edit-screen.php';
require_once plugin_dir_path( __FILE__ ) . 'backend/gutenburg.php';
require_once plugin_dir_path( __FILE__ ) . 'backend/notification.php';

?>