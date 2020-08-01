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
class TemplateTags extends PostView
{
	use HelperFunctions, Hooker;

	/**
	 * Register functions.
	 */
	public function register()
	{
		$this->filter( 'wplmi/template_tags_output', 'output', 10, 3 );
	}

	/**
	 * Show original publish info.
	 * 
	 * @param string  $content  Original Content
	 * 
	 * @return string $content  Filtered Content
	 */
	public function output( $html, $escape, $only_date )
	{
		global $post;
		$post_id = $post->ID;

		if ( ! is_singular() ) {
			return $html;
		}

		$template = $this->get_data( 'lmt_last_modified_info_template_tt' );
		if ( empty( $template ) ) {
			return $html;
		}

		$author_id = $this->get_meta( $post->ID, '_edit_last' );
		if ( $this->is_equal( 'show_author_tt_cb', 'custom', 'default' ) ) {
			$author_id = $this->get_data( 'lmt_show_author_list_tt' );
		}

		$date_type = $this->get_data( 'lmt_last_modified_format_tt', 'default' );
		$date_type = $this->do_filter( 'template_tags_datetime_type', $date_type, $post_id );

		$timestamp = human_time_diff( get_post_modified_time( 'U' ), current_time( 'U' ) );
		if ( $date_type == 'default' ) {
			$format = $this->get_data( 'lmt_tt_set_format_box', get_option( 'date_format' ) );
			$format = $this->do_filter( 'template_tags_datetime_format', $format, $post_id );
			$timestamp = ( ! empty( $format ) ) ? get_the_modified_date( $format ) : get_the_modified_date( get_option( 'date_format' ) );
		    $final_timestamp = $timestamp;
		}
		$timestamp = $this->do_filter( 'template_tags_formatted_date', $timestamp, $post_id );

		$template = str_replace( "'", '"', $this->generate( htmlspecialchars_decode( $template ), $post_id, $timestamp, $author_id ) );
	
		if ( $escape ) {
			$template = wp_strip_all_tags( $template );
		}

		if ( $only_date ) {
			$template = $final_timestamp;
		}

		return $template;
	}
}