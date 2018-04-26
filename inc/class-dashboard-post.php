<?php 

add_action ( 'manage_posts_custom_column',	'lmt_post_columns_data',	10,	2	);
    add_filter ( 'manage_edit-post_columns',	'lmt_post_columns_display'			);
    function lmt_post_columns_data( $column, $post_id ) {
        switch ( $column ) {
        case 'modified':
            $m_orig		= get_post_field( 'post_modified', $post_id, 'raw' );
            $m_stamp	= strtotime( $m_orig );
            $modified	= date('n/j/y @ g:i a', $m_stamp );
                   $modr_id	= get_post_meta( $post_id, '_edit_last', true );
                   $auth_id	= get_post_field( 'post_author', $post_id, 'raw' );
                   $user_id	= !empty( $modr_id ) ? $modr_id : $auth_id;
                   $user_info	= get_userdata( $user_id );
        
                   echo '<p class="mod-date">';
                   echo '<em>'.$modified.'</em><br />';
                   echo 'by <strong>'.$user_info->display_name.'<strong>';
                   echo '</p>';
            break;
        // end all case breaks
        }
    }
    function lmt_post_columns_display( $columns ) {
        $columns['modified']	= 'Last Modified';
        return $columns;
    }

    add_filter( "manage_edit-post_sortable_columns", "lmt_post_columns_display" );

?>