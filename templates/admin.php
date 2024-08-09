<?php
/**
 * The Main dashboard file.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Templates
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */
?>

<div id="wplmi-nav-container" class="wplmi-admin-toolbar">
	<h2>WP Last Modified Info<span class="title-count"><?= esc_html( $this->version ); ?></span></h2>

    <a href="#post" class="wplmi-tab is-active" id="wplmi-tab-post"><?php esc_html_e( 'Posts', 'wp-last-modified-info' ); ?></a>
    <a href="#template" class="wplmi-tab" id="wplmi-tab-template"><?php esc_html_e( 'Template Tag', 'wp-last-modified-info' ); ?></a>
    <a href="#schema" class="wplmi-tab" id="wplmi-tab-schema"><?php esc_html_e( 'Schema', 'wp-last-modified-info' ); ?></a>
    <a href="#notification" class="wplmi-tab" id="wplmi-tab-notification"><?php esc_html_e( 'Notification', 'wp-last-modified-info' ); ?></a>
    <a href="#misc" class="wplmi-tab" id="wplmi-tab-misc"><?php esc_html_e( 'Misc.', 'wp-last-modified-info' ); ?></a>
    <a href="#tools" class="wplmi-tab" id="wplmi-tab-tools"><?php esc_html_e( 'Tools', 'wp-last-modified-info' ); ?></a>
    <a href="#help" class="wplmi-tab" id="wplmi-tab-help"><?php esc_html_e( 'Help', 'wp-last-modified-info' ); ?></a>

    <div class="top-sharebar">
        <a class="share-btn rate-btn no-popup" href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?filter=5#new-post" target="_blank" title="<?php esc_html_e( 'Please rate 5 stars if you like WP Last Modified Info', 'wp-last-modified-info' ); ?>" rel="noopener"><span class="dashicons dashicons-star-filled"></span> <?php esc_html_e( 'Rate 5 stars', 'wp-last-modified-info' ); ?></a>
        <a class="share-btn twitter" href="https://twitter.com/intent/tweet?text=Checkout%20WP%20Last%20Modified%20Info%20a%20%23WordPress%20plugin%20that%20shows%20last%20update%20date%20and%20time%20on%20pages%20and%20posts%20very%20easily%20with%20%40Gutenberg%20block%20integration.&tw_p=tweetbutton&url=https://wordpress.org/plugins/wp-last-modified-info/&via=im_sayaan" target="_blank" rel="noopener"><span class="dashicons dashicons-twitter"></span> <?php esc_html_e( 'Tweet', 'wp-last-modified-info' ); ?></a>
        <a class="share-btn facebook" href="https://www.facebook.com/sharer/sharer.php?u=https://wordpress.org/plugins/wp-last-modified-info/&quote=Checkout%20WP%20Last%20Modified%20Info%20a%20%23WordPress%20plugin%20that%20shows%20last%20update%20date%20and%20time%20on%20pages%20and%20posts%20very%20easily%20with%20%40Gutenberg%20block%20integration.%20https%3A//wordpress.org/plugins/wp-last-modified-info/" target="_blank" rel="noopener"><span class="dashicons dashicons-facebook"></span> <?php esc_html_e( 'Share', 'wp-last-modified-info' ); ?></a>
    </div>
