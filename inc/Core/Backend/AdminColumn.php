<?php
/**
 * Shows last modified infos on admin colums.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Core\Backend;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\SettingsData;

defined( 'ABSPATH' ) || exit;

/**
 * Admin Column class.
 */
class AdminColumn
{
	use Hooker;
	use SettingsData;

	/**
	 * Register hooks.
	 */
	public function register() {
		$this->action( 'admin_init', 'generate_column' );
		$this->action( 'admin_head-edit.php', 'style' );
	}

	/**
	 * Register column hooks for supported post types.
	 */
	public function generate_column() {
		$post_types = get_post_types( $this->do_filter( 'admin_column_post_types', [] ), 'names' );
		foreach ( $post_types as $post_type ) {
			// Add column
			$this->filter( "manage_{$post_type}_posts_columns", 'column_title' );
			$this->filter( "manage_edit-{$post_type}_columns", 'column_title' );

			// Make sortable
			$this->filter( "manage_{$post_type}_sortable_columns", 'column_sortable' );
			$this->filter( "manage_edit-{$post_type}_sortable_columns", 'column_sortable' );

			// Populate data
			$this->action( "manage_{$post_type}_posts_custom_column", 'column_data', 10, 2 );
		}
	}

	/**
	 * Render column content.
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 */
	public function column_data( $column, $post_id ) {
		if ( 'lastmodified' !== $column ) {
			return;
		}

		$post = get_post( $post_id );
		if ( ! $post ) {
			return;
		}

		$disabled = $this->get_meta( $post->ID, '_lmt_disableupdate' ) ?? 'no';
		$modified = $this->format_modified_date( $post );

		$html  = $modified;
		$author = get_the_modified_author( $post );

		if ( $author ) {
			$html .= '<br>' . esc_html__( 'by', 'wp-last-modified-info' ) . ' <strong>' . esc_html( $author ) . '</strong>';
		}

		if ( ! in_array( $post->post_status, [ 'auto-draft', 'future' ], true ) ) {
			if ( 'yes' === $disabled ) {
				$html .= sprintf(
					' <span class="wplmi-lock dashicons dashicons-lock" title="%s" style="font-size:16px; padding-top: 3px;"></span>',
					esc_attr__( 'Modified date time update is disabled.', 'wp-last-modified-info' )
				);
			}

			$hidden = [
				'date-format'   => date( 'M d, Y H:i:s', strtotime( $post->post_modified ) ),
				'post-modified' => $post->post_modified,
				'disabled'      => $disabled,
				'post-type'     => $post->post_type,
			];

			foreach ( $hidden as $key => $value ) {
				$html .= sprintf(
					'<span class="wplmi-hidden-%1$s" style="display:none;">%2$s</span>',
					esc_attr( $key ),
					esc_html( $value )
				);
			}
		}

		$html .= sprintf(
			'<span class="wplmi-hidden-status" style="display:none;">%s</span>',
			esc_html( $post->post_status )
		);

		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Format modified date for display.
	 *
	 * @param \WP_Post $post Post object.
	 * @return string
	 */
	private function format_modified_date( $post ) {
		if ( has_filter( 'wplmi/admin_column_datetime_format' ) ) {
			$date_format = get_option( 'date_format' );
			$time_format = get_option( 'time_format' );
			return date_i18n(
				$this->do_filter( 'admin_column_datetime_format', $date_format . ' \a\t ' . $time_format, $post->ID ),
				strtotime( $post->post_modified )
			);
		}

		return sprintf(
			/* translators: 1: Post modified date, 2: Post modified time. */
			$this->do_filter( 'admin_column_text_placeholder', '%1$s at %2$s', $post ),
			/* translators: Post modified date format. See https://www.php.net/manual/datetime.format.php */
			get_the_modified_time( $this->do_filter( 'admin_column_date_format', 'Y/m/d' ), $post ),
			/* translators: Post modified time format. See https://www.php.net/manual/datetime.format.php */
			get_the_modified_time( $this->do_filter( 'admin_column_time_format', 'g:i a' ), $post )
		);
	}

	/**
	 * Add "Last Modified" column header.
	 *
	 * @param array $columns Registered columns.
	 * @return array
	 */
	public function column_title( $columns ) {
		$columns['lastmodified'] = __( 'Last Modified', 'wp-last-modified-info' );
		return $columns;
	}

	/**
	 * Register column as sortable.
	 *
	 * @param array $columns Sortable columns.
	 * @return array
	 */
	public function column_sortable( $columns ) {
		$columns['lastmodified'] = 'modified';
		return $columns;
	}

	/**
	 * Output column width CSS.
	 */
	public function style() {
		echo '<style>.fixed th.column-lastmodified{width:14%}</style>' . "\n";
	}
}
