<?php
/**
 * Load plugins settings
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

// require required files
require_once plugin_dir_path( __FILE__ ) . 'settings/tools.php';
require_once plugin_dir_path( __FILE__ ) . 'settings/settings-loader.php';
require_once plugin_dir_path( __FILE__ ) . 'settings/settings-fields.php';
require_once plugin_dir_path( __FILE__ ) . 'settings/meta-box.php';

require_once plugin_dir_path( __FILE__ ) . 'elementor/module.php';

// add settings page
add_action( 'admin_init', 'lmt_plug_settings_page' );

// page elements
function lmt_show_page() {
    require_once plugin_dir_path( __FILE__ ) . 'settings/settings-page.php';
}

// add menu options
function lmt_menu_item_options() {
    add_submenu_page( 'options-general.php', __( 'WP Last Modified Info', 'wp-last-modified-info' ), __( 'WP Last Modified Info', 'wp-last-modified-info' ), 'manage_options', 'wp-last-modified-info', 'lmt_show_page' ); 
}

if( !is_network_admin() ) {
    add_action( 'admin_menu', 'lmt_menu_item_options' );
}

?>