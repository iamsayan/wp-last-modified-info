( function( $ ) {

    // Copy of the WP inline edit post function.
    let $wp_inline_edit = inlineEditPost.edit;

    // Overwrite the function.
    inlineEditPost.edit = function( id ) {

        // Invoke the original function.
        $wp_inline_edit.apply( this, arguments );

        let $post_id = 0;
        if ( typeof( id ) == 'object' ) {
            $post_id = parseInt( this.getId( id ) );
        }

        if ( $post_id > 0 ) {
            // Define the edit row.
            let $edit_row = $( '#edit-' + $post_id );
            let $post_row = $( '#post-' + $post_id );

            // Get the data
            let $disabled = $( '.column-lastmodified .wplmi-hidden-disabled', $post_row ).text();
            let $modified = $( '.column-lastmodified .wplmi-hidden-post-modified', $post_row ).text();
            let $status = $( '.column-lastmodified .wplmi-hidden-status', $post_row ).text();
            let $month = $( '.column-lastmodified .wplmi-hidden-date-format', $post_row ).text().replace(/\d/g, '');
            let $mmm = $month.substr( 0, 3 );
            let $date = $( '.column-lastmodified .wplmi-hidden-date-format', $post_row ).text().replace(/[^0-9]/gi, '');
            let $jjm = $date.substr( 0, 2 );
            let $aam = $date.substr( 2, 4 );
            let $hhm = $date.substr( 6, 2 );
            let $mnm = $date.substr( 8, 2 );
            let $ssm = $date.substr( 10, 2 );
            let $wplmi_disable_update = !! $( '.column-lastmodified .wplmi-lock', $post_row ).size();

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

            let $statuses = [ 'future', 'auto-draft' ];
            if ( $statuses.includes( $status ) ) {
                $( '#inline-edit-col-modified-date', $edit_row ).remove();
            }

            $( '.time-modified', $edit_row ).on( 'change', function() {
                /*if ( ! $( '#wplmi_disable', $edit_row ).is( ':checked' ) ) {
                    $( '#wplmi-change-modified', $edit_row ).val( 'yes' );
                }*/

                $( '#wplmi-change-modified', $edit_row ).val( 'yes' );
                // $( '#wplmi-disable-hidden', $edit_row ).val( 'no' );
                // $( '#wplmi_disable', $edit_row ).prop( 'checked', false );
            });

            $( '#wplmi_disable', $edit_row ).on( 'change', function() {
                if ( $( this ).is( ':checked' ) ) {
                    $( '#wplmi-disable-hidden', $edit_row ).val( 'yes' );
                }
                if ( ! $( this ).is( ':checked' ) ) {
                    $( '#wplmi-disable-hidden', $edit_row ).val( 'no' );
                }
            } ).trigger( 'change' );
        }

    };

    $( '#inline-edit-col-modified-date' ).insertAfter( '.inline-edit-col-left:first-child .inline-edit-col .inline-edit-date' );

    $( 'body' ).on( 'click', '#bulk_edit', function( e ) {
        let el = $( this );
        if ( el.hasClass( 'prevented' ) ) {
            return;
        }

        e.preventDefault();
        el.addClass( 'prevented' );

        // let's add the WordPress default spinner just before the button
		el.after( '<span class="spinner is-active"></span>' );
	
		// define the bulk edit row
		let $bulk_row = $( '#bulk-edit' );
		
		// get the selected post ids that are being edited
		let $post_ids = new Array();
		$bulk_row.find( '#bulk-titles' ).children().each( function() {
			$post_ids.push( $( this ).attr( 'id' ).replace( /^(ttle)/i, '' ) );
		} );
		
		// get the custom fields
		let $modified_month = $bulk_row.find( 'select[name="mmm"]' ).val();
		let $modified_day = $bulk_row.find( 'input[name="jjm"]' ).val();
		let $modified_year = $bulk_row.find( 'input[name="aam"]' ).val();
		let $modified_hour = $bulk_row.find( 'input[name="hhm"]' ).val();
        let $modified_minute = $bulk_row.find( 'input[name="mnm"]' ).val();
        let $modified_disable = $bulk_row.find( 'select[name="disable_update"]' ).val();

        let wplmiBulkData = {
            action: 'wplmi_process_bulk_edit',
            post_ids: $post_ids,
            modified_month: $modified_month,
            modified_day: $modified_day,
            modified_year: $modified_year,
            modified_hour: $modified_hour,
            modified_minute: $modified_minute,
            modified_disable: $modified_disable,
            security: wplmi_edit_L10n.security
        };

        $.post( wplmi_edit_L10n.ajaxurl, wplmiBulkData, function( response ) {
            $( 'body' ).find( '#bulk_edit' ).trigger( 'click' );
        } );
	} );

} )( jQuery );