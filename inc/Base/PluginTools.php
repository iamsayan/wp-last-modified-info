<?php
/**
 * Plugin Tools.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Base
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Base;

use Wplmi\Helpers\Ajax;
use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Admin Notice class.
 */
class PluginTools
{
	use Ajax;
    use Hooker;
    use HelperFunctions;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( 'admin_init', 'export_settings' );
		$this->action( 'admin_init', 'import_settings' );
		$this->action( 'admin_notices', 'admin_notice' );
		$this->ajax( 'process_set_meta', 'set_meta' );
		$this->ajax( 'process_copy_data', 'copy_data' );
		$this->ajax( 'process_import_plugin_data', 'import_data' );
		$this->ajax( 'process_delete_plugin_data', 'remove_settings' );
	}

	/**
     * Process a settings export that generates a .json file
     */
	public function export_settings() {
		if ( empty( $_POST['wplmi_export_action'] ) || 'wplmi_export_settings' !== $_POST['wplmi_export_action'] ) {
			return;
		}

		if ( ! isset( $_POST['wplmi_export_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wplmi_export_nonce'] ) ), 'wplmi_export_nonce' ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$settings = get_option( 'lmt_plugin_global_settings' );
		$url = get_home_url();
		$find = [ 'http://', 'https://' ];
		$replace = '';
		$output = str_replace( $find, $replace, $url );

		ignore_user_abort( true );
		nocache_headers();
		header( 'Content-Type: application/json; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=' . str_replace( '/', '-', $output ) . '-wplmi-export-' . date( 'm-d-Y' ) . '.json' );
		header( "Expires: 0" );

		echo wp_json_encode( $settings );
		exit;
	}

	/**
     * Process a settings import from a json file
     */
	public function import_settings() {
    	if ( empty( $_POST['wplmi_import_action'] ) || 'wplmi_import_settings' !== $_POST['wplmi_import_action'] ) {
    		return;
		}

    	if ( ! isset( $_POST['wplmi_import_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wplmi_import_nonce'] ) ), 'wplmi_import_nonce' ) ) {
    		return;
		}

    	if ( ! current_user_can( 'manage_options' ) ) {
    		return;
		}

        $extension = explode( '.', sanitize_text_field( $_FILES['import_file']['name'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
        $file_extension = end( $extension );
    	if ( 'json' !== $file_extension ) {
    		wp_die( sprintf( '<strong>%s</strong>: %s',
				esc_html__( 'Settings import failed', 'wp-last-modified-info' ),
				esc_html__( 'Please upload a valid .json file to import settings in this website.', 'wp-last-modified-info' )
			) );
    	}

    	$import_file = sanitize_text_field( $_FILES['import_file']['tmp_name'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
    	if ( empty( $import_file ) ) {
			wp_die( sprintf( '<strong>%s</strong>: %s',
				esc_html__( 'Settings import failed', 'wp-last-modified-info' ),
				esc_html__( 'Please upload a file to import.', 'wp-last-modified-info' )
			) );
    	}

    	// Retrieve the settings from the file and convert the json object to an array.
    	$settings = (array) json_decode( file_get_contents( $import_file ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		update_option( 'lmt_plugin_global_settings', $settings, false );

		// set temporary transient for admin notice
		set_transient( 'wplmi_import_db_done', true );

		wp_safe_redirect( add_query_arg( 'page', 'wp-last-modified-info', admin_url( 'options-general.php' ) ) );
		exit;
	}

	/**
     * Process post meta data update
     */
	public function set_meta() {
		// security check
		$this->verify_nonce();

		if ( ! isset( $_POST['action_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			$this->error();
		}

		$action = sanitize_text_field( wp_unslash( $_POST['action_type'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$value = ( $action == 'check' ) ? 'yes' : 'no';

		$args = [
			'numberposts' => -1,
			'post_type'   => array_keys( $this->get_post_types() ),
			'post_status' => [ 'publish', 'draft', 'pending', 'future' ],
			'fields'      => 'ids',
		];

		$posts = get_posts( $args );
		if ( ! empty( $posts ) ) {
	    	foreach ( $posts as $post_id ) {
	    		$this->update_meta( $post_id, '_lmt_disableupdate', $value );
	    	}
	    }

		$this->success( [
			'reload' => false,
		] );
	}

	/**
     * Process a settings export from ajax request
     */
	public function copy_data() {
		// security check
		$this->verify_nonce();

		$option = get_option( 'lmt_plugin_global_settings' );

		$this->success( [
			'elements' => wp_json_encode( $option ),
		] );
	}

	/**
     * Process a settings import from ajax request
     */
	public function import_data() {
		// security check
		$this->verify_nonce();

		if ( ! current_user_can( 'manage_options' ) ) {
    		$this->error();
		}

		if ( ! isset( $_REQUEST['settings_data'] ) ) {
			$this->error();
		}

		$data = wp_unslash( $_REQUEST['settings_data'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$settings = (array) json_decode( $data );

		if ( is_array( $settings ) && ! empty( $settings ) ) {
			update_option( 'lmt_plugin_global_settings', $settings, false );

			// set temporary transient for admin notice
		    set_transient( 'wplmi_import_db_done', true );
		}

		$this->success();
	}

	/**
     * Process reset plugin settings
     */
	public function remove_settings() {
    	// security check
		$this->verify_nonce();

		// Remove options
		delete_option( 'lmt_plugin_global_settings' );
		delete_option( 'wplmi_site_global_update_info' );
		delete_option( 'lmt_dashboard_widget_options' );
		delete_option( 'wplmi_plugin_api_data' );

		// Remove post metas
		delete_post_meta_by_key( '_lmt_disable' );
		delete_post_meta_by_key( '_lmt_disableupdate' );
		delete_post_meta_by_key( '_wplmi_last_modified' );
		delete_post_meta_by_key( 'wp_last_modified_info' );
		delete_post_meta_by_key( 'wplmi_shortcode' );

		$this->success( [
			'reload' => true,
		] );
	}

	/**
     * Process reset plugin settings
     */
	public function admin_notice() {
    	if ( get_transient( 'wplmi_import_db_done' ) !== false ) { ?>
			<div class="notice notice-success is-dismissible"><p><strong><?php esc_html_e( 'Success! Plugin Settings has been imported successfully.', 'wp-last-modified-info' ); ?></strong></p></div><?php
		    delete_transient( 'wplmi_import_db_done' );
	    }
	}
}
