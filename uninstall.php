<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * @since    1.8.8
 * @package  WP Last Modified Info
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$option_name = 'lmt_plugin_global_settings';
if ( ! is_multisite() ) {
	$options = get_option( $option_name );
	if ( isset( $options['lmt_del_plugin_data_cb'] ) && $options['lmt_del_plugin_data_cb'] == 1 ) {
		wplmi_remove_plugin_data();
	}
} else {
	global $wpdb;

	$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
	$original_blog_id = get_current_blog_id();
	foreach ( $blog_ids as $wp_blog_id ) {
		switch_to_blog( $wp_blog_id );
		$options = get_option( $option_name );
		if ( isset( $options['lmt_del_plugin_data_cb'] ) && $options['lmt_del_plugin_data_cb'] == 1 ) {
			wplmi_remove_plugin_data();
		}
	}
	switch_to_blog( $original_blog_id );
}

/**
 * Removes ALL plugin data
 *
 * @since 1.8.8
 */
function wplmi_remove_plugin_data() {
	// Remove options.
	delete_option( 'lmt_plugin_global_settings' );
	delete_option( 'wplmi_site_global_update_info' );
	delete_option( 'lmt_dashboard_widget_options' );
	delete_option( 'wplmi_plugin_api_data' );

	// Remove post meta.
	delete_post_meta_by_key( '_lmt_disable' );
	delete_post_meta_by_key( '_lmt_disableupdate' );
	delete_post_meta_by_key( '_wplmi_last_modified' );
	delete_post_meta_by_key( 'wp_last_modified_info' );
	delete_post_meta_by_key( 'wplmi_shortcode' );
}
