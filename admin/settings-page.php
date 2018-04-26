<?php ?>

<div class="wrap">
    <h1> WP Last Modified Info Settings </h1>

		<div>
        Show or hide last update date and time on pages and posts very easily.
		</div><hr>
 
        <h2 class="nav-tab-wrapper">
            <a href="#post" class="nav-tab" id="btn1">Post Options</a>
            <a href="#page" class="nav-tab" id="btn2">Page Options</a>
            <a href="#dashboard" class="nav-tab" id="btn3">Dashboard Options</a>
            <a href="#style" class="nav-tab" id="btn4">Custom CSS</a>
            <a href="#help" class="nav-tab" id="btn5">Help</a>
        </h2>

    <div id="form_area">

        <form id="form" method="post" action="options.php">
        <?php
            if ( function_exists('wp_nonce_field') ) 
	        wp_nonce_field('wp-last-modified-time-date_' . "yep"); 
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
                <p>CSS Class is 'page-last-modified'. Add your custom style in Custom Style Tab.</p>...<br>

                <p><strong>What is the CSS class for posts?</strong>
                <p>CSS Class is 'post-last-modified'. Add your custom style in Custom Style Tab.</p>...<br>

                <p><strong>What is the shortcode for posts?</strong>
                <p>Shortcode is '[lmt-post-modified-info]'. Apply this on any post to show last modified info anywhere.</p>...<br>

                <p><strong>What is the shortcode for pages?</strong>
                <p>Shortcode is '[lmt-page-modified-info]'. Apply this on any page to show last modified info anywhere.</p>...<br>
                
                <p><strong>Do I need to add '&lt;style&gt; &lt;/style&gt;' tag?</strong>
                <p>No, this tag is not required, as it is already added.</p>...<br>
                
                <p><strong>What about Dashboard Options?</strong>
                <p>This options helps you by showing pages and posts last modified info in admin area (column). You can sort pages and by last modified info.</p>
                
                <br></div>
         </div>
    
        </form>
        
    </div>

</div>

