<?php
/**
 * Post Meta box.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Core\Backend;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Metabox class.
 */
class MetaBox
{
	use Hooker;
    use HelperFunctions;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( 'add_meta_boxes', 'meta_box', 10, 2 );
		$this->action( 'save_post', 'save_metadata' );
		$this->action( 'admin_print_footer_scripts-post-new.php', 'default_check', 99 );
	}

	/**
	 * Add Meta box.
	 *
	 * @param string $post_type Post Type
	 * @param object $post      WP Post
	 */
	public function meta_box( $post_type, $post ) {
		if ( ! $this->is_enabled( 'enable_last_modified_cb' ) && ! current_user_can( 'publish_posts' ) ) {
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
		    add_meta_box( 'wplmi_meta_box', __( 'Modified Info', 'wp-last-modified-info' ), [ $this, 'metabox' ], $post_types, 'side', 'default', [ '__back_compat_meta_box' => true ] );
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
	public function metabox( $post ) {
		// retrieve post meta
		$disabled = $this->get_meta( $post->ID, '_lmt_disable' );

		// buid nonce
		$this->nonce( 'disabled' ); ?>

		<div id="wplmi-status" class="meta-options">
			<label for="wplmi_status" class="selectit" title="<?php esc_attr_e( 'You can disable auto insertation of last modified info on this post', 'wp-last-modified-info' ); ?>">
				<input id="wplmi_status" type="checkbox" name="wplmi_disable_auto_insert" <?php if ( $disabled == 'yes' ) { echo 'checked'; } ?> /> <?php esc_html_e( 'Hide Modified Info on Frontend', 'wp-last-modified-info' ); ?>
		    </label>
		</div>
		<?php
	}

	/**
	 * Store custom field meta box data.
	 *
	 * @param int $post_id The post ID.
	 */
	public function save_metadata( $post_id ) {
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
		if ( isset( $_POST['wplmi_disable_auto_insert'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			$this->update_meta( $post_id, '_lmt_disable', 'yes' );
		} else {
			$this->update_meta( $post_id, '_lmt_disable', 'no' );
		}
	}

	/**
	 * Auto check metabox checkbox on new post create.
	 */
	public function default_check() {
		if ( $this->do_filter( 'default_checkbox_check', false ) ) {
			echo "<script type='text/javascript'>jQuery(document).ready(function ($) { $('#wplmi_status').prop( 'checked', true ); });</script>"."\n";
		}
	}

	/**
	 * Store custom field meta box data.
	 *
	 * @param int $post_id The post ID.
	 */
	private function nonce( $name, $referer = true, $show = true ) {
		\wp_nonce_field( 'wplmi_nonce_' . $name, 'wplmi_metabox_' . $name . '_nonce', $referer, $show );
	}

	/**
	 * Store custom field meta box data.
	 *
	 * @param int $post_id The post ID.
	 */
	private function verify( $name ) {
		if ( ! isset( $_REQUEST[ 'wplmi_metabox_' . $name . '_nonce' ] ) || ! \wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST[ 'wplmi_metabox_'.  $name . '_nonce' ] ) ), 'wplmi_nonce_' . $name ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
			return false;
		}

		return true;
	}
}
