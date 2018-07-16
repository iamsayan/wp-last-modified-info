<?php 
/**
 * Runs on post/page column
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

function lmt_post_admin_actions() {

    function lmt_last_modified_info_on_column( $column, $post_id ) {
        
        switch ( $column ) {
        case 'modified':
            $m_orig	= get_post_field( 'post_modified', $post_id, 'raw' );
            $m_stamp = strtotime( $m_orig );
            $modified = date(get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' ), $m_stamp );
                   $modr_id	= get_post_meta( $post_id, '_edit_last', true );
                   $auth_id	= get_post_field( 'post_author', $post_id, 'raw' );
                   $user_id	= !empty( $modr_id ) ? $modr_id : $auth_id;
                   $user_info = get_userdata( $user_id );
        
                   echo '<p class="lmt-mod-date">';
                   echo '' . $modified . '<br>';
                   echo __( 'by', 'wp-lmi' ) . ' <strong>' . $user_info->display_name . '<strong>';
                   echo '</p>';
            break;
        // end all case breaks
        }
    }
    function lmt_post_columns_display( $columns ) {
        $columns['modified'] = __( 'Last Modified', 'wp-lmi' );
        return $columns;
    }

    // hook into posts
    add_action ( "manage_post_posts_custom_column", "lmt_last_modified_info_on_column", 10, 2);
    // only applicable for posts
    add_filter ( "manage_post_posts_columns", "lmt_post_columns_display", 10, 1 );
    add_action( "manage_edit-post_sortable_columns", "lmt_post_columns_display", 10, 2 );

    // only applicable for pages
    add_filter ( "manage_page_posts_columns", "lmt_post_columns_display", 10, 1 );
    add_action( "manage_edit-page_sortable_columns", "lmt_post_columns_display", 10, 2);
	// hook into pages
	add_action ( "manage_page_posts_custom_column", "lmt_last_modified_info_on_column", 10, 2 );
    

    // select only custom post types
    $args = array(
        //'public'   => true,
        '_builtin' => false
     );
     
    $output = 'names'; // names or objects, note names is the default
    //$operator = 'and';
     
    $post_types = get_post_types( $args, $output ); 
     
    foreach ( $post_types as $ptc ) {

        //add_filter ( "manage_edit-{$ptc}_columns", "lmt_post_columns_display" );
        add_action( "manage_edit-{$ptc}_sortable_columns", "lmt_post_columns_display", 10, 2 );
        add_filter ( "manage_{$ptc}_posts_columns", "lmt_post_columns_display", 10, 1 );
        add_filter ( "manage_{$ptc}_sortable_columns", "lmt_post_columns_display", 10, 2);

        add_action ( "manage_{$ptc}_posts_custom_column", "lmt_last_modified_info_on_column", 10, 2);

    }
}

add_action( 'admin_init', 'lmt_post_admin_actions' );

?>