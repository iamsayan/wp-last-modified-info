<?php 
/**
 * Dashboard actions.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Pages
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Pages;

use Wplmi\Helpers\Hooker;
use Wplmi\Api\SettingsApi;
use Wplmi\Helpers\HelperFunctions;
use Wplmi\Api\Callbacks\AdminCallbacks;
use Wplmi\Api\Callbacks\ManagerCallbacks;

defined( 'ABSPATH' ) || exit;

/**
 * Dashboard class.
 */
class Dashboard
{
	use HelperFunctions, Hooker;

	/**
	 * Settings.
	 *
	 * @var array
	 */
	public $settings;

	/**
	 * Callbacks.
	 *
	 * @var array
	 */
	public $callbacks;

	/**
	 * Callback Managers.
	 *
	 * @var array
	 */
	public $callbacks_manager;

	/**
	 * Settings pages.
	 *
	 * @var array
	 */
	public $pages = [];

	/**
	 * Register functions.
	 */
	public function register() 
	{
		$this->settings = new SettingsApi();
		$this->callbacks = new AdminCallbacks();
		$this->callbacks_manager = new ManagerCallbacks();

		$this->setSubPages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addSubPages( $this->subpages )->register();
	}

	/**
	 * Register plugin pages.
	 */
	public function setSubPages() 
	{
		$this->subpages = [
			[
				'parent_slug' => 'options-general.php', 
				'page_title' => __( 'WP Last Modified Info', 'wp-last-modified-info' ), 
				'menu_title' => __( 'WP Last Modified Info', 'wp-last-modified-info' ), 
				'capability' => 'manage_options', 
				'menu_slug' => 'wp-last-modified-info', 
				'callback' => [ $this->callbacks, 'adminDashboard' ]
			]
		];
	}

	/**
	 * Register plugin settings.
	 */
	public function setSettings()
	{
		$args = [
			[
				'option_group' => 'wplmi_plugin_settings_fields',
				'option_name' => 'lmt_plugin_global_settings',
				'callback' => [ 
					'sanitize_callback' => [ $this, 'sanitizeOutput' ]
				]
			]
		];

		$this->settings->setSettings( $args );
	}

	/**
	 * Register plugin sections.
	 */
	public function setSections()
	{
		$sections = [ 
			'post' => __( 'Post Options', 'wp-last-modified-info' ),
			'template_tag' => __( 'Post Options', 'wp-last-modified-info' ),
			'schema' => __( 'Schema Options', 'wp-last-modified-info' ),
			'notification' => __( 'Email Notification', 'wp-last-modified-info' ),
			'misc' => __( 'Miscellaneous Options', 'wp-last-modified-info' )
		];
		$args = [];
		foreach ( $sections as $section => $title ) {
		    $args[] = [
		    	'id' => 'wplmi_plugin_'.$section.'_section',
		    	'title' => $title,
		    	'callback' => null,
		    	'page' => 'wplmi_plugin_'.$section.'_option'
			];
		}

		$this->settings->setSections( $args );
	}

	/**
	 * Register settings fields.
	 */
	public function setFields()
	{
		$args = [];
		foreach ( $this->build_settings_fields() as $key => $value ) {
			foreach ( $value as $type => $settings ) {
			    $args[] = [
			    	'id' => $type,
			    	'title' => $settings,
			    	'callback' => [ $this->callbacks_manager, $type ],
			    	'page' => 'wplmi_plugin_' . $key . '_option',
			    	'section' => 'wplmi_plugin_' . $key . '_section',
			    	'args' => [
			    		'label_for' => 'wplmi_' . $type,
			    		'class' => 'wplmi_row_' . $type
			    	]
				];
			}
		}

		$this->settings->setFields( $args );
	}

