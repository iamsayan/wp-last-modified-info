<?php
/**
 * Plugin Name: WP Last Modified Info
 * Plugin URI: https://iamsayan.github.io/wp-last-modified-info/
 * Description: Show or hide last update date and time on pages and posts very easily. You can use shortcode also to display last modified info anywhere.
 * Version: 1.2.10
 * Author: Sayan Datta
 * Author URI: https://profiles.wordpress.org/infosatech/
 * License: GPLv3
 * Text Domain: wp-last-modified-info
 * 
 * WP Last Modified Info is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * WP Last Modified Info is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WP Last Modified Info. If not, see <http://www.gnu.org/licenses/>.
 *
 * @category Core
 * @package  WP Last Modified Info
 * @author   Sayan Datta
 * @license  http://www.gnu.org/licenses/ GNU General Public License
 * @link     https://iamsayan.github.io/wp-last-modified-info/
 */

//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup plugin constants.
 *
 * We need a few constants in our plugin.
 * These values should be constant and con't
 * be altered later.
 *
 * @since  1.2.10
 * @return void
 */
function lmt_set_constants() {

	$constants = array(
		'LMT_NAME'       => 'WP Last Modified Info',
		'LMT_DOMAIN'     => 'wp-last-modified-info',
		'LMT_DIR_PATH'   => plugin_dir_path( __FILE__ ),
		'LMT_DIR_URL'    => plugin_dir_url( __FILE__ ),
		'LMT_BASE_NAME'  => plugin_basename(__FILE__),
		'LMT_BASE_FILE'  => __FILE__,
		'LMT_VERSION'    => '1.2.10',
		// Set who all can access plugin settings.
		// You can change this if you want to give others access.
		'LMT_ACCESS'     => 'manage_options',
	);

	foreach ( $constants as $constant => $value ) {
		if ( ! defined( $constant ) ) {
			define( $constant, $value );
		}
    }
}
// Set constants.    
lmt_set_constants();

/**
 * File that contains main plugin data.
 */
require_once LMT_DIR_PATH . 'includes/autoload.php';
require_once LMT_DIR_PATH . 'admin/loader.php';

?>