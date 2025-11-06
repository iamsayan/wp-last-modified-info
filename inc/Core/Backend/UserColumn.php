<?php
/**
 * Show profile update info.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Core\Backend;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\SettingsData;

defined( 'ABSPATH' ) || exit;

/**
 * User Column class.
 */
class UserColumn
{
	use Hooker;
	use SettingsData;

	/**
	 * Register hooks.
	 */
	public function register() {
		$this->action( 'profile_update', 'update_user' );
		$this->action( 'manage_users_custom_column', 'column_data', 10, 3 );
		$this->filter( 'manage_users_columns', 'load_columns' );
		$this->filter( 'manage_users_sortable_columns', 'sortable_columns' );
		$this->action( 'pre_user_query', 'user_column_orderby' );
		$this->action( 'admin_head-users.php', 'style' );
	}

	/**
	 * Store the last-modified timestamp for a user.
	 *
	 * @param int $user_id User ID.
	 */
	public function update_user( $user_id ) {
		if ( ! $user_id ) {
			return;
		}
		update_user_meta( $user_id, 'profile_last_modified', current_time( 'timestamp', 0 ) );
	}

	/**
	 * Render the custom-column value.
	 *
	 * @param string $value     Existing column value.
	 * @param string $column    Column name.
	 * @param int    $user_id   User ID.
	 * @return string
	 */
	public function column_data( $value, $column, $user_id ) {
		if ( 'last-updated' !== $column ) {
			return $value;
		}

		$timestamp = get_user_meta( $user_id, 'profile_last_modified', true );
		if ( ! $timestamp ) {
			return __( 'Never', 'wp-last-modified-info' );
		}

		$format = $this->do_filter(
			'user_column_datetime_format',
			get_option( 'date_format' ) . ' <br>' . get_option( 'time_format' )
		);

		return date_i18n( $format, (int) $timestamp );
	}

	/**
	 * Add the custom column header.
	 *
	 * @param string[] $columns Associative array of column IDs and labels.
	 * @return string[]
	 */
	public function load_columns( $columns ) {
		$columns['last-updated'] = __( 'Last Updated', 'wp-last-modified-info' );
		return $columns;
	}

	/**
	 * Make the column sortable.
	 *
	 * @param string[] $sortable_columns Associative array of sortable columns.
	 * @return string[]
	 */
	public function sortable_columns( $sortable_columns ) {
		$sortable_columns['last-updated'] = 'lastupdated';
		return $sortable_columns;
	}

	/**
	 * Handle sorting by last-updated meta.
	 *
	 * @param \WP_User_Query $user_search User query object.
	 */
	public function user_column_orderby( $user_search ) {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( ! $screen || 'users' !== $screen->id ) {
			return;
		}

		if ( 'lastupdated' === ( $user_search->query_vars['orderby'] ?? '' ) ) {
			global $wpdb;

			$order = esc_sql( strtoupper( $user_search->query_vars['order'] ?? 'ASC' ) );
			if ( ! in_array( $order, [ 'ASC', 'DESC' ], true ) ) {
				$order = 'ASC';
			}

			$user_search->query_from  .= " INNER JOIN {$wpdb->usermeta} AS lum ON ({$wpdb->users}.ID = lum.user_id AND lum.meta_key = 'profile_last_modified') ";
			$user_search->query_orderby = " ORDER BY CAST(lum.meta_value AS UNSIGNED) {$order} ";
		}
	}

	/**
	 * Output inline CSS to fix column width.
	 */
	public function style() {
		echo '<style>.fixed th.column-last-updated{width:12%;}</style>' . PHP_EOL;
	}
}
