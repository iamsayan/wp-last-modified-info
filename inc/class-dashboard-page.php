<?php
/**
 * Runs on Dashboard
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

function lmt_page_admin_actions() {

    function lmt_page_heirch_columns( $column, $post_id ) {

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
	
	function lmt_page_columns( $columns ) {
	    $columns['modified'] = 'Last Modified';
	    return $columns;
	}
	
	add_filter ( "manage_edit-page_columns", "lmt_page_columns" );
    add_filter( "manage_edit-page_sortable_columns", "lmt_page_columns", 10, 2);
	
	add_action ( "manage_pages_custom_column", "lmt_page_heirch_columns", 10, 2 );

}

add_action( 'admin_init', 'lmt_page_admin_actions' );

?>