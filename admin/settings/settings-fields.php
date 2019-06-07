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
        <span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you want to show last modified info on single posts page.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
   <?php
}

function lmt_enable_schema_on_post_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="post-enable-schema" name="lmt_plugin_global_settings[lmt_enable_schema_on_post_cb]" value="1" <?php checked(isset($options['lmt_enable_schema_on_post_cb']), 1); ?> /> 
        <span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you want to enable inline dateModified microdata schema markup on single posts page.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
   <?php
}

function lmt_show_last_modified_time_date_post_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_last_modified_time_date_post'])){
        $options['lmt_show_last_modified_time_date_post'] = 'before_content';
    }
    $items = array(
        'before_content' => __( 'Before Content', 'wp-last-modified-info' ),
        'after_content'  => __( 'After Content', 'wp-last-modified-info' ),
        'manual'         => __( 'Manual (use shortcode)', 'wp-last-modified-info' )
    );
    echo '<select id="post-show-status" name="lmt_plugin_global_settings[lmt_show_last_modified_time_date_post]" style="width:23%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_show_last_modified_time_date_post'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    <span id="show-post-homepage" style="display:nohne;">&nbsp;&nbsp;<label for="post-homepage" style="font-size:13px;"><strong><?php _e( 'Show on Archives:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <?php if(!isset($options['lmt_show_on_homepage'])){
        $options['lmt_show_on_homepage'] = 'no';
    }
    $archives = array(
        'yes' => __( 'Yes', 'wp-last-modified-info' ),
        'no'  => __( 'No', 'wp-last-modified-info' )
    );
    echo '<select id="post-homepage" name="lmt_plugin_global_settings[lmt_show_on_homepage]" style="width:10%;">';
    foreach( $archives as $archive => $label ) {
        $selected = ($options['lmt_show_on_homepage'] == $archive) ? ' selected="selected"' : '';
        echo '<option value="' . $archive . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?></span>
    &nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select where you want to show last modified info on a single posts. If you select \'Before Content or After Content\', you can disable auto insert on particular posts from post edit screen > WP Last Modified Info meta box and apply shortcode on that particular post, if you want to. \'Show on Homepage\' option is applicable for posts only.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_post_custom_text_display() {
    $options = get_option('lmt_plugin_global_settings');
    if(empty($options['lmt_post_custom_text'])){
        $options['lmt_post_custom_text'] = 'Last Updated on';
    }
    ?>  <input id="post-custom-text" name="lmt_plugin_global_settings[lmt_post_custom_text]" type="text" size="30" style="width:30%;" required placeholder="<?php _e( 'Last Updated on', 'wp-last-modified-info' ); ?>" value="<?php if (isset($options['lmt_post_custom_text'])) { echo htmlentities($options['lmt_post_custom_text']); } ?>" />
    
    &nbsp;&nbsp;<label for="post-html-tag" style="font-size:13px;"><strong><?php _e( 'HTML Tag:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <?php if(!isset($options['lmt_html_tag_post'])){
        $options['lmt_html_tag_post'] = 'p';
    }
    $items = array(
        'p'     => '&lt;p&gt;',
        'span'  => '&lt;span&gt;'
    );
    echo '<select id="post-html-tag" name="lmt_plugin_global_settings[lmt_html_tag_post]" style="width:12%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_html_tag_post'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enter your custom text which will be shown on single posts page. You can also set a custom style from \'Custom CSS tab\' for this. Use \'post-last-modified\' as css class.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_last_modified_format_post_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_last_modified_format_post'])){
        $options['lmt_last_modified_format_post'] = 'default';
    }
    $items = array(
        'default'         => __( 'Traditional Format', 'wp-last-modified-info' ),
        'human_readable'  => __( 'Human Readable Format', 'wp-last-modified-info' )
    );
    echo '<select id="post-format" name="lmt_plugin_global_settings[lmt_last_modified_format_post]" style="width:25%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_last_modified_format_post'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    <span id="post-human-end-with" style="display:none;">&nbsp;&nbsp;<label for="post-ago-replace" style="font-size:13px;"><strong><?php _e( 'End with:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
        <?php if(empty($options['lmt_replace_ago_text_with'])){
            $options['lmt_replace_ago_text_with'] = 'ago';
        } ?>
        <input id="post-ago-replace" name="lmt_plugin_global_settings[lmt_replace_ago_text_with]" type="text" size="10" style="width:10%;" required placeholder="ago" value="<?php if (isset($options['lmt_replace_ago_text_with'])) { echo htmlentities($options['lmt_replace_ago_text_with']); } ?>" />
    </span>
    &nbsp;&nbsp;</span><span class="tooltip" title="<?php _e( 'Select last modified info format from here.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_last_modified_default_format_post_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_last_modified_default_format_post'])){
        $options['lmt_last_modified_default_format_post'] = 'only_date';
    }
    $items = array(
        'only_date'    => __( 'Only Date', 'wp-last-modified-info' ),
        'only_time'    => __( 'Only Time', 'wp-last-modified-info' ),
        'show_both'    => __( 'Show Both', 'wp-last-modified-info' )
    );
    echo '<select id="post-default-format" name="lmt_plugin_global_settings[lmt_last_modified_default_format_post]" style="width:13%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_last_modified_default_format_post'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>

    <span id="post-dtcf" style="display:none;">&nbsp;&nbsp;<label for="custom-post-date-format" style="font-size:13px;"><strong><?php _e( 'Date Format:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
        <?php if(empty($options['lmt_custom_post_date_format'])){
            $options['lmt_custom_post_date_format'] = get_option( 'date_format' );
        } ?>
        <input id="custom-post-date-format" name="lmt_plugin_global_settings[lmt_custom_post_date_format]" type="text" size="8" style="width:8%;" required placeholder="F jS, Y" value="<?php if (isset($options['lmt_custom_post_date_format'])) { echo $options['lmt_custom_post_date_format']; } ?>" />
    </span>

    <span id="post-dtsep" style="display:none;">&nbsp;&nbsp;<label for="custom-post-dtsep" style="font-size:13px;"><strong><?php _e( 'Separator:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
        <?php if(empty($options['lmt_post_date_time_sep'])){
            $options['lmt_post_date_time_sep'] = 'at';
        } ?>
        <input id="custom-post-dtsep" name="lmt_plugin_global_settings[lmt_post_date_time_sep]" type="text" size="6" style="width:6%;" required placeholder="at" value="<?php if (isset($options['lmt_post_date_time_sep'])) { echo htmlentities($options['lmt_post_date_time_sep']); } ?>" />
    </span>

    <span id="post-tmcf" style="display:none;">&nbsp;&nbsp;<label for="custom-post-time-format" style="font-size:13px;"><strong><?php _e( 'Time Format:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
        <?php if(empty($options['lmt_custom_post_time_format'])){
            $options['lmt_custom_post_time_format'] = get_option( 'time_format' );
        } ?>
        <input id="custom-post-time-format" name="lmt_plugin_global_settings[lmt_custom_post_time_format]" type="text" size="8" style="width:8%;" required placeholder="h:i a" value="<?php if (isset($options['lmt_custom_post_time_format'])) { echo $options['lmt_custom_post_time_format']; } ?>" />
    </span>

    &nbsp;&nbsp;</span><span class="tooltip" title="<?php _e( 'Select how you want to show last modified info on a single post if Traditional Format is active.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_gap_on_post_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if( !isset($options['lmt_gap_on_post']) ) {
        $options['lmt_gap_on_post'] = 0;
    }
    $items = array(
        '0'        => __( 'No Gap', 'wp-last-modified-info' ),
        '86400'    => __( '1 day (24 hours)', 'wp-last-modified-info' ),
        '172800'   => __( '2 days (48 hours)', 'wp-last-modified-info' ),
        '259200'   => __( '3 days (72 hours)', 'wp-last-modified-info' ),
        '432000'   => __( '5 days (120 hours)', 'wp-last-modified-info' ),
        '604800'   => __( '7 days (168 hours)', 'wp-last-modified-info' ),
        '1296000'  => __( '15 days (360 hours)', 'wp-last-modified-info' ),
        '2592000'  => __( '30 days (720 hours)', 'wp-last-modified-info' )
    );
    $items = apply_filters( 'wplmi_add_custom_gap_items', $items );
    echo '<select id="post-gap" name="lmt_plugin_global_settings[lmt_gap_on_post]" style="width:20%;">';
    foreach( $items as $item => $label ) {
        $selected = ( $options['lmt_gap_on_post'] == $item ) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select the gap between published time and modified time. If modified time is greater than published time + gap, then it shows last modified info on frontend.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_show_author_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_author_cb'])){
        $options['lmt_show_author_cb'] = 'do_not_show';
    }
    $items = array(
        'do_not_show' => __( 'Do not show', 'wp-last-modified-info' ),
        'default'     => __( 'Default', 'wp-last-modified-info' ),
        'custom'      => __( 'Custom', 'wp-last-modified-info' )
    );
    echo '<select id="post-sa" name="lmt_plugin_global_settings[lmt_show_author_cb]" style="width:14%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_show_author_cb'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?> 
    <span id="post-custom-author-sep" style="display:none;">&nbsp;&nbsp;<label for="custom-post-author-sep" style="font-size:13px;"><strong><?php _e( 'Separator:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <?php if(empty($options['lmt_post_author_sep'])){
        $options['lmt_post_author_sep'] = 'by';
    } ?>
    <input id="custom-post-author-sep" name="lmt_plugin_global_settings[lmt_post_author_sep]" type="text" size="6" style="width:6%;" placeholder="by" required value="<?php if (isset($options['lmt_post_author_sep'])) { echo htmlentities($options['lmt_post_author_sep']); } ?>" />
    </span>
    <span id="post-custom-author" style="display:none;">&nbsp;&nbsp;<label for="custom-post-author" style="font-size:13px;"><strong><?php _e( 'Select:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <?php
    if(!isset($options['lmt_show_author_list'])){
        $options['lmt_show_author_list'] = 1;
    }
    $users = get_users( apply_filters( 'wplmi_custom_author_list_selection', '' ) );
    echo '<select id="custom-post-author" name="lmt_plugin_global_settings[lmt_show_author_list]" style="width:20%;">';
    foreach( $users as $user ) {
        $selected = ($options['lmt_show_author_list'] == $user->ID) ? ' selected="selected"' : '';
        echo '<option value="' . $user->ID . '"' . $selected . '>' . $user->display_name . '</option>';
    }
    echo '</select>';
    ?>
    </span>
    <span id="post-author-link" style="display:none;">&nbsp;&nbsp;<label for="post-authorlink" style="font-size:13px;"><strong><?php _e( 'Link to:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
        <?php
        if(!isset($options['lmt_enable_author_hyperlink'])){
            $options['lmt_enable_author_hyperlink'] = 'none';
        }
        $redirects = array(
            'none'            => __( 'None', 'wp-last-modified-info' ),
            'author_page'     => __( 'Author Archive', 'wp-last-modified-info' ),
            'author_website'  => __( 'Author Website', 'wp-last-modified-info' ),
            'author_email'    => __( 'Author Email', 'wp-last-modified-info' )
        );
        echo '<select id="post-authorlink" name="lmt_plugin_global_settings[lmt_enable_author_hyperlink]" style="width:16%;">';
        foreach( $redirects as $redirect => $label ) {
            $selected = ($options['lmt_enable_author_hyperlink'] == $redirect) ? ' selected="selected"' : '';
            echo '<option value="' . $redirect . '"' . $selected . '>' . $label . '</option>';
        }
        echo '</select>';
        ?>
    </span> 
    &nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select how you want to display last modified author name on posts.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
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

    echo '<select id="cpt" name="lmt_plugin_global_settings[lmt_custom_post_types_list][]" multiple="multiple" style="width:80%;">';
    foreach( $post_types as $item ) {
        $selected = in_array( $item, $options['lmt_custom_post_types_list'] ) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $item . '</option>';
    }
    echo '</select>';
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select custom post types to show last modified info on selected post types only.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

/* ============================================================================================== 
                                           page options
============================================================================================== */

function lmt_enable_last_modified_page_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="page-enable" name="lmt_plugin_global_settings[lmt_enable_last_modified_page_cb]" value="1" <?php checked(isset($options['lmt_enable_last_modified_page_cb']), 1); ?> /> 
        <span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you want to show last modified info on pages.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_schema_on_page_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="page-enable-schema" name="lmt_plugin_global_settings[lmt_enable_schema_on_page_cb]" value="1" <?php checked(isset($options['lmt_enable_schema_on_page_cb']), 1); ?> /> 
        <span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you want to enable inline dateModified microdata schema markup on pages.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
   <?php
}

function lmt_show_last_modified_time_date_page_display() {
    $options = get_option('lmt_plugin_global_settings');

    if(!isset($options['lmt_show_last_modified_time_date_page'])){
        $options['lmt_show_last_modified_time_date_page'] = 'before_content';
    }
    $items = array(
        'before_content' => __( 'Before Content', 'wp-last-modified-info' ),
        'after_content'  => __( 'After Content', 'wp-last-modified-info' ),
        'manual'         => __( 'Manual (use shortcode)', 'wp-last-modified-info' )
    );
    echo '<select id="page-show-status" name="lmt_plugin_global_settings[lmt_show_last_modified_time_date_page]" style="width:23%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_show_last_modified_time_date_page'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select where you want to show last modified info on a page. If you select \'Before Content or After Content\', you can disable auto insert on particular posts from page edit screen > WP Last Modified Info meta box and apply shortcode on that particular page, if you want to.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_page_custom_text_display() {
    $options = get_option('lmt_plugin_global_settings');
    if(empty($options['lmt_page_custom_text'])){
        $options['lmt_page_custom_text'] = 'Last Updated on';
    }
    ?> <input id="page-custom-text" name="lmt_plugin_global_settings[lmt_page_custom_text]" type="text" size="30" style="width:30%;" required placeholder="<?php _e( 'Last Updated on', 'wp-last-modified-info' ); ?>" value="<?php if (isset($options['lmt_page_custom_text'])) { echo htmlentities($options['lmt_page_custom_text']); } ?>" />
       
    &nbsp;&nbsp;<label for="page-html-tag" style="font-size:13px;"><strong><?php _e( 'HTML Tag:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <?php if(!isset($options['lmt_html_tag_page'])){
        $options['lmt_html_tag_page'] = 'p';
    }
    $items = array(
        'p'     => '&lt;p&gt;',
        'span'  => '&lt;span&gt;'
    );
    echo '<select id="page-html-tag" name="lmt_plugin_global_settings[lmt_html_tag_page]" style="width:12%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_html_tag_page'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enter your custom text which will be shown on single page. You can also set a custom style from \'Custom CSS tab\' for this. Use \'page-last-modified\' as css class.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_last_modified_format_page_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_last_modified_format_page'])){
        $options['lmt_last_modified_format_page'] = 'default';
    }
    $items = array(
        'default'         => __( 'Traditional Format', 'wp-last-modified-info' ),
        'human_readable'  => __( 'Human Readable Format', 'wp-last-modified-info' )
    );
    echo '<select id="page-format" name="lmt_plugin_global_settings[lmt_last_modified_format_page]" style="width:25%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_last_modified_format_page'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    <span id="page-human-end-with" style="display:none;">&nbsp;&nbsp;<label for="page-ago-replace" style="font-size:13px;"><strong><?php _e( 'End with:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
        <?php if(empty($options['lmt_replace_ago_text_with_page'])){
            $options['lmt_replace_ago_text_with_page'] = 'ago';
        } ?>
        <input id="page-ago-replace" name="lmt_plugin_global_settings[lmt_replace_ago_text_with_page]" type="text" size="10" style="width:10%;" required placeholder="ago" value="<?php if (isset($options['lmt_replace_ago_text_with_page'])) { echo htmlentities($options['lmt_replace_ago_text_with_page']); } ?>" />
    </span>
    &nbsp;&nbsp;</span><span class="tooltip" title="<?php _e( 'Select last modified info format from here.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_last_modified_default_format_page_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_last_modified_default_format_page'])){
        $options['lmt_last_modified_default_format_page'] = 'only_date';
    }
    $items = array(
        'only_date'    => __( 'Only Date', 'wp-last-modified-info' ),
        'only_time'    => __( 'Only Time', 'wp-last-modified-info' ),
        'show_both'    => __( 'Show Both', 'wp-last-modified-info' )
    );
    echo '<select id="page-default-format" name="lmt_plugin_global_settings[lmt_last_modified_default_format_page]" style="width:13%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_last_modified_default_format_page'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>

    <span id="page-dtcf" style="display:none;">&nbsp;&nbsp;<label for="custom-page-date-format" style="font-size:13px;"><strong><?php _e( 'Date Format:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
        <?php if(empty($options['lmt_custom_page_date_format'])){
            $options['lmt_custom_page_date_format'] = get_option( 'date_format' );
        } ?>
        <input id="custom-page-date-format" name="lmt_plugin_global_settings[lmt_custom_page_date_format]" type="text" size="8" style="width:8%;" required placeholder="F jS, Y" value="<?php if (isset($options['lmt_custom_page_date_format'])) { echo $options['lmt_custom_page_date_format']; } ?>" />
    </span>

    <span id="page-dtsep" style="display:none;">&nbsp;&nbsp;<label for="custom-page-dtsep" style="font-size:13px;"><strong><?php _e( 'Separator:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
        <?php if(empty($options['lmt_page_date_time_sep'])){
            $options['lmt_page_date_time_sep'] = 'at';
        } ?>
        <input id="custom-page-dtsep" name="lmt_plugin_global_settings[lmt_page_date_time_sep]" type="text" size="6" style="width:6%;" required placeholder="at" value="<?php if (isset($options['lmt_page_date_time_sep'])) { echo htmlentities($options['lmt_page_date_time_sep']); } ?>" />
    </span>

    <span id="page-tmcf" style="display:none;">&nbsp;&nbsp;<label for="custom-page-time-format" style="font-size:13px;"><strong><?php _e( 'Time Format:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
        <?php if(empty($options['lmt_custom_page_time_format'])){
            $options['lmt_custom_page_time_format'] = get_option( 'time_format' );
        } ?>
        <input id="custom-page-time-format" name="lmt_plugin_global_settings[lmt_custom_page_time_format]" type="text" size="8" style="width:8%;" required placeholder="h:i a" value="<?php if (isset($options['lmt_custom_page_time_format'])) { echo $options['lmt_custom_page_time_format']; } ?>" />
    </span>

    &nbsp;&nbsp;</span><span class="tooltip" title="<?php _e( 'Select how you want to show last modified info on a page if Traditional Format is active.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_gap_on_page_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if( !isset($options['lmt_gap_on_page']) ) {
        $options['lmt_gap_on_page'] = 0;
    }
    $items = array(
        '0'        => __( 'No Gap', 'wp-last-modified-info' ),
        '86400'    => __( '1 day (24 hours)', 'wp-last-modified-info' ),
        '172800'   => __( '2 days (48 hours)', 'wp-last-modified-info' ),
        '259200'   => __( '3 days (72 hours)', 'wp-last-modified-info' ),
        '432000'   => __( '5 days (120 hours)', 'wp-last-modified-info' ),
        '604800'   => __( '7 days (168 hours)', 'wp-last-modified-info' ),
        '1296000'  => __( '15 days (360 hours)', 'wp-last-modified-info' ),
        '2592000'  => __( '30 days (720 hours)', 'wp-last-modified-info' )
    );
    $items = apply_filters( 'wplmi_add_custom_gap_items', $items );
    echo '<select id="page-gap" name="lmt_plugin_global_settings[lmt_gap_on_page]" style="width:20%;">';
    foreach( $items as $item => $label ) {
        $selected = ( $options['lmt_gap_on_page'] == $item ) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select the gap between published time and modified time. If modified time is greater than published time + gap, then it shows last modified info on frontend.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_show_author_page_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_author_page_cb'])){
        $options['lmt_show_author_page_cb'] = 'do_not_show';
    }
    $items = array(
        'do_not_show' => __( 'Do not show', 'wp-last-modified-info' ),
        'default'     => __( 'Default', 'wp-last-modified-info' ),
        'custom'      => __( 'Custom', 'wp-last-modified-info' )
    );
    echo '<select id="page-sa" name="lmt_plugin_global_settings[lmt_show_author_page_cb]" style="width:14%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_show_author_page_cb'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    <span id="page-custom-author-sep" style="display:none;">&nbsp;&nbsp;<label for="custom-page-author-sep" style="font-size:13px;"><strong><?php _e( 'Separator:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <?php if(empty($options['lmt_page_author_sep'])){
        $options['lmt_page_author_sep'] = 'by';
    } ?>
    <input id="custom-page-author-sep" name="lmt_plugin_global_settings[lmt_page_author_sep]" type="text" size="6" style="width:6%;" placeholder="by" required value="<?php if (isset($options['lmt_page_author_sep'])) { echo htmlentities($options['lmt_page_author_sep']); } ?>" />
    </span>
    <span id="page-custom-author" style="display:none;">&nbsp;&nbsp;<label for="custom-page-author" style="font-size:13px;"><strong><?php _e( 'Select:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <?php
    if(!isset($options['lmt_show_author_list_page'])){
        $options['lmt_show_author_list_page'] = 1;
    }
    $users = get_users( apply_filters( 'wplmi_custom_author_list_selection', '' ) );
    echo '<select id="custom-page-author" name="lmt_plugin_global_settings[lmt_show_author_list_page]" style="width:20%;">';
    foreach( $users as $user ) {
        $selected = ($options['lmt_show_author_list_page'] == $user->ID) ? ' selected="selected"' : '';
        echo '<option value="' . $user->ID . '"' . $selected . '>' . $user->display_name . '</option>';
    }
    echo '</select>';
    ?>
    </span>
    <span id="page-author-link" style="display:none;">&nbsp;&nbsp;<label for="page-authorlink" style="font-size:13px;"><strong><?php _e( 'Link to:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <?php
        if(!isset($options['lmt_enable_page_author_hyperlink'])){
            $options['lmt_enable_page_author_hyperlink'] = 'none';
        }
        $redirects = array(
            'none'            => __( 'None', 'wp-last-modified-info' ),
            'author_page'     => __( 'Author Archive', 'wp-last-modified-info' ),
            'author_website'  => __( 'Author Website', 'wp-last-modified-info' ),
            'author_email'    => __( 'Author Email', 'wp-last-modified-info' )
        );
        echo '<select id="page-authorlink" name="lmt_plugin_global_settings[lmt_enable_page_author_hyperlink]" style="width:16%;">';
        foreach( $redirects as $redirect => $label ) {
            $selected = ($options['lmt_enable_page_author_hyperlink'] == $redirect) ? ' selected="selected"' : '';
            echo '<option value="' . $redirect . '"' . $selected . '>' . $label . '</option>';
        }
        echo '</select>';
        ?>
    </span>
    &nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select how you want to display last modified author name on pages.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

/* ============================================================================================== 
                                         template tags options
============================================================================================== */

function lmt_tt_generatepress_theme_mod_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_tt_generatepress_theme_mod'])) {
        $options['lmt_tt_generatepress_theme_mod'] = 'none';
    }
    $items = array(
        'replace'   => __( 'Replace Post Meta', 'wp-last-modified-info' ),
        'none'      => __( 'Do Nothing', 'wp-last-modified-info' )
    );
    echo '<select id="lmt-tt-gpmod" name="lmt_plugin_global_settings[lmt_tt_generatepress_theme_mod]" style="width:20%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_tt_generatepress_theme_mod'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    &nbsp;&nbsp;</span><span class="tooltip" title="<?php _e( 'Enable the GeneratePress Theme Support form here. It will replace the post meta published date with post modified date.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_tt_astra_theme_mod_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_tt_astra_theme_mod'])) {
        $options['lmt_tt_astra_theme_mod'] = 'none';
    }
    $items = array(
        'replace'   => __( 'Replace Post Meta', 'wp-last-modified-info' ),
        'none'      => __( 'Do Nothing', 'wp-last-modified-info' )
    );
    echo '<select id="lmt-tt-gpmod" name="lmt_plugin_global_settings[lmt_tt_astra_theme_mod]" style="width:20%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_tt_astra_theme_mod'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    &nbsp;&nbsp;</span><span class="tooltip" title="<?php _e( 'Enable the Astra Theme Support form here. It will replace the post meta published date with post modified date.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_tt_updated_text_box_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?> <input id="lmt-tt-updated-text" name="lmt_plugin_global_settings[lmt_tt_updated_text_box]" type="text" size="40" style="width:40%;" placeholder="Updated on" value="<?php if (isset($options['lmt_tt_updated_text_box'])) { echo htmlentities( $options['lmt_tt_updated_text_box'] ); } ?>" />
        &nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'If you want to display any message before last modified date/time, set here.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_last_modified_format_tt_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_last_modified_format_tt'])){
        $options['lmt_last_modified_format_tt'] = 'default';
    }
    $items = array(
        'default'         => __( 'Traditional Format', 'wp-last-modified-info' ),
        'human_readable'  => __( 'Human Readable Format', 'wp-last-modified-info' )
    );
    echo '<select id="tt-format" name="lmt_plugin_global_settings[lmt_last_modified_format_tt]" style="width:25%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_last_modified_format_tt'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    <span id="tt-format-output" style="display:none;">&nbsp;&nbsp;<label for="lmt-tt-format" style="font-size:13px;"><strong><?php _e( 'Format:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
        <?php if(empty($options['lmt_tt_set_format_box'])){
            $options['lmt_tt_set_format_box'] = get_option( 'date_format' );
        } ?>
        <input id="lmt-tt-format" name="lmt_plugin_global_settings[lmt_tt_set_format_box]" type="text" size="20" style="width:20%;" required placeholder="F jS, Y @ h:i a" value="<?php if (isset($options['lmt_tt_set_format_box'])) { echo $options['lmt_tt_set_format_box']; } ?>" />
       </span>
    <span id="tt-human-end-with" style="display:none;">&nbsp;&nbsp;<label for="tt-ago-replace" style="font-size:13px;"><strong><?php _e( 'End with:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
        <?php if(empty($options['lmt_replace_ago_text_with_tt'])){
            $options['lmt_replace_ago_text_with_tt'] = 'ago';
        } ?>
        <input id="tt-ago-replace" name="lmt_plugin_global_settings[lmt_replace_ago_text_with_tt]" type="text" size="10" style="width:10%;" required placeholder="ago" value="<?php if (isset($options['lmt_replace_ago_text_with_tt'])) { echo htmlentities($options['lmt_replace_ago_text_with_tt']); } ?>" />
    </span>
    &nbsp;&nbsp;</span><span class="tooltip" title="<?php _e( 'Select last modified info format from here.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_show_author_tt_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_show_author_tt_cb'])){
        $options['lmt_show_author_tt_cb'] = 'do_not_show';
    }
    $items = array(
        'do_not_show' => __( 'Do not show', 'wp-last-modified-info' ),
        'default'     => __( 'Default', 'wp-last-modified-info' ),
        'custom'      => __( 'Custom', 'wp-last-modified-info' )
    );
    echo '<select id="lmt-tt-sa" name="lmt_plugin_global_settings[lmt_show_author_tt_cb]" style="width:14%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_show_author_tt_cb'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    <span id="tt-custom-author-sep" style="display:none;">&nbsp;&nbsp;<label for="custom-tt-author-sep" style="font-size:13px;"><strong><?php _e( 'Separator:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <?php if(empty($options['lmt_tt_author_sep'])){
        $options['lmt_tt_author_sep'] = 'by';
    } ?>
    <input id="custom-tt-author-sep" name="lmt_plugin_global_settings[lmt_tt_author_sep]" type="text" size="6" style="width:6%;" placeholder="by" required value="<?php if (isset($options['lmt_tt_author_sep'])) { echo htmlentities($options['lmt_tt_author_sep']); } ?>" />
    </span>

    <span id="tt-custom-author" style="display:none;">&nbsp;&nbsp;<label for="lmt-custom-tt-author" style="font-size:13px;"><strong><?php _e( 'Select:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <?php
    if(!isset($options['lmt_show_author_list_tt'])){
        $options['lmt_show_author_list_tt'] = 1;
    }
    $users = get_users( apply_filters( 'wplmi_custom_author_list_selection', '' ) );
    echo '<select id="lmt-custom-tt-author" name="lmt_plugin_global_settings[lmt_show_author_list_tt]" style="width:20%;">';
    foreach( $users as $user ) {
        $selected = ($options['lmt_show_author_list_tt'] == $user->ID) ? ' selected="selected"' : '';
        echo '<option value="' . $user->ID . '"' . $selected . '>' . $user->display_name . '</option>';
    }
    echo '</select>';
    ?>
    </span>
    <span id="tt-author-link" style="display:none;">&nbsp;&nbsp;<label for="lmt-tt-authorlink" style="font-size:13px;"><strong><?php _e( 'Link to:', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <?php
        if(!isset($options['lmt_enable_tt_author_hyperlink'])){
            $options['lmt_enable_tt_author_hyperlink'] = 'none';
        }
        $redirects = array(
            'none'            => __( 'None', 'wp-last-modified-info' ),
            'author_page'     => __( 'Author Archive', 'wp-last-modified-info' ),
            'author_website'  => __( 'Author Website', 'wp-last-modified-info' ),
            'author_email'    => __( 'Author Email', 'wp-last-modified-info' )
        );
        echo '<select id="lmt-tt-authorlink" name="lmt_plugin_global_settings[lmt_enable_tt_author_hyperlink]" style="width:16%;">';
        foreach( $redirects as $redirect => $label ) {
            $selected = ($options['lmt_enable_tt_author_hyperlink'] == $redirect) ? ' selected="selected"' : '';
            echo '<option value="' . $redirect . '"' . $selected . '>' . $label . '</option>';
        }
        echo '</select>';
        ?>
    </span>
    &nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select how you want to display last modified author name using template tags.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_tt_class_box_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?> <input id="lmt-tt-class" name="lmt_plugin_global_settings[lmt_tt_class_box]" type="text" size="50" style="width:50%;" placeholder="e.g. entry-time" value="<?php if (isset($options['lmt_tt_class_box'])) { echo $options['lmt_tt_class_box']; } ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;<span class="tt-enable-schema"><label for="enable-schema-tt"><strong><?php _e( 'Enable Inline Schema Markup?', 'wp-last-modified-info' ); ?></strong></label>&nbsp;&nbsp;
    <label class="switch">
        <input type="checkbox" id="enable-schema-tt" name="lmt_plugin_global_settings[lmt_tt_enable_schema_cb]" value="1" <?php checked(isset($options['lmt_tt_enable_schema_cb']), 1); ?> /> 
        <span class="cb-slider round"></span>
    </label></span>
    <?php
}

function lmt_tt_replace_published_date_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?> <textarea id="lmt-tt-replace" placeholder="&lt;i class=&#34;icon-clock&#34;&gt;&lt;/i&gt;%published_date%" name="lmt_plugin_global_settings[lmt_tt_replace_published_date]" rows="5" cols="90" style="width:90%;"><?php if (isset($options['lmt_tt_replace_published_date'])) { echo $options['lmt_tt_replace_published_date']; } ?></textarea>
    <br><span style="float: left;width: 90%;font-size: smaller;line-height: 1.9;"><?php printf(__( 'If you do not want to edit any theme files, you can replace your post published date with the post modified info by using this option. Use %1$s for published date and %2$s for modified date.', 'wp-last-modified-info' ), '<code>%published_date%</code>', '<code>%modified_date%</code>' ); ?></span>
    <?php
}

/* ============================================================================================== 
                                            schema options
============================================================================================== */

function lmt_enable_jsonld_markup_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_enable_jsonld_markup_cb'])){
        $options['lmt_enable_jsonld_markup_cb'] = 'disable';
    }
    $items = array(
        'enable'     => __( 'Default Mode (CreativeWork)', 'wp-last-modified-info' ),
        'inline'     => __( 'Inline Mode (MicroData)', 'wp-last-modified-info' ),
        'comp_mode'  => __( 'Compatibilty Mode (Advanced)', 'wp-last-modified-info' ),
        'disable'    => __( 'Disable Schema Markup', 'wp-last-modified-info' )
    );
    echo '<select id="schema-jsonld" name="lmt_plugin_global_settings[lmt_enable_jsonld_markup_cb]" style="width:32%;">';
    foreach( $items as $item => $label ) {
        $selected = ($options['lmt_enable_jsonld_markup_cb'] == $item) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    &nbsp;&nbsp;</span><span class="tooltip" title="<?php _e( 'Set the JSON-LD Markup mode if you want to show last modified info to search engines.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <div class="schema-text" style="font-size: 12px;margin-top: 5px;"><i><?php _e( 'If you already have a SEO plugin or a Schema Plugin on your site, then you can use this option. In this mode, this plugin will try to convert the post published date output of any SEO or Schema plugin to the post modified date. This is dynamically applied when the content is displayed, and the stored content is not changed. Tested with Yoast SEO, Rank Math, All in One SEO Pack, SEOPress, Schema and many other plugins.', 'wp-last-modified-info' ); ?></i></div>
    <?php
}

