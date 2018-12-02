jQuery(document).ready(function ($) {
    
    $("#btn1").click(function () {
        $("#show-post").fadeIn("slow");
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn2").click(function () {
        $("#show-post").hide();
        $("#show-page").fadeIn("slow");
        $("#show-tt").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn3").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").fadeIn("slow");
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn4").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-misc").fadeIn("slow");
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn5").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-misc").hide();
        $("#show-tools").fadeIn("slow");
        $("#show-help").hide();

    });

    $("#btn6").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").fadeIn("slow");

    });

    $("#post-show-status").change(function() {
        if ($('#post-show-status').val() == 'manual') {
            $('#show-shortcode').show();
        }
        if ($('#post-show-status').val() != 'manual') {
            $('#show-shortcode').hide();
        }
    });
    $("#post-show-status").trigger('change');

    $("#post-format").change(function() {
        if ($('#post-format').val() == 'human_readable') {
            $('#post-human-end-with').show();
            $('.post-default-format').hide();
        }
        if ($('#post-format').val() != 'human_readable') {
            $('#post-human-end-with').hide();
            $('.post-default-format').show();
        }
    });
    $("#post-format").trigger('change');

    $("#post-default-format").change(function() {
        if ($('#post-default-format').val() == 'only_date') {
            $('#post-dtcf').show();
            $('#post-tmcf').hide();
            $('#post-dtsep').hide();
        }
        if ($('#post-default-format').val() == 'only_time') {
            $('#post-dtcf').hide();
            $('#post-tmcf').show();
            $('#post-dtsep').hide();
        }
        if ($('#post-default-format').val() == 'show_both') {
            $('#post-dtcf').show();
            $('#post-tmcf').show();
            $('#post-dtsep').show();
        }
    });
    $("#post-default-format").trigger('change');

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
        }
        if ($('#post-sa').val() != 'do_not_show') {
            $('#post-author-link').show();
            $('#post-custom-author-sep').show();
        }
    });
    $("#post-sa").trigger('change');

    $("#page-show-status").change(function() {
        if ($('#page-show-status').val() == 'manual') {
            $('#show-shortcode-page').show();
        }
        if ($('#page-show-status').val() != 'manual') {
            $('#show-shortcode-page').hide();
        }
    });
    $("#page-show-status").trigger('change');

    $("#page-format").change(function() {
        if ($('#page-format').val() == 'human_readable') {
            $('#page-human-end-with').show();
            $('.page-default-format').hide();
        }
        if ($('#page-format').val() != 'human_readable') {
            $('#page-human-end-with').hide();
            $('.page-default-format').show();
        }
    });
    $("#page-format").trigger('change');

    $("#page-default-format").change(function() {
        if ($('#page-default-format').val() == 'only_date') {
            $('#page-dtcf').show();
            $('#page-tmcf').hide();
            $('#page-dtsep').hide();
        }
        if ($('#page-default-format').val() == 'only_time') {
            $('#page-dtcf').hide();
            $('#page-tmcf').show();
            $('#page-dtsep').hide();
        }
        if ($('#page-default-format').val() == 'show_both') {
            $('#page-dtcf').show();
            $('#page-tmcf').show();
            $('#page-dtsep').show();
        }
    });
    $("#page-default-format").trigger('change');

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
        }
        if ($('#page-sa').val() != 'do_not_show') {
            $('#page-author-link').show();
            $('#page-custom-author-sep').show();
        }
    });
    $("#page-sa").trigger('change');

    $("#tt-format").change(function() {
        if ($('#tt-format').val() == 'human_readable') {
            $('#tt-human-end-with').show();
            $('#tt-format-output').hide();
        }
        if ($('#tt-format').val() != 'human_readable') {
            $('#tt-human-end-with').hide();
            $('#tt-format-output').show();
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
        }
        if ($('#lmt-tt-sa').val() != 'do_not_show') {
            $('#tt-author-link').show();
            $('#tt-custom-author-sep').show();
        }
    });
    $("#lmt-tt-sa").trigger('change');

    $('select').select2({
        placeholder: '-- Select --',
        minimumResultsForSearch: Infinity
    });

    $('select#cpt').select2({
        placeholder: 'Select custom post types',
        allowClear: true
    });

    if ( location.href.match(/page\=wp-last-modified-info#post/ig) ) {

        $("#show-page").hide();
        $("#show-dashboard").hide();
        $("#show-tt").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if ( location.href.match(/page\=wp-last-modified-info#page/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn2").addClass("active");
        $("#show-post").hide();
        $("#show-page").show();
        $("#show-tt").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if( location.href.match(/page\=wp-last-modified-info#template-tags/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn3").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").show();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if( location.href.match(/page\=wp-last-modified-info#misc/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn4").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-misc").show();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if( location.href.match(/page\=wp-last-modified-info#tools/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn5").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-misc").hide();
        $("#show-tools").show();
        $("#show-help").hide();

    } else if( location.href.match(/page\=wp-last-modified-info#help/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn6").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-tt").hide();
        $("#show-misc").hide();
        $("#show-tools").hide();
        $("#show-help").show();
        
    }

});