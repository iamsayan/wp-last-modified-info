<?php
/**
 * Show plugin updated info.
 *
 * @since      1.7.4
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Core\Backend;

use Wplmi\Helpers\Hooker;
use WP_Background_Process;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Plugins details class.
 */
class PluginsData extends WP_Background_Process
{
	use HelperFunctions;
    use Hooker;

	/**
	 * @var string
	 */
	protected $action = 'wplmi_fetch_plugin_data';

	/**
	 * Register functions.
	 */
	public function register() {
        $this->action( 'init', 'generate_cron' );
		$this->action( 'wplmi/fetch_plugin_data', 'clean_start' );
		$this->action( 'plugin_row_meta', 'display', 99, 2 );
		$this->action( 'activate_plugin', 'activate_plugin' );
		$this->action( 'deactivate_plugin', 'deactivate_plugin' );
		$this->action( 'upgrader_process_complete', 'update_action', 10, 2 );
	}

	/**
	 * Cron cleanup on request.
	 */
	public function generate_cron() {
		if ( ! wp_next_scheduled( 'wplmi/fetch_plugin_data' ) ) {
		    wp_schedule_event( time(), 'weekly', 'wplmi/fetch_plugin_data' );
		}
	}

	/**
	 * Start fetching process.
	 */
	public function clean_start() {
		// check if disabled from settings
		if ( ! $this->is_enabled( 'disable_plugin_info' ) ) {
			$this->kill_process();
			$this->start_process();
		}
	}

