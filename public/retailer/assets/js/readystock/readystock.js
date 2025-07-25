var baseurl = window.location.origin;
var windowWidth = window.innerWidth;
$(document).ready(function () {
    //qty
    qtyplusminus();
});
$("#add-moq").change(function () {
    if (this.checked) {
        $(".card-checkbox").prop("checked", true);
    } else {
        $(".card-checkbox").prop("checked", false);
    }
});
function qtyplusminus() {
    $(".quantity-container").each(function () {
        var container = $(this);
        var qtyInput = container.find(".qty");
        var productId = container.data("product-id");
        var moq = parseInt($("#moq" + productId).val()) || 1;
        var qty = $("#qty" + productId).val();
        // var stock = $("#stockqty").val();

        var stock = parseInt(qtyInput.data("stock")) || 1;



        container.find(".qtyplus").click(function (e) {
            e.preventDefault();
            var currentVal = parseInt(qtyInput.val());
            if (!isNaN(currentVal)) {
                if (currentVal < stock) {
                    qtyInput.val(currentVal + 1);
                    container.find(".qtyplus").css("color", "black");
                } else {
                    qtyInput.val(stock); // Clamp to stock limit
                    container.find(".qtyplus").css("color", "red");
                }
            } else {
                qtyInput.val(moq);
            }
        });

        container.find(".qtyminus").click(function (e) {
            e.preventDefault();
            var currentVal = parseInt(qtyInput.val());
            if (!isNaN(currentVal) && currentVal > moq) {
                qtyInput.val(currentVal - 1);
                container.find(".qtyminus").css("color", "black");
                container.find(".qtyplus").css("color", "black");
            } else {
                qtyInput.val(moq);
                container.find(".qtyminus").css("color", "red");
            }
        });
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const gridButton = document.querySelector(".grid-view");
    const listButton = document.querySelector(".list-view");
    const productCards = document.querySelector(".shop-page_product-cards");

    // Function to set the default view based on screen size
    function setDefaultView() {
        if (window.innerWidth < 768) {
            // Mobile screen
            productCards.classList.remove("grid");
            productCards.classList.add("list");
            listButton.classList.add("active");
            gridButton.classList.remove("active");
        } else {
            // Larger screens
            productCards.classList.remove("list");
            productCards.classList.add("grid");
            gridButton.classList.add("active");
            listButton.classList.remove("active");
        }
    }

    // Call the function when the page loads
    setDefaultView();

    // Optionally, listen for window resize to adjust view dynamically
    window.addEventListener("resize", setDefaultView);

    gridButton.addEventListener("click", function () {
        productCards.classList.remove("list");
        productCards.classList.add("grid");
        gridButton.classList.add("active");
        listButton.classList.remove("active");
    });

    listButton.addEventListener("click", function () {
        productCards.classList.remove("grid");
        productCards.classList.add("list");
        listButton.classList.add("active");
        gridButton.classList.remove("active");
    });
});

$(".top-dropdown-filters .btn").click(function () {
    var target = $(this).attr("data-target");
    var isExpanded = $(this).attr("aria-expanded") === "true";

    // Remove "show" class from all other collapses
    $(".top-dropdown-filters .collapse").not(target).removeClass("show");
    // Set "aria-expanded" to false for all other buttons
    $(".top-dropdown-filters .btn").not(this).attr("aria-expanded", "false");

    // Toggle the current collapse
    $(target).toggleClass("show");
    // Set "aria-expanded" to the opposite of its current state for the clicked button
    // $(this).attr('aria-expanded', !isExpanded);
});

function getWeightRange(id, page = 1) {
    $(".pagination-links").attr("hidden", true);
    var project = $("#decryptedProjectId").val();
    var procategory = $("#procategory").val();
    var product = $("#product").val();

    // Split the value into an array using the comma as a delimiter
    var procategoryArray = procategory.split(",");
    var productArray = product.split(",");

    var selectedWeightRanges = [];
    var weightToArray = [];

    // Iterate over all checkboxes with the class 'platingfilter'
    $(".weight_filter").each(function () {
        if (windowWidth > 300) {
            $("#pageloader").fadeIn();
        }
        var currentCheckbox = $(this);
        if (currentCheckbox.is(":checked")) {
            // Check if the value is already in the array
            if (!selectedWeightRanges.includes(currentCheckbox.val())) {
                // Add the value to the selectedWeightRanges array
                selectedWeightRanges.push(currentCheckbox.val());

                // Get the corresponding weightTo value
                weightToArray.push(
                    $("#weightto" + currentCheckbox.attr("data-id")).val()
                );
            }
        }

        // Serialize the array into a string separated by a delimiter (comma)
        var selectedweightfrom = selectedWeightRanges.join(",");
        var selectedweightto = weightToArray.join(",");

        // Set the value of the hidden input field to the serialized string
        $("#hdweightfrom").val(selectedweightfrom);
        $("#hdweightto").val(selectedweightto);

        // To retrieve the array back from the string later:
        // Retrieve the value of the hidden input field
        var selectedweightfrom = $("#hdweightfrom").val();
        var selectedweightto = $("#hdweightto").val();

        // Split the string into an array using the delimiter (comma)
        var selectedweightfrom = selectedweightfrom.split(",");
        var selectedweightto = selectedweightto.split(",");
    });

    $("#product_page").empty();
    $.ajax({
        type: "GET",
        url: "/retailer/weightrange/" + id + "?page=" + page,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            selectedWeightRanges: selectedWeightRanges,
            weightToArray: weightToArray,
            procategoryArray: procategoryArray,
            productArray: productArray,
            project: project,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            // Check if any checkbox is checked
            let isAnyCheckboxChecked = $(".weight_filter:checked").length > 0;
            // Assign value to #subCollectionData based on the checkbox state
            if (isAnyCheckboxChecked) {
                $("#subCollectionData").val(
                    JSON.stringify(result.subcollectionsjson)
                );
            } else {
                $("#subCollectionData").val(
                    JSON.stringify(result.subcollectionsDefaultjson)
                );
            }
            if (result.weightrange.data.length == 0) {
                $("#checkboxhidden").attr("hidden", "");
                $("#addtocarthidden").attr("hidden", "");
                $("#product_page").attr("hidden", "");
                $("#notfound").empty();
                var notfound = `<img src='${baseurl}/emptycart.gif'>`;
                $("#notfound").append(notfound);
                if (windowWidth > 300) {
                    $("#pageloader").fadeOut();
                }
            } else {
                $("#checkboxhidden").removeAttr("hidden", "");
                $("#addtocarthidden").removeAttr("hidden", "");
                $("#product_page").removeAttr("hidden", "");
                $.each(result.weightrange.data, function (key, value) {
                    $("#notfound").empty();
                    moqAvailabilityHTML = ` <div class="card-multiple-sizes-wrapper">

                                            <div class="d-flex mt-3">
                                                <div class="product-cart-qty-text">In Stock:
                                                    <span> ${
                                                        value.qty ?? "-"
                                                    } Pcs</span>
                                                </div>
                                            </div>
                                            </div>`;

                    var eid = $("#encrypt" + value.id).val();
                    var productDetailUrl =
                        "/retailer/productdetail/productId".replace(
                            "productId",
                            eid
                        );
                    var productHTML = `
                    <input type="hidden" name="weight${value.id}" id="weight${
                        value.id
                    }" value="${value.weight}">
                    <input type="hidden" name="size${value.id}" id="size${
                        value.id
                    }" value="${value.size}">
                    <input type="hidden" name="color${value.id}" id="color${
                        value.id
                    }" value="${value.color}">
                            <input type="hidden" name="box${value.id}" id="box${
                        value.id
                    }" value="${value.style}">
                    <div class="card shop-page_product-card">
                        <div class="card-checkbox_wrapper">
                            <input class="card-checkbox" type="checkbox" name="product${
                                value.id
                            }"
                                id="product${value.id}" data-id="${value.id}">
                        </div>
                        <div class="card-img-top d-flex align-items-center justify-content-center position-relative">
                            <a href="${productDetailUrl}">
                                <img class="img-fluid prouduct_card-image load-secure-image" width="255"
                                            height="255" src="http://imageurl.ejindia.com/api/image/secure"
                                            data-secure="${
                                                value.secureFilename
                                            }" alt>
                            </a>
                             <div class="position-absolute card-purity purity-list">
                                Purity: ${value.Purity}
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div
                                class="d-flex justify-content-between  align-items-center flex-wrap card-title_wrapper">
                              <div class="card-title"><a href="${productDetailUrl}">${
                        value.DesignNo
                    }</a> </div>
                                 
                                    <button class="ml-2 custom-icon-btn wishlist-svg ${
                                        value.is_favourite === 1 ? "active" : ""
                                    }"
                                    onclick="addtowishlist(${value.id})">
                                        <svg width="26" height="23" viewBox="0 0 26 23"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21.5109 13.0016L12.7523 21.8976L4.0016 13.0016C-3.73173 5.15359 5.0336 -3.73174 12.7603 4.11626C20.6003 -3.84641 29.3589 5.03893 21.5189 13.0123L21.5109 13.0016Z"
                                                stroke="inherit" stroke-width="1.5"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </button>
                            </div>
                                <input type="hidden" name="qty${value.id}"
                          id="qty${value.id}" value="${value.qty}">
        <div>

       <div class="mt-3 grid cols-3 card-content_wrapper">
                                            ${
                                                value.color
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">Colour</div>
                                                <div class="product-card-badge product-card-badge-light">
                                                    ${value.color ?? "-"}</div>
                                            </div>`
                                                    : ""
                                            }
                                             ${
                                                 value.unit
                                                     ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">Unit</div>
                                                <div class="product-card-badge product-card-badge-light">
                                                    ${value.unit ?? "-"}</div>
                                            </div>`
                                                     : ""
                                             }
                                            ${
                                                value.style
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">Style</div>
                                                <div class="product-card-badge product-card-badge-light">
                                                    ${value.style ?? "-"}</div>
                                            </div>`
                                                    : ""
                                            }
                                            ${
                                                value.making
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">Making %</div>
                                                <div class="product-card-badge">${
                                                    value.making ?? "-"
                                                }
                                                </div>
                                            </div>`
                                                    : ""
                                            }
                                            ${
                                                value.size
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">
                                                    Size
                                                </div>
                                                <div class="product-card-badge">${
                                                    value.size ?? "-"
                                                }
                                                </div>
                                            </div>`
                                                    : ""
                                            }
                                            ${
                                                value.weight
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">
                                                    Weight
                                                </div>
                                                <div class="product-card-badge">
                                                    ${
                                                        value.weight ?? "-"
                                                    }g</div>
                                            </div>`
                                                    : ""
                                            }
                                        </div>
             </div>
              <div class="d-flex flex-wrap gap-2 align-items-center">
                  ${moqAvailabilityHTML}
                  <div class="d-flex gap-2 align-items-center purity-inside-card">
                      <div class="card-text text-dark">
                          Purity
                      </div>
                      <div class="product-card-badge">${value.Purity}</div>
                  </div>
              </div>
                            <div class="mt-3 shop-page-qty-add-to-cart-btn_wrapper">
                                <div class="d-flex align-items-center">
                                    <label class="me-2">Qty</label>
                                    <div class="input-group quantity-input-group quantity-container"
                                        data-product-id=${value.id}>
                                        <input type="button" value="-" class="qtyminus"
                                            field="quantity"
                                           >
                                        <input type="text" name="quantity"
                                            id="quantity${value.id}" value="1"
                                            class="qty">
                                        <input type="button" value="+" class="qtyplus"
                                            field="quantity">
                                    </div>
                                </div>
                                <div class="shop-page-add-to-cart-btn">
                                <button onclick="addforcart(${
                                    value.id
                                })" data_id="card_id_${value.id}"
                                  class="btn ${
                                      result.cart[key] &&
                                      Array.isArray(result.cart[key]) &&
                                      result.cart[key].length
                                          ? "added-to-cart-btn"
                                          : "add-to-cart-btn"
                                  } mr-2 spinner-button">                                                            
                                  <span class="submit-text">${
                                      result.cart[key] &&
                                      Array.isArray(result.cart[key]) &&
                                      result.cart[key].length
                                          ? "Added To Cart"
                                          : "ADD TO CART"
                                  }</span>
                          <span class="d-none spinner">
                              <span class="spinner-grow spinner-grow-sm"
                                  aria-hidden="true"></span>
                              <span role="status">Adding...</span>
                          </span>
                          <span class="added-to-cart-badge ms-2">${
                              result.cartcount[key]
                          }</span>
                          </button>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
      `;
                    $("#product_page").append(productHTML);
                });
                $(".loader").fadeOut();
                if (windowWidth > 300) {
                    $("#pageloader").fadeOut();
                }
                $("#pagination").empty();
                // Append pagination links
                var paginationHTML = `<div class="my-5 pagination-links">
                <nav class="large-devices_pagination">
                    <div class="d-flex gap-3 flex-wrap justify-content-between">
                        <div>
                             Showing ${result.weightrange.from} - ${result.weightrange.to} of ${result.weightrange.total} results
                         </div>
                         <ul class="pagination">`;

                if (result.weightrange.current_page == 1) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Previous</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link" href="javascript:void(0)" onclick="getProduct(${id},${
                        result.weightrange.current_page - 1
                    })" tabindex="-1">Previous</a>
                 </li>`;
                }

                for (
                    var page = Math.max(1, result.weightrange.current_page - 2);
                    page <=
                    Math.min(
                        result.weightrange.last_page,
                        result.weightrange.current_page + 2
                    );
                    page++
                ) {
                    if (page == result.weightrange.current_page) {
                        paginationHTML += `<li class="page-item active">
                         <span class="page-link">${page}</span>
                     </li>`;
                    } else {
                        paginationHTML += `<li class="page-item">
                         <a class="page-link"  href="javascript:void(0)" onclick="getProduct(${id},${page})">${page}</a>
                     </li>`;
                    }
                }

                if (
                    result.weightrange.current_page ==
                    result.weightrange.last_page
                ) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Next</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link"  href="javascript:void(0)" onclick="getProduct(${id},${
                        result.weightrange.current_page + 1
                    })">Next</a>
                 </li>`;
                }

                paginationHTML += `</ul></div></nav>
                <nav class="small-devices_pagination d-none">
                    <div class="text-center">
                        <a class="btn btn-dark px-4 py-2" href="javascript:void(0)" onclick="getProduct(${id},${
                    result.weightrange.current_page + 1
                })">See More
                            Products</a>
                    </div>
                </nav></div>`;

                $("#pagination").append(paginationHTML);
            }
            qtyplusminus();
            loadSecureImages();
            $(".card-checkbox").click(function () {
                if ($(this).is(":checked")) {
                    $("#addalltocart").removeAttr("disabled");
                } else {
                    $("#addalltocart").attr("disabled", "disabled");
                }
            });

            // Add click event listener to wishlist-svg buttons
            const wishlistButtons = document.querySelectorAll(".wishlist-svg");

            wishlistButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    // Toggle the 'active' class to change the color on click
                    this.classList.toggle("active");
                });
            });
            var weightlength = document.querySelectorAll(
                ".weight_filter:checked"
            );

            if (isAnyCheckboxChecked) {
                updateProCategoryFilters(result.procategoryjson);
                updateMobileProCategoryFilters(result.procategoryjson);
            } else {
                updateProCategoryFilters(result.procategoryDefaultjson);
                updateMobileProCategoryFilters(result.procategoryDefaultjson);
            }
        },
    });
}

