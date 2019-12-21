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
    <div class="head-wrap">
        <h1 class="title">WP Last Modified Info<span class="title-count"><?php echo LMT_PLUGIN_VERSION; ?></span></h1>
        <div><?php _e( 'WP Last Modified Info is a small tool that shows last update date and time on pages and posts very easily.', 'wp-last-modified-info' ); ?></div><hr>
        <div class="top-sharebar">
            <a class="share-btn rate-btn" href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?filter=5#new-post" target="_blank" title="<?php _e( 'Please rate 5 stars if you like WP Last Modified Info', 'wp-last-modified-info' ); ?>"><span class="dashicons dashicons-star-filled"></span> <?php _e( 'Rate 5 stars', 'wp-last-modified-info' ); ?></a>
            <a class="share-btn twitter" href="https://twitter.com/intent/tweet?text=Checkout%20WP%20Last%20Modified%20Info v<?php echo LMT_PLUGIN_VERSION; ?>,%20a%20%23WordPress%20plugin%20that%20shows%20last%20update%20date%20and%20time%20on%20pages%20and%20posts%20very%20easily.&tw_p=tweetbutton&url=https://wordpress.org/plugins/wp-last-modified-info/&via=im_sayaan" target="_blank"><span class="dashicons dashicons-twitter"></span> <?php _e( 'Tweet about WP Last Modified Info', 'wp-last-modified-info' ); ?></a>
        </div>
    </div>
    <div id="nav-container" class="nav-tab-wrapper">
        <a href="#post" class="nav-tab active" id="btn1"><span class="dashicons dashicons-admin-post" style="padding-top: 2px;"></span> <?php _e( 'Post Options', 'wp-last-modified-info' ); ?></a>
        <a href="#page" class="nav-tab" id="btn2"><span class="dashicons dashicons-admin-page" style="padding-top: 2px;"></span> <?php _e( 'Page Options', 'wp-last-modified-info' ); ?></a>
        <a href="#template-tags" class="nav-tab" id="btn3"><span class="dashicons dashicons-tag" style="padding-top: 2px;"></span> <?php _e( 'Template Tags', 'wp-last-modified-info' ); ?></a>
        <a href="#schema" class="nav-tab" id="btn4"><span class="dashicons dashicons-editor-code" style="padding-top: 2px;"></span> <?php _e( 'Schema', 'wp-last-modified-info' ); ?></a>
        <a href="#notification" class="nav-tab" id="btn5"><span class="dashicons dashicons-email" style="padding-top: 2px;"></span> <?php _e( 'Notification', 'wp-last-modified-info' ); ?></a>
        <a href="#misc" class="nav-tab" id="btn6"><span class="dashicons dashicons-screenoptions" style="padding-top: 2px;"></span> <?php _e( 'Misc. Options', 'wp-last-modified-info' ); ?></a>
        <a href="#tools" class="nav-tab" id="btn7"><span class="dashicons dashicons-admin-tools" style="padding-top: 2px;"></span> <?php _e( 'Tools', 'wp-last-modified-info' ); ?></a>
        <a href="#help" class="nav-tab" id="btn8"><span class="dashicons dashicons-editor-help" style="padding-top: 2px;"></span> <?php _e( 'Help', 'wp-last-modified-info' ); ?></a>
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
                <?php settings_fields('lmt_post_page_plugin_section'); ?>
                <div id="show-post">
                    <?php do_settings_sections('lmt_post_section'); ?>
                    <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings', 'wplmi-save-post' ); ?>
                </div>
                <div style="display:none" id="show-page">
                    <?php do_settings_sections('lmt_page_section'); ?>
                    <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings', 'wplmi-save-page' ); ?>
                </div>
                <div style="display:none" id="show-tt">
                    <?php do_settings_sections('lmt_template_tag_section'); ?>
                    <br><b><?php _e( 'Note:', 'wp-last-modified-info' ); ?></b> <i><?php _e( 'Always backup .php files before making any changes, the backup file comes in handy for restoring the default file in case WordPress goes crazy.', 'wp-last-modified-info' ); ?></i>
                    <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings', 'wplmi-save-tt' ); ?>
                </div>
                <div style="display:none" id="show-schema">
                    <?php do_settings_sections('lmt_schema_section'); ?>
                    <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings', 'wplmi-save-schema' ); ?>
                </div>
                <div style="display:none" id="show-noti">
                    <?php do_settings_sections('lmt_notification_section'); ?>
                    <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings', 'wplmi-save-notification' ); ?>
                </div>
                <div style="display:none" id="show-misc">
                    <?php do_settings_sections('lmt_misc_section'); ?>
                    <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings', 'wplmi-save-misc' ); ?>
                </div>
                <div id="progressMessage" class="progressModal" style="display:none;"><?php _e( 'Please wait...', 'wp-last-modified-info' ); ?></div>
                <div id="saveMessage" class="successModal" style="display:none;"><p><?php _e( 'Settings Saved Successfully!', 'wp-last-modified-info' ); ?></p></div>
                <div style="display:none;" id="show-help">
                    <h2><?php _e( 'Do you need help with this plugin? Here are some FAQ for you:', 'wp-last-modified-info' ); ?></h2><p><hr></p>
                    <p><li><strong><?php _e( 'How this plugin works?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php _e( 'This plugin hooks into wordpress content area and shows last modified information of posts and pages.', 'wp-last-modified-info' ); ?></p>
                    
                    <p><li><strong><?php _e( 'Is this plugin compatible with any themes?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php _e( 'Yes, this plugin is compatible with any theme.', 'wp-last-modified-info' ); ?></p>
                    
                    <p><li><strong><?php _e( 'What is the CSS class for posts?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php printf( __( 'CSS Class is %1$s, for date time %2$s and for author %3$s. Add your custom style in Custom CSS field.', 'wp-last-modified-info' ), '<code>.post-last-modified</code>', '<code>.post-last-modified-td</code>', '<code>.post-modified-author</code>' ); ?></p>
                    
                    <p><li><strong><?php _e( 'What is the CSS class for pages?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php printf( __( 'CSS Class is %1$s, for date time %2$s and for author %3$s. Add your custom style in Custom CSS field.', 'wp-last-modified-info' ), '<code>.page-last-modified</code>', '<code>.page-last-modified-td</code>', '<code>.page-modified-author</code>' ); ?></p>
                    
                    <p><li><strong><?php printf( __( 'Do I need to add %s tag?', 'wp-last-modified-info' ), '<code>&lt;style&gt; &lt;/style&gt;</code>' ); ?></strong></li></p>
                    <p><?php _e( 'No, this tag is not required, as it is already added.', 'wp-last-modified-info' ); ?></p>
    
                    <p><li><strong><?php _e( 'How to set custom date/time format?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php printf( __( 'Go to %1$s WordPress Date/Time Syntax %2$s page and read instructions.', 'wp-last-modified-info' ), '<a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank">', '</a>' ); ?></p>
                    
                    <p><li><strong><?php _e( 'How to use template tag functionality?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php _e( 'Models the function naming convention used by WordPress for the_modified_time / get_the_modified_time and similar functions. In this case, you have to edit your theme\'s template files i.e. single.php, page.php etc. and add/replace default published date function with this:', 'wp-last-modified-info' ); ?> &nbsp;&nbsp;
                    <p><i><?php _e( 'Displays/echos the last modified info:', 'wp-last-modified-info' ); ?></i> <code>&lt;?php if ( function_exists( 'the_last_modified_info' ) ) {
                                the_last_modified_info();
		    	           } ?&gt;</code></p>       
                    <p><i><?php _e( 'Returns the last modified info:', 'wp-last-modified-info' ); ?></i> <code>&lt;?php if ( function_exists( 'get_the_last_modified_info' ) ) {
		    		            get_the_last_modified_info();
		    	    } ?&gt;</code></p>
                    </p>

                    <p><li><strong><?php _e( 'How to use shortcodes?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php printf( __( 'You can insert the last modified info by simply using the shortcode. Shortcode for posts is %1$s and for page is %2$s. To enter the shortcode directly into templates using PHP, use %3$s for post and %4$s for pages.', 'wp-last-modified-info' ), '<code>[lmt-post-modified-info]</code>', '<code>[lmt-page-modified-info]</code>', '<code>echo do_shortcode( &#39;[lmt-post-modified-info]&#39; );</code>', '<code>echo do_shortcode( &#39;[lmt-page-modified-info]&#39; );</code>' ); ?>
                    
                    <p><li><strong><?php _e( 'Is it possible to show last modified info to Search Engines and keep hidden form visitors?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php _e( 'Yes, it is possible. Just Enable JSON-LD Markup type from Schema Tab and save settings.', 'wp-last-modified-info' ); ?></p>
                    
                    <br>
                    
                    <h2><?php _e( 'My Other WordPress Plugins', 'wp-last-modified-info' ); ?></h2><p><hr></p>
                    <p><strong><?php _e( 'Like this plugin? Check out my other WordPress plugins:', 'wp-last-modified-info' ); ?></strong></p>
                    <li><strong><a href = "https://wordpress.org/plugins/ultimate-facebook-comments/" target = "_blank">Ultimate Social Comments</a></strong> - <?php _e( 'Ultimate Facebook Comment Solution with instant email notification for any WordPress Website. Everything is customizable.', 'wp-last-modified-info' ); ?></li>
                    <li><strong><a href = "https://wordpress.org/plugins/wp-auto-republish/" target = "_blank">WP Auto Republish</a></strong> - <?php _e( 'Automatically republish you old evergreen content to grab better SEO.', 'wp-last-modified-info' ); ?></li>
                    <li><strong><a href = "https://wordpress.org/plugins/change-wp-page-permalinks/" target = "_blank">WP Page Permalink Extension</a></strong> - <?php _e( 'Add any page extension like .html, .php, .aspx, .htm, .asp, .shtml only to wordpress pages very easily (tested on Yoast SEO).', 'wp-last-modified-info' ); ?></li>
                    <li><strong><a href = "https://wordpress.org/plugins/simple-posts-ticker/" target = "_blank">Simple Posts Ticker</a></strong> - <?php _e( 'Simple Posts Ticker is a small tool that shows your most recent posts in a marquee style.', 'wp-last-modified-info' ); ?></li>
                    <li><strong><a href = "https://wordpress.org/plugins/remove-wp-meta-tags/" target = "_blank">Easy Header Footer</a></strong> - <?php _e( 'Customize WP header, add custom code and enable, disable or remove the unwanted meta tags, links from the source code and many more.', 'wp-last-modified-info' ); ?></li>
                    <br>
                </div>
            </form>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $('#form-container').submit(function() {
                        $('#progressMessage').show();
                        $('#saveMessage').fadeOut();
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
                <h3><?php _e( 'Plugin Tools', 'wp-last-modified-info' ); ?></h3><p><hr></p>
                    <span><strong><?php _e( 'Check/Un-Check <i>Disable Update</i> Option', 'wp-last-modified-info' ); ?></strong></span>
		    		<p><?php _e( 'This will enable or disable "Disable Update" option for all posts, pages and CPTs automatically.', 'wp-last-modified-info' ); ?></p>
		    		<?php $check = wp_nonce_url( add_query_arg( 'lmt_update_cb_action', 'check' ), 'lmt_update_cb_action_check' ); 
                    $uncheck = wp_nonce_url( add_query_arg( 'lmt_update_cb_action', 'uncheck' ), 'lmt_update_cb_action_uncheck' ); ?>
                    <p>
                        <a href="<?php echo $check; ?>" class="button button-secondary"><?php _e( 'Check All', 'wp-last-modified-info' ); ?></a>
                        <a href="<?php echo $uncheck; ?>" class="button button-secondary"><?php _e( 'Un-Check All', 'wp-last-modified-info' ); ?></a>
                    </p>
                <p><hr></p>
                    <span><strong><?php _e( 'Export Settings', 'wp-last-modified-info' ); ?></strong></span>
		    		<p><?php _e( 'Export the plugin settings for this site as a .json file. This allows you to easily import the configuration into another site.', 'wp-last-modified-info' ); ?></p>
		    		<form method="post">
		    			<p><input type="hidden" name="lmt_export_action" value="lmt_export_settings" /></p>
		    			<p>
		    				<?php wp_nonce_field( 'lmt_export_nonce', 'lmt_export_nonce' ); ?>
		    				<?php submit_button( __( 'Export Settings', 'wp-last-modified-info' ), 'secondary', 'wplmi-export', false ); ?>
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
		    				<?php submit_button( __( 'Import Settings', 'wp-last-modified-info' ), 'secondary', 'wplmi-import', false ); ?>
		    			</p>
		    		</form>
                <p><hr></p>
                    <span><strong><?php _e( 'Reset Settings', 'wp-last-modified-info' ); ?></strong></span>
		    		<p style="color:red"><strong><?php _e( 'WARNING:', 'wp-last-modified-info' ); ?> </strong><?php _e( 'Resetting will delete all custom options to the default settings of the plugin in your database.', 'wp-last-modified-info' ); ?></p>
		    		<form method="post">
		    			<p><input type="hidden" name="lmt_reset_action" value="lmt_reset_settings" /></p>
	                    <p>
		    				<?php wp_nonce_field( 'lmt_reset_nonce', 'lmt_reset_nonce' ); ?>
		    				<?php submit_button( __( 'Reset Settings', 'wp-last-modified-info' ), 'secondary', 'wplmi-reset', false ); ?>
		    		    </p>
		    		</form>
                <br>
            </div>
        </div>
    </div>
    <div class="coffee-box">
        <div class="coffee-amt-wrap">
            <p><select class="coffee-amt">
                <option value="5usd">$5</option>
                <option value="6usd">$6</option>
                <option value="7usd">$7</option>
                <option value="8usd">$8</option>
                <option value="9usd">$9</option>
                <option value="10usd" selected="selected">$10</option>
                <option value="11usd">$11</option>
                <option value="12usd">$12</option>
                <option value="13usd">$13</option>
                <option value="14usd">$14</option>
                <option value="15usd">$15</option>
                <option value=""><?php _e( 'Custom', 'wp-last-modified-info' ); ?></option>
            </select></p>
            <a class="button button-primary buy-coffee-btn" style="margin-left: 2px;" href="https://www.paypal.me/iamsayan/10usd" data-link="https://www.paypal.me/iamsayan/" target="_blank"><?php _e( 'Buy me a coffee!', 'wp-last-modified-info' ); ?></a>
        </div>
        <span class="coffee-heading"><?php _e( 'Buy me a coffee!', 'wp-last-modified-info' ); ?></span>
        <p style="text-align: justify;"><?php printf( __( 'Thank you for using %s. If you found the plugin useful buy me a coffee! Your donation will motivate and make me happy for all the efforts. You can donate via PayPal.', 'wp-last-modified-info' ), '<strong>WP Last Modified Info v' . LMT_PLUGIN_VERSION . '</strong>' ); ?></strong></p>
        <p style="text-align: justify; font-size: 12px; font-style: italic;">Developed with <span style="color:#e25555;">♥</span> by <a href="https://about.me/iamsayan" target="_blank" style="font-weight: 500;">Sayan Datta</a> | <a href="mailto:iamsayan@pm.me" target="_blank" style="font-weight: 500;">Hire Me</a> | <a href="https://github.com/iamsayan/wp-last-modified-info" target="_blank" style="font-weight: 500;">GitHub</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank" style="font-weight: 500;">Support</a> | <a href="https://translate.wordpress.org/projects/wp-plugins/wp-last-modified-info" target="_blank" style="font-weight: 500;">Translate</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?rate=5#new-post" target="_blank" style="font-weight: 500;">Rate it</a> (<span style="color:#ffa000;">&#9733;&#9733;&#9733;&#9733;&#9733;</span>) on WordPress.org, if you like this plugin.</p>
    </div>
</div>