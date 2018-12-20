<?php
/**
 * Plugin settings options
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */
?>

<div class="wrap">
    <h1><?php _e( 'WP Last Modified Info', 'wp-last-modified-info' ); ?> <span style="font-size:12px;"><?php _e( 'Ver', 'wp-last-modified-info' ); ?> <?php echo LMT_PLUGIN_VERSION; ?></span></h1>
	<div> <?php _e( 'Show last update date and time on pages and posts very easily.', 'wp-last-modified-info' ); ?> </div><hr>
    <div id="nav-container" class="nav-tab-wrapper">
        <a href="#post" class="nav-tab active" id="btn1"><span class="dashicons dashicons-admin-post" style="padding-top: 2px;"></span> <?php _e( 'Post Options', 'wp-last-modified-info' ); ?></a>
        <a href="#page" class="nav-tab" id="btn2"><span class="dashicons dashicons-admin-page" style="padding-top: 2px;"></span> <?php _e( 'Page Options', 'wp-last-modified-info' ); ?></a>
        <a href="#template-tags" class="nav-tab" id="btn3"><span class="dashicons dashicons-tag" style="padding-top: 2px;"></span> <?php _e( 'Template Tags', 'wp-last-modified-info' ); ?></a>
        <a href="#misc" class="nav-tab" id="btn4"><span class="dashicons dashicons-screenoptions" style="padding-top: 2px;"></span> <?php _e( 'Misc. Options', 'wp-last-modified-info' ); ?></a>
        <a href="#tools" class="nav-tab" id="btn5"><span class="dashicons dashicons-admin-tools" style="padding-top: 2px;"></span> <?php _e( 'Tools', 'wp-last-modified-info' ); ?></a>
        <a href="#help" class="nav-tab" id="btn6"><span class="dashicons dashicons-editor-help" style="padding-top: 2px;"></span> <?php _e( 'Help', 'wp-last-modified-info' ); ?></a>
        <button class="nav-tab donate" style="cursor: pointer;" onclick="window.open('http://bit.ly/2I0Gj60', '_blank'); return false;"><span class="dashicons dashicons-smiley" style="padding-top: 2px;"></span> <?php _e( 'Donate this plugin', 'wp-last-modified-info' ); ?></button>
    </div>
    <script>
        var header = document.getElementById("nav-container");
        var btns = header.getElementsByClassName("nav-tab");
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
            });
        }
    </script>
    <div id="form_area">
        <div id="main-form">
        <form id="form-container" method="post" action="options.php">
            <?php if ( function_exists('wp_nonce_field') ) { wp_nonce_field('wp_last_modified_info'); } ?>
            <?php settings_fields('lmt_post_page_plugin_section'); ?>
            <div id="show-post">
                <?php do_settings_sections('lmt_post_option'); ?>
                <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings' ); ?>
            </div>
            <div style="display:none" id="show-page">
                <?php do_settings_sections('lmt_page_option'); ?>
                <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings' ); ?>
            </div>
            <div style="display:none" id="show-tt">
                <?php do_settings_sections('lmt_template_tag_option'); ?>
                <br><b><?php _e( 'Note:', 'wp-last-modified-info' ); ?></b> <i><?php _e( 'Always backup .php files before making any changes, the backup file comes in handy for restoring the default file in case WordPress goes crazy.', 'wp-last-modified-info' ); ?></i>
                <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings' ); ?>
            </div>
            <div style="display:none" id="show-misc">
                <?php do_settings_sections('lmt_misc_option'); ?>
                <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings' ); ?>
            </div>
            <div id="progressMessage" class="progressModal" style="display:none;"><?php _e( 'Please wait...', 'wp-last-modified-info' ); ?></div>
            <div id="saveMessage" class="successModal" style="display:none;"><p><?php _e( 'Settings Saved Successfully!', 'wp-last-modified-info' ); ?></p></div>
            <div style="display:none;" id="show-help">
                <h3> Do you need help with this plugin? Here are some FAQ for you: </h3><p><hr></p>
                <p><li><strong>How this plugin works?</strong></li></p>
                <p>This plugin hooks into wordpress content area and shows last modified information of posts and pages.</p>
                
                <p><li><strong>Is this plugin compatible with any themes?</strong></li></p>
                <p>Yes, this plugin is compatible with any theme.</p>
                
                <p><li><strong>What is the CSS class for posts?</strong></li></p>
                <p>CSS Class is <code>.post-last-modified</code>, for date time <code>.post-last-modified-td</code> and for author <code>.post-modified-author</code>. Add your custom style in Custom CSS field.</p>

                <p><li><strong>What is the CSS class for pages?</strong></li></p>
                <p>CSS Class is <code>.page-last-modified</code>, for date time <code>.page-last-modified-td</code> and for author <code>.page-modified-author</code>. Add your custom style in Custom CSS field.</p>
          
                <p><li><strong>What is the shortcode for pages?</strong></li></p>
                <p>Shortcode for post is <code>[lmt-post-modified-info]</code> and for page is <code>[lmt-page-modified-info]</code>. Apply this on any page to show last modified info anywhere.</p>
                
                <p><li><strong>I want to disable <code>&lt;p&gt; &lt;/p&gt;</code> tag output on posts or pages using shortcode/manual method. How can I do that?</strong></li></p>
                <p>Just select <code>&lt;span&gt;</code> tag from plugin settings and save changes. If you have select <code>&lt;p&gt;</code> tag from plugins settings then you can use <code>raw="1"</code> attribute to disable <code>&lt;p&gt; &lt;/p&gt;</code> tag output particularly on shortcodes. Example: <code>[lmt-post-modified-info raw="1"]</code> or <code>[lmt-page-modified-info raw="1"]</code></p>

                <p><li><strong>Do I need to add <code>&lt;style&gt; &lt;/style&gt;</code> tag?</strong></li></p>
                <p>No, this tag is not required, as it is already added.</p>

                <p><li><strong>How to set custom date/time format?</strong></li></p>
                <p>Go to <a href = "https://codex.wordpress.org/Formatting_Date_and_Time" target = "_blank"> WordPress Date/Time sysntax</a> page and read instructions.</p>

                <p><li><strong>How to use template tag functionality?</strong></li></p>
                <p>Models the function naming convention used by WordPress for the_modified_time / get_the_modified_time and similar functions. In this case, you have to edit your theme's template files i.e. single.php, page.php etc. and add/replace default published date function with this: &nbsp;&nbsp;
                <p><i>Displays/echos the last modified info:</i> <code>&lt;?php if ( function_exists( 'the_last_modified_info' ) ) {
                            the_last_modified_info();
			           } ?&gt;</code></p>       
                <p><i>Returns the last modified info:</i> <code>&lt;?php if ( function_exists( 'get_the_last_modified_info' ) ) {
				            get_the_last_modified_info();
			    } ?&gt;</code></p>
                </p>

                <p><li><strong>Is it possible to use shortcodes as template tags?</strong></li></p>
                <p>Yes, it is absolutely possible. Example of using the shortcode as template tags with PHP: <code>&lt;?php echo do_shortcode('[lmt-post-modified-info]'); ?&gt;</code> or <code>&lt;?php echo do_shortcode('[lmt-page-modified-info]'); ?&gt;</code>.</p>
                
                <p><li><strong>Published date is equal to modified date. What is the solution?</strong></li></p>
                <p>Sometimes you may want to show last modified date only. For that reason, post published date and modified date would be same and the last modified date will still appear on post/pages even if it’s the same as the publish date. In that case, you can set a time difference(ex. 1 day i.e. 24 hours) between post published date and modified date via custom filters.</p>
                <p><i>Create function:</i> <code>function override_time_diff() { return '86400'; // 86400 seconds i.e. 24 hours, set it according to your need }</code></p>       
                <p><i>Add filter for posts:</i> <code>add_filter( 'wplmi_date_time_diff_post', 'override_time_diff' ); // for posts</code></p>
                <p><i>Add filter for pages:</i> <code>add_filter( 'wplmi_date_time_diff_page', 'override_time_diff' ); // for pages</code></p>

                <br>
                
                <h3> My Other WordPress Plugins </h3><p><hr></p>
                <p><strong>Like this plugin? Check out my other WordPress plugins:</strong></p>
                <li><strong><a href = "https://wordpress.org/plugins/ultimate-facebook-comments/" target = "_blank">Ultimate Facebook Comments</a></strong> - Ultimate Facebook Comment Solution with instant email notification for any WordPress Website. Everything is customizable.</li>
                <li><strong><a href = "https://wordpress.org/plugins/change-wp-page-permalinks/" target = "_blank">WP Page Permalink Extension</a></strong> - Add any page extension like .html, .php, .aspx, .htm, .asp, .shtml only to wordpress pages very easily (tested on Yoast SEO).</li>
                <li><strong><a href = "https://wordpress.org/plugins/remove-wp-meta-tags/" target = "_blank">Easy Header Footer</a></strong> - Customize WP header, add custom code and enable, disable or remove the unwanted meta tags, links from the source code and many more.</li>
                <br>
            </div>
        </form>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#form-container').submit(function() {
                    $('#progressMessage').show();
                    $(".save-settings").addClass("disabled");
                    $(".save-settings").val("<?php _e( 'Saving...', 'wp-last-modified-info' ); ?>");
                    $(this).ajaxSubmit({
                        success: function() {
                            $('#progressMessage').fadeOut();
                            $('#saveMessage').show().delay(4000).fadeOut();
                            $(".save-settings").removeClass("disabled");
                            $(".save-settings").val("<?php _e( 'Save Settings', 'wp-last-modified-info' ); ?>");
                        }
                    });
                    return false;
                });
            });
        </script>
        <div id="show-tools" style="display:none;">
            <h3> <?php _e( 'Plugin Tools', 'wp-last-modified-info' ); ?> </h3><p><hr></p>
                <span><strong><?php _e( 'Export Settings', 'wp-last-modified-info' ); ?></strong></span>
				<p><?php _e( 'Export the plugin settings for this site as a .json file. This allows you to easily import the configuration into another site.', 'wp-last-modified-info' ); ?></p>
				<form method="post">
					<p><input type="hidden" name="lmt_export_action" value="lmt_export_settings" /></p>
					<p>
						<?php wp_nonce_field( 'lmt_export_nonce', 'lmt_export_nonce' ); ?>
						<?php submit_button( __( 'Export Settings', 'wp-last-modified-info' ), 'secondary', 'submit', false ); ?>
					</p>
				</form>
            <p><hr></p>
                <span><strong><?php _e( 'Import Settings', 'wp-last-modified-info' ); ?></strong></span>
				<p><?php _e( 'Import the plugin settings from a .json file. This file can be obtained by exporting the settings on another site using the form above.', 'wp-last-modified-info' ); ?></p>
				<form method="post" enctype="multipart/form-data">
					<p><input type="file" name="import_file" accept=".json"/></p>
					<p>
						<input type="hidden" name="lmt_import_action" value="lmt_import_settings" />
						<?php wp_nonce_field( 'lmt_import_nonce', 'lmt_import_nonce' ); ?>
						<?php submit_button( __( 'Import Settings', 'wp-last-modified-info' ), 'secondary', 'submit', false ); ?>
					</p>
				</form>
            <p><hr></p>
                <span><strong><?php _e( 'Reset Settings', 'wp-last-modified-info' ); ?></strong></span>
				<p style="color:red"><strong>WARNING: </strong><?php _e( 'Resetting will delete all custom options to the default settings of the plugin in your database.', 'wp-last-modified-info' ); ?></p>
				<form method="post">
					<p><input type="hidden" name="lmt_reset_action" value="lmt_reset_settings" /></p>
	                <p>
						<?php wp_nonce_field( 'lmt_reset_nonce', 'lmt_reset_nonce' ); ?>
						<?php submit_button( __( 'Reset Settings', 'wp-last-modified-info' ), 'secondary', 'submit', false ); ?>
				    </p>
				</form>
            <br>
        </div>
    </div>
</div>