jQuery(document).ready(function ($) {
    $(".js-select2-multi").select2();
    $(".js-select2-multi").on("focus", () => {
        inputElement.parent().find(".select2-search__field").prop("disabled", true);
    });

    jQuery(function () {
        jQuery(".mcfwp-color-field").wpColorPicker();
    });

    jQuery(".mcfwp-select").val() == "" ? jQuery(".mcfwp-select-err").fadeIn() : jQuery(".mcfwp-select-err").fadeOut();

    jQuery(".mcfwp-select").on("change", function () {
        var selectVal = jQuery(".mcfwp-select").val();
        selectVal == "" ? jQuery(".mcfwp-select-err").fadeIn() : jQuery(".mcfwp-select-err").fadeOut();
    });

    jQuery(".mcfwp-cart-options input[type=radio]").click(function () {
        jQuery(".mcfwp-cart-options").removeClass("mcfwp-current-cart-options");
        jQuery(this).parent().addClass("mcfwp-current-cart-options");
    });

    jQuery(".mcfwp-cart-btn-img input[type=radio]").click(function () {
        jQuery(".mcfwp-cart-btn-img").removeClass("mcfwp-current-cart-options");
        jQuery(this).parent().addClass("mcfwp-current-cart-options");
    });

    jQuery("body").on("click", ".mcfwp-menu-list", function () {
        jQuery(".mcfwp-mini-cart-main").addClass("mcfwp-menu-list-open");
    });

    Coloris({
        el: ".mcfwp_coloris",
        themeMode: "auto",
        swatches: ["#264653", "#2a9d8f", "#e9c46a", "#f4a261"],
        clearButton: {
            show: true,
            label: "Clear",
        },
        formatToggle: true,
        selectInput: true,
    });

    jQuery("body").on("click", ".mcfwp-design-setting input[type=reset]", function () {
        jQuery(".mcfwp-design-setting").find("input[type=text]").val("");
        jQuery(".mcfwp-design-setting").find(".clr-field").removeAttr("style");
        jQuery(".mcfwp-design-setting .mcfwp-sticky-cart-shape").val("mcfwp_round_cart").change();
        jQuery(".mcfwp-design-setting .mcfwp-border-style-select").val("none").change();
        jQuery(".mcfwp-design-setting .mcfwp-currency-position-select").val("mcfwp_currency_postion_left_withspace").change();
        jQuery(".mcfwp-design-setting input[type=submit]").click();
    });

    jQuery("body").on("click", "#mcfwp_copy_icon", function () {
        console.log("cal..");
        var copyText = document.getElementById("mcfwp_shortcode_copy");

        var text = copyText.value;
        var sampleTextarea = document.createElement("textarea");
        document.body.appendChild(sampleTextarea);
        sampleTextarea.value = text; //save main text in it
        sampleTextarea.select(); //select textarea contenrs
        document.execCommand("copy");
        document.body.removeChild(sampleTextarea);

        var tooltip = document.getElementById("mcfwp_shortcodeTooltip");
        tooltip.innerHTML = "Copied!";

        /* Select the text field */
        // copyText.select();
        // copyText.setSelectionRange(0, 99999); /* For mobile devices */

        // /* Copy the text inside the text field */
        // navigator.clipboard.writeText(copyText.value);

        // /* Alert the copied text */
        // alert("Copied the text: " + copyText.value);
    });

    jQuery("body #mcfwp_shortcode_copy").mouseout(function () {
        var tooltip = document.getElementById("mcfwp_shortcodeTooltip");
        tooltip.innerHTML = "Copy to clipboard";
    });
});
