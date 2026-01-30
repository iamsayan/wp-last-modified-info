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
 * Meta box class.
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
	 * Add meta box.
	 *
	 * @param string  $post_type Post type.
	 * @param WP_Post $post      Post object.
	 */
	public function meta_box( $post_type, $post ) {
		// Early bail: feature disabled and user lacks capability.
		if ( ! $this->is_enabled( 'enable_last_modified_cb' ) && ! current_user_can( 'publish_posts' ) ) {
			return;
		}

		// Early bail: unsupported post statuses.
		if ( ! isset( $post->post_status ) || in_array( $post->post_status, [ 'auto-draft', 'future' ], true ) ) {
			return;
		}

		// Early bail: invalid position setting.
		$position = $this->get_data( 'lmt_show_last_modified_time_date_post', 'before_content' );
		if ( ! in_array( $position, [ 'before_content', 'after_content', 'replace_original' ], true ) ) {
			return;
		}

		$post_types = $this->get_data( 'lmt_custom_post_types_list' );
		// Ensure we have an array of strings.
		if ( ! is_array( $post_types ) ) {
			$post_types = array_filter( (array) $post_types );
		}

		if ( ! empty( $post_types ) ) {
			add_meta_box(
				'wplmi_meta_box',
				__( 'Modified Info', 'wp-last-modified-info' ),
				[ $this, 'metabox' ],
				$post_types,
				'side',
				'default',
				[ '__back_compat_meta_box' => true ]
			);
		}
	}

	/**
	 * Render the meta box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function metabox( $post ) {
		$disabled = $this->get_meta( $post->ID, '_lmt_disable' );

		// Output nonce.
		$this->nonce( 'disabled' );
		?>
		<div id="wplmi-status" class="meta-options">
			<label for="wplmi_status" class="selectit" title="<?php esc_attr_e( 'You can disable auto insertion of last modified info on this post', 'wp-last-modified-info' ); ?>">
				<input id="wplmi_status" type="checkbox" name="wplmi_disable_auto_insert" value="1" <?php checked( $disabled, 'yes' ); ?> />
				<?php esc_html_e( 'Hide Modified Info on Frontend', 'wp-last-modified-info' ); ?>
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
		// Autosave bail.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Capability check.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Nonce verification.
		if ( ! $this->verify( 'disabled' ) ) {
			return;
		}

		// Sanitize & save.
		$hide = isset( $_POST['wplmi_disable_auto_insert'] ) ? 'yes' : 'no'; // PHPCS:ignore WordPress.Security.NonceVerification.Missing
		$this->update_meta( $post_id, '_lmt_disable', $hide );
	}

	/**
	 * Auto-check the meta box checkbox on new post creation.
	 */
	public function default_check() {
		if ( $this->do_filter( 'default_checkbox_check', false ) ) {
			printf(
				"<script type='text/javascript'>
					jQuery( function( $ ) {
						$( '#wplmi_status' ).prop( 'checked', true );
					} );
				</script>%s",
				PHP_EOL
			);
		}
	}

	/**
	 * Output a nonce field.
	 *
	 * @param string $name    Nonce name.
	 * @param bool   $referer Whether to include referer.
	 * @param bool   $show    Whether to display or return.
	 */
	private function nonce( $name, $referer = true, $show = true ) {
		wp_nonce_field( 'wplmi_nonce_' . $name, 'wplmi_metabox_' . $name . '_nonce', $referer, $show );
	}

	/**
	 * Verify a nonce.
	 *
	 * @param string $name Nonce name.
	 * @return bool
	 */
	private function verify( $name ) {
		$field = 'wplmi_metabox_' . $name . '_nonce';
		if ( ! isset( $_REQUEST[ $field ] ) ) {
			return false;
		}

		return (bool) wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST[ $field ] ) ), 'wplmi_nonce_' . $name );
	}
}
