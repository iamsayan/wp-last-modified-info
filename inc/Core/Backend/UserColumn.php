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
	    update_user_meta( $user_id, 'profile_last_modified', current_time( $get_df ) . '<br>' . current_time( $get_tf ) );
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
	    $updated = get_the_author_meta( 'profile_last_modified', $user_id, true );
    
	    switch ( $column ) {
	    	case 'last-updated' :
	    	    if ( ! $updated ) {
					return __( 'Never', 'wp-last-modified-info' );
				}
	    		
	    		return get_the_author_meta( 'profile_last_modified', $user_id, true );
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