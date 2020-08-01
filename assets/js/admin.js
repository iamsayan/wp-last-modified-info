jQuery(document).ready(function ($) {

    if ( typeof wplmi_admin_L10n === 'undefined' ) {
        return false;
    }

    var wplmi_editor = wp.codeEditor.initialize($('#wplmi_display_info'), wplmi_admin_L10n.html_editor);
    var wplmi_css_editor = wp.codeEditor.initialize($('#wplmi_custom_css'), wplmi_admin_L10n.css_editor);
    var wplmi_tag_editor = wp.codeEditor.initialize($('#wplmi_template_display_info'), wplmi_admin_L10n.html_editor);
    
    var btns = $("#nav-container").find("a.nav-tab");
    for (var i = 0; i < btns.length; i++) {
        $(btns[i]).click(function (e) {
            e.preventDefault();
            $("a.active").removeClass("active");
            $(this).addClass("active");
            $("#wplmi-form-area #wplmi-" + $(this).attr('id')).show();
            $("#wplmi-form-area .wplmi-metabox:not(#wplmi-" + $(this).attr('id') + ")").hide();
            $.cookie('wplmi_active_tab', $(this).attr('id'), { expires: 30 });
            if( $(this).attr('id') == 'post' ) {
                wplmi_editor.codemirror.refresh();
            }
            if( $(this).attr('id') == 'misc' ) {
                wplmi_css_editor.codemirror.refresh();
            }
            if( $(this).attr('id') == 'template' ) {
                wplmi_tag_editor.codemirror.refresh();
            }
        });
    }

    if ( typeof $.cookie('wplmi_active_tab') !== 'undefined' ) {
        $("#nav-container").find("a#" + $.cookie('wplmi_active_tab')).trigger('click');
    }

    var editors = [ wplmi_editor, wplmi_css_editor, wplmi_tag_editor ];
    editors.forEach(function (item, index, arr) { 
        $(item.codemirror.getWrapperElement()).resizable({
            handles: 's',
            resize: function() {
                var $this = $(this);
                item.codemirror.setSize( $this.width(), $this.height() );
            }
        });

        item.codemirror.on( 'change', function(editor) {
            editor.save();
        });
    });

    $('#form-container').submit(function(e) {
        e.preventDefault();
        $(".save-settings").addClass("disabled").val(wplmi_admin_L10n.saving);
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
                $(".save-settings").removeClass("disabled").val(wplmi_admin_L10n.save_button);
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

    $("input.wplmi-reset").on('click',(function(e) {
        e.preventDefault();
        var el = $(this);
        var action = el.data('action');
        var notice = el.data('notice');
        var success = el.data('success');
        var type = el.data('type');
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
                            title: wplmi_admin_L10n.deleting,
                            content: wplmi_admin_L10n.process_delete,
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
    }));

    $('#wplmi-form .wplmi_row_custom_css').find('.CodeMirror').on('mousedown.codemirror', function() {
        var $this = $(this);
		$this.addClass( 'large' );
		wplmi_css_editor.codemirror.refresh();
        $this.off( 'mousedown.codemirror' );
    });
    
    $('#wplmi_enable_plugin').on('change', function() {
		var is_enabled = $(this).prop( 'checked' );
		wplmi_editor.codemirror.setOption( 'readOnly', ! is_enabled );
        $( '#wplmi-form .wplmi_row_display_info' ).find( '.CodeMirror' ).toggleClass( 'disabled', ! is_enabled );
	}).change();

    $("#wplmi_date_type").change(function() {
        if ($(this).val() == 'default') {
            $('.wplmi_row_date_format').show();
        } else if ($(this).val() == 'human_readable') {
            $('.wplmi_row_date_format').hide();
        }
    }).change();

    $("#wplmi_author_display").change(function() {
        if ($(this).val() == 'custom') {
            $('.wplmi_row_author_list').show();
        } else {
            $('.wplmi_row_author_list').hide();
        }
    }).change();

    $("#wplmi_template_date_type").change(function() {
        if ($(this).val() == 'default') {
            $('.wplmi_row_template_date_format').show();
        } else if ($(this).val() == 'human_readable') {
            $('.wplmi_row_template_date_format').hide();
        }
    }).change();

    $("#wplmi_template_author_display").change(function() {
        if ($(this).val() == 'custom') {
            $('.wplmi_row_template_author_list').show();
        } else {
            $('.wplmi_row_template_author_list').hide();
        }
    }).change();

    $("#wplmi_astra_support, #wplmi_generatepress_support").change(function() {
        if ($(this).val() == 'replace') {
            $('.wplmi_row_theme_template_type').show();
            $('a#post').hide();
            $('#wplmi_enable_plugin').prop('checked', false);
        } else if ($(this).val() == 'none') {
            $('.wplmi_row_theme_template_type').hide();
            $('a#post').show();
        }
    }).change();

    $('#wplmi_theme_template_type').on('change', function() {
        var is_enabled;
        if ($(this).val() == 'default') {
            is_enabled = true;
        } else if ($(this).val() == 'custom') {
            is_enabled = false;
        }
		wplmi_tag_editor.codemirror.setOption( 'readOnly', is_enabled );
        $( '#wplmi-form .wplmi_row_template_display_info' ).find( '.CodeMirror' ).toggleClass( 'disabled', is_enabled );
	}).change();

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

    $("#wplmi_enable_schema").change(function() {
        if ($(this).val() == 'enable') {
            $('.wplmi_row_schema_post_types').show();
            $('.wplmi_row_enhanced_schema, .schema-text').hide();
            $('#wplmi_enhanced_schema').prop('checked', false);
        } else if ($(this).val() == 'inline') {
            $('.wplmi_row_enhanced_schema').show();
            $('.wplmi_row_schema_post_types, .schema-text').hide();
        } else if ($(this).val() == 'comp_mode') {
            $('.wplmi_row_schema_post_types, .wplmi_row_enhanced_schema').hide();
            $('.schema-text').show();
        } else if ($(this).val() == 'disable') {
            $('.wplmi_row_schema_post_types, .wplmi_row_enhanced_schema, .schema-text').hide();
            $('#wplmi_enhanced_schema').prop('checked', false);
        }
    }).change();

    $("#wplmi_display_method").change(function() {
        if ($(this).val() == 'replace_original') {
            $('.wplmi_row_selectors, .wplmi_row_post_types').show();
            $('.wplmi_row_archives').hide();
        } else if ($(this).val() == 'manual') {
            $('.wplmi_row_selectors, .wplmi_row_post_types, .wplmi_row_archives').hide();
        } else if ($(this).val() == 'before_content' || $(this).val() == 'after_content') {
            $('.wplmi_row_selectors').hide();
            $('.wplmi_row_post_types, .wplmi_row_archives').show();
        }
    }).change();

    $(".coffee-amt").change(function() {
        var btn = $('.buy-coffee-btn');
        btn.attr('href', btn.data('link') + $(this).val());
    });

    $(window).keydown( function(e) {
        if (e.ctrlKey || e.metaKey) {
            switch (String.fromCharCode(e.which).toLowerCase()) {
                case 's':
                    e.preventDefault();
                    $('#form-container').submit();
                    break;
            }
        }
    });

});