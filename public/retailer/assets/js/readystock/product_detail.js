$(document).ready(function () {
    // Handle increment and decrement for each container
    $(".quantity-container").each(function () {
        var container = $(this);
        var qtyInput = container.find(".qty");
        var productId = container.data("id"); // undefined for single product
        var option = container.data("option") || $("#qty").data("option");

        var moq = 1;
        var qty = parseInt($("#qty").val()) || moq;
        var mqty = parseInt($("#mqty" + productId).val()) || moq;

        // For single product, override mqty with initial qty
        if (!productId) {
            mqty = qty;
        }

        container.find(".qtyplus").click(function (e) {
            e.preventDefault();
            let currentVal = parseInt(qtyInput.val()) || moq;

            if (option === "multiple") {
                if (currentVal < mqty) {
                    qtyInput.val(currentVal + 1);
                } else {
                    qtyInput.val(mqty); // Do not exceed max qty
                }
            } else {
                qtyInput.val(currentVal + 1);
            }
        });

        container.find(".qtyminus").click(function (e) {
            e.preventDefault();
            let currentVal = parseInt(qtyInput.val()) || moq;

            if (currentVal > moq) {
                qtyInput.val(currentVal - 1);
            } else {
                qtyInput.val(moq); // Minimum 1
            }
        });
    });
});

var main = new Splide("#main-slider", {
    type: "fade",
    pagination: false,
    arrows: true,
});

var main = new Splide("#main-slider", {
    type: "fade",
    pagination: false,
    arrows: true,
});

var thumbnails = new Splide("#thumbnail-slider", {
    rewind: true,
    fixedWidth: 104,
    fixedHeight: 104,
    isNavigation: true,
    arrows: false,

    gap: 10,
    focus: "center",
    pagination: false,
    cover: true,
    dragMinThreshold: {
        mouse: 4,
        touch: 10,
    },
    breakpoints: {
        640: {
            fixedWidth: 60,
            fixedHeight: 62,
        },
    },
});

main.sync(thumbnails);
main.mount();
thumbnails.mount();
$(document).ready(function () {
    $(".accordion-header").click(function () {
        // Toggle the "collapsed" class on the header
        $(this).toggleClass("collapsed");

        // Toggle the icon (plus/minus) based on the header's state
        if ($(this).hasClass("collapsed")) {
            $(this)
                .find(".accordion-icon i")
                .removeClass("fa-angle-down")
                .addClass("fa-angle-up");
        } else {
            $(this)
                .find(".accordion-icon i")
                .removeClass("fa-angle-up")
                .addClass("fa-angle-down");
        }
    });
});