function getProduct(id, page = 1) {
    $(".pagination-links").attr("hidden", true);
    var project_id = $("#decryptedProjectId").val();
    var weightfrom = document.getElementById("hdweightfrom").value;
    var weightto = document.getElementById("hdweightto").value;
    var procategory = $("#procategory").val();

    // Split the value into an array using the comma as a delimiter
    var weightfrom = weightfrom.split(",");
    var weightto = weightto.split(",");
    var procategoryArray = procategory.split(",");

    var selectedItem = [];
    $(".product").each(function () {
        if (windowWidth > 300) {
            $("#pageloader").fadeIn();
        }
        if ($(this).is(":checked")) {
            selectedItem.push($(this).val());
        }
    });
    // Set the value of the hidden input field to the serialized string
    $("#product").val(selectedItem);

    $("#product_page").empty();
    $.ajax({
        type: "GET",
        url: "/retailer/itemwiseproduct/" + id + "?page=" + page,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            selectedItem: selectedItem,
            project_id: project_id,
            weightfrom: weightfrom,
            weightto: weightto,
            procategoryArray: procategoryArray,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            // Check if any checkbox is checked
            let isAnyCheckboxChecked = $(".product:checked").length > 0;
            // Assign value to #subCollectionData based on the checkbox state
            if (isAnyCheckboxChecked) {
                $("#weights").val(JSON.stringify(result.weightJson));
                $("#procategoryFilter").val(
                    JSON.stringify(result.procategoryjson)
                );
            } else {
                $("#weights").val(JSON.stringify(result.defaultweightJson));
                $("#procategoryFilter").val(
                    JSON.stringify(result.procategoryDefaultjson)
                );
            }
            if (result.itemwiseproduct.data.length == 0) {
                $("#checkboxhidden").attr("hidden", "");
                $("#addtocarthidden").attr("hidden", "");
                $("#product_page").attr("hidden", "");
                $("#notfound").empty();
                var notfound = `<img src='${baseurl}/emptycart.gif'>`;
                $("#notfound").append(notfound);
                if (windowWidth > 300) {
                    $("#pageloader").fadeOut();
                }
            } else {
                $("#checkboxhidden").removeAttr("hidden", "");
                $("#addtocarthidden").removeAttr("hidden", "");
                $("#product_page").removeAttr("hidden", "");
                $.each(result.itemwiseproduct.data, function (key, value) {
                    $("#notfound").empty();
                    moqAvailabilityHTML = ` <div class="card-multiple-sizes-wrapper">

                                            <div class="d-flex mt-3">
                                                <div class="product-cart-qty-text">In Stock:
                                                    <span> ${
                                                        value.qty ?? "-"
                                                    } Pcs</span>
                                                </div>
                                            </div>
                                            </div>`;

                    var eid = $("#encrypt" + value.id).val();
                    var productDetailUrl =
                        "/retailer/productdetail/productId".replace(
                            "productId",
                            eid
                        );
                    var productHTML = `
                    <input type="hidden" name="weight${value.id}" id="weight${
                        value.id
                    }" value="${value.weight}">
                    <input type="hidden" name="size${value.id}" id="size${
                        value.id
                    }" value="${value.size}">
                    <input type="hidden" name="color${value.id}" id="color${
                        value.id
                    }" value="${value.color}">
                            <input type="hidden" name="box${value.id}" id="box${
                        value.id
                    }" value="${value.style}">
                    <div class="card shop-page_product-card">
                        <div class="card-checkbox_wrapper">
                            <input class="card-checkbox" type="checkbox" name="product${
                                value.id
                            }"
                                id="product${value.id}" data-id="${value.id}">
                        </div>
                        <div class="card-img-top d-flex align-items-center justify-content-center position-relative">
                            <a href="${productDetailUrl}">
                                <img class="img-fluid prouduct_card-image load-secure-image" width="255"
                                            height="255" src="http://imageurl.ejindia.com/api/image/secure"
                                            data-secure="${
                                                value.secureFilename
                                            }" alt>
                            </a>
                             <div class="position-absolute card-purity purity-list">
                                Purity: ${value.Purity}
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div
                                class="d-flex justify-content-between  align-items-center flex-wrap card-title_wrapper">
                              <div class="card-title"><a href="${productDetailUrl}">${
                        value.DesignNo
                    }</a> </div>
                                 
                                    <button class="ml-2 custom-icon-btn wishlist-svg ${
                                        value.is_favourite === 1 ? "active" : ""
                                    }"
                                    onclick="addtowishlist(${value.id})">
                                        <svg width="26" height="23" viewBox="0 0 26 23"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21.5109 13.0016L12.7523 21.8976L4.0016 13.0016C-3.73173 5.15359 5.0336 -3.73174 12.7603 4.11626C20.6003 -3.84641 29.3589 5.03893 21.5189 13.0123L21.5109 13.0016Z"
                                                stroke="inherit" stroke-width="1.5"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </button>
                            </div>
                                <input type="hidden" name="qty${value.id}"
                          id="qty${value.id}" value="${value.qty}">
        <div>

       <div class="mt-3 grid cols-3 card-content_wrapper">
                                            ${
                                                value.color
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">Colour</div>
                                                <div class="product-card-badge product-card-badge-light">
                                                    ${value.color ?? "-"}</div>
                                            </div>`
                                                    : ""
                                            }
                                             ${
                                                 value.unit
                                                     ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">Unit</div>
                                                <div class="product-card-badge product-card-badge-light">
                                                    ${value.unit ?? "-"}</div>
                                            </div>`
                                                     : ""
                                             }
                                            ${
                                                value.style
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">Style</div>
                                                <div class="product-card-badge product-card-badge-light">
                                                    ${value.style ?? "-"}</div>
                                            </div>`
                                                    : ""
                                            }
                                            ${
                                                value.making
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">Making %</div>
                                                <div class="product-card-badge">${
                                                    value.making ?? "-"
                                                }
                                                </div>
                                            </div>`
                                                    : ""
                                            }
                                            ${
                                                value.size
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">
                                                    Size
                                                </div>
                                                <div class="product-card-badge">${
                                                    value.size ?? "-"
                                                }
                                                </div>
                                            </div>`
                                                    : ""
                                            }
                                            ${
                                                value.weight
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">
                                                    Weight
                                                </div>
                                                <div class="product-card-badge">
                                                    ${
                                                        value.weight ?? "-"
                                                    }g</div>
                                            </div>`
                                                    : ""
                                            }
                                        </div>
             </div>
              <div class="d-flex flex-wrap gap-2 align-items-center">
                  ${moqAvailabilityHTML}
                  <div class="d-flex gap-2 align-items-center purity-inside-card">
                      <div class="card-text text-dark">
                          Purity
                      </div>
                      <div class="product-card-badge">${value.Purity}</div>
                  </div>
              </div>
                            <div class="mt-3 shop-page-qty-add-to-cart-btn_wrapper">
                                <div class="d-flex align-items-center">
                                    <label class="me-2">Qty</label>
                                    <div class="input-group quantity-input-group quantity-container"
                                        data-product-id=${value.id}>
                                        <input type="button" value="-" class="qtyminus"
                                            field="quantity"
                                           >
                                        <input type="text" name="quantity"
                                            id="quantity${value.id}" value="1"
                                            class="qty">
                                        <input type="button" value="+" class="qtyplus"
                                            field="quantity">
                                    </div>
                                </div>
                                <div class="shop-page-add-to-cart-btn">
                                <button onclick="addforcart(${
                                    value.id
                                })" data_id="card_id_${value.id}"
                                  class="btn ${
                                      result.cart[key] &&
                                      Array.isArray(result.cart[key]) &&
                                      result.cart[key].length
                                          ? "added-to-cart-btn"
                                          : "add-to-cart-btn"
                                  } mr-2 spinner-button">                                                            
                                  <span class="submit-text">${
                                      result.cart[key] &&
                                      Array.isArray(result.cart[key]) &&
                                      result.cart[key].length
                                          ? "Added To Cart"
                                          : "ADD TO CART"
                                  }</span>
                          <span class="d-none spinner">
                              <span class="spinner-grow spinner-grow-sm"
                                  aria-hidden="true"></span>
                              <span role="status">Adding...</span>
                          </span>
                          <span class="added-to-cart-badge ms-2">${
                              result.cartcount[key]
                          }</span>
                          </button>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
      `;
                    $("#product_page").append(productHTML);
                });
                $(".loader").fadeOut();
                if (windowWidth > 300) {
                    $("#pageloader").fadeOut();
                }
                $("#pagination").empty();
                // Append pagination links
                var paginationHTML = `<div class="my-5 pagination-links">
                <nav class="large-devices_pagination">
                    <div class="d-flex gap-3 flex-wrap justify-content-between">
                        <div>
                             Showing ${result.itemwiseproduct.from} - ${result.itemwiseproduct.to} of ${result.itemwiseproduct.total} results
                         </div>
                         <ul class="pagination">`;

                if (result.itemwiseproduct.current_page == 1) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Previous</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link" href="javascript:void(0)" onclick="getProduct(${id},${
                        result.itemwiseproduct.current_page - 1
                    })" tabindex="-1">Previous</a>
                 </li>`;
                }

                for (
                    var page = Math.max(
                        1,
                        result.itemwiseproduct.current_page - 2
                    );
                    page <=
                    Math.min(
                        result.itemwiseproduct.last_page,
                        result.itemwiseproduct.current_page + 2
                    );
                    page++
                ) {
                    if (page == result.itemwiseproduct.current_page) {
                        paginationHTML += `<li class="page-item active">
                         <span class="page-link">${page}</span>
                     </li>`;
                    } else {
                        paginationHTML += `<li class="page-item">
                         <a class="page-link"  href="javascript:void(0)" onclick="getProduct(${id},${page})">${page}</a>
                     </li>`;
                    }
                }

                if (
                    result.itemwiseproduct.current_page ==
                    result.itemwiseproduct.last_page
                ) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Next</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link"  href="javascript:void(0)" onclick="getProduct(${id},${
                        result.itemwiseproduct.current_page + 1
                    })">Next</a>
                 </li>`;
                }

                paginationHTML += `</ul></div></nav>
                <nav class="small-devices_pagination d-none">
                    <div class="text-center">
                        <a class="btn btn-dark px-4 py-2" href="javascript:void(0)" onclick="getProduct(${id},${
                    result.itemwiseproduct.current_page + 1
                })">See More
                            Products</a>
                    </div>
                </nav></div>`;

                $("#pagination").append(paginationHTML);
            }
            qtyplusminus();
            $(".card-checkbox").click(function () {
                if ($(this).is(":checked")) {
                    $("#addalltocart").removeAttr("disabled");
                } else {
                    $("#addalltocart").attr("disabled", "disabled");
                }
            });

            // Add click event listener to wishlist-svg buttons
            const wishlistButtons = document.querySelectorAll(".wishlist-svg");

            wishlistButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    // Toggle the 'active' class to change the color on click
                    this.classList.toggle("active");
                });
            });

            if (isAnyCheckboxChecked) {
                updateWeightFilters(result.weightJson);
                updateMobileWeightFilters(result.weightJson);
                updateProCategoryFilters(result.procategoryjson);
                updateMobileProCategoryFilters(result.procategoryjson);
            } else {
                updateWeightFilters(result.defaultweightJson);
                updateMobileWeightFilters(result.defaultweightJson);
                updateProCategoryFilters(result.procategoryDefaultjson);
                updateMobileProCategoryFilters(result.procategoryDefaultjson);
            }
            loadSecureImages();
        },
    });
}

