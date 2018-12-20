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

Class WPLMI_Elementor_Register_Dynamic_Time_Tag extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'wplmi-modified-time';
    }
    
    public function get_title() {
        return __( 'Last Modified Time', 'wp-last-modified-info' );
    }
    
    public function get_group() {
        return 'wplmi-module';
    }
    
    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
    }
    
    protected function _register_controls() {
    
        $this->add_control(
            'schema',
            [
                'label' => __( 'Schema Markup', 'wp-last-modified-info' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'yes' => __( 'Yes', 'wp-last-modified-info' ),
                    'no' => __( 'No', 'wp-last-modified-info' ),
                ],
                'default' => 'yes',
            ]
        );
    
        $this->add_control(
            'format',
            [
                'label' => __( 'Time Format', 'wp-last-modified-info' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'default' => __( 'Default', 'wp-last-modified-info' ),
                    'g:i a' => date_i18n( 'g:i a' ),
                    'g:i A' => date_i18n( 'g:i A' ),
                    'H:i' => date_i18n( 'H:i' ),
                    'human' => __( 'Human Readable', 'wp-last-modified-info' ),
                    'custom' => __( 'Custom', 'wp-last-modified-info' ),
                ],
                'default' => 'default',
            ]
        );
    
        $this->add_control(
            'custom_format',
            [
                'label' => __( 'Custom Format', 'wp-last-modified-info' ),
                'default' => '',
                'description' => sprintf( '<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">%s</a>', __( 'Documentation on date and time formatting', 'wp-last-modified-info' ) ),
                'condition' => [
                    'format' => 'custom',
                ],
            ]
        );
    }
    
    public function render() {
        $schema = $this->get_settings( 'schema' );
        $format = $this->get_settings( 'format' );
        
        if ( 'human' === $format ) {
            /* translators: %s: Human readable date/time. */
            $value = sprintf( __( '%s ago', 'wp-last-modified-info' ), human_time_diff( get_the_modified_time( 'U' ), current_time( 'U' ) ) );
        } else {
    		switch ( $format ) {
    			case 'default':
    				$time_format = '';
    				break;
    			case 'custom':
    				$time_format = $this->get_settings( 'custom_format' );
    				break;
    			default:
    				$time_format = $format;
    				break;
    		}
    		$value = get_the_modified_time( $time_format );
        }
    
        if ( 'yes' === $schema ) {
            $output = '</time itemprop=/"dateModified/" datetime=/"'. get_post_modified_time( 'Y-m-d\TH:i:sP', true ) .'/">' . wp_kses_post( $value ) . '<//time>';
        } else {
            $output = wp_kses_post( $value );
        }
    
        echo $output;
    }

}