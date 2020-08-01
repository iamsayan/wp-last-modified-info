<?php 
/**
 * Admin callbacks.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Api\Callbacks
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Api\Callbacks;

use Wplmi\Base\BaseController;

defined( 'ABSPATH' ) || exit;

/**
 * Admin callbacks class.
 */
class AdminCallbacks extends BaseController
{
	/**
	 * Call dashboard template.
	 */
	public function adminDashboard()
	{
		$options = get_option( 'wpar_plugin_settings' );

		return require_once( "$this->plugin_path/templates/admin.php" );
	}
}