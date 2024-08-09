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
	 * Register functions.
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
	 * Generate column data.
	 *
	 * @param string   $column   Column name
	 * @param int      $post_id  Post ID
	 *
	 * @return string  $time
	 */
	public function update_user( $user_id ) {
	    // update user meta
	    update_user_meta( $user_id, 'profile_last_modified', current_time( 'timestamp', 0 ) );
	}

	/**
	 * Make Column sortable.
	 *
	 * @param string   $column  Column name
	 * @return string  $column  Filtered column
	 */
	public function column_data( $value, $column, $user_id ) {
		// get author meta
	    $timestamp = get_the_author_meta( 'profile_last_modified', $user_id, true );
		$get_df = get_option( 'date_format' );
		$get_tf = get_option( 'time_format' );

	    switch ( $column ) {
	    	case 'last-updated':
	    	    if ( ! $timestamp ) {
					return __( 'Never', 'wp-last-modified-info' );
				}

	    		return date_i18n( $this->do_filter( 'user_column_datetime_format', $get_df . '\<\b\r\>' . $get_tf ), $timestamp );
	        	break;
		}

	    return $value;
	}

	/**
	 * Register Column.
	 *
	 * @param string   $columns  Column name
	 * @return string  $columns  Filtered column
	 */
	public function load_columns( $columns ) {
		$columns['last-updated'] = __( 'Last Updated', 'wp-last-modified-info' );

		return $columns;
	}

	/**
	 * Column title.
	 *
	 * @param string   $column  Column name
	 * @return string  $column  Filtered column
	 */
	public function sortable_columns( $sortable_columns ) {
		$sortable_columns['last-updated'] = 'lastupdated';

		return $sortable_columns;
	}

	/**
	 * Sort Column.
	 *
	 * @since 1.8.4
	 * @param object   $user_search  User Query
	 */
	public function user_column_orderby( $user_search ) {
		global $wpdb, $current_screen;

		if ( isset( $current_screen->id ) && 'users' !== $current_screen->id ) {
			return;
		}

		$vars = $user_search->query_vars;
		if ( 'lastupdated' === $vars['orderby'] ) {
			$user_search->query_from .= " INNER JOIN {$wpdb->usermeta} m1 ON {$wpdb->users}.ID=m1.user_id AND (m1.meta_key='profile_last_modified')";
			$user_search->query_orderby = ' ORDER BY UPPER(m1.meta_value) '. $vars['order'];
		}
	}

	/**
	 * Column title.
	 *
	 * @param string   $column  Column name
	 * @return string  $column  Filtered column
	 */
	public function style() {
		echo '<style type="text/css">.fixed th.column-last-updated { width:12%; }</style>'."\n";
	}
}
