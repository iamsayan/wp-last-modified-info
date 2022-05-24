<?php 
/**
 * Admin notices.
 *
 * @since      1.8.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend;
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Core\Backend;

use Wplmi\Helpers\Hooker;
use Wplmi\Base\BaseController;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Admin Notice class.
 */
class BlockEditor extends BaseController
{
	use Hooker, HelperFunctions;
	
	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( 'init', 'register_meta' );
		$this->action( 'enqueue_block_editor_assets', 'assets' );

		$post_types = get_post_types( [ 'show_in_rest' => true ] );
		foreach ( $post_types as $post_type ) {
			$this->filter( "rest_pre_insert_{$post_type}", 'modified_params', 10, 2 );
		}
	}

	/**
	 * Register meta fields.
	 */
	public function register_meta() {
		register_meta( 
			'post',
			'_lmt_disableupdate',
			[
				'show_in_rest'      => true,
				'type'              => 'string',
				'single'            => true,
				'sanitize_callback' => 'sanitize_text_field',
				'auth_callback'     => function () {
					return current_user_can( 'edit_posts' );
				},
			] 
		);

		register_meta( 
			'post',
			'_lmt_disable',
			[
				'show_in_rest'      => true,
				'type'              => 'string',
				'single'            => true,
				'sanitize_callback' => 'sanitize_text_field',
				'auth_callback'     => function () {
					return current_user_can( 'edit_posts' );
				},
			]
		);
	}

	/**
	 * Append required parameters to REST call.
	 *
	 * @param stdClass        $prepared_post An object representing a single post prepared for inserting or updating the database.
	 * @param WP_REST_Request $request Request object.
	 * @return stdClass $prepared_post Resulting post object.
	 */
	public function modified_params( $prepared_post, $request ) {
		$params = $request->get_params();

		if ( isset( $params['modified'] ) ) {
			$prepared_post->wplmi_modified_rest = $params['modified'];
		}
	
		if ( isset( $params['meta']['_lmt_disableupdate'] ) ) {
			$prepared_post->wplmi_lockmodifiedupdate = $params['meta']['_lmt_disableupdate'];
		}

		return $prepared_post;
	}

	/**
	 * Enqueue Block Editor assets.
	 */
	public function assets() {
		global $post;

		if ( ! $post instanceof \WP_Post ) {
			return; // load assets only in post edit screen.
		}

		$asset_file = include( $this->plugin_path . 'assets/block-editor/build/index.asset.php' );

		wp_enqueue_script( 'wplmi-block-editor', $this->plugin_url . 'assets/block-editor/build/index.js', $asset_file['dependencies'], $asset_file['version'], true );
		wp_localize_script( 'wplmi-block-editor', 'wplmiBlockEditor', [
			'postTypes' => $this->get_data( 'lmt_custom_post_types_list', [] ),
			'isEnabled' => $this->is_enabled( 'enable_last_modified_cb' ),
		] );
	}
}