function lmt_enable_jsonld_markup_post_types_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if(!isset($options['lmt_enable_jsonld_markup_post_types'])){
        $options['lmt_enable_jsonld_markup_post_types'][] = '';
    }

    $post_types = get_post_types(array(
        'public'   => true,
    ), 'names'); 

    echo '<select id="schema-jsonld-pt" name="lmt_plugin_global_settings[lmt_enable_jsonld_markup_post_types][]" multiple="multiple" style="width:80%;">';
    foreach( $post_types as $item ) {
        $selected = in_array( $item, $options['lmt_enable_jsonld_markup_post_types'] ) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $item . '</option>';
    }
    echo '</select>';
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select on which post types you want to enable JSON-LD Markup.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_enable_schema_support_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="schema-support" name="lmt_plugin_global_settings[lmt_enable_schema_support_cb]" value="1" <?php checked(isset($options['lmt_enable_schema_support_cb']), 1); ?> /> 
        <span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if your theme does not support schema markup. This will add WebPage type schema support to the html tag. Please check Schema Markup before activate this option using Google Structured Data Tool. If Google already detects schema markup, you don\'t need to enable it anymore.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

/* ============================================================================================== 
                                        notification  options
============================================================================================== */

function lmt_enable_notification_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="noti-enable" name="lmt_plugin_global_settings[lmt_enable_notification_cb]" value="1" <?php checked(isset($options['lmt_enable_notification_cb']), 1); ?> /> 
        <span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you want to receive email notification if anyone makes changes to any post of your blog.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
   <?php
}

