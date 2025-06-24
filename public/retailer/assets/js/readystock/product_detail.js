$(document).ready(function () {
    // Handle increment and decrement for each container
    $(".quantity-container").each(function () {
        var container = $(this);
        var qtyInput = container.find(".qty");
        var moq = parseInt($("#moq").val());
        var qty = parseInt($("#qty").val());
        var stock = parseInt($("#stockqty").val());
        console.log(stock);

        container.find(".qtyplus").click(function (e) {
            e.preventDefault();
            var currentVal = parseInt(qtyInput.val());
            if (!isNaN(currentVal)) {
                if (stock === 1 && currentVal + 1 > qty) {
                    // If stock is 1 and increasing the quantity exceeds available stock, do nothing
                    container.find(".qtyplus").css("color", "red");
                    return;
                }
                qtyInput.val(currentVal + 1);
                // Show the ".qtyminus" button when incrementing
                container.find(".qtyminus").css("color", "black");
            } else {
                qtyInput.val(stock === 1 ? qty : moq);
            }
        });

        container.find(".qtyminus").click(function (e) {
            e.preventDefault();
            var currentVal = parseInt(qtyInput.val());
            if (!isNaN(currentVal) && currentVal > moq) {
                qtyInput.val(currentVal - 1);
                container.find(".qtyplus").css("color", "black");
                container.find(".qtyminus").css("color", "black");
            } else {
                qtyInput.val(moq);
                container.find(".qtyminus").css("color", "red");
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