	/**
	 * Start fetching process.
	 */
	public function start_process() {
        $plugins = (array) get_option( 'active_plugins' );

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
	protected function task( $item ) {
        $this->call_api( $item );
		sleep( 2 ); // stop for 2 seconds to optimize memory usage

		return false;
	}

	/**
	 * Kill process.
	 */
	private function kill_process() {
		$this->cancel_process();
	}

	/**
	 * Make API Calls
	 *
	 * @param mixed $item Queue item to iterate over
	 */
	protected function call_api( $item ) {
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
	private function save_data( $data ) {
		$saved_data = get_option( 'wplmi_plugin_api_data' );
		$new_data = ( $saved_data && is_array( $saved_data ) ) ? $saved_data : [];

		if ( empty( $data->slug ) ) {
		    return;
		}

		$new_data[ $data->slug ] = [
			'slug'       => $data->slug,
			'svn_exists' => $this->svn_exists( $data->slug ) ? 'yes' : 'no',
		];

		if ( ! empty( $data->version ) ) {
		    $new_data[ $data->slug ]['version'] = $data->version;
		}

		if ( ! empty( $data->requires ) ) {
		    $new_data[ $data->slug ]['requires'] = $data->requires;
		}

		if ( ! empty( $data->tested ) ) {
		    $new_data[ $data->slug ]['tested'] = $data->tested;
		}

		if ( ! empty( $data->last_updated ) ) {
		    $new_data[ $data->slug ]['last_updated'] = $data->last_updated;
		}

		if ( ! empty( $data->rating ) ) {
		    $new_data[ $data->slug ]['rating'] = $data->rating;
		}

		if ( ! empty( $data->num_ratings ) ) {
		    $new_data[ $data->slug ]['num_ratings'] = $data->num_ratings;
		}

		if ( ! empty( $data->active_installs ) ) {
		    $new_data[ $data->slug ]['active_installs'] = $data->active_installs;
		}

		return update_option( 'wplmi_plugin_api_data', array_filter( $new_data ), false );
	}

	/**
	 * Register meta links.
	 */
	public function display( $links, $file ) {
		global $wp_version;

		if ( $this->is_enabled( 'disable_plugin_info' ) ) {
			return $links;
		}

		$data = get_option( 'wplmi_plugin_api_data' );
		$new_file = $this->get_path( $file );

        if ( ! $data || ! isset( $data[ $new_file ] ) ) {
			return $links;
		}

		if ( ! empty( $data[ $new_file ]['last_updated'] ) ) {
			$date = get_date_from_gmt( $data[ $new_file ]['last_updated'], 'U' );
			$current_date = current_time( 'timestamp', 0 );
            $diff = strtotime( '-1 year', $current_date );
			if ( $diff <= $date ) {
				/* translators: %s: updated time */
			    $links[] = sprintf( esc_html__( 'Updated: %s', 'wp-last-modified-info' ), '<span style="font-weight: 600;">' . esc_html( date_i18n( get_option( 'date_format' ), $date ) ) . '</span>' );
		    } else {
				/* translators: %s: updated time */
				$links[] = sprintf( esc_html__( 'Updated: %s', 'wp-last-modified-info' ), '<span style="font-weight: 600;color: #c30808;">' . esc_html( date_i18n( get_option( 'date_format' ), $date ) ) . '</span>' );
		    }
	    }

		if ( ! empty( $data[ $new_file ]['rating'] ) ) {
			/* translators: %s: rating */
			$links[] = sprintf( esc_html__( 'Ratings: %s', 'wp-last-modified-info' ), esc_html( ( round( (int) $data[ $new_file ]['rating'], 0 ) / 20 ) . '/5' ) );
		}

		if ( ! empty( $data[ $new_file ]['num_ratings'] ) ) {
			/* translators: %s: no. of reviews */
			$links[] = sprintf( esc_html__( 'Reviews: %s', 'wp-last-modified-info' ), esc_html( $data[ $new_file ]['num_ratings'] ) );
		}

		if ( ! empty( $data[ $new_file ]['requires'] ) ) {
			/* translators: %s: vertion number */
			$links[] = sprintf( esc_html__( 'Requires at least: v%s', 'wp-last-modified-info' ), esc_html( $data[ $new_file ]['requires'] ) );
		}

		if ( ! empty( $data[ $new_file ]['tested'] ) ) {
			if ( version_compare( $wp_version, $data[ $new_file ]['tested'], '<=' ) ) {
				/* translators: %s: tested upto version */
			    $links[] = sprintf( esc_html__( 'Tested upto: %s', 'wp-last-modified-info' ), '<span style="font-weight: 600;">v' . esc_html( $data[ $new_file ]['tested'] ) . '</span>' );
			} else {
				/* translators: %s: tested upto version */
				$links[] = sprintf( esc_html__( 'Tested upto: %s', 'wp-last-modified-info' ), '<span style="font-weight: 600;color: #c30808;">v' . esc_html( $data[ $new_file ]['tested'] ) . '</span>' );
			}
		}

		if ( ! empty( $data[ $new_file ]['svn_exists'] ) ) {
			if ( $data[ $new_file ]['svn_exists'] == 'yes' ) {
				/* translators: %s: plugin info */
			    $links[] = sprintf( '%1$s %2$s', __( 'Status:', 'wp-last-modified-info' ), '<a href="https://wordpress.org/plugins/' . esc_attr( $data[ $new_file ]['slug'] ) . '/" target="_blank">' . esc_html__( 'Available', 'wp-last-modified-info' ) . '</a>' );
			}
		}

		return $this->do_filter( 'plugin_links', $links );
	}

	/**
	 * Check if plugin actually exists on wp svn.
	 */
	private function svn_exists( $file ) {
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
			'filename'    => null,
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
	 * Hook on Plugin Activation.
	 */
	public function activate_plugin( $plugin ) {
		$this->call_api( $this->get_path( $plugin ) );
	}

	/**
	 * Hook on Plugin Deactivation.
	 */
	public function deactivate_plugin( $plugin ) {
		$saved_data = get_option( 'wplmi_plugin_api_data', [] );
		$plugin = $this->get_path( $plugin );

		if ( isset( $saved_data[ $plugin ] ) ) {
			unset( $saved_data[ $plugin ] );
			update_option( 'wplmi_plugin_api_data', $saved_data, false );
		}
	}

	/**
	 * Run process after plugin update.
	 */
	public function update_action( $upgrader_object, $options ) {
		// If an update has taken place and the updated type is plugins and the plugins element exists
		if ( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
	        // Iterate through the plugins being updated
		    foreach ( $options['plugins'] as $plugin ) {
		        $this->call_api( $this->get_path( $plugin ) );
		    }
		}
	}

	/**
	 * Get plugin file or path name.
	 */
	private function get_path( $file ) {
		$file_parts = explode( '/', $file );
        if ( count( $file_parts ) > 1 ) {
			$new_file = $file_parts[0];
		} else {
			$new_file = str_replace( '.php', '', $file );
		}

		return $new_file;
	}
}
