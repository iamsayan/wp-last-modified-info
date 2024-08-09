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
	 * Register functions.
	 */
	public function register() {
		$this->action( 'admin_init', 'generate_column' );
		$this->action( 'admin_head-edit.php', 'style' );
	}

	/**
	 * Column hooks.
	 */
	public function generate_column() {
		// get all post types
		$post_types = get_post_types( $this->do_filter( 'admin_column_post_types', [] ) );
		if ( ! empty( $post_types ) ) {
	    	foreach ( $post_types as $post_type ) {
	    		$this->filter( "manage_edit-{$post_type}_columns", 'column_title' );
	    		$this->action( "manage_edit-{$post_type}_sortable_columns", 'column_sortable', 10, 2 );
	    		$this->filter( "manage_{$post_type}_posts_columns", 'column_title' );
	    		$this->filter( "manage_{$post_type}_sortable_columns", 'column_sortable', 10, 2 );
	    		$this->action( "manage_{$post_type}_posts_custom_column", 'column_data', 10, 2 );
	    	}
	    }
	}

	/**
	 * Generate column data.
	 *
	 * @param string   $column   Column name
	 * @param int      $post_id  Post ID
	 *
	 * @return string  $time
	 */
	public function column_data( $column, $post_id ) {
		if ( 'lastmodified' === $column ) {
			$post = get_post( $post_id );

			$get_df = get_option( 'date_format' );
			$get_tf = get_option( 'time_format' );
			$m_orig = get_post_field( 'post_modified', $post->ID, 'raw' );
			$p_meta = $this->get_meta( $post->ID, '_lmt_disableupdate' );
			$modified = date_i18n( $this->do_filter( 'admin_column_datetime_format', $get_df . ' \a\t ' . $get_tf, $post->ID ), strtotime( $m_orig ) );
			$mod_format = date( 'M d, Y H:i:s', strtotime( $m_orig ) );
			$disabled = ( ! empty( $p_meta ) ) ? $p_meta : 'no';

			$html = $modified;
			if ( get_the_modified_author() ) {
				$html .= '<br>' . __( 'by', 'wp-last-modified-info' ) . ' <strong>' . esc_html( get_the_modified_author() ) . '</strong>';
			}
			if ( ! in_array( $post->post_status, [ 'auto-draft', 'future' ] ) ) {
				if ( $p_meta == 'yes' ) {
					$html .= ' <span class="wplmi-lock dashicons dashicons-lock" title="' . esc_attr__( 'Modified date time update is disabled.', 'wp-last-modified-info' ) . '" style="font-size:16px; padding-top: 3px;"></span>';
				}
				$html .= '<span class="wplmi-hidden-date-format" style="display: none;">' . esc_html( $mod_format ) . '</span>';
				$html .= '<span class="wplmi-hidden-post-modified" style="display: none;">' . esc_html( $post->post_modified ) . '</span>';
				$html .= '<span class="wplmi-hidden-disabled" style="display: none;">' . esc_html( $disabled ) . '</span>';
				$html .= '<span class="wplmi-hidden-post-type" style="display: none;">' . esc_html( $post->post_type ) . '</span>';
			}
			$html .= '<span class="wplmi-hidden-status" style="display: none;">' . esc_html( $post->post_status ) . '</span>';

			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * Column title.
	 *
	 * @param string   $column  Column name
	 * @return string  $column  Filtered column
	 */
	public function column_title( $column ) {
		$column['lastmodified'] = __( 'Last Modified', 'wp-last-modified-info' );

		return $column;
	}

	/**
	 * Make Column sortable.
	 *
	 * @param string   $column  Column name
	 * @return array   $column  Filtered column
	 */
	public function column_sortable( $column ) {
		$column['lastmodified'] = 'modified';

		return $column;
	}

	/**
	 * Column custom CSS.
	 */
	public function style() {
		echo '<style type="text/css">.fixed th.column-lastmodified { width: 14%; }</style>'."\n";
	}
}
