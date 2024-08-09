<?php
/**
 * Show Original Republish Data.
 *
 * @since      1.7.0
 * @package    WP Last Modified Info
 * @subpackage Wplmi\Core\Frontend
 * @author     Sayan Datta <iamsayan@protonmail.com>
 */

namespace Wplmi\Core\Frontend;

use Wplmi\Helpers\Hooker;
use Wplmi\Helpers\HelperFunctions;

defined( 'ABSPATH' ) || exit;

/**
 * Republish info class.
 */
class PostView
{
	use HelperFunctions;
    use Hooker;

	/**
	 * Register functions.
	 */
	public function register() {
		$this->filter( 'the_content', 'show_info', $this->do_filter( 'display_priority', 5 ) );
		$this->action( 'wp_footer', 'run_replace', 99 );
	}

	/**
	 * Show original publish info.
	 *
	 * @param string  $content  Original Content
	 *
	 * @return string $content  Filtered Content
	 */
	public function show_info( $content ) {
		if ( ! $this->is_enabled( 'enable_last_modified_cb' ) ) {
			return $content;
		}

		$post_types = $this->get_data( 'lmt_custom_post_types_list', [ 'post' ] );
		if ( ! in_array( get_post_type(), $post_types ) ) {
			return $content;
		}

		$position = $this->get_data( 'lmt_show_last_modified_time_date_post', 'before_content' );
		if ( ! in_array( $position, [ 'before_content', 'after_content' ] ) ) {
			return $content;
		}

		$disable = $this->get_meta( get_the_ID(), '_lmt_disable' );
		if ( ! empty( $disable ) && $disable == 'yes' ) {
			return $content;
		}

		$template = $this->get_data( 'lmt_last_modified_info_template' );
		if ( empty( $template ) ) {
			return $content;
		}

		if ( ! in_the_loop() && $this->do_filter( 'disable_post_loop', true ) ) {
			return $content;
		}

		$archives = $this->get_data( 'lmt_archives' );
		if ( ! empty( $archives ) ) {
			foreach ( $archives as $archive ) {
		    	if ( $archive() ) {
		    		return $content;
		    	}
		    }
		}

		$timestamp = $this->get_timestamp( get_the_ID() );
		if ( ! $timestamp ) {
			return $content;
		}

		$author_id = $this->get_meta( get_the_ID(), '_edit_last' );
		if ( $this->is_equal( 'show_author_cb', 'custom', 'default' ) ) {
			$author_id = $this->get_data( 'lmt_show_author_list' );
		}

		$template = $this->generate( $template, get_the_ID(), $timestamp, $author_id );

		if ( $position == 'before_content' ) {
        	$content = $this->wrapper( $template, get_the_ID() ) . $content;
        } elseif ( $position == 'after_content' ) {
        	$content = $content . $this->wrapper( $template, get_the_ID() );
	    }

    	return $this->do_filter( 'post_content_output', $content, $position, $template, get_the_ID() );
	}

	/**
	 * Replace Published date with Modified Date using jQuery.
	 */
	public function run_replace() {
		global $post;

		if ( ! $post instanceof \WP_Post || ! is_singular() ) {
			return;
		}

		if ( ! $this->is_enabled( 'enable_last_modified_cb' ) ) {
			return;
		}

		$post_types = $this->get_data( 'lmt_custom_post_types_list', [ 'post' ] );
		if ( ! in_array( $post->post_type, $post_types ) ) {
			return;
		}

		$position = $this->get_data( 'lmt_show_last_modified_time_date_post', 'before_content' );
		if ( $position !== 'replace_original' ) {
			return;
		}

		$disable = $this->get_meta( $post->ID, '_lmt_disable' );
		if ( ! empty( $disable ) && $disable == 'yes' ) {
			return;
		}

		$template = $this->get_data( 'lmt_last_modified_info_template' );
		$selectors = $this->get_data( 'lmt_css_selectors' );
		if ( empty( $template ) || empty( $selectors ) ) {
			return;
		}

		$timestamp = $this->get_timestamp( $post->ID );
		if ( ! $timestamp ) {
			return;
		}

		$author_id = $this->get_meta( $post->ID, '_edit_last' );
		if ( $this->is_equal( 'show_author_cb', 'custom', 'default' ) ) {
			$author_id = $this->get_data( 'lmt_show_author_list' );
		}

		$template = $this->generate( $template, $post->ID, $timestamp, $author_id );

		echo '<div class="wplmi-frontend-template" style="display: none;">' . $template . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

	    <script type="text/javascript">
			const wplmiNodeList = document.querySelectorAll( '<?= wp_kses_post( preg_replace( "/\r|\n/", '', $selectors ) ); ?>' );
			for ( let i = 0; i < wplmiNodeList.length; i++ ) {
				wplmiNodeList[i].outerHTML = document.querySelector( '.wplmi-frontend-template' ).innerHTML;
			}
	    </script>
		<?php
	}

