<?php
/**
 * Show modified info using shortcode.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Frontend
 * @author     Sayan Datta <iamsayan@protonmail.com>
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
	 * Register shortcodes.
	 */
	public function register() {
		add_shortcode( 'lmt-post-modified-info', [ $this, 'render' ] );
		add_shortcode( 'lmt-page-modified-info', [ $this, 'render' ] );
		add_shortcode( 'lmt-template-tags', [ $this, 'render_template_tags' ] );
		add_shortcode( 'lmt-site-modified-info', [ $this, 'render_global' ] );
	}

	/**
	 * Renders the shortcode output for post and page modified info.
     *
	 * @param array $atts Shortcode attributes.
	 * @return string Shortcode output.
	 */
	public function render( $atts ) {
		$post = get_post();
		if ( ! $post instanceof \WP_Post ) {
			return '';
		}

		if ( ! $this->is_enabled( 'enable_last_modified_cb' ) ) {
			return '';
		}

		$author_id = $this->get_meta( $post->ID, '_edit_last' );
		if ( $this->is_equal( 'show_author_cb', 'custom', 'default' ) ) {
			$author_id = $this->get_data( 'lmt_show_author_list' );
		}
		
		$default_format = get_option( 'date_format' );
		$atts = shortcode_atts( [
			'id'           => $post->ID,
			'template'     => $this->get_data( 'lmt_last_modified_info_template' ),
			'date_format'  => $this->get_data( 'lmt_date_time_format', $default_format ),
			'date_type'    => $this->get_data( 'lmt_last_modified_format_post', 'default' ),
			'schema'       => $this->get_data( 'lmt_enable_jsonld_markup_cb', 'disable' ),
			'author_id'    => (int) $author_id,
			'hide_archive' => '',
			'filter_ids'   => '',
			'gap'          => (int) $this->get_data( 'lmt_gap_on_post', 0 ),
		], $atts, 'lmt-post-modified-info' );

		$_post = get_post( absint( $atts['id'] ) );
		if ( ! $_post ) {
			return '';
		}

		if ( $atts['hide_archive'] !== '' ) {
			foreach ( array_map( 'trim', explode( ',', $atts['hide_archive'] ) ) as $callback ) {
				if ( is_callable( $callback ) && $callback() ) {
					return '';
				}
			}
		}

		if ( $atts['filter_ids'] !== '' && is_singular( array_map( 'trim', explode( ',', $atts['filter_ids'] ) ) ) ) {
			return '';
		}

		$template = $atts['template'];
		if ( $template === '' ) {
			return '';
		}

		$published = (int) get_post_time( 'U', false, $_post );
		$modified  = (int) get_post_modified_time( 'U', false, $_post );
		if ( ( $modified - $published ) < $atts['gap'] ) {
			return '';
		}

		$date_type = $this->do_filter( 'post_datetime_type', $atts['date_type'], $_post->ID );

		$timestamp = ( $date_type === 'default' )
			? $this->get_modified_date( $this->validate_date_format( $atts['date_format'], $default_format ), $_post )
			: human_time_diff( $modified, current_time( 'U' ) );
		$timestamp   = $this->do_filter( 'post_datetime_format', $timestamp, $_post->ID );

		$output = $this->generate( $template, $_post->ID, $timestamp, $atts['author_id'] );

		return $this->wrapper( $output, $_post->ID, true, false, 'sc' );
	}

	/**
	 * Callback to register template tags shortcodes.
	 *
	 * @since v1.7.1
	 * @param array $atts Shortcode attributes.
	 * @return string Shortcode output.
	 */
	public function render_template_tags( $atts ) {
		$atts = shortcode_atts( [
			'escape'    => false,
			'only_date' => false,
		], $atts, 'lmt-template-tags' );

		return (string) get_the_last_modified_info( $atts['escape'], $atts['only_date'] );
	}

	/**
	 * Renders the shortcode output for global site modified info.
     *
	 * @param array $atts Shortcode attributes.
	 * @return string Shortcode output.
	 */
	public function render_global( $atts ) {
		$option = get_option( 'wplmi_site_global_update_info' );
		if ( ! is_numeric( $option ) ) {
			return '';
		}

		$default_format = get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' );
		$atts = shortcode_atts( [
			'format' => $default_format,
		], $atts, 'lmt-site-modified-info' );

		$format = $this->validate_date_format( $atts['format'], $default_format );
		
		return date_i18n( $format, (int) $option );
	}
}