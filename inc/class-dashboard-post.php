<?php 

function lmt_post_admin_actions() {

    function lmt_post_columns_data( $column, $post_id ) {
        
        switch ( $column ) {
        case 'modified':
            $m_orig		= get_post_field( 'post_modified', $post_id, 'raw' );
            $m_stamp	= strtotime( $m_orig );
            $modified	= date(get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' ), $m_stamp );
                   $modr_id	= get_post_meta( $post_id, '_edit_last', true );
                   $auth_id	= get_post_field( 'post_author', $post_id, 'raw' );
                   $user_id	= !empty( $modr_id ) ? $modr_id : $auth_id;
                   $user_info	= get_userdata( $user_id );
        
                   echo '<p class="lmt-mod-date">';
                   echo ''.$modified.'<br />';
                   echo 'by <strong>'.$user_info->display_name.'<strong>';
                   echo '</p>';
            break;
        // end all case breaks
        }
    }
    function lmt_post_columns_display( $columns ) {
        $columns['modified'] = 'Last Modified';
        return $columns;
    }

    // hook into all posts
    add_action ( "manage_posts_custom_column", "lmt_post_columns_data", 10, 2);

    // only applicable for posts
    add_filter ( "manage_edit-post_columns", "lmt_post_columns_display");
    add_action( "manage_edit-post_sortable_columns", "lmt_post_columns_display", 10, 2 );
    

    // select only custom post types
    $args = array(
        //'public'   => true,
        '_builtin' => false
     );
     
    $output = 'names'; // names or objects, note names is the default
    //$operator = 'and';
     
    $post_types = get_post_types( $args, $output ); 
     
    foreach ( $post_types  as $ptc ) {

        add_filter ( "manage_edit-{$ptc}_columns", "lmt_post_columns_display");
        add_filter( "manage_edit-{$ptc}_sortable_columns", "lmt_post_columns_display" );

    }
}

add_action( 'admin_init', 'lmt_post_admin_actions' );

?>