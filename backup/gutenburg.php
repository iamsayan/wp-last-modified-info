<?php 
/**
 * Gutenburg Support
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

/**
 * Enqueue front end and editor JavaScript and CSS
 */
function wplmi_gutenberg_scripts() {
	$blockPath = 'admin/assets/js/sidebar.js';

	// Enqueue the bundled block JS file
	wp_enqueue_script(
		'wplmi-sidebar-js',
		plugins_url( $blockPath, __FILE__ ),
		[ 'wp-i18n', 'wp-blocks', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-plugins', 'wp-edit-post', 'wp-api', 'wp-date' ],
		filemtime( plugin_dir_path(__FILE__) . $blockPath )
	);

}

// Hook scripts function into block editor hook
add_action( 'enqueue_block_assets', 'wplmi_gutenberg_scripts' );

/**
 * Register Gutenberg Meta Field to Rest API
 */
function wplmi_gutenberg_register_meta() {
	register_meta(
		'post', '_lmt_disable', array(
			'type'			=> 'string',
			'single'		=> true,
			'show_in_rest'	=> true,
		)
	);
}
add_action( 'init', 'wplmi_gutenberg_register_meta' );

/**
 * Register Gutenberg Metabox to Rest API
 */
function wplmi_gutenberg_api_posts_meta_field() {
	register_rest_route(
		'wp-last-modified-info/v1', '/update-meta', array(
			'methods'  => 'POST',
			'callback' => 'wplmi_gutenberg_update_callback',
			'args'     => array(
				'id' => array(
					'sanitize_callback' => 'absint',
				),
			),
		)
	);
}
add_action( 'rest_api_init', 'wplmi_gutenberg_api_posts_meta_field' );

/**
 * REST API Callback for Gutenberg
 */
function wplmi_gutenberg_update_callback( $data ) {
    if ( $data['value'] == 'yes' ) {
        return update_post_meta( $data['id'], $data['key'], 'yes' );
    } else {
        return delete_post_meta( $data['id'], $data['key'] );
    }
}