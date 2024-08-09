<?php
/**
 * Plugin Name: WP Last Modified Info
 * Plugin URI: https://wordpress.org/plugins/wp-last-modified-info/
 * Description: Ultimate Last Modified Plugin for WordPress with Gutenberg Block Integration. It is possible to use shortcodes to display last modified info anywhere on a WordPress site running 4.7 and beyond.
 * Version: 1.9.1
 * Author: Sayan Datta
 * Author URI: https://www.sayandatta.co.in
 * License: GPLv3
 * Text Domain: wp-last-modified-info
 * Domain Path: /languages
 *
 * WP Last Modified Info is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
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
 * @author   Sayan Datta <iamsayan@protonmail.com>
 * @license  http://www.gnu.org/licenses/ GNU General Public License
 * @link     https://wordpress.org/plugins/wp-last-modified-info/
 *
 */

// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) || exit;

/**
 * WPLMI class.
 *
 * @class Main class of the plugin.
 */
final class WPLMI {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public $version = '1.9.1';

	/**
	 * Minimum version of WordPress required to run WPLMI.
	 *
	 * @var string
	 */
	private $wordpress_version = '4.7';

	/**
	 * Minimum version of PHP required to run WPLMI.
	 *
	 * @var string
	 */
	private $php_version = '7.0';

	/**
	 * Hold install error messages.
	 *
	 * @var bool
	 */
	private $messages = [];

	/**
	 * The single instance of the class.
	 *
	 * @var WPLMI
	 */
	protected static $instance = null;

	/**
	 * Retrieve main WPLMI instance.
	 *
	 * Ensure only one instance is loaded or can be loaded.
	 *
	 * @see wplmi()
	 * @return WPLMI
	 */
	public static function get() {
		if ( is_null( self::$instance ) && ! ( self::$instance instanceof WPLMI ) ) {
			self::$instance = new WPLMI();
			self::$instance->setup();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the plugin.
	 */
	private function setup() {
		// Define plugin constants.
		$this->define_constants();

		if ( ! $this->is_requirements_meet() ) {
			return;
		}

		// Include required files.
		$this->includes();

		// Instantiate services.
		$this->instantiate();

		// Loaded action.
		do_action( 'wplmi/loaded' );
	}

	/**
	 * Check that the WordPress and PHP setup meets the plugin requirements.
	 *
	 * @return bool
	 */
	private function is_requirements_meet() {

		// Check WordPress version.
		if ( version_compare( get_bloginfo( 'version' ), $this->wordpress_version, '<' ) ) {
			/* translators: WordPress Version */
			$this->messages[] = sprintf( esc_html__( 'You are using the outdated WordPress, please update it to version %s or higher.', 'wp-last-modified-info' ), $this->wordpress_version );
		}

		// Check PHP version.
		if ( version_compare( phpversion(), $this->php_version, '<' ) ) {
			/* translators: PHP Version */
			$this->messages[] = sprintf( esc_html__( 'WP Last Modified Info requires PHP version %s or above. Please update PHP to run this plugin.', 'wp-last-modified-info' ), $this->php_version );
		}

		if ( empty( $this->messages ) ) {
			return true;
		}

		// Auto-deactivate plugin.
		add_action( 'admin_init', [ $this, 'auto_deactivate' ] );
		add_action( 'admin_notices', [ $this, 'activation_error' ] );

		return false;
	}

	/**
	 * Auto-deactivate plugin if requirements are not met, and display a notice.
	 */
	public function auto_deactivate() {
		deactivate_plugins( WPLMI_BASENAME );
		if ( isset( $_GET['activate'] ) ) { // phpcs:ignore
			unset( $_GET['activate'] ); // phpcs:ignore
		}
	}

	/**
	 * Error notice on plugin activation.
	 */
	public function activation_error() {
		?>
		<div class="notice wplmi-notice notice-error">
			<p>
				<?= join( '<br>', $this->messages ); // phpcs:ignore ?>
			</p>
		</div>
		<?php
	}

	/**
	 * Define the plugin constants.
	 */
	private function define_constants() {
		define( 'WPLMI_VERSION', $this->version );
		define( 'WPLMI_FILE', __FILE__ );
		define( 'WPLMI_PATH', dirname( WPLMI_FILE ) . '/' );
		define( 'WPLMI_URL', plugins_url( '', WPLMI_FILE ) . '/' );
		define( 'WPLMI_BASENAME', plugin_basename( WPLMI_FILE ) );
	}

	/**
	 * Include the required files.
	 */
	private function includes() {
		include __DIR__ . '/vendor/autoload.php';
	}

	/**
	 * Instantiate services.
	 */
	private function instantiate() {
		// Activation hook.
		register_activation_hook( WPLMI_FILE,
			function () {
				Wplmi\Base\Activate::activate();
			}
		);

		// Deactivation hook.
		register_deactivation_hook( WPLMI_FILE,
			function () {
				Wplmi\Base\Deactivate::deactivate();
			}
		);

		// Init WPLMI Classes.
		Wplmi\Loader::register_services();
	}
}

/**
 * Returns the main instance of WPLMI to prevent the need to use globals.
 *
 * @return WPLMI
 */
function wplmi() { // phpcs:ignore Universal.Files.SeparateFunctionsFromOO.Mixed
	return WPLMI::get();
}

// Start it.
wplmi();
