<?php
/**
 * Shows post modified time.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Elementor\Modules
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Core\Elementor\Modules;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;

defined( 'ABSPATH' ) || exit;

/**
 * Republish info class.
 */
Class ModifiedTime extends Tag {

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
        return [ Module::TEXT_CATEGORY ];
    }
    
    protected function register_controls() {
        $this->add_control(
            'schema',
            [
                'label'   => __( 'Schema Markup', 'wp-last-modified-info' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'yes' => __( 'Yes', 'wp-last-modified-info' ),
                    'no'  => __( 'No', 'wp-last-modified-info' ),
                ],
                'default' => 'yes',
            ]
        );
    
        $this->add_control(
            'format',
            [
                'label'   => __( 'Time Format', 'wp-last-modified-info' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'default' => __( 'Default', 'wp-last-modified-info' ),
                    'g:i a'   => date_i18n( 'g:i a' ),
                    'g:i A'   => date_i18n( 'g:i A' ),
                    'H:i'     => date_i18n( 'H:i' ),
                    'human'   => __( 'Human Readable', 'wp-last-modified-info' ),
                    'custom'  => __( 'Custom', 'wp-last-modified-info' ),
                ],
                'default' => 'default',
            ]
        );
    
        $this->add_control(
            'custom_format',
            [
                'label'       => __( 'Custom Format', 'wp-last-modified-info' ),
                'default'     => '',
                'description' => sprintf( '<a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank">%s</a>', __( 'Documentation on date and time formatting', 'wp-last-modified-info' ) ),
                'condition'   => [
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
            $value = sprintf( __( '%s ago', 'wp-last-modified-info' ), human_time_diff( get_post_modified_time( 'U' ), current_time( 'U' ) ) );
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
    		$value = get_post_modified_time( $time_format, false, null, true );
        }
    
        if ( 'yes' === $schema ) {
            $start_tag = '<time itemprop="dateModified" datetime="'. get_post_modified_time( 'Y-m-d\TH:i:sP', true ) .'">';
            $end_tag   = '</time>';

            $output = $start_tag . $value . $end_tag;
        } else {
            $output = $value;
        }
     
        echo wp_kses_post( $output );
    }
}