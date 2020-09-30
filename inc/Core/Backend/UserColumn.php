<?php
/**
 * Show profile update info.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend
 * @author     Sayan Datta <hello@sayandatta.in>
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
	use Hooker, SettingsData;

	/**
	 * Register functions.
	 */
	public function register()
	{
		$this->action( 'profile_update', 'update_user' );
		$this->action( 'manage_users_custom_column', 'column_data', 10, 3 );
		$this->filter( 'manage_users_columns', 'column_title' );
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
	public function update_user( $user_id )
	{
	    // update user meta
	    update_user_meta( $user_id, 'profile_last_modified', current_time( 'timestamp', 0 ) );
	}
	
	/**
	 * Make Column sortable.
	 * 
	 * @param string   $column  Column name
	 * @return string  $column  Filtered column
	 */
	public function column_data( $value, $column, $user_id )
	{
		// get author meta
	    $timestamp = get_the_author_meta( 'profile_last_modified', $user_id, true );
		$get_df = get_option( 'date_format' );
		$get_tf = get_option( 'time_format' );

	    switch ( $column ) {
	    	case 'last-updated' :
	    	    if ( ! $timestamp ) {
					return __( 'Never', 'wp-last-modified-info' );
				}
	    		
	    		return date_i18n( $this->do_filter( 'user_column_datetime_format', $get_df . '\<\b\r\>' . $get_tf ), $timestamp );
	        break;
		}
		
	    return $value;
	}

	/**
	 * Column title.
	 * 
	 * @param string   $column  Column name
	 * @return string  $column  Filtered column
	 */
	public function column_title( $column )
	{
		$column['last-updated'] = __( 'Last Updated', 'wp-last-modified-info' );
		
		return $column;
	}

	/**
	 * Column title.
	 * 
	 * @param string   $column  Column name
	 * @return string  $column  Filtered column
	 */
	public function style()
	{
		echo '<style type="text/css">.fixed th.column-last-updated { width:12%; }</style>'."\n";
	}
}