function getProCategory(id, page = 1) {
    $(".pagination-links").attr("hidden", true);
    var project_id = $("#decryptedProjectId").val();
    var weightfrom = document.getElementById("hdweightfrom").value;
    var weightto = document.getElementById("hdweightto").value;
    var product = $("#product").val();

    // Split the value into an array using the comma as a delimiter
    var weightfrom = weightfrom.split(",");
    var weightto = weightto.split(",");
    var productArray = product.split(",");

    var selectedprocategory = [];
    $(".procategory").each(function () {
        if (windowWidth > 300) {
            $("#pageloader").fadeIn();
        }
        if ($(this).is(":checked")) {
            selectedprocategory.push($(this).val());
        }
    });
    // Set the value of the hidden input field to the serialized string
    $("#procategory").val(selectedprocategory);

    $("#product_page").empty();
    $.ajax({
        type: "GET",
        url: "/retailer/procategorywiseproduct/" + id + "?page=" + page,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            selectedprocategory: selectedprocategory,
            project_id: project_id,
            weightfrom: weightfrom,
            weightto: weightto,
            productArray: productArray,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            // Check if any checkbox is checked
            let isAnyCheckboxChecked = $(".procategory:checked").length > 0;
            // Assign value to #subCollectionData based on the checkbox state
            if (isAnyCheckboxChecked) {
                $("#weights").val(JSON.stringify(result.weightJson));
            } else {
                $("#weights").val(JSON.stringify(result.defaultweightJson));
            }
            if (result.procategorywiseproduct.data.length == 0) {
                $("#checkboxhidden").attr("hidden", "");
                $("#addtocarthidden").attr("hidden", "");
                $("#product_page").attr("hidden", "");
                $("#notfound").empty();
                var notfound = `<img src='${baseurl}/emptycart.gif'>`;
                $("#notfound").append(notfound);
                if (windowWidth > 300) {
                    $("#pageloader").fadeOut();
                }
            } else {
                $("#checkboxhidden").removeAttr("hidden", "");
                $("#addtocarthidden").removeAttr("hidden", "");
                $("#product_page").removeAttr("hidden", "");
                $.each(
                    result.procategorywiseproduct.data,
                    function (key, value) {
                        $("#notfound").empty();
                        moqAvailabilityHTML = ` <div class="card-multiple-sizes-wrapper">

                                            <div class="d-flex mt-3">
                                                <div class="product-cart-qty-text">In Stock:
                                                    <span> ${
                                                        value.qty ?? "-"
                                                    } Pcs</span>
                                                </div>
                                            </div>
                                            </div>`;

                        var eid = $("#encrypt" + value.id).val();
                        var productDetailUrl =
                            "/retailer/productdetail/productId".replace(
                                "productId",
                                eid
                            );
                        var productHTML = `
                    <input type="hidden" name="weight${value.id}" id="weight${
                            value.id
                        }" value="${value.weight}">
                    <input type="hidden" name="size${value.id}" id="size${
                            value.id
                        }" value="${value.size}">
                    <input type="hidden" name="color${value.id}" id="color${
                            value.id
                        }" value="${value.color}">
                            <input type="hidden" name="box${value.id}" id="box${
                            value.id
                        }" value="${value.style}">
                    <div class="card shop-page_product-card">
                        <div class="card-checkbox_wrapper">
                            <input class="card-checkbox" type="checkbox" name="product${
                                value.id
                            }"
                                id="product${value.id}" data-id="${value.id}">
                        </div>
                        <div class="card-img-top d-flex align-items-center justify-content-center position-relative">
                            <a href="${productDetailUrl}">
                                <img class="img-fluid prouduct_card-image load-secure-image" width="255"
                                            height="255" src="http://imageurl.ejindia.com/api/image/secure"
                                            data-secure="${
                                                value.secureFilename
                                            }" alt>
                            </a>
                             <div class="position-absolute card-purity purity-list">
                                Purity: ${value.Purity}
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div
                                class="d-flex justify-content-between  align-items-center flex-wrap card-title_wrapper">
                              <div class="card-title"><a href="${productDetailUrl}">${
                            value.DesignNo
                        }</a> </div>
                                 
                                    <button class="ml-2 custom-icon-btn wishlist-svg ${
                                        value.is_favourite === 1 ? "active" : ""
                                    }"
                                    onclick="addtowishlist(${value.id})">
                                        <svg width="26" height="23" viewBox="0 0 26 23"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21.5109 13.0016L12.7523 21.8976L4.0016 13.0016C-3.73173 5.15359 5.0336 -3.73174 12.7603 4.11626C20.6003 -3.84641 29.3589 5.03893 21.5189 13.0123L21.5109 13.0016Z"
                                                stroke="inherit" stroke-width="1.5"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </button>
                            </div>
                                <input type="hidden" name="qty${value.id}"
                          id="qty${value.id}" value="${value.qty}">
        <div>

       <div class="mt-3 grid cols-3 card-content_wrapper">
                                            ${
                                                value.color
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">Colour</div>
                                                <div class="product-card-badge product-card-badge-light">
                                                    ${value.color ?? "-"}</div>
                                            </div>`
                                                    : ""
                                            }
                                             ${
                                                 value.unit
                                                     ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">Unit</div>
                                                <div class="product-card-badge product-card-badge-light">
                                                    ${value.unit ?? "-"}</div>
                                            </div>`
                                                     : ""
                                             }
                                            ${
                                                value.style
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">Style</div>
                                                <div class="product-card-badge product-card-badge-light">
                                                    ${value.style ?? "-"}</div>
                                            </div>`
                                                    : ""
                                            }
                                            ${
                                                value.making
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">Making %</div>
                                                <div class="product-card-badge">${
                                                    value.making ?? "-"
                                                }
                                                </div>
                                            </div>`
                                                    : ""
                                            }
                                            ${
                                                value.size
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">
                                                    Size
                                                </div>
                                                <div class="product-card-badge">${
                                                    value.size ?? "-"
                                                }
                                                </div>
                                            </div>`
                                                    : ""
                                            }
                                            ${
                                                value.weight
                                                    ? `
                                            <div class="d-flex flex-column gap-1">
                                                <div class="card-text text-dark">
                                                    Weight
                                                </div>
                                                <div class="product-card-badge">
                                                    ${
                                                        value.weight ?? "-"
                                                    }g</div>
                                            </div>`
                                                    : ""
                                            }
                                        </div>
             </div>
              <div class="d-flex flex-wrap gap-2 align-items-center">
                  ${moqAvailabilityHTML}
                  <div class="d-flex gap-2 align-items-center purity-inside-card">
                      <div class="card-text text-dark">
                          Purity
                      </div>
                      <div class="product-card-badge">${value.Purity}</div>
                  </div>
              </div>
                            <div class="mt-3 shop-page-qty-add-to-cart-btn_wrapper">
                                <div class="d-flex align-items-center">
                                    <label class="me-2">Qty</label>
                                    <div class="input-group quantity-input-group quantity-container"
                                        data-product-id=${value.id}>
                                        <input type="button" value="-" class="qtyminus"
                                            field="quantity"
                                           >
                                        <input type="text" name="quantity"
                                            id="quantity${value.id}" value="1"
                                            class="qty">
                                        <input type="button" value="+" class="qtyplus"
                                            field="quantity">
                                    </div>
                                </div>
                                <div class="shop-page-add-to-cart-btn">
                                <button onclick="addforcart(${
                                    value.id
                                })" data_id="card_id_${value.id}"
                                  class="btn ${
                                      result.cart[key] &&
                                      Array.isArray(result.cart[key]) &&
                                      result.cart[key].length
                                          ? "added-to-cart-btn"
                                          : "add-to-cart-btn"
                                  } mr-2 spinner-button">                                                            
                                  <span class="submit-text">${
                                      result.cart[key] &&
                                      Array.isArray(result.cart[key]) &&
                                      result.cart[key].length
                                          ? "Added To Cart"
                                          : "ADD TO CART"
                                  }</span>
                          <span class="d-none spinner">
                              <span class="spinner-grow spinner-grow-sm"
                                  aria-hidden="true"></span>
                              <span role="status">Adding...</span>
                          </span>
                          <span class="added-to-cart-badge ms-2">${
                              result.cartcount[key]
                          }</span>
                          </button>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
      `;
                        $("#product_page").append(productHTML);
                    }
                );
                $(".loader").fadeOut();
                if (windowWidth > 300) {
                    $("#pageloader").fadeOut();
                }
                $("#pagination").empty();
                // Append pagination links
                var paginationHTML = `<div class="my-5 pagination-links">
                <nav class="large-devices_pagination">
                    <div class="d-flex gap-3 flex-wrap justify-content-between">
                        <div>
                             Showing ${result.procategorywiseproduct.from} - ${result.procategorywiseproduct.to} of ${result.procategorywiseproduct.total} results
                         </div>
                         <ul class="pagination">`;

                if (result.procategorywiseproduct.current_page == 1) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Previous</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link" href="javascript:void(0)" onclick="getProduct(${id},${
                        result.procategorywiseproduct.current_page - 1
                    })" tabindex="-1">Previous</a>
                 </li>`;
                }

                for (
                    var page = Math.max(
                        1,
                        result.procategorywiseproduct.current_page - 2
                    );
                    page <=
                    Math.min(
                        result.procategorywiseproduct.last_page,
                        result.procategorywiseproduct.current_page + 2
                    );
                    page++
                ) {
                    if (page == result.procategorywiseproduct.current_page) {
                        paginationHTML += `<li class="page-item active">
                         <span class="page-link">${page}</span>
                     </li>`;
                    } else {
                        paginationHTML += `<li class="page-item">
                         <a class="page-link"  href="javascript:void(0)" onclick="getProduct(${id},${page})">${page}</a>
                     </li>`;
                    }
                }

                if (
                    result.procategorywiseproduct.current_page ==
                    result.procategorywiseproduct.last_page
                ) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Next</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link"  href="javascript:void(0)" onclick="getProduct(${id},${
                        result.procategorywiseproduct.current_page + 1
                    })">Next</a>
                 </li>`;
                }

                paginationHTML += `</ul></div></nav>
                <nav class="small-devices_pagination d-none">
                    <div class="text-center">
                        <a class="btn btn-dark px-4 py-2" href="javascript:void(0)" onclick="getProduct(${id},${
                    result.procategorywiseproduct.current_page + 1
                })">See More
                            Products</a>
                    </div>
                </nav></div>`;

                $("#pagination").append(paginationHTML);
            }
            qtyplusminus();
            $(".card-checkbox").click(function () {
                if ($(this).is(":checked")) {
                    $("#addalltocart").removeAttr("disabled");
                } else {
                    $("#addalltocart").attr("disabled", "disabled");
                }
            });

            // Add click event listener to wishlist-svg buttons
            const wishlistButtons = document.querySelectorAll(".wishlist-svg");

            wishlistButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    // Toggle the 'active' class to change the color on click
                    this.classList.toggle("active");
                });
            });
            if (isAnyCheckboxChecked) {
                updateWeightFilters(result.weightJson);
                updateMobileWeightFilters(result.weightJson);
            } else {
                updateWeightFilters(result.defaultweightJson);
                updateMobileWeightFilters(result.defaultweightJson);
            }
            loadSecureImages();
        },
    });
}

function updateWeightFilters(weights) {
    // Parse the JSON string into a JavaScript object
    var weights = JSON.parse(weights);

    var container = document.getElementById("weight-filters-container");
    container.innerHTML = ""; // Clear existing filters if any

    weights.forEach(function (weight, key) {
        var label = "";

        if (
            weight.weight_range_from === 20 &&
            weight.weight_range_to === 200000
        ) {
            label = "Above 20grams";
        } else if (Number.isInteger(weight.weight_range_from)) {
            label =
                weight.weight_range_from +
                " - " +
                weight.weight_range_to +
                "gms";
        } else {
            label =
                weight.weight_range_from +
                " - " +
                weight.weight_range_to +
                "gms";
        }

        var filterHtml = `
                <div class="form-check">
                    <input class="form-check-input weight_filter" type="checkbox"
                        id="weightfrom${weight.id}" name="weightfrom"
                        data-id="${weight.id}" value="${weight.weight_range_from}"
                        onclick="getWeightRange(${weight.id})">
                    <input class="weight_filter" type="hidden" name="weightto"
                        id="weightto${weight.id}" value="${weight.weight_range_to}">
                    <label class="form-check-label" for="weightfrom${weight.id}">
                        ${label}
                    </label>
                </div>
            `;
        container.insertAdjacentHTML("beforeend", filterHtml);
    });
}

function updateMobileWeightFilters(data) {
    // console.log("updated mobile weights", data);
    var weights = JSON.parse(data);
    const container = document.getElementById("mobile-weight-filters");

    container.innerHTML = "";
    weights.forEach(function (weight, key) {
        if (
            weight.weight_range_from === 20 &&
            weight.weight_range_to === 200000
        ) {
            label = "Above 20grams";
        } else if (Number.isInteger(weight.weight_range_from)) {
            label =
                weight.weight_range_from +
                " - " +
                weight.weight_range_to +
                "gms";
        } else {
            label =
                weight.weight_range_from +
                " - " +
                weight.weight_range_to +
                "gms";
        }

        var filterHtml = `
                <div class="form-check">
                    <input class="form-check-input weight_filter" type="checkbox"
                        id="weightfrommob${weight.id}" name="weightfrom"
                        data-id="${weight.id}" value="${weight.weight_range_from}"
                        onclick="getWeightRange(${weight.id})">
                    <input class="weight_filter" type="hidden" name="weightto"
                        id="weighttomob${weight.id}" value="${weight.weight_range_to}">
                    <label class="form-check-label" for="weightfrommob${weight.id}">
                        ${label}
                    </label>
                </div>
            `;
        container.insertAdjacentHTML("beforeend", filterHtml);
    });
}

function updateProductFilters(productsData) {
    let products = JSON.parse(productsData);
    let container = document.getElementById("product-filter");
    if (container) {
        container.innerHTML = ""; // Clear existing filters if any
        products.forEach(function (product) {
            var filterHtml = `
    <div class="form-check">
    
    <input class="product form-check-input" type="checkbox"
    id="product${product.id}" name="product" data-id="${product.id}"
    value="${product.Item}" onclick="getProduct(${product.id})">
    <label class="form-check-label" for="product${product.id}">
    ${product.Item}
    </label>
    
        </div>
        `;
            container.insertAdjacentHTML("beforeend", filterHtml);
        });
    }
}

function updateMobileProductFilters(productsData) {
    let products = JSON.parse(productsData);

    let container = document.getElementById("mobile-product-filters");
    container.innerHTML = ""; // Clear existing filters if any

    products.forEach(function (product) {
        let filterHtml = `
        <div class="form-check d-flex justify-content-between gap-2">
            <div>
                <input class="product form-check-input" type="checkbox"
                    id="product${product.id}-mob" name="product" data-id="${product.id}"
                    value="${product.Item}" onclick="getproductProduct(${product.id})">
                <label class="form-check-label" for="product${product.id}-mob">
                    ${product.Item}
                </label>
            </div>
        </div>
    `;
        container.insertAdjacentHTML("beforeend", filterHtml);
    });
}

function updateProCategoryFilters(procategorysData) {
    let procategorys = JSON.parse(procategorysData);
    let container = document.getElementById("procategory-filters-container");
    if (container) {
        container.innerHTML = ""; // Clear existing filters if any
        procategorys.forEach(function (procat) {
            var filterHtml = `
    <div class="form-check">
    
    <input class="procategory form-check-input" type="checkbox"
    id="procategory${procat.id}" name="procategory" data-id="${procat.id}"
    value="${procat.Procatgory}" onclick="getProCategory(${procat.id})">
    <label class="form-check-label" for="procategory${procat.id}">
    ${procat.Procatgory}
    </label>
    
        </div>
        `;
            container.insertAdjacentHTML("beforeend", filterHtml);
        });
    }
}

function updateMobileProCategoryFilters(procategorysData) {
    let procategorys = JSON.parse(procategorysData);

    let container = document.getElementById("mobile-procategory-filters");
    container.innerHTML = ""; // Clear existing filters if any

    procategorys.forEach(function (procat) {
        let filterHtml = `
        <div class="form-check d-flex justify-content-between gap-2">
            <div>
                <input class="procategory form-check-input" type="checkbox"
                    id="procategory${procat.id}-mob" name="procategory" data-id="${procat.id}"
                    value="${procat.Procatgory}" onclick="getProCategory(${procat.id})">
                <label class="form-check-label" for="procategory${procat.id}-mob">
                    ${procat.Procatgory}
                </label>
            </div>
        </div>
    `;
        container.insertAdjacentHTML("beforeend", filterHtml);
    });
}

function clearFilters() {
    $("input[type='checkbox']").prop("checked", false);
    window.location.reload();
}

function appendWeightFilters() {
    let weights = JSON.parse($("#weights").val());
    var container = document.getElementById("weight-filters-container");
    container.innerHTML = ""; // Clear existing filters if any

    weights?.forEach(function (weight, key) {
        var label = "";

        if (
            weight.weight_range_from === 20 &&
            weight.weight_range_to === 200000
        ) {
            label = "Above 20grams";
        } else if (Number.isInteger(weight.weight_range_from)) {
            label =
                weight.weight_range_from +
                " - " +
                weight.weight_range_to +
                "gms";
        } else {
            label =
                weight.weight_range_from +
                " - " +
                weight.weight_range_to +
                "gms";
        }

        var filterHtml = `
                <div class="form-check">
                    <input class="form-check-input weight_filter" type="checkbox"
                        id="weightfrom${weight.id}" name="weightfrom"
                        data-id="${weight.id}" value="${weight.weight_range_from}"
                        onclick="getWeightRange(${weight.id})">
                    <input class="weight_filter" type="hidden" name="weightto"
                        id="weightto${weight.id}" value="${weight.weight_range_to}">
                    <label class="form-check-label" for="weightfrom${weight.id}">
                        ${label}
                    </label>
                </div>
            `;
        container.insertAdjacentHTML("beforeend", filterHtml);
    });
}

function appendProductFilters() {
    let products = JSON.parse($("#productFilter").val());

    let container = document.getElementById("product-filter");
    if (container) {
        container.innerHTML = ""; // Clear existing filters if any

        products.forEach(function (product) {
            // Remove "SIL-" prefix if present
            let productabel = product.Item;

            var filterHtml = `
        <div class="form-check">
  
                <input class="product form-check-input" type="checkbox"
                    id="product${product.id}" name="product" data-id="${product.id}"
                    value="${productabel}" onclick="getProduct(${product.id})">
                <label class="form-check-label" for="product${product.id}">
                    ${productabel}
                </label>
 
        </div>
    `;
            container.insertAdjacentHTML("beforeend", filterHtml);
        });
    }
}

function appendProCategoryFilters() {
    let procategorys = JSON.parse($("#procategoryFilter").val());

    let container = document.getElementById("procategory-filters-container");
    if (container) {
        container.innerHTML = ""; // Clear existing filters if any

        procategorys.forEach(function (procategory) {
            // Use the correct spelling from JSON
            let procategorylabel = procategory.Procatgory;

            var filterHtml = `
                <div class="form-check">
                    <input class="procategory form-check-input" type="checkbox"
                        id="procategory${procategory.id}" name="procategory" data-id="${procategory.id}"
                        value="${procategorylabel}" onclick="getProCategory(${procategory.id})">
                    <label class="form-check-label" for="procategory${procategory.id}">
                        ${procategorylabel}
                    </label>
                </div>
            `;
            container.insertAdjacentHTML("beforeend", filterHtml);
        });
    }
}

$(document).ready(function () {
    // Call the function to append the filters
    appendProCategoryFilters();
    appendProductFilters();
    appendWeightFilters();
});

async function loadSecureImages() {
    try {
        const res = await fetch("/retailer/proxy/token");
        const data = await res.json();
        const token = data.token;

        if (!token) {
            throw new Error("Token not received from /retailer/proxy/token");
        }

        const secureImages = document.querySelectorAll(".load-secure-image");

        secureImages.forEach(async (img) => {
            const secureFilename = img.dataset.secure;

            try {
                const imageRes = await fetch("/retailer/proxy/secure-image", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `${token}`,
                    },
                    body: JSON.stringify({
                        secureFilename,
                    }),
                });

                if (!imageRes.ok) {
                    throw new Error(
                        `Failed to fetch image for ${secureFilename}`
                    );
                }

                const blob = await imageRes.blob();
                const imageUrl = URL.createObjectURL(blob);
                img.src = imageUrl;
            } catch (error) {
                console.error("Image load failed:", error);
                img.alt = "Image load failed";
            }
        });
    } catch (err) {
        console.error("Token fetch failed:", err);
    }
}

function clearAllSelectedInputs() {
    // Optionally, you can reload the page to reset everything
    window.location.reload();
}
