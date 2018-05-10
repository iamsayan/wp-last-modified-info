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

	wp_add_dashboard_widget(
                 'lmt_dashboard_widget',         // Widget slug.
                 'Last Updated Posts',         // Title.
                 'lmt_dashboard_widget_function' // Display function.
        );	
}
add_action( 'wp_dashboard_setup', 'lmt_add_dashboard_widgets' );

/**
 * Create the function to output the contents of  Dashboard Widget.
 */
function lmt_dashboard_widget_function() {
    ?>
        <div id="published-posts" class="lmt-updated-posts-block">
            <h3>Recently Modified</h3>
                <ul>
<?php
	// Show recently modified posts
	$recently_updated_posts = new WP_Query( array(
		'post_type'      => 'post',
		'posts_per_page' => 5,
		'orderby'        => 'modified',
		'no_found_rows'  => true // speed up query when we don't need pagination
		//'category_name'  => 'uncategorized' // Only display posts from the category with the slug "news"
	) );
	if ( $recently_updated_posts->have_posts() ) :
		while( $recently_updated_posts->have_posts() ) : $recently_updated_posts->the_post(); ?>
                <li>
                    <span><?php the_modified_time('M jS,' . get_option( 'time_format' )); ?></span>
                    <?php edit_post_link(esc_attr( get_the_title() )); ?> &nbsp;<font color="#E3DDE3">|</font>&nbsp; <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank">View Post</a>
                </li>
        <?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>
    </ul>
    </div>
<?php
}

?>