	/**
	 * Get Timestamp.
	 *
	 * @param int  $post_id  WP Post ID.
	 *
	 * @return string
	 */
	private function get_timestamp( $post_id ) {
		$published_timestamp = get_post_time( 'U', false, $post_id );
		$modified_timestamp = get_post_modified_time( 'U', false, $post_id );
		$gap = $this->get_data( 'lmt_gap_on_post', 0 );

		if ( ( $modified_timestamp - $published_timestamp ) < $gap ) {
			return false;
		}

		// Get Format
		$date_type = $this->get_data( 'lmt_last_modified_format_post', 'default' );
		$date_type = $this->do_filter( 'post_datetime_type', $date_type, $post_id );

		// Generate Timestamp
		$timestamp = human_time_diff( $modified_timestamp, current_time( 'U' ) );
		if ( $date_type == 'default' ) {
			$format = $this->get_data( 'lmt_date_time_format', get_option( 'date_format' ) );
			$format = $this->do_filter( 'post_datetime_format', $format, $post_id );
			$timestamp = $this->get_modified_date( $format, $post_id );
		}
		$timestamp = $this->do_filter( 'post_formatted_date', $timestamp, $post_id );

		return $timestamp;
	}

	/**
	 * Replace email variables.
	 *
	 * @param string  $html    Input data.
	 * @param int     $post_id Post ID.
	 * @param string  $type    Sting type. Default subject.
	 *
	 * @return string
	 */
	protected function generate( $html, $post_id, $timestamp, $author_id ) {
		$html = htmlspecialchars_decode( wp_unslash( $html ) );

		if ( $this->is_equal( 'enable_jsonld_markup_cb', 'inline' ) && ! $this->is_archive() ) {
			$timestamp = '<time itemprop="dateModified" datetime="'. esc_attr( get_post_modified_time( 'Y-m-d\TH:i:sP', false, $post_id ) ) . '">' . esc_html( $timestamp ) . '</time>';
		}

		// Prepare contents
		$author_name = get_the_author_meta( 'display_name', $author_id );
		$author_url = esc_url( get_the_author_meta( 'url', $author_id ) );
		$author_email = filter_var( get_the_author_meta( 'user_email', $author_id ), FILTER_SANITIZE_EMAIL );
		$author_archive = esc_url( get_author_posts_url( $author_id ) );

		// Published date format
		$date_format = $this->do_filter( 'post_published_date_format', get_option( 'date_format' ), $post_id );

		// Start replace
		$html = str_replace( [ '%original_author_name%', '%post_original_author%' ], get_the_author(), $html );
		$html = str_replace( [ '%author_name%', '%post_author%' ], $author_name, $html );
		$html = str_replace( [ '%author_url%', '%author_website%' ], $author_url, $html );
		$html = str_replace( '%author_email%', $author_email, $html );
		$html = str_replace( [ '%author_archive%', '%author_posts_url%' ], $author_archive, $html );
		$html = str_replace( [ '%post_published%', '%published_date%' ], esc_attr( get_post_time( $date_format, false, $post_id, true ) ), $html );
		$html = str_replace( '%post_link%', esc_url( get_the_permalink( $post_id ) ), $html );
		$html = str_replace( '%post_categories%', get_the_category_list( $this->do_filter( 'post_categories_separator', ', ', $post_id ), '', $post_id ), $html );
		$html = str_replace( '%comment_count%', get_comments_number( $post_id ), $html );
		$html = str_replace( [ '%post_modified%', '%modified_date%' ], $timestamp, $html );

		$html = $this->do_filter( 'post_tags', $html, $post_id );
		$html = preg_replace( "/\r|\n/", '', $html );

		$allowed_htmls = array_merge( wp_kses_allowed_html( 'post' ), [
			'time' => [
				'class'    => [],
				'itemprop' => [],
				'datetime' => [],
			],
		] );

		return wp_kses( $html, $allowed_htmls );
	}

	/**
	 * Check archive pages
	 *
	 * @param string  $content      Post Content.
	 * @param int     $post_id      WP Post ID.
	 * @param bool    $remove       Whether to remove p tag | Default false.
	 * @param bool    $wrap         Whether to wrap with specified html tag | Default false.
	 * @param string  $output_type  Output Type | Default post.
	 * @param string  $element      HTML element | Default p.
	 *
	 * @return string
	 */
	protected function wrapper( $content, $post_id, $remove = false, $wrap = false, $output_type = 'post', $element = 'p' ) {
		$wrapper = $this->do_filter( $output_type . '_wrapper_element', $element, $post_id );

		if ( $this->do_filter( $output_type . '_remove_auto_p', $remove, $post_id ) ) {
		    $content = preg_replace( '/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $content );
		}

		if ( $this->do_filter( $output_type . '_wrapper', $wrap, $post_id ) ) {
		    $content = '<' . esc_attr( $wrapper ) . ' class="wplmi-' . esc_attr( $output_type ) . ' post-last-modified">' . $content . '</' . esc_attr( $wrapper ) . '>';
		}

		return $content;
	}

	/**
	 * Check archive pages
	 *
	 * @return bool
	 */
	private function is_archive() {
		if ( is_archive() || is_tax() || is_home() || is_front_page() || is_search() || is_404() ) {
            return true;
		}

		return false;
	}
}
