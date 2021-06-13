<?php
/**
 * Register all classes
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi;

/**
 * WPLMI Main Class.
 */
final class WPLMILoader
{
	/**
	 * Store all the classes inside an array
	 * 
	 * @return array Full list of classes
	 */
	public static function get_services() 
	{
		$services = [
			Pages\Dashboard::class,
			Base\Enqueue::class,
			Base\MiscActions::class,
			Base\Localization::class,
			Base\AdminNotice::class,
			Base\RatingNotice::class,
			Base\DonateNotice::class,
			Base\PluginTools::class,
			Core\RestApi::class,
			Core\Notification::class,
			Core\AdminBar::class,
			Core\ThemeCompat::class,
			Core\Frontend\PostView::class,
			Core\Frontend\TemplateTags::class,
			Core\Frontend\Schema::class,
			Core\Frontend\Shortcode::class,
			Core\Backend\AdminColumn::class,
			Core\Backend\UserColumn::class,
			Core\Backend\MiscActions::class,
			Core\Backend\DashboardWidget::class,
			Core\Backend\EditScreen::class,
			Core\Backend\MetaBox::class,
			Core\Backend\PostStatusFilters::class,
			Core\Backend\PluginsData::class,
			Core\Elementor\Loader::class
		];

		return $services;
	}

	/**
	 * Loop through the classes, initialize them, 
	 * and call the register() method if it exists
	 */
	public static function register_services() 
	{
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
	 * @param  class $class    class from the services array
	 * @return class instance  new instance of the class
	 */
	private static function instantiate( $class )
	{
		$service = new $class();

		return $service;
	}
}