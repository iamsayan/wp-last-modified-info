<?php 

/**
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

 /**
 * Add Last modified author to Rest API
 */
add_action( 'rest_api_init', 'lmt_register_modified_by_api_field' );

function lmt_register_modified_by_api_field() {
    // Add the last modified author name to GET requests for individual posts
    register_rest_field(
        'post', // object type
        apply_filters( 'wplmi_modified_by_field_name', 'modified_by' ), // field name
        array(
            'get_callback' => 'lmt_modified_by_wp_rest_api_output', // callback
        )
    );
}

function lmt_modified_by_wp_rest_api_output( $object, $field_name, $request ) {
	$modified_id = get_post_meta( $object['id'], '_edit_last', true );
	if( $modified_id ) {
        $last_user = get_userdata( $modified_id );
        // return user name
	    return $last_user->display_name;
    }
    return '';
}