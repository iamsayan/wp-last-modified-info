<?php
/**
 * Show modified info using shortcode.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Frontend
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Core\Frontend;

use Wplmi\Core\Frontend\PostView;

defined( 'ABSPATH' ) || exit;

/**
 * Shortcode class.
 */
class Shortcode extends PostView
{
	/**
	 * Register functions.
	 */
	public function register()
	{
		add_shortcode( 'lmt-post-modified-info', [ $this, 'render' ] );
		add_shortcode( 'lmt-page-modified-info', [ $this, 'render' ] );
		add_shortcode( 'lmt-template-tags', [ $this, 'render_template_tags' ] );
		add_shortcode( 'lmt-site-modified-info', [ $this, 'render_global' ] );
	}

	/**
     * Callback to register shortcodes.
     *
     * @param array $atts Shortcode attributes.
	 * 
     * @return string     Shortcode output.
     */
	public function render( $atts )
	{
		global $post;
		
		if ( ! $this->is_enabled( 'enable_last_modified_cb' ) ) {
			return;
		}

		$post_id = $post->ID;
		$author_id = $this->get_meta( $post_id, '_edit_last' );
		if ( $this->is_equal( 'show_author_cb', 'custom', 'default' ) ) {
			$author_id = $this->get_data( 'lmt_show_author_list' );
		}
	
		$atts = shortcode_atts( [
			'id'           => $post_id,
			'template'     => $this->get_data( 'lmt_last_modified_info_template' ),
			'date_format'  => $this->get_data( 'lmt_date_time_format', get_option( 'date_format' ) ),
			'date_type'    => $this->get_data( 'lmt_last_modified_format_post', 'default' ),
			'schema'       => $this->get_data( 'lmt_enable_jsonld_markup_cb', 'disable' ),
			'author_id'    => $author_id,
			'hide_archive' => '',
			'filter_ids'   => '',
			'gap'          => $this->get_data( 'lmt_gap_on_post', 0 )
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
		
		if ( empty( $atts['template'] ) ) {
			return;
		}

		$published_timestamp = get_post_time( 'U' );
		$modified_timestamp = get_post_modified_time( 'U' );
		if ( $modified_timestamp < ( $published_timestamp + $atts['gap'] ) ) {
			return;
		}

		$date_type = $this->do_filter( 'post_datetime_type', $atts['date_type'], $get_post->ID );

		$timestamp = human_time_diff( $modified_timestamp, current_time( 'U' ) );
		if ( $date_type == 'default' ) {
			$timestamp = $this->get_modified_date( $atts['date_format'] );
		}
		$timestamp = $this->do_filter( 'post_datetime_format', $timestamp, $get_post->ID );

		$template = str_replace( "'", '"', $this->generate( htmlspecialchars_decode( wp_unslash( $atts['template'] ) ), $get_post->ID, $timestamp, $atts['author_id'] ) );

    	return $this->wrapper( $template, $get_post->ID, true, false, 'sc' );
	}

	/**
     * Callback to register template tags shortcodes.
	 * 
	 * @since v1.7.1
     *
     * @param array $atts Shortcode attributes.
	 * 
     * @return string     Shortcode output.
     */
	public function render_template_tags( $atts )
	{
		$atts = shortcode_atts( [
			'escape'    => false,
			'only_date' => false,
		], $atts, 'lmt-template-tags' );
		
		return get_the_last_modified_info( $atts['escape'], $atts['only_date'] );
	}

	/**
     * Callback to register shortcodes.
     *
     * @param array $atts Shortcode attributes.
	 * 
     * @return string     Shortcode output.
     */
	public function render_global( $atts )
	{
		$option = get_option( 'wplmi_site_global_update_info' );
		if ( $option === false ) {
			return;
		}

		$atts = shortcode_atts( [
			'format'  => get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' ),
		], $atts, 'lmt-site-modified-info' );
		
		return date_i18n( $atts['format'], $option );
	}
}