<?php
/**
 * Show Original Republish Data.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Core\Frontend;

use Wplmi\Helpers\Hooker;
use Wplmi\Core\Frontend\PostView;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Republish info class.
 */
class Shortcode extends PostView
{
	use HelperFunctions, Hooker;

	/**
	 * Register functions.
	 */
	public function register()
	{
		add_shortcode( 'lmt-post-modified-info', [ $this, 'render' ] );
		add_shortcode( 'lmt-page-modified-info', [ $this, 'render' ] );
		add_shortcode( 'lmt-site-modified-info', [ $this, 'render_global' ] );
	}

	/**
	 * Show original publish info.
	 * 
	 * @param string  $content  Original Content
	 * 
	 * @return string $content  Filtered Content
	 */
	public function render( $atts )
	{
		global $post;
		$post_id = $post->ID;

		if ( ! $this->is_enabled( 'enable_last_modified_cb' ) ) {
			return;
		}

		if ( ! $this->is_equal( 'show_last_modified_time_date_post', 'manual' ) ) {
			return;
		}

		$format = $this->get_data( 'lmt_date_time_format', get_option( 'date_format' ) );
		$format = ( ! empty( $format ) ) ? $format : get_option( 'date_format' );

		$author_id = $this->get_meta( get_the_ID(), '_edit_last' );
		if ( $this->is_equal( 'show_author_cb', 'custom', 'default' ) ) {
			$author_id = $this->get_data( 'lmt_show_author_list' );
		}
	
		$atts = shortcode_atts( [
			'id'           => $post_id,
			'date_format'  => $format,
			'date_type'    => $this->get_data( 'lmt_last_modified_format_post', 'default' ),
			'schema'       => $this->get_data( 'lmt_enable_jsonld_markup_cb', 'disable' ),
			'author_id'    => $author_id,
			'hide_archive' => [],
			'filter_ids'   => [],
			'gap'          => $this->get_data( 'lmt_gap_on_post', 0 ),
		], $atts, 'lmt-post-modified-info' );

		$get_post = get_post( absint( $atts['id'] ) );
		if ( ! $get_post ) {
			return;
		}

		if ( ! empty( $atts['hide_archive'] ) ) {
			$archives = explode( ',', $atts['hide_archive'] );
			if ( ! empty( $archives ) ) {
				foreach ( $archives as $archive ) {
					if ( is_callable( $archive ) ) {
						if ( $archive() ) {
							return;
						}
					}
				}
			}
		}

		if ( ! empty( $atts['filter_ids'] ) ) {
			if ( is_singular( explode( ',', $atts['filter_ids'] ) ) ) {
				return;
			}
		}
		
		$template = $this->get_data( 'lmt_last_modified_info_template' );
		if ( empty( $template ) ) {
			return;
		}

		$published_timestamp = get_the_time( 'U' );
		$modified_timestamp = get_the_modified_time( 'U' );
		if ( $modified_timestamp <= ( $published_timestamp + $atts['gap'] ) ) {
			return;
		}

		$date_type = $this->do_filter( 'post_datetime_type', $atts['date_type'], $get_post->ID );

		$timestamp = human_time_diff( $modified_timestamp, current_time( 'U' ) );
		if ( $date_type == 'default' ) {
			$timestamp = get_the_modified_date( $atts['date_format'] );
		}
		$timestamp = $this->do_filter( 'post_datetime_format', $timestamp, $get_post->ID );

		$template = str_replace( "'", '"', $this->generate( htmlspecialchars_decode( $template ), $get_post->ID, $timestamp, $atts['author_id'] ) );

    	return $template;
	}

	public function render_global( $atts )
	{
		$option = get_option( 'wplmi_site_global_update_info' );
		if ( $option === false ) {
			return;
		}

		$atts = shortcode_atts( [
			'format'  => get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' ),
		], $atts, 'lmt-site-modified-info' );
		
		return get_date_from_gmt( date( 'Y-m-d H:i:s', $option ), $atts['format'] );
	}
}