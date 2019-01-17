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
            <a class="share-btn twitter" href="https://twitter.com/home?status=Checkout%20WP%20Last%20Modified%20Info,%20a%20%23WordPress%20plugin%20that%20shows%20last%20update%20date%20and%20time%20on%20pages%20and%20posts%20very%20easily.%20https%3A//wordpress.org/plugins/wp-last-modified-info/%20via%20%40im_sayaan" target="_blank"><span class="dashicons dashicons-twitter"></span> <?php _e( 'Tweet about WP Last Modified Info', 'wp-last-modified-info' ); ?></a>
        </div>
    </div>
    <div id="nav-container" class="nav-tab-wrapper">
        <a href="#post" class="nav-tab active" id="btn1"><span class="dashicons dashicons-admin-post" style="padding-top: 2px;"></span> <?php _e( 'Post Options', 'wp-last-modified-info' ); ?></a>
        <a href="#page" class="nav-tab" id="btn2"><span class="dashicons dashicons-admin-page" style="padding-top: 2px;"></span> <?php _e( 'Page Options', 'wp-last-modified-info' ); ?></a>
        <a href="#template-tags" class="nav-tab" id="btn3"><span class="dashicons dashicons-tag" style="padding-top: 2px;"></span> <?php _e( 'Template Tags', 'wp-last-modified-info' ); ?></a>
        <a href="#misc" class="nav-tab" id="btn4"><span class="dashicons dashicons-screenoptions" style="padding-top: 2px;"></span> <?php _e( 'Misc. Options', 'wp-last-modified-info' ); ?></a>
        <a href="#tools" class="nav-tab" id="btn5"><span class="dashicons dashicons-admin-tools" style="padding-top: 2px;"></span> <?php _e( 'Tools', 'wp-last-modified-info' ); ?></a>
        <a href="#help" class="nav-tab" id="btn6"><span class="dashicons dashicons-editor-help" style="padding-top: 2px;"></span> <?php _e( 'Help', 'wp-last-modified-info' ); ?></a>
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
                    <h3><?php _e( 'Do you need help with this plugin? Here are some FAQ for you:', 'wp-last-modified-info' ); ?></h3><p><hr></p>
                    <p><li><strong><?php _e( 'How this plugin works?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php _e( 'This plugin hooks into wordpress content area and shows last modified information of posts and pages.', 'wp-last-modified-info' ); ?></p>
                    
                    <p><li><strong><?php _e( 'Is this plugin compatible with any themes?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php _e( 'Yes, this plugin is compatible with any theme.', 'wp-last-modified-info' ); ?></p>
                    
                    <p><li><strong><?php _e( 'What is the CSS class for posts?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php printf( __( 'CSS Class is %1$s, for date time %2$s and for author %3$s. Add your custom style in Custom CSS field.', 'wp-last-modified-info' ), '<code>.post-last-modified</code>', '<code>.post-last-modified-td</code>', '<code>.post-modified-author</code>' ); ?></p>
                    
                    <p><li><strong><?php _e( 'What is the CSS class for pages?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php printf( __( 'CSS Class is %1$s, for date time %2$s and for author %3$s. Add your custom style in Custom CSS field.', 'wp-last-modified-info' ), '<code>.page-last-modified</code>', '<code>.page-last-modified-td</code>', '<code>.page-modified-author</code>' ); ?></p>
                    
                    <p><li><strong><?php _e( 'What are the shortcodes for posts and pages?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php printf( __( 'Shortcode for post is %1$s and for page is %2$s. Apply this on any page to show last modified info anywhere.', 'wp-last-modified-info' ), '<code>[lmt-post-modified-info]</code>', '<code>[lmt-page-modified-info]</code>' ); ?></p>
                    
                    <p><li><strong><?php printf( __( 'I want to disable %s tag output on posts or pages using shortcode/manual method. How can I do that?', 'wp-last-modified-info' ), '<code>&lt;p&gt; &lt;/p&gt;</code>' ); ?></strong></li></p>
                    <p><?php printf( __( 'Just select %1$s tag from plugin settings and save changes. If you have select %2$s tag from plugins settings then you can use %3$s attribute to disable %4$s tag output particularly on shortcodes. Example: %5$s or %6$s', 'wp-last-modified-info' ), '<code>&lt;span&gt;</code>', '<code>&lt;p&gt;</code>', '<code>raw="1"</code>', '<code>&lt;p&gt; &lt;/p&gt;</code>', '<code>[lmt-post-modified-info raw="1"]</code>', '<code>[lmt-page-modified-info raw="1"]</code>' ); ?></p>
                    
                    <p><li><strong><?php printf( __( 'Do I need to add %s tag?', 'wp-last-modified-info' ), '<code>&lt;style&gt; &lt;/style&gt;</code>' ); ?></strong></li></p>
                    <p><?php _e( 'No, this tag is not required, as it is already added.', 'wp-last-modified-info' ); ?></p>
    
                    <p><li><strong><?php _e( 'How to set custom date/time format?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php printf( __( 'Go to %1$s WordPress Date/Time Syntax %2$s page and read instructions.', 'wp-last-modified-info' ), '<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">', '</a>' ); ?></p>
                    
                    <p><li><strong><?php _e( 'How to use template tag functionality?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php _e( 'Models the function naming convention used by WordPress for the_modified_time / get_the_modified_time and similar functions. In this case, you have to edit your theme\'s template files i.e. single.php, page.php etc. and add/replace default published date function with this:', 'wp-last-modified-info' ); ?> &nbsp;&nbsp;
                    <p><i><?php _e( 'Displays/echos the last modified info:', 'wp-last-modified-info' ); ?></i> <code>&lt;?php if ( function_exists( 'the_last_modified_info' ) ) {
                                the_last_modified_info();
		    	           } ?&gt;</code></p>       
                    <p><i><?php _e( 'Returns the last modified info:', 'wp-last-modified-info' ); ?></i> <code>&lt;?php if ( function_exists( 'get_the_last_modified_info' ) ) {
		    		            get_the_last_modified_info();
		    	    } ?&gt;</code></p>
                    </p>
    
                    <p><li><strong><?php _e( 'Is it possible to use shortcodes as template tags?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php _e( 'Yes, it is absolutely possible. Example of using the shortcode as template tags with PHP:', 'wp-last-modified-info' ); ?> <code>&lt;?php echo do_shortcode('[lmt-post-modified-info]'); ?&gt;</code> or <code>&lt;?php echo do_shortcode('[lmt-page-modified-info]'); ?&gt;</code>.</p>
                    
                    <p><li><strong><?php _e( 'Is it possible to show last modified info to Search Engines and keep hidden form visitors?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php _e( 'Yes, it is possible. Set "Last Modified Schema Markup Type:" to "JSON-LD Markup" and "Last Modified Info Display Method:" to "Manual".', 'wp-last-modified-info' ); ?></p>
                    
                    <p><li><strong><?php _e( 'Published date is equal to modified date. What is the solution?', 'wp-last-modified-info' ); ?></strong></li></p>
                    <p><?php _e( 'Sometimes you may want to show last modified date only. For that reason, post published date and modified date would be same and the last modified date will still appear on post/pages even if it’s the same as the publish date. In that case, you can set a time difference(ex. 1 day i.e. 24 hours) between post published date and modified date via custom filters.', 'wp-last-modified-info' ); ?></p>
                    <p><i><?php _e( 'Create function:', 'wp-last-modified-info' ); ?></i> <code>function override_time_diff() { return '86400'; // 86400 seconds i.e. 24 hours, set it according to your need }</code></p>       
                    <p><i><?php _e( 'Add filter for posts:', 'wp-last-modified-info' ); ?></i> <code>add_filter( 'wplmi_date_time_diff_post', 'override_time_diff' ); // <?php _e( 'for posts', 'wp-last-modified-info' ); ?></code></p>
                    <p><i><?php _e( 'Add filter for pages:', 'wp-last-modified-info' ); ?></i> <code>add_filter( 'wplmi_date_time_diff_page', 'override_time_diff' ); // <?php _e( 'for pages', 'wp-last-modified-info' ); ?></code></p>
    
                    <br>
                    
                    <h3><?php _e( 'My Other WordPress Plugins', 'wp-last-modified-info' ); ?></h3><p><hr></p>
                    <p><strong><?php _e( 'Like this plugin? Check out my other WordPress plugins:', 'wp-last-modified-info' ); ?></strong></p>
                    <li><strong><a href = "https://wordpress.org/plugins/ultimate-facebook-comments/" target = "_blank">Ultimate Facebook Comments</a></strong> - <?php _e( 'Ultimate Facebook Comment Solution with instant email notification for any WordPress Website. Everything is customizable.', 'wp-last-modified-info' ); ?></li>
                    <li><strong><a href = "https://wordpress.org/plugins/change-wp-page-permalinks/" target = "_blank">WP Page Permalink Extension</a></strong> - <?php _e( 'Add any page extension like .html, .php, .aspx, .htm, .asp, .shtml only to wordpress pages very easily (tested on Yoast SEO).', 'wp-last-modified-info' ); ?></li>
                    <li><strong><a href = "https://wordpress.org/plugins/wp-auto-republish/" target = "_blank">WP Auto Republish</a></strong> - <?php _e( 'Automatically republish you old evergreen content to grab better SEO.', 'wp-last-modified-info' ); ?></li>
                    <li><strong><a href = "https://wordpress.org/plugins/simple-posts-ticker/" target = "_blank">Simple Posts Ticker</a></strong> - <?php _e( 'Simple Posts Ticker is a small tool that shows your most recent posts in a marquee style.', 'wp-last-modified-info' ); ?></li>
                    <li><strong><a href = "https://wordpress.org/plugins/remove-wp-meta-tags/" target = "_blank">Easy Header Footer</a></strong> - <?php _e( 'Customize WP header, add custom code and enable, disable or remove the unwanted meta tags, links from the source code and many more.', 'wp-last-modified-info' ); ?></li>
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
		    		<p style="color:red"><strong><?php _e( 'WARNING:', 'wp-last-modified-info' ); ?> </strong><?php _e( 'Resetting will delete all custom options to the default settings of the plugin in your database.', 'wp-last-modified-info' ); ?></p>
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
    <div class="coffee-box">
        <div class="coffee-amt-wrap">
            <p><select class="coffee-amt">
                <option value="2usd">$2</option>
                <option value="3usd">$3</option>
                <option value="4usd">$4</option>
                <option value="5usd" selected="selected">$5</option>
                <option value="6usd">$6</option>
                <option value="7usd">$7</option>
                <option value="8usd">$8</option>
                <option value="9usd">$9</option>
                <option value="10usd">$10</option>
                <option value="11usd">$11</option>
                <option value="12usd">$12</option>
                <option value=""><?php _e( 'Custom', 'wp-last-modified-info' ); ?></option>
            </select></p>
            <a class="button button-primary buy-coffee-btn" style="margin-left: 2px;" href="https://www.paypal.me/iamsayan/5usd" data-link="https://www.paypal.me/iamsayan/" target="_blank"><?php _e( 'Buy me a coffee!', 'wp-last-modified-info' ); ?></a>
        </div>
        <span class="coffee-heading"><?php _e( 'Buy me a coffee!', 'wp-last-modified-info' ); ?></span>
        <p style="text-align: justify;"><?php printf( __( 'Thank you for using %s. If you found the plugin useful buy me a coffee! Your donation will motivate and make me happy for all the efforts. You can donate via PayPal.', 'wp-last-modified-info' ), '<strong>WP Last Modified Info v' . LMT_PLUGIN_VERSION . '</strong>' ); ?></strong></p>
        <p style="text-align: justify; font-size: 12px; font-style: italic;">Developed with <span style="color:#e25555;">♥</span> by <a href="https://www.sayandatta.com" target="_blank" style="font-weight: 500;">Sayan Datta</a> | <a href="https://github.com/iamsayan/wp-last-modified-info" target="_blank" style="font-weight: 500;">GitHub</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank" style="font-weight: 500;">Support</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?rate=5#new-post" target="_blank" style="font-weight: 500;">Rate it</a> (<span style="color:#ffa000;">&#9733;&#9733;&#9733;&#9733;&#9733;</span>) on WordPress.org, if you like this plugin.</p>
    </div>
</div>