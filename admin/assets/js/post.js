function doCopyPost() {
    var copyText = document.getElementById("postSC");
    copyText.select();
    document.execCommand("copy");

    var tooltip = document.getElementById("scTooltipPost");
    tooltip.innerHTML = "Shortcode Copied";
}

function doCopyPage() {
    var copyText = document.getElementById("pageSC");
    copyText.select();
    document.execCommand("copy");

    var tooltip = document.getElementById("scTooltipPage");
    tooltip.innerHTML = "Shortcode Copied";
}

function dooutFuncPost() {
    var tooltip = document.getElementById("scTooltipPost");
    tooltip.innerHTML = "Copy to clipboard";
}

function dooutFuncPage() {
    var tooltip = document.getElementById("scTooltipPage");
    tooltip.innerHTML = "Copy to clipboard";
}