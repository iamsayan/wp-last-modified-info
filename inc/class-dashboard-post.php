<?php 

add_action ( 'manage_posts_custom_column', 'lmt_post_columns_data', 10, 2 );
add_filter ( 'manage_edit-post_columns', 'lmt_post_columns_display');

    function lmt_post_columns_data( $column, $post_id ) {
        switch ( $column ) {
        case 'modified':
            $m_orig		= get_post_field( 'post_modified', $post_id, 'raw' );
            $m_stamp	= strtotime( $m_orig );
            $modified	= date('Y/n/j @ g:i a', $m_stamp );
                   $modr_id	= get_post_meta( $post_id, '_edit_last', true );
                   $auth_id	= get_post_field( 'post_author', $post_id, 'raw' );
                   $user_id	= !empty( $modr_id ) ? $modr_id : $auth_id;
                   $user_info	= get_userdata( $user_id );
        
                   echo '<p class="lmt-mod-date">';
                   echo ''.$modified.'<br />';
                   echo 'by <strong>'.$user_info->display_name.'<strong>';
                   echo '</p>';
            break;
        // end all case breaks
        }
    }
    function lmt_post_columns_display( $columns ) {
        $columns['modified'] = 'Last Modified';
        return $columns;
    }

    add_filter( "manage_edit-post_sortable_columns", "lmt_post_columns_display" );

// last modified info of woo column
if( isset($options['lmt_enable_on_woo_product_cb']) && ($options['lmt_enable_on_woo_product_cb'] == 1 ) ) {
    
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
        // enable sorting
        add_filter( "manage_edit-product_sortable_columns", "lmt_post_columns_display" );
        add_filter( "manage_edit-shop_order_sortable_columns", "lmt_post_columns_display" );
        add_filter( "manage_edit-shop_coupon_sortable_columns", "lmt_post_columns_display" );
        // display column on woo
        add_filter ( 'manage_edit-product_columns', 'lmt_post_columns_display');
        add_filter ( 'manage_edit-shop_order_columns', 'lmt_post_columns_display');
        add_filter ( 'manage_edit-shop_coupon_columns', 'lmt_post_columns_display');
    } else {
        ?><div class="notice notice-warning"> 
        <p><strong>WP Last Modified Info requires WooCommerce Plugin to be activated as WooCommerce Option is enabled in settings | <a href="options-general.php?page=wp-last-modified-info">disable settings</a>.</strong></p>
    </div> <?php
    }
}

?>