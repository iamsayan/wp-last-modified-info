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

    $("#post-enable").change(function () {
        if ($('#post-enable').is(':checked')) {
            $('#post-human').prop('disabled', false);
            $('#post-enable-time').prop('disabled', false);
            $('#custom-post-time-format').prop('disabled', false);
            $('#post-enable-date').prop('disabled', false);
            $('#custom-post-date-format').prop('disabled', false);
            $('#post-dt-sep').prop('disabled', false);
            $('#post-show-status').prop('disabled', false);
            $('#post-custom-text').prop('disabled', false);
            $('#post-sa').prop('disabled', false);
            $('#custom-post-author').prop('disabled', false);
            $('#post-authorlink').prop('disabled', false);
            $('#cpt').prop('disabled', false);
        }
        if (!$('#post-enable').is(':checked')) {
            $('#post-human').prop('disabled', true);
            $('#post-enable-time').prop('disabled', true);
            $('#custom-post-time-format').prop('disabled', true);
            $('#post-enable-date').prop('disabled', true);
            $('#custom-post-date-format').prop('disabled', true);
            $('#post-dt-sep').prop('disabled', true);
            $('#post-show-status').prop('disabled', true);
            $('#post-custom-text').prop('disabled', true);
            $('#post-sa').prop('disabled', true);
            $('#custom-post-author').prop('disabled', true);
            $('#post-authorlink').prop('disabled', true);
            $('#cpt').prop('disabled', true);
        }
    });
    $("#post-enable").trigger('change');

    $("#post-human").change(function () {
        if ($('#post-human').is(':checked')) {
            $('.post-time').hide();
            $('.post-date').hide();
            $('.post-sep').hide();
        }
        if (!$('#post-human').is(':checked')) {
            $('.post-time').show();
            $('.post-date').show();
            $('.post-sep').show();
        }
    });
    $("#post-human").trigger('change');

    $("#page-enable").change(function () {
        if ($('#page-enable').is(':checked')) {
            $('#page-human').prop('disabled', false);
            $('#page-enable-time').prop('disabled', false);
            $('#custom-page-time-format').prop('disabled', false);
            $('#page-enable-date').prop('disabled', false);
            $('#custom-page-date-format').prop('disabled', false);
            $('#page-dt-sep').prop('disabled', false);
            $('#page-show-status').prop('disabled', false);
            $('#page-custom-text').prop('disabled', false);
            $('#page-sa').prop('disabled', false);
            $('#custom-page-author').prop('disabled', false);
            $('#page-authorlink').prop('disabled', false);
        }
        if (!$('#page-enable').is(':checked')) {
            $('#page-human').prop('disabled', true);
            $('#page-enable-time').prop('disabled', true);
            $('#custom-page-time-format').prop('disabled', true);
            $('#page-enable-date').prop('disabled', true);
            $('#custom-page-date-format').prop('disabled', true);
            $('#page-dt-sep').prop('disabled', true);
            $('#page-show-status').prop('disabled', true);
            $('#page-custom-text').prop('disabled', true);
            $('#page-sa').prop('disabled', true);
            $('#custom-page-author').prop('disabled', true);
            $('#page-authorlink').prop('disabled', true);
        }
    });
    $("#page-enable").trigger('change');

    $("#page-human").change(function () {
        if ($('#page-human').is(':checked')) {
            $('.page-time').hide();
            $('.page-date').hide();
            $('.page-sep').hide();
        }
        if (!$('#page-human').is(':checked')) {
            $('.page-time').show();
            $('.page-date').show();
            $('.page-sep').show();
        }
    });
    $("#page-human").trigger('change');

    $("#lmt-tt").change(function () {
        if ($('#lmt-tt').is(':checked')) {
            $('#lmt-tt-human').prop('disabled', false);
            $('#lmt-tt-format').prop('disabled', false);
            $('#lmt-tt-updated-text').prop('disabled', false);
            $('#lmt-tt-sa').prop('disabled', false);
            $('#lmt-custom-tt-author').prop('disabled', false);
            $('#lmt-tt-authorlink').prop('disabled', false);
            $('#lmt-tt-class').prop('disabled', false);
        }
        if (!$('#lmt-tt').is(':checked')) {
            $('#lmt-tt-human').prop('disabled', true);
            $('#lmt-tt-format').prop('disabled', true);
            $('#lmt-tt-updated-text').prop('disabled', true);
            $('#lmt-tt-sa').prop('disabled', true);
            $('#lmt-custom-tt-author').prop('disabled', true);
            $('#lmt-tt-authorlink').prop('disabled', true);
            $('#lmt-tt-class').prop('disabled', true);
        }
    });
    $("#lmt-tt").trigger('change');

    $("#lmt-tt-human").change(function () {
        if ($('#lmt-tt-human').is(':checked')) {
            $('.lmt-tt-format').hide();
        }
        if (!$('#lmt-tt-human').is(':checked')) {
            $('.lmt-tt-format').show();
        }
    });
    $("#lmt-tt-human").trigger('change');

    $('select#cpt').select2({
        placeholder: 'Select custom post types',
        allowClear: true
    });

    $('select#disable-update').select2({
        placeholder: 'Select user roles',
        allowClear: true
    });

    $('select#post-show-status').select2({
        placeholder: '-- Select --',
        minimumResultsForSearch: Infinity
    });

    $('select#post-sa').select2({
        placeholder: '-- Select --',
        minimumResultsForSearch: Infinity
    });

    $('select#custom-post-author').select2({
        placeholder: '-- Select --',
        minimumResultsForSearch: Infinity
    });

    $('select#page-sa').select2({
        placeholder: '-- Select --',
        minimumResultsForSearch: Infinity
    });

    $('select#custom-page-author').select2({
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

    $('select#lmt-custom-tt-author').select2({
        placeholder: '-- Select --',
        minimumResultsForSearch: Infinity
    });

    $('select#lmt-time-diff').select2({
        placeholder: '-- Select --',
        minimumResultsForSearch: Infinity
    });

    $("#post-show-status").change(function() {
        if ($('#post-show-status').val() == 'Manual') {
            $('#show-shortcode').show();
        }
        if ($('#post-show-status').val() != 'Manual') {
            $('#show-shortcode').hide();
        }
    });
    $("#post-show-status").trigger('change');

    $("#page-show-status").change(function() {
        if ($('#page-show-status').val() == 'Manual') {
            $('#show-shortcode-page').show();
        }
        if ($('#page-show-status').val() != 'Manual') {
            $('#show-shortcode-page').hide();
        }
    });
    $("#page-show-status").trigger('change');

    $("#post-sa").change(function() {
        if ($('#post-sa').val() == 'Custom') {
            $('#post-custom-author').show();
            $('#custom-post-author').attr('required', 'required');
        }
        if ($('#post-sa').val() != 'Custom') {
            $('#post-custom-author').hide();
            $('#custom-post-author').removeAttr("required");
        }
        if ($('#post-sa').val() == 'Do not show') {
            $('#post-author-link').hide();
        }
        if ($('#post-sa').val() != 'Do not show') {
            $('#post-author-link').show();
        }
    });
    $("#post-sa").trigger('change');

    $("#page-sa").change(function() {
        if ($('#page-sa').val() == 'Custom') {
            $('#page-custom-author').show();
            $('#custom-page-author').attr('required', 'required');
        }
        if ($('#page-sa').val() != 'Custom') {
            $('#page-custom-author').hide();
            $('#custom-page-author').removeAttr("required");
        }
        if ($('#page-sa').val() == 'Do not show') {
            $('#page-author-link').hide();
        }
        if ($('#page-sa').val() != 'Do not show') {
            $('#page-author-link').show();
        }
    });
    $("#page-sa").trigger('change');

    $("#lmt-tt-sa").change(function() {
        if ($('#lmt-tt-sa').val() == 'Custom') {
            $('#tt-custom-author').show();
            $('#custom-tt-author').attr('required', 'required');
        }
        if ($('#lmt-tt-sa').val() != 'Custom') {
            $('#tt-custom-author').hide();
            $('#custom-tt-author').removeAttr("required");
        }
        if ($('#lmt-tt-sa').val() == 'Do not show') {
            $('#tt-author-link').hide();
        }
        if ($('#lmt-tt-sa').val() != 'Do not show') {
            $('#tt-author-link').show();
        }
    });
    $("#lmt-tt-sa").trigger('change');

    $("#post-enable-time").change(function () {
        if ($('#post-enable-time').is(':checked')) {
            $('#post-tmcf').show();
        }
        if (!$('#post-enable-time').is(':checked')) {
            $('#post-tmcf').hide();
        }
    });
    $("#post-enable-time").trigger('change');

    $("#post-enable-date").change(function () {
        if ($('#post-enable-date').is(':checked')) {
            $('#post-dtcf').show();
        }
        if (!$('#post-enable-date').is(':checked')) {
            $('#post-dtcf').hide();
        }
    });
    $("#post-enable-date").trigger('change');

    $("#page-enable-time").change(function () {
        if ($('#page-enable-time').is(':checked')) {
            $('#page-tmcf').show();
        }
        if (!$('#page-enable-time').is(':checked')) {
            $('#page-tmcf').hide();
        }
    });
    $("#page-enable-time").trigger('change');

    $("#page-enable-date").change(function () {
        if ($('#page-enable-date').is(':checked')) {
            $('#page-dtcf').show();
        }
        if (!$('#page-enable-date').is(':checked')) {
            $('#page-dtcf').hide();
        }
    });
    $("#page-enable-date").trigger('change');

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