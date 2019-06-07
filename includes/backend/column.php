<?php 
/**
 * Runs on post/page column
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

add_action( 'admin_init', 'lmt_post_admin_actions' );

function lmt_post_admin_actions() {
    // get all post types
    $post_types = get_post_types();
    foreach ( $post_types as $post_type ) {
        add_filter( "manage_edit-{$post_type}_columns", "lmt_post_columns_display", 10, 1 );
        add_action( "manage_edit-{$post_type}_sortable_columns", "lmt_make_column_sortable", 10, 2 );
        
        add_filter( "manage_{$post_type}_posts_columns", "lmt_post_columns_display", 10, 1 );
        add_filter( "manage_{$post_type}_sortable_columns", "lmt_make_column_sortable", 10, 2 );

        add_action( "manage_{$post_type}_posts_custom_column", "lmt_last_modified_info_on_column", 10, 2 );
    }
}

function lmt_last_modified_info_on_column( $column, $post_id ) {
    switch ( $column ) {
        case 'lastmodified':
            $get_df = get_option( 'date_format' );
            $get_tf = get_option( 'time_format' );
            $m_orig	= get_post_field( 'post_modified', $post_id, 'raw' );
            $p_meta = get_post_meta( $post_id, '_lmt_disableupdate', true );
            $m_stamp = strtotime( $m_orig );
            $modified = date_i18n( apply_filters( 'wplmi_admin_column_date_time_format', $get_df . ' @ ' . $get_tf ), $m_stamp );
            $mod_format = date( 'M d, Y H:i', $m_stamp );

            echo $modified;
            if( get_the_modified_author() ) {
                echo '<br>' . __( 'by', 'wp-last-modified-info' ) . ' <strong>' . get_the_modified_author() . '</strong>';
            }
            if ( $p_meta  == 'yes' ) {
                echo ' <span class="lmt-lock dashicons dashicons-lock" title="' . esc_attr__( 'Modified date time update is disabled.', 'wp-last-modified-info' ) . '" style="font-size:16px; padding-top: 3px;"></span>';
            }
            echo '<span class="hidden-df" style="display:none;">' . $mod_format . '</span>';
        break;
    // end all case breaks
    }
}

function lmt_post_columns_display( $column ) {
    $column['lastmodified'] = __( 'Last Modified', 'wp-last-modified-info' );
    return $column;
}

function lmt_make_column_sortable( $column ) {
	$column['lastmodified'] = 'modified';
	return $column;
}

?>