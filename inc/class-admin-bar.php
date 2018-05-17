<?php
/**
 * Template Tags
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @since     v1.2.2
 * @license   http://www.gnu.org/licenses/gpl.html
 */

// add a link to the WP Toolbar
function lmt_custom_toolbar_link( $wp_admin_bar ) {

    if (is_singular() && is_user_logged_in() && (get_the_modified_time('U') > get_the_time('U'))) {

        global $post;

    $args = array(
        'id' => 'lmt-update',
        'title' => '<span class="ab-icon"></span>Updated ' . human_time_diff(get_the_modified_time( 'U' ), current_time( 'U' )) . ' ago',
        //'href' => get_admin_url() . 'edit.php?post_type=' . $post->post_type, 
        'meta' => array(
            //'class' => 'lmt-ab-icon',
            'title' => 'This ' . $post->post_type . ' was last updated on ' . get_the_modified_time( get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' ) ) . ' by ' . get_the_modified_author()
            )
    );
    
    $wp_admin_bar->add_node($args);
    
    }

}
add_action('admin_bar_menu', 'lmt_custom_toolbar_link', 999);

function lmt_add_admin_bar_object() { ?>
  <style type="text/css">

  #wpadminbar #wp-admin-bar-lmt-update .ab-icon:before {
    content: '\f469';
    top: 2px;
   }

</style>
<?php
}

add_action('wp_head', 'lmt_add_admin_bar_object', 10);

?>