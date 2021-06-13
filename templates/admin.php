<?php
/**
 * The Main dashboard file.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Templates
 * @author     Sayan Datta <hello@sayandatta.in>
 */
?>

<div class="wrap">
    <div class="head-wrap">
        <h1 class="title"><?php echo $this->name; ?><span class="title-count"><?php echo $this->version; ?></span></h1>
        <div><?php _e( 'WP Last Modified Info is a small tool that shows last update date and time on pages and posts very easily.', 'wp-last-modified-info' ); ?></div>
        <div class="top-sharebar">
            <a class="share-btn rate-btn" href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/#new-post" target="_blank" title="Please rate 5 stars if you like <?php echo $this->name; ?>"><span class="dashicons dashicons-star-filled"></span> <?php _e( 'Rate 5 stars', 'wp-last-modified-info' ); ?></a>
            <a class="share-btn twitter" href="https://twitter.com/intent/tweet?text=Checkout%20WP%20Last%20Modified%20Info v<?php echo $this->version; ?>,%20a%20%23WordPress%20plugin%20that%20shows%20last%20update%20date%20and%20time%20on%20pages%20and%20posts%20very%20easily.&tw_p=tweetbutton&url=https://wordpress.org/plugins/wp-last-modified-info/&via=im_sayaan" target="_blank"><span class="dashicons dashicons-twitter"></span> <?php _e( 'Share on Twitter', 'wp-last-modified-info' ); ?></a>
            <a class="share-btn facebook" href="https://www.facebook.com/sharer/sharer.php?u=https://wordpress.org/plugins/wp-last-modified-info/" target="_blank"><span class="dashicons dashicons-facebook"></span> <?php _e( 'Share on Facebook', 'wp-auto-republish' ); ?></a>
        </div>
    </div>
    <div id="nav-container" class="nav-tab-wrapper">
        <a href="#post" class="nav-tab active" id="post"><span class="dashicons dashicons-admin-post" style="padding-top: 2px;"></span> <?php _e( 'Post Options', 'wp-last-modified-info' ); ?></a>
        <a href="#template" class="nav-tab" id="template"><span class="dashicons dashicons-tag" style="padding-top: 2px;"></span> <?php _e( 'Template Tags', 'wp-last-modified-info' ); ?></a>
        <a href="#schema" class="nav-tab" id="schema"><span class="dashicons dashicons-editor-code" style="padding-top: 2px;"></span> <?php _e( 'Schema', 'wp-last-modified-info' ); ?></a>
        <a href="#notification" class="nav-tab" id="notification"><span class="dashicons dashicons-email" style="padding-top: 2px;"></span> <?php _e( 'Notification', 'wp-last-modified-info' ); ?></a>
        <a href="#misc" class="nav-tab" id="misc"><span class="dashicons dashicons-screenoptions" style="padding-top: 2px;"></span> <?php _e( 'Misc. Options', 'wp-last-modified-info' ); ?></a>
        <a href="#tools" class="nav-tab" id="tools"><span class="dashicons dashicons-admin-tools" style="padding-top: 2px;"></span> <?php _e( 'Tools', 'wp-last-modified-info' ); ?></a>
        <a href="#help" class="nav-tab" id="help"><span class="dashicons dashicons-editor-help" style="padding-top: 2px;"></span> <?php _e( 'Help', 'wp-last-modified-info' ); ?></a>
    </div>
    <div id="wplmi-form-area">
        <div id="wplmi-form" class="wplmi-display">
            <form id="form-container" method="post" action="options.php">
                <?php settings_fields( 'wplmi_plugin_settings_fields' ); ?>
                <div id="wplmi-post" class="wplmi-metabox">
                    <?php do_settings_sections( 'wplmi_plugin_post_option' ); ?>
                    <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings', 'wplmi-save-post' ); ?>
                </div>
                <div style="display: none;" id="wplmi-template" class="wplmi-metabox">
                    <?php do_settings_sections( 'wplmi_plugin_template_tag_option' ); ?>
                    <br><b><?php _e( 'Note:', 'wp-last-modified-info' ); ?></b> <i><?php _e( 'Always backup .php files before making any changes, the backup file comes in handy for restoring the default file in case WordPress goes crazy.', 'wp-last-modified-info' ); ?></i>
                    <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings', 'wplmi-save-tt' ); ?>
                </div>
                <div style="display: none;" id="wplmi-schema" class="wplmi-metabox">
                    <?php do_settings_sections( 'wplmi_plugin_schema_option' ); ?>
                    <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings', 'wplmi-save-schema' ); ?>
                </div>
                <div style="display: none;" id="wplmi-notification" class="wplmi-metabox">
                    <?php do_settings_sections( 'wplmi_plugin_notification_option' ); ?>
                    <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings', 'wplmi-save-notification' ); ?>
                </div>
                <div style="display: none;" id="wplmi-misc" class="wplmi-metabox">
                    <?php do_settings_sections( 'wplmi_plugin_misc_option' ); ?>
                    <?php submit_button( __( 'Save Settings', 'wp-last-modified-info' ), 'primary save-settings', 'wplmi-save-misc' ); ?>
                </div>
            </form>
            <div style="display: none;" id="wplmi-help" class="wplmi-metabox">
                <div class="help-container">
                    <h2><?php _e( 'Do you need help with this plugin? Here are some FAQ for you:', 'wp-last-modified-info' ); ?></h2>
                    <ol class="help-faq">
                        <p><li><?php _e( 'How this plugin works?', 'wp-last-modified-info' ); ?></li>
                        <?php _e( 'This plugin hooks into wordpress content area and shows last modified information of posts and pages.', 'wp-last-modified-info' ); ?></p>
                    
                        <p><li><?php _e( 'Is this plugin compatible with any themes?', 'wp-last-modified-info' ); ?></li>
                        <?php _e( 'Yes, this plugin is compatible with any theme. But Replace Post Meta Option may not be compatible with some theme. Please check before using this option.', 'wp-last-modified-info' ); ?></p>
                    
                        <p><li><?php printf( 
                            /* translators: %s: code html tag */
                            __( 'Do I need to add %s tag?', 'wp-last-modified-info' ), '<code>&lt;style&gt; &lt;/style&gt;</code>' ); ?></li>
                        <?php _e( 'No, this tag is not required, as it is already added. You just need to add only CSS Codes.', 'wp-last-modified-info' ); ?></p>
                    
                        <p><li><?php _e( 'How to set custom date/time format?', 'wp-last-modified-info' ); ?></li>
                        <?php printf( 
                            /* translators: %s: html tags */
                            __( 'Go to %1$sWordPress Date/Time Syntax%2$s page and read instructions about Date/Time Syntax.', 'wp-last-modified-info' ), '<a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank">', '</a>' ); ?></p>
                    
                        <p><li><?php _e( 'How to use template tag functionality?', 'wp-last-modified-info' ); ?></li>
                        <?php _e( 'Models the function naming convention used by WordPress for the_modified_time / get_the_modified_time and similar functions. In this case, you have to edit your theme\'s template files i.e. single.php, page.php etc. and add/replace default published date function with this:', 'wp-last-modified-info' ); ?> &nbsp;&nbsp;
                        <p><i><?php _e( 'Displays/echos the last modified info:', 'wp-last-modified-info' ); ?></i> <code>&lt;?php if ( function_exists( 'the_last_modified_info' ) ) {
                            the_last_modified_info();
		                } ?&gt;</code></p>       
                        <p><i><?php _e( 'Returns the last modified info:', 'wp-last-modified-info' ); ?></i> <code>&lt;?php if ( function_exists( 'get_the_last_modified_info' ) ) {
		        	        get_the_last_modified_info();
		                } ?&gt;</code></p></p>
                    
                        <p><li><?php _e( 'How to use shortcodes?', 'wp-last-modified-info' ); ?></li>
                        <?php printf( 
                            /* translators: %s: shortcodes */
                            __( 'You can insert the last modified info by simply using the shortcode. Shortcode for posts/pages/custom post types is %1$s. To enter the shortcode directly into templates using PHP, use %2$s for any post types. You can use %3$s to display global site modified info on website frontend.', 'wp-last-modified-info' ), '<code>[lmt-post-modified-info]</code>', '<code>echo do_shortcode( &#39;[lmt-post-modified-info]&#39; );</code>', '<code>[lmt-site-modified-info]</code>' ); ?></p>
    
                        <p><li><?php _e( 'Is it possible to show last modified info to Search Engines and keep hidden form visitors?', 'wp-last-modified-info' ); ?></li>
                        <?php _e( 'Yes, it is possible. Just Enable JSON-LD Markup type from Schema Tab and save settings.', 'wp-last-modified-info' ); ?></p>
                    </ol>
                </div>
                <div class="help-container">
                    <h2><?php _e( 'My Other WordPress Plugins', 'wp-last-modified-info' ); ?></h2>
                    <p><strong><?php _e( 'Like this plugin? Check out my other WordPress plugins:', 'wp-last-modified-info' ); ?></strong></p>
                    <li><strong><a href = "https://wordpress.org/plugins/wp-auto-republish/" target = "_blank">WP Auto Republish</a></strong> - <?php _e( 'Automatically republish you old evergreen content to grab better SEO and share them of Social Media to boost your traffic.', 'wp-last-modified-info' ); ?></li>
                    <li><strong><a href = "https://wordpress.org/plugins/ultimate-facebook-comments/" target = "_blank">Ultimate Social Comments - Notification & Lazy Load</a></strong> - <?php _e( 'Ultimate Facebook Comment Solution with instant email notification for any WordPress Website. Everything is customizable.', 'wp-last-modified-info' ); ?></li>
                    <li><strong><a href = "https://wordpress.org/plugins/change-wp-page-permalinks/" target = "_blank">WP Page Permalink Extension</a></strong> - <?php _e( 'Add any page extension like .html, .php, .aspx, .htm, .asp, .shtml only to wordpress pages very easily (tested on Yoast SEO).', 'wp-last-modified-info' ); ?></li>
                    <li><strong><a href = "https://wordpress.org/plugins/simple-posts-ticker/" target = "_blank">Simple Posts Ticker - Easy, Lightweight & Flexible</a></strong> - <?php _e( 'Simple Posts Ticker is a small tool that shows your most recent posts in a marquee style.', 'wp-last-modified-info' ); ?></li>
                    <li><strong><a href = "https://wordpress.org/plugins/rzp-woocommerce/" target = "_blank">Razorpay Payment Gateway for WooCommerce</a></strong> - <?php _e( 'This is the Razorpay, a Indian Payment Gateway plugin for WooCommerce based on Razorpay Payment Links.', 'wp-last-modified-info' ); ?></li>
                    <li><strong><a href = "https://wordpress.org/plugins/migrate-wp-cron-to-action-scheduler/" target = "_blank">Migrate WP Cron to Action Scheduler</a></strong> - <?php _e( 'The Migrate WP Cron to Action Scheduler plugin does alter the way that WordPress core runs cron events using the Action Scheduler Library.', 'wp-last-modified-info' ); ?></li>
                </div>
            </div>
            <div id="wplmi-tools" style="display: none;" class="wplmi-metabox">
                <h2><?php _e( 'Plugin Tools', 'wp-last-modified-info' ); ?></h2>
                <div>
                    <strong><?php _e( 'Check or Un-Check <i>Disable Update</i> Option', 'wp-last-modified-info' ); ?></strong>
		    	    <p><?php _e( 'This will enable or disable "Disable Update" option for all posts, pages and CPTs automatically.', 'wp-last-modified-info' ); ?></p>
		    		<p><input type="button" class="button button-secondary wplmi-reset" data-action="wplmi_process_set_meta" data-type="check" data-notice="<?php _e( 'It will enable post modified info output on all activated post types. Do you want to continue?', 'wp-last-modified-info' ); ?>" data-success="<?php _e( 'Success! Requested Action processed successfully.', 'wp-last-modified-info' ); ?>" data-process="<?php _e( 'Processing...', 'wp-last-modified-info' ); ?>" value="<?php _e( 'Check All', 'wp-last-modified-info' ); ?>">
                    <input type="button" class="button button-secondary wplmi-reset" data-action="wplmi_process_set_meta" data-type="uncheck" data-notice="<?php _e( 'It will disable post modified info output on all activated post types. Do you want to continue?', 'wp-last-modified-info' ); ?>" data-success="<?php _e( 'Success! Requested Action processed successfully.', 'wp-last-modified-info' ); ?>" data-process="<?php _e( 'Processing...', 'wp-last-modified-info' ); ?>" value="<?php _e( 'Un-Check All', 'wp-last-modified-info' ); ?>"></p>
                </div><hr>
                <div>
                    <span><strong><?php _e( 'Export Settings', 'wp-last-modified-info' ); ?></strong></span>
		    		<p><?php _e( 'Export the plugin settings for this site as a .json file. This allows you to easily import the configuration into another site.', 'wp-last-modified-info' ); ?></p>
		    		<form method="post">
		    			<p><input type="hidden" name="wplmi_export_action" value="wplmi_export_settings" />
                            <?php wp_nonce_field( 'wplmi_export_nonce', 'wplmi_export_nonce' ); ?>
		    				<?php submit_button( __( 'Export Settings', 'wp-last-modified-info' ), 'secondary', 'wplmi-export', false ); ?>
                            <input type="button" class="button wplmi-copy" data-action="wplmi_process_copy_data" value="<?php _e( 'Copy', 'wp-last-modified-info' ); ?>" style="margin-left: -1px;">
                            <span class="wplmi-copied" style="padding-left: 6px;display: none;color: #068611;"><?php _e( 'Copied!', 'wp-last-modified-info' ); ?></span>
                        </p>
		    		</form>
                </div><hr>
                <div>
                    <span><strong><?php _e( 'Import Settings', 'wp-last-modified-info' ); ?></strong></span>
		    		<p><?php _e( 'Import the plugin settings from a .json file. This file can be obtained by exporting the settings on another site using the form above.', 'wp-last-modified-info' ); ?></p>
		    		<form method="post" enctype="multipart/form-data">
		    			<p><input type="file" name="import_file" accept=".json"/></p>
		    			<p>
		    				<input type="hidden" name="wplmi_import_action" value="wplmi_import_settings" />
		    				<?php wp_nonce_field( 'wplmi_import_nonce', 'wplmi_import_nonce' ); ?>
		    				<?php submit_button( __( 'Import Settings', 'wp-last-modified-info' ), 'secondary', 'wplmi-import', false ); ?>
                            <input type="button" class="button wplmi-paste" data-action="wplmi_process_paste_data" value="<?php _e( 'Paste', 'wp-last-modified-info' ); ?>">
                        </p>
                    </form>
                </div><hr>
                <div style="padding-bottom: 10px;">
                    <span><strong><?php _e( 'Reset Settings', 'wp-last-modified-info' ); ?></strong></span>
		    		<p style="color: #ff0000;"><strong><?php _e( 'WARNING:', 'wp-last-modified-info' ); ?> </strong><?php _e( 'Resetting will delete all custom options to the default settings of the plugin in your database.', 'wp-last-modified-info' ); ?></p>
		    	    <p><input type="button" class="button button-primary wplmi-reset" data-action="wplmi_process_delete_plugin_data" data-type="delete" data-notice="<?php _e( 'It will delete all the data relating to this plugin settings. You have to re-configure this plugin again. Do you want to continue?', 'wp-last-modified-info' ); ?>" data-success="<?php _e( 'Success! Plugin Settings reset successfully.', 'wp-last-modified-info' ); ?>" data-process="<?php _e( 'Deleting...', 'wp-last-modified-info' ); ?>" value="<?php _e( 'Reset All Settings', 'wp-last-modified-info' ); ?>"></p>
                </div>
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
        <p style="text-align: justify;"><?php printf( 
            /* translators: %s: plugin name */
            __( 'Thank you for using %s. If you found the plugin useful buy me a coffee! Your donation will motivate and make me happy for all the efforts. You can donate via PayPal.', 'wp-last-modified-info' ), '<strong>WP Last Modified Info v' . $this->version . '</strong>' ); ?></strong></p>
        <p style="text-align: justify; font-size: 12px; font-style: italic;">Developed with <span style="color:#e25555;">♥</span> by <a href="https://www.sayandatta.in" target="_blank" style="font-weight: 500;">Sayan Datta</a> | <a href="https://www.sayandatta.in/contact/" target="_blank" style="font-weight: 500;">Hire Me</a> | <a href="https://github.com/iamsayan/wp-last-modified-info" target="_blank" style="font-weight: 500;">GitHub</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank" style="font-weight: 500;">Support</a> | <a href="https://translate.wordpress.org/projects/wp-plugins/wp-last-modified-info" target="_blank" style="font-weight: 500;">Translate</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/#new-post" target="_blank" style="font-weight: 500;">Rate it</a> (<span style="color:#ffa000;">&#9733;&#9733;&#9733;&#9733;&#9733;</span>) on WordPress.org, if you like this plugin.</p>
    </div>
</div>