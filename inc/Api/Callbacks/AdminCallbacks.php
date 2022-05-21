<?php 
/**
 * Admin callbacks.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Api\Callbacks
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Api\Callbacks;

use Wplmi\Base\BaseController;

defined( 'ABSPATH' ) || exit;

/**
 * Admin callbacks class.
 */
class AdminCallbacks extends BaseController
{
	/**
	 * Call dashboard template.
	 */
	public function adminDashboard() {
		return require_once( "$this->plugin_path/templates/admin.php" );
	}

	public function sectionHeader( $title, $description ) { ?>
		<div class="wplmi-metabox-holder">
			<div class="wplmi-metabox-td">
				<h3 class="wplmi-metabox-title"><?php echo esc_html( $title ); ?></h3>
				<p class="wplmi-metabox-description"><?php echo wp_kses_post( $description ); ?></p>
			</div>
		</div>
		<?php
	}

	public function doSettingsSection( $attr ) { ?>
		<div id="<?php echo esc_attr( $attr['id'] ); ?>" class="postbox <?php echo esc_attr( $attr['class'] ); ?>">
			<?php $this->sectionHeader( $attr['title'], $attr['description'] ); ?>
			<div class="inside">
				<?php do_settings_sections( $attr['name'] ); ?>
			</div>
			<p class="wplmi-control-area">
				<?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary wplmi-save', '', false ); ?>
			</p>
		</div>
		<?php
	}
}