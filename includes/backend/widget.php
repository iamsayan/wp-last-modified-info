<?php

/**
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 * @since     v1.1.8
 *
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action.
 */

add_action( 'wp_dashboard_setup', 'lmt_add_dashboard_widgets' );
add_action( 'admin_head', 'lmt_load_custom_css_to_admin_head' );

function lmt_add_dashboard_widgets() {
    global $wp_meta_boxes;

	wp_add_dashboard_widget(
                 'dashboard_last_modified_posts', // Widget slug.
                 __('Last Updated Posts', 'wp-last-modified-info' ), // Title.
                 'lmt_dashboard_widget_box_callback', // callback.
                 'lmt_dashboard_widget_control_callback' // control callback.
        );	
}

function lmt_dashboard_widget_control_callback() {
    // Get widget options
    $widget_options = get_option( 'lmt_dashboard_widget_options' );
    $value = isset($widget_options['number']) ? esc_attr($widget_options['number']) : '';
    // Update widget options
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['lmt_widget_post'] ) ) {
        update_option( 'lmt_dashboard_widget_options', $_POST['lmt_widget_value'] );
    } ?>
    <p>
        <label for="widget-post-no"><strong><?php _e( 'No. of Posts to Display on this Widget:', 'wp-last-modified-info' ); ?></strong></label>
        &nbsp;&nbsp;&nbsp;<input class="widefat" id="widget-post-no" name="lmt_widget_value[number]" type="number" size="15" style="width:15%;vertical-align: middle;" placeholder="5" min="3" value="<?php echo $value; ?>" /><input name="lmt_widget_post" type="hidden" value="1" />
    </p>
    <?php
}

/**
 * Create the function to output the contents of  Dashboard Widget.
 */
function lmt_dashboard_widget_box_callback( $widget_id ) { ?>
<div id="activity-widget"> <?php
    
    global $post, $post_id, $current_user;
    // get plugin options
    $options = get_option('lmt_plugin_global_settings');
    // get widget options
    $widget_options = get_option( 'lmt_dashboard_widget_options' );
    // get wordpress date time format
    $get_df = get_option( 'date_format' );
    $get_tf = get_option( 'time_format' );

    $num = !empty( $widget_options['number'] ) ? esc_attr( $widget_options['number'] ) : 5;

    if ( isset($num) ) {
	    // Show recently modified posts
	    $recently_updated_posts = new WP_Query( array(
		    'post_type'      => 'post',
		    'post_status'    => 'publish',
		    'posts_per_page' => $num,
		    'orderby'        => 'modified',
            'no_found_rows'  => true,
        ) );
    }

    if( $recently_updated_posts->have_posts() ) { ?>
        <div id="published-posts" class="activity-block">
            <h3><?php _e( 'Recently Updated', 'wp-last-modified-info' ); ?></h3>
            <ul> <?php
	            while( $recently_updated_posts->have_posts() ) : $recently_updated_posts->the_post(); ?>
                    <li>
                        <span><?php the_modified_time( 'M jS, ' . $get_tf ); ?></span>
                        <?php if( current_user_can( 'edit_post', $post_id ) ) {
                                edit_post_link( esc_attr( get_the_title() ) );
                            } else {
                                echo '<a href="' . get_the_permalink() . '" target="_blank" title="' . get_the_title() . '">' . get_the_title() . '</a>';
                            } ?> &nbsp;<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank"><span class="dashicons dashicons-external" style="font-size:15px;margin-left:0px;min-width:0px;"></span></a>
                    </li>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </ul>
        </div>
    <?php } else { ?>
        <div class="no-activity"><p class="smiley" aria-hidden="true"></p><p>No modified posts yet!</p></div>
    <?php } ?>
</div> <?php
}

function lmt_load_custom_css_to_admin_head() { ?>
    <style>
        #dashboard_last_modified_posts .no-activity .smiley {
            margin-top: 0;
        }
        #dashboard_last_modified_posts .no-activity p {
            color: #72777c;
            font-size: 16px;
        }
        #dashboard_last_modified_posts .no-activity {
            overflow: hidden;
            padding: 0 0 12px;
            text-align: center;
        }
        #dashboard_last_modified_posts .no-activity .smiley:before {
            content: "\f328";
            font: normal 120px/1 dashicons;
            speak: none;
            display: block;
            margin: 0 5px 0 0;
            padding: 0;
            text-indent: 0;
            text-align: center;
            position: relative;
            -webkit-font-smoothing: antialiased;
            text-decoration: none!important;
        }
        #dashboard_last_modified_posts .inside {
            margin: 0;
            padding-bottom: 0;
        }

        #dashboard_last_modified_posts .dashboard-widget-control-form {
            padding-top: 10px;
            padding-bottom: 15px;
        }
    </style>
<?php }

?>