<?php
/**
 * Filter post statuses.
 *
 * @since      1.7.6
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Core\Backend;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Filter post statuses class.
 */
class PostStatusFilters
{
	use HelperFunctions, Hooker;

	/**
	 * Register functions.
	 */
	public function register()
	{
		$this->action( 'admin_init', 'init' );
	}

	/**
	 * Hook to views content action.
	 */
	public function init()
	{
		$this->filter( 'pre_get_posts', 'filter_posts' );

		$post_types = get_post_types();
		foreach( $post_types as $post_type ) {
			$this->action( "views_edit-{$post_type}", 'content_filter' );
		}
	}

	/**
	 * Add view to filter list for Pending.
	 *
	 * @param array $views An array of available list table views.
	 */
	public function content_filter( $views )
	{
		global $typenow;

		$enabled = $this->do_filter( 'show_filter_link', true, $typenow );
		$current = empty( $_GET['update_disabled'] ) ? '' : ' class="current" aria-current="page"';
		$get_posts = get_posts(
			[
				'post_type'      => $typenow,
				'fields'         => 'ids',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'meta_query'     => [
		    	    [
						'key'     => '_lmt_disableupdate',
						'value'   => 'yes',
		    	    	'compare' => '='
		    	    ]
				]
			]
		);

		if ( count( $get_posts ) > 0 && $enabled ) {
	    	$views['update_disabled'] = sprintf(
	    		'<a href="%1$s"%2$s>%3$s <span class="count">(%4$s)</span></a>',
	    		add_query_arg(
	    			[
	    				'post_type'    => $typenow,
	    				'update_disabled' => 1,
	    			],
	    		    admin_url( 'edit.php' ) 
	    	    ),
	    		$current,
	    		esc_html__( 'Update Disabled', 'wp-auto-republish' ),
	    		number_format_i18n( count( $get_posts ) )
	    	);
	    }
    
		return $views;
	}

	/**
	 * Filter posts in admin by Post meta value.
	 *
	 * @param \WP_Query $query The wp_query instance.
	 */
	public function filter_posts( $query )
	{
		if ( ! is_admin() ) {
			return;
		}

		if ( ! empty( $_GET['update_disabled'] ) ) {
		    $meta_query = [
				[
		    		'key'     => '_lmt_disableupdate',
					'value'   => 'yes',
		    	    'compare' => '='
		    	]
			];
			
			$query->set( 'meta_query', $meta_query );
		}
	}
}