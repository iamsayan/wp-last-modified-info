<?php
/**
 * Show plugin updated info.
 *
 * @since      1.7.4
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Core\Backend;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Plugins details class.
 */
class PluginsData extends \WP_Background_Process
{
	use HelperFunctions, Hooker;

	/**
	 * @var string
	 */
	protected $action = 'wplmi_fetch_plugin_data';

	/**
	 * Register functions.
	 */
	public function register()
	{
        $this->action( 'init', 'generate_cron' );
		$this->action( 'wplmi/fetch_plugin_data', 'clean_start' );
		$this->action( 'plugin_row_meta', 'display', 99, 2 );
		$this->action( 'activate_plugin', 'activate_plugin' );
	}

	/**
	 * Cron cleanup on request.
	 */
	public function generate_cron()
	{
		if ( ! wp_next_scheduled( 'wplmi/fetch_plugin_data' ) ) {
		    wp_schedule_event( time(), 'weekly', 'wplmi/fetch_plugin_data' );
		}
	}

	/**
	 * Start fetching process.
	 */
	public function clean_start()
	{
		if ( get_site_transient( 'wplmi_lock_fetch' ) === false ) {
			// check if disabled from settings
			if ( ! $this->is_enabled( 'disable_plugin_info' ) ) {
			    $this->kill_process();
			    $this->start_process();
			}

			// stop multiple cron run issue
			set_site_transient( 'wplmi_lock_fetch', true, 5 );
		}
	}

	/**
	 * Start fetching process.
	 */
	public function start_process()
	{
        $plugins = array_keys( get_plugins() );
		foreach ( $plugins as $plugin ) {
			$file_parts = explode( '/', $plugin );
            if ( count( $file_parts ) > 1 ) {
				$this->push_to_queue( $file_parts[0] );
			}
		}

		$this->save()->dispatch();
	}

	/**
	 * Task
	 *
	 * @param mixed $item Queue item to iterate over
	 *
	 * @return mixed
	 */
	protected function task( $item )
	{
        $this->call_api( $item );
		sleep( 2 ); // stop for 2 seconds to optimize memory usage
		
		return false;
	}

	/**
	 * Make API Calls
	 *
	 * @param mixed $item Queue item to iterate over
	 */
	protected function call_api( $item )
	{
		if ( ! function_exists( 'plugins_api' ) ) {
		    require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
		}

		$response = plugins_api( 'plugin_information', [ 'slug' => $item ] );
	    if ( ! is_wp_error( $response ) ) {
			$this->save_data( $response );
		}
	}

	/**
	 * API Response data
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	private function save_data( $data )
	{
		$new_data = [];
		if ( get_option( 'wplmi_plugin_api_data' ) !== false ) {
			$new_data = get_option( 'wplmi_plugin_api_data' );
		}

		$new_data[$data->slug] = [
			'slug' => $data->slug,
            'version' => $data->version,
            'requires' => $data->requires,
            'tested' => $data->tested,
            'last_updated' => $data->last_updated,
			'svn_exists' => $this->svn_exists( $data->slug ) ? 'yes' : 'no'
		];

		if ( isset( $data->rating ) ) {
		    $new_data[$data->slug]['rating'] = $data->rating;
		}

		if ( isset( $data->num_ratings ) ) {
		    $new_data[$data->slug]['num_ratings'] = $data->num_ratings;
		}

		if ( isset( $data->active_installs ) ) {
		    $new_data[$data->slug]['active_installs'] = $data->active_installs;
		}

		update_option( 'wplmi_plugin_api_data', $new_data );

		return true;
	}

	/**
	 * Kill process.
	 */
	private function kill_process() {
		$this->cancel_process();
	}