	/**
	 * Build settings fields.
	 */
	private function build_settings_fields()
	{
		$theme = wp_get_theme();
		$managers = [
            'post' => [
				'enable_plugin' => __( 'Enable for Posts/Pages on Frontend:', 'wp-last-modified-info' ),
				'display_method' => __( 'Last Modified Info Display Method:', 'wp-last-modified-info' ),
				'date_type' => __( 'Last Modified Info Format for Posts:', 'wp-last-modified-info' ),
				'date_format' => __( 'Last Modified Info Date Time Format:', 'wp-last-modified-info' ),
				'time_gap' => __( 'Published Time & Modified Time Gap:', 'wp-last-modified-info' ),
				'author_display' => __( 'Display Last Modified Author Name:', 'wp-last-modified-info' ),
				'author_list' => __( 'Custom Post Author for All Posts:', 'wp-last-modified-info' ),
				'archives' => __( 'Disable Output on these Archive(s):', 'wp-last-modified-info' ),
				'selectors' => __( 'Enter the Post Date CSS Selector(s):', 'wp-last-modified-info' ),
				'display_info' => __( 'HTML Template to Display on Posts:', 'wp-last-modified-info' ),
				'post_types' => __( 'Posts Types to Show Modified Info:', 'wp-last-modified-info' )
			],
			'template_tag' => [
				'template_date_type' => __( 'Last Modified Info Format for Posts:', 'wp-last-modified-info' ),
				'template_date_format' => __( 'Last Modified Info Date Time Format:', 'wp-last-modified-info' ),
				'template_author_display' => __( 'Display Last Modified Author Name:', 'wp-last-modified-info' ),
				'template_author_list' => __( 'Custom Post Author for All Posts:', 'wp-last-modified-info' ),
				'template_display_info' => __( 'HTML Template for Template Tags:', 'wp-last-modified-info' )
			],
			'schema' => [
			    'enable_schema' => __( 'JSON-LD Schema Markup Mode:', 'wp-last-modified-info' ),
				'schema_post_types' => __( 'Select Post Types for JSON-LD Markup:', 'wp-last-modified-info' ),
				'enhanced_schema' => __( 'Enable Enhanced Schema Support:', 'wp-last-modified-info' )
			],
			'notification' => [
			    'enable_notification' => __( 'Enable Notification on Post Update?', 'wp-last-modified-info' ),
			    'author_notification' => __( 'Send Notification to Post Author?', 'wp-last-modified-info' ),
				'draft_notification' => __( 'Send Notification when Draft Changes?', 'wp-last-modified-info' ),
				'recipients_list' => __( 'Send Email to these Email Recipient(s):', 'wp-last-modified-info' ),
				'notification_post_types' => __( 'Select Posts Types for Diff Detection:', 'wp-last-modified-info' ),
				'email_notification_subject' => __( 'Enter Email Notification Subject:', 'wp-last-modified-info' ),
				'email_notification_message' => __( 'Enter Email Notification Message Body:', 'wp-last-modified-info' )
			],
			'misc' => [
			    'admin_bar' => __( 'Show Modified Info on Admin Bar:', 'wp-last-modified-info' ),
			    'disable_plugin_info' => __( 'Hide Plugins Last Modified Info:', 'wp-last-modified-info' ),
			    'admin_sort_order' => __( 'Default Admin Post Sorting Order:', 'wp-last-modified-info' ),
				'sort_order' => __( 'Default Frontend Post Sorting Order:', 'wp-last-modified-info' ),
				'replace_date' => __( 'Post Date Time Change or Removal:', 'wp-last-modified-info' ),
				'custom_css' => __( 'Custom CSS Code (if required):', 'wp-last-modified-info' ),
				'delete_data' => __( 'Delete Plugin Data upon Uninstallation:', 'wp-last-modified-info' )
			]
		];

		if ( 'Astra' == $theme->name || 'Astra' == $theme->parent_theme ) {
			$managers['template_tag'] = $this->insert_settings( $managers['template_tag'], 0, [
			    'astra_support' => __( 'Enable Astra Theme Auto Support:', 'wp-last-modified-info' ),
			    'theme_template_type' => __( 'Astra Theme Info Template Type:', 'wp-last-modified-info' )
			] );
		}

		if ( 'GeneratePress' == $theme->name || 'GeneratePress' == $theme->parent_theme ) {
			$managers['template_tag'] = $this->insert_settings( $managers['template_tag'], 0, [
			    'generatepress_support' => __( 'Enable GeneratePress Theme Support:', 'wp-last-modified-info' ),
				'theme_template_type' => __( 'GeneratePress Theme Template Type:', 'wp-last-modified-info' )
			] );
		}

		return $managers;
	}

	/**
     * A custom sanitization function that will take the incoming input, and sanitize
     * the input before handing it back to WordPress to save to the database.
     *
     * @since 1.7.0
     *
     * @param   array  $input   The address input.
     * @return  array  $output  The sanitized input.
     */
    public function sanitizeOutput( $input )
    {    
    	$output = [];
		$fields = [ 'lmt_last_modified_info_template', 'lmt_last_modified_info_template_tt', 'lmt_email_subject', 'lmt_email_message' ];
		
		foreach ( $input as $key => $value ) {
			if ( in_array( $key, $fields ) ) {
				$output[$key] = wp_kses_post( $value );
			} else {
				$output[$key] = $value;
			}
		}
		
		return $this->do_filter( 'validate_input', $output, $input );
    }
}