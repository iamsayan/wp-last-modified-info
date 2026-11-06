<?php
/**
 * Regression checks using real WordPress hooks, options and WP_Query objects.
 *
 * Run: wp --skip-plugins --skip-themes eval-file tests/sorting-order.php
 * No options or posts are written. The plugin need not be active.
 *
 * @package WP Last Modified Info
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	exit( "Run this check with WP-CLI eval-file.\n" );
}

$base = dirname( __DIR__ ) . '/inc/';
foreach ( [ 'Helpers/SettingsData.php', 'Helpers/Hooker.php', 'Helpers/HelperFunctions.php', 'Core/Backend/MiscActions.php' ] as $file ) {
	require_once $base . $file;
}
require_once ABSPATH . 'wp-admin/includes/class-wp-screen.php';

$handler = new \Wplmi\Core\Backend\MiscActions();
$handler->register();
$settings = false;
$read_settings = function () use ( &$settings ) {
	return $settings;
};
// Cover installations with and without an existing options row, without writes.
add_filter( 'option_lmt_plugin_global_settings', $read_settings );
add_filter( 'default_option_lmt_plugin_global_settings', $read_settings );

$cases = [
	'missing option' => [ false, false ],
	'missing key'    => [ [], false ],
	'empty value'    => [ '', false ],
	'false value'    => [ false, false ],
	'default'        => [ 'default', false ],
	'modified'       => [ 'modified', 'DESC' ],
	'published'      => [ 'published', 'ASC' ],
	'unknown value'  => [ 'unknown', false ],
];
$checks = 0;
foreach ( [ 'home', 'category', 'tag', 'admin', 'search', 'secondary' ] as $context ) {
	$GLOBALS['current_screen'] = 'admin' === $context ? WP_Screen::get( 'edit-post' ) : null;
	$GLOBALS['pagenow'] = 'admin' === $context ? 'edit.php' : 'index.php';
	$key = 'admin' === $context ? 'lmt_admin_default_sort_order' : 'lmt_default_sort_order';
	foreach ( $cases as $name => $case ) {
		$settings = in_array( $name, [ 'missing option', 'missing key' ], true ) ? $case[0] : [ $key => $case[0] ];
		$query = new WP_Query();
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );
		$query->is_home = in_array( $context, [ 'home', 'secondary' ], true );
		$query->is_category = 'category' === $context;
		$query->is_tag = 'tag' === $context;
		$query->is_search = 'search' === $context;
		$GLOBALS['wp_the_query'] = 'secondary' === $context ? new WP_Query() : $query;
		do_action_ref_array( 'pre_get_posts', [ &$query ] );
		$sorts = false !== $case[1] && ! in_array( $context, [ 'search', 'secondary' ], true );
		$expected = $sorts ? [ 'modified', $case[1] ] : [ 'title', 'ASC' ];
		$actual = [ $query->get( 'orderby' ), strtoupper( $query->get( 'order' ) ) ];
		if ( $actual !== $expected ) {
			WP_CLI::error( $context . ' / ' . $name . ': expected ' . wp_json_encode( $expected ) . ', got ' . wp_json_encode( $actual ) );
		}
		++$checks;
	}
}

WP_CLI::success( $checks . ' sorting checks passed; no options or posts changed.' );
