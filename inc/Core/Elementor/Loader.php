<?php
/**
 * Elementor loader.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Elementor
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Core\Elementor;

use Elementor\Plugin;
use Wplmi\Helpers\Hooker;
use Wplmi\Core\Elementor\Modules;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor loader class.
 */
class Loader
{
	use Hooker;

	/**
	 * Register functions.
	 */
	public function register() {
        if ( function_exists( '_is_elementor_installed' ) && defined( 'ELEMENTOR_PRO_VERSION' ) ) {
            $this->filter( 'wp_kses_allowed_html', 'wp_kses_post_tags', 10, 2 );
            $this->action( 'elementor/dynamic_tags/register', 'register_tags' );
            $this->action( 'elementor/frontend/the_content', 'render' );
            $this->action( 'elementor/widget/render_content', 'render' );
            $this->action( 'elementor/query/wplmi_elementor_widget_query_filter', 'query' );
        }
	}

	/**
	 * Register custom dynamic tags.
	 * 
	 * @param object  $dynamic_tags  Original Elementor dynamic tags object
	 */
	public function register_tags( $dynamic_tags_manager ) {
        // Register group
        $dynamic_tags_manager->register_group( 'wplmi-module', [
            'title' => __( 'WP Last Modified Info', 'wp-last-modified-info' ),
        ] );

        // Finally register the tags
        $dynamic_tags_manager->register( new Modules\ModifiedDate() );
        $dynamic_tags_manager->register( new Modules\ModifiedTime() );
        $dynamic_tags_manager->register( new Modules\AuthorName() );
        $dynamic_tags_manager->register( new Modules\AuthorUrl() );
    }

    /**
	 * Modify elementor query object.
	 * 
	 * @param object  $query  Original Elementor query object
	 */
    public function query( $query ) {
        // ordered by post modified date
        $query->set( 'orderby', 'modified' );
    }

    /**
	 * Remove old placeholders.
	 * 
	 * @param string  $content  Original Content
	 * 
	 * @return string $content  Filtered Content
	 */
    public function render( $content ) {
        $content = str_replace( [ '%wplmi_schema_start%', '%wplmi_schema_end%', '%wplmi_span_start%', '%wplmi_span_end%', '%wplmi_author_avatar%' ], '', $content );
        
        return $content;
    }

    /**
	 * Allow HTMl Tag.
	 * 
	 * @param array  $tags    Tags array
	 * @param string $context Current context
	 * 
	 * @return array $tags Tags array
	 */
    public function wp_kses_post_tags( $tags, $context ) {
        if ( 'post' === $context ) {
            $tags['time'] = [
                'itemprop' => true,
                'datetime' => true,
            ];
        }
    
        return $tags;
    }    
}