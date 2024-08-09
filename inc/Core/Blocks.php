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
	 * Callback method for the 'post-modified-date' block as defined for this block.
	 *
	 * @param array    $attributes Block attributes.
	 * @param string   $content    Block default content.
	 * @param WP_Block $block      Block instance.
	 *
	 * @return string  Returns the post modified date.
	 */
	public function post_modified( $attributes, $content, $block ) {
		if ( ! isset( $block->context['postId'] ) ) {
			return;
		}

		$post_id = $block->context['postId'];
		$attributes = $this->normalize_attributes( $attributes );
		$attributes = $this->do_filter( 'post_modified_block_attributes', $attributes, $post_id );

		$classes = [ 'wp-block', 'wplmi-post-modified' ];
		if ( isset( $attributes['className'] ) ) {
			$classes[] = $attributes['className'];
		}

		$date_content = $this->get_modified_date( $attributes['format'], $post_id );

		if ( isset( $attributes['textBefore'] ) ) {
			$date_content = '<span class="wplmi-site-modified-prefix">' . esc_html( $attributes['textBefore'] ) . '</span>' . $date_content;
		}

		if ( isset( $attributes['textAfter'] ) ) {
			$date_content = $date_content . '<span class="wplmi-site-modified-suffix">' . esc_html( $attributes['textAfter'] ) . '</span>';
		}

		$styles = $this->convert_styles( $attributes['styles'] );

		return sprintf(
			'<%1$s class="%2$s" style="%3$s">%4$s</%1$s>',
			( $attributes['display'] == 'block' ) ? 'div' : 'span',
			esc_attr( join( ' ', $classes ) ),
			esc_attr( $styles ),
			$date_content
		);
	}

	/**
	 * Callback method for the 'post-modified-date' block as defined for this block.
	 *
	 * @param array    $attributes Block attributes.
	 * @param string   $content    Block default content.
	 * @param WP_Block $block      Block instance.
	 *
	 * @return string  Returns the post modified date.
	 */
	public function post_template_tag( $attributes, $content, $block ) {
		return get_the_last_modified_info();
	}

	/**
	 * Callback method for the 'site-modified-date' block as defined for this block.
	 *
	 * @param array $attributes
	 *
	 * @param array    $attributes Block attributes.
	 *
	 * @return string  Returns the site modified date.
	 */
	public function site_modified( $attributes ) {
		$attributes = $this->normalize_attributes( $attributes );
		$attributes = $this->do_filter( 'site_modified_block_attributes', $attributes );

		$classes = [ 'wp-block', 'wplmi-site-modified' ];
		if ( isset( $attributes['className'] ) ) {
			$classes[] = $attributes['className'];
		}

		$shortcode = '[lmt-site-modified-info]';
		if ( isset( $attributes['format'] ) ) {
			$shortcode = '[lmt-site-modified-info format="' . $attributes['format'] . '"]';
		}
		$content = do_shortcode( $shortcode );

		if ( isset( $attributes['textBefore'] ) ) {
			$content = '<span class="wplmi-site-modified-prefix">' . esc_html( $attributes['textBefore'] ) . '</span>' . $content;
		}

		if ( isset( $attributes['textAfter'] ) ) {
			$content = $content . '<span class="wplmi-site-modified-suffix">' . esc_html( $attributes['textAfter'] ) . '</span>';
		}

		$styles = $this->convert_styles( $attributes['styles'] );

		return sprintf(
			'<%1$s class="%2$s" style="%3$s">%4$s</%1$s>',
			( $attributes['display'] == 'block' ) ? 'div' : 'span',
			esc_attr( join( ' ', $classes ) ),
			esc_attr( $styles ),
			$content
		);
	}

	/**
	 * Convert array items to CSS.
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	private function convert_styles( $args ) {
		$content = [];
		foreach ( $args as $key => $value ) {
			$content[] = $key . ': ' . $value;
		}

		return join( ';', $content );
	}

	/**
	 * Block attributes names can be different than attributes for the shortcodes. This function
	 * changes the attributes names to match the shortcodes functions.
	 *
	 * Also, font size value is missing the 'px', it has only value when set in the block attribute.
	 *
	 * @param array $attributes
	 *
	 * @return string
	 */
	private function normalize_attributes( $attributes ) {
		$map = [
			'varLineHeight'      => 'line-height',
			'varFontSize'        => 'font-size',
			'varColorBackground' => 'background-color',
			'varColorText'       => 'color',
			'textAlign'          => 'text-align',
		];

		foreach ( $attributes as $key => $value ) {
			if ( isset( $map[ $key ] ) ) {
				$new_key            = $map[ $key ];
				$output[ $new_key ] = $value;
				unset( $attributes[ $key ] );
			}
		}

		if ( ! empty( $output['font-size'] ) ) {
			$output['font-size'] = $output['font-size'] . 'px';
		}

		$attributes['styles']  = $output;

		return $attributes;
	}
}
