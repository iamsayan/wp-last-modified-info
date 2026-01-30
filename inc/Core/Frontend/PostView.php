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
 * Display last-modified information on the frontend.
 *
 * @since 1.7.0
 */
class PostView
{
	use HelperFunctions;
	use Hooker;

	/**
	 * List of conditional tags to check.
	 *
	 * @since 1.8.5
	 * @var array
	 */
	protected $functions = [
		'is_archive',
		'is_tax',
		'is_home',
		'is_front_page',
		'is_search',
		'is_404',
		'is_author',
		'is_category',
		'is_tag',
	];

	/**
	 * Register hooks.
	 */
	public function register() {
		$this->filter( 'the_content', 'show_info', $this->do_filter( 'display_priority', 5 ) );
		$this->action( 'wp_footer', 'run_replace', 99 );
	}

	/**
	 * Append / prepend last-modified block to post content.
	 *
	 * @param string $content Original post content.
	 * @return string
	 */
	public function show_info( $content ) {
		// Early bail-outs
		if ( ! $this->is_enabled( 'enable_last_modified_cb' ) ) {
			return $content;
		}

		$post_id   = get_the_ID();
		$post_type = get_post_type( $post_id );

		$allowed_types = (array) $this->get_data( 'lmt_custom_post_types_list', [ 'post' ] );
		if ( ! in_array( $post_type, $allowed_types, true ) ) {
			return $content;
		}

		$position = $this->get_data( 'lmt_show_last_modified_time_date_post', 'before_content' );
		if ( ! in_array( $position, [ 'before_content', 'after_content' ], true ) ) {
			return $content;
		}

		if ( 'yes' === $this->get_meta( $post_id, '_lmt_disable' ) ) {
			return $content;
		}

		$template = trim( (string) $this->get_data( 'lmt_last_modified_info_template' ) );
		if ( '' === $template ) {
			return $content;
		}

		if ( ! in_the_loop() && $this->do_filter( 'disable_post_loop', true ) ) {
			return $content;
		}

		// Skip on archive-like pages when configured
		$archives = (array) $this->get_data( 'lmt_archives' );
		foreach ( $archives as $archive ) {
			if ( in_array( $archive, $this->functions, true ) && is_callable( $archive ) && $archive() ) {
				return $content;
			}
		}

		$timestamp = $this->get_timestamp( $post_id );
		if ( ! $timestamp ) {
			return $content;
		}

		$author_id = $this->get_meta( $post_id, '_edit_last' );
		if ( $this->is_equal( 'show_author_cb', 'custom', 'default' ) ) {
			$author_id = $this->get_data( 'lmt_show_author_list' );
		}

		$markup = $this->generate( $template, $post_id, $timestamp, $author_id );
		$markup = $this->wrapper( $markup, $post_id );

		$content = ( $position === 'before_content' )
			? $markup . $content
			: $content . $markup;

		return $this->do_filter( 'post_content_output', $content, $position, $markup, $post_id );
	}

