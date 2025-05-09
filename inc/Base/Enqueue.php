<?php
/**
 * Enqueue all css & js.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Base
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Base;

use Wplmi\Helpers\Hooker;
use Wplmi\Base\BaseController;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Script class.
 */
class Enqueue extends BaseController
{
	use Hooker;
    use HelperFunctions;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( 'admin_enqueue_scripts', 'assets' );
	}

	/**
	 * Load admin assets.
	 */
	public function assets( $hook ) {
		global $wp_version;

		if ( 'settings_page_wp-last-modified-info' === $hook ) {

			// enqueue required css
			wp_enqueue_style( 'wp-codemirror' );

			// enqueue required js
			wp_enqueue_script( 'jquery-form' );
			wp_enqueue_script( 'jquery-ui-resizable' );
			wp_enqueue_script( 'wp-theme-plugin-editor' );

			// load required css & js files.
			$this->load( 'css', 'admin', 'admin.min.css', $this->version );
			$this->load( 'css', 'selectize', 'selectize.min.css', '0.15.2' );
			$this->load( 'css', 'confirm', 'jquery-confirm.min.css', '3.3.4' );

			$this->load( 'js', 'selectize', 'selectize.min.js', '0.15.2', [ 'jquery' ] );
			$this->load( 'js', 'confirm', 'jquery-confirm.min.js', '3.3.4', [ 'jquery' ] );
		    $this->load( 'js', 'admin', 'admin.min.js', $this->version, [ 'jquery', 'jquery-form', 'jquery-ui-resizable', 'wplmi-confirm', 'wplmi-selectize' ] );

			$args = [
				'ajaxurl'        => admin_url( 'admin-ajax.php' ),
				'copied'         => __( 'Copied!', 'wp-last-modified-info' ),
				'saving'         => __( 'Saving...', 'wp-last-modified-info' ),
				'saving_text'    => __( 'Please wait while we are saving your settings...', 'wp-last-modified-info' ),
				'done'           => __( 'Done!', 'wp-last-modified-info' ),
				'error'          => __( 'Error!', 'wp-last-modified-info' ),
				'warning'        => __( 'Warning!', 'wp-last-modified-info' ),
				'processing'     => __( 'Please wait while we are processing your request...', 'wp-last-modified-info' ),
				'save_button'    => __( 'Save Settings', 'wp-last-modified-info' ),
				'save_success'   => __( 'Settings Saved Successfully!', 'wp-last-modified-info' ),
				'process_failed' => __( 'Invalid Nonce! We could not process your request.', 'wp-last-modified-info' ),
				'ok_button'      => __( 'OK', 'wp-last-modified-info' ),
				'confirm_button' => __( 'Confirm', 'wp-last-modified-info' ),
				'cancel_button'  => __( 'Cancel', 'wp-last-modified-info' ),
				'please_wait'    => __( 'Please wait...', 'wp-last-modified-info' ),
				'close_btn'      => __( 'Close', 'wp-last-modified-info' ),
				'paste_data'     => __( 'Paste Here', 'wp-last-modified-info' ),
				'import_btn'     => __( 'Import', 'wp-last-modified-info' ),
				'importing'      => __( 'Importing...', 'wp-last-modified-info' ),
				'security'       => wp_create_nonce( 'wplmi_admin_nonce' ),
			];

			if ( version_compare( $wp_version, '4.9', '>=' ) ) {
				$current_user = wp_get_current_user();

				$args['html_editor'] = wp_enqueue_code_editor( [ 'type' => 'text/html' ] );
				$args['css_editor'] = wp_enqueue_code_editor( [ 'type' => 'text/css' ] );
				$args['highlighting'] = ( $current_user->syntax_highlighting === 'true' ) ? 'on' : 'off';
			} else {
				$args['highlighting'] = 'off';
			}

			wp_localize_script( 'wplmi-admin', 'wplmiAdminL10n', $args );
		}

		if ( $this->is_block_editor() ) {
			return;
		}

		if ( in_array( $hook, [ 'post-new.php', 'post.php' ], true ) ) {
			$this->load( 'css', 'post', 'post.min.css', $this->version );
			$this->load( 'js', 'post', 'post.min.js', $this->version, [ 'jquery' ] );
		}

		if ( 'edit.php' === $hook ) {
			$this->load( 'css', 'edit', 'edit.min.css', $this->version );
			$this->load( 'js', 'edit', 'edit.min.js', $this->version, [ 'jquery' ] );

			wp_localize_script( 'wplmi-edit', 'wplmi_edit_L10n', [
				'ajaxurl'  => admin_url( 'admin-ajax.php' ),
				'security' => wp_create_nonce( 'wplmi_edit_nonce' ),
			] );
		}
	}

	/**
	 * Enqueue CSS & JS wrapper function.
	 */
	private function load( $type, $handle, $name, $version, $dep = [], $end = true ) {
		if ( $type === 'css' ) {
		    wp_enqueue_style( 'wplmi-' . $handle, $this->plugin_url . 'assets/css/' . $name, $dep, $version );
		} elseif ( $type === 'js' ) {
		    wp_enqueue_script( 'wplmi-' . $handle, $this->plugin_url . 'assets/js/' . $name, $dep, $version, $end );
		}
	}
}
