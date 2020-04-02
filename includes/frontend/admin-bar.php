<?php

/**
 * Admin Bar
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @since     v1.2.2
 * @license   http://www.gnu.org/licenses/gpl.html
 */

add_action( 'init', 'lmt_plugin_init_admin_bar_display' );

function lmt_plugin_init_admin_bar_display() {
    $options = get_option('lmt_plugin_global_settings');

    if( isset($options['lmt_enable_on_admin_bar_cb']) && ($options['lmt_enable_on_admin_bar_cb'] == 1) ) {
        add_action( 'admin_bar_menu', 'lmt_custom_toolbar_item', 999 );
    }
}

function lmt_get_post_revision() {
    global $post, $post_id;

    // If user can't edit post, then don't show
    if( ! current_user_can( 'edit_post', $post_id ) ) return;

    $revision = wp_get_post_revisions( $post_id );

    $latest_revision = array_shift( $revision );

    if ( wp_revisions_enabled( $post ) && count( $revision ) >= 1 ) {
        return get_admin_url() . 'revision.php?revision=' . $latest_revision->ID;
    }

    return;
}

function lmt_adminbar_info() {
    // retrive date time formats
    $cur_time = current_time('U');
    $mod_time = get_the_modified_time( 'U' );
    $org_time = get_the_time('U');

    if ( $mod_time > $cur_time || $org_time > $mod_time ) {
        return sprintf( __( 'Updated on %1$s at %2$s', 'wp-last-modified-info' ), get_the_modified_date( 'M j' ), get_the_modified_time() );
    }
    return sprintf( __( 'Updated %s ago', 'wp-last-modified-info' ), human_time_diff( get_the_modified_time( 'U' ), $cur_time ) );
}

// add a link to the WP Toolbar
function lmt_custom_toolbar_item( $wp_admin_bar ) {
    // If it's admin page, then get out!
    if( is_admin() ) return;

    // If it's archive pages, then get out!
    if( is_home() || is_author() || is_category() || is_tag() || is_404() ) return;
    
    // If user can't publish posts, then get out
    if( ! current_user_can( 'publish_posts' ) ) return;

    if( get_post_status( get_the_ID() ) == 'auto-draft' ) {
		return;
    }
    
    $object = get_post_type_object( get_post_type( get_the_ID() ) );
    $args = array(
        'id' => 'lmt-update',
        'parent' => 'top-secondary',
        'title'  => lmt_adminbar_info(),
        'href'   => lmt_get_post_revision(),
        'meta' => array(
            'title'  => sprintf( __( 'This %1$s was last updated on %2$s at %3$s by %4$s', 'wp-last-modified-info' ), get_post_type( get_the_ID() ), get_the_modified_date(), get_the_modified_time(), get_the_modified_author() ),
            'target' => '_blank',
        )
    );

    $wp_admin_bar->add_node( $args );
}

?>