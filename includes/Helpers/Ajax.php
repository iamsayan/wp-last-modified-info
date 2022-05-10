<?php
/**
 * Ajax Helpers.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Helpers
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Ajax class.
 */
trait Ajax {

	/**
	 * Hooks a function on to a specific ajax action
	 *
	 * @param string   $tag             The name of the action to which the $function_to_add is hooked.
	 * @param callable $function_to_add The name of the function you wish to be called.
	 * @param int      $priority        Optional. Used to specify the order in which the functions
	 *                                  associated with a particular action are executed. Default 10.
	 *                                  Lower numbers correspond with earlier execution,
	 *                                  and functions with the same priority are executed
	 *                                  in the order in which they were added to the action.
	 */
	protected function ajax( $tag, $function_to_add, $priority = 10 ) {
		\add_action( 'wp_ajax_wplmi_' . $tag, [ $this, $function_to_add ], $priority );
	}

	/**
	 * Verify request nonce
	 *
	 * @param string $action The nonce action name.
	 */
	protected function verify_nonce( $action = 'wplmi_admin_nonce' ) {
		if ( ! isset( $_REQUEST['security'] ) || ! \wp_verify_nonce( $_REQUEST['security'], $action ) ) {
			$this->error( __( 'Error: Nonce verification failed', 'wp-last-modified-info' ) );
		}
	}

	/**
	 * Wrapper function for sending success response
	 *
	 * @param mixed $data Data to send to response.
	 */
	protected function success( $data = null ) {
		$this->send( $data );
	}

	/**
	 * Wrapper function for sending error
	 *
	 * @param mixed $data Data to send to response.
	 */
	protected function error( $data = null ) {
		if ( is_null( $data ) ) {
			$data = __( 'Error: Requested actions not found!', 'wp-last-modified-info' );
		}
		$this->send( $data, false );
	}

	/**
	 * Send AJAX response.
	 *
	 * @param array   $data    Data to send using ajax.
	 * @param boolean $success Optional. If this is an error. Defaults: true.
	 */
	private function send( $data = null, $success = true, $status_code = null ) {
		if ( is_string( $data ) ) {
			$data = $success ? [ 'message' => $data ] : [ 'error' => $data ];
		}

		if ( $success ) {
			\wp_send_json_success( $data, $status_code );
		} else {
			\wp_send_json_error( $data, $status_code );
		}
	}
}