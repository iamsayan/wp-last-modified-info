<?php
/**
 * Runs on Users page
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

 // create custom column
function lmt_add_items_to_user_table( $columns ) {

	// build custom columns
	$columns['last-login'] = __( 'Last Login', 'wp-last-modified-info' );
	$columns['last-updated'] = __( 'Last Updated', 'wp-last-modified-info' );
	
	return $columns;
}

function lmt_make_users_column_sortable( $columns ) {
	$columns['last-login'] = 'login';
	return $columns;
}

add_filter( 'manage_users_columns', 'lmt_add_items_to_user_table', 10, 3 );
add_filter( 'manage_users_sortable_columns', 'lmt_make_users_column_sortable', 10, 2 );

// last login info
function lmt_user_last_login( $user_login, $user ) {

	// get wordpress date time format
	$get_df = get_option( 'date_format' );
	$get_tf = get_option( 'time_format' );
	// update user meta
	update_user_meta( $user->ID, 'last_login', current_time( $get_df ) . '<br>' . current_time( $get_tf ) );
}

// add action to login
add_action( 'wp_login', 'lmt_user_last_login', 10, 2 );
 
// profile modified info
function lmt_update_profile_modified( $user_id ) {

	// get wordpress date time format
	$get_df = get_option( 'date_format' );
	$get_tf = get_option( 'time_format' );
	// update user meta
	update_user_meta( $user_id, 'profile_last_modified', current_time( $get_df ) . '<br>' . current_time( $get_tf ) );
}

// add action to profile update
add_action( 'profile_update', 'lmt_update_profile_modified' );


function lmt_manage_users_custom_column( $value, $column_name, $user_id ) {
	
	// get author meta
	$chk_login = get_the_author_meta( 'last_login', $user_id, true );
	$chk_mod = get_the_author_meta( 'profile_last_modified', $user_id, true );

	switch ( $column_name ) {
		case 'last-login' :
			if( !$chk_login ) return 'Never';
            return get_the_author_meta( 'last_login', $user_id, true );
			break;
			
		case 'last-updated' :
		    if( !$chk_mod ) return 'Never';
            return get_the_author_meta( 'profile_last_modified', $user_id, true );
			break;
    }
	return $value;
}

// add custom columns value
add_action( 'manage_users_custom_column', 'lmt_manage_users_custom_column', 10, 3 );

/**
 * uncomment this if you want to disable user columns
 */
//add_filter( 'manage_users_columns','lmt_remove_users_columns', 10, 3 );

function lmt_remove_users_columns( $column_headers ) {
	
	// last updated column
	// unset($column_headers['last-updated']);
	// last login column
	//unset($column_headers['last-login']);
	
    //return $column_headers;
}



?>