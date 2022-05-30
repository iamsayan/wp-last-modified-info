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

use WP_Query;
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
	public function register() {
		$this->action( 'wp_dashboard_setup', 'dashboard_widget' );
		$this->action( 'admin_head-index.php', 'widget_css' );
	}

	/**
	 * Register dashboard widgets.
	 */
	public function dashboard_widget() {
		global $wp_meta_boxes;
		
		\wp_add_dashboard_widget(
			'dashboard_last_modified_posts', // Widget slug.
			__( 'Last Updated', 'wp-last-modified-info' ), // Title.
			[ $this, 'widget_callback' ], // callback.
			[ $this, 'widget_control_callback' ] // control callback.
		);
	}

	/**
	 * Dashboard widget callback.
	 */
	public function widget_callback() {
		$timestamp = current_time( 'timestamp', 0 );

		$widget_options = get_option( 'lmt_dashboard_widget_options' );
        $num = ! empty( $widget_options['number'] ) ? intval( $widget_options['number'] ) : 5;

		$args = $this->do_filter( 'dashboard_widget_args', [
			'post_type'        => 'post',
			'post_status'      => 'publish',
			'posts_per_page'   => $num,
			'orderby'          => 'modified',
			'order'            => 'DESC',
			'no_found_rows'    => true,
			'suppress_filters' => true,
		] );
		$posts = new WP_Query( $args );

		echo '<div id="activity-widget">';

	    if ( $posts->have_posts() ) {

			echo '<div id="published-posts" class="activity-block">';
			echo '<h3>' .  esc_html__( 'Recently Updated', 'wp-last-modified-info' ) . '</h3>';
			echo '<ul>';

			$today    = gmdate( 'Y-m-d', $timestamp );
		    $tomorrow = gmdate( 'Y-m-d', strtotime( '+1 day', $timestamp ) );

            while ( $posts->have_posts() ) {
				$posts->the_post();
	
				$modified_timestamp = get_post_modified_time( 'U' );
			    if ( gmdate( 'Y-m-d', $modified_timestamp ) == $today ) {
			    	$relative = __( 'Today' );
			    } elseif ( gmdate( 'Y-m-d', $modified_timestamp ) == $tomorrow ) {
			    	$relative = __( 'Tomorrow' );
			    } elseif ( gmdate( 'Y', $modified_timestamp ) !== gmdate( 'Y', $timestamp ) ) {
			    	/* translators: Date and time format for recent posts on the dashboard, from a different calendar year, see https://www.php.net/date */
			    	$relative = date_i18n( 'M jS Y', $modified_timestamp );
			    } else {
			    	/* translators: Date and time format for recent posts on the dashboard, see https://www.php.net/date */
			    	$relative = date_i18n( 'M jS', $modified_timestamp );
			    }
				
				// Use the post edit link for those who can edit, the permalink otherwise.
			    $recent_post_link = current_user_can( 'edit_post', get_the_ID() ) ? get_edit_post_link() : get_permalink();
    
			    $draft_or_post_title = _draft_or_post_title();
			    printf(
			    	'<li><span>%1$s</span> <a href="%2$s" aria-label="%3$s">%4$s</a></li>',
			    	/* translators: 1: Relative date, 2: Time. */
			    	sprintf( _x( '%1$s, %2$s', 'dashboard' ), $relative, date_i18n( get_option( 'time_format' ), $modified_timestamp ) ),
			    	$recent_post_link,
			    	/* translators: %s: Post title. */
			    	esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;' ), $draft_or_post_title ) ),
					$draft_or_post_title
				);
			}
						
		    echo '</ul>';
			echo '</div>';
				
		} else {

			echo '<div class="no-activity">';
			echo '<p class="smiley" aria-hidden="true"></p>';
			echo '<p>' . __( 'No modified posts yet!' ) . '</p>';
			echo '</div>';
			
		}
		wp_reset_postdata();

		echo '</div>';
    }

	/**
	 * Dashboard widget control callback.
	 */
	public function widget_control_callback() {
		// Update widget options
		if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['wplmi_widget_options'] ) ) {
			check_admin_referer();
			update_option( 'lmt_dashboard_widget_options', array_map( 'intval', $_POST['wplmi_widget_options'] ) );
		} 

		// Get widget options
		$widget_options = get_option( 'lmt_dashboard_widget_options' );
		$value = isset( $widget_options['number'] ) ? $widget_options['number'] : '';
		
		wp_nonce_field(); ?>
		<table>
			<tr>
				<td><label for="post-count"><strong><?php esc_html_e( 'Number of Posts to Display', 'wp-last-modified-info' ); ?>:</strong></label></td>
				<td><input class="widefat" id="post-count" name="wplmi_widget_options[number]" type="number" placeholder="5" min="3" max="100" value="<?php echo esc_attr( $value ); ?>" /></td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Locad custom css for dashboard widget.
	 */
	public function widget_css() { ?>
		<style type="text/css">
			#dashboard_last_modified_posts table {
				width: 100%;
				margin-bottom: 15px;
			}
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
				padding-top: 12px;
				padding-bottom: 15px;
			}
		</style>
	<?php }
}