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
 * WooCommerce integration class.
 * Compatible with both legacy posts table and High-Performance Order Storage (HPOS).
 */
class WooCommerce
{
	use Hooker;
	use SettingsData;

	/**
	 * Register hooks.
	 */
	public function register() {
		// Ensure product hooks run before order hooks.
		$this->action( 'woocommerce_update_product', 'update_product', 9 );
		$this->action( 'woocommerce_update_product_variation', 'update_product', 9 );

		// Use appropriate hook depending on HPOS availability.
		if ( $this->is_hpos_enabled() ) {
			$this->action( 'woocommerce_after_order_object_save', 'handle_hpos_order_save', 99, 2 );
		} else {
			$this->action( 'woocommerce_new_order', 'update_products', 99 );
			$this->action( 'woocommerce_order_status_changed', 'update_products', 99 );
		}
	}

	/**
	 * Restore the last-modified date for a product after WooCommerce update.
	 *
	 * @param int $product_id Product or variation ID.
	 */
	public function update_product( $product_id ) {
		$product = wc_get_product( $product_id );
		if ( ! $product ) {
			return;
		}

		if ( 'yes' === $this->get_meta( $product_id, '_lmt_disableupdate' ) ) {
			return;
		}

		$post_status = get_post_status( $product_id );
		if ( in_array( $post_status, [ 'auto-draft', 'future' ], true ) ) {
			return;
		}

		$modified = $this->get_meta( $product_id, '_wplmi_last_modified' );
		if ( empty( $modified ) ) {
			return;
		}

		$modified_ts  = strtotime( $modified );
		$published_ts = (int) get_post_time( 'U', false, $product_id );

		if ( $modified_ts >= $published_ts ) {
			global $wpdb;

			$wpdb->update(
				$wpdb->posts,
				[
					'post_modified'     => $modified,
					'post_modified_gmt' => get_gmt_from_date( $modified ),
				],
				[ 'ID' => $product_id ]
			);

			clean_post_cache( $product_id );
		}
	}

	/**
	 * Handle order save event for HPOS.
	 *
	 * @param \WC_Order $order      Order object.
	 * @param \WC_Data_Store $data_store Data store instance.
	 */
	public function handle_hpos_order_save( $order, $data_store ) {
		if ( ! $order instanceof \WC_Order ) {
			return;
		}

		// Only process if the order is newly created or status changed.
		if ( $order->get_data_store()->get_stock_reduced( $order->get_id() ) ) {
			$this->update_products( $order->get_id() );
		}
	}

	/**
	 * Restore last-modified dates for all products in an order.
	 *
	 * @param int $order_id WC_Order ID.
	 */
	public function update_products( $order_id ) {
		$order = wc_get_order( $order_id );
		if ( ! $order ) {
			return;
		}

		foreach ( $order->get_items() as $item ) {
			if ( ! $item->is_type( 'line_item' ) ) {
				continue;
			}

			$product_id = $item instanceof \WC_Order_Item_Product ? $item->get_product_id() : 0;
			if ( $product_id ) {
				$this->update_product( $product_id );
			}
		}
	}

	/**
	 * Check if HPOS is enabled.
	 *
	 * @return bool
	 */
	private function is_hpos_enabled() {
		return class_exists( '\Automattic\WooCommerce\Utilities\OrderUtil' )
			&& \Automattic\WooCommerce\Utilities\OrderUtil::custom_orders_table_usage_is_enabled();
	}
}
