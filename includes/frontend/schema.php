<?php 
/**
 * Runs on Frontend
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

add_action( 'wp_head', 'lmt_json_ld_schema_markup', 10 );

function lmt_json_ld_schema_markup() { 
    $options = get_option('lmt_plugin_global_settings');

    // do not run on front, home page, archive pages, search result pages, and 404 error pages
	if( is_archive() || is_home() || is_front_page() || is_search() || is_404() ) return;

    global $post;
    $author_id = get_post_meta( $post->ID, '_edit_last', true ); 

    // get post infos
    $full_content = $post->post_content;
    $excerpt = $post->post_excerpt;

    // Strip shortcodes and tags
	$full_content = preg_replace( '#\[[^\]]+\]#', '', $full_content );
    $full_content = wp_strip_all_tags( $full_content );
    $full_content = apply_filters( 'wplmi_custom_schema_content', $full_content );

    $desc_word_count = apply_filters( 'wplmi_schema_description_word_count', 60 );
    $short_content = wp_trim_words( $full_content, $desc_word_count, '' );
    $short_content = apply_filters( 'wplmi_custom_schema_description', ( $excerpt != '' ) ? $excerpt : $short_content );

    $json = [
        '@context'         => 'http://schema.org/',
        '@type'            => 'CreativeWork',
        'dateModified'     => get_post_modified_time( 'Y-m-d\TH:i:sP', false ),
        'headline'         => esc_html( $post->post_title ),
        'description'      => wptexturize( $short_content ),
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id'   => get_permalink( $post->ID ),
        ],
        'author'           => [
            '@type'          => 'Person',
            'name'           => esc_html( get_the_author_meta( 'display_name', $author_id ) ),
            'url'            => get_author_posts_url( $author_id ),
            'description'    => esc_html( get_the_author_meta( 'description', $author_id ) ),
        ],
    ];

    if( is_page() ) {
        // change schema type for pages
        $json['@type'] = 'WebPage';
        unset( $json['mainEntityOfPage'] );
    }

    $json = apply_filters( 'wplmi_edit_schema_item', $json );

    $output = '';
    if( ! empty( $json ) ) {
        $output .= "\n\n";
	    $output .= '<!-- Last Modified Schema is inserted by the WP Last Modified Info plugin v'.LMT_PLUGIN_VERSION.' - https://wordpress.org/plugins/wp-last-modified-info/ -->';
	    $output .= "\n";
        $output .= '<script type="application/ld+json">' . wp_json_encode( $json ) . '</script>';
        $output .= "\n\n";
    }

    if( isset($options['lmt_enable_jsonld_markup_cb']) && ($options['lmt_enable_jsonld_markup_cb'] == 'enable') ) {
        if( isset($options['lmt_enable_jsonld_markup_post_types']) ) {
            $post_types = $options['lmt_enable_jsonld_markup_post_types'];
            if( in_array( get_post_type( get_the_ID() ), $post_types ) ) {
                echo $output;
            }
        }
    }
}

if( isset($options['lmt_enable_schema_support_cb']) && ($options['lmt_enable_schema_support_cb'] == 1) ) {
    add_filter( 'language_attributes', 'lmt_add_schema_attribute' );
}

function lmt_add_schema_attribute( $input ) {
    $output = trim( $input );
    $attrs = array(
        array(
            'attr'  => 'itemscope itemtype',
            'value' => 'https://schema.org/WebPage',
        ),
    );
    foreach( $attrs as $info ) {
        if( strpos( $input, $info['attr'] ) === false ) {
            $output .= ' ' . $info['attr'] . '="' . $info['value'] . '"';
        }
    }
    return $output;
}
