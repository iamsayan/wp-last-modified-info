<?php
/**
 * Show Original Republish Data.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Core;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\SettingsData;

defined( 'ABSPATH' ) || exit;

/**
 * Republish info class.
 */
class RestApi
{
	use Hooker, SettingsData;

	/**
	 * Register functions.
	 */
	public function register()
	{
		$this->action( 'rest_api_init', 'rest_init' );
	}

	/**
	 * Show original publish info.
	 * 
	 * @param string  $content  Original Content
	 * 
	 * @return string $content  Filtered Content
	 */
	public function rest_init()
	{
		register_rest_field(
			'post', // object type
			$this->do_filter( 'modified_by_field_name', 'modified_by' ), // field name
			[
				'get_callback' => [ $this, 'rest_output' ], // callback
			]
		);
	}

	public function rest_output( $object, $field_name, $request )
	{
		$author_id = $this->get_meta( $object['id'], '_edit_last' );
		
		if ( $author_id ) {
            $last_user = get_userdata( $author_id );
			
			// return user name
	        return $last_user->display_name;
		}
		
        return '';
	}
}