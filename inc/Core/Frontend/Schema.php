<?php
/**
 * Json-ld Schema.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Frontend
 * @author     Sayan Datta <iamsayan@protonmail.com>
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
	use HelperFunctions;
	use Hooker;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( 'wp_head', 'schema_markup', 5 );
		$this->filter( 'language_attributes', 'schema_attribute' );
		$this->action( 'template_redirect', 'run_replace' );
	}

	/**
	 * Echo Json-ld Schema codes.
	 */
	public function schema_markup() {
		// Ensure we are on a singular post/page and have a valid post object.
		if ( ! is_singular() ) {
			return;
		}

		$post = get_post();
		if ( ! $post instanceof \WP_Post ) {
			return;
		}

		// Bail early if JSON-LD markup is not enabled.
		if ( ! $this->is_equal( 'enable_jsonld_markup_cb', 'enable' ) ) {
			return;
		}

		$post_types = (array) $this->get_data( 'lmt_enable_jsonld_markup_post_types', [ 'post' ] );
		if ( empty( $post_types ) || ! in_array( get_post_type( $post->ID ), $post_types, true ) ) {
			return;
		}

		// Prepare description.
		$full_content = $post->post_content;
		$excerpt      = $post->post_excerpt;

		// Strip shortcodes and tags.
		$full_content = preg_replace( '#\[[^\]]+\]#', '', $full_content );
		$full_content = wp_strip_all_tags( $full_content );
		$full_content = $this->do_filter( 'schema_content', $full_content, $post->ID );

		$desc_word_count = (int) $this->do_filter( 'schema_description_word_count', 60 );
		$short_content   = wp_trim_words( $full_content, $desc_word_count, '' );
		$short_content   = ( ! empty( $excerpt ) ) ? $excerpt : $short_content;

		// Get modified author ID safely.
		$author_id = (int) $this->get_meta( $post->ID, '_edit_last' );
		if ( $author_id <= 0 ) {
			$author_id = (int) $post->post_author;
		}

		// Build JSON-LD array.
		$json = [
			'@context'         => 'https://schema.org/',
			'@type'            => 'CreativeWork',
			'dateModified'     => esc_attr( get_post_modified_time( 'Y-m-d\TH:i:sP', false, $post ) ),
			'headline'         => esc_html( $post->post_title ),
			'description'      => wptexturize( $this->do_filter( 'wplmi_schema_description', $short_content, $post->ID ) ),
			'mainEntityOfPage' => [
				'@type' => 'WebPage',
				'@id'   => esc_url( get_permalink( $post ) ),
			],
			'author'           => [
				'@type'       => 'Person',
				'name'        => esc_html( get_the_author_meta( 'display_name', $author_id ) ),
				'url'         => esc_url( get_author_posts_url( $author_id ) ),
				'description' => esc_html( get_the_author_meta( 'description', $author_id ) ),
			],
		];

		// Adjust schema for pages.
		if ( is_page() ) {
			$json['@type'] = 'WebPage';
			unset( $json['mainEntityOfPage'] );
		}

		// Allow filtering of final schema.
		$json = $this->do_filter( 'schema_items', $json, $post->ID );

		// Output if valid.
		if ( ! empty( $json ) ) {
			echo "\n\n";
			echo '<!-- Last Modified Schema is inserted by the WP Last Modified Info plugin v' . esc_html( $this->version ) . ' - https://wordpress.org/plugins/wp-last-modified-info/ -->';
			echo "\n";
			echo '<script type="application/ld+json">' . wp_json_encode( $json ) . '</script>';
			echo "\n\n";
		}
	}

	/**
	 * Hooks the language attributes to add Extended schema compatibility.
	 *
	 * @param string $input Original Content.
	 * @return string Filtered Content.
	 */
	public function schema_attribute( $input ) {
		if ( ! $this->is_enabled( 'enable_schema_support_cb' ) || ! $this->is_equal( 'enable_jsonld_markup_cb', 'inline' ) ) {
			return $input;
		}

		$output = trim( $input );
		$attrs  = [
			[
				'attr'  => 'itemscope itemtype',
				'value' => 'https://schema.org/WebPage',
			],
		];

		foreach ( $attrs as $info ) {
			if ( strpos( $input, $info['attr'] ) === false ) {
				$output .= ' ' . $info['attr'] . '="' . esc_attr( $info['value'] ) . '"';
			}
		}

		return $output;
	}

	/**
	 * Runs output buffering for replacement.
	 */
	public function run_replace() {
		if ( ! is_admin() ) {
			ob_start( [ $this, 'replace' ] );
		}
	}

	/**
	 * Replace the strings for compatibility.
	 *
	 * @param string $html Original Content.
	 * @return string Filtered Content.
	 */
	public function replace( $html ) {
		// Ensure we are on a singular post/page and have a valid post object.
		if ( ! is_singular() ) {
			return $html;
		}

		$post = get_post();
		if ( ! $post instanceof \WP_Post ) {
			return $html;
		}

		$can_replace = $this->do_filter( 'published_schema_replace', true );
		if ( ! $this->is_equal( 'enable_jsonld_markup_cb', 'disable' ) && $can_replace ) {
			$replace = ' itemprop="dateModified"';

			if ( $this->is_equal( 'replace_published_date', 'remove' ) ) {
				$replace = '';
			}

			$html = str_replace( ' itemprop="datePublished"', $replace, $html );
		}

		if ( $this->is_equal( 'enable_jsonld_markup_cb', 'comp_mode' ) ) {
			// All in One SEO Pack Meta Compatibility.
			$published_gmt = mysql2date( 'U', $post->post_date_gmt, false );
			$modified_gmt  = mysql2date( 'U', $post->post_modified_gmt, false );
			if ( $published_gmt && $modified_gmt ) {
				$html = str_replace( gmdate( 'Y-m-d\TH:i:s\Z', $published_gmt ), gmdate( 'Y-m-d\TH:i:s\Z', $modified_gmt ), $html );
			}

			// Yoast SEO Compatibility.
			$published_time = get_post_time( 'Y-m-d\TH:i:sP', true, $post );
			$modified_time  = get_post_modified_time( 'Y-m-d\TH:i:sP', true, $post );
			if ( $published_time && $modified_time ) {
				$html = str_replace( $published_time, $modified_time, $html );
			}

			// Rank Math, All in One SEO Pack SEO & Newspaper theme Compatibility.
			$formats = (array) $this->do_filter( 'schema_datetime_fotmat', [
				get_post_time( 'Y-m-d\TH:i:sP', false, $post ),
				gmdate( DATE_W3C, get_post_time( 'U', false, $post ) ),
				mysql2date( DATE_W3C, $post->post_modified_gmt, false ),
			] );
			foreach ( $formats as $format ) {
				if ( $format ) {
					$html = str_replace( $format, get_post_modified_time( 'Y-m-d\TH:i:sP', false, $post ), $html );
				}
			}
		}

		return $this->do_filter( 'html_ouput', $html );
	}
}
