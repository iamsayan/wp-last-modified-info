<?php
/**
 * Load plugins settings
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

// caling required files
require plugin_dir_path( __FILE__ ) . 'settings/tools.php';
require plugin_dir_path( __FILE__ ) . 'settings/settings-loader.php';
require plugin_dir_path( __FILE__ ) . 'settings/settings-fields.php';
require plugin_dir_path( __FILE__ ) . 'settings/meta-box.php';

// add settings page
add_action('admin_init', 'lmt_plug_settings_page');

function lmt_remove_footer_admin_text() {
    echo 'Thanks for using <strong>WP Last Modified Info v'. lmt_remove_footer_admin() .'</strong> | Developed with <span style="color:#e25555;">♥</span> by <a href="https://profiles.wordpress.org/infosatech/" target="_blank" style="font-weight: 500;">Sayan Datta</a> | <a href="https://github.com/iamsayan/wp-last-modified-info" target="_blank" style="font-weight: 500;">GitHub</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank" style="font-weight: 500;">Support</a> | <a href="http://bit.ly/2I0Gj60" target="_blank" style="font-weight: 500;">Donate</a> | <a href="https://twitter.com/home?status=I%20am%20using%20WP%20Last%20Modified%20Info%20Plugin%20by%20%40im_sayaan%20to%20show%20last%20modified%20info%20on%20posts%20and%20pages%20in%20my%20%40WordPress%20Website%20-%20It%20is%20awesome%21%20%3E%20https%3A%2F%2Fwordpress.org%2Fplugins%2Fwp-last-modified-info%2F" target="_blank" style="font-weight: 500;">Tweet</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?rate=5#new-post" target="_blank" style="font-weight: 500;">Rate it</a> (<span style="color:#ffa000;">&#9733;&#9733;&#9733;&#9733;&#9733;</span>), if you like this plugin.';
}

// page elements
function lmt_show_page() {
    require plugin_dir_path( __FILE__ ) . 'settings/settings-page.php';
    add_filter('admin_footer_text', 'lmt_remove_footer_admin_text');    
}

// add menu options
function lmt_menu_item_options() {
    add_submenu_page('options-general.php', __( 'WP Last Modified Info', 'wp-lmi' ), __( 'Last Modified Info', 'wp-lmi' ), 'manage_options', 'wp-last-modified-info', 'lmt_show_page'); 
}

if( !is_network_admin() ) {
    add_action('admin_menu', 'lmt_menu_item_options');
}

?>