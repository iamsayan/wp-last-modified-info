<?php

/**
 * @package   WP Last Modified Info
 * @author    Sayan Datta
 * @license   http://www.gnu.org/licenses/gpl.html
 * @since     v1.5.0
 *
 * Notify admin users about the modification of the posts of their website or blog.
 */

add_action( 'post_updated', 'lmt_trigger_post_updated_action', 10, 3 );

function lmt_trigger_post_updated_action( $post_id, $post_after, $post_before ) {
    $options = get_option('lmt_plugin_global_settings');

    if( !( isset($options['lmt_enable_notification_cb']) && ($options['lmt_enable_notification_cb'] == 1) ) ) {
        return;
    }

    // Transitioning from an Auto Draft to Published shouldn't result in a notification.
    if ( $post_before->post_status === 'auto-draft' && $post_after->post_status === 'publish' ) {
        return;
    }

    // If we're purely saving a draft, and don't have the draft option enabled, skip. If we're transitioning one way or the other, send a notification.
    if ( !( isset( $options['lmt_enable_draft_noti_cb'] ) && 1 == $options['lmt_enable_draft_noti_cb'] ) && in_array( $post_before->post_status, array( 'draft', 'auto-draft' ) ) && 'draft' == $post_after->post_status ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( isset( $options['lmt_enable_noti_post_types'] ) && !in_array( $post_before->post_type, $options['lmt_enable_noti_post_types'] ) ) {
        return;
    }

    // If this is a new post, skip.
    $child_posts = wp_get_post_revisions( $post_id, array( 'numberposts' => 1 ) );
    if ( count( $child_posts ) == 0 ) {
        return;
    }

    if ( ! $post_before || ! $post_after ) {
        return;
    }

    // Get current time
	$time = date_i18n( apply_filters( 'wplmi_notification_date_time_format', 'j F, Y @ g:i a' ), current_time( 'timestamp', 0 ) );
    $post_author = get_user_by( 'id', $post_before->post_author );

    $text = '';
    if ( $post_before->post_title !== $post_after->post_title ) {
        $text .= __( '<strong>Old Title:</strong> ' ) . $post_before->post_title . "\n";
        $text .= __( '<strong>New Title:</strong> ' ) . $post_after->post_title . "\n\n";
    }

    if ( $post_before->post_content !== $post_after->post_content ) {
        $text .= __( '<strong>Old Post Content:</strong> ' ) . $post_before->post_content . "\n";
        $text .= __( '<strong>New Post Content:</strong> ' ) . $post_after->post_content . "\n\n";
    }

    if ( $post_before->post_excerpt !== $post_after->post_excerpt ) {
        $text .= __( '<strong>Old Excerpt:</strong> ' ) . $post_before->post_excerpt . "\n";
        $text .= __( '<strong>New Excerpt:</strong> ' ) . $post_after->post_excerpt . "\n\n";
    }

    if ( $post_before->post_author !== $post_after->post_author ) {
        $text .= __( '<strong>Old Author:</strong> ' ) . get_the_author_meta( 'display_name', $post_before->post_author ) . "\n";
        $text .= __( '<strong>New Author:</strong> ' ) . get_the_author_meta( 'display_name',  $post_after->post_author ) . "\n\n";
    }

    if ( $post_before->post_name !== $post_after->post_name ) {
        $text .= __( '<strong>Old Link:</strong> ' ) . str_replace( $post_after->post_name, $post_before->post_name, get_permalink( $post_before->ID ) ) . "\n";
        $text .= __( '<strong>New Link:</strong> ' ) . get_permalink( $post_after->ID ) . "\n\n";
    }

    if ( $post_before->comment_status !== $post_after->comment_status ) {
        $text .= __( '<strong>Old Comment Status:</strong> ' ) . ucfirst( $post_before->comment_status ). "\n";
        $text .= __( '<strong>New Comment Status:</strong> ' ) . ucfirst( $post_after->comment_status ). "\n\n";
    }

    if ( $post_before->ping_status !== $post_after->ping_status ) {
        $text .= __( '<strong>Old Ping Status:</strong> ' ) . ucfirst( $post_before->ping_status ). "\n";
        $text .= __( '<strong>New Ping Status:</strong> ' ) . ucfirst( $post_after->ping_status ). "\n\n";
    }

    $text = apply_filters( 'wplmi_post_edit_custom_action', $text, $post_before, $post_after );

    $blogurl = get_bloginfo( 'url' );
    $blogname = get_bloginfo( 'name' );
    $blogname = wp_specialchars_decode( $blogname, ENT_QUOTES );
    $blog_admin_email = get_bloginfo( 'admin_email' );
    
    $emailSubject = $options['lmt_email_subject'];
    $emailSubject = stripslashes( $emailSubject );
    $emailSubject = str_replace( '%author_name%', get_the_author_meta( 'display_name', $post_before->post_author ), $emailSubject ); 
    $emailSubject = str_replace( '%modified_author_name%', get_the_author_meta( 'display_name', get_post_meta( $post_id, '_edit_last', true ) ), $emailSubject ); 
    $emailSubject = str_replace( '%post_title%', $post_before->post_title, $emailSubject ); 
    $emailSubject = str_replace( '%post_type%', get_post_type( $post_id ), $emailSubject ); 
    $emailSubject = str_replace( '%post_edit_link%', get_edit_post_link( $post_id ), $emailSubject ); 
    $emailSubject = str_replace( '%current_time%', $time, $emailSubject );
    $emailSubject = str_replace( '%site_name%', $blogname, $emailSubject ); 
    $emailSubject = str_replace( '%site_url%', $blogurl, $emailSubject );
    $emailSubject = stripslashes( strip_tags( $emailSubject ) );

    $emailBody = $options['lmt_email_message'];
    $emailBody = stripslashes( $emailBody );
    $emailBody = str_replace( '%admin_email%', $blog_admin_email, $emailBody ); 
    $emailBody = str_replace( '%author_name%', get_the_author_meta( 'display_name', $post_before->post_author ), $emailBody );
    $emailBody = str_replace( '%modified_author_name%', get_the_author_meta( 'display_name', get_post_meta( $post_id, '_edit_last', true ) ), $emailBody ); 
    $emailBody = str_replace( '%post_title%', $post_before->post_title, $emailBody );
    $emailBody = str_replace( '%post_type%', get_post_type( $post_id ), $emailBody ); 
    $emailBody = str_replace( '%post_edit_link%', get_edit_post_link( $post_id ), $emailBody );
    $emailBody = str_replace( '%current_time%', $time, $emailBody );
    $emailBody = str_replace( '%site_name%', $blogname, $emailBody ); 
    $emailBody = str_replace( '%site_url%', $blogurl, $emailBody );
    $emailBody = stripslashes( htmlspecialchars_decode( $emailBody ) );
    $emailBody = str_replace( '%post_diff%', str_replace( "\n", '<br>', $text ), $emailBody );
    
    $emailRecipient = $options['lmt_email_recipient'];
    $recipient = array();
    $recipient = explode( ',', $emailRecipient );
    if( isset($options['lmt_enable_author_noti_cb']) && ($options['lmt_enable_author_noti_cb'] == 1) ) {
        if( !in_array( $post_author->data->user_email, $recipient ) ) {
            $recipient[] = $post_author->data->user_email;
        }
    }
    $subject = $emailSubject;
    $body = apply_filters( 'wplmi_custom_email_template', $emailBody );
    $headers = array( 'Content-Type: text/html; charset=UTF-8' );
    $headers = apply_filters( 'wplmi_custom_email_headers', $headers );

    if( !empty( $text ) ) {
        wp_mail( $recipient, $subject, $body, $headers );
        //error_log( $subject . $body );
    }
}

?>