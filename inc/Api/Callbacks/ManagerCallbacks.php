<?php
/**
 * Settings callbacks.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Api\Callbacks
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Api\Callbacks;

use Wplmi\Helpers\Fields;
use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

class ManagerCallbacks
{
	use Fields;
    use HelperFunctions;
    use Hooker;

	/* ==============================================================================================
                                            Post Options
    ============================================================================================== */

	public function enable_plugin( $args ) {
		$this->do_field( [
			'type'        => 'checkbox',
			'id'          => $args['label_for'],
			'name'        => 'lmt_enable_last_modified_cb',
			'checked'     => 1 == $this->get_data( 'lmt_enable_last_modified_cb' ),
			'description' => __( 'Enable this Global Switch if you want to show last modified info on your posts.', 'wp-last-modified-info' ),
		] );
	}

	public function display_method( $args ) {
		$this->do_field( [
			'type'        => 'select',
			'id'          => $args['label_for'],
			'name'        => 'lmt_show_last_modified_time_date_post',
			'value'       => $this->get_data( 'lmt_show_last_modified_time_date_post', 'before_content' ),
			'description' => __( 'Select where you want to show last modified info on a single posts. If you select Before Content or After Content or Replace Method, you can disable auto insert on particular posts from post edit screen > WP Last Modified Info meta box and apply shortcode on that particular post.', 'wp-last-modified-info' ),
			'options'     => [
				'before_content'   => __( 'Before Content', 'wp-last-modified-info' ),
				'after_content'    => __( 'After Content', 'wp-last-modified-info' ),
				'replace_original' => __( 'Replace Published Date', 'wp-last-modified-info' ),
				'manual'           => __( 'Manual (use shortcode)', 'wp-last-modified-info' ),
			],
			'show_if'     => 'wplmi_enable_plugin',
		] );
	}

	public function date_type( $args ) {
		$this->do_field( [
			'type'        => 'select',
			'id'          => $args['label_for'],
			'name'        => 'lmt_last_modified_format_post',
			'value'       => $this->get_data( 'lmt_last_modified_format_post', 'default' ),
			'description' => __( 'Select last modified date time format from here.', 'wp-last-modified-info' ),
			'options'     => [
				'default'        => __( 'Traditional Format', 'wp-last-modified-info' ),
				'human_readable' => __( 'Human Readable Format', 'wp-last-modified-info' ),
			],
			'show_if'     => 'wplmi_enable_plugin',
		] );
	}

	public function date_format( $args ) {
		$this->do_field( [
			'id'          => $args['label_for'],
			'name'        => 'lmt_date_time_format',
			'value'       => $this->get_data( 'lmt_date_time_format', get_option( 'date_format' ) ),
			/* translators: %s: Link */
			'description' => sprintf( __( 'Set post last modified date time format from here. %s', 'wp-last-modified-info' ), '<a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank" rel="nopender">' . __( 'Learn more', 'wp-last-modified-info' ) . '</a>' ),
			'condition'   => [ 'wplmi_date_type', '=', 'default' ],
			'show_if'     => 'wplmi_enable_plugin',
		] );
	}

	public function time_gap( $args ) {
		$this->do_field( [
			'type'        => 'select',
			'id'          => $args['label_for'],
			'name'        => 'lmt_gap_on_post',
			'value'       => $this->get_data( 'lmt_gap_on_post', '0' ),
			'description' => __( 'Select the gap between published time and modified time. If modified time is greater than published time + gap, then it shows last modified info on frontend.', 'wp-last-modified-info' ),
			'options'     => [
				'0'       => __( 'No Gap', 'wp-last-modified-info' ),
				'86400'   => __( '1 day (24 hours)', 'wp-last-modified-info' ),
				'172800'  => __( '2 days (48 hours)', 'wp-last-modified-info' ),
				'259200'  => __( '3 days (72 hours)', 'wp-last-modified-info' ),
				'432000'  => __( '5 days (120 hours)', 'wp-last-modified-info' ),
				'604800'  => __( '7 days (168 hours)', 'wp-last-modified-info' ),
				'1296000' => __( '15 days (360 hours)', 'wp-last-modified-info' ),
				'2592000' => __( '30 days (720 hours)', 'wp-last-modified-info' ),
			],
			'show_if'     => 'wplmi_enable_plugin',
		] );
	}

	public function author_display( $args ) {
		$this->do_field( [
			'type'        => 'select',
			'id'          => $args['label_for'],
			'name'        => 'lmt_show_author_cb',
			'value'       => $this->get_data( 'lmt_show_author_cb', 'default' ),
			'description' => __( 'Select how you want to display last modified author name on posts.', 'wp-last-modified-info' ),
			'options'     => [
				'default' => __( 'Last Modified Author', 'wp-last-modified-info' ),
				'custom'  => __( 'Custom Author', 'wp-last-modified-info' ),
			],
			'show_if'     => 'wplmi_enable_plugin',
		] );
	}

	public function author_list( $args ) {
		$this->do_field( [
			'type'        => 'select',
			'id'          => $args['label_for'],
			'name'        => 'lmt_show_author_list',
			'value'       => $this->get_data( 'lmt_show_author_list' ),
			'description' => __( 'Select the author name which you want to display for all posts.', 'wp-last-modified-info' ),
			'options'     => $this->get_users( $this->do_filter( 'custom_author_list_selection', [] ) ),
			'condition'   => [ 'wplmi_author_display', '=', 'custom' ],
			'show_if'     => 'wplmi_enable_plugin',
		] );
	}

	public function archives( $args ) {
		$this->do_field( [
			'type'        => 'multiple',
			'id'          => $args['label_for'],
			'name'        => 'lmt_archives',
			'value'       => $this->get_data( 'lmt_archives', [ 'is_home', 'is_author', 'is_category', 'is_tag', 'is_search' ] ),
			'description' => __( 'Select the archives where you don\'t want to show last modified info.', 'wp-last-modified-info' ),
			'options'     => [
				'is_home'       => __( 'Home Page', 'wp-last-modified-info' ),
				'is_front_page' => __( 'Front Page', 'wp-last-modified-info' ),
				'is_author'     => __( 'Author Archive', 'wp-last-modified-info' ),
				'is_category'   => __( 'Post Category Archive', 'wp-last-modified-info' ),
				'is_tag'        => __( 'Post Tag Archive', 'wp-last-modified-info' ),
				'is_search'     => __( 'Search Page', 'wp-last-modified-info' ),
				'is_archive'    => __( 'All Post Archives', 'wp-last-modified-info' ),
				'is_tax'        => __( 'All Post Type Archives', 'wp-last-modified-info' ),
			],
			'condition'   => [ 'wplmi_display_method', '=', [ 'before_content', 'after_content' ] ],
			'show_if'     => 'wplmi_enable_plugin',
		] );
	}

	public function selectors( $args ) {
		$this->do_field( [
			'id'          => $args['label_for'],
			'name'        => 'lmt_css_selectors',
			'value'       => $this->get_data( 'lmt_css_selectors', 'ul li.meta-date' ),
			'description' => __( 'Add the CSS selector to replace the post meta. It may not work for all themes. Please check before using it. If you need any help, please open a support ticket with your website URL. If you are using any caching plugin, please clear/remove your cache after any changes made to this field.', 'wp-last-modified-info' ),
			'condition'   => [ 'wplmi_display_method', '=', 'replace_original' ],
			'show_if'     => 'wplmi_enable_plugin',
		] );
	}

	public function display_info( $args ) {
		$default = '<p class="post-modified-info">Last Updated on %post_modified% by <a href="%author_url%" target="_blank" class="last-modified-author">%author_name%</a></p>';
		$this->do_field( [
			'type'        => 'textarea',
			'id'          => $args['label_for'],
			'name'        => 'lmt_last_modified_info_template',
			'value'       => wp_unslash( $this->get_data( 'lmt_last_modified_info_template', $default ) ),
			'description' => $this->generate_template_tags( [ 'author_name', 'author_url', 'author_email', 'author_archive', 'post_published', 'post_link', 'post_modified' ] ),
			'show_if'     => 'wplmi_enable_plugin',
		] );
	}

	public function post_types( $args ) {
		$this->do_field( [
			'type'        => 'multiple',
			'id'          => $args['label_for'],
			'name'        => 'lmt_custom_post_types_list',
			'value'       => $this->get_data( 'lmt_custom_post_types_list', [ 'post' ] ),
			'description' => __( 'Select post types on which you want to show last modified info.', 'wp-last-modified-info' ),
			'class'       => 'wplmi-post-types',
			'options'     => $this->get_post_types(),
			'condition'   => [ 'wplmi_display_method', '!=', 'manual' ],
			'show_if'     => 'wplmi_enable_plugin',
		] );
	}

	/* ==============================================================================================
                                            Template Tags
	============================================================================================== */

	public function template_date_type( $args ) {
		$this->do_field( [
			'type'        => 'select',
			'id'          => $args['label_for'],
			'name'        => 'lmt_last_modified_format_tt',
			'value'       => $this->get_data( 'lmt_last_modified_format_tt', 'default' ),
			'description' => __( 'Select last modified date time format from here.', 'wp-last-modified-info' ),
			'options'     => [
				'default'        => __( 'Traditional Format', 'wp-last-modified-info' ),
				'human_readable' => __( 'Human Readable Format', 'wp-last-modified-info' ),
			],
		] );
	}

	public function template_date_format( $args ) {
		$this->do_field( [
			'id'          => $args['label_for'],
			'name'        => 'lmt_tt_set_format_box',
			'value'       => $this->get_data( 'lmt_tt_set_format_box', get_option( 'date_format' ) ),
			'description' => sprintf( '%s <a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank">%s</a>', __( 'Set post last modified date time format from here.', 'wp-last-modified-info' ), __( 'Learn More', 'wp-last-modified-info' ) ),
			'condition'   => [ 'wplmi_template_date_type', '=', 'default' ],
		] );
	}

	public function template_author_display( $args ) {
		$this->do_field( [
			'type'        => 'select',
			'id'          => $args['label_for'],
			'name'        => 'lmt_show_author_tt_cb',
			'value'       => $this->get_data( 'lmt_show_author_tt_cb', 'default' ),
			'description' => __( 'Select how you want to display last modified author name on posts.', 'wp-last-modified-info' ),
			'options'     => [
				'default' => __( 'Last Modified Author', 'wp-last-modified-info' ),
				'custom'  => __( 'Custom Author', 'wp-last-modified-info' ),
			],
		] );
	}

	public function template_author_list( $args ) {
		$this->do_field( [
			'type'        => 'select',
			'id'          => $args['label_for'],
			'name'        => 'lmt_show_author_list_tt',
			'value'       => $this->get_data( 'lmt_show_author_list_tt' ),
			'description' => __( 'Select the author name which you want to display for all posts.', 'wp-last-modified-info' ),
			'options'     => $this->get_users( $this->do_filter( 'custom_author_list_selection', [] ) ),
			'condition'   => [ 'wplmi_template_author_display', '=', 'custom' ],
		] );
	}

	public function template_display_info( $args ) {
		$default = '<p class="post-modified-info">Last Updated on %post_modified% by <a href="%author_url%" target="_blank" class="last-modified-author">%author_name%</a></p>';
		$this->do_field( [
			'type'        => 'textarea',
			'id'          => $args['label_for'],
			'name'        => 'lmt_last_modified_info_template_tt',
			'value'       => wp_unslash( $this->get_data( 'lmt_last_modified_info_template_tt', $default ) ),
			'description' => $this->generate_template_tags( [ 'author_name', 'author_url', 'author_email', 'author_archive', 'post_published', 'post_link', 'post_modified' ] ),
		] );
	}

	/* ==============================================================================================
                                            Schema Options
    ============================================================================================== */

	public function enable_schema( $args ) {
		$this->do_field( [
			'type'        => 'select',
			'id'          => $args['label_for'],
			'name'        => 'lmt_enable_jsonld_markup_cb',
			'value'       => $this->get_data( 'lmt_enable_jsonld_markup_cb', 'disable' ),
			'description' => __( 'Set the JSON-LD Markup mode if you want to show last modified info to search engines. If you already have a SEO plugin or a Schema Plugin on your site, then you can use this option. In this mode, this plugin will try to convert the post published date output of any SEO or Schema plugin to the post modified date. This is dynamically applied when the content is displayed, and the stored content is not changed. Tested with Yoast SEO, Rank Math, All in One SEO Pack, SEOPress, Schema and many other plugins.', 'wp-last-modified-info' ),
			'options'     => [
				'enable'    => __( 'Default Mode (CreativeWork)', 'wp-last-modified-info' ),
				'inline'    => __( 'Inline Mode (MicroData)', 'wp-last-modified-info' ),
				'comp_mode' => __( 'Compatibilty Mode (Advanced)', 'wp-last-modified-info' ),
				'disable'   => __( 'Disable Schema Markup', 'wp-last-modified-info' ),
			],
		] );
	}

	public function schema_post_types( $args ) {
		$this->do_field( [
			'type'        => 'multiple',
			'id'          => $args['label_for'],
			'name'        => 'lmt_enable_jsonld_markup_post_types',
			'value'       => $this->get_data( 'lmt_enable_jsonld_markup_post_types', [ 'post' ] ),
			'description' => __( 'Select on which post types you want to enable JSON-LD Markup.', 'wp-last-modified-info' ),
			'class'       => 'wplmi-post-types',
			'options'     => $this->get_post_types(),
			'condition'   => [ 'wplmi_enable_schema', '=', 'enable' ],
		] );
	}

	public function enhanced_schema( $args ) {
		$this->do_field( [
			'type'        => 'checkbox',
			'id'          => $args['label_for'],
			'name'        => 'lmt_enable_schema_support_cb',
			'checked'     => 1 == $this->get_data( 'lmt_enable_schema_support_cb' ),
			'description' => __( 'Enable this if your theme does not support schema markup. This will add WebPage type schema support to the html tag. Please check Schema Markup before activate this option using Google Structured Data Tool. If Google already detects schema markup, you don\'t need to enable it anymore.', 'wp-last-modified-info' ),
			'condition'   => [ 'wplmi_enable_schema', '=', 'inline' ],
		] );
	}

	/* ==============================================================================================
                                            Notification Options
	============================================================================================== */

	public function enable_notification( $args ) {
		$this->do_field( [
			'type'        => 'checkbox',
			'id'          => $args['label_for'],
			'name'        => 'lmt_enable_notification_cb',
			'checked'     => 1 == $this->get_data( 'lmt_enable_notification_cb' ),
			'description' => __( 'Enable this if you want to receive email notification if anyone makes changes to any post of your blog.', 'wp-last-modified-info' ),
		] );
	}

	public function author_notification( $args ) {
		$this->do_field( [
			'type'        => 'checkbox',
			'id'          => $args['label_for'],
			'name'        => 'lmt_enable_author_noti_cb',
			'checked'     => 1 == $this->get_data( 'lmt_enable_author_noti_cb' ),
			'description' => __( 'Enable this if you want to send notification to the post author.', 'wp-last-modified-info' ),
			'show_if'     => 'wplmi_enable_notification',
		] );
	}

	public function draft_notification( $args ) {
		$this->do_field( [
			'type'        => 'checkbox',
			'id'          => $args['label_for'],
			'name'        => 'lmt_enable_draft_noti_cb',
			'checked'     => 1 == $this->get_data( 'lmt_enable_draft_noti_cb' ),
			'description' => __( 'Enable this if you want to enable notification when anyone makes changes to any draft post.', 'wp-last-modified-info' ),
			'show_if'     => 'wplmi_enable_notification',
		] );
	}

	public function recipients_list( $args ) {
		$this->do_field( [
			'id'         => $args['label_for'],
			'name'       => 'lmt_email_recipient',
			'value'      => $this->get_data( 'lmt_email_recipient', get_bloginfo( 'admin_email' ) ),
			'attributes' => [
				'placeholder' => get_bloginfo( 'admin_email' ),
			],
			'show_if'    => 'wplmi_enable_notification',
		] );
	}

	public function notification_post_types( $args ) {
		$this->do_field( [
			'type'        => 'multiple',
			'id'          => $args['label_for'],
			'name'        => 'lmt_enable_noti_post_types',
			'value'       => $this->get_data( 'lmt_enable_noti_post_types', [ 'post' ] ),
			'description' => __( 'Select on which post types you want to enable JSON-LD Markup.', 'wp-last-modified-info' ),
			'class'       => 'wplmi-post-types',
			'options'     => $this->get_post_types(),
			'show_if'     => 'wplmi_enable_notification',
		] );
	}

	public function email_notification_subject( $args ) {
		$this->do_field( [
			'type'        => 'textarea',
			'id'          => $args['label_for'],
			'name'        => 'lmt_email_subject',
			'value'       => $this->get_data( 'lmt_email_subject', '[%site_name%] A %post_type% of %author_name% has been modified on your blog.' ),
			'description' => $this->generate_template_tags( [ 'post_title', 'post_type', 'author_name', 'site_name', 'site_url', 'current_time' ] ),
			'attributes'  => [
				'rows' => 2,
				'cols' => 100,
			],
			'show_if'     => 'wplmi_enable_notification',
		] );
	}

	public function email_notification_message( $args ) {
		$default = 'The following changes are made on a %post_type% of your blog by %modified_author_name%' . "\n\n" . '<p><strong>Post: %post_title%</strong></p><p>%post_diff%</p>';
		$this->do_field( [
			'type'        => 'wp_editor',
			'id'          => $args['label_for'],
			'name'        => 'lmt_email_message',
			'value'       => $this->get_data( 'lmt_email_message', $default ),
			'description' => $this->generate_template_tags( [ 'post_title', 'post_type', 'author_name', 'modified_author_name', 'post_edit_link', 'post_diff', 'site_name', 'site_url', 'admin_email', 'current_time' ] ),
			'show_if'     => 'wplmi_enable_notification',
		] );
	}

	/* ==============================================================================================
                                                Misc Options
	============================================================================================== */

	public function admin_bar( $args ) {
		$this->do_field( [
			'type'        => 'checkbox',
			'id'          => $args['label_for'],
			'name'        => 'lmt_enable_on_admin_bar_cb',
			'checked'     => 1 == $this->get_data( 'lmt_enable_on_admin_bar_cb' ),
			'description' => __( 'Enable this if you want to show last modified info on WordPress admin bar.', 'wp-last-modified-info' ),
		] );
    }

	public function disable_plugin_info( $args ) {
		$this->do_field( [
			'type'        => 'checkbox',
			'id'          => $args['label_for'],
			'name'        => 'lmt_disable_plugin_info',
			'checked'     => 1 == $this->get_data( 'lmt_disable_plugin_info' ),
			'description' => __( 'Enable this if you do not want to show last updated info on plugins page.', 'wp-last-modified-info' ),
		] );
	}

	public function admin_sort_order( $args ) {
		$this->do_field( [
			'type'        => 'select',
			'id'          => $args['label_for'],
			'name'        => 'lmt_admin_default_sort_order',
			'value'       => $this->get_data( 'lmt_admin_default_sort_order', 'default' ),
			'description' => __( 'Select the post sorting order on Admin Edit page in Backend.', 'wp-last-modified-info' ),
			'options'     => [
				'default'   => __( 'Default Order', 'wp-last-modified-info' ),
				'modified'  => __( 'Modified Post First', 'wp-last-modified-info' ),
				'published' => __( 'Modified Post Last', 'wp-last-modified-info' ),
			],
		] );
    }

	public function sort_order( $args ) {
		$this->do_field( [
			'type'        => 'select',
			'id'          => $args['label_for'],
			'name'        => 'lmt_default_sort_order',
			'value'       => $this->get_data( 'lmt_default_sort_order', 'default' ),
			'description' => __( 'Select the post sorting order on Frontend.', 'wp-last-modified-info' ),
			'options'     => [
				'default'   => __( 'Default Order', 'wp-last-modified-info' ),
				'modified'  => __( 'Modified Post First', 'wp-last-modified-info' ),
				'published' => __( 'Modified Post Last', 'wp-last-modified-info' ),
			],
		] );
	}

	public function replace_date( $args ) {
		$this->do_field( [
			'type'        => 'select',
			'id'          => $args['label_for'],
			'name'        => 'lmt_replace_published_date',
			'value'       => $this->get_data( 'lmt_replace_published_date', 'none' ),
			'description' => __( 'You can convert original post date to modified date or remove published date completely. "Hide from Search Engines" option remove all the dates output from frontend and also from search engines if your theme supports it. If you see any empty or blank icon or option on frontend or post meta area, just hide that element with the Custom CSS option below. Please disable schema if you are using this option.', 'wp-last-modified-info' ),
			'options'     => [
				'none'    => __( 'Disable', 'wp-last-modified-info' ),
				'replace' => __( 'Convert to Modified Date', 'wp-last-modified-info' ),
				'remove'  => __( 'Hide from Search Engines', 'wp-last-modified-info' ),
			],
		] );
	}

	public function custom_css( $args ) {
		$this->do_field( [
			'type'        => 'textarea',
			'id'          => $args['label_for'],
			'name'        => 'lmt_custom_style_box',
			'value'       => wp_unslash( wp_kses_post( $this->get_data( 'lmt_custom_style_box' ) ) ),
			/* translators: %s: Tag */
			'description' => sprintf( __( 'Do not add %s tag. This tag is not required, as it is already added.', 'wp-last-modified-info' ), '<code>&lt;style&gt;&lt;/style&gt;</code>' ),
		] );
    }

	public function delete_data( $args ) {
		$this->do_field( [
			'type'        => 'checkbox',
			'id'          => $args['label_for'],
			'name'        => 'lmt_del_plugin_data_cb',
			'checked'     => 1 == $this->get_data( 'lmt_del_plugin_data_cb' ),
			'description' => __( 'Enable this if you want to delete plugin data at the time of uninstallation.', 'wp-last-modified-info' ),
		] );
    }

	/**
	 * Generate template tags output.
	 *
	 * @since 1.8.0
	 */
	private function generate_template_tags( $tags ) {
		ob_start() ?>
		<div class="dynamic-tags">
			<div class="dynamic-tags-label">
				<a href="https://github.com/iamsayan/wp-last-modified-info/wiki/Temaplate-Use-Cases" target="_blank" rel="noopener"><?php esc_html_e( 'Use these tags', 'wp-last-modified-info' ); ?></a>.
				<a href="https://github.com/iamsayan/wp-last-modified-info/wiki/Template-Tags" target="_blank" rel="noopener"><?php esc_html_e( 'Available Dynamic Tags', 'wp-last-modified-info' ); ?></a>:
			</div>
			<div class="dynamic-tags-content"><?= $this->get_available_tags( $tags ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Get available template tags.
	 *
	 * @param $tags
	 * @return string
	 * @since 1.8.0
	 */
	private function get_available_tags( $tags ): string {
		$content = [];
		foreach ( $tags as $tag ) {
			$content[] = '<code class="click-to-copy">%' . esc_html( $tag ) . '%</code>';
		}

		return join( ' ', $content );
	}
}
