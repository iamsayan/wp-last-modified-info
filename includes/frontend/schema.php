<?php 
/**
 * Runs on Frontend
 *
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 */

add_action( 'wp_head', 'lmt_json_ld_schema_markup' );

function lmt_json_ld_schema_markup() { 
    
    $options = get_option('lmt_plugin_global_settings');

    if( !is_singular() ) return;

    global $post;
    $author_id = get_post_meta( $post->ID, '_edit_last', true ); 

    if( isset($options['lmt_enable_last_modified_cb']) && ($options['lmt_enable_last_modified_cb'] == 1) ) {
        if( ( isset($options['lmt_enable_schema_on_post_cb']) && ($options['lmt_enable_schema_on_post_cb'] == 'jsonld') ) && is_singular( 'post' ) ) { ?>
            <script type="application/ld+json">
                {
                	"@context": "http://schema.org/",
                	"@type": "CreativeWork",
                	"dateModified": "<?php echo get_post_modified_time( 'Y-m-d\TH:i:sP', true ); ?>",
                	"headline": "<?php echo get_the_title(); ?>",
                	"text": "<?php echo preg_replace( '/\r|\n/', '', strip_tags( strip_shortcodes( $post->post_content ) ) ); ?>",
                    "author": {
                       "@type": "Person",
                       "name": "<?php echo get_the_author_meta( 'display_name', $author_id ); ?>",
                       "url": "<?php echo str_replace( '/', '\/', get_author_posts_url( $author_id ) ); ?>",
                       "description": "<?php echo strip_tags( get_the_author_meta( 'description', $author_id ) ); ?>"
                    }
                }
            </script>
        <?php
        } 
    }

    if( isset($options['lmt_enable_last_modified_page_cb']) && ($options['lmt_enable_last_modified_page_cb'] == 1) ) {
        if( ( isset($options['lmt_enable_schema_on_page_cb']) && ($options['lmt_enable_schema_on_page_cb'] == 'jsonld') ) && is_page() ) { ?>
            <script type="application/ld+json">
                {
                	"@context": "http://schema.org/",
                	"@type": "WebPage",
                	"dateModified": "<?php echo get_post_modified_time( 'Y-m-d\TH:i:sP', true ); ?>",
                	"headline": "<?php echo get_the_title(); ?>",
                	"text": "<?php echo preg_replace( '/\r|\n/', '', strip_tags( strip_shortcodes( $post->post_content ) ) ); ?>"
                }
            </script>
        <?php
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