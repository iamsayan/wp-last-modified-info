<?php
/**
 * Admin Bar
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @since     v1.2.2
 * @license   http://www.gnu.org/licenses/gpl.html
 */

function lmt_get_post_revision_status() {

    global $post, $post_id;
    $revision = wp_get_post_revisions( $post_id );

    $latest_revision = array_shift( $revision );

    if ( wp_revisions_enabled( $post ) && count( $revision ) >= 1 ) {
        $get_revision = get_admin_url() . 'revision.php?revision=' . $latest_revision->ID;
    } else {
        $get_revision = '';
    }
    return $get_revision;

}

// add a link to the WP Toolbar
function lmt_custom_toolbar_item( $wp_admin_bar ) {

    // If it's admin page, then get out!
    if ( is_admin() ) return;
    
    // If user can't publish posts, then get out
    if ( ! current_user_can( 'publish_posts' ) ) return;
    
    // if modified time is equal to published time, do not show admin bar item
    if ( get_the_modified_time('U') == get_the_time('U') ) return;

    global $post;
    $args = array(
        'id' => 'lmt-update',
        'parent' => 'top-secondary',
        'title'  => sprintf(__( 'Updated %s ago', 'wp-lmi' ), human_time_diff(get_the_modified_time( 'U' ), current_time( 'U' ))),
        'href'   => lmt_get_post_revision_status(),
        'meta' => array(
            //'class'  => 'lmt-ab-icon',
            'title'  => sprintf(__('This %1$s was last updated on %2$s at %3$s by %4$s', 'wp-lmi' ), $post->post_type, get_the_modified_date( get_option( 'date_format' ) ), get_the_modified_time( get_option( 'time_format' ) ), get_the_modified_author() ),
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

function lmt_remove_toolbar_node( $wp_admin_bar ) {
	
	// replace 'updraft_admin_node' with your node id
	$wp_admin_bar->remove_node('lmt-update');

}

/**
 * uncomment this if you want to hide admin bar item
 */
// add_action('admin_bar_menu', 'lmt_remove_toolbar_node', 999);

?>