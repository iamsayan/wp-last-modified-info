<?php
/**
 * Runs on Users page
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

// last login info
function lmt_user_last_login( $user_login, $user ) {
	update_user_meta( $user->ID, 'last_login', current_time( get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' ) ) );
}

add_action( 'wp_login', 'lmt_user_last_login', 10, 2 );

function lmt_add_last_login_user_column( $columns ) {
    return array_merge( $columns, array( 'last-login' => __( 'Last Login', 'wp-last-modified-info' ) ) );
}

add_action( 'manage_users_columns', 'lmt_add_last_login_user_column' );
//add_filter( 'manage_users_sortable_columns', 'lmt_add_last_login_user_column' );
 
function lmt_main_lastlogin($get_login_value, $login_column_name, $user_id) { 

    if ( 'last-login' == $login_column_name ) {
	    $user_info = get_userdata( $user_id );
	    $last_login_info = $user_info->last_login;
      	$get_login_value = $last_login_info;
    }
	return $get_login_value; 
} 

add_action( 'manage_users_custom_column', 'lmt_main_lastlogin', 10, 3 );

// profile modified info
function lmt_update_profile_modified( $user_id ) {
	update_user_meta( $user_id, 'profile_last_modified', current_time( get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' ) ) );
}

add_action( 'profile_update', 'lmt_update_profile_modified' );

function lmt_profile_update_user_column( $columns ) {
	return array_merge( $columns, array( 'last-updated' => __( 'Last Updated', 'wp-last-modified-info' ) ) );
}

add_action( 'manage_users_columns', 'lmt_profile_update_user_column' );
//add_filter( 'manage_users_sortable_columns', 'lmt_profile_update_user_column' );

function lmt_manage_users_custom_column( $profile_update_get_value, $profile_column_name, $user_id ) {
	if ( 'last-updated' == $profile_column_name ) {
		$user_info = get_userdata( $user_id );
		$profile_last_modified = $user_info->profile_last_modified;
		$profile_update_get_value = $profile_last_modified;
	}
	return $profile_update_get_value;
}

add_action( 'manage_users_custom_column', 'lmt_manage_users_custom_column', 10, 3 );

?>