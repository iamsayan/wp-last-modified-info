<?php

/**
 * The admin-facing functionality of the plugin.
 *
 * @package    WP Last Modified Info
 * @subpackage Admin
 * @author     Sayan Datta
 * @license    http://www.gnu.org/licenses/ GNU General Public License
 */

add_action( 'admin_notices', 'lmt_donate_admin_notice' );
add_action( 'admin_init', 'lmt_dismiss_donate_admin_notice' );

function lmt_donate_admin_notice() {
    // Show notice after 240 hours (10 days) from installed time.
    if ( lmt_plugin_installed_time_donate() > strtotime( '-360 hours' )
        || '1' === get_option( 'lmt_plugin_dismiss_donate_notice' )
        || ! current_user_can( 'manage_options' )
        || apply_filters( 'lmt_plugin_hide_sticky_donate_notice', false ) ) {
        return;
    }

    $dismiss = wp_nonce_url( add_query_arg( 'lmt_donate_notice_action', 'dismiss_donate_true' ), 'lmt_dismiss_donate_true' ); 
    $no_thanks = wp_nonce_url( add_query_arg( 'lmt_donate_notice_action', 'no_thanks_donate_true' ), 'lmt_no_thanks_donate_true' ); ?>
    
    <div class="notice notice-success">
        <p><?php _e( 'Hey, I noticed you\'ve been using WP Last Modified Info for more than 2 week – that’s awesome! If you like WP Last Modified Info and you are satisfied with the plugin, isn’t that worth a coffee or two? Please consider donating. Donations help me to continue support and development of this free plugin! Thank you very much!', 'wp-last-modified-info' ); ?></p>
        <p><a href="https://www.paypal.me/iamsayan" target="_blank" class="button button-secondary"><?php _e( 'Donate Now', 'wp-last-modified-info' ); ?></a>&nbsp;
        <a href="<?php echo $dismiss; ?>" class="already-did"><strong><?php _e( 'I already donated', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
        <a href="<?php echo $no_thanks; ?>" class="later"><strong><?php _e( 'Nope&#44; maybe later', 'wp-last-modified-info' ); ?></strong></a>&nbsp;<strong>|</strong>
        <a href="<?php echo $dismiss; ?>" class="hide"><strong><?php _e( 'I don\'t want to donate', 'wp-last-modified-info' ); ?></strong></a></p>
    </div>
<?php
}

function lmt_dismiss_donate_admin_notice() {
    if( get_option( 'lmt_plugin_no_thanks_donate_notice' ) === '1' ) {
        if ( get_option( 'lmt_plugin_dismissed_time_donate' ) > strtotime( '-360 hours' ) ) {
            return;
        }
        delete_option( 'lmt_plugin_dismiss_donate_notice' );
        delete_option( 'lmt_plugin_no_thanks_donate_notice' );
    }

    if ( ! isset( $_GET['lmt_donate_notice_action'] ) ) {
        return;
    }

    if ( 'dismiss_donate_true' === $_GET['lmt_donate_notice_action'] ) {
        check_admin_referer( 'lmt_dismiss_donate_true' );
        update_option( 'lmt_plugin_dismiss_donate_notice', '1' );
    }

    if ( 'no_thanks_donate_true' === $_GET['lmt_donate_notice_action'] ) {
        check_admin_referer( 'lmt_no_thanks_donate_true' );
        update_option( 'lmt_plugin_no_thanks_donate_notice', '1' );
        update_option( 'lmt_plugin_dismiss_donate_notice', '1' );
        update_option( 'lmt_plugin_dismissed_time_donate', time() );
    }

    wp_redirect( remove_query_arg( 'lmt_donate_notice_action' ) );
    exit;
}

function lmt_plugin_installed_time_donate() {
    $installed_time = get_option( 'lmt_plugin_installed_time_donate' );
    if ( ! $installed_time ) {
        $installed_time = time();
        update_option( 'lmt_plugin_installed_time_donate', $installed_time );
    }
    return $installed_time;
}