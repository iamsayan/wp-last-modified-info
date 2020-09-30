<?php
/**
 * Helper functions.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Helpers
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Helpers;

use Wplmi\Helpers\SettingsData;

defined( 'ABSPATH' ) || exit;

/**
 * Meta & Option class.
 */
trait HelperFunctions
{
	use SettingsData;

	/**
	 * Get all registered public post types.
	 *
	 * @param bool $public Public type True or False.
	 * @return array
	 */
	protected function get_post_types( $public = true ) {
		$post_types = get_post_types( [ 'public' => $public ], 'objects' );
		$data = [];
		foreach ( $post_types as $post_type ) {
			if ( ! is_object( $post_type ) )
			    continue;															
			
			if ( isset( $post_type->labels ) ) {
				$label = $post_type->labels->name ? $post_type->labels->name : $post_type->name;
			} else {
				$label = $post_type->name;
			}
			
			if ( $label == 'Media' || $label == 'media' || $post_type->name == 'elementor_library' )
				continue; // skip media
				
			$data[$post_type->name] = $label;
		}

		return $data;
	}

	/**
	 * Post Modified time wrapper function.
	 *
	 * @param string     $format Date Format.
	 * @param object|int $post
	 * 
	 * @return string
	 */
	protected function get_modified_date( $format = '', $post = null ) {
		$post = get_post( $post );
 
        if ( ! $post ) {
            $the_time = false;
        } else {
            $_format = ! empty( $format ) ? $format : get_option( 'date_format' );
     
            $the_time = get_post_modified_time( $_format, false, $post, true );
		}
		
		return $the_time;
	}

	/**
	 * Insert the plugins settings in proper place.
	 *
	 * @param  array   $array     Default setting fields.
	 * @param  integer $position  Insertion position.
	 * @param  array   $insert    Field.
	 * @return array
	 */
	protected function insert_settings( $array, $position, $insert )
    {
		$array = array_merge( array_slice( $array, 0, $position ), $insert, array_slice( $array, $position ) );
		
		return $array;
	}

	/**
	 * Check plugin settings if enabled
	 * 
	 * @param  string  $name  Settings field name.
	 * 
	 * @return bool
	 */
	protected function is_enabled( $name )
	{
		$data = $this->get_data( 'lmt_' . $name );
		if ( $data == 1 ) {
            return true;
		}

		return false;
	}

	/**
	 * Check plugin settings has a particular value
	 * 
	 * @param  string  $name   Settings field name.
	 * @param  string  $value  Settings field value.
	 * 
	 * @return bool
	 */
	protected function is_equal( $name, $value )
	{
		$data = $this->get_data( 'lmt_' . $name );
		if ( $data == $value ) {
            return true;
		}

		return false;
	}

	/**
	 * Check plugin settings has in a array
	 * 
	 * @param  string  $name     Settings field name.
	 * @param  array   $value    Settings field values.
	 * @param  bool    $default  Default value.
	 * 
	 * @return bool
	 */
	protected function in_array( $name, array $values, $default = false )
	{
		$data = $this->get_data( 'lmt_' . $name, $default );
		
		return in_array( $name, $data, true );
	}
}