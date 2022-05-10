(function($) {

    let $tsmdiv = $('#timestampmodifieddiv');
	
	/**
	 * Partially borrowed from wp-admin/js/post.js
	 */
	$tsmdiv.siblings( 'a.edit-timestampmodified' ).click( function( e ) {
        if ( $tsmdiv.is( ':hidden' ) ) {
			$tsmdiv.slideDown( 'fast', function() {
				$( 'input, select', $tsmdiv.find( '.timestamp-wrap' ) ).first().focus();
			} );
			$(this).hide();
		}
        e.preventDefault();
    });
    
	$tsmdiv.find( '.cancel-timestamp' ).click( function( e ) {
        $tsmdiv.slideUp( 'fast' ).siblings( 'a.edit-timestampmodified' ).show().focus();
		$( '#mmm' ).val( $('#hidden_mmm').val() );
		$( '#jjm' ).val( $('#hidden_jjm').val() );
		$( '#aam' ).val( $('#hidden_aam').val() );
		$( '#hhm' ).val( $('#hidden_hhm').val() );
        $( '#mnm' ).val( $('#hidden_mnm').val() );
        updateTextModified();
        $( '#wplmi-change-modified ').val( 'no' );
        e.preventDefault();
    });
    
	$tsmdiv.find( '.save-timestamp' ).click( function( e ) {
        if ( $( '#wplmi_disable' ).is( ':checked' ) ) {
            $( '#mmm' ).val( $('#hidden_mmm').val() );
		    $( '#jjm' ).val( $('#hidden_jjm').val() );
		    $( '#aam' ).val( $('#hidden_aam').val() );
		    $( '#hhm' ).val( $('#hidden_hhm').val() );
            $( '#mnm' ).val( $('#hidden_mnm').val() );
        } else {
            $( '#wplmi-change-modified' ).val( 'yes' );
        }

        if ( updateTextModified() ) {
            $tsmdiv.slideUp( 'fast' );
            $tsmdiv.siblings( 'a.edit-timestampmodified' ).show().focus();
        }
        e.preventDefault();
    });

    $( '#post' ).on( 'submit', function( e ) {
        if ( ! updateTextModified() ) {
            e.preventDefault();
            $tsmdiv.show();

            if ( wp.autosave ) {
                wp.autosave.enableButtons();
            }

            $( '#publishing-action .spinner' ).removeClass( 'is-active' );
        }
    });
    
    var updateTextModified = function() {
        if ( ! $tsmdiv.length ) {
			return true;
        }

		var dateFormat = '%1$s %2$s, %3$s ' + $tsmdiv.data( 'separator' ) + ' %4$s:%5$s';
		var aam = $( '#aam' ).val(), mmm = $( '#mmm' ).val(), jjm = $( '#jjm' ).val(), hhm = $( '#hhm' ).val(), mnm = $( '#mnm' ).val();
        var textModifiedOn = $tsmdiv.data( 'prefix' );
        var attemptedDate = new Date( aam, mmm - 1, jjm, hhm, mnm );

        if ( attemptedDate.getFullYear() != aam || (1 + attemptedDate.getMonth()) != mmm || attemptedDate.getDate() != jjm || attemptedDate.getMinutes() != mnm ) {
            $tsmdiv.find( '.timestamp-wrap' ).addClass( 'form-invalid' );
            return false;
        } else {
            $tsmdiv.find( '.timestamp-wrap' ).removeClass( 'form-invalid' );
        }

		$( '#wplmi-timestamp' ).html(
			'\n ' + textModifiedOn + ' <b>' +
			dateFormat
				.replace( '%1$s', $( 'option[value="' + mmm + '"]', '#mmm' ).attr( 'data-text' ) )
				.replace( '%2$s', parseInt( jjm, 10 ) )
				.replace( '%3$s', aam )
				.replace( '%4$s', ( '00' + hhm ).slice( -2 ) )
				.replace( '%5$s', ( '00' + mnm ).slice( -2 ) ) +
				'</b> '
        );
        
        $('#wplmi-timestamp-be').html(
            '\n ' + ' <b>' +
            dateFormat
                .replace( '%1$s', $( 'option[value="' + mmm + '"]', '#mmm' ).attr( 'data-text' ) )
                .replace( '%2$s', parseInt( jjm, 10 ) )
                .replace( '%3$s', aam )
                .replace( '%4$s', ( '00' + hhm ).slice( -2 ) )
                .replace( '%5$s', ( '00' + mnm ).slice( -2 ) ) +
                '</b> '
        );

		return true;
    }

    $( '#wplmi_disable' ).change( function() {
		if ( $(this).is( ':checked' ) ) {
			$( '#wplmi-disable-hidden' ).val( 'yes' );
		}
		if ( ! $(this).is( ':checked' ) ) {
			$( '#wplmi-disable-hidden' ).val( 'no' );
		}
    }).change();
    
    $( '.time-modified' ).change( function() {
        $( '#wplmi-disable-hidden' ).val( 'no' );
        $( '#wplmi_disable' ).prop( 'checked', false );
    });

})( jQuery );