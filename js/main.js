jQuery(document).ready(function ($) {
    
    $("#btn1").click(function () {
        $("#show-post").fadeIn("slow");
        $("#show-page").hide();
        $("#show-dashboard").hide();
        $("#show-tt").hide();
        $("#show-style-area").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn2").click(function () {
        $("#show-post").hide();
        $("#show-page").fadeIn("slow");
        $("#show-dashboard").hide();
        $("#show-tt").hide();
        $("#show-style-area").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn3").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-dashboard").fadeIn("slow");
        $("#show-tt").hide();
        $("#show-style-area").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn4").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-dashboard").hide();
        $("#show-tt").fadeIn("slow");
        $("#show-style-area").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn5").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-dashboard").hide();
        $("#show-tt").hide();
        $("#show-style-area").fadeIn("slow");
        $("#show-tools").hide();
        $("#show-help").hide();

    });

    $("#btn6").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-dashboard").hide();
        $("#show-tt").hide();
        $("#show-style-area").hide();
        $("#show-tools").fadeIn("slow");
        $("#show-help").hide();

    });

    $("#btn7").click(function () {
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-dashboard").hide();
        $("#show-tt").hide();
        $("#show-style-area").hide();
        $("#show-tools").hide();
        $("#show-help").fadeIn("slow");

    });

    $("#post-enable").change(function () {
        if ($('#post-enable').is(':checked')) {
            $('#post-sc').prop('disabled', false);
            $('#cpt').prop('disabled', false);
            $('#post-human').prop('disabled', false);
            $('#post-revised').prop('disabled', false);
            $('#post-enable-time').prop('disabled', false);
            $('#custom-post-time-format').prop('disabled', false);
            $('#post-enable-date').prop('disabled', false);
            $('#post-dt-sep').prop('disabled', false);
            $('#custom-post-date-format').prop('disabled', false);
            $('#post-show-status').prop('disabled', false);
            $('#post-custom-text').prop('disabled', false);
            $('#post-sa').prop('disabled', false);
            $('#post-disable-auto-insert').prop('disabled', false);
        }
        if (!$('#post-enable').is(':checked')) {
            $('#post-sc').prop('disabled', true);
            $('#cpt').prop('disabled', true);
            $('#post-human').prop('disabled', true);
            $('#post-revised').prop('disabled', true);
            $('#post-enable-time').prop('disabled', true);
            $('#custom-post-time-format').prop('disabled', true);
            $('#post-enable-date').prop('disabled', true);
            $('#post-dt-sep').prop('disabled', true);
            $('#custom-post-date-format').prop('disabled', true);
            $('#post-show-status').prop('disabled', true);
            $('#post-custom-text').prop('disabled', true);
            $('#post-sa').prop('disabled', true);
            $('#post-disable-auto-insert').prop('disabled', true);
        }
    });
    $("#post-enable").trigger('change');


    $("#page-enable").change(function () {
        if ($('#page-enable').is(':checked')) {
            $('#page-sc').prop('disabled', false);
            $('#page-human').prop('disabled', false);
            $('#page-revised').prop('disabled', false);
            $('#page-enable-time').prop('disabled', false);
            $('#custom-page-time-format').prop('disabled', false);
            $('#page-enable-date').prop('disabled', false);
            $('#page-dt-sep').prop('disabled', false);
            $('#custom-page-date-format').prop('disabled', false);
            $('#page-show-status').prop('disabled', false);
            $('#page-custom-text').prop('disabled', false);
            $('#page-sa').prop('disabled', false);
            $('#page-disable-auto-insert').prop('disabled', false);
        }
        if (!$('#page-enable').is(':checked')) {
            $('#page-sc').prop('disabled', true);
            $('#page-human').prop('disabled', true);
            $('#page-revised').prop('disabled', true);
            $('#page-enable-time').prop('disabled', true);
            $('#custom-page-time-format').prop('disabled', true);
            $('#page-enable-date').prop('disabled', true);
            $('#custom-page-date-format').prop('disabled', true);
            $('#page-dt-sep').prop('disabled', true);
            $('#page-show-status').prop('disabled', true);
            $('#page-custom-text').prop('disabled', true);
            $('#page-sa').prop('disabled', true);
            $('#page-disable-auto-insert').prop('disabled', true);
        }
    });
    $("#page-enable").trigger('change');

    $("#lmt-tt").change(function () {
        if ($('#lmt-tt').is(':checked')) {
            $('#lmt-tt-human').prop('disabled', false);
            $('#lmt-tt-format').prop('disabled', false);
            $('#lmt-tt-updated-text').prop('disabled', false);
            $('#lmt-tt-sa').prop('disabled', false);
            $('#lmt-tt-class').prop('disabled', false);
        }
        if (!$('#lmt-tt').is(':checked')) {
            $('#lmt-tt-human').prop('disabled', true);
            $('#lmt-tt-format').prop('disabled', true);
            $('#lmt-tt-updated-text').prop('disabled', true);
            $('#lmt-tt-sa').prop('disabled', true);
            $('#lmt-tt-class').prop('disabled', true);
        }
    });
    $("#lmt-tt").trigger('change');

    $('select#cpt').select2({
        placeholder: 'Select custom post types',
        allowClear: true
    });

    $('select#post-sa').select2({
        placeholder: '-- Select --',
        minimumResultsForSearch: Infinity
    });

    $('select#post-show-status').select2({
        placeholder: '-- Select --',
        minimumResultsForSearch: Infinity
    });

    $('select#page-sa').select2({
        placeholder: '-- Select --',
        minimumResultsForSearch: Infinity
    });

    $('select#page-show-status').select2({
        placeholder: '-- Select --',
        minimumResultsForSearch: Infinity
    });

    $('select#lmt-tt-sa').select2({
        placeholder: '-- Select --',
        minimumResultsForSearch: Infinity
    });

    $("#post-show-status").change(function() {
        if ($('#post-show-status').val() == 'Using Shortcode') {
            jQuery('#show-shortcode').show();
        }
        if ($('#post-show-status').val() != 'Using Shortcode') {
            jQuery('#show-shortcode').hide();
        }
    });
    $("#post-show-status").trigger('change');

    $("#page-show-status").change(function() {
        if ($('#page-show-status').val() == 'Using Shortcode') {
            jQuery('#show-shortcode-page').show();
        }
        if ($('#page-show-status').val() != 'Using Shortcode') {
            jQuery('#show-shortcode-page').hide();
        }
    });
    $("#page-show-status").trigger('change');


    if ( location.href.match(/page\=wp-last-modified-info#post/ig) ) {

        $("#show-page").hide();
        $("#show-dashboard").hide();
        $("#show-tt").hide();
        $("#show-style-area").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if ( location.href.match(/page\=wp-last-modified-info#page/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn2").addClass("active");
        $("#show-post").hide();
        $("#show-page").show();
        $("#show-dashboard").hide();
        $("#show-tt").hide();
        $("#show-style-area").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if ( location.href.match(/page\=wp-last-modified-info#dashboard/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn3").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-dashboard").show();
        $("#show-tt").hide();
        $("#show-style-area").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if( location.href.match(/page\=wp-last-modified-info#template-tags/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn4").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-dashboard").hide();
        $("#show-tt").show();
        $("#show-style-area").hide();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if( location.href.match(/page\=wp-last-modified-info#style/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn5").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-dashboard").hide();
        $("#show-tt").hide();
        $("#show-style-area").show();
        $("#show-tools").hide();
        $("#show-help").hide();

    } else if( location.href.match(/page\=wp-last-modified-info#tools/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn6").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-dashboard").hide();
        $("#show-tt").hide();
        $("#show-style-area").hide();
        $("#show-tools").show();
        $("#show-help").hide();

    } else if( location.href.match(/page\=wp-last-modified-info#help/ig) ) {

        $("#btn1").removeClass("active");
        $("#btn7").addClass("active");
        $("#show-post").hide();
        $("#show-page").hide();
        $("#show-dashboard").hide();
        $("#show-tt").hide();
        $("#show-style-area").hide();
        $("#show-tools").hide();
        $("#show-help").show();
        
    }

});