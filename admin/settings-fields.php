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
   ?>   <label class="switch">
        <input type="checkbox" id="post-enable" name="lmt_plugin_global_settings[lmt_enable_last_modified_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_cb'])); ?> /> 
        <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on single posts page."><span title="" class="dashicons dashicons-editor-help"></span></span>
   <?php
}

function lmt_enable_human_format_cb_display() {
    ?>  <label class="switch">
        <input type="checkbox" id="post-human" name="lmt_plugin_global_settings[lmt_enable_human_format_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_human_format_cb'])); ?> /> 
        <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on posts as human readable format i.e. days/weeks/years ago."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_last_modified_time_cb_display() {
    ?>  <label class="switch">
        <input type="checkbox" id="post-enable-time" name="lmt_plugin_global_settings[lmt_enable_last_modified_time_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_time_cb'])); ?> /> 
        <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified time on posts."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_custom_post_time_format_display() {
    ?>  <input id="custom-post-time-format" name="lmt_plugin_global_settings[lmt_custom_post_time_format]" type="text" size="10" style="width:10%;" placeholder="h:i a" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_post_time_format'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_post_time_format']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter custom time format here. Default: h:i a. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_last_modified_date_cb_display() {
    ?>  <label class="switch">
        <input type="checkbox" id="post-enable-date" name="lmt_plugin_global_settings[lmt_enable_last_modified_date_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_date_cb'])); ?> /> 
        <div class="slider round"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified date on posts."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_custom_post_date_format_display() {
    ?>  <input id="custom-post-date-format" name="lmt_plugin_global_settings[lmt_custom_post_date_format]" type="text" size="10" style="width:10%;" placeholder="F jS, Y" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_post_date_format'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_post_date_format']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter custom date format here. Default: F, jS, Y. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_post_date_time_sep_display() {
    ?>  <input id="post-dt-sep" name="lmt_plugin_global_settings[lmt_post_date_time_sep]" type="text" size="8" style="width:8%;" placeholder="at" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_post_date_time_sep'])) { echo get_option('lmt_plugin_global_settings')['lmt_post_date_time_sep']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="If you want to customize date/time seperator on posts, set custom date and time seperator from here. Default: at."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_show_last_modified_time_date_post_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_last_modified_time_date_post'])){
        $options['lmt_show_last_modified_time_date_post'] = 'Before Content';
    }

    $items = array("Before Content", "After Content", "Using Shortcode");
    echo "<select id='post-show-status' name='lmt_plugin_global_settings[lmt_show_last_modified_time_date_post]' style='width:18%;'>";
    foreach($items as $item) {
        $selected = ($options['lmt_show_last_modified_time_date_post'] == $item) ? 'selected="selected"' : '';
        echo "<option value='$item' $selected>$item</option>";
    }
    echo "</select>";
    ?>
    &nbsp;&nbsp;<span id="show-shortcode" style="display:none;"><i>Shortcode: <code>[lmt-post-modified-info]</code></i>&nbsp;&nbsp;</span><span class="tooltip" title="Select where you want to show last modified info on a single posts page."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_post_custom_text_display() {
    ?>  <input id="post-custom-text" name="lmt_plugin_global_settings[lmt_post_custom_text]" type="text" size="30" style="width:30%;" placeholder="Last Updated on" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_post_custom_text'])) { echo get_option('lmt_plugin_global_settings')['lmt_post_custom_text']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter your custom text which will be shown on single posts page. You can also set a custom style from 'Custom CSS tab' for this. Use 'post-last-modified' as css class."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_show_author_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_author_cb'])){
        $options['lmt_show_author_cb'] = 'Do not show';
    }

    $items = array("Do not show", "Show only", "Show with Link");
    echo "<select id='post-sa' name='lmt_plugin_global_settings[lmt_show_author_cb]' style='width:16%;'>";
    foreach($items as $item) {
        $selected = ($options['lmt_show_author_cb'] == $item) ? 'selected="selected"' : '';
        echo "<option value='$item' $selected>$item</option>";
    }
    echo "</select>";
    ?>
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

    echo "<select id='cpt' name='lmt_plugin_global_settings[lmt_custom_post_types_list][]' multiple='multiple' style='width:60%;'>";
    foreach($post_types as $item) {
        $selected = in_array( $item, $options['lmt_custom_post_types_list'] ) ? ' selected="selected" ' : '';
        echo "<option value='$item' $selected>$item</option>";
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
    ?>  <label class="switch-pg">
        <input type="checkbox" id="page-enable" name="lmt_plugin_global_settings[lmt_enable_last_modified_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_page_cb'])); ?> /> 
        <div class="slider-pg round-pg"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on pages."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_human_format_page_cb_display() {
    ?>  <label class="switch-pg">
        <input type="checkbox" id="page-human" name="lmt_plugin_global_settings[lmt_enable_human_format_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_human_format_page_cb'])); ?> /> 
        <div class="slider-pg round-pg"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on pages as human readable format i.e. days/weeks/years ago."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_last_modified_time_page_cb_display() {
    ?>  <label class="switch-pg">
        <input type="checkbox" id="page-enable-time" name="lmt_plugin_global_settings[lmt_enable_last_modified_time_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_time_page_cb'])); ?> /> 
        <div class="slider-pg round-pg"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified time on pages."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_custom_page_time_format_display() {
    ?>  <input id="custom-page-time-format" name="lmt_plugin_global_settings[lmt_custom_page_time_format]" type="text" size="10" style="width:10%;" placeholder="h:i a" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_page_time_format'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_page_time_format']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter custom time format here. Default: h:i a. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_last_modified_date_page_cb_display() {
    ?>  <label class="switch-pg">
        <input type="checkbox" id="page-enable-date" name="lmt_plugin_global_settings[lmt_enable_last_modified_date_page_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_last_modified_date_page_cb'])); ?> /> 
        <div class="slider-pg round-pg"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified date on pages."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_custom_page_date_format_display() {
    ?>  <input id="custom-page-date-format" name="lmt_plugin_global_settings[lmt_custom_page_date_format]" type="text" size="10" style="width:10%;" placeholder="F jS, Y" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_page_date_format'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_page_date_format']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter custom date format here. Default: F, jS, Y. Go to help tab for more."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_page_date_time_sep_display() {
    ?>  <input id="page-dt-sep" name="lmt_plugin_global_settings[lmt_page_date_time_sep]" type="text" size="8" style="width:8%;" placeholder="at" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_page_date_time_sep'])) { echo get_option('lmt_plugin_global_settings')['lmt_page_date_time_sep']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="If you want to customize date/time seperator on pages, set custom date and time seperator from here. Default: at."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}
 
