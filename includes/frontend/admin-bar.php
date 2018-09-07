<?php
/**
 * Admin Bar
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @since     v1.2.2
 * @license   http://www.gnu.org/licenses/gpl.html
 */

function lmt_get_post_revision() {

    global $post, $post_id;

    // If user can't edit post, then don't show
    if( ! current_user_can('edit_post', $post_id) ) return;

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
    $get_df = get_option( 'date_format' );
    $get_tf = get_option( 'time_format' );

    if ( $mod_time > $cur_time ) {
        return sprintf(__( 'Updated on %1$s at %2$s', 'wp-last-modified-info' ), get_the_modified_date( 'M g' ), get_the_modified_time( $get_tf ));
    }
    return sprintf(__( 'Updated %s ago', 'wp-last-modified-info' ), human_time_diff(get_the_modified_time( 'U' ), $cur_time));
}

// add a link to the WP Toolbar
function lmt_custom_toolbar_item( $wp_admin_bar ) {

    // get wp date time formats
    $get_df = get_option( 'date_format' );
    $get_tf = get_option( 'time_format' );
    
    // If it's admin page, then get out!
    if ( is_admin() ) return;
    
    // If user can't publish posts, then get out
    if ( ! current_user_can( 'publish_posts' ) ) return;
    
    // if modified time is equal to published time, do not show admin bar item
    if ( get_the_modified_time('U') <= get_the_time('U') ) return;

    global $post;
    $object = get_post_type_object( get_post_type( $post ) );
    $args = array(
        'id' => 'lmt-update',
        'parent' => 'top-secondary',
        'title'  => lmt_adminbar_info(),
        'href'   => lmt_get_post_revision(),
        'meta' => array(
            //'class'  => 'lmt-ab-icon',
            'title'  => sprintf(__('This %1$s was last updated on %2$s at %3$s by %4$s', 'wp-last-modified-info' ), $post->post_type, get_the_modified_date( $get_df ), get_the_modified_time( $get_tf ), get_the_modified_author() ),
            'target' => '_blank',
        )
    );
    $wp_admin_bar->add_node($args);

}
add_action('admin_bar_menu', 'lmt_custom_toolbar_item', 999);

function lmt_add_admin_bar_object() { 
    
    if ( ! is_admin_bar_showing() ) return; ?>

    <style type="text/css">
        #wpadminbar #wp-admin-bar-lmt-update .ab-icon:before {
            content: '\f469'; 
            top: 2px;
        }
    </style>
<?php
}

/**
 * use this if you want to add some dashicons before admin bar item
 */
//add_action('wp_head', 'lmt_add_admin_bar_object', 10);

?>