<?php
/**
 * Shows modified author name.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Elementor\Modules
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Core\Elementor\Modules;

use Wplmi\Helpers\Hooker;
use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;

defined( 'ABSPATH' ) || exit;

/**
 * Republish info class.
 */
Class AuthorName extends Tag {

    use Hooker;

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
        return [ Module::TEXT_CATEGORY ];
    }

    protected function register_controls() {
        $this->add_control(
            'show_avatar',
            [
                'label' => __( 'Show Avatar', 'wp-last-modified-info' ),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'custom_text',
            [
                'label'     => __( 'Text After', 'wp-last-modified-info' ),
                'condition' => [
                    'show_avatar' => 'yes',
                ],
            ]
        );
    }
    
    public function render() {
        $avatar = $this->get_settings( 'show_avatar' );
        $text = $this->get_settings( 'custom_text' );
        
        $author_id = get_post_meta( get_the_ID(), '_edit_last', true );
        $value = get_the_author_meta( 'display_name', $author_id );

        if ( 'yes' === $avatar ) {
            $author_id   = get_post_meta( get_the_ID(), '_edit_last', true );
            $author_name = get_the_author_meta( 'display_name', $author_id );
            $avatar      = '<span class="wplmi-user-avatar"><img class="elementor-avatar wplmi-elementor-avatar" src="' . esc_url( get_avatar_url( $author_id, [ 'size' => $this->do_filter( 'avatar_default_size', 96 ) ] ) ) . '" alt="' . $author_name . '"></span> ';

            $output = '<span class="wplmi-author-tag">' . $avatar . $text . '<span class="wplmi-author">' . $value . '</span></span>';
        } else {
            $output = $value;
        }

        echo wp_kses_post( $output );
    }
}