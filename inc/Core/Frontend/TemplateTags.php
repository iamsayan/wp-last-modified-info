<?php
/**
 * Template tags.
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
 * Template tags class.
 */
class TemplateTags extends PostView
{
	/**
	 * array $params
	 */
	private $params;

	/**
	 * Class constructor.
	 *
	 * @see get_the_last_modified_info()
	 *
	 * @param array<string,mixed>  $args  The arguments.
	 */
	public function __construct( array $args ) {
		$this->params = $args;
	}

	/**
	 * Template tag output.
	 *
	 * @return string $html
	 */
	public function output() {
		global $post;

		if ( ! $post instanceof \WP_Post ) {
			return;
		}

		$template = $this->get_data( 'lmt_last_modified_info_template_tt' );
		if ( empty( $template ) ) {
			return;
		}

		$author_id = $this->get_meta( $post->ID, '_edit_last' );
		if ( $this->is_equal( 'show_author_tt_cb', 'custom', 'default' ) ) {
			$author_id = $this->get_data( 'lmt_show_author_list_tt' );
		}

		// Get Format
		$date_type = $this->get_data( 'lmt_last_modified_format_tt', 'default' );
		$date_type = $this->do_filter( 'template_tags_datetime_type', $date_type, $post->ID );

		// Generate Timestamp
		$timestamp = human_time_diff( get_post_modified_time( 'U' ), current_time( 'U' ) );
		if ( $date_type == 'default' ) {
			$format = $this->get_data( 'lmt_tt_set_format_box', get_option( 'date_format' ) );
			$format = $this->do_filter( 'template_tags_datetime_format', $format, $post->ID );
			$timestamp = $this->get_modified_date( $format );
		}
		$final_timestamp = $timestamp;
		$timestamp = $this->do_filter( 'template_tags_formatted_date', $timestamp, $post->ID );

		// Prepare template
		$template = $this->generate( $template, $post->ID, $timestamp, $author_id );

		if ( $this->params['escape'] ) {
			$template = wp_strip_all_tags( $template );
		}

		if ( $this->params['only_date'] ) {
			$template = $final_timestamp;
		}

		return $template;
	}
}
