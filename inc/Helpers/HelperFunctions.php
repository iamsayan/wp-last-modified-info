<?php
/**
 * Helper functions.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Helpers
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Helpers;

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
	 * @param bool $post_type_public Public type True or False.
	 * @return array
	 */
	protected function get_post_types( bool $post_type_public = true ): array {
		$post_types = get_post_types( [ 'public' => $post_type_public ], 'objects' );
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
	 * @param array $fields    Default setting fields.
	 * @param integer $position  Insertion position.
	 * @param array $insert    Field.
	 * @return array
	 */
	protected function insert_settings( array $fields, int $position, array $insert ): array {
		return array_merge( array_slice( $fields, 0, $position ), $insert, array_slice( $fields, $position ) );
	}

	/**
	 * Check plugin settings if enabled
	 *
	 * @param string $name  Settings field name.
	 *
	 * @return bool
	 */
	protected function is_enabled( string $name ): bool {
		$data = $this->get_data( 'lmt_' . $name );

		return $data == 1;
	}

	/**
	 * Check plugin settings has a particular value
	 *
	 * @param string $name   Settings field name.
	 * @param  string  $value  Settings field value.
	 *
	 * @return bool
	 */
	protected function is_equal( string $name, $value ): bool {
		$data = $this->get_data( 'lmt_' . $name );
		if ( $data && $data == $value ) {
            return true;
		}

		return false;
	}

	/**
	 * Check current user roles.
	 *
	 * @return array
	 * @since  1.8.0
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
	 * Determines whether the current screen is an edit post screen.
	 *
	 * @since 1.8.0
	 * @return bool Whether or not the current screen is editing an existing post.
	 */
	protected function is_edit_post_screen(): bool {
		if ( ! \is_admin() ) {
			return false;
		}

		$current_screen = \get_current_screen();

		return $current_screen->base === 'post' && $current_screen->action !== 'add';
	}

	/**
	 * Determines whether the current screen is a new post screen.
	 *
	 * @since 1.8.0
	 * @return bool Whether the current screen is editing a new post.
	 */
	protected function is_new_post_screen(): bool {
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
	protected function is_classic_editor(): bool {
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
	protected function is_block_editor(): bool {
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
	protected function post_type_has_admin_bar( $post_type ): bool {
		$post_type_object = \get_post_type_object( $post_type );

		if ( empty( $post_type_object ) ) {
			return false;
		}

		return $post_type_object->public && $post_type_object->show_in_admin_bar;
	}
}
