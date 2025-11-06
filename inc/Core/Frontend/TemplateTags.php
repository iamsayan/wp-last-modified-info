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
	 * @var array<string,mixed>
	 */
	private $params;

	/**
	 * Class constructor.
	 *
	 * @see get_the_last_modified_info()
	 *
	 * @param array<string,mixed> $args The arguments.
	 */
	public function __construct( array $args ) {
		$this->params = array_merge(
			[
				'escape'    => false,
				'only_date' => false,
			],
			$args
		);
	}

	/**
	 * Template tag output.
	 *
	 * @return string
	 */
	public function output() {
		$post = get_post();

		if ( ! $post instanceof \WP_Post ) {
			return '';
		}

		$template = (string) $this->get_data( 'lmt_last_modified_info_template_tt' );
		if ( $template === '' ) {
			return '';
		}

		$author_id = (int) $this->get_meta( $post->ID, '_edit_last' );
		if ( $this->is_equal( 'show_author_tt_cb', 'custom', 'default' ) ) {
			$custom_author = $this->get_data( 'lmt_show_author_list_tt' );
			if ( is_numeric( $custom_author ) ) {
				$author_id = (int) $custom_author;
			}
		}

		// Determine date type and format.
		$date_type = (string) $this->get_data( 'lmt_last_modified_format_tt', 'default' );
		$date_type = $this->do_filter( 'template_tags_datetime_type', $date_type, $post->ID );

		// Build timestamp.
		if ( $date_type === 'default' ) {
			$format = (string) $this->get_data( 'lmt_tt_set_format_box', get_option( 'date_format' ) );
			$format = $this->do_filter( 'template_tags_datetime_format', $format, $post->ID );
			$timestamp = $this->get_modified_date( $format );
		} else {
			$timestamp = human_time_diff( get_post_modified_time( 'U', true, $post ), current_time( 'U' ) );
		}

		$final_timestamp = $timestamp;
		$timestamp       = $this->do_filter( 'template_tags_formatted_date', $timestamp, $post->ID );

		// Generate output.
		$output = $this->generate( $template, $post->ID, $timestamp, $author_id );

		if ( ! empty( $this->params['escape'] ) ) {
			$output = wp_strip_all_tags( $output );
		}

		if ( ! empty( $this->params['only_date'] ) ) {
			$output = $final_timestamp;
		}

		return (string) $output;
	}
}