function lmt_enable_author_noti_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="noti-author" name="lmt_plugin_global_settings[lmt_enable_author_noti_cb]" value="1" <?php checked(isset($options['lmt_enable_author_noti_cb']), 1); ?> /> 
        <span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you want to send notification to the post author.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
   <?php
}

function lmt_enable_draft_noti_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="noti-draft" name="lmt_plugin_global_settings[lmt_enable_draft_noti_cb]" value="1" <?php checked(isset($options['lmt_enable_draft_noti_cb']), 1); ?> /> 
        <span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you want to enable notification when anyone makes changes to any draft post.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
   <?php
}

function lmt_email_recipient_display() {
    $options = get_option( 'lmt_plugin_global_settings' );
    if( !isset($options['lmt_email_recipient']) ) {
        $options['lmt_email_recipient'] = get_bloginfo( 'admin_email' );
    } ?> 
    <input id="noti-email-receive" name="lmt_plugin_global_settings[lmt_email_recipient]" type="text" size="100" style="width:100%;" required placeholder="admin@yoursite.com" value="<?php if (isset($options['lmt_email_recipient'])) { echo $options['lmt_email_recipient']; } ?>" />
    <?php
}

function lmt_enable_noti_post_types_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if( !isset($options['lmt_enable_noti_post_types']) ) {
        $options['lmt_enable_noti_post_types'] = array( 'post', 'page' );
    }

    $post_types = get_post_types(array(
        'public'   => true,
    ), 'names'); 

    echo '<select id="noti-pt" name="lmt_plugin_global_settings[lmt_enable_noti_post_types][]" multiple="multiple" required style="width:100%;">';
    foreach( $post_types as $post_type ) {
        if ( post_type_supports( $post_type, 'revisions' ) ) {
            $selected = in_array( $post_type, $options['lmt_enable_noti_post_types'] ) ? ' selected="selected"' : '';
            echo '<option value="' . $post_type . '"' . $selected . '>' . $post_type . '</option>';
        }
    }
    echo '</select>';
}