	/**
	 * Replace original publish date via inline JS (footer).
	 */
	public function run_replace() {
		$post = get_post();
		if ( ! $post instanceof \WP_Post || ! is_singular() ) {
			return;
		}

		if ( ! $this->is_enabled( 'enable_last_modified_cb' ) ) {
			return;
		}

		$allowed_types = (array) $this->get_data( 'lmt_custom_post_types_list', [ 'post' ] );
		if ( ! in_array( $post->post_type, $allowed_types, true ) ) {
			return;
		}

		if ( 'replace_original' !== $this->get_data( 'lmt_show_last_modified_time_date_post', 'before_content' ) ) {
			return;
		}

		if ( 'yes' === $this->get_meta( $post->ID, '_lmt_disable' ) ) {
			return;
		}

		$template  = trim( (string) $this->get_data( 'lmt_last_modified_info_template' ) );
		$selectors = trim( (string) $this->get_data( 'lmt_css_selectors' ) );

		if ( '' === $template || '' === $selectors ) {
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

		$markup = $this->generate( $template, $post->ID, $timestamp, $author_id );

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<div class="wplmi-frontend-template" style="display:none;">' . $markup . '</div>';
		?>
		<script>
		( function() {
			const tpl  = document.querySelector( '.wplmi-frontend-template' );
			if ( ! tpl ) { return; }
			const nodes = document.querySelectorAll( '<?php echo wp_kses_post( str_replace( [ "\r", "\n" ], '', $selectors ) ); ?>' );
			nodes.forEach( el => el.outerHTML = tpl.innerHTML );
		} )();
		</script>
		<?php
	}

	/**
	 * Build human or formatted date string for the given post.
	 *
	 * @param int $post_id
	 * @return string|false
	 */
	private function get_timestamp( $post_id ) {
		$published = (int) get_post_time( 'U', false, $post_id );
		$modified  = (int) get_post_modified_time( 'U', false, $post_id );
		$gap       = (int) $this->get_data( 'lmt_gap_on_post', 0 );

		// Skip if modification is within the configured gap
		if ( ( $modified - $published ) < $gap ) {
			return false;
		}

		$type = $this->do_filter( 'post_datetime_type', $this->get_data( 'lmt_last_modified_format_post', 'default' ), $post_id );

		if ( 'default' === $type ) {
			$format = $this->do_filter( 'post_datetime_format', $this->get_data( 'lmt_date_time_format', get_option( 'date_format' ) ), $post_id );
			$date   = $this->get_modified_date( $format, $post_id );
		} else {
			$date = human_time_diff( $modified, current_time( 'U' ) ) . ' ' . __( 'ago', 'wp-last-modified-info' );
		}

		return $this->do_filter( 'post_formatted_date', $date, $post_id );
	}

	/**
	 * Replace placeholders inside template.
	 *
	 * @param string $html
	 * @param int    $post_id
	 * @param string $timestamp
	 * @param int    $author_id
	 * @return string
	 */
	protected function generate( $html, $post_id, $timestamp, $author_id ) {
		$html = htmlspecialchars_decode( wp_unslash( $html ) );

		// Schema markup for inline JSON-LD
		if ( $this->is_equal( 'enable_jsonld_markup_cb', 'inline' ) && ! $this->is_archive() ) {
			$datetime  = get_post_modified_time( 'Y-m-d\TH:i:sP', false, $post_id );
			$timestamp = sprintf(
				'<time itemprop="dateModified" datetime="%1$s">%2$s</time>',
				esc_attr( $datetime ),
				esc_html( $timestamp )
			);
		}

		// Author data
		$author_name   = get_the_author_meta( 'display_name', $author_id );
		$author_url    = esc_url( get_the_author_meta( 'url', $author_id ) );
		$author_email  = sanitize_email( get_the_author_meta( 'user_email', $author_id ) );
		$author_posts  = esc_url( get_author_posts_url( $author_id ) );

		// Post data
		$date_format = $this->do_filter( 'post_published_date_format', get_option( 'date_format' ), $post_id );
		$published   = esc_html( get_post_time( $date_format, false, $post_id, true ) );
		$permalink   = esc_url( get_permalink( $post_id ) );
		$categories  = get_the_category_list( $this->do_filter( 'post_categories_separator', ', ', $post_id ), '', $post_id );
		$comments    = get_comments_number( $post_id );

		$replacements = [
			'%original_author_name%' => get_the_author(),
			'%post_original_author%' => get_the_author(),
			'%author_name%'          => $author_name,
			'%post_author%'          => $author_name,
			'%author_url%'           => $author_url,
			'%author_website%'       => $author_url,
			'%author_email%'         => $author_email,
			'%author_archive%'       => $author_posts,
			'%author_posts_url%'     => $author_posts,
			'%post_published%'       => $published,
			'%published_date%'       => $published,
			'%post_link%'            => $permalink,
			'%post_categories%'      => $categories,
			'%comment_count%'        => $comments,
			'%post_modified%'        => $timestamp,
			'%modified_date%'        => $timestamp,
		];

		$html = str_replace( array_keys( $replacements ), array_values( $replacements ), $html );
		$html = $this->do_filter( 'post_tags', $html, $post_id );
		$html = str_replace( [ "\r", "\n" ], '', $html );

		$allowed = wp_kses_allowed_html( 'post' );
		$allowed['time'] = [
			'class'    => true,
			'itemprop' => true,
			'datetime' => true,
		];

		return wp_kses( $html, $allowed );
	}

	/**
	 * Wrap generated markup.
	 *
	 * @param string $content
	 * @param int    $post_id
	 * @param bool   $remove
	 * @param bool   $wrap
	 * @param string $output_type
	 * @param string $element
	 * @return string
	 */
	protected function wrapper( $content, $post_id, $remove = false, $wrap = false, $output_type = 'post', $element = 'p' ) {
		$element = $this->do_filter( $output_type . '_wrapper_element', $element, $post_id );

		if ( $this->do_filter( $output_type . '_remove_auto_p', $remove, $post_id ) ) {
			$content = preg_replace( '/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $content );
		}

		if ( $this->do_filter( $output_type . '_wrapper', $wrap, $post_id ) ) {
			$content = sprintf(
				'<%1$s class="wplmi-%2$s post-last-modified">%3$s</%1$s>',
				tag_escape( $element ),
				esc_attr( $output_type ),
				$content
			);
		}

		return $content;
	}

	/**
	 * Determine whether current request is an archive page.
	 *
	 * @return bool
	 */
	private function is_archive() {
		return is_archive() || is_tax() || is_home() || is_front_page() || is_search() || is_404();
	}
}
