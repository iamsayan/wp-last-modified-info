<?php
/**
 * Elementor loader.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Elementor
 * @author     Sayan Datta <hello@sayandatta.in>
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
	 * Modify elementor query obejct.
	 * 
	 * @param object  $query  Original Elementor query object
	 */
    public function query( $query ) {
        // ordered by post modified date
        $query->set( 'orderby', 'modified' );
    }

    /**
	 * Show filtered content.
	 * 
	 * @param string  $content  Original Content
	 * 
	 * @return string $content  Filtered Content
	 */
    public function render( $content ) {
        $start_tag = '<time itemprop="dateModified" datetime="'. get_post_modified_time( 'Y-m-d\TH:i:sP', true ) .'">';
        $end_tag = '</time>';

        $content = str_replace( '%wplmi_schema_start%', $start_tag, $content );
        $content = str_replace( '%wplmi_schema_end%', $end_tag, $content );

        $content = str_replace( '%wplmi_span_start%', '<span class="wplmi-author">', $content );
        $content = str_replace( '%wplmi_span_end%', '</span>', $content );

        $author_id = get_post_meta( get_the_ID(), '_edit_last', true );
        $author_name = get_the_author_meta( 'display_name', $author_id );

        $content = str_replace( '%wplmi_author_avatar%', '<span class="wplmi-user-avatar">
        <img class="elementor-avatar wplmi-elementor-avatar" src="' . esc_url( get_avatar_url( $author_id, [ 'size' => $this->do_filter( 'avatar_default_size', 96 ) ] ) ) . '" alt="' . $author_name . '"></span>', $content );
        
        return $content;
    }
}