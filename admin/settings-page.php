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
    <h1> WP Last Modified Info Settings </h1>

		<div>
        Show last update date and time on pages and posts very easily.
		</div><hr>
 
        <h2 class="nav-tab-wrapper">
            <a href="#post" class="nav-tab" id="btn1">Post Options</a>
            <a href="#page" class="nav-tab" id="btn2">Page Options</a>
            <a href="#dashboard" class="nav-tab" id="btn3">Dashboard Options</a>
            <a href="#template-tags" class="nav-tab" id="btn4">Template Tags</a>
            <a href="#style" class="nav-tab" id="btn5">Custom CSS</a>
            <a href="#help" class="nav-tab" id="btn6">Help</a>
        </h2>

    <div id="form_area">

        <form id="form" method="post" action="options.php">
        <?php
            if ( function_exists('wp_nonce_field') ) 
	        wp_nonce_field('wp_last_modified_info'); 
        ?>
        <?php settings_fields("lmt_post_page_plugin_section"); ?>

            <div id="show-post"> <?php
            
                do_settings_sections("lmt_post_option");
                submit_button('Save All Settings');
            
            ?> </div>

            <div style="display:none" id="show-page"> <?php
                 
                do_settings_sections("lmt_page_option");
                submit_button('Save All Settings');

            ?> </div>

            <div style="display:none" id="show-dashboard"> <?php

                do_settings_sections("lmt_dashboard_option");
                submit_button('Save All Settings');
               
            ?> </div>

            <div style="display:none" id="show-tt"> <?php

                do_settings_sections("lmt_template_tag_option");
                ?> <br><b>Note:</b> <i>Always back-up functions.php before making changes, the back-up file comes in handy for restoring the default file in case WordPress goes crazy.</i><?php
                submit_button('Save All Settings');

            ?> </div>

            <div style="display:none" id="show-style-area"> <?php

                do_settings_sections("lmt_cus_style_option");
                submit_button('Save All Settings');

            ?> </div>

            <div style="display:none" id="show-help">
                <br><div>
                <b> Do you need help with this plugin? Here are some FAQ for you: </b> <hr>
                <p><strong>How this plugin works?</strong>
                <p>This plugin hooks into wordpress content area and shows last modified information of posts and pages.</p>...<br>
                
                <p><strong>Is this plugin copmpatible with any themes?</strong>
                <p>Yes, this plugin is compatible with any theme.</p>...<br>
                
                <p><strong>What is the CSS class for pages?</strong>
                <p>CSS Class for prefix is 'page-last-modified' and for date time is 'page-last-modified-td'. Add your custom style in Custom CSS Tab.</p>...<br>

                <p><strong>What is the CSS class for posts?</strong>
                <p>CSS Class for prefix is 'post-last-modified' and for date time is 'post-last-modified-td'. Add your custom style in Custom CSS Tab.</p>...<br>

                <p><strong>What is the shortcode for posts?</strong>
                <p>Shortcode is '[lmt-post-modified-info]'. Apply this on any post to show last modified info anywhere.</p>...<br>

                <p><strong>What is the shortcode for pages?</strong>
                <p>Shortcode is '[lmt-page-modified-info]'. Apply this on any page to show last modified info anywhere.</p>...<br>
                
                <p><strong>Do I need to add '&lt;style&gt; &lt;/style&gt;' tag?</strong>
                <p>No, this tag is not required, as it is already added.</p>...<br>

                <p><strong>How to set custom date/time format?</strong>
                <p>Go to <a href = "https://codex.wordpress.org/Formatting_Date_and_Time" target = "_blank"> WordPress Date/Time sysntax</a> page and read instructions.</p>...<br>

                <p><strong>How to use template tag functionality?</strong>
                <p>In this case, you have to edit your theme's template files i.e. single.php, page.php etc. and add/replace default published date function with this: &nbsp;&nbsp;<p><code>&lt;?php if ( function_exists( 'get_last_modified_info' ) ) {
				             get_last_modified_info();
			           } ?&gt;</code></p></p>...<br>

                <p><strong>How to display last modified info on all posts, pages column?</strong>
                <p>You have to enable all options in Dashboard Tab to display last modified info aand you can also sort posts and pages by last modified info.</p>
                
                <br></div>
            </div>
    
        </form>
        
    </div>

</div>