</div>
<div class="wrap wplmi-wrap" data-reload="no">
    <h2 style="display: none;"></h2>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content" class="wplmi-metabox">
                <form id="wplmi-settings-form" method="post" action="options.php">
                    <?php
                        settings_fields( 'wplmi_plugin_settings_fields' );

                        $this->doSettingsSection( [
                            'id'          => 'wplmi-post',
                            'class'       => 'wplmi-post',
                            'title'       => __( 'Post Settings', 'wp-last-modified-info' ),
                            'description' => __( 'Control the Auto Insertion of ast Modified Info here.', 'wp-last-modified-info' ),
                            'name'        => 'wplmi_plugin_post_option',
                        ] );

                        $this->doSettingsSection( [
                            'id'          => 'wplmi-template',
                            'class'       => 'wplmi-template d-none',
                            'title'       => __( 'Template Tag', 'wp-last-modified-info' ),
                            'description' => __( 'Use the template tag in your theme template files or Gutenberg Block on your posts to display last modified info.', 'wp-last-modified-info' ),
                            'name'        => 'wplmi_plugin_template_tag_option',
                        ] );

                        $this->doSettingsSection( [
                            'id'          => 'wplmi-schema',
                            'class'       => 'wplmi-schema d-none',
                            'title'       => __( 'Schema Options', 'wp-last-modified-info' ),
                            'description' => __( 'Configure the JSON-LD Structured Data settings here.', 'wp-last-modified-info' ),
                            'name'        => 'wplmi_plugin_schema_option',
                        ] );

                        $this->doSettingsSection( [
                            'id'          => 'wplmi-notification',
                            'class'       => 'wplmi-notification d-none',
                            'title'       => __( 'Email Notification', 'wp-last-modified-info' ),
                            'description' => __( 'Configure the settings to get Email Notiifcation after post update.', 'wp-last-modified-info' ),
                            'name'        => 'wplmi_plugin_notification_option',
                        ] );

                        $this->doSettingsSection( [
                            'id'          => 'wplmi-misc',
                            'class'       => 'wplmi-misc d-none',
                            'title'       => __( 'Miscellaneous Options', 'wp-last-modified-info' ),
                            'description' => __( 'Change some uncommon but essential settings here.', 'wp-last-modified-info' ),
                            'name'        => 'wplmi_plugin_misc_option',
                        ] );
                    ?>
                </form>
                <div id="wplmi-tools" class="postbox wplmi-tools d-none">
                    <div class="wplmi-metabox-holder">
                        <div class="wplmi-metabox-td">
                            <h3 class="wplmi-metabox-title"><?php esc_html_e( 'Plugin Tools', 'wp-last-modified-info' ); ?></h3>
                            <p class="wplmi-metabox-description"><?php esc_html_e( 'Perform database related actions here.', 'wp-last-modified-info' ); ?></p>
                        </div>
                    </div>
                    <div class="inside wplmi-inside" style="padding: 10px 20px;">
                        <div class="wplmi-tools-box">
                            <span><?php esc_html_e( 'Toogle Disable Update Option', 'wp-last-modified-info' ); ?></span>
                            <p><?php esc_html_e( 'This will enable or disable "Disable Update" option for all posts, pages and CPTs automatically.', 'wp-last-modified-info' ); ?></p>
                            <p><input type="button" class="button button-large button-secondary default wplmi-reset" data-action="wplmi_process_set_meta" data-type="check" data-notice="<?php esc_attr_e( 'It will enable post modified info output on all activated post types. Do you want to continue?', 'wp-last-modified-info' ); ?>" data-success="<?php esc_attr_e( 'Success! Requested Action processed successfully.', 'wp-last-modified-info' ); ?>" data-process="<?php esc_attr_e( 'Processing...', 'wp-last-modified-info' ); ?>" value="<?php esc_attr_e( 'Check All', 'wp-last-modified-info' ); ?>">
                            <input type="button" class="button button-large button-secondary default wplmi-reset" data-action="wplmi_process_set_meta" data-type="uncheck" data-notice="<?php esc_attr_e( 'It will disable post modified info output on all activated post types. Do you want to continue?', 'wp-last-modified-info' ); ?>" data-success="<?php esc_attr_e( 'Success! Requested Action processed successfully.', 'wp-last-modified-info' ); ?>" data-process="<?php esc_attr_e( 'Processing...', 'wp-last-modified-info' ); ?>" value="<?php esc_attr_e( 'Un-Check All', 'wp-last-modified-info' ); ?>"></p>
                        </div>
                        <div class="wplmi-tools-box">
                            <span><?php esc_html_e( 'Export Settings', 'wp-last-modified-info' ); ?></span>
                            <p><?php esc_html_e( 'Export the plugin settings for this site as a .json file. This allows you to easily import the configuration into another site.', 'wp-last-modified-info' ); ?></p>
                            <form method="post">
                                <p>
                                    <input type="hidden" name="wplmi_export_action" value="wplmi_export_settings" />
                                    <?php wp_nonce_field( 'wplmi_export_nonce', 'wplmi_export_nonce' ); ?>
                                    <?php submit_button( __( 'Export Settings', 'wp-last-modified-info' ), 'button-large button-secondary default', 'wplmi-export', false ); ?>
                                    <input type="button" class="button button-large button-secondary default wplmi-copy" data-action="wplmi_process_copy_data" value="<?php esc_attr_e( 'Copy', 'wp-last-modified-info' ); ?>" style="margin-left: -1px;">
                                    <span class="wplmi-copied" style="padding-left: 6px;display: none;color: #068611;"><?php esc_html_e( 'Copied!', 'wp-last-modified-info' ); ?></span>
                                </p>
                            </form>
                        </div>
                        <div class="wplmi-tools-box">
                            <span><?php esc_html_e( 'Import Settings', 'wp-last-modified-info' ); ?></span>
                            <p><?php esc_html_e( 'Import the plugin settings from a .json file. This file can be obtained by exporting the settings on another site using the form above.', 'wp-last-modified-info' ); ?></p>
                            <form method="post" enctype="multipart/form-data">
                                <p><input type="file" name="import_file" accept=".json"/></p>
                                <p>
                                    <input type="hidden" name="wplmi_import_action" value="wplmi_import_settings" />
                                    <?php wp_nonce_field( 'wplmi_import_nonce', 'wplmi_import_nonce' ); ?>
                                    <?php submit_button( __( 'Import Settings', 'wp-last-modified-info' ), 'button-large button-secondary default', 'wplmi-import', false ); ?>
                                    <input type="button" class="button button-large button-secondary default wplmi-paste" data-action="wplmi_process_paste_data" value="<?php esc_attr_e( 'Paste', 'wp-last-modified-info' ); ?>">
                                </p>
                            </form>
                        </div>
                        <div class="wplmi-tools-box">
                            <span><?php esc_html_e( 'Reset Settings', 'wp-last-modified-info' ); ?></span>
                            <p style="color: #ff0000;"><strong><?php esc_html_e( 'WARNING:', 'wp-last-modified-info' ); ?> </strong><?php esc_html_e( 'Resetting will delete all custom options to the default settings of the plugin in your database.', 'wp-last-modified-info' ); ?></p>
                            <p><input type="button" class="button button-large button-secondary default wplmi-reset" data-action="wplmi_process_delete_plugin_data" data-type="delete" data-notice="<?php esc_attr_e( 'It will delete all the data relating to this plugin settings. You have to re-configure this plugin again. Do you want to continue?', 'wp-last-modified-info' ); ?>" data-success="<?php esc_attr_e( 'Success! Plugin Settings reset successfully.', 'wp-last-modified-info' ); ?>" data-process="<?php esc_attr_e( 'Deleting...', 'wp-last-modified-info' ); ?>" value="<?php esc_attr_e( 'Reset All Settings', 'wp-last-modified-info' ); ?>"></p>
                        </div>
                    </div>
                </div>
                <div id="wplmi-help" class="postbox wplmi-help d-none">
                    <div class="wplmi-metabox-holder">
                        <div class="wplmi-metabox-td">
                            <h3 class="wplmi-metabox-title">Help</h3>
                            <p class="wplmi-metabox-description"><?php esc_html_e( 'Do you need help with this plugin? Here are some FAQ for you.', 'wp-last-modified-info' ); ?></p>
                        </div>
                    </div>
                    <div class="inside">
                        <ol class="help-faq">
                            <li>
                                <?php esc_html_e( 'How this plugin works?', 'wp-last-modified-info' ); ?>
                                <p><?php esc_html_e( 'This plugin hooks into WordPress content area and shows last modified information of posts and pages.', 'wp-last-modified-info' ); ?></p>
                            </li>
                            <li>
                                <?php esc_html_e( 'Is this plugin compatible with any themes?', 'wp-last-modified-info' ); ?>
                                <p><?php esc_html_e( 'Yes, this plugin is compatible with any theme. But Replace Post Meta Option may not be compatible with some theme. Please check before using this option.', 'wp-last-modified-info' ); ?></p>
                            </li>
                            <li>
                                <?php printf(
                                /* translators: %s: code html tag */
                                esc_html__( 'Do I need to add %s tag?', 'wp-last-modified-info' ), '<code>&lt;style&gt; &lt;/style&gt;</code>' ); ?>
                                <p><?php esc_html_e( 'No, this tag is not required, as it is already added. You just need to add only CSS Codes.', 'wp-last-modified-info' ); ?></p>
                            </li>
                            <li>
                                <?php esc_html_e( 'How to set custom date/time format?', 'wp-last-modified-info' ); ?>
                                <p><?php printf(
                                /* translators: %s: html tags */
                                esc_html__( 'Go to %1$sWordPress Date/Time Syntax%2$s page and read instructions about Date/Time Syntax.', 'wp-last-modified-info' ), '<a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank">', '</a>' ); ?></p>
                            </li>
                            <li>
                                <?php esc_html_e( 'How to use template tag functionality?', 'wp-last-modified-info' ); ?>
                                <p><?php esc_html_e( 'Models the function naming convention used by WordPress for the_modified_time / get_the_modified_time and similar functions. In this case, you have to edit your theme\'s template files i.e. single.php, page.php etc. and add/replace default published date function with this:', 'wp-last-modified-info' ); ?> &nbsp;&nbsp;
                                <p><em><?php esc_html_e( 'Displays/echos the last modified info:', 'wp-last-modified-info' ); ?></em> <code>&lt;?php if ( function_exists( 'the_last_modified_info' ) ) {
                                the_last_modified_info();
                                } ?&gt;</code></p>
                                <p><em><?php esc_html_e( 'Returns the last modified info:', 'wp-last-modified-info' ); ?></em> <code>&lt;?php if ( function_exists( 'get_the_last_modified_info' ) ) {
                                get_the_last_modified_info();
                                } ?&gt;</code></p></p>
                            </li>
                            <li><?php esc_html_e( 'How to use shortcodes?', 'wp-last-modified-info' ); ?>
                                <p><?php printf(
                                /* translators: %s: shortcodes */
                                esc_html__( 'You can insert the last modified info by simply using the shortcode. Shortcode for posts/pages/custom post types is %1$s. To enter the shortcode directly into templates using PHP, use %2$s for any post types. You can use %3$s to display global site modified info on website frontend.', 'wp-last-modified-info' ), '<code>[lmt-post-modified-info]</code>', '<code>echo do_shortcode( &#39;[lmt-post-modified-info]&#39; );</code>', '<code>[lmt-site-modified-info]</code>' ); ?></p>
                            </li>
                            <li><?php esc_html_e( 'Is it possible to show last modified info to Search Engines and keep hidden form visitors?', 'wp-last-modified-info' ); ?>
                                <p><?php esc_html_e( 'Yes, it is possible. Just Enable JSON-LD Markup type from Schema Tab and save settings.', 'wp-last-modified-info' ); ?></p>
                            </li>
                        </ol>
                    </div><hr>
                    <div class="inside">
                        <ul class="my-plugins">
                            <h2><?php esc_html_e( 'My Other WordPress Plugins', 'wp-last-modified-info' ); ?></h2>
                            <p><strong><?php esc_html_e( 'Like this plugin? Check out my other WordPress plugins:', 'wp-last-modified-info' ); ?></strong></p>
                            <li><a href="https://wordpress.org/plugins/wp-auto-republish/" target="_blank" rel="noopener">RevivePress - Keep your Old Content Evergreen</a> - <?php esc_html_e( 'Automatically republish you old evergreen content to grab better SEO and share them of Social Media to boost your traffic.', 'wp-last-modified-info' ); ?></li>
                            <li><a href="https://wordpress.org/plugins/migrate-wp-cron-to-action-scheduler/" target="_blank" rel="noopener">Advanced Cron Scheduler for WordPress</a> - <?php esc_html_e( 'It alters the way that WordPress core runs cron events using the Action Scheduler Library.', 'wp-last-modified-info' ); ?></li>
                            <li><a href="https://wordpress.org/plugins/ultimate-facebook-comments/" target="_blank" rel="noopener">Ultimate Social Comments - Notification & Lazy Load</a> - <?php esc_html_e( 'Ultimate Facebook Comment Solution with instant email notification for any WordPress Website.', 'wp-last-modified-info' ); ?></li>
                            <li><a href="https://wordpress.org/plugins/change-wp-page-permalinks/" target="_blank" rel="noopener">WP Page Permalink Extension</a> - <?php esc_html_e( 'Add any page extension like .html, .php, .aspx, .htm, .asp, .shtml only to WordPress pages very easily.', 'wp-last-modified-info' ); ?></li>
                            <li><a href="https://wordpress.org/plugins/simple-posts-ticker/" target="_blank" rel="noopener">Simple Posts Ticker - Easy, Lightweight & Flexible</a> - <?php esc_html_e( 'Simple Posts Ticker is a small tool that shows your most recent posts in a marquee style.', 'wp-last-modified-info' ); ?></li>
                        </ul>
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
                            <option value=""><?php esc_html_e( 'Custom', 'wp-last-modified-info' ); ?></option>
                        </select></p>
                        <a class="button button-primary buy-coffee-btn" style="margin-left: 2px;" href="https://www.paypal.me/iamsayan/10usd" rel="noopener" data-link="https://www.paypal.me/iamsayan/" target="_blank"><?php esc_html_e( 'Buy me a coffee!', 'wp-last-modified-info' ); ?></a>
                    </div>
                    <span class="coffee-heading"><?php esc_html_e( 'Buy me a coffee!', 'wp-last-modified-info' ); ?></span>
                    <p style="text-align: justify;"><?php printf(
                        /* translators: %s: plugin name */
                        esc_html__( 'Thank you for using %s. If you found the plugin useful buy me a coffee! Your donation will motivate and make me happy for all the efforts. You can donate via PayPal.', 'wp-last-modified-info' ), '<strong>WP Last Modified Info v' . esc_html( $this->version ) . '</strong>' ); ?></strong>
                    </p>
                    <p style="text-align: justify; font-size: 12px; font-style: italic;">Developed with <span style="color:#e25555;">♥</span> by <a href="https://www.sayandatta.co.in" target="_blank" rel="noopener" style="font-weight: 500;">Sayan Datta</a> | <a href="https://www.sayandatta.co.in/contact/" target="_blank" rel="noopener" style="font-weight: 500;">Hire Me</a> | <a href="https://github.com/iamsayan/wp-last-modified-info" target="_blank" rel="noopener" style="font-weight: 500;">GitHub</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info" target="_blank" rel="noopener" style="font-weight: 500;">Support</a> | <a href="https://translate.wordpress.org/projects/wp-plugins/wp-last-modified-info" target="_blank" rel="noopener" style="font-weight: 500;">Translate</a> | <a href="https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?filter=5#new-post" target="_blank" rel="noopener" style="font-weight: 500;">Rate it</a> (<span style="color:#ffa000;">&#9733;&#9733;&#9733;&#9733;&#9733;</span>) on WordPress.org, if you like this plugin.</p>
                </div>
            </div>
        </div>
    </div>
</div>
