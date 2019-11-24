jQuery(document).ready(function ($) {
    
    $("#btn1").click(function () {
        $("#show-post").fadeIn("slow");
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-schema").hide();
        $("#show-noti").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn2").click(function () {
        $("#show-post").hide();
        $("#show-page").fadeIn("slow");
        $("#show-tt").hide();
        $("#show-schema").hide();
        $("#show-noti").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn3").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").fadeIn("slow");
        $("#show-schema").hide();
        $("#show-noti").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn4").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-schema").fadeIn("slow");
        $("#show-noti").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn5").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-schema").hide();
        $("#show-noti").fadeIn("slow");
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn6").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-schema").hide();
        $("#show-noti").hide();
        $("#show-misc").fadeIn("slow");
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn7").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-schema").hide();
        $("#show-noti").hide();
        $("#show-misc").hide();
        $("#show-tools").fadeIn("slow");
        $("#show-help").hide();

    });

    $("#btn8").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-schema").hide();
        $("#show-noti").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").fadeIn("slow");

    });

    $("#post-enable").change(function() {
        if ($('#post-enable').is(':checked')) {
            $('#post-show-status').prop('disabled', false);
            $('#post-homepage').prop('disabled', false);
        }
        if (!$('#post-enable').is(':checked')) {
            $('#post-show-status').prop('disabled', true);
            $('#post-homepage').prop('disabled', true);
        }
    });
    $("#post-enable").trigger('change');

    $("#post-show-status").change(function() {
        if ($('#post-show-status').val() == 'manual') {
            $('.cpt').hide();
        }
        if ($('#post-show-status').val() != 'manual') {
            $('.cpt').show();
        }
    });
    $("#post-show-status").trigger('change');

    $("#page-enable").change(function() {
        if ($('#page-enable').is(':checked')) {
            $('#page-show-status').prop('disabled', false);
        }
        if (!$('#page-enable').is(':checked')) {
            $('#page-show-status').prop('disabled', true);
        }
    });
    $("#page-enable").trigger('change');

    $("#post-format").change(function() {
        if ($('#post-format').val() == 'human_readable') {
            $('#post-human-end-with').show();
            $('.post-default-format').hide();
            $('#post-ago-replace').prop('required',true);
            $('#custom-post-date-format').removeAttr('required');
            $('#custom-post-dtsep').removeAttr('required');
            $('#custom-post-time-format').removeAttr('required');
        }
        if ($('#post-format').val() != 'human_readable') {
            $('#post-human-end-with').hide();
            $('.post-default-format').show();
            $('#post-ago-replace').removeAttr('required');
            $("#post-default-format").change(function() {
                if ($('#post-default-format').val() == 'only_date') {
                    $('#post-dtcf').show();
                    $('#post-tmcf').hide();
                    $('#post-dtsep').hide();
                    $('#custom-post-date-format').prop('required',true);
                    $('#custom-post-dtsep').removeAttr('required');
                    $('#custom-post-time-format').removeAttr('required');
                }
                if ($('#post-default-format').val() == 'only_time') {
                    $('#post-dtcf').hide();
                    $('#post-tmcf').show();
                    $('#post-dtsep').hide();
                    $('#custom-post-date-format').removeAttr('required');
                    $('#custom-post-dtsep').removeAttr('required');
                    $('#custom-post-time-format').prop('required',true);
                }
                if ($('#post-default-format').val() == 'show_both') {
                    $('#post-dtcf').show();
                    $('#post-tmcf').show();
                    $('#post-dtsep').show();
                    $('#custom-post-date-format').prop('required',true);
                    $('#custom-post-dtsep').prop('required',true);
                    $('#custom-post-time-format').prop('required',true);
                }
            });
            $("#post-default-format").trigger('change');
        }
    });
    $("#post-format").trigger('change');

    $("#post-sa").change(function() {
        if ($('#post-sa').val() == 'custom') {
            $('#post-custom-author').show();
        }
        if ($('#post-sa').val() != 'custom') {
            $('#post-custom-author').hide();
        }
        if ($('#post-sa').val() == 'do_not_show') {
            $('#post-author-link').hide();
            $('#post-custom-author-sep').hide();
            $('#post-author-link-target').hide();
            $('#custom-post-author-sep').removeAttr('required');
        }
        if ($('#post-sa').val() != 'do_not_show') {
            $('#post-author-link').show();
            $('#post-custom-author-sep').show();
            $('#post-author-link-target').show();
            $('#custom-post-author-sep').prop('required',true);
        }
    });
    $("#post-sa").trigger('change');

    $("#post-authorlink").change(function() {
        if ($('#post-authorlink').val() == 'none') {
            $('#post-authorlinktarget').prop('disabled', true);
        } else if ($('#post-authorlink').val() == 'author_email') {
            $('#post-authorlinktarget').prop('disabled', true);
        } else {
            $('#post-authorlinktarget').prop('disabled', false);
        }
    });
    $("#post-authorlink").trigger('change');

    $("#page-format").change(function() {
        if ($('#page-format').val() == 'human_readable') {
            $('#page-human-end-with').show();
            $('.page-default-format').hide();
            $('#page-ago-replace').prop('required',true);
            $('#custom-page-date-format').removeAttr('required');
            $('#custom-page-dtsep').removeAttr('required');
            $('#custom-page-time-format').removeAttr('required');
        }
        if ($('#page-format').val() != 'human_readable') {
            $('#page-human-end-with').hide();
            $('.page-default-format').show();
            $('#page-ago-replace').removeAttr('required');
            $("#page-default-format").change(function() {
                if ($('#page-default-format').val() == 'only_date') {
                    $('#page-dtcf').show();
                    $('#page-tmcf').hide();
                    $('#page-dtsep').hide();
                    $('#custom-page-date-format').prop('required',true);
                    $('#custom-page-dtsep').removeAttr('required');
                    $('#custom-page-time-format').removeAttr('required');
                }
                if ($('#page-default-format').val() == 'only_time') {
                    $('#page-dtcf').hide();
                    $('#page-tmcf').show();
                    $('#page-dtsep').hide();
                    $('#custom-page-date-format').removeAttr('required');
                    $('#custom-page-dtsep').removeAttr('required');
                    $('#custom-page-time-format').prop('required',true);
                }
                if ($('#page-default-format').val() == 'show_both') {
                    $('#page-dtcf').show();
                    $('#page-tmcf').show();
                    $('#page-dtsep').show();
                    $('#custom-page-date-format').prop('required',true);
                    $('#custom-page-dtsep').prop('required',true);
                    $('#custom-page-time-format').prop('required',true);
                }
            });
            $("#page-default-format").trigger('change');
        }
    });
    $("#page-format").trigger('change');

    $("#page-sa").change(function() {
        if ($('#page-sa').val() == 'custom') {
            $('#page-custom-author').show();
        }
        if ($('#page-sa').val() != 'custom') {
            $('#page-custom-author').hide();
        }
        if ($('#page-sa').val() == 'do_not_show') {
            $('#page-author-link').hide();
            $('#page-custom-author-sep').hide();
            $('#page-author-link-target').hide();
            $('#custom-page-author-sep').removeAttr('required');
        }
        if ($('#page-sa').val() != 'do_not_show') {
            $('#page-author-link').show();
            $('#page-custom-author-sep').show();
            $('#page-author-link-target').show();
            $('#custom-page-author-sep').prop('required',true);
        }
    });
    $("#page-sa").trigger('change');

    $("#page-authorlink").change(function() {
        if ($('#page-authorlink').val() == 'none') {
            $('#page-authorlinktarget').prop('disabled', true);
        } else if ($('#page-authorlink').val() == 'author_email') {
            $('#page-authorlinktarget').prop('disabled', true);
        } else {
            $('#page-authorlinktarget').prop('disabled', false);
        }
    });
    $("#page-authorlink").trigger('change');

    $("#tt-format").change(function() {
        if ($('#tt-format').val() == 'human_readable') {
            $('#tt-human-end-with').show();
            $('#tt-format-output').hide();
            $('#tt-ago-replace').prop('required',true);
            $('#lmt-tt-format').removeAttr('required');
        }
        if ($('#tt-format').val() != 'human_readable') {
            $('#tt-human-end-with').hide();
            $('#tt-format-output').show();
            $('#tt-ago-replace').removeAttr('required');
            $('#lmt-tt-format').prop('required',true);
        }
    });
    $("#tt-format").trigger('change');

    $("#lmt-tt-sa").change(function() {
        if ($('#lmt-tt-sa').val() == 'custom') {
            $('#tt-custom-author').show();
        }
        if ($('#lmt-tt-sa').val() != 'custom') {
            $('#tt-custom-author').hide();
        }
        if ($('#lmt-tt-sa').val() == 'do_not_show') {
            $('#tt-author-link').hide();
            $('#tt-custom-author-sep').hide();
            $('#tt-author-link-target').hide();
            $('#custom-tt-author-sep').removeAttr('required');
        }
        if ($('#lmt-tt-sa').val() != 'do_not_show') {
            $('#tt-author-link').show();
            $('#tt-custom-author-sep').show();
            $('#tt-author-link-target').show();
            $('#custom-tt-author-sep').prop('required',true);
        }
    });
    $("#lmt-tt-sa").trigger('change');

    $("#lmt-tt-authorlink").change(function() {
        if ($('#lmt-tt-authorlink').val() == 'none') {
            $('#tt-authorlinktarget').prop('disabled', true);
        } else if ($('#lmt-tt-authorlink').val() == 'author_email') {
            $('#tt-authorlinktarget').prop('disabled', true);
        } else {
            $('#tt-authorlinktarget').prop('disabled', false);
        }
    });
    $("#lmt-tt-authorlink").trigger('change');

    $("#schema-jsonld").change(function() {
        if ($('#schema-jsonld').val() == 'enable') {
            $('.schema-jsonld-pt').show();
            $('.post-enable-schema').hide();
            $('.page-enable-schema').hide();
            $('.tt-enable-schema').hide();
            $('.schema-support').hide();
            $('.schema-text').hide();
            $('#post-enable-schema').prop('checked', false);
            $('#page-enable-schema').prop('checked', false);
            $('#enable-schema-tt').prop('checked', false);
        }
        if ($('#schema-jsonld').val() == 'inline') {
            $('.post-enable-schema').show();
            $('.page-enable-schema').show();
            $('.tt-enable-schema').show();
            $('.schema-support').show();
            $('.schema-jsonld-pt').hide();
            $('.schema-text').hide();
            $('#post-enable-schema').prop('checked', true);
            $('#page-enable-schema').prop('checked', true);
            $('#enable-schema-tt').prop('checked', true);
        }
        if ($('#schema-jsonld').val() == 'comp_mode') {
            $('.schema-text').show();
            $('.post-enable-schema').hide();
            $('.page-enable-schema').hide();
            $('.tt-enable-schema').hide();
            $('.schema-support').hide();
            $('.schema-jsonld-pt').hide();
            $('#post-enable-schema').prop('checked', false);
            $('#page-enable-schema').prop('checked', false);
            $('#enable-schema-tt').prop('checked', false);
        }
        if ($('#schema-jsonld').val() == 'disable') {
            $('.schema-jsonld-pt').hide();
            $('.post-enable-schema').hide();
            $('.page-enable-schema').hide();
            $('.tt-enable-schema').hide();
            $('.schema-support').hide();
            $('.schema-text').hide();
            $('#post-enable-schema').prop('checked', false);
            $('#page-enable-schema').prop('checked', false);
            $('#enable-schema-tt').prop('checked', false);
        }
    });
    $("#schema-jsonld").trigger('change');

    $('select#cpt').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        placeholder: 'Select custom post types',
        persist: false,
        create: false
    });
    
    $('select#schema-jsonld-pt').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        placeholder: 'Select post types',
        persist: false,
        create: false
    });

    $('input#noti-email-receive').selectize({
        plugins: ['remove_button', 'restore_on_backspace'],
        persist: false,
        create: true,
        createOnBlur: true,
        delimiter: ',',
    });

    $('select#noti-pt').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        placeholder: 'Select post types',
        persist: false,
        create: false
    });

    $(".coffee-amt").change(function() {
        var btn = $('.buy-coffee-btn');
        btn.attr('href', btn.data('link') + $(this).val());
    });
    $(".coffee-amt").trigger('change');

    if ( location.href.match(/page\=wp-last-modified-info#post/ig) ) {

        $("#show-page").hide();
        $("#show-dashboard").hide();
        $("#show-tt").hide();
        $("#show-schema").hide();
        $("#show-noti").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if ( location.href.match(/page\=wp-last-modified-info#page/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn2").addClass("active");
        $("#show-post").hide();
        $("#show-page").show();
        $("#show-tt").hide();
        $("#show-schema").hide();
        $("#show-noti").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if( location.href.match(/page\=wp-last-modified-info#template-tags/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn3").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").show();
        $("#show-schema").hide();
        $("#show-noti").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if( location.href.match(/page\=wp-last-modified-info#schema/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn4").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-schema").show();
        $("#show-noti").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if( location.href.match(/page\=wp-last-modified-info#notification/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn5").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-schema").hide();
        $("#show-noti").show();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if( location.href.match(/page\=wp-last-modified-info#misc/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn6").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-schema").hide();
        $("#show-noti").hide();
        $("#show-misc").show();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if( location.href.match(/page\=wp-last-modified-info#tools/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn7").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-schema").hide();
        $("#show-noti").hide();
        $("#show-misc").hide();
        $("#show-tools").show();
        $("#show-help").hide();

    } else if( location.href.match(/page\=wp-last-modified-info#help/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn8").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-schema").hide();
        $("#show-noti").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").show();
        
    }

});