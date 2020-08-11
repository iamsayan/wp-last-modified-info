<?php
/**
 * Post Meta box.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Core\Backend;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\SettingsData;

defined( 'ABSPATH' ) || exit;

/**
 * Metabox class.
 */
class MetaBox
{
	use Hooker, SettingsData;

	/**
	 * Register functions.
	 */
	public function register()
	{
		$this->action( 'add_meta_boxes', 'meta_box', 10, 2 );
		$this->action( 'save_post', 'save_metadata' );
		$this->action( 'admin_print_footer_scripts-post-new.php', 'default_check' );
	}
	
	/**
	 * Add Meta box.
	 * 
	 * @param string $post_type Post Type
	 * @param object $post      WP Post
	 */
	public function meta_box( $post_type, $post )
	{
		// If user can't publish posts, then get out
		if ( ! current_user_can( 'publish_posts' ) ) {
		    return;
		}

		if ( in_array( $post->post_status, [ 'auto-draft', 'future' ] ) ) {
			return;
		}

		$position = $this->get_data( 'lmt_show_last_modified_time_date_post', 'before_content' );
		if ( ! in_array( $position, [ 'before_content', 'after_content', 'replace_original' ] ) ) {
			return;
		}
		
		$post_types = $this->get_data( 'lmt_custom_post_types_list' );
		if ( ! empty( $post_types ) ) {
		    add_meta_box( 'wplmi_meta_box', __( 'Modified Info', 'wp-last-modified-info' ), [ $this, 'metabox' ], $post_types, 'side', 'default' );
		}
	}

	/**
	 * Generate column data.
	 * 
	 * @param string   $column   Column name
	 * @param int      $post_id  Post ID
	 * 
	 * @return string  $time
	 */
	public function metabox( $post )
	{
		// get post types objects
		$post_types = get_post_type_object( get_post_type( $post ) );
		// retrieve post meta
		$disabled = $this->get_meta( $post->ID, '_lmt_disable' );

		// buid nonce
		$this->nonce( 'disabled' ); ?>
			
		<div id="wplmi-status" class="meta-options">
			<label for="wplmi_status" class="selectit" title="<?php _e( 'You can disable auto insertation of last modified info on this', 'wp-last-modified-info' ); ?> <?php echo $post_types->name; ?>">
				<input id="wplmi_status" type="checkbox" name="wplmi_disable_auto_insert" <?php if ( $disabled == 'yes' ) { echo 'checked'; } ?> /> <?php _e( 'Disable auto insert on this post', 'wp-last-modified-info' ); ?>
		    </label>
		</div>
		<?php 
	}

	/**
	 * Store custom field meta box data.
	 *
	 * @param int $post_id The post ID.
	 */
	public function save_metadata( $post_id )
	{
		// return if autosave
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	    	return;
		}
		
	    // Check the user's permissions.
	    if ( ! current_user_can( 'edit_post', $post_id ) ) {
	    	return;
	    }

		if ( ! $this->verify( 'disabled' ) ) {
			return;
		}

		// disableautoinsert string
		if ( isset( $_POST[ 'wplmi_disable_auto_insert' ] ) ) {
			$this->update_meta( $post_id, '_lmt_disable', 'yes' );
		} else {
			$this->update_meta( $post_id, '_lmt_disable', 'no' );
		}
	}

	/**
	 * Auto check metabox checkbox on new post create.
	 */
	public function default_check()
	{
		if ( $this->do_filter( 'default_checkbox_check', false ) ) {
			echo "<script type='text/javascript'>jQuery(document).ready(function ($) { $('#wplmi_status').prop( 'checked', true ); });</script>"."\n";
		}
	}

	/**
	 * Store custom field meta box data.
	 *
	 * @param int $post_id The post ID.
	 */
	private function nonce( $name, $referer = true, $echo = true )
	{
		\wp_nonce_field( 'wplmi_nonce_'.$name, 'wplmi_metabox_'.$name.'_nonce', $referer, $echo );
	}

	/**
	 * Store custom field meta box data.
	 *
	 * @param int $post_id The post ID.
	 */
	private function verify( $name )
	{
		if ( ! isset( $_REQUEST['wplmi_metabox_'.$name.'_nonce'] ) || ! \wp_verify_nonce( $_REQUEST['wplmi_metabox_'.$name.'_nonce'], 'wplmi_nonce_'.$name ) ) {
			return false;
		}

		return true;
	}
}