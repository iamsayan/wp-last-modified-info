<?php
/**
 * Handle WooCommerce product date updation.
 *
 * @since      1.8.5
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Backend
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Core\Backend;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\SettingsData;

defined( 'ABSPATH' ) || exit;

/**
 * WooCommerce class.
 */
class WooCommerce
{
	use Hooker;
    use SettingsData;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->action( 'woocommerce_update_product', 'update_product', 9 );
		$this->action( 'woocommerce_update_product_variation', 'update_product', 9 );
		$this->action( 'woocommerce_new_order', 'update_products', 99 );
		$this->action( 'woocommerce_order_status_changed', 'update_products', 99 );
	}

	/**
	 * Update Post Modified date from previously save meta to fix WooCommerce Product Update process.
	 *
	 * @param int $product_id The Product ID.
	 */
	public function update_product( $product_id ) {
		global $wpdb;

		$post_status = get_post_status( $product_id );
		$disabled = $this->get_meta( $product_id, '_lmt_disableupdate' );
		if ( 'yes' !== $disabled && in_array( $post_status, [ 'auto-draft', 'future' ] ) ) {
			return;
		}

		$modified = $this->get_meta( $product_id, '_wplmi_last_modified' );
		$published_timestamp = get_post_time( 'U', false, $product_id );

		if ( ! empty( $modified ) && ( strtotime( $modified ) >= $published_timestamp ) ) {
	    	$args = [
	            'post_modified'     => $modified,
	            'post_modified_gmt' => get_gmt_from_date( $modified ),
	    	];

	    	$wpdb->update( $wpdb->posts, $args, [
	    	    'ID' => $product_id,
			] );
			clean_post_cache( $product_id );
	   	}
	}

	/**
	 * Update Post Modified date from previously save meta to fix WooCommerce Product Update process on creation of new order.
	 *
	 * @param int $order_id The Order ID.
	 */
	public function update_products( $order_id ) {
		$order = wc_get_order( $order_id );

		foreach ( $order->get_items() as $item ) {
			$product_id = $item->get_product_id();
			$this->update_product( $product_id );
		}
	}
}
