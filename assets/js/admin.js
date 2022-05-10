jQuery(document).ready(function ($) {

    if ( typeof wplmi_admin_L10n === 'undefined' ) {
        return false;
    }

    var highlighting = true;
    if ( wplmi_admin_L10n.highlighting == 'disable' ) {
        highlighting = false;
    }

    if ( highlighting ) {
        var wplmi_editor = wp.codeEditor.initialize($('#wplmi_display_info'), wplmi_admin_L10n.html_editor);
        var wplmi_css_editor = wp.codeEditor.initialize($('#wplmi_custom_css'), wplmi_admin_L10n.css_editor);
        var wplmi_tag_editor = wp.codeEditor.initialize($('#wplmi_template_display_info'), wplmi_admin_L10n.html_editor);
    }

    var wplmi_btns = $( '#wplmi-nav-container' ).find( 'a.wplmi-tab:not(.type-link)' );
    for ( var i = 0; i < wplmi_btns.length; i++ ) {
        $( wplmi_btns[i] ).on( 'click', function (e) {
            e.preventDefault();
            var tab_id = $(this).attr('id').replace('wplmi-tab-', '');
            $('a.is-active').removeClass("is-active");
            $(this).addClass("is-active");
            $(".wplmi-metabox .wplmi-" + tab_id).removeClass('d-none');
            $(".wplmi-metabox .postbox:not(.wplmi-" + tab_id + "), .wplmi-metabox .sub-links:not(.wplmi-" + tab_id + ")").addClass('d-none');
            $.cookie('wplmi_active_tab', tab_id, { expires: 30 });
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

    setTimeout( function() {
        if ( typeof $.cookie('wplmi_active_tab') !== 'undefined' ) {
            $("#wplmi-nav-container").find("a#wplmi-tab-" + $.cookie('wplmi_active_tab')).trigger('click');
        } else {
            $("#wplmi-nav-container").find("a#wplmi-tab-general").trigger('click');
        }
    }, 50 );

    let opt = ( p1, p2, c ) => {
        switch (c) {
            case '=':
                return p1 == p2;
                break;
            case '>':
                return p1 > p2;
                break;
            case '<':
                return p1 < p2;
                break;
            case '!=':
                return p1 != p2;
                break;
            case '>=':
                return p1 >= p2;
                break;
            case '<=':
                return p1 <= p2;
                break;
        }
    }

    $( '.wplmi-wrap' ).find( '.wplmi-form-el[data-condition]' ).each( function( index, el ) {
        let condition = $( el ).data( 'condition' );
        $( `#wplmi_${condition[0].replace( 'wplmi_', '' )}` ).on( 'change', function() {
            if ( opt( $(this).val(), condition[2], condition[1] ) ) {
                $( el ).closest( 'tr' ).removeClass( 'wplmi-c-hide' ).addClass( 'wplmi-c-show' ).slideDown();
            } else {
                $( el ).closest( 'tr' ).removeClass( 'wplmi-c-show' ).addClass( 'wplmi-c-hide' ).hide();
            }
        } ).trigger( 'change' );
    } );

    setTimeout( () => {
        $( '.wplmi-wrap' ).find( '.wplmi-form-el[data-show-if]' ).each( function( index, el ) {
            let element = $( el ).data( 'show-if' );
            $( `#wplmi_${element.replace( 'wplmi_', '' )}` ).on( 'change', function() {
                if ( $( this ).is( ':checked' ) ) {
                    $( el ).closest( 'tr:not(.wplmi-c-hide)' ).slideDown();
                } else {
                    $( el ).closest( 'tr:not(.wplmi-c-hide)' ).hide();
                }
            } ).trigger( 'change' );
        } );

        $( '#wpbody-content' ).show();
    }, 100 );

    if ( highlighting ) {
        var editors = [ wplmi_editor, wplmi_css_editor, wplmi_tag_editor ];
        editors.forEach(function (item, index, arr) { 
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

    // $('#wplmi_astra_support').on('change', function() {
    //     if ($(this).val() == 'none') {
    //         if ( highlighting ) {
    //             wplmi_tag_editor.codemirror.setOption( 'readOnly', false );
    //             $( '#wplmi-settings-form .wplmi_el_template_display_info' ).find( '.CodeMirror' ).toggleClass( 'disabled', false );
    //         } else {
    //             $('#wplmi_template_display_info').removeAttr('readonly');
    //         }
    //     } else {
    //         $('#wplmi_theme_template_type').change();
    //     }
	// }).change();

    // $('#wplmi_theme_template_type').on('change', function() {
    //     var is_enabled;
    //     if ($(this).val() == 'default') {
    //         is_enabled = true;
    //     } else if ($(this).val() == 'custom') {
    //         is_enabled = false;
    //     }
    //     if ( highlighting ) {
	// 	    wplmi_tag_editor.codemirror.setOption( 'readOnly', is_enabled );
    //         $( '#wplmi-settings-form .wplmi_el_template_display_info' ).find( '.CodeMirror' ).toggleClass( 'disabled', is_enabled );
    //     } else {
    //         if ( is_enabled ) {
    //             $('#wplmi_template_display_info').attr('readonly','readonly');
    //         } else {
    //             $('#wplmi_template_display_info').removeAttr('readonly');
    //         }
    //     }
	// }).change();

    $( '#wplmi-settings-form' ).submit( function( e ) {
        e.preventDefault();
        $( ".wplmi-save" ).addClass( "disabled" ).val( wplmi_admin_L10n.saving );
        var jd = $.dialog({
            title: wplmi_admin_L10n.saving,
            content: wplmi_admin_L10n.saving_text,
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
                    title: wplmi_admin_L10n.done,
                    content: wplmi_admin_L10n.save_success,
                    useBootstrap: false,
                    draggable: false,
                    theme: 'material',
                    type: 'green',
                    boxWidth: '25%',
                    scrollToPreviousElement: false,
                    buttons: {
                        buttonOK: {
                            text: wplmi_admin_L10n.ok_button,
                            action: function () {}
                        }
                    }
                });
                $(".wplmi-save").removeClass("disabled").val(wplmi_admin_L10n.save_button);
            },
            error: function() { 
                jd.close();
                $.alert({
                    title: wplmi_admin_L10n.error,
                    content: wplmi_admin_L10n.process_failed,
                    useBootstrap: false,
                    draggable: false,
                    theme: 'material',
                    type: 'red',
                    boxWidth: '25%',
                    scrollToPreviousElement: false,
                    buttons: {
                        buttonOK: {
                            text: wplmi_admin_L10n.ok_button,
                            action: function () {}
                        }
                    }
                });;
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
            title: wplmi_admin_L10n.warning,
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
                    text: wplmi_admin_L10n.confirm_button,
                    action: function () {
                        mdc.close();
                        var cd = $.dialog({
                            title: process,
                            content: wplmi_admin_L10n.processing,
                            useBootstrap: false,
                            draggable: false,
                            theme: 'material',
                            type: 'orange',
                            closeIcon: false,
                            boxWidth: '25%',
                            scrollToPreviousElement: false,
                        });
                        $.post( wplmi_admin_L10n.ajaxurl, { action: action, action_type: type, security: wplmi_admin_L10n.security }, function( response, status ) {
                            if( response.success === true ) {
                                cd.close();
                                $.alert({
                                    title: wplmi_admin_L10n.done,
                                    content: success,
                                    useBootstrap: false,
                                    draggable: false,
                                    theme: 'material',
                                    type: 'green',
                                    boxWidth: '25%',
                                    scrollToPreviousElement: false,
                                    buttons: {
                                        buttonOK: {
                                            text: wplmi_admin_L10n.ok_button,
                                            action: function () {
                                                if( response.data.reload === true ) {
                                                    window.location.reload();
                                                    $.cookie('wplmi_active_tab', 'post', { expires: 30 });
                                                }
                                            }
                                        }
                                    }
                                });
                            } else {
                                cd.close();
                                $.alert({
                                    title: wplmi_admin_L10n.error,
                                    content: response.data.error,
                                    useBootstrap: false,
                                    draggable: false,
                                    theme: 'material',
                                    type: 'red',
                                    boxWidth: '25%',
                                    scrollToPreviousElement: false,
                                    buttons: {
                                        buttonOK: {
                                            text: wplmi_admin_L10n.ok_button,
                                            action: function () {}
                                        }
                                    }
                                });
                            }
                        });
                    }    
                },
                cancel: {
                    text: wplmi_admin_L10n.cancel_button,
                    action: function () {}
                } 
            }
        })
    } );

    $( "input.wplmi-copy" ).on( 'click', function( e ) {
        e.preventDefault();
        var el = $(this);
        var value = el.val();
        var action = el.data('action');
        el.addClass("disabled").val(wplmi_admin_L10n.please_wait);
        $.post( wplmi_admin_L10n.ajaxurl, { action: action, security: wplmi_admin_L10n.security }, function( response, status ) {
            if ( response.success === true ) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(response.data.elements).select();
                document.execCommand("copy");
                $temp.remove();
                el.removeClass("disabled").val(value);
                $(".wplmi-copied").show().delay(1000).fadeOut();
            } 
        });
    } );

    $( "input.wplmi-paste" ).on( 'click', function( e ) {
        e.preventDefault();
        var el = $(this);
        var mdc = $.confirm({
            title: wplmi_admin_L10n.paste_data,
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
                    text: wplmi_admin_L10n.import_btn,
                    action: function () {
                        var settings_data = this.$content.find('#wplmi-settings-data-import').val();
                        if ( ! settings_data ) {
                            alert( 'Please enter valid settings data!' );
                            return false;
                        }
                        console.log( settings_data );
                        mdc.close();
                        $.dialog({
                            title: wplmi_admin_L10n.importing,
                            content: wplmi_admin_L10n.processing,
                            useBootstrap: false,
                            draggable: false,
                            theme: 'material',
                            type: 'orange',
                            closeIcon: false,
                            boxWidth: '25%',
                            scrollToPreviousElement: false,
                        });
                        $.post( wplmi_admin_L10n.ajaxurl, { action: 'wplmi_process_import_plugin_data', settings_data: settings_data, security: wplmi_admin_L10n.security }, function( response, status ) {
                            if( response.success === true ) {
                                window.location.reload();
                                $.cookie('wplmi_active_tab', 'post', { expires: 30 });
                            } 
                        });
                    }    
                },
                close: {
                    text: wplmi_admin_L10n.close_btn,
                    action: function () {}
                } 
            }
        })
    } );

    // $("#wplmi_date_type").change(function() {
    //     if ($(this).val() == 'default') {
    //         $('.wplmi_el_date_format').show();
    //     } else if ($(this).val() == 'human_readable') {
    //         $('.wplmi_el_date_format').hide();
    //     }
    // }).change();

    // $("#wplmi_author_display").change(function() {
    //     if ($(this).val() == 'custom') {
    //         $('.wplmi_el_author_list').show();
    //     } else {
    //         $('.wplmi_el_author_list').hide();
    //     }
    // }).change();

    // $("#wplmi_template_date_type").change(function() {
    //     if ($(this).val() == 'default') {
    //         $('.wplmi_el_template_date_format').show();
    //     } else if ($(this).val() == 'human_readable') {
    //         $('.wplmi_el_template_date_format').hide();
    //     }
    // }).change();

    // $("#wplmi_template_author_display").change(function() {
    //     if ($(this).val() == 'custom') {
    //         $('.wplmi_el_template_author_list').show();
    //     } else {
    //         $('.wplmi_el_template_author_list').hide();
    //     }
    // }).change();

    // $("#wplmi_astra_support, #wplmi_generatepress_support").change(function() {
    //     if ($(this).val() == 'replace') {
    //         $('.wplmi_el_theme_template_type').show();
    //         $('a#post').hide();
    //         $('#wplmi_enable_plugin').prop('checked', false);
    //     } else if ($(this).val() == 'none') {
    //         $('.wplmi_el_theme_template_type').hide();
    //         $('a#post').show();
    //     }
    // }).change();

    $('#wplmi_post_types, #wplmi_schema_post_types, #wplmi_notification_post_types, #wplmi_archives').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        placeholder: $(this).data('placeholder'),
        persist: false,
        create: false
    });

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

    // $("#wplmi_enable_schema").change(function() {
    //     if ($(this).val() == 'enable') {
    //         $('.wplmi_el_schema_post_types').show();
    //         $('.wplmi_el_enhanced_schema, .schema-text').hide();
    //         $('#wplmi_enhanced_schema').prop('checked', false);
    //     } else if ($(this).val() == 'inline') {
    //         $('.wplmi_el_enhanced_schema').show();
    //         $('.wplmi_el_schema_post_types, .schema-text').hide();
    //     } else if ($(this).val() == 'comp_mode') {
    //         $('.wplmi_el_schema_post_types, .wplmi_el_enhanced_schema').hide();
    //         $('.schema-text').show();
    //     } else if ($(this).val() == 'disable') {
    //         $('.wplmi_el_schema_post_types, .wplmi_el_enhanced_schema, .schema-text').hide();
    //         $('#wplmi_enhanced_schema').prop('checked', false);
    //     }
    // }).change();

    $( "#wplmi_display_method" ).change( function() {
        if ($(this).val() == 'replace_original') {
            $('.wplmi_el_selectors, .wplmi_el_post_types').show();
            $('.wplmi_el_archives').hide();
        } else if ($(this).val() == 'manual') {
            $('.wplmi_el_selectors, .wplmi_el_post_types, .wplmi_el_archives').hide();
        } else if ($(this).val() == 'before_content' || $(this).val() == 'after_content') {
            $('.wplmi_el_selectors').hide();
            $('.wplmi_el_post_types, .wplmi_el_archives').show();
        }
    } ).trigger( 'change' );

    // $("#wplmi_replace_date").change(function() {
    //     if ($(this).val() == 'remove') {
    //         $('.remove-info-text').show();
    //     } else {
    //         $('.remove-info-text').hide();
    //     }
    // }).change();

    $(".coffee-amt").change(function() {
        var btn = $('.buy-coffee-btn');
        btn.attr('href', btn.data('link') + $(this).val());
    });

    $(window).keydown( function(e) {
        if (e.ctrlKey || e.metaKey) {
            switch (String.fromCharCode(e.which).toLowerCase()) {
                case 's':
                    e.preventDefault();
                    $('#wplmi-settings-form').submit();
                    break;
            }
        }
    });

});