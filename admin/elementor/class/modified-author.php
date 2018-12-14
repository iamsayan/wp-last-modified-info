<?php

/**
 * Elementor Dynamic Tags Support
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @since     v1.4.0
 * @license   http://www.gnu.org/licenses/gpl.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

Class WPLMI_Elementor_Register_Dynamic_Author_Tag extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'wplmi-modified-author';
    }
    
    public function get_title() {
        return __( 'Last Modified Author', 'wp-last-modified-info' );
    }
    
    public function get_group() {
        return 'wplmi-module';
    }
    
    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
    }
    
    public function render() {
        $author_id = get_post_meta( get_the_ID(), '_edit_last', true );
        echo wp_kses_post( get_the_author_meta( 'display_name', $author_id ) );
    }

}