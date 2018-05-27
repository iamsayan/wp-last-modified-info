<?php

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
	ignore_user_abort( true );
	nocache_headers();
	header( 'Content-Type: application/json; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=lmt-settings-export-' . date( 'm-d-Y' ) . '.json' );
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
		wp_die( __( 'Please upload a valid .json file' ) );
	}
	$import_file = $_FILES['import_file']['tmp_name'];
	if( empty( $import_file ) ) {
		wp_die( __( 'Please upload a file to import' ) );
	}
	// Retrieve the settings from the file and convert the json object to an array.
	$settings = (array) json_decode( file_get_contents( $import_file ) );
    update_option( 'lmt_plugin_global_settings', $settings );
    //wp_safe_redirect( admin_url( 'admin.php?page=wp-last-modified-info' ) ); exit;
    function lmt_import_success_notice(){
        echo '<div class="notice notice-success is-dismissible">
                 <p><strong>Success! Plugin Settings has been imported successfully.</strong></p>
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

    function lmt_settings_reset_success_notice(){
        echo '<div class="notice notice-success is-dismissible">
                 <p><strong>Success! Plugin Settings reset successfully.</strong></p>
             </div>';
    }
    add_action('admin_notices', 'lmt_settings_reset_success_notice'); 
}
add_action( 'admin_init', 'lmt_remove_plugin_settings' );
?>