<?php
/**
 * Runs on Users page
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

add_filter( 'manage_users_columns', 'lmt_add_items_to_user_table', 10, 3 );

// add action to profile update
add_action( 'profile_update', 'lmt_update_profile_modified' );

// add custom columns value
add_action( 'manage_users_custom_column', 'lmt_manage_users_custom_column', 10, 3 );

// create custom column
function lmt_add_items_to_user_table( $columns ) {
	// build custom columns
	$columns['last-updated'] = __( 'Last Updated', 'wp-last-modified-info' );
	
	return $columns;
}

// profile modified info
function lmt_update_profile_modified( $user_id ) {
	// get wordpress date time format
	$get_df = get_option( 'date_format' );
	$get_tf = get_option( 'time_format' );

	// update user meta
	update_user_meta( $user_id, 'profile_last_modified', current_time( $get_df ) . '<br>' . current_time( $get_tf ) );
}

function lmt_manage_users_custom_column( $value, $column_name, $user_id ) {
	// get author meta
	$chk_mod = get_the_author_meta( 'profile_last_modified', $user_id, true );

	switch ( $column_name ) {
		case 'last-updated' :
		    if( !$chk_mod ) return 'Never';
            return get_the_author_meta( 'profile_last_modified', $user_id, true );
			break;
    }
	return $value;
}

?>