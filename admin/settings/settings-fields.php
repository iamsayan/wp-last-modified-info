<?php
/**
 * Load settings fields
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

/* ============================================================================================== 
                                           post options
============================================================================================== */

function lmt_enable_last_modified_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="post-enable" name="lmt_plugin_global_settings[lmt_enable_last_modified_cb]" value="1" <?php checked(isset($options['lmt_enable_last_modified_cb']), 1); ?> /> 
        <span class="slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on single posts page."><span title="" class="dashicons dashicons-editor-help"></span></span>
   <?php
}

function lmt_enable_human_format_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="post-human" name="lmt_plugin_global_settings[lmt_enable_human_format_cb]" value="1" <?php checked(isset($options['lmt_enable_human_format_cb']), 1); ?> /> 
        <span class="slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on posts as human readable format i.e. days / weeks / years ago."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_last_modified_time_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="post-enable-time" name="lmt_plugin_global_settings[lmt_enable_last_modified_time_cb]" value="1" <?php checked(isset($options['lmt_enable_last_modified_time_cb']), 1); ?> /> 
        <span class="slider round"></span></label>
        <span id="post-tmcf" style="display:none;">&nbsp;&nbsp;&nbsp;<label for="custom-post-time-format" style="font-size:13px;"><strong><?php _e( 'Custom Format:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;<input id="custom-post-time-format" name="lmt_plugin_global_settings[lmt_custom_post_time_format]" type="text" size="10" style="width:10%;" placeholder="h:i a" value="<?php if (isset($options['lmt_custom_post_time_format'])) { echo $options['lmt_custom_post_time_format']; } ?>" />
        </span>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified time on posts. You can also customize default (h:i a) time format. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_last_modified_date_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="post-enable-date" name="lmt_plugin_global_settings[lmt_enable_last_modified_date_cb]" value="1" <?php checked(isset($options['lmt_enable_last_modified_date_cb']), 1); ?> /> 
        <span class="slider round"></span></label>
        <span id="post-dtcf" style="display:none;">&nbsp;&nbsp;&nbsp;<label for="custom-post-date-format" style="font-size:13px;"><strong><?php _e( 'Custom Format:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;<input id="custom-post-date-format" name="lmt_plugin_global_settings[lmt_custom_post_date_format]" type="text" size="10" style="width:10%;" placeholder="F jS, Y" value="<?php if (isset($options['lmt_custom_post_date_format'])) { echo $options['lmt_custom_post_date_format']; } ?>" />
        </span>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified date on posts. You can also customize default (F jS, Y) date format. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_post_date_time_sep_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <input id="post-dt-sep" name="lmt_plugin_global_settings[lmt_post_date_time_sep]" type="text" size="8" style="width:8%;" placeholder="at" value="<?php if (isset($options['lmt_post_date_time_sep'])) { echo $options['lmt_post_date_time_sep']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="If you want to customize date/time seperator on posts, set custom date and time seperator from here. Default: at."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_show_last_modified_time_date_post_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_last_modified_time_date_post'])){
        $options['lmt_show_last_modified_time_date_post'] = 'Before Content';
    }

    $items = array("Before Content", "After Content", "Manual");
    echo '<select id="post-show-status" name="lmt_plugin_global_settings[lmt_show_last_modified_time_date_post]" style="width:16%;">';
    foreach($items as $item) {
        $selected = ($options['lmt_show_last_modified_time_date_post'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $item . '</option>';
    }
    echo "</select>";
    ?>
    &nbsp;&nbsp;<span id="show-shortcode" style="display:none;"><i><?php _e( 'Shortcode: ', 'wp-last-modified-info' ); ?><code>[lmt-post-modified-info]</code></i>&nbsp;&nbsp;</span><span class="tooltip" title="Select where you want to show last modified info on a single posts. If you select 'Before Content or After Content', you can disable auto insert on particular posts from post edit screen > WP Last Modified Info meta box."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_post_custom_text_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <input id="post-custom-text" name="lmt_plugin_global_settings[lmt_post_custom_text]" type="text" size="30" style="width:30%;" placeholder="Last Updated on" value="<?php if (isset($options['lmt_post_custom_text'])) { echo $options['lmt_post_custom_text']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter your custom text which will be shown on single posts page. You can also set a custom style from 'Custom CSS tab' for this. Use 'post-last-modified' as css class."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_show_author_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_author_cb'])){
        $options['lmt_show_author_cb'] = 'Do not show';
    }

    $items = array("Do not show", "Default", "Custom");
    echo '<select id="post-sa" name="lmt_plugin_global_settings[lmt_show_author_cb]" style="width:14%;">';
    foreach($items as $item) {
        $selected = ($options['lmt_show_author_cb'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $item . '</option>';
    }
    echo "</select>";

    ?>
    <span id="post-custom-author" style="display:none;">&nbsp;&nbsp;&nbsp;<label for="custom-post-author" style="font-size:13px;"><strong><?php _e( 'Select:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <?php

    if(!isset($options['lmt_show_author_list'])){
        $options['lmt_show_author_list'] = 1;
    }

    $users = get_users();
    echo '<select id="custom-post-author" name="lmt_plugin_global_settings[lmt_show_author_list]" style="width:20%;">';
    foreach($users as $user) {
        $selected = ($options['lmt_show_author_list'] == $user->ID) ? ' selected="selected"' : '';
        echo '<option value="' . $user->ID . '"' . $selected . '>' . $user->display_name . '</option>';
    }
    echo "</select>";
    ?>
    </span><span id="post-author-link" style="display:none;">&nbsp;&nbsp;&nbsp;<label for="post-authorlink" style="font-size:13px;"><strong><?php _e( 'Link:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <label class="switch">
        <input type="checkbox" id="post-authorlink" name="lmt_plugin_global_settings[lmt_enable_author_hyperlink]" value="1" <?php checked(isset($options['lmt_enable_author_hyperlink']), 1); ?> /> 
        <span class="slider round"></span>
    </label></span>
    &nbsp;&nbsp;<span class="tooltip" title="Set how you want to display last modified author name on posts."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_custom_post_types_list_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_custom_post_types_list'])){
        $options['lmt_custom_post_types_list'][] = '';
    }

    $post_types = get_post_types(array(
        'public'   => true,
        '_builtin' => false
    ), 'names'); 

    echo '<select id="cpt" name="lmt_plugin_global_settings[lmt_custom_post_types_list][]" multiple="multiple" style="width:70%;">';
    foreach($post_types as $item) {
        $selected = in_array( $item, $options['lmt_custom_post_types_list'] ) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $item . '</option>';
    }
    echo "</select>";
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="Select custom post types to show last modified info on selected post types only."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

/* ============================================================================================== 
                                           page options
============================================================================================== */

function lmt_enable_last_modified_page_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="page-enable" name="lmt_plugin_global_settings[lmt_enable_last_modified_page_cb]" value="1" <?php checked(isset($options['lmt_enable_last_modified_page_cb']), 1); ?> /> 
        <span class="slider-pg round-pg"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on pages."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_human_format_page_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="page-human" name="lmt_plugin_global_settings[lmt_enable_human_format_page_cb]" value="1" <?php checked(isset($options['lmt_enable_human_format_page_cb']), 1); ?> /> 
        <span class="slider-pg round-pg"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on pages as human readable format i.e. days / weeks / years ago."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_last_modified_time_page_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="page-enable-time" name="lmt_plugin_global_settings[lmt_enable_last_modified_time_page_cb]" value="1" <?php checked(isset($options['lmt_enable_last_modified_time_page_cb']), 1); ?> /> 
        <span class="slider-pg round-pg"></span></label>
        <span id="page-tmcf" style="display:none;">&nbsp;&nbsp;&nbsp;<label for="custom-page-time-format" style="font-size:13px;"><strong><?php _e( 'Custom Format:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;<input id="custom-page-time-format" name="lmt_plugin_global_settings[lmt_custom_page_time_format]" type="text" size="10" style="width:10%;" placeholder="h:i a" value="<?php if (isset($options['lmt_custom_page_time_format'])) { echo $options['lmt_custom_page_time_format']; } ?>" />
        </span>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified time on pages. You can also customize default (h:i a) date format. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_last_modified_date_page_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="page-enable-date" name="lmt_plugin_global_settings[lmt_enable_last_modified_date_page_cb]" value="1" <?php checked(isset($options['lmt_enable_last_modified_date_page_cb']), 1); ?> /> 
        <span class="slider-pg round-pg"></span></label>
        <span id="page-dtcf" style="display:none;">&nbsp;&nbsp;&nbsp;<label for="custom-page-date-format" style="font-size:13px;"><strong><?php _e( 'Custom Format:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;<input id="custom-page-date-format" name="lmt_plugin_global_settings[lmt_custom_page_date_format]" type="text" size="10" style="width:10%;" placeholder="F jS, Y" value="<?php if (isset($options['lmt_custom_page_date_format'])) { echo $options['lmt_custom_page_date_format']; } ?>" />
        </span>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified date on pages. You can also customize default (F jS, Y) date format. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_page_date_time_sep_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <input id="page-dt-sep" name="lmt_plugin_global_settings[lmt_page_date_time_sep]" type="text" size="8" style="width:8%;" placeholder="at" value="<?php if (isset($options['lmt_page_date_time_sep'])) { echo $options['lmt_page_date_time_sep']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="If you want to customize date/time seperator on pages, set custom date and time seperator from here. Default: at."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}
 
function lmt_show_last_modified_time_date_page_display() {
    $options = get_option('lmt_plugin_global_settings');

    if(!isset($options['lmt_show_last_modified_time_date_page'])){
        $options['lmt_show_last_modified_time_date_page'] = 'Before Content';
    }

    $items = array("Before Content", "After Content", "Manual");
    echo '<select id="page-show-status" name="lmt_plugin_global_settings[lmt_show_last_modified_time_date_page]" style="width:16%;">';
    foreach($items as $item) {
        $selected = ($options['lmt_show_last_modified_time_date_page'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $item . '</option>';
    }
    echo "</select>";
    ?>
    &nbsp;&nbsp;<span id="show-shortcode-page" style="display:none;"><i><?php _e( 'Shortcode: ', 'wp-last-modified-info' ); ?><code>[lmt-page-modified-info]</code></i>&nbsp;&nbsp;</span><span class="tooltip" title="Select where you want to show last modified info on a page. If you select 'Before Content or After Content', you can disable auto insert on particular posts from page edit screen > WP Last Modified Info meta box."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}
 
function lmt_page_custom_text_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?> <input id="page-custom-text" name="lmt_plugin_global_settings[lmt_page_custom_text]" type="text" size="30" style="width:30%;" placeholder="Last Updated on" value="<?php if (isset($options['lmt_page_custom_text'])) { echo $options['lmt_page_custom_text']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter your custom text which will be shown on single page. You can also set a custom style from 'Custom CSS tab' for this. Use 'page-last-modified' as css class."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_show_author_page_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_author_page_cb'])){
        $options['lmt_show_author_page_cb'] = 'Do not show';
    }

    $items = array("Do not show", "Default", "Custom");
    echo '<select id="page-sa" name="lmt_plugin_global_settings[lmt_show_author_page_cb]" style="width:14%;">';
    foreach($items as $item) {
        $selected = ($options['lmt_show_author_page_cb'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $item . '</option>';
    }
    echo "</select>";
    ?>
    <span id="page-custom-author" style="display:none;">&nbsp;&nbsp;&nbsp;<label for="custom-page-author" style="font-size:13px;"><strong><?php _e( 'Select:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <?php

    if(!isset($options['lmt_show_author_list_page'])){
        $options['lmt_show_author_list_page'] = 1;
    }

    $users = get_users();
    echo '<select id="custom-page-author" name="lmt_plugin_global_settings[lmt_show_author_list_page]" style="width:20%;">';
    foreach($users as $user) {
        $selected = ($options['lmt_show_author_list_page'] == $user->ID) ? ' selected="selected"' : '';
        echo '<option value="' . $user->ID . '"' . $selected . '>' . $user->display_name . '</option>';
    }
    echo "</select>";
    ?>
    </span><span id="page-author-link" style="display:none;">&nbsp;&nbsp;&nbsp;<label for="page-authorlink" style="font-size:13px;"><strong><?php _e( 'Link:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <label class="switch">
        <input type="checkbox" id="page-authorlink" name="lmt_plugin_global_settings[lmt_enable_page_author_hyperlink]" value="1" <?php checked(isset($options['lmt_enable_page_author_hyperlink']), 1); ?> /> 
        <span class="slider-pg round-pg"></span>
    </label></span>
    &nbsp;&nbsp;<span class="tooltip" title="Set how you want to display last modified author name on pages."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

/* ============================================================================================== 
                                         template tags options
============================================================================================== */

function lmt_tt_enable_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="lmt-tt" name="lmt_plugin_global_settings[lmt_tt_enable_cb]" value="1" <?php checked(isset($options['lmt_tt_enable_cb']), 1); ?> /> 
        <span class="slider-tt round-tt"></span></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to use template tag functionality. Go to Help tab for more info."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_human_format_tt_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="lmt-tt-human" name="lmt_plugin_global_settings[lmt_enable_human_format_tt_cb]" value="1" <?php checked(isset($options['lmt_enable_human_format_tt_cb']), 1); ?> /> 
        <span class="slider-tt round-tt"></span></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info as human readable format i.e. days/weeks/years ago using template tags."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_tt_set_format_box_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?> <input id="lmt-tt-format" name="lmt_plugin_global_settings[lmt_tt_set_format_box]" type="text" size="20" style="width:20%;" placeholder="F jS, Y @ h:i a" value="<?php if (isset($options['lmt_tt_set_format_box'])) { echo $options['lmt_tt_set_format_box']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Set custom date/time format here. Default: F jS, Y @ h:i a. go to help tab for details."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_tt_updated_text_box_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?> <input id="lmt-tt-updated-text" name="lmt_plugin_global_settings[lmt_tt_updated_text_box]" type="text" size="30" style="width:30%;" placeholder="Updated on" value="<?php if (isset($options['lmt_tt_updated_text_box'])) { echo $options['lmt_tt_updated_text_box']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="If you want to display any message before last modified date/time, set here."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_show_author_tt_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_author_tt_cb'])){
        $options['lmt_show_author_tt_cb'] = 'Do not show';
    }

    $items = array("Do not show", "Default", "Custom");
    echo '<select id="lmt-tt-sa" name="lmt_plugin_global_settings[lmt_show_author_tt_cb]" style="width:14%;">';
    foreach($items as $item) {
        $selected = ($options['lmt_show_author_tt_cb'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $item . '</option>';
    }
    echo "</select>";
    ?>
    <span id="tt-custom-author" style="display:none;">&nbsp;&nbsp;&nbsp;<label for="lmt-custom-tt-author" style="font-size:13px;"><strong><?php _e( 'Select:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <?php

    if(!isset($options['lmt_show_author_list_tt'])){
        $options['lmt_show_author_list_tt'] = 1;
    }

    $users = get_users();
    echo '<select id="lmt-custom-tt-author" name="lmt_plugin_global_settings[lmt_show_author_list_tt]" style="width:20%;">';
    foreach($users as $user) {
        $selected = ($options['lmt_show_author_list_tt'] == $user->ID) ? ' selected="selected"' : '';
        echo '<option value="' . $user->ID . '"' . $selected . '>' . $user->display_name . '</option>';
    }
    echo "</select>";
    ?>
    </span><span id="tt-author-link" style="display:none;">&nbsp;&nbsp;&nbsp;<label for="lmt-tt-authorlink" style="font-size:13px;"><strong><?php _e( 'Link:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <label class="switch">
        <input type="checkbox" id="lmt-tt-authorlink" name="lmt_plugin_global_settings[lmt_enable_tt_author_hyperlink]" value="1" <?php checked(isset($options['lmt_enable_tt_author_hyperlink']), 1); ?> /> 
        <span class="slider-tt round-tt"></span>
    </label></span>
    &nbsp;&nbsp;<span class="tooltip" title="Set how you want to display last modified author name using template tags."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_tt_class_box_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?> <input id="lmt-tt-class" name="lmt_plugin_global_settings[lmt_tt_class_box]" type="text" size="50" style="width:40%;" placeholder="e.g. entry-time" value="<?php if (isset($options['lmt_tt_class_box'])) { echo $options['lmt_tt_class_box']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="If you want to set any CSS Class, write here."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}
/* ============================================================================================== 
                                            misc options
============================================================================================== */

function lmt_enable_on_admin_bar_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="admin-bar-display" name="lmt_plugin_global_settings[lmt_enable_on_admin_bar_cb]" value="1" <?php checked(isset($options['lmt_enable_on_admin_bar_cb']), 1); ?> /> 
        <span class="slider-misc round-misc"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on wordpress admin bar."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_custom_style_box_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>
    <textarea id="lmt-cus-style" placeholder=".post-last-modified, .page-last-modified { color: #000000; font-weight: bold; }" name="lmt_plugin_global_settings[lmt_custom_style_box]" rows="12" cols="100" style="width:90%;"><?php if (isset($options['lmt_custom_style_box'])) { echo $options['lmt_custom_style_box']; } ?></textarea>
    <br><small><?php printf(__( 'Do not add %s tag. This tag is not required, as it is already added.', 'wp-last-modified-info' ), '<strong>&#39;&lt;style&gt; &lt;/style&gt;&#39;</strong>'); ?></small>
    <?php
}

function lmt_del_plugin_data_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="del-data" name="lmt_plugin_global_settings[lmt_del_plugin_data_cb]" value="1" <?php checked(isset($options['lmt_del_plugin_data_cb']), 1); ?> /> 
        <span class="slider-misc round-misc"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to delete plugin data at the time of uninstallation."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

?>