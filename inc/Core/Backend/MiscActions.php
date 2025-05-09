<?php
/**
 * Register miscellaneous actions.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Core\Backend;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Misc Actions class.
 */
class MiscActions
{
	use HelperFunctions;
    use Hooker;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( 'admin_init', 'actions' );
		$this->action( 'wp_head', 'custom_css' );
		$this->action( 'pre_get_posts', 'sorting_order' );
		$this->action( 'pre_get_posts', 'frontend_sorting_order' );
		$this->action( 'init', 'disable_date_time', 1 );
		$this->filter( 'get_the_time', 'replace_time', 10, 3 );
        $this->filter( 'get_the_date', 'replace_date', 10, 3 );
	}

	/**
	 * WP Actions added to admin_init.
	 */
	public function actions() {
		$this->filter( 'post_updated_messages', 'messages' );
		$this->action( 'save_post', 'save_post' );
	}

	/**
	 * Generate column data.
	 *
	 * @param string   $messages   Messages
	 *
	 * @return string  $time
	 */
	public function messages( $messages ) {
		global $post;

		$wp_post = $post;

		if ( ! $wp_post instanceof \WP_Post ) {
			if ( empty( $_REQUEST['post'] ) ) {
				return $messages;
			}
			$post_id = absint( $_REQUEST['post'] );
			$wp_post = get_post( $post_id );
		}

		// get WordPress date time format
		$get_df = get_option( 'date_format' );
		$get_tf = get_option( 'time_format' );

		$m_orig = get_post_field( 'post_modified', $wp_post->ID, 'raw' );
		$post_modified = '&nbsp;<strong>' . date_i18n( $this->do_filter( 'post_updated_datetime_format', $get_df . ' @ ' . $get_tf, $wp_post->ID ), strtotime( $m_orig ) ) . '</strong>.&nbsp;';

		// get post types returns object
		$post_types = get_post_type_object( $wp_post->post_type );
		if ( is_post_type_viewable( $wp_post->post_type ) ) {
			$post_modified .= sprintf( '<a href="%1$s" target="_blank">%2$s %3$s</a>', esc_url( get_permalink( $wp_post->ID ) ), esc_html__( 'View', 'wp-last-modified-info' ), $post_types->name );
		}

		if ( isset( $messages[ $wp_post->post_type ] ) ) {
			$messages[ $wp_post->post_type ][1] = esc_html( $post_types->labels->singular_name ) . '&nbsp;' . sprintf( 
				/* translators: %s: Post modified date */
				esc_html__( 'updated on %s', 'wp-last-modified-info' ), $post_modified 
			);
		}

		return $messages;
	}

	/**
	 * Runs after post save.
	 *
	 * @param int      $post_id  Post ID
	 */
	public function save_post( $post_id ) {
		// get WordPress date time format
		$get_df = get_option( 'date_format' );
		$get_tf = get_option( 'time_format' );

		// get post meta data
		$m_orig    = get_post_field( 'post_modified', $post_id, 'raw' );
		$m_stamp   = strtotime( $m_orig );
		$modified  = date_i18n( $this->do_filter( 'custom_field_date_time_format', $get_df . ' @ ' . $get_tf ), $m_stamp );

		// update post meta
		$this->update_meta( $post_id, 'wp_last_modified_info', $modified );

		// update global site update time
		update_option( 'wplmi_site_global_update_info', current_time( 'timestamp', 0 ) );
	}

	/**
	 * Replace published time.
	 *
	 * @param string   $time     Post published time
	 * @param string   $format   Post date format
	 * @param int      $post_id  Post ID
	 *
	 * @return string  $time
	 */
	public function replace_time( $time, $format, $post ) {
		if ( ! $this->is_equal( 'replace_published_date', 'replace' ) || is_admin() ) {
            return $time;
		}

		return get_the_modified_time( $format, $post );
	}

	/**
	 * Replace published date.
	 *
	 * @param string   $date     Post published date
	 * @param string   $format   Post date format
	 * @param int      $post_id  Post ID
	 *
	 * @return string  $time
	 */
	public function replace_date( $date, $format, $post ) {
		if ( ! $this->is_equal( 'replace_published_date', 'replace' ) || is_admin() ) {
            return $date;
		}

		return get_the_modified_date( $format, $post );
	}

	/**
	 * Disable Date Time output completely.
	 */
	public function disable_date_time() {
		if ( ! $this->is_equal( 'replace_published_date', 'remove' ) || is_admin() ) {
            return;
		}

		add_filter( 'the_date', '__return_false', 1 );
		add_filter( 'the_time', '__return_false', 1 );
		add_filter( 'the_modified_date', '__return_false', 1 );
		add_filter( 'get_the_date', '__return_false', 1 );
		add_filter( 'get_the_time', '__return_false', 1 );
		add_filter( 'get_the_modified_date', '__return_false', 1 );
	}

	/**
	 * Filter query.
	 *
	 * @param object $query WP Query
	 */
	public function sorting_order( $query ) {
		global $pagenow;
		$order = $this->is_equal( 'admin_default_sort_order', 'published' ) ? 'asc' : 'desc';

		if ( ! $this->is_equal( 'admin_default_sort_order', 'default' ) ) {
			if ( is_admin() && 'edit.php' === $pagenow && ! isset( $_GET['orderby'], $_GET['order'] ) ) {
				$query->set( 'orderby', 'modified' );
				$query->set( 'order', $order );
			}
		}
	}

	/**
	 * Filter query.
	 *
	 * @param object $query WP Query
	 */
	public function frontend_sorting_order( $query ) {
		global $pagenow;
		$order = $this->is_equal( 'default_sort_order', 'published' ) ? 'asc' : 'desc';

		if ( ! $this->is_equal( 'default_sort_order', 'default' ) ) {
			if ( ! is_admin() && $query->is_main_query() ) {
			    if ( $query->is_home() || $query->is_category() || $query->is_tag() ) {
			    	$query->set( 'orderby', 'modified' );
			    	$query->set( 'order', $order );
				}
			}
		}
	}

	/**
	 * Custom CSS Ouput.
	 */
	public function custom_css() {
		$css = $this->get_data( 'lmt_custom_style_box' );
		if ( function_exists( '_is_elementor_installed' ) && defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$css .= ' span.wplmi-user-avatar { width: 16px;display: inline-block !important;flex-shrink: 0; } img.wplmi-elementor-avatar { border-radius: 100%;margin-right: 3px; }';
		}

		if ( ! empty( $css ) ) {
			echo '<style id="wplmi-inline-css" type="text/css">'."\n". wp_kses_post( wp_unslash( $css ) ) ."\n".'</style>'."\n";
		}
	}
}
