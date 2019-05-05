<?php

/**
 * Plugin tools options
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

 /**
 * Process auto meta update settings
 */
function lmt_check_disable_update_settings() {
	if( empty( $_POST['lmt_check_disable_update_action'] ) || 'lmt_check_disable_update' != $_POST['lmt_check_disable_update_action'] )
		return;
	if( ! wp_verify_nonce( $_POST['lmt_check_nonce'], 'lmt_check_nonce' ) )
		return;
	if( ! current_user_can( 'manage_options' ) )
		return;
	
	$args = array(
		'numberposts'   => -1,
		'post_type'     => 'any'
	);

	$posts = get_posts( $args );
	foreach( $posts as $post ) {
		update_post_meta( $post->ID, '_lmt_disableupdate', 'yes' );
	}

    function lmt_check_disable_update_notice() {
        echo '<div class="notice notice-success is-dismissible">
                 <p><strong>' . __( 'Success! All Checkboxes are checked successfully.', 'wp-last-modified-info' ) . '</strong></p>
             </div>';
    }
    add_action('admin_notices', 'lmt_check_disable_update_notice'); 
}

add_action( 'admin_init', 'lmt_check_disable_update_settings' );

/**
 * Process a settings export that generates a .json file of the shop settings
 */
function lmt_process_settings_export() {
	if( empty( $_POST['lmt_export_action'] ) || 'lmt_export_settings' != $_POST['lmt_export_action'] )
		return;
	if( ! wp_verify_nonce( $_POST['lmt_export_nonce'], 'lmt_export_nonce' ) )
		return;
	if( ! current_user_can( 'manage_options' ) )
		return;
	$settings = get_option( 'lmt_plugin_global_settings' );
	$url = get_site_url();
    $find = array( 'http://', 'https://' );
    $replace = '';
    $output = str_replace( $find, $replace, $url );
	ignore_user_abort( true );
	nocache_headers();
	header( 'Content-Type: application/json; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=' . $output . '-wplmi-export-' . date( 'm-d-Y' ) . '.json' );
	header( "Expires: 0" );
	echo json_encode( $settings );
	exit;
}

add_action( 'admin_init', 'lmt_process_settings_export' );

/**
 * Process a settings import from a json file
 */
function lmt_process_settings_import() {
	if( empty( $_POST['lmt_import_action'] ) || 'lmt_import_settings' != $_POST['lmt_import_action'] )
		return;
	if( ! wp_verify_nonce( $_POST['lmt_import_nonce'], 'lmt_import_nonce' ) )
		return;
	if( ! current_user_can( 'manage_options' ) )
		return;
    $extension = explode( '.', $_FILES['import_file']['name'] );
    $file_extension = end($extension);
	if( $file_extension != 'json' ) {
		wp_die( __( '<strong>Settings import failed:</strong> Please upload a valid .json file to import settings in this website.', 'wp-last-modified-info' ) );
	}
	$import_file = $_FILES['import_file']['tmp_name'];
	if( empty( $import_file ) ) {
		wp_die( __( '<strong>Settings import failed:</strong> Please upload a file to import.', 'wp-last-modified-info' ) );
	}
	// Retrieve the settings from the file and convert the json object to an array.
	$settings = (array) json_decode( file_get_contents( $import_file ) );
    update_option( 'lmt_plugin_global_settings', $settings );
    function lmt_import_success_notice() {
        echo '<div class="notice notice-success is-dismissible">
                 <p><strong>' . __( 'Success! Plugin Settings has been imported successfully.', 'wp-last-modified-info' ) . '</strong></p>
             </div>';
    }
    add_action('admin_notices', 'lmt_import_success_notice'); 
}

add_action( 'admin_init', 'lmt_process_settings_import' );

/**
 * Process reset plugin settings
 */
function lmt_remove_plugin_settings() {
	if( empty( $_POST['lmt_reset_action'] ) || 'lmt_reset_settings' != $_POST['lmt_reset_action'] )
		return;
	if( ! wp_verify_nonce( $_POST['lmt_reset_nonce'], 'lmt_reset_nonce' ) )
		return;
	if( ! current_user_can( 'manage_options' ) )
		return;
    $plugin_settings = 'lmt_plugin_global_settings';
    delete_option( $plugin_settings );

    function lmt_settings_reset_success_notice() {
        echo '<div class="notice notice-success is-dismissible">
                 <p><strong>' . __( 'Success! Plugin Settings reset successfully.', 'wp-last-modified-info' ) . '</strong></p>
             </div>';
    }
    add_action('admin_notices', 'lmt_settings_reset_success_notice'); 
}

add_action( 'admin_init', 'lmt_remove_plugin_settings' );

?>