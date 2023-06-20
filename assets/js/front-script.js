jQuery(document).ready(function ($) {
    setTimeout(refresh_cart_fragment, 1000);

    var $supports_html5_storage = true,
        cart_hash_key = wc_add_to_cart_params.cart_hash_key;

    var $fragment_refresh = {
        url: wc_add_to_cart_params.wc_ajax_url.toString().replace("%%endpoint%%", "get_refreshed_fragments"),
        type: "POST",
        data: {
            time: new Date().getTime(),
        },
        timeout: wc_add_to_cart_params.request_timeout,
        success: function (data) {
            if (data && data.fragments) {
                $.each(data.fragments, function (key, value) {
                    $(key).replaceWith(value);
                });

                if ($supports_html5_storage) {
                    sessionStorage.setItem(wc_add_to_cart_params.fragment_name, JSON.stringify(data.fragments));
                }

                $(document.body).trigger("wc_fragments_refreshed");
            }
        },
    };

    /* Named callback for refreshing cart fragment */
    function refresh_cart_fragment() {
        $.ajax($fragment_refresh);
    }
    jQuery(document.body).on("wc_cart_emptied", empty_cart);

    function empty_cart(params) {
        if (mcfwpObj.general_data["always_display"] != "on") {
            jQuery(".mcfwp-menu").hide();
        }
    }
    jQuery("body").on("added_to_cart", function () {
        jQuery(".mcfwp-menu").show();
    });

    /** Main Menu click to show falyout  */
    jQuery("body").on("click", ".mcfwp-menu .mcfwp-menu-list", function () {
        jQuery(this).closest(".mcfwp-menu").toggleClass("mcfwp-menu-show");
        const fullHeight = jQuery(document).scrollTop() + window.innerHeight - jQuery(".mcfwp-mini-cart-main").height();
        const clickTop = jQuery(this).offset().top;
        const downUp = fullHeight - clickTop;

        if (jQuery(this).hasClass("mcfwp-menu-show")) {
            if (downUp < 0) {
                jQuery(this).closest(".mcfwp-menu").addClass("mcfwp-falyout-open-top");
            } else {
                if (jQuery(".mcfwp-menu").hasClass("mcfwp-falyout-open-top")) {
                    jQuery(".mcfwp-menu").removeClass("mcfwp-falyout-open-top");
                }
            }
        }
    });

    jQuery("body").on("mouseover", ".mcfwp-menu", function () {
        const fullHeight = jQuery(document).scrollTop() + window.innerHeight - jQuery(".mcfwp-mini-cart-main").height();
        const clickTop = jQuery(this).offset().top;
        const downUp = fullHeight - clickTop;

        if (downUp < 0) {
            jQuery(this).closest(".mcfwp-menu").addClass("mcfwp-falyout-open-top");
        } else {
            if (jQuery(".mcfwp-menu").hasClass("mcfwp-falyout-open-top")) {
                jQuery(".mcfwp-menu").removeClass("mcfwp-falyout-open-top");
            }
        }
    });

    /** Remove Product in cart */
    var currentRequest = null;
    jQuery("body").on("click", ".mcfwp-remove-cart-item", function () {
        var product_id = jQuery(this).attr("data-id");
        currentRequest = $.ajax({
            type: "POST",
            url: mcfwpObj.ajaxurl,
            data: {
                action: "mcfwp_remove_cart_iteam",
                product_id: product_id,
            },
            dataType: "text",
            beforeSend: function () {
                if (currentRequest != null) {
                    currentRequest.abort();
                }
            },
            success: function (data) {
                refresh_cart_fragment();
            },
        });
    });

    setTimeout(function () {
        var i = 1;
        jQuery(".mcfwp-mini-cart-main").each(function () {
            const fullHeight = jQuery(document).scrollTop() + window.innerHeight - jQuery(".mcfwp-mini-cart-main").height();
            const clickTop = jQuery(this).offset().top;
            const downUp = fullHeight - clickTop;

            if (downUp < 0) {
                jQuery(this).closest(".mcfwp-menu").addClass("mcfwp-falyout-open-top");
            }
        });
    }, 1000);
});

jQuery(document).click(function (event) {
    var container = jQuery(".mcfwp-mini-cart-main");
    var container_menu = jQuery(".mcfwp-menu");
    if (!container.is(event.target) && !container.has(event.target).length) {
        if (!container_menu.is(event.target) && !container_menu.has(event.target).length) {
            jQuery("body .mcfwp-menu").removeClass("mcfwp-menu-show");
        }
    }
});
