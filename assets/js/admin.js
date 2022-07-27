jQuery(document).ready(function ($) {

    if ( typeof wplmiAdminL10n === 'undefined' ) {
        return false;
    }

    var highlighting = true,
    wplmi_editor, wplmi_css_editor, wplmi_tag_editor;

    if ( wplmiAdminL10n.highlighting == 'off' ) {
        highlighting = false;
    }

    if ( highlighting ) {
        wplmi_editor = wp.codeEditor.initialize($('#wplmi_display_info'), wplmiAdminL10n.html_editor);
        wplmi_css_editor = wp.codeEditor.initialize($('#wplmi_custom_css'), wplmiAdminL10n.css_editor);
        wplmi_tag_editor = wp.codeEditor.initialize($('#wplmi_template_display_info'), wplmiAdminL10n.html_editor);
    }

    var wplmi_btns = $( '#wplmi-nav-container' ).find( 'a.wplmi-tab:not(.type-link)' );
    for (var wplmi_btn of wplmi_btns) {
        $( wplmi_btn ).on( 'click', function (e) {
            e.preventDefault();
            var tab_id = $(this).attr('id').replace('wplmi-tab-', '');
            $('a.is-active').removeClass("is-active");
            $(this).addClass("is-active");
            $(".wplmi-metabox .wplmi-" + tab_id).removeClass('d-none');
            $(".wplmi-metabox .postbox:not(.wplmi-" + tab_id + "), .wplmi-metabox .sub-links:not(.wplmi-" + tab_id + ")").addClass('d-none');
            localStorage.setItem('wplmi_active_tab', tab_id);
            if ( highlighting ) {
                if ( tab_id == 'post' ) {
                    wplmi_editor.codemirror.refresh();
                }
                if ( tab_id == 'misc' ) {
                    wplmi_css_editor.codemirror.refresh();
                }
                if ( tab_id == 'template' ) {
                    wplmi_tag_editor.codemirror.refresh();
                }
            }
        });
    }

    let opt = ( p1, p2, c ) => {
        switch (c) {
            case '=':
                return p1 == p2;
            case '>':
                return p1 > p2;
            case '<':
                return p1 < p2;
            case '!=':
                return p1 != p2;
            case '>=':
                return p1 >= p2;
            case '<=':
                return p1 <= p2;
        }
    }

    $( '.wplmi-wrap' ).find( '.wplmi-form-el[data-condition]' ).each( function( _index, el ) {
        let condition = $( el ).data( 'condition' );
        $( `#wplmi_${condition[0].replace( 'wplmi_', '' )}` ).on( 'change', function() {
            let value = $(this).val();
            let values = condition[2];
            let isTrue = false;
            if ( Array.isArray( values ) ) {
                values.forEach( function( item ) {
                    if ( opt( value, item, condition[1] ) ) {
                        isTrue = true;
                    }
                } );
            } else {
                isTrue = opt( $(this).val(), values, condition[1] );
            }

            if ( isTrue ) {
                $( el ).closest( 'tr' ).removeClass( 'wplmi-c-hide' ).addClass( 'wplmi-c-show' ).slideDown();
            } else {
                $( el ).closest( 'tr' ).removeClass( 'wplmi-c-show' ).addClass( 'wplmi-c-hide' ).hide();
            }
        } ).trigger( 'change' );
    } );

    setTimeout( () => {
        $( '.wplmi-wrap' ).find( '.wplmi-form-el[data-show-if]' ).each( function( _index, el ) {
            let element = $( el ).data( 'show-if' );
            $( `#wplmi_${element.replace( 'wplmi_', '' )}` ).on( 'change', function() {
                if ( $( this ).is( ':checked' ) ) {
                    $( el ).closest( 'tr:not(.wplmi-c-hide)' ).slideDown();
                } else {
                    $( el ).closest( 'tr:not(.wplmi-c-hide)' ).hide();
                }
            } ).trigger( 'change' );
        } );
        
        if ( localStorage.wplmi_active_tab ) {
            $("#wplmi-nav-container").find("a#wplmi-tab-" + localStorage.wplmi_active_tab).trigger('click');
        } else {
            $("#wplmi-nav-container").find("a#wplmi-tab-general").trigger('click');
        }
    }, 50 );

    if ( highlighting ) {
        var editors = [ wplmi_editor, wplmi_css_editor, wplmi_tag_editor ];
        editors.forEach(function (item) {
            $( item.codemirror.getWrapperElement() ).resizable( {
                handles: 's',
                resize: function() {
                    var $this = $( this );
                    item.codemirror.setSize( $this.width(), $this.height() );
                }
            } );
    
            item.codemirror.on( 'change', function( editor ) {
                editor.save();
            } );
        } );

        $( '#wplmi-settings-form .wplmi_el_custom_css' ).find( '.CodeMirror' ).on( 'mousedown.codemirror', function() {
            var $this = $( this );
            $this.addClass( 'large' );
            wplmi_css_editor.codemirror.refresh();
            $this.off( 'mousedown.codemirror' );
        } );
        
        $( '#wplmi_enable_plugin' ).on( 'change', function() {
            var is_enabled = $( this ).prop( 'checked' );
            wplmi_editor.codemirror.setOption( 'readOnly', ! is_enabled );
            $( '#wplmi-settings-form .wplmi_el_display_info' ).find( '.CodeMirror' ).toggleClass( 'disabled', ! is_enabled );
        } ).trigger( 'change' );
    }

    $( '#wplmi-settings-form' ).submit( function( e ) {
        e.preventDefault();
        $( ".wplmi-save" ).addClass( "disabled" ).val( wplmiAdminL10n.saving );
        var jd = $.dialog({
            title: wplmiAdminL10n.saving,
            content: wplmiAdminL10n.saving_text,
            useBootstrap: false,
            draggable: false,
            theme: 'material',
            type: 'orange',
            closeIcon: false,
            boxWidth: '25%',
            scrollToPreviousElement: false,
        });
        $(this).ajaxSubmit({
            success: function() {
                jd.close();
                $.alert({
                    title: wplmiAdminL10n.done,
                    content: wplmiAdminL10n.save_success,
                    useBootstrap: false,
                    draggable: false,
                    theme: 'material',
                    type: 'green',
                    boxWidth: '25%',
                    scrollToPreviousElement: false,
                    buttons: {
                        buttonOK: {
                            text: wplmiAdminL10n.ok_button,
                        }
                    }
                });
                $(".wplmi-save").removeClass("disabled").val(wplmiAdminL10n.save_button);
            },
            error: function() { 
                jd.close();
                $.alert({
                    title: wplmiAdminL10n.error,
                    content: wplmiAdminL10n.process_failed,
                    useBootstrap: false,
                    draggable: false,
                    theme: 'material',
                    type: 'red',
                    boxWidth: '25%',
                    scrollToPreviousElement: false,
                    buttons: {
                        buttonOK: {
                            text: wplmiAdminL10n.ok_button,
                        }
                    }
                });
            },
        });
    });

    $( "input.wplmi-reset" ).on( 'click', function( e ) {
        e.preventDefault();
        var el = $(this);
        var action = el.data('action');
        var notice = el.data('notice');
        var success = el.data('success');
        var type = el.data('type');
        var process = el.data('process');
        var mdc = $.confirm({
            title: wplmiAdminL10n.warning,
            content: notice,
            useBootstrap: false,
            theme: 'material',
            animation: 'scale',
            type: 'red',
            boxWidth: '30%',
            draggable: false,
            scrollToPreviousElement: false,
            buttons: {
                confirm: {
                    text: wplmiAdminL10n.confirm_button,
                    action: function () {
                        mdc.close();
                        var cd = $.dialog({
                            title: process,
                            content: wplmiAdminL10n.processing,
                            useBootstrap: false,
                            draggable: false,
                            theme: 'material',
                            type: 'orange',
                            closeIcon: false,
                            boxWidth: '25%',
                            scrollToPreviousElement: false,
                        });
                        $.post( wplmiAdminL10n.ajaxurl, { action: action, action_type: type, security: wplmiAdminL10n.security }, function( response ) {
                            if( response.success === true ) {
                                cd.close();
                                $.alert({
                                    title: wplmiAdminL10n.done,
                                    content: success,
                                    useBootstrap: false,
                                    draggable: false,
                                    theme: 'material',
                                    type: 'green',
                                    boxWidth: '25%',
                                    scrollToPreviousElement: false,
                                    buttons: {
                                        buttonOK: {
                                            text: wplmiAdminL10n.ok_button,
                                            action: function () {
                                                if( response.data.reload === true ) {
                                                    localStorage.setItem('wplmi_active_tab', 'post');
                                                    location.reload();
                                                }
                                            }
                                        }
                                    }
                                });
                            } else {
                                cd.close();
                                $.alert({
                                    title: wplmiAdminL10n.error,
                                    content: response.data.error,
                                    useBootstrap: false,
                                    draggable: false,
                                    theme: 'material',
                                    type: 'red',
                                    boxWidth: '25%',
                                    scrollToPreviousElement: false,
                                    buttons: {
                                        buttonOK: {
                                            text: wplmiAdminL10n.ok_button,
                                        }
                                    }
                                });
                            }
                        });
                    }    
                },
                cancel: {
                    text: wplmiAdminL10n.cancel_button,
                } 
            }
        })
    } );

    $( "input.wplmi-copy" ).on( 'click', function( e ) {
        e.preventDefault();
        var el = $(this);
        var value = el.val();
        var action = el.data('action');
        el.addClass("disabled").val(wplmiAdminL10n.please_wait);
        $.post( wplmiAdminL10n.ajaxurl, { action: action, security: wplmiAdminL10n.security }, function( response ) {
            if ( response.success === true ) {
                if ( navigator.clipboard ) {
                    navigator.clipboard.writeText( response.data.elements ).then( function() {
                        console.log('Copied to clipboard!');
                    }, function(err) {
                        console.error('Could not copy text: ', err);
                    } );
                }
                el.removeClass("disabled").val(value);
                $(".wplmi-copied").show().delay(1000).fadeOut();
            } 
        });
    } );

    $( "input.wplmi-paste" ).on( 'click', function( e ) {
        e.preventDefault();
        var mdc = $.confirm({
            title: wplmiAdminL10n.paste_data,
            content: '<textarea id="wplmi-settings-data-import" rows="4" style="width: 100%;"></textarea>',
            useBootstrap: false,
            theme: 'material',
            animation: 'scale',
            type: 'green',
            boxWidth: '40%',
            draggable: false,
            scrollToPreviousElement: false,
            buttons: {
                confirm: {
                    text: wplmiAdminL10n.import_btn,
                    action: function () {
                        var settings_data = this.$content.find('#wplmi-settings-data-import').val();
                        if ( ! settings_data ) {
                            alert( 'Please enter valid settings data!' );
                            return false;
                        }
                        mdc.close();
                        $.dialog({
                            title: wplmiAdminL10n.importing,
                            content: wplmiAdminL10n.processing,
                            useBootstrap: false,
                            draggable: false,
                            theme: 'material',
                            type: 'orange',
                            closeIcon: false,
                            boxWidth: '25%',
                            scrollToPreviousElement: false,
                        });
                        $.post( wplmiAdminL10n.ajaxurl, { action: 'wplmi_process_import_plugin_data', settings_data: settings_data, security: wplmiAdminL10n.security }, function( response ) {
                            if( response.success === true ) {
                                localStorage.setItem('wplmi_active_tab', 'post');
                                location.reload();
                            } 
                        });
                    }    
                },
                close: {
                    text: wplmiAdminL10n.close_btn,
                } 
            }
        })
    } );

    $( '#wplmi_post_types, #wplmi_schema_post_types, #wplmi_notification_post_types, #wplmi_archives' ).selectize( {
        plugins: ['remove_button'],
        delimiter: ',',
        placeholder: $(this).data('placeholder'),
        persist: false,
        create: false
    } );

    $('#wplmi_recipients_list').selectize({
        plugins: ['remove_button', 'restore_on_backspace'],
        persist: false,
        create: true,
        createOnBlur: true,
        delimiter: ',',
        placeholder: $(this).data('placeholder'),
        createFilter: function(input) {
            var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return regex.test(String(input).toLowerCase());
        }
    });

    $(".coffee-amt").on( 'change', function() {
        var btn = $('.buy-coffee-btn');
        btn.attr('href', btn.data('link') + $(this).val());
    });

    $( 'a.share-btn:not(.no-popup)' ).on( 'click', function (e) {
        e.preventDefault();
        wplmiOpenPopup( $(this).attr('href'), 'Share Window', 950, 700 );
    } );

    $( window ).keydown( function(e) {
        if (e.ctrlKey || e.metaKey) {
            switch (String.fromCharCode(e.which).toLowerCase()) {
                case 's':
                    e.preventDefault();
                    $('#wplmi-settings-form').submit();
                    break;
            }
        }
    });

    $( '.click-to-copy' ).on( 'click', function( e ) {
        e.preventDefault();
        if ( highlighting ) {
            var active_tab = localStorage.getItem('wplmi_active_tab'),
                editor;
            if ( active_tab == 'post' ) {
                editor = wplmi_editor;
            }
            if ( active_tab == 'misc' ) {
                editor = wplmi_css_editor;
            }
            if ( active_tab == 'template' ) {
                editor = wplmi_tag_editor;
            }
            insertText( $( this ).text(), editor );
        } else {
            insertAtCursor( $( this ).parents( 'td' ).find( 'textarea' ), $( this ).text() );
        }
    } )

    function insertText( data, cme ) {
        var cm = cme.codemirror;
        var doc = cm.getDoc();
        var cursor = doc.getCursor();
        var pos = {
            line: cursor.line,
            ch: cursor.ch
        };
        doc.replaceRange(data, pos);
    }

    function insertAtCursor( myField, myValue ) {
        var cursorPos = myField.prop( 'selectionStart' );
        var v = myField.val();
        var textBefore = v.substring( 0,  cursorPos );
        var textAfter  = v.substring( cursorPos, v.length );
    
        myField.val( textBefore + myValue + textAfter );
    }
});

function wplmiOpenPopup( url, title, w, h ) {
    var y = window.outerHeight / 2 + window.screenY - ( h / 2)
    var x = window.outerWidth / 2 + window.screenX - ( w / 2)
    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + y + ', left=' + x);
}