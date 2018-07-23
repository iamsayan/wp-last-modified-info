<?php
/**
 * Runs on Uninstall of WP Last Modified Info
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 * @since     v1.0
 */

// Exit if accessed directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

// Make sure that we are uninstalling
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

// Leave no trail
$plugin_option = 'lmt_plugin_global_settings';

if ( !is_multisite() ) {
	
    $options = get_option( $plugin_option );
	
	if ( isset($options['lmt_del_plugin_data_cb']) && $options['lmt_del_plugin_data_cb'] == 1 ) {
	
		// Remove all plugin settings
		delete_option( $plugin_option );
	}

} else { 

	// This is a multisite
	//
	// @since 1.3.1

    global $wpdb;
	
    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
    $original_blog_id = get_current_blog_id();
    foreach ( $blog_ids as $blog_id ) {
		
        switch_to_blog( $blog_id );
		
		$options = get_option( $plugin_option );
		
		if ( isset($options['lmt_del_plugin_data_cb']) && $options['lmt_del_plugin_data_cb'] == 1 ) {
			
			// Remove all plugin settings
			delete_option( $plugin_option );
		}
    }
    switch_to_blog( $original_blog_id );
}