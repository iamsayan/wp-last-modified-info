<?php
/**
 * Filter post statuses.
 *
 * @since      1.7.6
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend
 * @author     Sayan Datta <iamsayan@protonmail.com>
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
	use HelperFunctions;
	use Hooker;

	/**
	 * Register hooks.
	 */
	public function register() {
		$this->action( 'admin_init', 'init' );
	}

	/**
	 * Initialize hooks for post list views and filtering.
	 */
	public function init() {
		// Only proceed in admin area.
		if ( ! is_admin() ) {
			return;
		}

		$this->filter( 'pre_get_posts', 'filter_posts' );

		// Hook into views for all public post types.
		foreach ( get_post_types( [ 'public' => true ], 'names' ) as $post_type ) {
			$this->action( "views_edit-{$post_type}", 'content_filter' );
		}
	}

	/**
	 * Add “Lock Modified” filter link to list table views.
	 *
	 * @param string[] $views Associative array of view links.
	 * @return string[]
	 */
	public function content_filter( $views ) {
		global $typenow;

		// Ensure we are on a valid edit screen.
		if ( empty( $typenow ) || ! post_type_exists( $typenow ) ) {
			return $views;
		}

		// Allow developers to disable the link.
		if ( ! $this->do_filter( 'show_filter_link', true, $typenow ) ) {
			return $views;
		}

		// Check if the current view is active.
		$current = isset( $_GET['update_locked'] ) && '1' === $_GET['update_locked'] ? ' class="current" aria-current="page"' : '';

		// Fast count query: only IDs, no post objects.
		$locked_ids = get_posts( [
			'post_type'      => $typenow,
			'post_status'    => [ 'publish', 'draft', 'private' ],
			'fields'         => 'ids',
			'posts_per_page' => -1,
			'meta_query'     => [
				[
					'key'     => '_lmt_disableupdate',
					'value'   => 'yes',
					'compare' => '=',
				],
			],
			// Ignore filters that might exclude posts.
			'suppress_filters' => true,
		] );

		$count = count( $locked_ids );

		if ( $count > 0 ) {
			$views['update_locked'] = sprintf(
				'<a href="%1$s"%2$s>%3$s <span class="count">(%4$s)</span></a>',
				esc_url( add_query_arg( [
					'post_type'     => $typenow,
					'update_locked' => '1',
				], admin_url( 'edit.php' ) ) ),
				$current,
				esc_html__( 'Lock Modified', 'wp-last-modified-info' ),
				number_format_i18n( $count )
			);
		}

		return $views;
	}

	/**
	 * Filter the posts query to show only “locked” posts when requested.
	 *
	 * @param \WP_Query $query WP_Query instance (passed by reference).
	 */
	public function filter_posts( $query ) {
		// Only apply in admin and for main query.
		if ( ! is_admin() || ! $query->is_main_query() ) {
			return;
		}

		// Only apply on edit.php screen.
		if ( ! isset( $GLOBALS['pagenow'] ) || 'edit.php' !== $GLOBALS['pagenow'] ) {
			return;
		}

		// Apply the meta filter when the locked view is selected.
		if ( isset( $_GET['update_locked'] ) && '1' === $_GET['update_locked'] ) {
			$meta_query = $query->get( 'meta_query', [] );
			$meta_query[] = [
				'key'     => '_lmt_disableupdate',
				'value'   => 'yes',
				'compare' => '=',
			];
			$query->set( 'meta_query', $meta_query );
		}
	}
}
