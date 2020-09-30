<?php
/**
 * Theme Compatibility.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Core;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Theme Compatibility class.
 */
class ThemeCompat
{
	use HelperFunctions, Hooker;

	/**
	 * Register functions.
	 */
	public function register()
	{
		$this->filter( 'astra_post_date', 'astra_post_meta' );
		$this->filter( 'astra_post_author', 'astra_post_author_meta' );
		$this->filter( 'generate_post_date_output', 'gp_post_meta' );
		$this->filter( 'generate_post_author_output', 'gp_post_author_meta' );
		$this->filter( 'genesis_attr_entry-time', 'genesis_schema_removal', 20 );
        $this->filter( 'genesis_attr_entry-modified-time',	'genesis_schema_removal', 20 );
		$this->action( 'template_redirect', 'run_replace' );
	}

	/**
	 * Regenerate the Astra Theme Date Meta.
	 * 
	 * @param string  $html    Original Date Meta
	 * @return string $output  Filtered Date Meta
	 */
	public function astra_post_meta( $html )
	{
		if ( $this->is_equal( 'tt_astra_theme_mod', 'none' ) ) {
			return $html;
		}
	
		$output = '';
		$format = $this->do_filter( 'astra_post_date_format', '' );

		$output .= '<span class="posted-on">' . $this->do_filter( 'astra_post_date_prepend', '' );
		$output .= '<span class="post-updated" itemprop="dateModified">' . esc_attr( $this->get_modified_date( $format ) ) . '</span>' . $this->do_filter( 'astra_post_date_append', '' );
		$output .= '</span>';

		if ( ! is_singular() && $this->do_filter( 'astra_filter_archive_output', true ) ) {
			return $output;
		}

		if ( $this->is_equal( 'tt_theme_template_type', 'custom' ) ) {
			$output = $this->do_filter( 'astra_post_template', get_the_last_modified_info(), $html );
		}
		
		return $output;
	}

