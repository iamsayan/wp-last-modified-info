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
            var $month = $( '.column-lastmodified .hidden-df', $post_row ).text().replace(/\d/g, '');
            var $mmm = $month.substr(0, 3);
            var $date = $( '.column-lastmodified .hidden-df', $post_row ).text().replace(/[^0-9]/gi, '');
            var $jjm = $date.substr(0, 2);
            var $aam = $date.substr(2, 4);
            var $hhm = $date.substr(6, 2);
            var $mnm = $date.substr(8, 2);
            var $lmt_disable_update = !! $( '.column-lastmodified .lmt-lock', $post_row ).size();
            var $lmt_switch_update = $( '.column-lastmodified .lmt-lock', $post_row ).size();

            // Populate the data.
            $( ':input[name="mmm"]', $edit_row ).find("[data-text='" + $mmm + "']").attr('selected', 'selected' );
            $( ':input[name="jjm"]', $edit_row ).val( $jjm );
            $( ':input[name="aam"]', $edit_row ).val( $aam );
            $( ':input[name="hhm"]', $edit_row ).val( $hhm );
            $( ':input[name="mnm"]', $edit_row ).val( $mnm );
            $( ':input[name="disableupdate"]', $edit_row ).prop('checked', $lmt_disable_update );
            $( ':input[name="disableupdatehidden"]', $edit_row ).val( $lmt_switch_update );
        }
    };

    // default check the last modified on/off checkbox
    $('#lmt_status').prop('checked', true);

})(jQuery);