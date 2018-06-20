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

function lmt_add_meta_boxes( $post ) {

    $post_types = get_post_types(array(
        'public'   => true,
        '_builtin' => false 
    ), 'names'); 

    foreach ( $post_types as $screen ) {
	    add_meta_box( 'lmt_meta_box', __( 'WP Last Modified Info', 'wp-last-modified-info' ), 'lmt_meta_box_callback', $screen, 'side', 'default' );
    }
}

function lmt_add_post_meta_boxes( $post ) {
    add_meta_box( 'lmt_meta_box', __( 'WP Last Modified Info', 'wp-last-modified-info' ), 'lmt_meta_box_callback', 'post', 'side', 'default' );
}

function lmt_add_page_meta_boxes( $post ) {
    add_meta_box( 'lmt_meta_box', __( 'WP Last Modified Info', 'wp-last-modified-info' ), 'lmt_meta_box_callback', 'page', 'side', 'default' );
}

if( isset($options['lmt_enable_last_modified_cb']) && ($options['lmt_enable_last_modified_cb'] == 1) ) {
    
    add_action( 'add_meta_boxes_post', 'lmt_add_post_meta_boxes' );

    if( isset($options['lmt_enable_custom_post_types']) ) {
        $post_types = $options['lmt_enable_custom_post_types'];
        foreach($post_types as $item) {
            add_action( "add_meta_boxes_{$item}", "lmt_add_meta_boxes" );
        }
    }
}

if( isset($options['lmt_enable_last_modified_page_cb']) && ($options['lmt_enable_last_modified_page_cb'] == 1) ) {
    add_action( 'add_meta_boxes_page', 'lmt_add_page_meta_boxes' );
}

/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function lmt_meta_box_callback( $post ) {
    // get post types objects
    $post_type = get_post_type_object( get_post_type( $post ) );
    // make sure the form request comes from WordPress
    wp_nonce_field( 'lmt_meta_box_build_nonce', 'lmt_meta_box_nonce' );
    // retrieve post id
    $checkboxMeta = get_post_meta( $post->ID );
?>
    <p class="meta-options">
        <label for="lmt_status" class="selectit">
		    <input id="lmt_status" type="checkbox" name="disableautoinsert" value="yes" <?php if ( isset ( $checkboxMeta['_lmt_disable'] ) ) checked( $checkboxMeta['_lmt_disable'][0], 'yes' ); ?> /> Disable auto insert on this <?php echo $post_type->capability_type ?>
	    </label>
    </p>
    <p id="major-publishing-actions" style="font-size:12px;line-height:1.9;border-top:none !important;">
        <span id="show-shortcode-post" class="tooltipsc" onclick="doCopyPost(); return false;" onmouseout="dooutFuncPost(); return false;">
            <strong>Shortcode:</strong><input type="text" style="font-size:12px;box-shadow:none !important;border:none;cursor:pointer;background:transparent;padding-left:0;" value="[lmt-post-modified-info]" id="postSC">
            <span class="tooltiptext" id="scTooltipPost">Copy to clipboard</span>
        </span>
        <span id="show-shortcode-page" class="tooltipsc" onclick="doCopyPage(); return false;" onmouseout="dooutFuncPage(); return false;">
            <strong>Shortcode:</strong><input type="text" style="font-size:12px;box-shadow:none !important;border:none;cursor:pointer;background:transparent;padding-left:0;" value="[lmt-page-modified-info]" id="pageSC">
            <span class="tooltiptext" id="scTooltipPage">Copy to clipboard</span>
        </span>
    </p>
<?php

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

function lmt_hide_sc_using_css() { 
    
    // get current screen
    $pt = get_current_screen()->post_type;
    // check if page edit screen
    if ( $pt == 'page' ) { ?>
        <style type="text/css">
            #show-shortcode-post {
                display: none !important;
            }
        </style>
        <?php
    // check if not page edit screen
    } elseif ( $pt != 'page' ) { ?>
        <style type="text/css">
            #show-shortcode-page {
                display: none !important;
            }
        </style>
        <?php
    }
}
add_action('admin_print_styles-post.php', 'lmt_hide_sc_using_css', 10);
add_action('admin_print_styles-post-new.php', 'lmt_hide_sc_using_css', 10);

function lmt_load_sc_admin_scripts( $hook ) {

    global $post;
    // check if post edit screen
    if ( $hook == 'post-new.php' || $hook == 'post.php' ) { 
        wp_enqueue_style( 'shortcode', plugins_url( 'css/shortcode.min.css', __FILE__ ) );    
        wp_enqueue_script( 'shortcode-script', plugins_url( 'js/shortcode.min.js', __FILE__ ) );
    }
}
add_action( 'admin_enqueue_scripts', 'lmt_load_sc_admin_scripts', 10, 1 );

?>