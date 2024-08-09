<?php
/**
 * Shows post modified date.
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
Class ModifiedDate extends Tag {

    public function get_name() {
        return 'wplmi-modified-date';
    }
    
    public function get_title() {
        return __( 'Last Modified Date', 'wp-last-modified-info' );
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
                'label'   => __( 'Date Format', 'wp-last-modified-info' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'default' => __( 'Default', 'wp-last-modified-info' ),
                    'F j, Y'  => date_i18n( 'F j, Y' ),
                    'Y-m-d'   => date_i18n( 'Y-m-d' ),
                    'm/d/Y'   => date_i18n( 'm/d/Y' ),
                    'd/m/Y'   => date_i18n( 'd/m/Y' ),
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
    
        switch ( $format ) {
    		case 'default':
    			$date_format = '';
    			break;
    		case 'custom':
    			$date_format = $this->get_settings( 'custom_format' );
    			break;
    		default:
    			$date_format = $format;
    			break;
        }
        
        $value = get_the_modified_date( $date_format );
    
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