function lmt_show_last_modified_time_date_page_display() {
    $options = get_option('lmt_plugin_global_settings');

    if(!isset($options['lmt_show_last_modified_time_date_page'])){
        $options['lmt_show_last_modified_time_date_page'] = 'Before Content';
    }

    $items = array("Before Content", "After Content", "Using Shortcode");
    echo "<select id='page-show-status' name='lmt_plugin_global_settings[lmt_show_last_modified_time_date_page]' style='width:18%;'>";
    foreach($items as $item) {
        $selected = ($options['lmt_show_last_modified_time_date_page'] == $item) ? 'selected="selected"' : '';
        echo "<option value='$item' $selected>$item</option>";
    }
    echo "</select>";
    ?>
    &nbsp;&nbsp;<span id="show-shortcode-page" style="display:none;"><i>Shortcode: <code>[lmt-page-modified-info]</code></i>&nbsp;&nbsp;</span><span class="tooltip" title="Select where you want to show last modified info on a single posts page."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}
 
function lmt_page_custom_text_display() {
    ?> <input id="page-custom-text" name="lmt_plugin_global_settings[lmt_page_custom_text]" type="text" size="30" style="width:30%;" placeholder="Last Updated on" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_page_custom_text'])) { echo get_option('lmt_plugin_global_settings')['lmt_page_custom_text']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Enter your custom text which will be shown on single page. You can also set a custom style from 'Custom CSS tab' for this. Use 'page-last-modified' as css class."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_show_author_page_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_author_page_cb'])){
        $options['lmt_show_author_page_cb'] = 'Do not show';
    }

    $items = array("Do not show", "Show only", "Show with Link");
    echo "<select id='page-sa' name='lmt_plugin_global_settings[lmt_show_author_page_cb]' style='width:16%;'>";
    foreach($items as $item) {
        $selected = ($options['lmt_show_author_page_cb'] == $item) ? 'selected="selected"' : '';
        echo "<option value='$item' $selected>$item</option>";
    }
    echo "</select>";
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="Set how you want to display last modified author name on pages."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

/* ============================================================================================== 
                                           dashboard options
============================================================================================== */

