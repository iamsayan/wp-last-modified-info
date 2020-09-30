<?php
/**
 * Json-ld Schema.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Frontend
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Core\Frontend;

use Wplmi\Helpers\Hooker;
use Wplmi\Base\BaseController;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Schema class.
 */
class Schema extends BaseController
{
	use HelperFunctions, Hooker;

	/**
	 * Register functions.
	 */
	public function register()
	{
		$this->action( 'wp_head', 'schema_markup', 5 );
		$this->filter( 'language_attributes', 'schema_attribute' );
		$this->action( 'template_redirect', 'run_replace' );
	}

	/**
	 * Echo Json-ld Schema codes.
	 */
	public function schema_markup()
	{ 
		global $post;

		if ( ! is_singular() ) {
			return;
		}
	
		// get post infos
		$full_content = $post->post_content;
		$excerpt = $post->post_excerpt;
	
		// get post modfied author ID
		$author_id = $this->get_meta( $post->ID, '_edit_last' ); 

		// Strip shortcodes and tags
		$full_content = preg_replace( '#\[[^\]]+\]#', '', $full_content );
		$full_content = wp_strip_all_tags( $full_content );
		$full_content = $this->do_filter( 'schema_content', $full_content, $post->ID );
	
		$desc_word_count = $this->do_filter( 'schema_description_word_count', 60 );
		$short_content = wp_trim_words( $full_content, $desc_word_count, '' );
		$short_content = ( ! empty( $excerpt ) ) ? $excerpt : $short_content;
	
		$json = [
			'@context'         => 'http://schema.org/',
			'@type'            => 'CreativeWork',
			'dateModified'     => esc_attr( get_post_modified_time( 'Y-m-d\TH:i:sP', false ) ),
			'headline'         => esc_html( $post->post_title ),
			'description'      => wptexturize( $this->do_filter( 'wplmi_schema_description', $short_content, $post->ID ) ),
			'mainEntityOfPage' => [
				'@type' => 'WebPage',
				'@id'   => get_permalink( $post->ID ),
			],
			'author'           => [
				'@type'          => 'Person',
				'name'           => esc_html( get_the_author_meta( 'display_name', $author_id ) ),
				'url'            => esc_url( get_author_posts_url( $author_id ) ),
				'description'    => esc_html( get_the_author_meta( 'description', $author_id ) ),
			],
		];
	
		if ( is_page() ) {
			// change schema type for pages
			$json['@type'] = 'WebPage';
			unset( $json['mainEntityOfPage'] );
		}
	
		$json = $this->do_filter( 'schema_items', $json, $post->ID );
	
		$output = '';
		if ( ! empty( $json ) ) {
			$output .= "\n\n";
			$output .= '<!-- Last Modified Schema is inserted by the WP Last Modified Info plugin v' . $this->version . ' - https://wordpress.org/plugins/wp-last-modified-info/ -->';
			$output .= "\n";
			$output .= '<script type="application/ld+json">' . wp_json_encode( $json ) . '</script>';
			$output .= "\n\n";
		}

		$post_types = $this->get_data( 'lmt_enable_jsonld_markup_post_types', [ 'post' ] );
		if ( $this->is_equal( 'enable_jsonld_markup_cb', 'enable' ) && ! empty( $post_types ) ) {
			if ( in_array( get_post_type( $post->ID ), $post_types ) ) {
				echo $output;
			}
		}
	}

	/**
	 * Hooks the language attributes to add Extended schema compatibility.
	 * 
	 * @param string  $input   Original Content
	 * @return string $output  Filtered Content
	 */
	public function schema_attribute( $input )
	{
		if ( ! $this->is_enabled( 'enable_schema_support_cb' ) || ! $this->is_equal( 'enable_jsonld_markup_cb', 'inline' ) ) {
			return $input;
		}

		$output = trim( $input );
		$attrs = [
			[
				'attr'  => 'itemscope itemtype',
				'value' => 'https://schema.org/WebPage',
			],
		];

		foreach( $attrs as $info ) {
			if ( strpos( $input, $info['attr'] ) === false ) {
				$output .= ' ' . $info['attr'] . '="' . $info['value'] . '"';
			}
		}

		return $output;
	}

	/**
	 * Runs ob_srart().
	 */
	public function run_replace()
	{
		if ( ! is_admin() ) {
			ob_start( [ $this, 'replace' ] );
		}
	}

	/**
	 * Replace the strings.
	 * 
	 * @param string  $html  Original Content
	 * 
	 * @return string $html  Filtered Content
	 */
	public function replace( $html )
	{
		global $post;

		if ( ! $post ) {
			return $html;
		}
	
		if ( ! is_singular() ) {
		    return $html;
		}

		$replace = $this->do_filter( 'published_schema_replace', true );
		if ( ! $this->is_equal( 'enable_jsonld_markup_cb', 'disable' ) && $replace ) {
			if ( $this->is_equal( 'replace_published_date', 'remove' ) ) {
			    $html = str_replace( ' itemprop="datePublished"', '', $html );
			} else {
				$html = str_replace( ' itemprop="datePublished"', ' itemprop="dateModified"', $html );
			}
		}
	
		if ( $this->is_equal( 'enable_jsonld_markup_cb', 'comp_mode' ) ) {
		    // All in One SEO Pack Meta Compatibility
		    $html = str_replace( date( 'Y-m-d\TH:i:s\Z', mysql2date( 'U', $post->post_date_gmt ) ), date( 'Y-m-d\TH:i:s\Z', mysql2date( 'U', $post->post_modified_gmt ) ), $html );
		    // Yoast SEO Compatibility
		    $html = str_replace( get_post_time( 'Y-m-d\TH:i:sP', true, $post ), get_post_modified_time( 'Y-m-d\TH:i:sP', true, $post ), $html );
		    // Rank Math, All in One SEO Pack SEO & Newspaper theme Compatibility
		    $html = str_replace( $this->do_filter( 'schema_datetime_fotmat', [ get_post_time( 'Y-m-d\TH:i:sP', false, $post ), date( DATE_W3C, get_post_time( 'U' ) ), mysql2date( DATE_W3C, $post->post_modified_gmt, false ) ] ), get_post_modified_time( 'Y-m-d\TH:i:sP', false ), $html );
		}

		return $html;
	}
}