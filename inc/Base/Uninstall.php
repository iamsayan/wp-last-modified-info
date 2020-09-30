<?php
/**
 * Uninstallation hook.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Base
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Base;

/**
 * Uninstall class.
 */
class Uninstall
{
	/**
	 * Run plugin uninstallation process.
	 */
	public static function uninstall()
	{
		$option_name = 'lmt_plugin_global_settings';
		
		if ( ! is_multisite() ) {
			$options = get_option( $option_name );
			if ( isset( $options['lmt_del_plugin_data_cb'] ) && $options['lmt_del_plugin_data_cb'] == 1 ) {
				self::uninstaller();
			}
		} else {
			global $wpdb;
			
			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			$original_blog_id = get_current_blog_id();
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				$options = get_option( $option_name );
				if ( isset( $options['lmt_del_plugin_data_cb'] ) && $options['lmt_del_plugin_data_cb'] == 1 ) {
					self::uninstaller();
				}
			}
			switch_to_blog( $original_blog_id );
		}
	}

	/**
	 * Run plugin uninstallation process.
	 */
	public static function uninstaller()
	{
		delete_option( 'lmt_plugin_global_settings' );
		delete_option( 'wplmi_site_global_update_info' );
		delete_option( 'lmt_dashboard_widget_options' );
		delete_option( 'wplmi_plugin_api_data' );

		$args = [
			'numberposts'   => -1,
			'post_type'     => 'any',
			'post_status'   => 'any',
		];
	
		$posts = get_posts( $args );
		if ( ! empty( $posts ) ) {
	    	foreach ( $posts as $post ) {
	    		delete_post_meta( $post->ID, '_lmt_disable' );
	    		delete_post_meta( $post->ID, '_lmt_disableupdate' );
	    		delete_post_meta( $post->ID, '_wplmi_last_modified' );
	    		delete_post_meta( $post->ID, 'wp_last_modified_info' );
	    		delete_post_meta( $post->ID, 'wplmi_shortcode' );
	    	}
	    }
	}
}