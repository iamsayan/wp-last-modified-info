<?php
/**
 * The Hooker.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Helpers
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Hooker class.
 */
trait Hooker {

	/**
	 * Hooks a function on to a specific action
	 *
	 * @param string   $tag             The name of the action to which the $function_to_add is hooked.
	 * @param callable $function_to_add The name of the function you wish to be called.
	 * @param int      $priority        Optional. Used to specify the order in which the functions
	 *                                  associated with a particular action are executed. Default 10.
	 *                                  Lower numbers correspond with earlier execution,
	 *                                  and functions with the same priority are executed
	 *                                  in the order in which they were added to the action.
	 * @param int      $accepted_args   Optional. The number of arguments the function accepts. Default 1.
	 * @return true    Will always return true.
	 */
	protected function action( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		return \add_action( $tag, [ $this, $function_to_add ], $priority, $accepted_args );
	}

	/**
	 * Hook a function or method to a specific filter action
	 *
	 * @param string   $tag             The name of the filter to hook the $function_to_add callback to.
	 * @param callable $function_to_add The callback to be run when the filter is applied.
	 * @param int      $priority        Optional. Used to specify the order in which the functions
	 *                                  associated with a particular action are executed. Default 10.
	 *                                  Lower numbers correspond with earlier execution,
	 *                                  and functions with the same priority are executed
	 *                                  in the order in which they were added to the action.
	 * @param int      $accepted_args   Optional. The number of arguments the function accepts. Default 1.
	 * @return true    Will always return true.
	 */
	protected function filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		return \add_filter( $tag, [ $this, $function_to_add ], $priority, $accepted_args );
	}

	/**
	 * Removes a function from a specified action hook
	 *
	 * @param string   $tag                The action hook to which the function to be removed is hooked.
	 * @param callable $function_to_remove The name of the function which should be removed.
	 * @param int      $priority           Optional. The priority of the function. Default 10.
	 * @return bool Whether the function is removed.
	 */
	protected function remove_action( $tag, $function_to_remove, $priority = 10 ) {
		return \remove_action( $tag, [ $this, $function_to_remove ], $priority );
	}

	/**
	 * Removes a function from a specified filter hook
	 *
	 * @param string   $tag                The filter hook to which the function to be removed is hooked.
	 * @param callable $function_to_remove The name of the function which should be removed.
	 * @param int      $priority           Optional. The priority of the function. Default 10.
	 * @return bool    Whether the function existed before it was removed.
	 */
	protected function remove_filter( $tag, $function_to_remove, $priority = 10 ) {
		return \remove_filter( $tag, [ $this, $function_to_remove ], $priority );
	}

	/**
	 * Do action with league as prefix
	 */
	protected function do_action( ...$args ) {
		if ( ! isset( $args[0] ) || empty( $args[0] ) ) {
			return;
		}

		$action = 'wplmi/' . $args[0];
		unset( $args[0] );

		\do_action_ref_array( $action, \array_merge( [], $args ) );
	}

	/**
	 * Do filter with league as prefix
	 */
	protected function do_filter( ...$args ) {
		if ( ! isset( $args[0] ) || empty( $args[0] ) ) {
			return;
		}

		$action = 'wplmi/' . $args[0];
		unset( $args[0] );

		return \apply_filters_ref_array( $action, \array_merge( [], $args ) );
	}
}
