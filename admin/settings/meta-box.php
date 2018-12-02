<?php

/**
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @since     v1.2.7
 * @license   http://www.gnu.org/licenses/gpl.html
 *
 * Add meta box
 *
 * @param post $post The post object
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 */

// get plugin settings
$options = get_option('lmt_plugin_global_settings');

function lmt_add_meta_boxes( $post ) {

    // If user can't publish posts, then get out
    if ( ! current_user_can( 'publish_posts' ) ) return;
    
    add_meta_box( 'lmt_meta_box', __( 'WP Last Modified Info', 'wp-last-modified-info' ), 'lmt_meta_box_callback', '', 'side', 'default' );
}

if( isset($options['lmt_enable_last_modified_cb']) && ($options['lmt_enable_last_modified_cb'] == 1) ) {
    
    add_action( 'add_meta_boxes_post', 'lmt_add_meta_boxes' );

    if( isset($options['lmt_custom_post_types_list']) ) {
        $post_types = $options['lmt_custom_post_types_list'];
        foreach($post_types as $item) {
            add_action( "add_meta_boxes_{$item}", "lmt_add_meta_boxes" );
        }
    }
}

if( isset($options['lmt_enable_last_modified_page_cb']) && ($options['lmt_enable_last_modified_page_cb'] == 1) ) {
    add_action( 'add_meta_boxes_page', 'lmt_add_meta_boxes' );
}

/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function lmt_meta_box_callback( $post ) {
    // get plugin options
    $options = get_option('lmt_plugin_global_settings');
    // get post types objects
    $post_types = get_post_type_object( get_post_type( $post ) );
    // retrieve post id
    $checkboxMeta = get_post_meta( $post->ID ); 
    //get current time
    $current_time = get_the_time('U');
    // get modified time
    $modified_time = get_the_modified_time('U');
    // get current user
    $user = wp_get_current_user();
    // get current screen
    $pt = get_current_screen()->post_type;
    // make sure the form request comes from WordPress
    wp_nonce_field( 'lmt_meta_box_build_nonce', 'lmt_meta_box_nonce' );
    
    if ( $pt != 'page' ) {
        if( $options['lmt_show_last_modified_time_date_post'] != 'manual' ) { ?>
            <p id="lmt-status" class="meta-options">
                <label for="lmt_status" class="selectit" title="You can disable auto insertation of last modified info on this <?php echo $post_types->capability_type ?>">
		            <input id="lmt_status" type="checkbox" name="disableautoinsert" value="yes" <?php if ( isset ( $checkboxMeta['_lmt_disable'] ) ) checked( $checkboxMeta['_lmt_disable'][0], 'yes' ); ?> /> <?php _e( 'Disable auto insert on this post', 'wp-last-modified-info' ); ?>
	            </label>
            </p> <?php 
        } else { ?>
            <p id="major-publishing-actions" style="font-size:12px;line-height:1.9;border-top:none !important;">
                <span id="show-shortcode-post" class="tooltipsc" onclick="doCopyPost(); return false;" onmouseout="dooutFuncPost(); return false;">
                    <strong><?php _e( 'Shortcode:', 'wp-last-modified-info' ); ?></strong><input type="text" id="postSC" autocomplete="off" value="[lmt-post-modified-info]" style="font-size:12px; box-shadow:none !important; border:none; cursor:pointer; background:transparent; padding-left:0; outline:none;">
                    <span class="tooltiptext" id="scTooltipPost"><?php _e( 'Copy to clipboard', 'wp-last-modified-info' ); ?></span>
                </span>
            </p><?php
        }
    }

    if ( $pt == 'page' ) { 
        if( $options['lmt_show_last_modified_time_date_page'] != 'manual' ) { ?>
            <p id="lmt-status" class="meta-options">
                <label for="lmt_status" class="selectit" title="You can disable auto insertation of last modified info on this <?php echo $post_types->capability_type ?>">
		            <input id="lmt_status" type="checkbox" name="disableautoinsert" value="yes" <?php if ( isset ( $checkboxMeta['_lmt_disable'] ) ) checked( $checkboxMeta['_lmt_disable'][0], 'yes' ); ?> /> <?php _e( 'Disable auto insert on this page', 'wp-last-modified-info' ); ?>
	            </label>
            </p> <?php 
        } else { ?>
            <p id="major-publishing-actions" style="font-size:12px;line-height:1.9;border-top:none !important;">
                <span id="show-shortcode-page" class="tooltipsc" onclick="doCopyPage(); return false;" onmouseout="dooutFuncPage(); return false;">
                    <strong><?php _e( 'Shortcode:', 'wp-last-modified-info' ); ?></strong><input type="text" id="pageSC" autocomplete="off" value="[lmt-page-modified-info]" style="font-size:12px; box-shadow:none !important; border:none; cursor:pointer; background:transparent; padding-left:0; outline:none;">
                    <span class="tooltiptext" id="scTooltipPage"><?php _e( 'Copy to clipboard', 'wp-last-modified-info' ); ?></span>
                </span>
            </p><?php
        }
    } 
}

/**
 * Store custom field meta box data
 *
 * @param int $post_id The post ID.
 */
function lmt_save_meta_boxes_data( $post_id ) {
    
    // verify taxonomies meta box nonce
	if ( ! isset( $_POST['lmt_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['lmt_meta_box_nonce'], 'lmt_meta_box_build_nonce' ) ) {
		return;
	}
	// return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	// store custom fields values
	// disableautoinsert string
    if( isset( $_POST[ 'disableautoinsert' ] ) ) {
        update_post_meta( $post_id, '_lmt_disable', 'yes' );
    } else {
        delete_post_meta( $post_id, '_lmt_disable' );
    }
    
}

add_action( 'save_post', 'lmt_save_meta_boxes_data', 10, 2 );

?>