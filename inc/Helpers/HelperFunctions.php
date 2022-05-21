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
			if ( ! is_object( $post_type ) ) {
			    continue;                                                           
			}

			if ( isset( $post_type->labels ) ) {
				$label = $post_type->labels->name ? $post_type->labels->name : $post_type->name;
			} else {
				$label = $post_type->name;
			}
			
			if ( $label == 'Media' || $label == 'media' || $post_type->name == 'elementor_library' ) {
				continue; // skip media
			}
				
			$data[ $post_type->name ] = $label;
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
	protected function insert_settings( $array, $position, $insert ) {
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
	protected function is_enabled( $name ) {
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
	protected function is_equal( $name, $value ) {
		$data = $this->get_data( 'lmt_' . $name );
		if ( $data && $data == $value ) {
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
	protected function in_array( $name, array $values, $default = false ) {
		$data = $this->get_data( 'lmt_' . $name, $default );
		
		return in_array( $name, $data, true );
	}

	/**
	 * Check current user roles.
	 * 
	 * @since  1.8.0
	 * @return bool
	 */
	protected function get_users( $args = [] ) {
		$options = [];
		$users = \get_users( wp_parse_args( $args, [
			'fields' => [ 'ID', 'display_name' ],
		] ) );
		foreach ( $users as $user ) {
			$options[ $user->ID ] = $user->display_name;
		}

		return $options;
    }

	/**
	 * Date Time string to seconds and also from array
	 * 
	 * @since 1.8.0
	 * @return string
	 */
	protected function str_to_second( $input ) {
		$times = explode( ' ', preg_replace( '!\s+!', ' ', str_replace( [ ',', '-', '_' ], ' ', $input ) ) );
		$total_time = 0;
		foreach ( $times as $time ) {
			$total_time += $this->convert_str_to_second( $time );
		}

		return $total_time;
	}

	/**
	 * Convert Date Time string to seconds
	 * 
	 * @since 1.3.0
	 * @return string
	 */
	protected function convert_str_to_second( $input ) {
		$res = preg_replace( "/[^a-z]/i", '', strtolower( $input ) );
		if ( ! in_array( $res, [ 'y', 'm', 'd', 'w', 'h', 'i' ] ) ) {
			return $input * MINUTE_IN_SECONDS;
		}

		$input = preg_replace( "/[^0-9]/", '', $input );
		switch ( $res ) {
			case 'y':
				$output = $input * YEAR_IN_SECONDS;
				break;
			case 'm':
				$output = $input * MONTH_IN_SECONDS;
				break;
			case 'd':
				$output = $input * DAY_IN_SECONDS;
				break;
			case 'w':
				$output = $input * WEEK_IN_SECONDS;
				break;
			case 'h':
				$output = $input * HOUR_IN_SECONDS;
				break;
			case 'i':
				$output = $input * MINUTE_IN_SECONDS;
				break;
			default:
				$output = MINUTE_IN_SECONDS;
		}

		return $output;
	}

	/**
	 * Determines whether the current screen is an edit post screen.
	 *
	 * @since 1.8.0
	 * @return bool Whether or not the current screen is editing an existing post.
	 */
	protected function is_edit_post_screen() {
		if ( ! \is_admin() ) {
			return false;
		}

		$current_screen = \get_current_screen();

		return $current_screen->base === 'post' && $current_screen->action !== 'add';
	}

	/**
	 * Determines whether the current screen is an new post screen.
	 *
	 * @since 1.8.0
	 * @return bool Whether or not the current screen is editing an new post.
	 */
	protected function is_new_post_screen() {
		if ( ! \is_admin() ) {
			return false;
		}

		$current_screen = \get_current_screen();

		return $current_screen->base === 'post' && $current_screen->action === 'add';
	}

	/**
	 * Determines if we are currently editing a post with Classic editor.
	 *
	 * @since 1.8.0
	 * @return bool Whether we are currently editing a post with Classic editor.
	 */
	protected function is_classic_editor() {
		if ( ! $this->is_edit_post_screen() && ! $this->is_new_post_screen() ) {
			return false;
		}

		$screen = \get_current_screen();
		if ( $screen->is_block_editor() ) {
			return false;
		}

		return true;
	}

	/**
	 * Determines if we are currently editing a post with Block editor.
	 *
	 * @since 1.8.0
	 * @return bool Whether we are currently editing a post with Block editor.
	 */
	protected function is_block_editor() {
		$screen = \get_current_screen();
		if ( \method_exists( $screen, 'is_block_editor' ) && $screen->is_block_editor() ) {
			return true;
		}

		return false;
	}

	/**
	 * Determines whether the passed post type is public and shows an admin bar.
	 *
	 * @param string $post_type The post_type to copy.
	 *
	 * @since 1.8.0
	 * @return bool Whether or not the post can be copied to a new draft.
	 */
	protected function post_type_has_admin_bar( $post_type ) {
		$post_type_object = \get_post_type_object( $post_type );

		if ( empty( $post_type_object ) ) {
			return false;
		}

		return $post_type_object->public && $post_type_object->show_in_admin_bar;
	}
}