function lmt_email_subject_display() {
    $options = get_option('lmt_plugin_global_settings');
    if( empty($options['lmt_email_subject']) ) {
        $options['lmt_email_subject'] = __( '[%site_name%] A %post_type% of %author_name% has been modified on your blog.', 'wp-last-modified-info' );
    }
    ?> <input id="email-sub" name="lmt_plugin_global_settings[lmt_email_subject]" type="text" size="100" style="width:100%;" value="<?php if (isset($options['lmt_email_subject'])) { echo htmlentities( $options['lmt_email_subject'] ); } ?>" />
        <br>
    <?php printf(
		'<small style="line-height: 2;"><i>%s</i><code>&#37;post_title&#37;</code> <code>&#37;author_name&#37;</code> <code>&#37;post_type&#37;</code> <code>&#37;site_name&#37;</code> <code>&#37;site_url&#37;</code> <code>&#37;current_time&#37;</code><small>',
		__( 'Use these tags into email subject - ', 'wp-last-modified-info' )
	);
}

function lmt_email_message_display() {
    $options = get_option('lmt_plugin_global_settings');
    $emailBody = $options['lmt_email_message'];
    if( empty( $emailBody ) ) {
        $emailBody = __( 'The following changes are made on a %post_type% of your blog by ', 'wp-last-modified-info' ) . '%modified_author_name%' . "\n\n" . '<p><strong>Post: %post_title%</strong></p><p>%post_diff%</p>';
    }
    $emailBody = html_entity_decode( $emailBody, ENT_COMPAT, "UTF-8" );

    $args = array(
        'textarea_name'   => 'lmt_plugin_global_settings[lmt_email_message]',
        'textarea_rows'   => '8',
        'teeny'           => true,
        'tinymce'         => false,
        'media_buttons'   => false,
    );
    wp_editor( $emailBody, 'email-msg', $args );
    printf(
		'<small style="line-height: 2;"><i>%1$s</i><code>&#37;admin_email&#37;</code> <code>&#37;post_title&#37;</code> <code>&#37;author_name&#37;</code> <code>&#37;modified_author_name&#37;</code> <code>&#37;post_type&#37;</code> <code>&#37;post_edit_link&#37;</code> <code>&#37;site_name&#37;</code> <code>&#37;site_url&#37;</code> <code>&#37;current_time&#37;</code> <code>&#37;post_diff&#37;</code><i>. %2$s</i><small>',
		__( 'Use these tags into email body - ', 'wp-last-modified-info' ), __( 'Email body supports HTML.', 'wp-last-modified-info' )
	);
}