	/**
	 * Register meta links.
	 */
	public function display( $links, $file )
	{
		global $wp_version;

		if ( $this->is_enabled( 'disable_plugin_info' ) ) {
			return $links;
		}

        if ( get_option( 'wplmi_plugin_api_data' ) === false ) {
			return $links;
		}

		$data = get_option( 'wplmi_plugin_api_data' );

		$new_file = $this->get_path( $file );

		if ( ! isset( $data[$new_file] ) ) {
			return $links;
		}

		if ( isset( $data[$new_file]['last_updated'] ) ) {
			$date = get_date_from_gmt( $data[$new_file]['last_updated'], 'U' );
			$current_date = current_time( 'timestamp', 0 );
            $diff = strtotime( '-1 year', $current_date );
			if ( $diff <= $date ) {
			    $links[] = sprintf( __( 'Updated: %s', 'wp-last-modified-info' ), '<span style="font-weight: 600;">' . date_i18n( get_option( 'date_format' ), $date ) . '</span>' );
		    } else {
				$links[] = sprintf( __( 'Updated: %s', 'wp-last-modified-info' ), '<span style="font-weight: 600;color: #c30808;">' . date_i18n( get_option( 'date_format' ), $date ) . '</span>' );
		    }
	    }

		if ( isset( $data[$new_file]['rating'] ) ) {
			$links[] = sprintf( __( 'Ratings: %s', 'wp-last-modified-info' ), ( $data[$new_file]['rating'] / 10 ) . '/10' );
		}

		if ( isset( $data[$new_file]['num_ratings'] ) ) {
			$links[] = sprintf( __( 'Reviews: %s', 'wp-last-modified-info' ), $data[$new_file]['num_ratings'] );
		}

		if ( isset( $data[$new_file]['requires'] ) ) {
			$links[] = sprintf( __( 'Requires at least: v%s', 'wp-last-modified-info' ), $data[$new_file]['requires'] );
		}

		if ( isset( $data[$new_file]['tested'] ) ) {
			if ( version_compare( $wp_version, $data[$new_file]['tested'], '<=' ) ) {
			    $links[] = sprintf( __( 'Tested upto: v%s', 'wp-last-modified-info' ), '<span style="font-weight: 600;">' . $data[$new_file]['tested'] . '</span>' );
			} else {
				$links[] = sprintf( __( 'Tested upto: %s', 'wp-last-modified-info' ), '<span style="font-weight: 600;color: #c30808;">v' . $data[$new_file]['tested'] . '</span>' );
			}
		}

		if ( isset( $data[$new_file]['svn_exists'] ) ) {
			if ( $data[$new_file]['svn_exists'] == 'yes' ) {
			    $links[] = sprintf( '%1$s %2$s', __( 'Status:', 'wp-last-modified-info' ), '<a href="https://wordpress.org/plugins/' . $data[$new_file]['slug'] . '/" target="_blank">' . __( 'Available', 'wp-last-modified-info' ) . '</a>' );
			}
		}

		return $links;
	}

	/**
	 * Check if plugin actually exists on wp svn.
	 */
	private function svn_exists( $file )
	{
		global $wp_version;

		$args = [
			'timeout'     => 5,
			'redirection' => 5,
			'httpversion' => '1.0',
			'user-agent'  => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' ),
			'blocking'    => true,
			'headers'     => [],
			'cookies'     => [],
			'body'        => null,
			'compress'    => false,
			'decompress'  => true,
			'sslverify'   => true,
			'stream'      => false,
			'filename'    => null
		];	
		
		$response = wp_remote_get( 'https://plugins.svn.wordpress.org/' . $file . '/', $args );
	
		if ( is_wp_error( $response ) ) {
			$status = false;
		} else {
			$response_code = wp_remote_retrieve_response_code( $response );
			if ( '200' == $response_code ) {
				$status = true;
			} else {
				$status = false;
			}
		}

		return $status;
	}

	/**
	 * Start fetching process.
	 */
	public function activate_plugin( $plugin )
	{
		$this->call_api( $this->get_path( $plugin ) );
	}

	/**
	 * Run process after plugin update.
	 */
	public function update_action( $upgrader_object, $options )
	{
		// If an update has taken place and the updated type is plugins and the plugins element exists
		if ( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
	        // Iterate through the plugins being updated
		    foreach( $options['plugins'] as $plugin ) {
		        $this->call_api( $this->get_path( $plugin ) );
		    }
		}
	}

	/**
	 * Get plugin file or path name.
	 */
	private function get_path( $file )
	{
		$file_parts = explode( '/', $file );
        if ( count( $file_parts ) > 1 ) {
			$new_file = $file_parts[0];
		} else {
			$new_file = str_replace( '.php', '', $file );
		}

		return $new_file;
	}
}