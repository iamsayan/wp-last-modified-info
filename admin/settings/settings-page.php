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
    <h1> <?php _e( 'WP Last Modified Info', 'wp-lmi' ); ?> <span style="font-size:12px;"><?php _e( 'Ver', 'wp-lmi' ); ?> <?php echo lmt_remove_footer_admin(); ?></span></h1>
		<div> <?php _e( 'Show last update date and time on pages and posts very easily.', 'wp-lmi' ); ?> </div><hr>
            <div id="nav-container" class="nav-tab-wrapper">
                <a href="#post" class="nav-tab active" id="btn1"><?php _e( 'Post Options', 'wp-lmi' ); ?></a>
                <a href="#page" class="nav-tab" id="btn2"><?php _e( 'Page Options', 'wp-lmi' ); ?></a>
                <a href="#template-tags" class="nav-tab" id="btn3"><?php _e( 'Template Tags', 'wp-lmi' ); ?></a>
                <a href="#misc" class="nav-tab" id="btn4"><?php _e( 'Misc. Options', 'wp-lmi' ); ?></a>
                <a href="#tools" class="nav-tab" id="btn5"><?php _e( 'Tools', 'wp-lmi' ); ?></a>
                <a href="#help" class="nav-tab" id="btn6"><?php _e( 'Help', 'wp-lmi' ); ?></a>
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
        <?php
            if ( function_exists('wp_nonce_field') ) 
	        wp_nonce_field('wp_last_modified_info'); 
           
            settings_fields('lmt_post_page_plugin_section'); ?>

            <div id="show-post"> <?php
            
                do_settings_sections('lmt_post_option');
                submit_button( __( 'Save Settings', 'wp-lmi' ), 'primary' );
            
            ?> </div>

            <div style="display:none" id="show-page"> <?php
                 
                do_settings_sections('lmt_page_option');
                submit_button( __( 'Save Settings', 'wp-lmi' ), 'primary' );

            ?> </div>

            <div style="display:none" id="show-tt"> <?php

                do_settings_sections('lmt_template_tag_option');
                ?> <br><b><?php _e( 'Note:', 'wp-lmi' ); ?></b> <i><?php _e( 'Always backup .php files before making any changes, the backup file comes in handy for restoring the default file in case WordPress goes crazy.', 'wp-lmi' ); ?></i><?php
                submit_button( __( 'Save Settings', 'wp-lmi' ), 'primary' );

            ?> </div>

            <div style="display:none" id="show-misc"> <?php

                do_settings_sections('lmt_misc_option');
                submit_button( __( 'Save Settings', 'wp-lmi' ), 'primary' );

            ?> </div>
            <div id="progress" style="display:none;">Please wait...</div>
            <div style="display:none;" id="show-help">
                <div>
                <h3> Do you need help with this plugin? Here are some FAQ for you: </h3><p><hr></p>
                <p><li><strong>How this plugin works?</strong></li>
                <p>This plugin hooks into wordpress content area and shows last modified information of posts and pages.</p>
                
                <p><li><strong>Is this plugin compatible with any themes?</strong></li>
                <p>Yes, this plugin is compatible with any theme.</p>
                
                <p><li><strong>What is the CSS class for posts?</strong></li>
                <p>CSS Class is <code>.post-last-modified</code>, for date time <code>.post-last-modified-td</code> and for author <code>.post-modified-author</code>. Add your custom style in Custom CSS field.</p>

                <p><li><strong>What is the CSS class for pages?</strong></li>
                <p>CSS Class is <code>.page-last-modified</code>, for date time <code>.page-last-modified-td</code> and for author <code>.page-modified-author</code>. Add your custom style in Custom CSS field.</p>
          
                <p><li><strong>What is the shortcode for pages?</strong></li>
                <p>Shortcode for post is <code>[lmt-post-modified-info]</code> and for page is <code>[lmt-page-modified-info]</code>. Apply this on any page to show last modified info anywhere.</p>
                
                <p><li><strong>Do I need to add '&lt;style&gt; &lt;/style&gt;' tag?</strong></li>
                <p>No, this tag is not required, as it is already added.</p>

                <p><li><strong>How to set custom date/time format?</strong></li>
                <p>Go to <a href = "https://codex.wordpress.org/Formatting_Date_and_Time" target = "_blank"> WordPress Date/Time sysntax</a> page and read instructions.</p>

                <p><li><strong>How to use template tag functionality?</strong></li>
                <p>Models the function naming convention used by WordPress for the_modified_time / get_the_modified_time and similar functions. In this case, you have to edit your theme's template files i.e. single.php, page.php etc. and add/replace default published date function with this: &nbsp;&nbsp;
                <p><i>Displays/echos the last modified info:</i> <code>&lt;?php if ( function_exists( 'the_last_modified_info' ) ) {
                            the_last_modified_info();
			           } ?&gt;</code></p>       
                <p><i>Returns the last modified info:</i> <code>&lt;?php if ( function_exists( 'get_the_last_modified_info' ) ) {
				            get_the_last_modified_info();
			    } ?&gt;</code></p>
                </p></p>

                <p><li><strong>How to display last modified info on all posts, pages column?</strong></li>
                <p>You have to enable all options in Dashboard Tab to display last modified info aand you can also sort posts and pages by last modified info.</p>
                
                </p><br>
                
                <h3> My Other WordPress Plugins </h3><p><hr></p>
                <p><strong>Like this plugin? Check out my other WordPress plugins:</strong></p>
                <li><strong><a href = "https://wordpress.org/plugins/remove-wp-meta-tags/" target = "_blank">WP Header & Meta Tags</a></strong> - Customize WP header, add custom code and enable, disable or remove the unwanted meta tags, links from the source code and many more.</li>
                <li><strong><a href = "https://wordpress.org/plugins/ultimate-facebook-comments/" target = "_blank">Ultimate Facebook Comments</a></strong> - Ultimate Facebook Comment Solution for Any WordPress Website.</li>
                <li><strong><a href = "https://wordpress.org/plugins/change-wp-page-permalinks/" target = "_blank">WordPress Page Extension</a></strong> - Add any page extension like .html, .php to wordpress pages.</li>
                <li><strong><a href = "https://wordpress.org/plugins/all-in-one-wp-solution/" target = "_blank">All In One WP Solution</a></strong> - All In One Solution / Customization for WordPress.</li>
                <br></div>
            </div>
    
        </form>
            <div id="saveResult"></div>
                <script type="text/javascript">
                    jQuery(document).ready(function() {
                        jQuery('#form-container').submit(function() {
                            jQuery('#progress').show().delay(3000).fadeOut();
                            jQuery(this).ajaxSubmit({
                                success: function() {
                                    jQuery('#saveResult').html("<div id='saveMessage' class='successModal'></div>");
                                    jQuery('#saveMessage').append("<p><?php echo htmlentities(__('Settings Saved Successfully!','wp-lmi'),ENT_QUOTES); ?></p>").show();
                                },
                                timeout: 5000
                            });
                            setTimeout("jQuery('#saveMessage').hide();", 4000);
                            return false;
                        });
                    });
                </script>
            
            <div id="show-tools" style="display:none;">
                <h3> <?php _e( 'Plugin Tools', 'wp-lmi' ); ?> </h3><p><hr></p>
                    <span><strong><?php _e( 'Export Settings', 'wp-lmi' ); ?></strong></span>
					<p><?php _e( 'Export the plugin settings for this site as a .json file. This allows you to easily import the configuration into another site.', 'wp-lmi' ); ?></p>
					<form method="post">
						<p><input type="hidden" name="lmt_export_action" value="lmt_export_settings" /></p>
						<p>
							<?php wp_nonce_field( 'lmt_export_nonce', 'lmt_export_nonce' ); ?>
							<?php submit_button( __( 'Export Settings', 'wp-lmi' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
                <p><hr></p>
                    <span><strong><?php _e( 'Import Settings', 'wp-lmi' ); ?></strong></span>
					<p><?php _e( 'Import the plugin settings from a .json file. This file can be obtained by exporting the settings on another site using the form above.', 'wp-lmi' ); ?></p>
					<form method="post" enctype="multipart/form-data">
						<p><input type="file" name="import_file" accept=".json"/></p>
						<p>
							<input type="hidden" name="lmt_import_action" value="lmt_import_settings" />
							<?php wp_nonce_field( 'lmt_import_nonce', 'lmt_import_nonce' ); ?>
							<?php submit_button( __( 'Import Settings', 'wp-lmi' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
                <p><hr></p>
                    <span><strong><?php _e( 'Reset Settings', 'wp-lmi' ); ?></strong></span>
					<p style="color:red"><strong>WARNING: </strong><?php _e( 'Delete all options related to this plugin in your database.', 'wp-lmi' ); ?></p>
					<form method="post">
						<p><input type="hidden" name="lmt_reset_action" value="lmt_reset_settings" /></p>
	                    <p>
							<?php wp_nonce_field( 'lmt_reset_nonce', 'lmt_reset_nonce' ); ?>
							<?php submit_button( __( 'Reset Settings', 'wp-lmi' ), 'secondary', 'submit', false ); ?>
					    </p>
					</form>
                <br>
            </div>   
        </div>
    </div>
</div>

