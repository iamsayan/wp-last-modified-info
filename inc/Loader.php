<?php
/**
 * Register all classes
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi;

/**
 * WPLMI Main Class.
 */
final class Loader
{
	/**
	 * Store all the classes inside an array
	 *
	 * @return array Full list of classes
	 */
	public static function get_services(): array {
		return [
			Base\Enqueue::class,
			Base\MiscActions::class,
			Base\Localization::class,
			Base\AdminNotice::class,
			Base\PluginTools::class,
			Core\Blocks::class,
			Core\RestApi::class,
			Core\Notification::class,
			Core\AdminBar::class,
			Core\Frontend\PostView::class,
			Core\Frontend\Schema::class,
			Core\Frontend\Shortcode::class,
			Core\Backend\AdminColumn::class,
			Core\Backend\UserColumn::class,
			Core\Backend\MiscActions::class,
			Core\Backend\DashboardWidget::class,
			Core\Backend\BlockEditor::class,
			Core\Backend\EditScreen::class,
			Core\Backend\MetaBox::class,
			Core\Backend\PostStatusFilters::class,
			Core\Backend\PluginsData::class,
			Core\Backend\WooCommerce::class,
			Core\Elementor\Loader::class,
			Pages\Dashboard::class,
		];
	}

	/**
	 * Loop through the classes, initialize them,
	 * and call the register() method if it exists
	 */
	public static function register_services() {
		foreach ( self::get_services() as $class ) {
			$service = self::instantiate( $class );

			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}

	/**
	 * Initialize the class
	 *
	 * @param string $wplmi_class  class from the services array
	 * @return class instance      new instance of the class
	 */
	private static function instantiate( string $wplmi_class ) {
		return new $wplmi_class();
	}
}
