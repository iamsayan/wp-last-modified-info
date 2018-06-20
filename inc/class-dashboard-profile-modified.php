<?php
/**
 * Runs on Dashboard
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

// profile modified info
function lmt_update_profile_modified( $user_id ) {
	update_user_meta( $user_id, 'profile_last_modified', current_time( get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' ) ) );
}

add_action( 'profile_update', 'lmt_update_profile_modified' );

function lmt_add_extra_user_column( $columns ) {
	return array_merge( $columns, array( 'last-updated' => __( 'Last Updated' ) ) );
}

add_action( 'manage_users_columns', 'lmt_add_extra_user_column' );

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