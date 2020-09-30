<?php
/**
 * Dashboard widget.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Core\Backend;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Dashboard widget class.
 */
class DashboardWidget
{
	use HelperFunctions, Hooker;

	/**
	 * Register functions.
	 */
	public function register() 
	{
		$this->action( 'wp_dashboard_setup', 'dashboard_widget' );
		$this->action( 'admin_head-index.php', 'widget_css' );
	}

	/**
	 * Register dashboard widgets.
	 */
	public function dashboard_widget()
	{
		global $wp_meta_boxes;
		wp_add_dashboard_widget(
			'dashboard_last_modified_posts', // Widget slug.
			__( 'Last Updated Posts', 'wp-last-modified-info' ), // Title.
			[ $this, 'widget_callback' ], // callback.
			[ $this, 'widget_control_callback' ] // control callback.
		);
	}

	/**
	 * Dashboard widget callback.
	 * 
	 * @param string $widget_id Widget ID
	 */
	public function widget_callback( $widget_id )
	{
        global $post;
        // Save the global post object so we can restore it later
    	$save_post = $post;
        // get widget options
        $widget_options = get_option( 'lmt_dashboard_widget_options' );
        // get wordpress date time format
        $get_df = get_option( 'date_format' );
        $get_tf = get_option( 'time_format' );
    
        $num = ! empty( $widget_options['number'] ) ? esc_attr( $widget_options['number'] ) : 5;
    
        if ( isset( $num ) ) {
    	    // Show recently modified posts
    	    $posts = get_posts( $this->do_filter( 'dashboard_widget_args', [
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => $num,
				'orderby'        => 'modified',
				'no_found_rows'  => true,
            ] ) );
            ?>
			<div id="activity-widget"><?php
            if ( ! empty( $posts ) ) { ?>
                <div id="published-posts" class="activity-block">
                    <h3><?php _e( 'Recently Updated', 'wp-last-modified-info' ); ?></h3>
                    <ul> <?php
                        foreach ( $posts as $post ) : 
                            setup_postdata( $post ); ?>
                            <li>
                                <span><?php the_modified_time( 'M jS, ' . $get_tf ); ?></span>
                                <?php if ( current_user_can( 'edit_post', get_the_ID() ) ) {
                                        edit_post_link( esc_attr( get_the_title() ) );
                                    } else {
                                        echo '<a href="' . get_the_permalink() . '" target="_blank" title="' . get_the_title() . '">' . get_the_title() . '</a>';
                                    } ?> &nbsp;<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank"><span class="dashicons dashicons-external" style="font-size:15px;margin-left:0px;min-width:0px;"></span></a>
                            </li>
                        <?php endforeach;
    		            wp_reset_postdata();
    		            // Restore the global post object
    		            $post = $save_post; ?>
                    </ul>
                </div>
            <?php } else { ?>
                <div class="no-activity"><p><?php _e( 'No modified posts yet!', 'wp-last-modified-info' ); ?></p></div>
            <?php } ?>
        </div> <?php
        }
    }

	/**
	 * Dashboard widget control callback.
	 */
	public function widget_control_callback()
	{
		// Get widget options
		$widget_options = get_option( 'lmt_dashboard_widget_options' );
		$value = isset( $widget_options['number'] ) ? esc_attr( $widget_options['number'] ) : '';
		// Update widget options
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['wplmi_widget_post'] ) ) {
			update_option( 'lmt_dashboard_widget_options', $_POST['wplmi_widget_value'] );
		} ?>
		<p>
			<label for="post-count"><strong><?php _e( 'No. of Posts to Display on this Widget', 'wp-last-modified-info' ); ?>:</strong></label>
			&nbsp;&nbsp;&nbsp;<input class="widefat" id="post-count" name="wplmi_widget_value[number]" type="number" size="15" style="width:15%;vertical-align: middle;" placeholder="5" min="3" value="<?php echo $value; ?>" /><input name="wplmi_widget_post" type="hidden" value="1" />
		</p>
		<?php
	}

	/**
	 * Locad custom css for dashboard widget.
	 */
	public function widget_css()
	{ ?>
		<style type="text/css">
			#dashboard_last_modified_posts .no-activity p {
				color: #72777c;
				font-size: 16px;
			}
			#dashboard_last_modified_posts .no-activity {
				overflow: hidden;
				padding: 12px 0;
				text-align: center;
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
}