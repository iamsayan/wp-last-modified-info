<?php
/**
 * Show Original Republish Data.
 *
 * @since      1.1.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core
 * @author     Sayan Datta <hello@sayandatta.in>
 */

namespace Wplmi\Core\Elementor;

use \Elementor\Plugin;
use Wplmi\Helpers\Hooker;
use Wplmi\Core\Elementor\Modules;

defined( 'ABSPATH' ) || exit;

/**
 * Republish info class.
 */
class Loader
{
	use Hooker;

	/**
	 * Register functions.
	 */
	public function register()
	{
        if ( function_exists( '_is_elementor_installed' ) && defined( 'ELEMENTOR_PRO_VERSION' ) ) {
            $this->action( 'elementor/frontend/the_content', 'render' );
            $this->action( 'elementor/widget/render_content', 'render' );
            $this->action( 'elementor/dynamic_tags/register_tags', 'tags' );
            $this->action( 'elementor/query/wplmi_elementor_widget_query_filter', 'query' );
        }
	}

	/**
	 * Show original publish info.
	 * 
	 * @param string  $content  Original Content
	 * 
	 * @return string $content  Filtered Content
	 */
	public function tags( $dynamic_tags )
    {
        Plugin::$instance->dynamic_tags->register_group( 'wplmi-module', [
            'title' => __( 'WP Last Modified Info', 'wp-last-modified-info' )
        ] );

        // Finally register the tags
        $dynamic_tags->register_tag( new Modules\ModifiedDate() );
        $dynamic_tags->register_tag( new Modules\ModifiedTime() );
        $dynamic_tags->register_tag( new Modules\AuthorName() );
        $dynamic_tags->register_tag( new Modules\AuthorUrl() );
    }

    public function query( $query )
    {
        // ordered by post modified date
        $query->set( 'orderby', 'modified' );
    }

    public function render( $content )
    {
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