	/**
	 * Regenerate the Astra Theme Author Meta.
	 * 
	 * @param string  $html    Original Author Meta
	 * @return string $output  Filtered Author Meta
	 */
	public function astra_post_author_meta( $html )
	{ 
		if ( $this->is_equal( 'tt_astra_theme_mod', 'none' ) ) {
			return $html;
		}

		if ( $this->do_filter( 'astra_show_original_author', false ) ) {
			return $html;
		}

		$author_id = $this->get_meta( get_the_ID(), '_edit_last' );
		$output = '';

		if ( $this->do_filter( 'astra_enable_author_output', false ) ) {
		    $output .= '<span class="posted-by vcard author" itemprop="author" itemtype="https://schema.org/Person" itemscope="">';
		    $output .= '<a class="url fn n" href="' . esc_url( get_author_posts_url( $author_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts by %s', 'wp-last-modified-info' ), get_the_author_meta( 'display_name', $author_id ) ) ) . '" rel="author" itemprop="url">';
		    $output .= '<span class="author-name" itemprop="name">' . esc_attr( get_the_author_meta( 'display_name', $author_id ) ) . '</span>';
			$output .= '</a></span>';
			
			if ( $this->do_filter( 'astra_remove_author_schema', false ) ) {
				$output = str_replace( 'itemprop="author" itemtype="https://schema.org/Person" itemscope=""', '', $output );
			}
		
			return $output;
		}

		return $html;
	}

	/**
	 * Regenerate the GeneratePress Theme Date Meta.
	 * 
	 * @param string  $html    Original Date Meta
	 * @return string $output  Filtered Date Meta
	 */
	public function gp_post_meta( $html )
	{
		if ( $this->is_equal( 'tt_generatepress_theme_mod', 'none' ) ) {
			return $html;
		}

		if ( $this->do_filter( 'gp_show_published_date', false ) ) {
			return $html;
		}

		$output = '';
		$format = $this->do_filter( 'gp_post_date_format', '' );

		$output .= '<span class="posted-on">' . apply_filters( 'generate_inside_post_meta_item_output', '', 'date' );
		$output .= '<a href="' . esc_url( get_the_permalink() ) . '" title="' . esc_attr( $this->get_modified_date( get_option( 'time_format' ) ) ) . '" rel="bookmark">';
		$output .= '<time class="post-updated" datetime="' . esc_attr( get_post_modified_time( 'Y-m-d\TH:i:sP', false ) ) . '" itemprop="dateModified">' . esc_attr( $this->get_modified_date( $format ) ). '</time>';
		$output .= '</a></span> ';

		if ( ! is_singular() && $this->do_filter( 'gp_filter_archive_output', true ) ) {
			return $output;
		}

		if ( $this->is_equal( 'tt_theme_template_type', 'custom' ) ) {
			$output = $this->do_filter( 'gp_post_template', get_the_last_modified_info(), $html );
		}

		return $output;
	}

	/**
	 * Regenerate the GeneratePress Theme Author Meta.
	 * 
	 * @param string  $html    Original Author Meta
	 * @return string $output  Filtered Author Meta
	 */
	public function gp_post_author_meta( $html )
	{ 
		if ( $this->is_equal( 'tt_generatepress_theme_mod', 'none' ) ) {
			return $html;
		}

		if ( $this->do_filter( 'gp_show_original_author', false ) ) {
			return $html;
		}

		$author_id = $this->get_meta( get_the_ID(), '_edit_last' );
		$output = '';

		if ( $this->is_equal( 'tt_theme_template_type', 'default' ) && $this->do_filter( 'gp_enable_author_output', false ) ) {
		    $output .= '<span class="posted-on">' . apply_filters( 'generate_inside_post_meta_item_output', '', 'author' );
		    $output .= '<span class="author vcard" itemprop="author" itemtype="https://schema.org/Person" itemscope="">';
		    $output .= '<a class="url fn n" href="' . esc_url( get_author_posts_url( $author_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts by %s', 'wp-last-modified-info' ), get_the_author_meta( 'display_name', $author_id ) ) ) . '" rel="author" itemprop="url">';
		    $output .= '<span class="author-name" itemprop="name">' . esc_attr( get_the_author_meta( 'display_name', $author_id ) ) . '</span>';
		    $output .= '</a></span></span> ';
		}

		if ( $this->do_filter( 'gp_remove_author_schema', false ) ) {
			$output = str_replace( ' itemprop="author" itemtype="https://schema.org/Person" itemscope=""', '', $output );
		}
		
		return $output;
	}

	/**
	 * Runs ob_srart().
	 */
	public function run_replace()
	{
		if ( $this->is_equal( 'tt_generatepress_theme_mod', 'none' ) ) {
			return;
		}

		$replace = $this->do_filter( 'gp_remove_schema', false );
		if ( ! is_admin() && defined( 'GENERATE_VERSION' ) && $replace ) {
			ob_start( [ $this, 'remove_schema' ] );
		}
	}

	/**
	 * Replace the strings.
	 * 
	 * @param string  $html  Original Content
	 * @return string $html  Filtered Content
	 */
	public function remove_schema( $html )
	{
		$html = str_replace( $this->do_filter( 'gp_schema', [ 'hfeed ', 'hentry ' ] ), '', $html );

		return $html;
	}

	/**
	 * Replace the schema properties of Genesis theme.
	 * 
	 * @param string  $attributes  Original Content
	 * @return string $attributes  Filtered Content
	 */
	public function genesis_schema_removal( $attributes )
	{
		$replace = $this->do_filter( 'genesis_remove_schema', false );
		if ( $replace ) {
		    $attributes['role']	= '';
		    $attributes['itemprop']	= '';
		    $attributes['itemscope'] = '';
		    $attributes['itemtype'] = ''; 
		}
			
		return $this->do_filter( 'genesis_schema_attributes', $attributes );
	}
}