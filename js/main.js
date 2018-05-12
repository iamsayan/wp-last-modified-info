jQuery(document).ready(function () {
    jQuery("#btn1").click(function () {
        jQuery("#show-post").show();
        jQuery("#show-page").hide();
        jQuery("#show-dashboard").hide();
        jQuery("#show-tt").hide();
        jQuery("#show-style-area").hide();
        jQuery("#show-help").hide();

    });

    jQuery("#btn2").click(function () {
        jQuery("#show-post").hide();
        jQuery("#show-page").show();
        jQuery("#show-dashboard").hide();
        jQuery("#show-tt").hide();
        jQuery("#show-style-area").hide();
        jQuery("#show-help").hide();

    });

    jQuery("#btn3").click(function () {
        jQuery("#show-post").hide();
        jQuery("#show-page").hide();
        jQuery("#show-dashboard").show();
        jQuery("#show-tt").hide();
        jQuery("#show-style-area").hide();
        jQuery("#show-help").hide();

    });

    jQuery("#btn4").click(function () {
        jQuery("#show-post").hide();
        jQuery("#show-page").hide();
        jQuery("#show-dashboard").hide();
        jQuery("#show-tt").show();
        jQuery("#show-style-area").hide();
        jQuery("#show-help").hide();

    });

    jQuery("#btn5").click(function () {
        jQuery("#show-post").hide();
        jQuery("#show-page").hide();
        jQuery("#show-dashboard").hide();
        jQuery("#show-tt").hide();
        jQuery("#show-style-area").show();
        jQuery("#show-help").hide();

    });

    jQuery("#btn6").click(function () {
        jQuery("#show-post").hide();
        jQuery("#show-page").hide();
        jQuery("#show-dashboard").hide();
        jQuery("#show-tt").hide();
        jQuery("#show-style-area").hide();
        jQuery("#show-help").show();

    });

    jQuery("#post-enable").change(function () {
        if (jQuery('#post-enable').is(':checked')) {
            jQuery('#post-sc').prop('disabled', false);
            jQuery('#post-revised').prop('disabled', false);
            jQuery('#post-enable-time').prop('disabled', false);
            jQuery('#custom-post-time-format').prop('disabled', false);
            jQuery('#post-enable-date').prop('disabled', false);
            jQuery('#custom-post-date-format').prop('disabled', false);
            jQuery('#post-show-status').prop('disabled', false);
            jQuery('#post-custom-text').prop('disabled', false);
            jQuery('#post-disable-auto-insert').prop('disabled', false);
        }
        if (!jQuery('#post-enable').is(':checked')) {
            jQuery('#post-sc').prop('disabled', true);
            jQuery('#post-revised').prop('disabled', true);
            jQuery('#post-enable-time').prop('disabled', true);
            jQuery('#custom-post-time-format').prop('disabled', true);
            jQuery('#post-enable-date').prop('disabled', true);
            jQuery('#custom-post-date-format').prop('disabled', true);
            jQuery('#post-show-status').prop('disabled', true);
            jQuery('#post-custom-text').prop('disabled', true);
            jQuery('#post-disable-auto-insert').prop('disabled', true);
        }
    });
    jQuery("#post-enable").trigger('change');


    jQuery("#page-enable").change(function () {
        if (jQuery('#page-enable').is(':checked')) {
            jQuery('#page-sc').prop('disabled', false);
            jQuery('#page-revised').prop('disabled', false);
            jQuery('#page-enable-time').prop('disabled', false);
            jQuery('#custom-page-time-format').prop('disabled', false);
            jQuery('#page-enable-date').prop('disabled', false);
            jQuery('#custom-page-date-format').prop('disabled', false);
            jQuery('#page-show-status').prop('disabled', false);
            jQuery('#page-custom-text').prop('disabled', false);
            jQuery('#page-disable-auto-insert').prop('disabled', false);
        }
        if (!jQuery('#page-enable').is(':checked')) {
            jQuery('#page-sc').prop('disabled', true);
            jQuery('#page-revised').prop('disabled', true);
            jQuery('#page-enable-time').prop('disabled', true);
            jQuery('#custom-page-time-format').prop('disabled', true);
            jQuery('#page-enable-date').prop('disabled', true);
            jQuery('#custom-page-date-format').prop('disabled', true);
            jQuery('#page-show-status').prop('disabled', true);
            jQuery('#page-custom-text').prop('disabled', true);
            jQuery('#page-disable-auto-insert').prop('disabled', true);
        }
    });
    jQuery("#page-enable").trigger('change');

    jQuery("#lmt-tt").change(function () {
        if (jQuery('#lmt-tt').is(':checked')) {
            jQuery('#lmt-tt-format').prop('disabled', false);
            jQuery('#lmt-tt-class').prop('disabled', false);
        }
        if (!jQuery('#lmt-tt').is(':checked')) {
            jQuery('#lmt-tt-format').prop('disabled', true);
            jQuery('#lmt-tt-class').prop('disabled', true);
        }
    });
    jQuery("#lmt-tt").trigger('change');


});