function lmt_enable_on_dashboard_cb_display() {
    ?>  <label class="switch-db">
        <input type="checkbox" id="dashboard-display" name="lmt_plugin_global_settings[lmt_enable_on_dashboard_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_on_dashboard_cb'])); ?> /> 
        <div class="slider-db round-db"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to display last modified info on all posts, pages admin column, publish meta box, on the dashboard widget and save last modified info in custom field of every posts/pages."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_on_admin_bar_cb_display() {
    ?>  <label class="switch-db">
        <input type="checkbox" id="admin-bar-display" name="lmt_plugin_global_settings[lmt_enable_on_admin_bar_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_on_admin_bar_cb'])); ?> /> 
        <div class="slider-db round-db"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info on wordpress admin bar."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_set_widget_post_num_display() {
    ?>  <input id="widget-post-no" name="lmt_plugin_global_settings[lmt_set_widget_post_num]" type="number" size="6" style="width:6%;" placeholder="5" min="3" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_set_widget_post_num'])) { echo get_option('lmt_plugin_global_settings')['lmt_set_widget_post_num']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Set the number of posts you want to display on dashboard widget."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_custom_field_format_display() {
    ?>  <input id="custom-dtf" name="lmt_plugin_global_settings[lmt_custom_field_format]" type="text" size="12" style="width:12%;" placeholder="F jS, Y @ h:i a" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_field_format'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_field_format']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="You can set custom date/time format to show last modified info in a custom field."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

/* ============================================================================================== 
                                         template tags options
============================================================================================== */

function lmt_tt_enable_cb_display() {
    ?>  <label class="switch-tt">
        <input type="checkbox" id="lmt-tt" name="lmt_plugin_global_settings[lmt_tt_enable_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_tt_enable_cb'])); ?> /> 
        <div class="slider-tt round-tt"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to use template tag functionality. Go to Help tab for more info."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_human_format_tt_cb_display() {
    ?>  <label class="switch-tt">
        <input type="checkbox" id="lmt-tt-human" name="lmt_plugin_global_settings[lmt_enable_human_format_tt_cb]" value="1" <?php checked(1 == isset(get_option('lmt_plugin_global_settings')['lmt_enable_human_format_tt_cb'])); ?> /> 
        <div class="slider-tt round-tt"></div></label>&nbsp;&nbsp;<span class="tooltip" title="Enable this if you want to show last modified info as human readable format i.e. days/weeks/years ago using template tags."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_tt_set_format_box_display() {
    ?> <input id="lmt-tt-format" name="lmt_plugin_global_settings[lmt_tt_set_format_box]" type="text" size="20" style="width:20%;" placeholder="F jS, Y @ h:i a" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_tt_set_format_box'])) { echo get_option('lmt_plugin_global_settings')['lmt_tt_set_format_box']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="Set custom date/time format here. Default: F jS, Y @ h:i a. go to help tab for details."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_tt_updated_text_box_display() {
    ?> <input id="lmt-tt-updated-text" name="lmt_plugin_global_settings[lmt_tt_updated_text_box]" type="text" size="30" style="width:30%;" placeholder="Updated on" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_tt_updated_text_box'])) { echo get_option('lmt_plugin_global_settings')['lmt_tt_updated_text_box']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="If you want to display any message before last modified date/time, set here."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_show_author_tt_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_author_tt_cb'])){
        $options['lmt_show_author_tt_cb'] = 'Do not show';
    }

    $items = array("Do not show", "Show only", "Show with Link");
    echo "<select id='lmt-tt-sa' name='lmt_plugin_global_settings[lmt_show_author_tt_cb]' style='width:16%;'>";
    foreach($items as $item) {
        $selected = ($options['lmt_show_author_tt_cb'] == $item) ? 'selected="selected"' : '';
        echo "<option value='$item' $selected>$item</option>";
    }
    echo "</select>";
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="Set how you want to display last modified author name using template tags."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_tt_class_box_display() {
    ?> <input id="lmt-tt-class" name="lmt_plugin_global_settings[lmt_tt_class_box]" type="text" size="40" style="width:40%;" placeholder="e.g. entry-time" value="<?php if (isset(get_option('lmt_plugin_global_settings')['lmt_tt_class_box'])) { echo get_option('lmt_plugin_global_settings')['lmt_tt_class_box']; } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="If you want to set any CSS Class, write here."><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}
/* ============================================================================================== 
                                            custom css 
============================================================================================== */

function lmt_custom_style_box_display() {
    ?>
    <textarea id="lmt-cus-style" placeholder="Write your custom css here." name="lmt_plugin_global_settings[lmt_custom_style_box]" rows="12" cols="100" style="width:90%;"><?php if (isset(get_option('lmt_plugin_global_settings')['lmt_custom_style_box'])) { echo get_option('lmt_plugin_global_settings')['lmt_custom_style_box']; } ?></textarea>
    <br><small>Do not add <strong>'&lt;style&gt; &lt;/style&gt;'</strong> tag. This tag is not required, as it is already added.</small><?php
}


?>