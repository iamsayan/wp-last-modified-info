(function($) {

    // Copy of the WP inline edit post function.
    var $wp_inline_edit = inlineEditPost.edit;

    // Overwrite the function.
    inlineEditPost.edit = function( id ) {

        // Invoke the original function.
        $wp_inline_edit.apply( this, arguments );

        var $post_id = 0;
        if ( typeof( id ) == 'object' ) {
            $post_id = parseInt( this.getId( id ) );
        }

        if ( $post_id > 0 ) {
            // Define the edit row.
            var $edit_row = $( '#edit-' + $post_id );
            var $post_row = $( '#post-' + $post_id );

            // Get the data
            var $disabled = $( '.column-lastmodified .hidden-disabled', $post_row ).text();
            var $modified = $( '.column-lastmodified .hidden-pm', $post_row ).text();
            var $status = $( '.column-lastmodified .hidden-status', $post_row ).text();
            var $month = $( '.column-lastmodified .hidden-df', $post_row ).text().replace(/\d/g, '');
            var $mmm = $month.substr( 0, 3 );
            var $date = $( '.column-lastmodified .hidden-df', $post_row ).text().replace(/[^0-9]/gi, '');
            var $jjm = $date.substr( 0, 2 );
            var $aam = $date.substr( 2, 4 );
            var $hhm = $date.substr( 6, 2 );
            var $mnm = $date.substr( 8, 2 );
            var $ssm = $date.substr( 10, 2 );
            var $wplmi_disable_update = !! $( '.column-lastmodified .wplmi-lock', $post_row ).size();

            // Populate the data.
            $( ':input[name="mmm"]', $edit_row ).find( "[data-text='" + $mmm + "']" ).attr( 'selected', 'selected' );
            $( ':input[name="jjm"]', $edit_row ).val( $jjm );
            $( ':input[name="aam"]', $edit_row ).val( $aam );
            $( ':input[name="hhm"]', $edit_row ).val( $hhm );
            $( ':input[name="mnm"]', $edit_row ).val( $mnm );
            $( ':input[name="ssm"]', $edit_row ).val( $ssm );
            $( ':input[name="disableupdate"]', $edit_row ).prop( 'checked', $wplmi_disable_update );
            $( ':input[name="wplmi_disable"]', $edit_row ).val( $disabled );
            $( ':input[name="wplmi_modified"]', $edit_row ).val( $modified );

            var $statuses = [ 'future', 'auto-draft' ];
            if ( $statuses.includes( $status ) ) {
                $( '#inline-edit-col-modified-date', $edit_row ).remove();
            }

            $( '.time-modified', $edit_row ).change( function() {
                if ( ! $( '#wplmi_disable', $edit_row ).is( ':checked' ) ) {
                    $( '#wplmi-change-modified', $edit_row ).val( 'yes' );
                }
            });

            $( '#wplmi_disable', $edit_row ).change( function() {
                if ( $(this).is( ':checked' ) ) {
                    $( '#wplmi-disable-hidden', $edit_row ).val( 'yes' );
                }
                if ( ! $(this).is( ':checked' ) ) {
                    $( '#wplmi-disable-hidden', $edit_row ).val( 'no' );
                }
            }).change();
        }
    };

    $( '#inline-edit-col-modified-date' ).appendTo( '.inline-edit-col-left:first-child .inline-edit-col .inline-edit-date' );

})(jQuery);