/* ============================================================================================== 
                                            misc options
============================================================================================== */

function lmt_enable_on_admin_bar_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="admin-bar-display" name="lmt_plugin_global_settings[lmt_enable_on_admin_bar_cb]" value="1" <?php checked(isset($options['lmt_enable_on_admin_bar_cb']), 1); ?> /> 
        <span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you want to show last modified info on wordpress admin bar.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_admin_default_sort_order_display() {
    $options = get_option('lmt_plugin_global_settings');
    
    if( !isset($options['lmt_admin_default_sort_order']) ) {
        $options['lmt_admin_default_sort_order'] = 'default';
    }
    $items = array(
        'default'     => __( 'Default Order', 'wp-last-modified-info' ),
        'modified'    => __( 'Modified Post First', 'wp-last-modified-info' ),
        'published'   => __( 'Modified Post Last', 'wp-last-modified-info' )
    );
    echo '<select id="lmt-order" name="lmt_plugin_global_settings[lmt_admin_default_sort_order]" style="width:20%;">';
    foreach( $items as $item => $label ) {
        $selected = ( $options['lmt_admin_default_sort_order'] == $item ) ? ' selected="selected"' : '';
        echo '<option value="' . $item . '"' . $selected . '>' . $label . '</option>';
    }
    echo '</select>';
    ?>
    &nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Select the post sorting order in Admin Edit page in Backend.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

function lmt_custom_style_box_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>   <textarea id="lmt-cus-style" placeholder=".post-last-modified, .page-last-modified { color: #000000; font-weight: bold; }" name="lmt_plugin_global_settings[lmt_custom_style_box]" rows="8" cols="100" style="width:90%;"><?php if (isset($options['lmt_custom_style_box'])) { echo $options['lmt_custom_style_box']; } ?></textarea>
    <br><small><?php printf(__( 'Do not add %s tag. This tag is not required, as it is already added.', 'wp-last-modified-info' ), '<code>&lt;style&gt; &lt;/style&gt;</code>'); ?></small>
    <?php
}

function lmt_del_plugin_data_cb_display() {
    $options = get_option('lmt_plugin_global_settings');
    ?>  <label class="switch">
        <input type="checkbox" id="del-data" name="lmt_plugin_global_settings[lmt_del_plugin_data_cb]" value="1" <?php checked(isset($options['lmt_del_plugin_data_cb']), 1); ?> /> 
        <span class="cb-slider round"></span></label>&nbsp;&nbsp;&nbsp;<span class="tooltip" title="<?php _e( 'Enable this if you want to delete plugin data at the time of uninstallation.', 'wp-last-modified-info' ); ?>"><span title="" class="dashicons dashicons-editor-help"></span></span>
    <?php
}

?>