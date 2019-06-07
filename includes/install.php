<?php

/**
 * The admin-facing functionality of the plugin.
 *
 * @package    WP Last Modified Info
 * @subpackage Admin
 * @author     Sayan Datta
 * @license    http://www.gnu.org/licenses/ GNU General Public License
 */

add_action( 'admin_notices', 'lmt_new_plugin_install_notice' );
add_action( 'admin_init', 'lmt_dismiss_fbak_notice' );

function lmt_new_plugin_install_notice() { 
    $options = get_option('lmt_plugin_global_options');

    // Show a warning to sites running PHP < 5.6
    if( version_compare( PHP_VERSION, '5.6', '<' ) ) {
	    echo '<div class="error"><p>' . __( 'Your version of PHP is below the minimum version of PHP required by WP Last Modified Info plugin. Please contact your host and request that your version be upgraded to 5.6 or later.', 'wp-last-modified-info' ) . '</p></div>';
    }

    // Check transient, if available display notice
    if( get_transient( 'lmt-admin-notice-on-activation' ) ) { ?>
        <div class="notice notice-success">
            <p><strong><?php printf( __( 'Thanks for installing %1$s v%2$s plugin. Click <a href="%3$s">here</a> to configure plugin settings.', 'wp-last-modified-info' ), 'WP Last Modified Info', LMT_PLUGIN_VERSION, admin_url( 'options-general.php?page=wp-last-modified-info' ) ); ?></strong></p>
        </div> <?php
        delete_transient( 'lmt-admin-notice-on-activation' );
    }

    // Show notice to new users
    if( '1' !== get_option( 'lmt_plugin_fbak_dismiss' ) ) {
        $dismiss = wp_nonce_url( add_query_arg( 'fbak_lmt_suggust', 'dismiss_true' ), 'lmt_fbak_suggust_ref' ); ?>
        <div class="notice notice-success">
            <p style="text-align: justify;"><strong><?php _e( 'Introducing the New Facebook Account Kit Login plugin which brings a lightweight, secure, flexible, free and easy way to configure Facebook\'s Secure and easy Passwordless Login to your WordPress website. You can login by using a OTP on your Phone Number or WhatsApp or Email Verification without any password. Try this plugin now!', 'wp-last-modified-info' ); ?></strong></p>
            <p><a href="<?php echo admin_url( 'plugin-install.php?s=Facebook+Account+Kit+Login+Sayan&tab=search&type=term' ); ?>" target="_blank" class="button button-secondary"><?php _e( 'Install this plugin', 'wp-last-modified-info' ); ?></a>&nbsp;
            <a href="<?php echo $dismiss; ?>" class="dismiss"><strong><?php _e( 'I have already tried it', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
            <a href="<?php echo $dismiss; ?>" class="dismiss"><strong><?php _e( 'No, I don\'t want to try it', 'wp-last-modified-info' ); ?></strong></a><span style="float: right;font-size: 10px;margin-top: 10px;"><?php _e( 'Powered by', 'wp-last-modified-info' ); ?> WP Last Modified Info</span></p>
        </div> <?php
    }
}

function lmt_dismiss_fbak_notice() {
    if ( ! isset( $_GET['fbak_lmt_suggust'] ) ) {
        return;
    }

    if ( 'dismiss_true' === $_GET['fbak_lmt_suggust'] ) {
        check_admin_referer( 'lmt_fbak_suggust_ref' );
        update_option( 'lmt_plugin_fbak_dismiss', '1' );
    }

    wp_redirect( remove_query_arg( 'fbak_lmt_suggust' ) );
    exit;
}