<?php

/**
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 * @since     v1.1.8
 *
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function lmt_add_dashboard_widgets() {

    global $wp_meta_boxes;
	wp_add_dashboard_widget(
                 'last_modified_posts_widget', // Widget slug.
                 'Last Updated Posts', // Title.
                 'lmt_dashboard_widget_box_callback', // callback.
                 'lmt_dashboard_widget_control_callback' // control callback.
        );	
}
add_action( 'wp_dashboard_setup', 'lmt_add_dashboard_widgets' );

function lmt_dashboard_widget_control_callback() {
    
    // Get widget options
    $widget_options = get_option( 'lmt_dashboard_widget_options' );
    $value = isset($widget_options['number']) ? esc_attr($widget_options['number']) : '';
    // Update widget options
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['lmt_widget_post']) ) {
        update_option( 'lmt_dashboard_widget_options', $_POST['lmt_widget_value'] );
    } ?>
    <p>
        <label for="widget-post-no"><strong><?php _e('No. of Posts to Display on this Widget: ', 'wp-last-modified-info'); ?></strong></label>
        &nbsp;&nbsp;&nbsp;<input class="widefat" id="widget-post-no" name="lmt_widget_value[number]" type="number" size="15" style="width:15%;" placeholder="5" min="3" value="<?php echo $value; ?>" />
    </p>
    <input name="lmt_widget_post" type="hidden" value="1" />
<?php
}

/**
 * Create the function to output the contents of  Dashboard Widget.
 */
function lmt_dashboard_widget_box_callback($widget_id) {
    ?><div id="activity-widget" style="margin-top:-10px;margin-bottom:-14px;">
        <div id="published-posts" class="activity-block">
            <h3>Recently Updated</h3>
                <ul class="subsubsub1"> <?php

    global $post, $post_id, $current_user;
    //wp_get_current_user();
    $options = get_option('lmt_plugin_global_settings');
    $widget_options = get_option( 'lmt_dashboard_widget_options' );

    if(!empty($widget_options['number'])) {
        $num = $widget_options['number'];
    } else {
        $num = '5';
    }

if ( isset($num) ) {
	// Show recently modified posts
	$recently_updated_posts = new WP_Query( array(
		'post_type'      => 'post',
		'posts_per_page' => $num,
		'orderby'        => 'modified',
        'no_found_rows'  => true, // speed up query when we don't need pagination
        //'author' => $current_user->ID
		//'category_name'  => $cat// Only display posts from the category with the slug "news"
    ) );
}
	if ( $recently_updated_posts->have_posts() ) :
		while( $recently_updated_posts->have_posts() ) : $recently_updated_posts->the_post(); ?>
                <li>
                    <span><?php the_modified_time('M jS, ' . get_option( 'time_format' )); ?></span>
                    <?php if( current_user_can('edit_post', $post_id) ) {
                            edit_post_link(esc_attr( get_the_title() ));
                        } else {
                            echo '<a href="' . get_the_permalink() . '" target="_blank" title="' . get_the_title() . '">' . get_the_title() . '</a>';
                        } ?> &nbsp;<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank"><span class="dashicons dashicons-external" style="font-size:16px;margin-left:0px;min-width:0px;"></span></a>
                </li>
        <?php endwhile;
        wp_reset_postdata();
    endif; ?>
            </ul>
        </div>
    </div>
<?php
}

?>