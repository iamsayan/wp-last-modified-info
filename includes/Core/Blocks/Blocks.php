<?php
/**
 * Register Gutenberg Blocks
 *
 * @since      1.8.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Blocks
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Core\Blocks;

use Wplmi\Helpers\Hooker;
use Wplmi\Base\BaseController;

defined( 'ABSPATH' ) || exit;

/**
 * Blocks class.
 */
class Blocks extends BaseController
{
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
		$this->_register_script();
		$this->_register_post_modified_block();
	}

	/**
	 * Register JavaScript code with the blocks. And, load translations for it.
	 */
	private function _register_script() {
		/* load generated asset file to get JavaScript dependencies and various */
		$asset_file = include( $this->plugin_path . 'includes/Core/Blocks/build/index.asset.php' );

		/* register generated blocks JavaScript file using previously loaded assets */
		wp_register_script( 'wplmi-blocks', $this->plugin_url . 'includes/Core/Blocks/build/index.js', $asset_file['dependencies'], $asset_file['version'] );

		/* set the translations domain and link it to the blocks script */
		wp_set_script_translations( 'wplmi-blocks', 'wp-last-modified-info' );
	}

	/**
	 * Register block for 'post-modified-date'.
	 *
	 * The attributes listed here must be a match to the attributes listed in the JavaScript file for this block.
	 * Block definition (name, title, description, category, icon) can be listed here and in JavaScript file, but it
	 * can be listed in one place only, it doesn't need to be in both.
	 *
	 * Value for render_callback HAS to be listed here only, it can't be in the JavaScript block code.
	 * Values for editor_script and editor_style also have to be listed here only, not in JavaScript block code.
	 */
	private function _register_post_modified_block() {
		register_block_type( 'wp-last-modified-info/post-modified-date', array(
			'apiVersion'      => 2,
			'name'            => 'wp-last-modified-info/post-modified-date',
			'title'           => __( 'Post Modified Date', 'wp-last-modified-info' ),
			'description'     => __( 'Display simple notice.', 'wp-last-modified-info' ),
			'category'        => 'widgets',
			'icon'            => 'menu-alt',
			'render_callback' => array( $this, 'callback_meta' ),
			'attributes'      => array(
				'title'           => array(
					'type'    => 'string',
					'default' => 'This is just a notice.',
				),
				'class'           => array(
					'type'    => 'string',
					'default' => '',
				),
				'showSiteAdmin'   => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showProfileEdit' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showLogIn'       => array(
					'type'    => 'boolean',
					'default' => true,
				),
			),
			'textdomain'      => 'wp-last-modified-info',
			'editor_script'   => 'wplmi-blocks',
			//'editor_style'    => 'wp-last-modified-info'
		) );
	}

	/**
	 * Callback method for the 'post-modified-date' block as defined for this block. The method is called by the
	 * Block Editor Server Side Rendering component, and it has all the block attributes as parameter.
	 *
	 * @param array $attributes
	 *
	 * @return string
	 */
	public function callback_meta( array $attributes ) : string {
		error_log(print_r($attributes,1));
		return do_shortcode( '[lmt-template-tags]' );
	}
}