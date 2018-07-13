<?php
/**
 * Load plugins data
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

//add admin styles and scripts
function lmt_custom_admin_styles_scripts() {
    // get current screen
    $current_screen = get_current_screen();
    if ( strpos($current_screen->base, 'wp-last-modified-info') !== false ) {
        wp_enqueue_style( 'lmt-admin', LMT_DIR_URL . 'admin/assets/css/admin-style.min.css' );
        wp_enqueue_style( 'lmt-cb', LMT_DIR_URL . 'admin/assets/css/style.min.css' );
        wp_enqueue_script( 'lmt-admin-script', LMT_DIR_URL . 'admin/assets/js/admin.min.js' );

        wp_enqueue_style( 'lmt-select2', LMT_DIR_URL . 'admin/assets/lib/select2/css/select2.min.css' ); 
        wp_enqueue_script( 'lmt-select2-script', LMT_DIR_URL . 'admin/assets/lib/select2/js/select2.min.js' );
    }
}

function lmt_ajax_save_admin_scripts() {
    if ( is_admin() ) { 
        // Embed the Script on our Plugin's Option Page Only
        if ( isset($_GET['page']) && $_GET['page'] == 'wp-last-modified-info' ) {
            wp_enqueue_script('jquery');
            wp_enqueue_script( 'jquery-form' );
        }
    }
}

// add action links
function lmt_add_action_links ( $links ) {
    $lmtlinks = array(
        '<a href="' . admin_url( 'options-general.php?page=wp-last-modified-info' ) . '">Settings</a>',
    );
    return array_merge( $lmtlinks, $links );
}

function lmt_plugin_meta_links($links, $file) {
	$plugin = LMT_BASE_NAME;
	if ($file == $plugin) // only for this plugin
		return array_merge( $links, 
            array( '<a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank">' . __('Support') . '</a>' ),
            array( '<a href="http://bit.ly/2I0Gj60" target="_blank">' . __('Donate') . '</a>' )
		);
	return $links;
}

add_action( 'admin_enqueue_scripts', 'lmt_custom_admin_styles_scripts' );
add_action( 'admin_init', 'lmt_ajax_save_admin_scripts' );
add_filter( 'plugin_action_links_' . LMT_BASE_NAME, 'lmt_add_action_links', 10, 2 );
add_filter( 'plugin_row_meta', 'lmt_plugin_meta_links', 10, 2 );

/**
 * File that triggers main plugin data.
 */
require_once LMT_DIR_PATH . 'includes/trigger.php';
require_once LMT_DIR_PATH . 'includes/frontend/shortcode.php';

?>