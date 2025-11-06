<?php
/**
 * Register Gutenberg Blocks for WP >= 5.8
 *
 * @since      1.8.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Core;

use Wplmi\Helpers\Hooker;
use Wplmi\Base\BaseController;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Blocks class.
 */
class Blocks extends BaseController
{
	use HelperFunctions;
    use Hooker;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( 'init', 'register_blocks' );
	}

	/**
	 * Register blocks script, translations for it and register blocks.
	 */
	public function register_blocks() {
		global $pagenow, $wp_version;
		if ( version_compare( $wp_version, '5.8', '<' ) ) {
			return;
		}

		/**
		 * List of Blocks in Name => Callback pair.
		 */
		$blocks = [
			'post-modified-date' => [
				'callback' => 'post_modified',
				'visible'  => ( 'widgets.php' !== $pagenow ),
			],
			'post-template-tag'  => [
				'callback' => 'post_template_tag',
				'visible'  => ( 'widgets.php' !== $pagenow ),
			],
			'site-modified-date' => [
				'callback' => 'site_modified',
				'visible'  => true,
			],
		];

		foreach ( $blocks as $name => $params ) {
			if ( $params['visible'] ) {
				register_block_type( $this->plugin_path . 'blocks/build/' . $name, [
					'render_callback' => [ $this, $params['callback'] ],
				] );
			}
		}
	}

	/**
	 * Callback method for the 'post-modified-date' block.
	 *
	 * @param array    $attributes Block attributes.
	 * @param string   $content    Block default content.
	 * @param WP_Block $block      Block instance.
	 *
	 * @return string|null  Returns the post modified date markup or null if postId missing.
	 */
	public function post_modified( $attributes, $content, $block ) {
		if ( ! isset( $block->context['postId'] ) ) {
			return '';
		}

		$post_id      = absint( $block->context['postId'] );
		$attributes   = $this->normalize_attributes( $attributes );
		$attributes   = $this->do_filter( 'post_modified_block_attributes', $attributes, $post_id );

		$classes = [ 'wp-block', 'wplmi-post-modified' ];
		if ( ! empty( $attributes['className'] ) ) {
			$classes[] = $attributes['className'];
		}

		$date_content = $this->get_modified_date( $attributes['format'] ?? '', $post_id );

		if ( ! empty( $attributes['textBefore'] ) ) {
			$date_content = '<span class="wplmi-site-modified-prefix">' . esc_html( $attributes['textBefore'] ) . '</span>' . $date_content;
		}

		if ( ! empty( $attributes['textAfter'] ) ) {
			$date_content .= '<span class="wplmi-site-modified-suffix">' . esc_html( $attributes['textAfter'] ) . '</span>';
		}

		$styles = $this->convert_styles( $attributes['styles'] ?? [] );

		$tag = ( ! empty( $attributes['display'] ) && $attributes['display'] === 'block' ) ? 'div' : 'span';

		return sprintf(
			'<%1$s class="%2$s" style="%3$s">%4$s</%1$s>',
			$tag,
			esc_attr( implode( ' ', $classes ) ),
			esc_attr( $styles ),
			$date_content
		);
	}

	/**
	 * Callback method for the 'post-template-tag' block.
	 *
	 * @param array    $attributes Block attributes.
	 * @param string   $content    Block default content.
	 * @param WP_Block $block      Block instance.
	 *
	 * @return string  Returns the last modified info.
	 */
	public function post_template_tag( $attributes, $content, $block ) {
		return (string) get_the_last_modified_info();
	}

	/**
	 * Callback method for the 'site-modified-date' block.
	 *
	 * @param array $attributes Block attributes.
	 *
	 * @return string  Returns the site modified date markup.
	 */
	public function site_modified( $attributes ) {
		$attributes = $this->normalize_attributes( $attributes );
		$attributes = $this->do_filter( 'site_modified_block_attributes', $attributes );

		$classes = [ 'wp-block', 'wplmi-site-modified' ];
		if ( ! empty( $attributes['className'] ) ) {
			$classes[] = $attributes['className'];
		}

		$shortcode = sprintf(
			'[lmt-site-modified-info%1$s]',
			! empty( $attributes['format'] ) ? ' format="' . esc_attr( $attributes['format'] ) . '"' : ''
		);
		$content = do_shortcode( $shortcode );

		if ( ! empty( $attributes['textBefore'] ) ) {
			$content = '<span class="wplmi-site-modified-prefix">' . esc_html( $attributes['textBefore'] ) . '</span>' . $content;
		}

		if ( ! empty( $attributes['textAfter'] ) ) {
			$content .= '<span class="wplmi-site-modified-suffix">' . esc_html( $attributes['textAfter'] ) . '</span>';
		}

		$styles = $this->convert_styles( $attributes['styles'] ?? [] );

		$tag = ( ! empty( $attributes['display'] ) && $attributes['display'] === 'block' ) ? 'div' : 'span';

		return sprintf(
			'<%1$s class="%2$s" style="%3$s">%4$s</%1$s>',
			$tag,
			esc_attr( implode( ' ', $classes ) ),
			esc_attr( $styles ),
			$content
		);
	}

	/**
	 * Convert array items to CSS rules.
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	private function convert_styles( $args ) {
		if ( ! is_array( $args ) ) {
			return '';
		}

		$rules = [];
		foreach ( $args as $key => $value ) {
			if ( is_string( $key ) && is_scalar( $value ) ) {
				$rules[] = sanitize_key( $key ) . ': ' . esc_html( $value );
			}
		}

		return implode( '; ', $rules );
	}

	/**
	 * Normalize block attributes to match shortcode expectations.
	 *
	 * Also appends 'px' to font-size when numeric.
	 *
	 * @param array $attributes
	 *
	 * @return array
	 */
	private function normalize_attributes( $attributes ) {
		$map = [
			'varLineHeight'      => 'line-height',
			'varFontSize'        => 'font-size',
			'varColorBackground' => 'background-color',
			'varColorText'       => 'color',
			'textAlign'          => 'text-align',
		];

		$output = [];
		foreach ( $attributes as $key => $value ) {
			if ( isset( $map[ $key ] ) ) {
				$output[ $map[ $key ] ] = $value;
			}
		}

		if ( isset( $output['font-size'] ) && is_numeric( $output['font-size'] ) ) {
			$output['font-size'] .= 'px';
		}

		return [
			'styles' => $output,
		] + $attributes;
	}
}
