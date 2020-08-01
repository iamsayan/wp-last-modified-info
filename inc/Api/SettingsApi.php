<?php 
/**
 * Settings API Class.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Api
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Api;

use Wplmi\Helpers\Hooker;

defined( 'ABSPATH' ) || exit;

class SettingsApi
{
	use Hooker;

	/**
	 * Admin pages.
	 *
	 * @var array
	 */
	public $admin_pages = [];

	/**
	 * Admin subpages.
	 *
	 * @var array
	 */
	public $admin_subpages = [];

	/**
	 * Plugin settings.
	 *
	 * @var array
	 */
	public $settings = [];

	/**
	 * Plugin sections.
	 *
	 * @var array
	 */
	public $sections = [];

	/**
	 * Plugin fields.
	 *
	 * @var array
	 */
	public $fields = [];

    /**
	 * Register functions.
	 */
	public function register()
	{
		if ( ! empty( $this->admin_pages ) || ! empty( $this->admin_subpages ) ) {
			$this->action( 'admin_menu', 'addAdminMenu' );
		}

		if ( ! empty( $this->settings ) ) {
			$this->action( 'admin_init', 'registerCustomFields' );
		}
	}

	/**
	 * Register menu pages.
	 */
	public function addPages( array $pages )
	{
		$this->admin_pages = $pages;

		return $this;
	}

	/**
	 * Register sub menu pages.
	 */
	public function withSubPage( $title = null ) 
	{
		if ( empty( $this->admin_pages ) ) {
			return $this;
		}

		$admin_page = $this->admin_pages[0];

		$subpage = [
			[
				'parent_slug' => $admin_page['menu_slug'], 
				'page_title' => $admin_page['page_title'], 
				'menu_title' => ( $title ) ? $title : $admin_page['menu_title'], 
				'capability' => $admin_page['capability'], 
				'menu_slug' => $admin_page['menu_slug'], 
				'callback' => $admin_page['callback']
			]
		];

		$this->admin_subpages = $subpage;

		return $this;
	}

	/**
	 * Locate sub menu pages.
	 */
	public function addSubPages( array $pages )
	{
		$this->admin_subpages = array_merge( $this->admin_subpages, $pages );

		return $this;
	}

	/**
	 * Register admin menus & submenus.
	 */
	public function addAdminMenu()
	{
		foreach ( $this->admin_pages as $page ) {
			add_menu_page( $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position'] );
		}

		foreach ( $this->admin_subpages as $page ) {
			add_submenu_page( $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'] );
		}
	}

	/**
	 * Register settings.
	 */
	public function setSettings( array $settings )
	{
		$this->settings = $settings;

		return $this;
	}

	/**
	 * Register sections.
	 */
	public function setSections( array $sections )
	{
		$this->sections = $sections;

		return $this;
	}

	/**
	 * Register fields.
	 */
	public function setFields( array $fields )
	{
		$this->fields = $fields;

		return $this;
	}

	/**
	 * Register plugin fields.
	 */
	public function registerCustomFields()
	{
		// register setting
		foreach ( $this->settings as $setting ) {
			register_setting( $setting["option_group"], $setting["option_name"], ( isset( $setting["callback"] ) ? $setting["callback"] : [] ) );
		}

		// add settings section
		foreach ( $this->sections as $section ) {
			add_settings_section( $section["id"], $section["title"], ( isset( $section["callback"] ) ? $section["callback"] : '' ), $section["page"] );
		}

		// add settings field
		foreach ( $this->fields as $field ) {
			add_settings_field( $field["id"], $field["title"], ( isset( $field["callback"] ) ? $field["callback"] : '' ), $field["page"], $field["section"], ( isset( $field["args"] ) ? $field["args"] : '' ) );
		}
	}
}