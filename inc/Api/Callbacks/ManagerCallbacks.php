<?php 
/**
 * Settings callbacks.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Api\Callbacks
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Api\Callbacks;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

class ManagerCallbacks
{
	use HelperFunctions, Hooker;

	/* ============================================================================================== 
                                           Post Options
    ============================================================================================== */

	public function enable_plugin( $args )
	{
		?><label class="switch">
			<input type="checkbox" id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_enable_last_modified_cb]" value="1" <?php checked( $this->get_data( 'lmt_enable_last_modified_cb' ), 1 ); ?> /> 
			<span class="cb-slider round"></span></label>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this Global Switch if you want to show last modified info on your posts.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
		<?php
	}

	public function display_method( $args )
	{
		$items = [
			'before_content'   => __( 'Before Content', 'wp-last-modified-info' ),
			'after_content'    => __( 'After Content', 'wp-last-modified-info' ),
			'replace_original' => __( 'Replace Published Date', 'wp-last-modified-info' ),
			'manual'           => __( 'Manual (use shortcode)', 'wp-last-modified-info' )
		];
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_show_last_modified_time_date_post]" style="width:25%;">';
		foreach( $items as $item => $label ) {
			$selected = ( $this->get_data( 'lmt_show_last_modified_time_date_post', 'before_content' ) == $item ) ? ' selected="selected"' : '';
			echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select where you want to show last modified info on a single posts. If you select Before Content or After Content or Replace Method, you can disable auto insert on particular posts from post edit screen > WP Last Modified Info meta box and apply shortcode on that particular post.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<?php
	}

	public function date_type( $args )
	{
		$items = [
			'default'         => __( 'Traditional Format', 'wp-last-modified-info' ),
			'human_readable'  => __( 'Human Readable Format', 'wp-last-modified-info' )
		];
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_last_modified_format_post]" style="width:25%;">';
		foreach( $items as $item => $label ) {
			$selected = ( $this->get_data( 'lmt_last_modified_format_post', 'default' ) == $item ) ? ' selected="selected"' : '';
			echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select last modified date time format from here.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<?php
	}

	public function date_format( $args )
	{
		?><input id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_date_time_format]" type="text" style="width:25%;" placeholder="<?php _e( 'Default:', 'wp-last-modified-info' ); ?> <?php echo get_option( 'date_format' ); ?>" value="<?php echo $this->get_data( 'lmt_date_time_format', get_option( 'date_format' ) ); ?>" />&nbsp;
		<a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank"><span class="tooltip" title="<?php _e( 'Set post last modified date time format from here.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span></a>
		<?php
	}

	public function time_gap( $args )
	{
		$items = [
			'0'        => __( 'No Gap', 'wp-last-modified-info' ),
			'86400'    => __( '1 day (24 hours)', 'wp-last-modified-info' ),
			'172800'   => __( '2 days (48 hours)', 'wp-last-modified-info' ),
			'259200'   => __( '3 days (72 hours)', 'wp-last-modified-info' ),
			'432000'   => __( '5 days (120 hours)', 'wp-last-modified-info' ),
			'604800'   => __( '7 days (168 hours)', 'wp-last-modified-info' ),
			'1296000'  => __( '15 days (360 hours)', 'wp-last-modified-info' ),
			'2592000'  => __( '30 days (720 hours)', 'wp-last-modified-info' )
		];
		$items = $this->do_filter( 'custom_time_gap_intervals', $items );
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_gap_on_post]" style="width:25%;">';
		foreach( $items as $item => $label ) {
			$selected = ( $this->get_data( 'lmt_gap_on_post', 0 ) == $item ) ? ' selected="selected"' : '';
			echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select the gap between published time and modified time. If modified time is greater than published time + gap, then it shows last modified info on frontend.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<?php
	}

	public function author_display( $args )
	{
		$items = [
			'default'     => __( 'Last Modified Author', 'wp-last-modified-info' ),
			'custom'      => __( 'Custom Author', 'wp-last-modified-info' )
		];
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_show_author_cb]" style="width:25%;">';
		foreach( $items as $item => $label ) {
			$selected = ( $this->get_data( 'lmt_show_author_cb', 'default' ) == $item ) ? ' selected="selected"' : '';
			echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select how you want to display last modified author name on posts.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<?php
	}

	public function author_list( $args )
	{
		$users = get_users( $this->do_filter( 'custom_author_list_selection', [] ) );
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_show_author_list]" style="width:25%;">';
		foreach( $users as $user ) {
			$selected = ( $this->get_data( 'lmt_show_author_list' ) == $user->ID ) ? ' selected="selected"' : '';
			echo '<option value="' . $user->ID . '"' . $selected . '>' . $user->display_name . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select the author name which you want to display for all posts.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<?php
	}

	public function archives( $args )
	{
		$items = [
			'is_home' => __( 'Home Page', 'wp-last-modified-info' ),
			'is_front_page' => __( 'Front Page', 'wp-last-modified-info' ),
			'is_author' => __( 'Author Archive', 'wp-last-modified-info' ),
			'is_category' => __( 'Post Category Archive', 'wp-last-modified-info' ),
			'is_tag' => __( 'Post Tag Archive', 'wp-last-modified-info' ),
			'is_search' => __( 'Search Page', 'wp-last-modified-info' ),
			'is_archive' => __( 'All Post Archives', 'wp-last-modified-info' ),
			'is_tax' => __( 'All Post Type Archives', 'wp-last-modified-info' ),
		];
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_archives][]" multiple="multiple" data-placeholder="' . __( 'Select archives', 'wp-last-modified-info' ) . '" style="width:90%;">';
		foreach( $items as $item => $label ) {
			$selected = in_array( $item, $this->get_data( 'lmt_archives', [ 'is_home', 'is_author', 'is_category', 'is_tag', 'is_search' ] ) ) ? ' selected="selected"' : '';
			echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;</span><span class="tooltip" title="<?php _e( 'Select the archives where you don\'t want to show last modified info.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<?php
	}

	public function selectors( $args )
	{
		?><input id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_css_selectors]" type="text" style="width:90%;" value="<?php echo wp_kses_post( $this->get_data( 'lmt_css_selectors', 'ul li.meta-date' ) ); ?>" />&nbsp;
		<span class="tooltip" title="<?php _e( 'Add the CSS selector to replace the post meta. It may not work for all themes. Please check before using it. If you need any help, please open a support ticket with your website URL.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<p><small><span class="help-text"><?php _e( 'If you are using any caching plugin, please clear/remove your cache after any changes made to this field.', 'wp-last-modified-info' ); ?></span></small>
		</p><?php
	}

	public function display_info( $args )
	{
		$default = '<p class="post-modified-info">Last Updated on %post_modified% by <a href="%author_url%" target="_blank" class="last-modified-author">%author_name%</a></p>';
		?><textarea id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_last_modified_info_template]" rows="6" style="width:95%;"><?php echo esc_html( wp_unslash( $this->get_data( 'lmt_last_modified_info_template', $default ) ) ); ?></textarea>
		<p>
		    <small><span class="help-text"><?php _e( 'Use these tags', 'wp-last-modified-info' ); ?></span> -
			<code>&#37;author_name&#37;</code> <code>&#37;author_url&#37;</code> <code>&#37;author_email&#37;</code> <code>&#37;author_archive&#37;</code> <code>&#37;post_published&#37;</code> <code>&#37;post_link&#37;</code> <code>&#37;post_modified&#37;</code>
			</small>
		</p><?php
	}

	public function post_types( $args )
	{
		$post_types = $this->get_post_types();
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_custom_post_types_list][]" multiple="multiple" data-placeholder="' . __( 'Select post types', 'wp-last-modified-info' ) . '" style="width:90%;">';
		foreach( $post_types as $post_type => $label ) {
            $selected = in_array( $post_type, $this->get_data( 'lmt_custom_post_types_list', [ 'post' ] ) ) ? ' selected="selected"' : '';
			echo '<option value="' . $post_type . '"' . $selected . '>' . $label . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select post types on which you want to show last modified info.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
		<?php
	}
	/* ============================================================================================== 
                                           Template Tags
	============================================================================================== */

	public function astra_support( $args )
	{
		$items = [
		    'none'      => __( 'Use Default Post Date', 'wp-last-modified-info' ),
			'replace'   => __( 'Replace Post Meta Data', 'wp-last-modified-info' )
        ];
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_tt_astra_theme_mod]" style="width:25%;">';
		foreach( $items as $item => $label ) {
			$selected = ( $this->get_data( 'lmt_tt_astra_theme_mod', 'none' ) == $item ) ? ' selected="selected"' : '';
			echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable the Astra Theme Support form here. It will replace the post meta published date with post modified date.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<?php
	}

	public function generatepress_support( $args )
	{
		$items = [
			'none'      => __( 'Use Default Post Date', 'wp-last-modified-info' ),
			'replace'   => __( 'Replace Post Meta Data', 'wp-last-modified-info' )
        ];
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_tt_generatepress_theme_mod]" style="width:25%;">';
		foreach( $items as $item => $label ) {
			$selected = ( $this->get_data( 'lmt_tt_generatepress_theme_mod', 'none' ) == $item ) ? ' selected="selected"' : '';
			echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable the GeneratePress Theme Support form here. It will replace the post meta published date with post modified date.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<?php
	}

	public function theme_template_type( $args )
	{
		$items = [
			'default' => __( 'Show Modified Date', 'wp-last-modified-info' ),
            'custom'  => __( 'Custom Template', 'wp-last-modified-info' )
		];
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_tt_theme_template_type]" style="width:25%;">';
		foreach( $items as $item => $label ) {
			$selected = ( $this->get_data( 'lmt_tt_theme_template_type', 'custom' ) == $item ) ? ' selected="selected"' : '';
			echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Set the template type from here to diaplay on post meta.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<?php
	}

	public function template_date_type( $args )
	{
		$items = [
			'default'         => __( 'Traditional Format', 'wp-last-modified-info' ),
			'human_readable'  => __( 'Human Readable Format', 'wp-last-modified-info' )
		];
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_last_modified_format_tt]" style="width:25%;">';
		foreach( $items as $item => $label ) {
			$selected = ( $this->get_data( 'lmt_last_modified_format_tt', 'default' ) == $item ) ? ' selected="selected"' : '';
			echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select last modified date time format from here.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<?php
	}

	public function template_date_format( $args )
	{
		?><input id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_tt_set_format_box]" type="text" style="width:25%;" placeholder="<?php _e( 'Default:', 'wp-last-modified-info' ); ?> <?php echo get_option( 'date_format' ); ?>" value="<?php echo $this->get_data( 'lmt_tt_set_format_box', get_option( 'date_format' ) ); ?>" />&nbsp;
		<a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank"><span class="tooltip" title="<?php _e( 'Set post last modified date time format from here.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span></a>
		<?php
	}

	public function template_author_display( $args )
	{
		$items = [
			'default'     => __( 'Last Modified Author', 'wp-last-modified-info' ),
			'custom'      => __( 'Custom Author', 'wp-last-modified-info' )
		];
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_show_author_tt_cb]" style="width:25%;">';
		foreach( $items as $item => $label ) {
			$selected = ( $this->get_data( 'lmt_show_author_tt_cb', 'do_not_show' ) == $item ) ? ' selected="selected"' : '';
			echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select how you want to display last modified author name on posts.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<?php
	}

	public function template_author_list( $args )
	{
		$users = get_users( $this->do_filter( 'custom_author_list_selection', [] ) );
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_show_author_list_tt]" style="width:25%;">';
		foreach( $users as $user ) {
			$selected = ( $this->get_data( 'lmt_show_author_list_tt' ) == $user->ID ) ? ' selected="selected"' : '';
			echo '<option value="' . $user->ID . '"' . $selected . '>' . $user->display_name . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select the author name which you want to display for all posts.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<?php
	}

	public function template_display_info( $args )
	{
		$default = '<p class="post-modified-info">Last Updated on %post_modified% by <a href="%author_url%" target="_blank" class="last-modified-author">%author_name%</a></p>';
		?><textarea id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_last_modified_info_template_tt]" rows="6" style="width:90%;"><?php echo esc_html( wp_unslash( $this->get_data( 'lmt_last_modified_info_template_tt', $default ) ) ); ?></textarea>
		<p>
		    <small><span class="help-text"><?php _e( 'Use these tags', 'wp-last-modified-info' ); ?></span> -
			<code>&#37;author_name&#37;</code> <code>&#37;author_url&#37;</code> <code>&#37;author_email&#37;</code> <code>&#37;author_archive&#37;</code> <code>&#37;post_published&#37;</code> <code>&#37;post_link&#37;</code> <code>&#37;post_modified&#37;</code>
			</small>
		</p><?php
	}

	/* ============================================================================================== 
                                           Schema Options
    ============================================================================================== */

	public function enable_schema( $args )
	{
		$items = [
			'enable'     => __( 'Default Mode (CreativeWork)', 'wp-last-modified-info' ),
			'inline'     => __( 'Inline Mode (MicroData)', 'wp-last-modified-info' ),
			'comp_mode'  => __( 'Compatibilty Mode (Advanced)', 'wp-last-modified-info' ),
			'disable'    => __( 'Disable Schema Markup', 'wp-last-modified-info' )
		];
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_enable_jsonld_markup_cb]" style="width:30%;">';
		foreach( $items as $item => $label ) {
			$selected = ( $this->get_data( 'lmt_enable_jsonld_markup_cb', 'disable' ) == $item ) ? ' selected="selected"' : '';
			echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Set the JSON-LD Markup mode if you want to show last modified info to search engines.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<div class="schema-text"><?php _e( 'If you already have a SEO plugin or a Schema Plugin on your site, then you can use this option. In this mode, this plugin will try to convert the post published date output of any SEO or Schema plugin to the post modified date. This is dynamically applied when the content is displayed, and the stored content is not changed. Tested with Yoast SEO, Rank Math, All in One SEO Pack, SEOPress, Schema and many other plugins.', 'wp-last-modified-info' ); ?></div>
		<?php
	}
	
	public function schema_post_types( $args )
	{
		$post_types = $this->get_post_types();
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_enable_jsonld_markup_post_types][]" multiple="multiple" data-placeholder="' . __( 'Select post types', 'wp-last-modified-info' ) . '" style="width:80%;">';
		foreach( $post_types as $post_type => $label ) {
			$selected = in_array( $post_type, $this->get_data( 'lmt_enable_jsonld_markup_post_types', [ 'post' ] ) ) ? ' selected="selected"' : '';
			echo '<option value="' . $post_type . '"' . $selected . '>' . $label . '</option>';
		}
		echo '</select>';
		?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select on which post types you want to enable JSON-LD Markup.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<?php
	}
	
	public function enhanced_schema( $args )
	{
		?><label class="switch">
			<input type="checkbox" id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_enable_schema_support_cb]" value="1" <?php checked( $this->get_data( 'lmt_enable_schema_support_cb' ), 1 ); ?> /> 
			<span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if your theme does not support schema markup. This will add WebPage type schema support to the html tag. Please check Schema Markup before activate this option using Google Structured Data Tool. If Google already detects schema markup, you don\'t need to enable it anymore.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
		<?php
	}
	
	/* ============================================================================================== 
                                           Notification Options
	============================================================================================== */
	
	public function enable_notification( $args )
	{
		?><label class="switch">
			<input type="checkbox" id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_enable_notification_cb]" value="1" <?php checked( $this->get_data( 'lmt_enable_notification_cb' ), 1 ); ?> /> 
			<span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you want to receive email notification if anyone makes changes to any post of your blog.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
	   <?php
	}
	
	public function author_notification( $args )
	{
		?><label class="switch">
			<input type="checkbox" id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_enable_author_noti_cb]" value="1" <?php checked( $this->get_data( 'lmt_enable_author_noti_cb' ), 1 ); ?> /> 
			<span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you want to send notification to the post author.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
	   <?php
	}
	
	public function draft_notification( $args )
	{
		?><label class="switch">
			<input type="checkbox" id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_enable_draft_noti_cb]" value="1" <?php checked( $this->get_data( 'lmt_enable_draft_noti_cb' ), 1 ); ?> /> 
			<span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you want to enable notification when anyone makes changes to any draft post.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
	   <?php
	}
	
	public function recipients_list( $args )
	{
		?><input id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_email_recipient]" type="text" style="width:100%;" placeholder="<?php echo get_option( 'admin_email' ); ?>" value="<?php echo $this->get_data( 'lmt_email_recipient' ); ?>" />
		<?php
	}
	
	public function notification_post_types( $args )
	{
		$post_types = $this->get_post_types();
		echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_enable_noti_post_types][]" multiple="multiple" data-placeholder="' . __( 'Select post types', 'wp-last-modified-info' ) . '" style="width:100%;">';
		foreach( $post_types as $post_type => $label ) {
            $selected = in_array( $post_type, $this->get_data( 'lmt_enable_noti_post_types', [ 'post' ] ) ) ? ' selected="selected"' : '';
			echo '<option value="' . $post_type . '"' . $selected . '>' . $label . '</option>';
		}
		echo '</select>';
	}

	public function email_notification_subject( $args )
	{
		$default = '[%site_name%] A %post_type% of %author_name% has been modified on your blog.';
		?><input id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_email_subject]" type="text" style="width:100%;" value="<?php echo esc_html( $this->get_data( 'lmt_email_subject', $default ) ); ?>" />
		<p>
			<small><span class="help-text"><?php _e( 'Use these tags into email subject', 'wp-last-modified-info' ); ?></span> -
			<code>&#37;post_title&#37;</code> <code>&#37;author_name&#37;</code> <code>&#37;post_type&#37;</code> <code>&#37;site_name&#37;</code> <code>&#37;site_url&#37;</code> <code>&#37;current_time&#37;</code></small>
		</p>
		<?php
	}
	
	public function email_notification_message( $args )
	{
		$default = 'The following changes are made on a %post_type% of your blog by  %modified_author_name%' . "\n\n" . '<p><strong>Post: %post_title%</strong></p><p>%post_diff%</p>';
		
		$config = [
			'textarea_name'   => 'lmt_plugin_global_settings[lmt_email_message]',
			'textarea_rows'   => '8',
			'teeny'           => true,
			'tinymce'         => false,
			'media_buttons'   => false,
		];
		wp_editor( esc_html( $this->get_data( 'lmt_email_message', $default ) ), $args['label_for'], $config ); ?>
		<p>
		    <small><span class="help-text"><?php _e( 'Use these tags into email body', 'wp-last-modified-info' ); ?></span> -
			<code>&#37;admin_email&#37;</code> <code>&#37;post_title&#37;</code> <code>&#37;author_name&#37;</code> <code>&#37;modified_author_name&#37;</code> <code>&#37;post_type&#37;</code> <code>&#37;post_edit_link&#37;</code> <code>&#37;site_name&#37;</code> <code>&#37;site_url&#37;</code> <code>&#37;current_time&#37;</code> <code>&#37;post_diff&#37;</code>
			<span class="help-text"><?php _e( 'Email body supports HTML.', 'wp-last-modified-info' ); ?></span></small>
		</p>
	<?php
	}

	/* ============================================================================================== 
                                                Misc Options
	============================================================================================== */
	
	public function admin_bar( $args )
	{
        ?><label class="switch">
            <input type="checkbox" id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_enable_on_admin_bar_cb]" value="1" <?php checked( $this->get_data( 'lmt_enable_on_admin_bar_cb' ), 1 ); ?> /> 
            <span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you want to show last modified info on wordpress admin bar.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
        <?php
    }
	
	public function disable_plugin_info( $args )
	{
        ?><label class="switch">
            <input type="checkbox" id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_disable_plugin_info]" value="1" <?php checked( $this->get_data( 'lmt_disable_plugin_info' ), 1 ); ?> /> 
            <span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you do not want to show last updated info on plugins page.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
        <?php
	}
    
	public function admin_sort_order( $args )
	{
        $items = [
            'default'     => __( 'Default Order', 'wp-last-modified-info' ),
            'modified'    => __( 'Modified Post First', 'wp-last-modified-info' ),
            'published'   => __( 'Modified Post Last', 'wp-last-modified-info' )
		];
        echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_admin_default_sort_order]" style="width:25%;">';
        foreach( $items as $item => $label ) {
            $selected = ( $this->get_data( 'lmt_admin_default_sort_order', 'default' ) == $item ) ? ' selected="selected"' : '';
            echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
        }
        echo '</select>';
        ?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select the post sorting order in Admin Edit page in Backend.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
        <?php
    }
    
	public function sort_order( $args )
	{
        $items = [
            'default'     => __( 'Default Order', 'wp-last-modified-info' ),
            'modified'    => __( 'Modified Post First', 'wp-last-modified-info' ),
            'published'   => __( 'Modified Post Last', 'wp-last-modified-info' )
		];
        echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_default_sort_order]" style="width:25%;">';
        foreach( $items as $item => $label ) {
            $selected = ( $this->get_data( 'lmt_default_sort_order', 'default' ) == $item ) ? ' selected="selected"' : '';
            echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
        }
        echo '</select>';
        ?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select the post sorting order in Admin Edit page in Frontend.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
        <?php
	}
	
	public function replace_date( $args )
	{
        $items = [
            'none'     => __( 'Do Nothing', 'wp-last-modified-info' ),
            'replace'  => __( 'Convert to Modified Date', 'wp-last-modified-info' ),
            'remove'   => __( 'Hide from Search Engines', 'wp-last-modified-info' )
		];
        echo '<select id="' . $args['label_for'] . '" name="lmt_plugin_global_settings[lmt_replace_published_date]" style="width:25%;">';
        foreach( $items as $item => $label ) {
            $selected = ( $this->get_data( 'lmt_replace_published_date', 'none' ) == $item ) ? ' selected="selected"' : '';
            echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
        }
        echo '</select>';
        ?>&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'You can convert original post date to modified date or remove published date completely.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
        <div class="remove-info-text"><?php _e( 'This option remove all the dates output from frontend and also from search engines if your theme supports it. If you see any empty or blank icon or option on frontend or post meta area, just hide that element with the Custom CSS option below. Please disable schema if you are using this option.', 'wp-last-modified-info' ); ?></div>
		<?php
	}
    
	public function custom_css( $args )
	{
        ?><textarea id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_custom_style_box]" rows="6" style="width:90%;"><?php echo esc_html( wp_unslash( wp_kses_post( $this->get_data( 'lmt_custom_style_box' ) ) ) ); ?></textarea>
		<p><small><span class="help-text"><?php printf( __( 'Do not add %s tag. This tag is not required, as it is already added.', 'wp-last-modified-info' ), '<code>&lt;style&gt; &lt;/style&gt;</code>' ); ?></span></small></p>
		<?php
    }
    
	public function delete_data( $args )
	{
        ?><label class="switch">
            <input type="checkbox" id="<?php echo $args['label_for']; ?>" name="lmt_plugin_global_settings[lmt_del_plugin_data_cb]" value="1" <?php checked( $this->get_data( 'lmt_del_plugin_data_cb' ), 1 ); ?> /> 
            <span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you want to delete plugin data at the time of uninstallation.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicon dashicons dashicons-editor-help"></span></span>
        <?php
    }
}