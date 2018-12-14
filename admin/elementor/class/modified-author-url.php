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

Class WPLMI_Elementor_Register_Dynamic_Author_URL_Tag extends \Elementor\Core\DynamicTags\Data_Tag {

    public function get_name() {
        return 'wplmi-modified-author-url';
    }
    
    public function get_title() {
        return __( 'Last Modified Author URL', 'wp-last-modified-info' );
    }
    
    public function get_group() {
        return 'wplmi-module';
    }
    
    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::URL_CATEGORY ];
    }
    
    public function get_value( array $options = [] ) {
        
        $value = '';
        $author_id = get_post_meta( get_the_ID(), '_edit_last', true );

		if ( $author_id ) {
		    if ( 'archive' === $this->get_settings( 'url' ) ) {
		    	$value = get_author_posts_url( $author_id );
		    } elseif ( 'website' === $this->get_settings( 'url' ) ) {
		    	$value = get_the_author_meta( 'url', $author_id );
		    } else {
                $value = 'mailto:' . get_the_author_meta( 'user_email', $author_id );
		    }
	    }
		return $value;
	}

	protected function _register_controls() {
		$this->add_control(
			'url',
			[
				'label' => __( 'URL', 'wp-last-modified-info' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'archive',
				'options' => [
					'archive' => __( 'Author Archive', 'wp-last-modified-info' ),
                    'website' => __( 'Author Website', 'wp-last-modified-info' ),
                    'email' => __( 'Author Email', 'wp-last-modified-info' ),
				],
			]
		);
	}

}