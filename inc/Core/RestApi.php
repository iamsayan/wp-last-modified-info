<?php
/**
 * Shows last modified author name on rest output.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Core;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\SettingsData;

defined( 'ABSPATH' ) || exit;

/**
 * Rest Api class.
 */
class RestApi
{
	use Hooker;
    use SettingsData;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( 'rest_api_init', 'rest_init' );
	}

	/**
	 * Register Rest field.
	 */
	public function rest_init() {
		register_rest_field(
			'post', // object type
			$this->do_filter( 'modified_rest_field_name', 'modified_by' ), // field name
			[
				'get_callback' => [ $this, 'rest_output' ], // callback
			]
		);
	}

	/**
	 * Rest Api outpur callback
	 *
	 * @param object  $rest_object WP Post Object
	 * @param string  $field_name  Field Name
	 * @param string  $request     Request
	 *
	 * @return string|null
	 */
	public function rest_output( $rest_object, $field_name, $request ) {
		$author_id = $this->get_meta( $rest_object['id'], '_edit_last' );

		if ( $author_id ) {
            $last_user = get_userdata( $author_id );

			if ( $last_user && is_object( $last_user ) ) {
				return $last_user->display_name;
			}
		}
	}
}
