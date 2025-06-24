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
        var moq = $("#moq" + productId).val();
        var qty = $("#qty" + productId).val();
        var stock = $("#stockqty").val();

        container.find(".qtyplus").click(function (e) {
            e.preventDefault();
            var currentVal = parseInt(qtyInput.val());
            if (!isNaN(currentVal)) {
                if (stock == 1 && currentVal >= qty) {
                    qtyInput.val(qty);
                    container.find(".qtyplus").css("color", "red");
                } else {
                    qtyInput.val(currentVal + 1);
                    container.find(".qtyminus").css("color", "black");
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

function getCollectionWiseProducts(id, page = 1) {
    $(".pagination-links").attr("hidden", true);
    var category_id = $("#decryptedCategoryId").val();
    var project_id = $("#decryptedProjectId").val();
    var subcollection_id = $("#subcol").val();
    var weightfrom = document.getElementById("hdweightfrom").value;
    var weightto = document.getElementById("hdweightto").value;

    // Split the value into an array using the comma as a delimiter
    var weightfrom = weightfrom.split(",");
    var weightto = weightto.split(",");

    var stockid = JSON.parse(document.getElementById("stock").value);
    var selectedcollection = [];
    // Iterate over all checkboxes with the class 'platingfilter'
    $(".others").each(function () {
        if (windowWidth > 300) {
            $("#pageloader").fadeIn();
        }
        // Check if the checkbox is checked
        if ($(this).is(":checked")) {
            // Add the value to the selectedplating array
            selectedcollection.push($(this).val());
        }
    });

    // Serialize the array into a string separated by a delimiter (comma)
    var selectedcollectionString = selectedcollection.join(",");
    // Set the value of the hidden input field to the serialized string
    $("#col").val(selectedcollectionString);

    // To retrieve the array back from the string later:
    // Retrieve the value of the hidden input field
    var selectedcollectionString = $("#col").val();

    // Split the string into an array using the delimiter (comma)
    var selectedcollection = selectedcollectionString.split(",");
    $("#product_page").empty();
    $.ajax({
        type: "GET",
        url: "collectionwiseproduct/" + id + "?page=" + page,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            selectedcollection: selectedcollection,
            category_id: category_id,
            subcollection_id: subcollection_id,
            project_id: project_id,
            weightfrom: weightfrom,
            weightto: weightto,
            stockid: stockid,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (data) {
            // Check if any checkbox is checked
            let isAnyCheckboxChecked = $(".others:checked").length > 0;
            // Assign value to #subCollectionData based on the checkbox state
            if (isAnyCheckboxChecked) {
                $("#weights").val(JSON.stringify(data.weightJson));
            } else {
                $("#weights").val(JSON.stringify(data.defaultweightJson));
            }
            if (data.collectionwiseproduct.data.length == 0) {
                $("#notfound").empty();
                $("#checkboxhidden").attr("hidden", "");
                $("#addtocarthidden").attr("hidden", "");
                $("#product_page").attr("hidden", "");
                var notfound = `<img src='${baseurl}/emptycart.gif'>`;
                $("#notfound").append(notfound);
                if (windowWidth > 300) {
                    $("#pageloader").fadeOut();
                }
            } else {
                $("#checkboxhidden").removeAttr("hidden", "");
                $("#addtocarthidden").removeAttr("hidden", "");
                $("#product_page").removeAttr("hidden", "");
                $.each(data.collectionwiseproduct.data, function (key, value) {
                    $("#notfound").empty();
                    if (data.stock == 1) {
                        moqAvailabilityHTML = `<div class="product-cart-qty-text mt-2">In Stock: <span class="fw-semibold" style="font-size:10px;">${value.qty} pcs</span></div>`;
                    } else {
                        moqAvailabilityHTML = `<div class="card-text mt-2">MOQ : ${value.moq} pcs</div>`;
                    }
                    mc = `
                            <div class="d-flex mt-2 flex-wrap gap-2 align-items-center justify-content-between">
                                <div class="text-success">Tag Code: 
                                    <span class="fw-semibold">${
                                        data.mc_charge[key]
                                    }</span>
                                </div>
                                ${
                                    data.stock == 1
                                        ? `<div class="d-flex my-2 flex-wrap gap-2 align-items-center justify-content-between">
                                                <div class="card-text shop-page-card__select-option">
                                                    <span style="font-weight: bold;" class="text-green">
                                                        ${
                                                            value.project_id !=
                                                            4
                                                                ? "Box: "
                                                                : "Style: "
                                                        }${data.box[key]}
                                                    </span>
                                                </div>
                                        </div>`
                                        : ""
                                }
                            </div>
                        `;
                    var eid = $("#encrypt" + value.id).val();
                    var productDetailUrl = "productdetail/productId".replace(
                        "productId",
                        eid
                    );
                    var productHTML = `
                                          <input type="hidden" name="weight${
                                              value.id
                                          }" id="weight${value.id}"
                                              value="${value.weight}">
                                              <input type="hidden" name="finish${
                                                  value.id
                                              }" id="finish${value.id}"
                                                  value="${value.finish_id}">
                                          <input type="hidden" name="size${
                                              value.id
                                          }" id="size${value.id}"
                                              value="${value.size_id}">
                                          <input type="hidden" name="plating${
                                              value.id
                                          }" id="plating${value.id}"
                                              value="${value.platin4g_id}">
                                          <input type="hidden" name="color${
                                              value.id
                                          }" id="color${value.id}"
                                              value="${value.color_id}">
                                              <input type="hidden" name="stock${
                                                  value.id
                                              }" id="stock${value.id}"
                                                  value="${stockid}">
                                                  <input type="hidden" name="box${
                                                      value.id
                                                  }" id="box${value.id}"
                        value="${value.style_id}">
                                          <div class="card shop-page_product-card">
                                              <div class="card-checkbox_wrapper">
                                                  <input class="card-checkbox" type="checkbox" name="product${
                                                      value.id
                                                  }"
                                                      id="product${
                                                          value.id
                                                      }" data-id="${value.id}">
                                              </div>
                                              <div class="card-img-top d-flex align-items-center justify-content-center">
                                                  <a href="${productDetailUrl}">
                                                      <img class="img-fluid prouduct_card-image" width="154" height="160"
                                                          src="${baseurl}/${
                        "upload/product/" + value.product_image
                    }" alt>
                                                  </a>
                                              </div>
                                              <div class="card-body d-flex flex-column justify-content-between">
                                                  <div
                                                      class="d-flex justify-content-between  align-items-center flex-wrap card-title_wrapper">
                                                    <div class="card-title"><a href="${productDetailUrl}">${
                        value.product_unique_id
                    }</a> </div>
                                                          <div class="card-text">${
                                                              value.weight
                                                          }g</div>
                                                          <button class="ml-2 custom-icon-btn wishlist-svg ${
                                                              value.is_favourite ===
                                                              1
                                                                  ? "active"
                                                                  : ""
                                                          }"
                                                          onclick="addtowishlist(${
                                                              value.id
                                                          })">
                                                              <svg width="26" height="23" viewBox="0 0 26 23"
                                                                  fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                  <path
                                                                      d="M21.5109 13.0016L12.7523 21.8976L4.0016 13.0016C-3.73173 5.15359 5.0336 -3.73174 12.7603 4.11626C20.6003 -3.84641 29.3589 5.03893 21.5189 13.0123L21.5109 13.0016Z"
                                                                      stroke="#F78D1E" stroke-width="1.5"
                                                                      stroke-linejoin="round" />
                                                              </svg>
                                                          </button>
                                                  </div>
                                                  <input type="hidden" name="moq${
                                                      value.id
                                                  }"
                                                      id="moq${
                                                          value.id
                                                      }" value="${value.moq}">
                                                      <input type="hidden" name="qty${
                                                          value.id
                                                      }"
                                                id="qty${value.id}" value="${
                        value.qty
                    }">
                                                <input type="hidden" name="stockqty"
                                                id="stockqty" value="${stockid}">
                              <div>
                            ${mc}
                                        ${moqAvailabilityHTML}
                                                  <div class="mt-3 shop-page-qty-add-to-cart-btn_wrapper">
                                                      <div class="d-flex align-items-center">
                                                          <label class="me-2">Qty</label>
                                                          <div class="input-group quantity-input-group quantity-container"
                                                              data-product-id=${
                                                                  value.id
                                                              }>
                                                              <input type="button" value="-" class="qtyminus"
                                                                  field="quantity"
                                                                 >
                                                              <input type="text" name="quantity"
                                                                  id="quantity${
                                                                      value.id
                                                                  }" value="${
                        value.moq
                    }"
                                                                  class="qty">
                                                              <input type="button" value="+" class="qtyplus"
                                                                  field="quantity">
                                                          </div>
                                                      </div>
                                                      <div class="mt-3">
                                                      <button onclick="addforcart(${
                                                          value.id
                                                      })" data_id="card_id_${
                        value.id
                    }"
                                                      class="btn add-to-cart-btn mr-2 spinner-button">                                                            <span>ADD TO CART</span>
                                                      <span class="d-none spinner">
                                                          <span class="spinner-grow spinner-grow-sm"
                                                              aria-hidden="true"></span>
                                                          <span role="status">Adding...</span>
                                                      </span></button>
                                                  </div>
                                                  </div>
                                                  </div>
                                              </div>
                                          </div>
                            `;
                    $("#product_page").append(productHTML);
                });
                if (windowWidth > 300) {
                    $("#pageloader").fadeOut();
                }
                $("#pagination").empty();
                // Append pagination links
                var paginationHTML = `<div class="my-5 pagination-links">
                          <nav class="large-devices_pagination">
                              <div class="d-flex gap-3 flex-wrap justify-content-between">
                                  <div>
                                       Showing ${data.collectionwiseproduct.from} - ${data.collectionwiseproduct.to} of ${data.collectionwiseproduct.total} results
                                   </div>
                                   <ul class="pagination">`;

                if (data.collectionwiseproduct.current_page == 1) {
                    paginationHTML += `<li class="page-item disabled">
                               <span class="page-link">Previous</span>
                           </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                               <a class="page-link" href="javascript:void(0)" onclick="getCollectionWiseProducts(${id}, ${
                        data.collectionwiseproduct.current_page - 1
                    })" tabindex="-1">Previous</a>
                           </li>`;
                }
                $("#pageloader").fadeOut();

                for (
                    var page = Math.max(
                        1,
                        data.collectionwiseproduct.current_page - 2
                    );
                    page <=
                    Math.min(
                        data.collectionwiseproduct.last_page,
                        data.collectionwiseproduct.current_page + 2
                    );
                    page++
                ) {
                    if (page == data.collectionwiseproduct.current_page) {
                        paginationHTML += `<li class="page-item active">
                                   <span class="page-link">${page}</span>
                               </li>`;
                    } else {
                        paginationHTML += `<li class="page-item">
                                   <a class="page-link"  href="javascript:void(0)" onclick="getCollectionWiseProducts(${id}, ${page})">${page}</a>
                               </li>`;
                    }
                }

                if (
                    data.collectionwiseproduct.current_page ==
                    data.collectionwiseproduct.last_page
                ) {
                    paginationHTML += `<li class="page-item disabled">
                               <span class="page-link">Next</span>
                           </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                               <a class="page-link"  href="javascript:void(0)" onclick="getCollectionWiseProducts(${id}, ${
                        data.collectionwiseproduct.current_page + 1
                    })">Next</a>
                           </li>`;
                }

                paginationHTML += `</ul></div></nav>
                          <nav class="small-devices_pagination d-none">
                              <div class="text-center">
                                  <a class="btn btn-dark px-4 py-2" href="javascript:void(0)" onclick="getCollectionWiseProducts(${id}, ${
                    data.collectionwiseproduct.current_page + 1
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
                updateWeightFilters(data.weightJson);
                updateMobileWeightFilters(data.weightJson);
            } else {
                updateWeightFilters(data.defaultweightJson);
                updateMobileWeightFilters(data.defaultweightJson);
            }
        },
    });
    var collectionwiseproduct = document.querySelectorAll(".others:checked");
    if (collectionwiseproduct.length > 0) {
        const checkboxes = document.querySelectorAll(".subcollection_filter");
        checkboxes.forEach((checkbox) => {
            checkbox.disabled = true;
        });
    } else {
        const checkboxes = document.querySelectorAll(".subcollection_filter");
        checkboxes.forEach((checkbox) => {
            checkbox.disabled = false;
        });
    }
}

function getWeightRange(id, page = 1) {
    // Get the value from the hidden input field
    var subcolValue = $("#subcol").val();
    console.log("subcol Value", subcolValue);
    var calssValue = $("#class").val();
    console.log("class Value", calssValue);
    var catValue = $("#jewcat").val();
    console.log("jewcat Value", catValue);

    var collectionValue = document.getElementById("col").value;
    // Split the value into an array using the comma as a delimiter
    var subcolArray = subcolValue.split(",");
    var colArray = collectionValue.split(",");
    var classArray = calssValue.split(",");
    var jewArray = catValue.split(",");

    $(".pagination-links").attr("hidden", true);
    var category_id = $("#decryptedCategoryId").val();
    var project_id = $("#decryptedProjectId").val();
    var subcategory_id = $("#decryptedSubCategoryId").val();
    var stockid = JSON.parse(document.getElementById("stock").value);
    console.log(stockid);
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
        url: "weightrange/" + id + "?page=" + page,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            selectedWeightRanges: selectedWeightRanges,
            colArray: colArray,
            classArray: classArray,
            jewArray: jewArray,
            weightToArray: weightToArray,
            category_id: category_id,
            subcategory_id: subcategory_id,
            project_id: project_id,
            subcolArray: subcolArray,
            stockid: stockid,
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
                $("#classification").val(
                    JSON.stringify(result.classificationsjson)
                );
                $("#categoryFilter").val(JSON.stringify(result.categoryjson));
            } else {
                $("#subCollectionData").val(
                    JSON.stringify(result.subcollectionsDefaultjson)
                );
                $("#classification").val(
                    JSON.stringify(result.classificationsDefaultjson)
                );
                $("#categoryFilter").val(
                    JSON.stringify(result.categoryDefaultjson)
                );
            }
            if (result.weightrange.data.length == 0) {
                $("#checkboxhidden").attr("hidden", "");
                $("#addtocarthidden").attr("hidden", "");
                $("#product_page").attr("hidden", "");
                $("#notfound").empty();
                var notfound = `<img class="img-fluid" src='${baseurl}/emptycart.gif'">`;
                $("#notfound").append(notfound);
                if (windowWidth > 300) {
                    $("#pageloader").fadeOut();
                }
            } else {
                $("#checkboxhidden").removeAttr("hidden", "");
                $("#addtocarthidden").removeAttr("hidden", "");
                $("#product_page").removeAttr("hidden", "");
                $.each(result.weightrange.data, function (key, value) {
                    if (result.stock == 1 && value.qty != 0) {
                        moqAvailabilityHTML = `<div class="product-cart-qty-text mt-2">In Stock: <span class="fw-semibold" style="font-size:10px;">${value.qty} pcs</span></div>`;
                    } else {
                        moqAvailabilityHTML = `<div class="card-text mt-2">MOQ : ${value.moq} pcs</div>`;
                    }
                    mc = `
                            <div class="d-flex mt-2 flex-wrap gap-2 align-items-center justify-content-between">
                                <div class="text-success">Tag Code: 
                                    <span class="fw-semibold">${
                                        result.mc_charge[key]
                                    }</span>
                                </div>
                                ${
                                    result.stock == 1
                                        ? `<div class="d-flex my-2 flex-wrap gap-2 align-items-center justify-content-between">
                                                <div class="card-text shop-page-card__select-option">
                                                    <span style="font-weight: bold;" class="text-green">
                                                        ${
                                                            value.project_id !=
                                                            4
                                                                ? "Box: "
                                                                : "Style: "
                                                        }${result.box[key]}
                                                    </span>
                                                </div>
                                        </div>`
                                        : ""
                                }
                            </div>
                        `;
                    $("#notfound").empty();
                    var eid = $("#encrypt" + value.id).val();

                    var productDetailUrl = "productdetail/productId".replace(
                        "productId",
                        eid
                    );
                    var productHTML = `
                        <div class="card shop-page_product-card">
                        <input type="hidden" name="weight${
                            value.id
                        }" id="weight${value.id}"
                        value="${value.weight}">
                        <input type="hidden" name="finish${
                            value.id
                        }" id="finish${value.id}"
                        value="${value.finish_id}">
                        <input type="hidden" name="size${value.id}" id="size${
                        value.id
                    }"
                                value="${value.size_id}">
                                <input type="hidden" name="plating${
                                    value.id
                                }" id="plating${value.id}"
                                value="${value.plating_id}">
                                <input type="hidden" name="color${
                                    value.id
                                }" id="color${value.id}"
                                value="${value.color_id}">
                                <input type="hidden" name="stock${
                                    value.id
                                }" id="stock${value.id}"
                                    value="${stockid}">
                                    <input type="hidden" name="box${
                                        value.id
                                    }" id="box${value.id}"
                        value="${value.style_id}">

                                <div class="card-checkbox_wrapper">
                                <input class="card-checkbox" type="checkbox" name="product${
                                    value.id
                                }"
                                id="product${value.id}" data-id="${value.id}">
                                </div>
                                <div class="card-img-top d-flex align-items-center justify-content-center">
                                <a href="${productDetailUrl}">
                                <img class="img-fluid prouduct_card-image" width="154" height="160"
                                src="${baseurl}/${
                        "upload/product/" + value.product_image
                    }" alt>
                                </a>
                                </div>
                                <div class="card-body d-flex flex-column justify-content-between">
                               
                                <div
                                            class="d-flex justify-content-between  align-items-center  card-title_wrapper">
                                            <div class="card-title">${
                                                value.product_unique_id
                                            } </div>                                           
                                            ${
                                                value.weight
                                                    ? `<div class="card-text">${value.weight}g</div>`
                                                    : ""
                                            }
                                            <button class="ml-2 custom-icon-btn wishlist-svg ${
                                                value.is_favourite === 1
                                                    ? "active"
                                                    : ""
                                            }"
                                            onclick="addtowishlist(${
                                                value.id
                                            })">
                                                    <svg width="26" height="23" viewBox="0 0 26 23"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                        d="M21.5109 13.0016L12.7523 21.8976L4.0016 13.0016C-3.73173 5.15359 5.0336 -3.73174 12.7603 4.11626C20.6003 -3.84641 29.3589 5.03893 21.5189 13.0123L21.5109 13.0016Z"
                                                        stroke="#F78D1E" stroke-width="1.5"
                                                        stroke-linejoin="round" />
                                                        </svg>
                                                        </button>
                                                        </div>
                                                        <input type="hidden" name="moq${
                                                            value.id
                                                        }"
                                            id="moq${value.id}" value="${
                        value.moq
                    }">
          <input type="hidden" name="qty${value.id}"
                                                id="qty${value.id}" value="${
                        value.qty
                    }">
                                                <input type="hidden" name="stockqty"
                                                id="stockqty" value="${stockid}">
                    <div>
                    ${mc}
                                        ${moqAvailabilityHTML}
                                            <div class="mt-3 shop-page-qty-add-to-cart-btn_wrapper">
                                            <div class="d-flex align-items-center">
                                            <label class="me-2">Qty</label>
                                            <div class="input-group quantity-input-group quantity-container"
                                            data-product-id=${value.id}>
                                            <input type="button" value="-" class="qtyminus"
                                            field="quantity"
                                            >
                                            <input type="text" name="quantity"
                                            id="quantity${value.id}" value="${
                        value.moq
                    }"
                    
                                                        class="qty">
                                                        <input type="button" value="+" class="qtyplus"
                                                        field="quantity">
                                                        </div>
                                                        </div>
                                                        <div class="mt-3">
                                                        <button onclick="addforcart(${
                                                            value.id
                                                        })" data_id="card_id_${
                        value.id
                    }"
                                                        class="btn add-to-cart-btn mr-2 spinner-button">                                                            <span>ADD TO CART</span>
                                                <span class="d-none spinner">
                                                    <span class="spinner-grow spinner-grow-sm"
                                                        aria-hidden="true"></span>
                                                    <span role="status">Adding...</span>
                                                </span></button>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        `;
                    $("#product_page").append(productHTML);
                });
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
                     <a class="page-link" href="javascript:void(0)" onclick="getWeightRange(${id}, ${
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
                            <a class="page-link"  href="javascript:void(0)" onclick="getWeightRange(${id}, ${page})">${page}</a>
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
                            <a class="page-link"  href="javascript:void(0)" onclick="getWeightRange(${id}, ${
                        result.weightrange.current_page + 1
                    })">Next</a>
                            </li>`;
                }

                paginationHTML += `</ul></div></nav>
                        <nav class="small-devices_pagination d-none">
                        <div class="text-center">
                        <a class="btn btn-dark px-4 py-2" href="javascript:void(0)" onclick="getWeightRange(${id}, ${
                    result.weightrange.current_page + 1
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
            var weightlength = document.querySelectorAll(
                ".weight_filter:checked"
            );
            var otherlength = document.querySelectorAll(".others:checked");
            console.log("otherlength", otherlength);
            // var subcollectionlength = document.querySelectorAll('.subcollection_filter:checked');
            // if (subcollectionlength.length > 0 ) {
            //     const checkboxes = document.querySelectorAll('[name="other"]');
            //     checkboxes.forEach(checkbox => {
            //     checkbox.disabled = true;
            //     });
            // }
            // else{
            //     const checkboxes = document.querySelectorAll('[name="other"]');
            //     checkboxes.forEach(checkbox => {
            //     checkbox.disabled = false;
            //     });
            // }

            if (otherlength.length == 0) {
                if (isAnyCheckboxChecked) {
                    updateSubCollections(result.subcollectionsjson);
                    updateMobileSubColFilters(result.subcollectionsjson);
                    updateCategoryFilters(result.categoryjson);
                    updateMobileCategoryFilters(result.categoryjson);
                } else {
                    updateSubCollections(result.subcollectionsDefaultjson);
                    updateMobileSubColFilters(result.subcollectionsDefaultjson);
                    updateCategoryFilters(result.categoryDefaultjson);
                    updateMobileCategoryFilters(result.categoryDefaultjson);
                }
            }
        },
    });
}

function getsubcollectionproduct(id, page = 1) {
    $(".pagination-links").attr("hidden", true);
    var category_id = $("#decryptedCategoryId").val();
    var project_id = $("#decryptedProjectId").val();
    var classification_id = $("#class").val();
    // var weightfrom = $("#hdweightfrom").val();
    // var weightto = $("#hdweightto").val();
    // Get the value from the hidden input field
    var weightfrom = document.getElementById("hdweightfrom").value;
    var weightto = document.getElementById("hdweightto").value;

    // Split the value into an array using the comma as a delimiter
    var weightfrom = weightfrom.split(",");
    var weightto = weightto.split(",");

    var stockid = JSON.parse(document.getElementById("stock").value);

    var selectedsubcollection = [];
    // Iterate over all checkboxes with the class 'platingfilter'
    $(".subcollection_filter").each(function () {
        if (windowWidth > 300) {
            $("#pageloader").fadeIn();
        }
        // Check if the checkbox is checked
        if ($(this).is(":checked")) {
            // Add the value to the selectedplating array
            selectedsubcollection.push($(this).val());
        }
    });

    // Serialize the array into a string separated by a delimiter (comma)
    var selectedsubcollectionString = selectedsubcollection.join(",");

    // Set the value of the hidden input field to the serialized string
    $("#subcol").val(selectedsubcollectionString);

    // To retrieve the array back from the string later:
    // Retrieve the value of the hidden input field
    var selectedsubcollectionString = $("#subcol").val();

    // Split the string into an array using the delimiter (comma)
    var selectedsubcollection = selectedsubcollectionString.split(",");
    $("#product_page").empty();
    $.ajax({
        type: "GET",
        url: "subcollectionwiseproduct/" + id + "?page=" + page,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            selectedsubcollection: selectedsubcollection,
            category_id: category_id,
            classification_id: classification_id,
            project_id: project_id,
            weightfrom: weightfrom,
            weightto: weightto,
            stockid: stockid,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            // Check if any checkbox is checked
            let isAnyCheckboxChecked =
                $(".subcollection_filter:checked").length > 0;
            // Assign value to #subCollectionData based on the checkbox state
            if (isAnyCheckboxChecked) {
                $("#weights").val(JSON.stringify(result.weightJson));
                $("#classification").val(
                    JSON.stringify(result.classificationsjson)
                );
            } else {
                $("#weights").val(JSON.stringify(result.defaultweightJson));
                $("#classification").val(
                    JSON.stringify(result.classificationsDefaultjson)
                );
            }
            if (result.subcollectionwiseproduct.data.length == 0) {
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
                    result.subcollectionwiseproduct.data,
                    function (key, value) {
                        $("#notfound").empty();
                        if (result.stock == 1 && value.qty != 0) {
                            moqAvailabilityHTML = `<div class="product-cart-qty-text mt-2">In Stock: <span class="fw-semibold" style="font-size:10px;">${value.qty} pcs</span></div>`;
                        } else {
                            moqAvailabilityHTML = `<div class="card-text mt-2">MOQ : ${value.moq} pcs</div>`;
                        }
                        mc = `
                            <div class="d-flex mt-2 flex-wrap gap-2 align-items-center justify-content-between">
                                <div class="text-success">Tag Code: 
                                    <span class="fw-semibold">${
                                        result.mc_charge[key]
                                    }</span>
                                </div>
                                ${
                                    result.stock == 1
                                        ? `<div class="d-flex my-2 flex-wrap gap-2 align-items-center justify-content-between">
                                                <div class="card-text shop-page-card__select-option">
                                                    <span style="font-weight: bold;" class="text-green">
                                                        ${
                                                            value.project_id !=
                                                            4
                                                                ? "Box: "
                                                                : "Style: "
                                                        }${result.box[key]}
                                                    </span>
                                                </div>
                                        </div>`
                                        : ""
                                }
                            </div>
                        `;
                        var eid = $("#encrypt" + value.id).val();
                        var productDetailUrl =
                            "productdetail/productId".replace("productId", eid);
                        var productHTML = `
                                <input type="hidden" name="weight${
                                    value.id
                                }" id="weight${value.id}"
                                    value="${value.weight}">
                                    <input type="hidden" name="finish${
                                        value.id
                                    }" id="finish${value.id}"
                                        value="${value.finish_id}">
                                <input type="hidden" name="size${
                                    value.id
                                }" id="size${value.id}"
                                    value="${value.size_id}">
                                <input type="hidden" name="plating${
                                    value.id
                                }" id="plating${value.id}"
                                    value="${value.plating_id}">
                                <input type="hidden" name="color${
                                    value.id
                                }" id="color${value.id}"
                                    value="${value.color_id}">
                                    <input type="hidden" name="stock${
                                        value.id
                                    }" id="stock${value.id}"
                                        value="${stockid}">
                                        <input type="hidden" name="box${
                                            value.id
                                        }" id="box${value.id}"
                        value="${value.style_id}">
                                <div class="card shop-page_product-card">
                                    <div class="card-checkbox_wrapper">
                                        <input class="card-checkbox" type="checkbox" name="product${
                                            value.id
                                        }"
                                            id="product${value.id}" data-id="${
                            value.id
                        }">
                                    </div>
                                    <div class="card-img-top d-flex align-items-center justify-content-center">
                                        <a href="${productDetailUrl}">
                                            <img class="img-fluid prouduct_card-image" width="154" height="160"
                                                src="${baseurl}/${
                            "upload/product/" + value.product_image
                        }" alt>
                                        </a>
                                    </div>
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <div
                                            class="d-flex justify-content-between  align-items-center flex-wrap card-title_wrapper">
                                            <div class="card-title"><a href="${productDetailUrl}">${
                            value.product_unique_id
                        }</a> </div>
                                                <div class="card-text">${
                                                    value.weight
                                                }g</div>
                                                <button class="ml-2 custom-icon-btn wishlist-svg ${
                                                    value.is_favourite === 1
                                                        ? "active"
                                                        : ""
                                                }"
                                                onclick="addtowishlist(${
                                                    value.id
                                                })">
                                                    <svg width="26" height="23" viewBox="0 0 26 23"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M21.5109 13.0016L12.7523 21.8976L4.0016 13.0016C-3.73173 5.15359 5.0336 -3.73174 12.7603 4.11626C20.6003 -3.84641 29.3589 5.03893 21.5189 13.0123L21.5109 13.0016Z"
                                                            stroke="#F78D1E" stroke-width="1.5"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </button>
                                        </div>
                                        <input type="hidden" name="moq${
                                            value.id
                                        }"
                                            id="moq${value.id}" value="${
                            value.moq
                        }">
          <input type="hidden" name="qty${value.id}"
                                                id="qty${value.id}" value="${
                            value.qty
                        }">
                                                <input type="hidden" name="stockqty"
                                                id="stockqty" value="${stockid}">
                    <div>
                    ${mc}
                                        ${moqAvailabilityHTML}
                                        <div class="mt-3 shop-page-qty-add-to-cart-btn_wrapper">
                                            <div class="d-flex align-items-center">
                                                <label class="me-2">Qty</label>
                                                <div class="input-group quantity-input-group quantity-container"
                                                    data-product-id=${value.id}>
                                                    <input type="button" value="-" class="qtyminus"
                                                        field="quantity"
                                                       >
                                                    <input type="text" name="quantity"
                                                        id="quantity${
                                                            value.id
                                                        }" value="${value.moq}"
                                                        class="qty">
                                                    <input type="button" value="+" class="qtyplus"
                                                        field="quantity">
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                            <button onclick="addforcart(${
                                                value.id
                                            })" data_id="card_id_${value.id}"
                                                class="btn add-to-cart-btn mr-2 spinner-button">                                                            <span>ADD TO CART</span>
                                                <span class="d-none spinner">
                                                    <span class="spinner-grow spinner-grow-sm"
                                                        aria-hidden="true"></span>
                                                    <span role="status">Adding...</span>
                                                </span></button>
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
                             Showing ${result.subcollectionwiseproduct.from} - ${result.subcollectionwiseproduct.to} of ${result.subcollectionwiseproduct.total} results
                         </div>
                         <ul class="pagination">`;

                if (result.subcollectionwiseproduct.current_page == 1) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Previous</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link" href="javascript:void(0)" onclick="getsubcollectionproduct(${id}, ${
                        result.subcollectionwiseproduct.current_page - 1
                    })" tabindex="-1">Previous</a>
                 </li>`;
                }

                for (
                    var page = Math.max(
                        1,
                        result.subcollectionwiseproduct.current_page - 2
                    );
                    page <=
                    Math.min(
                        result.subcollectionwiseproduct.last_page,
                        result.subcollectionwiseproduct.current_page + 2
                    );
                    page++
                ) {
                    if (page == result.subcollectionwiseproduct.current_page) {
                        paginationHTML += `<li class="page-item active">
                         <span class="page-link">${page}</span>
                     </li>`;
                    } else {
                        paginationHTML += `<li class="page-item">
                         <a class="page-link"  href="javascript:void(0)" onclick="getsubcollectionproduct(${id}, ${page})">${page}</a>
                     </li>`;
                    }
                }

                if (
                    result.subcollectionwiseproduct.current_page ==
                    result.subcollectionwiseproduct.last_page
                ) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Next</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link"  href="javascript:void(0)" onclick="getsubcollectionproduct(${id}, ${
                        result.subcollectionwiseproduct.current_page + 1
                    })">Next</a>
                 </li>`;
                }

                paginationHTML += `</ul></div></nav>
                <nav class="small-devices_pagination d-none">
                    <div class="text-center">
                        <a class="btn btn-dark px-4 py-2" href="javascript:void(0)" onclick="getsubcollectionproduct(${id}, ${
                    result.subcollectionwiseproduct.current_page + 1
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
        },
    });

    var subcollectionlength = document.querySelectorAll(
        ".subcollection_filter:checked"
    );
    if (subcollectionlength.length > 0) {
        const checkboxes = document.querySelectorAll('[name="other"]');
        checkboxes.forEach((checkbox) => {
            checkbox.disabled = true;
        });
    } else {
        const checkboxes = document.querySelectorAll('[name="other"]');
        checkboxes.forEach((checkbox) => {
            checkbox.disabled = false;
        });
    }
}

function getclassificationproduct(id, page = 1) {
    $(".pagination-links").attr("hidden", true);
    var category_id = $("#decryptedCategoryId").val();
    var project_id = $("#decryptedProjectId").val();
    var weightfrom = document.getElementById("hdweightfrom").value;
    var weightto = document.getElementById("hdweightto").value;
    var subcollection_id = $("#subcol").val();
    // Split the value into an array using the comma as a delimiter
    var weightfrom = weightfrom.split(",");
    var weightto = weightto.split(",");
    var stockid = JSON.parse(document.getElementById("stock").value);

    var selectedclassification = [];
    $(".classification").each(function () {
        if (windowWidth > 300) {
            $("#pageloader").fadeIn();
        }
        if ($(this).is(":checked")) {
            selectedclassification.push($(this).val());
        }
    });

    var selectedclassificationString = selectedclassification.join(",");
    console.log(selectedclassificationString);
    $("#class").val(selectedclassificationString);

    $("#product_page").empty();
    $.ajax({
        type: "GET",
        url: "classificationwiseproduct/" + id + "?page=" + page,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            selectedclassification: selectedclassification,
            category_id: category_id,
            subcollection_id: subcollection_id,
            project_id: project_id,
            weightfrom: weightfrom,
            weightto: weightto,
            stockid: stockid,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            console.log(result);
            // Check if any checkbox is checked
            let isAnyCheckboxChecked = $(".classification:checked").length > 0;
            // Assign value to #subCollectionData based on the checkbox state
            if (isAnyCheckboxChecked) {
                $("#subCollectionData").val(
                    JSON.stringify(result.subcollectionsjson)
                );
                $("#weights").val(JSON.stringify(result.weightJson));
            } else {
                $("#subCollectionData").val(
                    JSON.stringify(result.subcollectionsDefaultjson)
                );
                $("#weights").val(JSON.stringify(result.defaultweightJson));
            }
            if (result.classificationwiseproduct.data.length == 0) {
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
                    result.classificationwiseproduct.data,
                    function (key, value) {
                        $("#notfound").empty();
                        if (result.stock == 1 && value.qty != 0) {
                            moqAvailabilityHTML = `<div class="product-cart-qty-text mt-2">In Stock: <span class="fw-semibold" style="font-size:10px;">${value.qty} pcs</span></div>`;
                        } else {
                            moqAvailabilityHTML = `<div class="card-text mt-2">MOQ : ${value.moq} pcs</div>`;
                        }
                        mc = `
                            <div class="d-flex mt-2 flex-wrap gap-2 align-items-center justify-content-between">
                                <div class="text-success">Tag Code: 
                                    <span class="fw-semibold">${
                                        result.mc_charge[key]
                                    }</span>
                                </div>
                                ${
                                    result.stock == 1
                                        ? `<div class="d-flex my-2 flex-wrap gap-2 align-items-center justify-content-between">
                                                <div class="card-text shop-page-card__select-option">
                                                    <span style="font-weight: bold;" class="text-green">
                                                        ${
                                                            value.project_id !=
                                                            4
                                                                ? "Box: "
                                                                : "Style: "
                                                        }${result.box[key]}
                                                    </span>
                                                </div>
                                        </div>`
                                        : ""
                                }
                            </div>
                        `;
                        var eid = $("#encrypt" + value.id).val();
                        var productDetailUrl =
                            "productdetail/productId".replace("productId", eid);
                        var productHTML = `
                                <input type="hidden" name="weight${
                                    value.id
                                }" id="weight${value.id}"
                                    value="${value.weight}">
                                    <input type="hidden" name="finish${
                                        value.id
                                    }" id="finish${value.id}"
                                        value="${value.finish_id}">
                                <input type="hidden" name="size${
                                    value.id
                                }" id="size${value.id}"
                                    value="${value.size_id}">
                                <input type="hidden" name="plating${
                                    value.id
                                }" id="plating${value.id}"
                                    value="${value.plating_id}">
                                <input type="hidden" name="color${
                                    value.id
                                }" id="color${value.id}"
                                    value="${value.color_id}">
                                    <input type="hidden" name="stock${
                                        value.id
                                    }" id="stock${value.id}"
                                        value="${stockid}">
                                        <input type="hidden" name="box${
                                            value.id
                                        }" id="box${value.id}"
                        value="${value.style_id}">
                                <div class="card shop-page_product-card">
                                    <div class="card-checkbox_wrapper">
                                        <input class="card-checkbox" type="checkbox" name="product${
                                            value.id
                                        }"
                                            id="product${value.id}" data-id="${
                            value.id
                        }">
                                    </div>
                                    <div class="card-img-top d-flex align-items-center justify-content-center">
                                        <a href="${productDetailUrl}">
                                            <img class="img-fluid prouduct_card-image" width="154" height="160"
                                                src="${baseurl}/${
                            "upload/product/" + value.product_image
                        }" alt>
                                        </a>
                                    </div>
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <div
                                            class="d-flex justify-content-between  align-items-center flex-wrap card-title_wrapper">
                                            <div class="card-title"><a href="${productDetailUrl}">${
                            value.product_unique_id
                        }</a> </div>
                                                <div class="card-text">${
                                                    value.weight
                                                }g</div>
                                                <button class="ml-2 custom-icon-btn wishlist-svg ${
                                                    value.is_favourite === 1
                                                        ? "active"
                                                        : ""
                                                }"
                                                onclick="addtowishlist(${
                                                    value.id
                                                })">
                                                    <svg width="26" height="23" viewBox="0 0 26 23"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M21.5109 13.0016L12.7523 21.8976L4.0016 13.0016C-3.73173 5.15359 5.0336 -3.73174 12.7603 4.11626C20.6003 -3.84641 29.3589 5.03893 21.5189 13.0123L21.5109 13.0016Z"
                                                            stroke="#F78D1E" stroke-width="1.5"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </button>
                                        </div>
                                        <input type="hidden" name="moq${
                                            value.id
                                        }"
                                            id="moq${value.id}" value="${
                            value.moq
                        }">
          <input type="hidden" name="qty${value.id}"
                                                id="qty${value.id}" value="${
                            value.qty
                        }">
                                                <input type="hidden" name="stockqty"
                                                id="stockqty" value="${stockid}">
                    <div>
                    ${mc}
                                        ${moqAvailabilityHTML}
                                        <div class="mt-3 shop-page-qty-add-to-cart-btn_wrapper">
                                            <div class="d-flex align-items-center">
                                                <label class="me-2">Qty</label>
                                                <div class="input-group quantity-input-group quantity-container"
                                                    data-product-id=${value.id}>
                                                    <input type="button" value="-" class="qtyminus"
                                                        field="quantity"
                                                       >
                                                    <input type="text" name="quantity"
                                                        id="quantity${
                                                            value.id
                                                        }" value="${value.moq}"
                                                        class="qty">
                                                    <input type="button" value="+" class="qtyplus"
                                                        field="quantity">
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                            <button onclick="addforcart(${
                                                value.id
                                            })" data_id="card_id_${value.id}"
                                                class="btn add-to-cart-btn mr-2 spinner-button">                                                            <span>ADD TO CART</span>
                                                <span class="d-none spinner">
                                                    <span class="spinner-grow spinner-grow-sm"
                                                        aria-hidden="true"></span>
                                                    <span role="status">Adding...</span>
                                                </span></button>
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
                             Showing ${result.classificationwiseproduct.from} - ${result.classificationwiseproduct.to} of ${result.classificationwiseproduct.total} results
                         </div>
                         <ul class="pagination">`;

                if (result.classificationwiseproduct.current_page == 1) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Previous</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link" href="javascript:void(0)" onclick="getclassificationproduct(${id},${
                        result.classificationwiseproduct.current_page - 1
                    })" tabindex="-1">Previous</a>
                 </li>`;
                }

                for (
                    var page = Math.max(
                        1,
                        result.classificationwiseproduct.current_page - 2
                    );
                    page <=
                    Math.min(
                        result.classificationwiseproduct.last_page,
                        result.classificationwiseproduct.current_page + 2
                    );
                    page++
                ) {
                    if (page == result.classificationwiseproduct.current_page) {
                        paginationHTML += `<li class="page-item active">
                         <span class="page-link">${page}</span>
                     </li>`;
                    } else {
                        paginationHTML += `<li class="page-item">
                         <a class="page-link"  href="javascript:void(0)" onclick="getclassificationproduct(${id},${page})">${page}</a>
                     </li>`;
                    }
                }

                if (
                    result.classificationwiseproduct.current_page ==
                    result.classificationwiseproduct.last_page
                ) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Next</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link"  href="javascript:void(0)" onclick="getclassificationproduct(${id},${
                        result.classificationwiseproduct.current_page + 1
                    })">Next</a>
                 </li>`;
                }

                paginationHTML += `</ul></div></nav>
                <nav class="small-devices_pagination d-none">
                    <div class="text-center">
                        <a class="btn btn-dark px-4 py-2" href="javascript:void(0)" onclick="getclassificationproduct(${id},${
                    result.classificationwiseproduct.current_page + 1
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
                updateSubCollections(result.subcollectionsjson);
                updateMobileSubColFilters(result.subcollectionsjson);
                updateWeightFilters(result.weightJson);
                updateMobileWeightFilters(result.weightJson);
            } else {
                updateSubCollections(result.subcollectionsDefaultjson);
                updateMobileSubColFilters(result.subcollectionsDefaultjson);
                updateWeightFilters(result.defaultweightJson);
                updateMobileWeightFilters(result.defaultweightJson);
            }
        },
    });
}

function getcategoryproduct(id, page = 1) {
    $(".pagination-links").attr("hidden", true);
    var category_id = $("#decryptedCategoryId").val();
    var project_id = $("#decryptedProjectId").val();
    var weightfrom = document.getElementById("hdweightfrom").value;
    var weightto = document.getElementById("hdweightto").value;
    var box = $("#box").val();
    // console.log("box Value", box);
    var purity = $("#purity").val();
    // console.log("purity Value", purity);
    // Split the value into an array using the comma as a delimiter
    var weightfrom = weightfrom.split(",");
    var weightto = weightto.split(",");
    var boxArray = box.split(",");
    var purityArray = purity.split(",");

    var stockid = JSON.parse(document.getElementById("stock").value);

    var selectedcategory = [];
    $(".category").each(function () {
        if (windowWidth > 300) {
            $("#pageloader").fadeIn();
        }
        if ($(this).is(":checked")) {
            selectedcategory.push($(this).val());
        }
    });

    var selectedcategoryString = selectedcategory.join(",");
    // console.log(selectedcategoryString);
    $("#jewcat").val(selectedcategoryString);

    $("#product_page").empty();
    $.ajax({
        type: "GET",
        url: "/retailer/categorywiseproduct/" + id + "?page=" + page,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            selectedcategory: selectedcategory,
            category_id: category_id,
            project_id: project_id,
            weightfrom: weightfrom,
            weightto: weightto,
            boxArray: boxArray,
            purityArray: purityArray,
            stockid: stockid,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            // console.log(result);
            // Check if any checkbox is checked
            let isAnyCheckboxChecked = $(".classification:checked").length > 0;
            // Assign value to #subCollectionData based on the checkbox state
            if (isAnyCheckboxChecked) {
                $("#boxFilter").val(JSON.stringify(result.boxjson));
                $("#purityFilter").val(JSON.stringify(result.purityjson));
            } else {
                $("#boxFilter").val(result.boxDefaultjson);
                $("#purityFilter").val(result.purityDefaultjson);
            }
            if (result.categorywiseproduct.data.length == 0) {
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
                $.each(result.categorywiseproduct.data, function (key, value) {
                    $("#notfound").empty();
                    if (result.stock == 1 && value.qty != 0) {
                        moqAvailabilityHTML = `<div class="product-cart-qty-text">In Stock: <span>${value.qty} Pcs</span></div>`;
                    } else {
                        moqAvailabilityHTML = ``;
                    }
                    let box = "";
                    if (
                        result.box[key] !== "-" &&
                        result.box[key] !== undefined &&
                        result.box[key] !== null
                    ) {
                        box = `
                        <div class="d-flex flex-column gap-1">
                        <div class="card-text text-dark">
                        ${value.project_id != 4 ? "Box: " : "Style: "}
                        </div>
                        <div class="product-card-badge">${result.box[key]}</div>
                        </div>`;
                    }

                    var eid = $("#encrypt" + value.id).val();
                    var productDetailUrl =
                        "/retailer/productdetail/productId".replace(
                            "productId",
                            eid
                        );
                    var productHTML = `
                    <input type="hidden" name="weight${value.id}" id="weight${
                        value.id
                    }"
                        value="${value.weight}">
                        <input type="hidden" name="finish${
                            value.id
                        }" id="finish${value.id}"
                            value="${value.finish_id}">
                    <input type="hidden" name="size${value.id}" id="size${
                        value.id
                    }"
                        value="${value.size_id}">
                    <input type="hidden" name="plating${value.id}" id="plating${
                        value.id
                    }"
                        value="${value.plating_id}">
                    <input type="hidden" name="color${value.id}" id="color${
                        value.id
                    }"
                        value="${value.color_id}">
                        <input type="hidden" name="stock${value.id}" id="stock${
                        value.id
                    }"
                            value="${stockid}">
                            <input type="hidden" name="box${value.id}" id="box${
                        value.id
                    }"
  value="${value.style_id}">
                    <div class="card shop-page_product-card">
                        <div class="card-checkbox_wrapper">
                            <input class="card-checkbox" type="checkbox" name="product${
                                value.id
                            }"
                                id="product${value.id}" data-id="${value.id}">
                        </div>
                        <div class="card-img-top d-flex align-items-center justify-content-center position-relative">
                            <a href="${productDetailUrl}">
                                <img class="img-fluid prouduct_card-image" width="154" height="160"
                                    src="${baseurl}/${
                        "upload/product/" + value.product_image
                    }" alt>
                            </a>
                             <div class="position-absolute card-purity purity-list">
          Purity: ${
              result.purity && result.purity[key]
                  ? result.purity[key].replace("SIL-", "")
                  : ""
          }
      </div>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div
                                class="d-flex justify-content-between  align-items-center flex-wrap card-title_wrapper">
                              <div class="card-title"><a href="${productDetailUrl}">${
                        value.product_unique_id
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
                            <input type="hidden" name="moq${value.id}"
                                id="moq${value.id}" value="${value.moq}">
                                <input type="hidden" name="qty${value.id}"
                          id="qty${value.id}" value="${value.qty}">
                          <input type="hidden" name="stockqty"
                          id="stockqty" value="${stockid}">
        <div>



         <div class="d-flex my-2 flex-wrap gap-3 align-items-center card-content_wrapper">


           <div class="d-flex flex-column gap-1">
              <div class="card-text text-dark">Weight</div>
              <div class="product-card-badge">${value.weight}g</div>
          </div>
          
          ${box}
       
      </div>



      
              <div class="d-flex flex-wrap gap-2 align-items-center">
                  ${moqAvailabilityHTML}
                  <div class="d-flex gap-2 align-items-center purity-inside-card">
                      <div class="card-text text-dark">
                          Purity
                      </div>
                      <div class="product-card-badge">${
                          result.purity && result.purity[key]
                              ? result.purity[key].replace("SIL-", "")
                              : ""
                      }</div>
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
                                            id="quantity${value.id}" value="${
                        value.moq
                    }"
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
                             Showing ${result.categorywiseproduct.from} - ${result.categorywiseproduct.to} of ${result.categorywiseproduct.total} results
                         </div>
                         <ul class="pagination">`;

                if (result.categorywiseproduct.current_page == 1) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Previous</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link" href="javascript:void(0)" onclick="getcategoryproduct(${id},${
                        result.categorywiseproduct.current_page - 1
                    })" tabindex="-1">Previous</a>
                 </li>`;
                }

                for (
                    var page = Math.max(
                        1,
                        result.categorywiseproduct.current_page - 2
                    );
                    page <=
                    Math.min(
                        result.categorywiseproduct.last_page,
                        result.categorywiseproduct.current_page + 2
                    );
                    page++
                ) {
                    if (page == result.categorywiseproduct.current_page) {
                        paginationHTML += `<li class="page-item active">
                         <span class="page-link">${page}</span>
                     </li>`;
                    } else {
                        paginationHTML += `<li class="page-item">
                         <a class="page-link"  href="javascript:void(0)" onclick="getcategoryproduct(${id},${page})">${page}</a>
                     </li>`;
                    }
                }

                if (
                    result.categorywiseproduct.current_page ==
                    result.categorywiseproduct.last_page
                ) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Next</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link"  href="javascript:void(0)" onclick="getcategoryproduct(${id},${
                        result.categorywiseproduct.current_page + 1
                    })">Next</a>
                 </li>`;
                }

                paginationHTML += `</ul></div></nav>
                <nav class="small-devices_pagination d-none">
                    <div class="text-center">
                        <a class="btn btn-dark px-4 py-2" href="javascript:void(0)" onclick="getcategoryproduct(${id},${
                    result.categorywiseproduct.current_page + 1
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
                updateBoxFilters(data.boxjson);
                updatePurityFilters(data.purityjson);
            } else {
                updateBoxFilters(data.boxDefaultjson);
                updatePurityFilters(data.purityDefaultjson);
            }
        },
    });
}

function getBoxProduct(id, page = 1) {
    $(".pagination-links").attr("hidden", true);
    var category_id = $("#decryptedCategoryId").val();
    var project_id = $("#decryptedProjectId").val();
    var weightfrom = document.getElementById("hdweightfrom").value;
    var weightto = document.getElementById("hdweightto").value;
    // Split the value into an array using the comma as a delimiter
    var weightfrom = weightfrom.split(",");
    var weightto = weightto.split(",");
    var stockid = JSON.parse(document.getElementById("stock").value);

    var selectedbox = [];
    $(".box").each(function () {
        if (windowWidth > 300) {
            $("#pageloader").fadeIn();
        }
        if ($(this).is(":checked")) {
            selectedbox.push($(this).val());
        }
    });

    var selectedboxString = selectedbox.join(",");
    // console.log(selectedcategoryString);
    $("#box").val(selectedboxString);

    $("#product_page").empty();
    $.ajax({
        type: "GET",
        url: "/retailer/boxwiseproduct/" + id + "?page=" + page,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            selectedbox: selectedbox,
            category_id: category_id,
            project_id: project_id,
            weightfrom: weightfrom,
            weightto: weightto,
            stockid: stockid,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            // console.log(result);
            if (result.boxwiseproduct.data.length == 0) {
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
                $.each(result.boxwiseproduct.data, function (key, value) {
                    $("#notfound").empty();
                    if (result.stock == 1 && value.qty != 0) {
                        moqAvailabilityHTML = `<div class="product-cart-qty-text">In Stock: <span>${value.qty} Pcs</span></div>`;
                    } else {
                        moqAvailabilityHTML = ``;
                    }
                    let box = "";
                    if (
                        result.box[key] !== "-" &&
                        result.box[key] !== undefined &&
                        result.box[key] !== null
                    ) {
                        box = `
                        <div class="d-flex flex-column gap-1">
                        <div class="card-text text-dark">
                        ${value.project_id != 4 ? "Box: " : "Style: "}
                        </div>
                        <div class="product-card-badge">${result.box[key]}</div>
                        </div>`;
                    }

                    var eid = $("#encrypt" + value.id).val();
                    var productDetailUrl =
                        "/retailer/productdetail/productId".replace(
                            "productId",
                            eid
                        );
                    var productHTML = `
                    <input type="hidden" name="weight${value.id}" id="weight${
                        value.id
                    }"
                        value="${value.weight}">
                        <input type="hidden" name="finish${
                            value.id
                        }" id="finish${value.id}"
                            value="${value.finish_id}">
                    <input type="hidden" name="size${value.id}" id="size${
                        value.id
                    }"
                        value="${value.size_id}">
                    <input type="hidden" name="plating${value.id}" id="plating${
                        value.id
                    }"
                        value="${value.plating_id}">
                    <input type="hidden" name="color${value.id}" id="color${
                        value.id
                    }"
                        value="${value.color_id}">
                        <input type="hidden" name="stock${value.id}" id="stock${
                        value.id
                    }"
                            value="${stockid}">
                            <input type="hidden" name="box${value.id}" id="box${
                        value.id
                    }"
  value="${value.style_id}">
                    <div class="card shop-page_product-card">
                        <div class="card-checkbox_wrapper">
                            <input class="card-checkbox" type="checkbox" name="product${
                                value.id
                            }"
                                id="product${value.id}" data-id="${value.id}">
                        </div>
                        <div class="card-img-top d-flex align-items-center justify-content-center position-relative">
                            <a href="${productDetailUrl}">
                                <img class="img-fluid prouduct_card-image" width="154" height="160"
                                    src="${baseurl}/${
                        "upload/product/" + value.product_image
                    }" alt>
                            </a>
                             <div class="position-absolute card-purity purity-list">
          Purity: ${
              result.purity && result.purity[key]
                  ? result.purity[key].replace("SIL-", "")
                  : ""
          }
      </div>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div
                                class="d-flex justify-content-between  align-items-center flex-wrap card-title_wrapper">
                              <div class="card-title"><a href="${productDetailUrl}">${
                        value.product_unique_id
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
                            <input type="hidden" name="moq${value.id}"
                                id="moq${value.id}" value="${value.moq}">
                                <input type="hidden" name="qty${value.id}"
                          id="qty${value.id}" value="${value.qty}">
                          <input type="hidden" name="stockqty"
                          id="stockqty" value="${stockid}">
        <div>



         <div class="d-flex my-2 flex-wrap gap-3 align-items-center card-content_wrapper">


           <div class="d-flex flex-column gap-1">
              <div class="card-text text-dark">Weight</div>
              <div class="product-card-badge">${value.weight}g</div>
          </div>
          
          ${box}
       
      </div>
              <div class="d-flex flex-wrap gap-2 align-items-center">
                  ${moqAvailabilityHTML}
                  <div class="d-flex gap-2 align-items-center purity-inside-card">
                      <div class="card-text text-dark">
                          Purity
                      </div>
                      <div class="product-card-badge">${
                          result.purity && result.purity[key]
                              ? result.purity[key].replace("SIL-", "")
                              : ""
                      }</div>
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
                                            id="quantity${value.id}" value="${
                        value.moq
                    }"
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
                             Showing ${result.boxwiseproduct.from} - ${result.boxwiseproduct.to} of ${result.boxwiseproduct.total} results
                         </div>
                         <ul class="pagination">`;

                if (result.boxwiseproduct.current_page == 1) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Previous</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link" href="javascript:void(0)" onclick="getBoxProduct(${id},${
                        result.boxwiseproduct.current_page - 1
                    })" tabindex="-1">Previous</a>
                 </li>`;
                }

                for (
                    var page = Math.max(
                        1,
                        result.boxwiseproduct.current_page - 2
                    );
                    page <=
                    Math.min(
                        result.boxwiseproduct.last_page,
                        result.boxwiseproduct.current_page + 2
                    );
                    page++
                ) {
                    if (page == result.boxwiseproduct.current_page) {
                        paginationHTML += `<li class="page-item active">
                         <span class="page-link">${page}</span>
                     </li>`;
                    } else {
                        paginationHTML += `<li class="page-item">
                         <a class="page-link"  href="javascript:void(0)" onclick="getBoxProduct(${id},${page})">${page}</a>
                     </li>`;
                    }
                }

                if (
                    result.boxwiseproduct.current_page ==
                    result.boxwiseproduct.last_page
                ) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Next</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link"  href="javascript:void(0)" onclick="getBoxProduct(${id},${
                        result.boxwiseproduct.current_page + 1
                    })">Next</a>
                 </li>`;
                }

                paginationHTML += `</ul></div></nav>
                <nav class="small-devices_pagination d-none">
                    <div class="text-center">
                        <a class="btn btn-dark px-4 py-2" href="javascript:void(0)" onclick="getBoxProduct(${id},${
                    result.boxwiseproduct.current_page + 1
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
        },
    });
}

function getPurityProduct(id, page = 1) {
    $(".pagination-links").attr("hidden", true);
    var category_id = $("#decryptedCategoryId").val();
    var project_id = $("#decryptedProjectId").val();
    var weightfrom = document.getElementById("hdweightfrom").value;
    var weightto = document.getElementById("hdweightto").value;
    // Split the value into an array using the comma as a delimiter
    var weightfrom = weightfrom.split(",");
    var weightto = weightto.split(",");
    var stockid = JSON.parse(document.getElementById("stock").value);

    var selectedpurity = [];
    $(".purity").each(function () {
        if (windowWidth > 300) {
            $("#pageloader").fadeIn();
        }
        if ($(this).is(":checked")) {
            selectedpurity.push("SIL-" + $(this).val());
        }
    });
    console.log(selectedpurity);

    var selectedpurityString = selectedpurity.join(",");
    // console.log(selectedcategoryString);
    $("#box").val(selectedpurityString);

    $("#product_page").empty();
    $.ajax({
        type: "GET",
        url: "/retailer/puritywiseproduct/" + id + "?page=" + page,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            selectedpurity: selectedpurity,
            category_id: category_id,
            project_id: project_id,
            weightfrom: weightfrom,
            weightto: weightto,
            stockid: stockid,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            // console.log(result);
            if (result.puritywiseproduct.data.length == 0) {
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
                $.each(result.puritywiseproduct.data, function (key, value) {
                    $("#notfound").empty();
                    if (result.stock == 1 && value.qty != 0) {
                        moqAvailabilityHTML = `<div class="product-cart-qty-text">In Stock: <span>${value.qty} Pcs</span></div>`;
                    } else {
                        moqAvailabilityHTML = ``;
                    }
                    let box = "";
                    if (
                        result.box[key] !== "-" &&
                        result.box[key] !== undefined &&
                        result.box[key] !== null
                    ) {
                        box = `
                        <div class="d-flex flex-column gap-1">
                        <div class="card-text text-dark">
                        ${value.project_id != 4 ? "Box: " : "Style: "}
                        </div>
                        <div class="product-card-badge">${result.box[key]}</div>
                        </div>`;
                    }

                    var eid = $("#encrypt" + value.id).val();
                    var productDetailUrl =
                        "/retailer/productdetail/productId".replace(
                            "productId",
                            eid
                        );
                    var productHTML = `
                    <input type="hidden" name="weight${value.id}" id="weight${
                        value.id
                    }"
                        value="${value.weight}">
                        <input type="hidden" name="finish${
                            value.id
                        }" id="finish${value.id}"
                            value="${value.finish_id}">
                    <input type="hidden" name="size${value.id}" id="size${
                        value.id
                    }"
                        value="${value.size_id}">
                    <input type="hidden" name="plating${value.id}" id="plating${
                        value.id
                    }"
                        value="${value.plating_id}">
                    <input type="hidden" name="color${value.id}" id="color${
                        value.id
                    }"
                        value="${value.color_id}">
                        <input type="hidden" name="stock${value.id}" id="stock${
                        value.id
                    }"
                            value="${stockid}">
                            <input type="hidden" name="box${value.id}" id="box${
                        value.id
                    }"
  value="${value.style_id}">
                    <div class="card shop-page_product-card">
                        <div class="card-checkbox_wrapper">
                            <input class="card-checkbox" type="checkbox" name="product${
                                value.id
                            }"
                                id="product${value.id}" data-id="${value.id}">
                        </div>
                        <div class="card-img-top d-flex align-items-center justify-content-center position-relative">
                            <a href="${productDetailUrl}">
                                <img class="img-fluid prouduct_card-image" width="154" height="160"
                                    src="${baseurl}/${
                        "upload/product/" + value.product_image
                    }" alt>
                            </a>
                             <div class="position-absolute card-purity purity-list">
          Purity: ${
              result.purity && result.purity[key]
                  ? result.purity[key].replace("SIL-", "")
                  : ""
          }
      </div>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div
                                class="d-flex justify-content-between  align-items-center flex-wrap card-title_wrapper">
                              <div class="card-title"><a href="${productDetailUrl}">${
                        value.product_unique_id
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
                            <input type="hidden" name="moq${value.id}"
                                id="moq${value.id}" value="${value.moq}">
                                <input type="hidden" name="qty${value.id}"
                          id="qty${value.id}" value="${value.qty}">
                          <input type="hidden" name="stockqty"
                          id="stockqty" value="${stockid}">
        <div>



         <div class="d-flex my-2 flex-wrap gap-3 align-items-center card-content_wrapper">


           <div class="d-flex flex-column gap-1">
              <div class="card-text text-dark">Weight</div>
              <div class="product-card-badge">${value.weight}g</div>
          </div>
          
          ${box}
       
      </div>
              <div class="d-flex flex-wrap gap-2 align-items-center">
                  ${moqAvailabilityHTML}
                  <div class="d-flex gap-2 align-items-center purity-inside-card">
                      <div class="card-text text-dark">
                          Purity
                      </div>
                      <div class="product-card-badge">${
                          result.purity && result.purity[key]
                              ? result.purity[key].replace("SIL-", "")
                              : ""
                      }</div>
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
                                            id="quantity${value.id}" value="${
                        value.moq
                    }"
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
                             Showing ${result.puritywiseproduct.from} - ${result.puritywiseproduct.to} of ${result.puritywiseproduct.total} results
                         </div>
                         <ul class="pagination">`;

                if (result.puritywiseproduct.current_page == 1) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Previous</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link" href="javascript:void(0)" onclick="getPurityProduct(${id},${
                        result.puritywiseproduct.current_page - 1
                    })" tabindex="-1">Previous</a>
                 </li>`;
                }

                for (
                    var page = Math.max(
                        1,
                        result.puritywiseproduct.current_page - 2
                    );
                    page <=
                    Math.min(
                        result.puritywiseproduct.last_page,
                        result.puritywiseproduct.current_page + 2
                    );
                    page++
                ) {
                    if (page == result.puritywiseproduct.current_page) {
                        paginationHTML += `<li class="page-item active">
                         <span class="page-link">${page}</span>
                     </li>`;
                    } else {
                        paginationHTML += `<li class="page-item">
                         <a class="page-link"  href="javascript:void(0)" onclick="getPurityProduct(${id},${page})">${page}</a>
                     </li>`;
                    }
                }

                if (
                    result.puritywiseproduct.current_page ==
                    result.puritywiseproduct.last_page
                ) {
                    paginationHTML += `<li class="page-item disabled">
                     <span class="page-link">Next</span>
                 </li>`;
                } else {
                    paginationHTML += `<li class="page-item">
                     <a class="page-link"  href="javascript:void(0)" onclick="getPurityProduct(${id},${
                        result.puritywiseproduct.current_page + 1
                    })">Next</a>
                 </li>`;
                }

                paginationHTML += `</ul></div></nav>
                <nav class="small-devices_pagination d-none">
                    <div class="text-center">
                        <a class="btn btn-dark px-4 py-2" href="javascript:void(0)" onclick="getPurityProduct(${id},${
                    result.puritywiseproduct.current_page + 1
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
        },
    });
}

function updateWeightFilters(weights) {
    // Parse the JSON string into a JavaScript object
    // console.log("updated weights", weights);
    var weights = JSON.parse(weights);

    var container = document.getElementById("weight-filters-container");
    container.innerHTML = ""; // Clear existing filters if any

    weights.forEach(function (weight, key) {
        var label = "";

        if (
            weight.weight_range_from === 50 &&
            weight.weight_range_to === 10000
        ) {
            label = "Above 50grams";
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
            weight.weight_range_from === 50 &&
            weight.weight_range_to === 10000
        ) {
            label = "Above 50grams";
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

function updateSubCollections(subcollectionsjson) {
    // Log the data to debug
    // console.log("subcollectionsjson:", subcollectionsjson);

    // Ensure the data is parsed if it's not an object
    if (typeof subcollectionsjson === "string") {
        try {
            subcollectionsjson = JSON.parse(subcollectionsjson);
        } catch (error) {
            console.error("Failed to parse subcollectionsjson:", error);
            return;
        }
    }

    // Check if the data is an array
    if (!Array.isArray(subcollectionsjson)) {
        console.error(
            "subcollectionsjson is not an array:",
            subcollectionsjson
        );
        return;
    }

    let newSubCollectionData = addKeyValueToObjects(
        subcollectionsjson,
        "item_name",
        "sub_collection_name"
    );
    newSubCollectionData.sort(sortByItemName);

    // Clear existing sub-collection filter inputs
    let subCollectionEl = document.getElementById(
        "sidebarLabels-subcollection"
    );
    if (subCollectionEl) {
        subCollectionEl.innerHTML = "";

        // Generate new sub-collection filter inputs
        generateInputElements("subcollection", newSubCollectionData);
        generatePopupInputElements("subcollection", newSubCollectionData);
        generatePopupSortingButtons("subcollection", newSubCollectionData);
    }
}

function updateMobileSubColFilters(newData) {
    let newContainer = document.querySelector("#subcollectionFilterContent1");
    newContainer.innerHTML = ""; // Clear existing filters

    // Ensure newData is parsed if it's not an object
    if (typeof newData === "string") {
        try {
            newData = JSON.parse(newData);
        } catch (error) {
            console.error("Failed to parse newData:", error);
            return;
        }
    }

    // Check if newData is an array
    if (Array.isArray(newData)) {
        newData.forEach((each) => {
            let filterItem = document.createElement("div");

            filterItem.innerHTML = `<div class="form-check d-flex justify-content-between gap-2">
                        <div>
                            <input type="checkbox" class="form-check-input subcollection_filter" id="mobile-${each.sub_collection_name.toLowerCase()}"
                            value="${
                                each.sub_collection_name
                            }" onclick="getsubcollectionproduct(${
                each.id
            })"><label for="mobile-${each.sub_collection_name.toLowerCase()}" class="form-check-label">${
                each.sub_collection_name
            }</label>
                        </div>
                    </div>`;
            newContainer.appendChild(filterItem);
        });
    } else {
        console.error("newData is not an array:", newData);
        // Handle the case where newData is not an array (e.g., log an error, show a message, etc.)
    }
}

function updateCategoryFilters(categoriesData) {
    // console.log("update cat filters", categoriesData);
    let categories = JSON.parse(categoriesData);
    let container = document.getElementById("jewel-category-filter");
    if (container) {
        container.innerHTML = ""; // Clear existing filters if any
        categories.forEach(function (category) {
            var filterHtml = `
    <div class="form-check">
    
    <input class="category form-check-input" type="checkbox"
    id="category${category.id}" name="category" data-id="${category.id}"
    value="${category.category_name}" onclick="getcategoryproduct(${category.id})">
    <label class="form-check-label" for="category${category.id}">
    ${category.category_name}
    </label>
    
        </div>
        `;
            container.insertAdjacentHTML("beforeend", filterHtml);
        });
    }
}

function updateMobileCategoryFilters(categoriesData) {
    // console.log("update mob cat filters", categoriesData);
    let categories = JSON.parse(categoriesData);

    let container = document.getElementById("mobileCategoryFilter");
    container.innerHTML = ""; // Clear existing filters if any

    categories.forEach(function (category) {
        let filterHtml = `
        <div class="form-check d-flex justify-content-between gap-2">
            <div>
                <input class="category form-check-input" type="checkbox"
                    id="category${category.id}-mob" name="category" data-id="${category.id}"
                    value="${category.category_name}" onclick="getcategoryproduct(${category.id})">
                <label class="form-check-label" for="category${category.id}-mob">
                    ${category.category_name}
                </label>
            </div>
        </div>
    `;
        container.insertAdjacentHTML("beforeend", filterHtml);
    });
}

function updateBoxFilters(boxesData) {
    // console.log("update cat filters", categoriesData);
    let boxes = JSON.parse(boxesData);
    let container = document.getElementById("box-filter");
    if (container) {
        container.innerHTML = ""; // Clear existing filters if any
        boxes.forEach(function (box) {
            var filterHtml = `
    <div class="form-check">
    
    <input class="box form-check-input" type="checkbox"
    id="box${box.id}" name="box" data-id="${box.id}"
    value="${box.style_name}" onclick="getBoxProduct(${box.id})">
    <label class="form-check-label" for="box${box.id}">
    ${box.style_name == "-" ? "Default" : box.style_name}
    </label>
    
        </div>
        `;
            container.insertAdjacentHTML("beforeend", filterHtml);
        });
    }
}

function updateMobileBoxFilters(boxesData) {
    // console.log("update mob cat filters", categoriesData);
    let boxes = JSON.parse(boxesData);

    let container = document.getElementById("mobile-box-filters");
    container.innerHTML = ""; // Clear existing filters if any

    boxes.forEach(function (box) {
        let filterHtml = `
        <div class="form-check d-flex justify-content-between gap-2">
            <div>
                <input class="box form-check-input" type="checkbox"
                    id="box${box.id}-mob" name="box" data-id="${box.id}"
                    value="${box.style_name}" onclick="getBoxProduct(${
            box.id
        })">
                <label class="form-check-label" for="box${box.id}-mob">
                    ${box.style_name == "-" ? "Default" : box.style_name}
                </label>
            </div>
        </div>
    `;
        container.insertAdjacentHTML("beforeend", filterHtml);
    });
}

function updatePurityFilters(puritiesData) {
    // console.log("update cat filters", categoriesData);
    let purities = JSON.parse(puritiesData);
    let container = document.getElementById("purity-filter");
    if (container) {
        container.innerHTML = ""; // Clear existing filters if any
        purities.forEach(function (purity) {
            var filterHtml = `
    <div class="form-check">
    
    <input class="purity form-check-input" type="checkbox"
    id="purity${purity.id}" name="purity" data-id="${purity.id}"
    value="${purity.silver_purity_percentage}" onclick="getBoxProduct(${purity.id})">
    <label class="form-check-label" for="purity${purity.id}">
    ${purity.silver_purity_percentage}
    </label>
    
        </div>
        `;
            container.insertAdjacentHTML("beforeend", filterHtml);
        });
    }
}

function updateMobilePurityFilters(puritiesData) {
    // console.log("update mob cat filters", categoriesData);
    let purities = JSON.parse(puritiesData);

    let container = document.getElementById("mobile-purity-filters");
    container.innerHTML = ""; // Clear existing filters if any

    purities.forEach(function (purity) {
        let filterHtml = `
        <div class="form-check d-flex justify-content-between gap-2">
            <div>
                <input class="purity form-check-input" type="checkbox"
                    id="purity${purity.id}-mob" name="purity" data-id="${purity.id}"
                    value="${purity.silver_purity_percentage}" onclick="getPurityProduct(${purity.id})">
                <label class="form-check-label" for="purity${purity.id}-mob">
                    ${purity.silver_purity_percentage}
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

// function updateMobileClassifications(classifications) {
//     const mobileClassificationContainer = document.querySelector('#mobileClassificationFilter .filter-inputs_wrapper');

//     if(mobileClassificationContainer){
//         mobileClassificationContainer.innerHTML = ''; // Clear existing filters if any
//         classifications.forEach(classification => {

//             const formCheckDiv = document.createElement('div');
//             formCheckDiv.className = 'form-check d-flex justify-content-between gap-2';

//             const innerDiv = document.createElement('div');

//             const inputElement = document.createElement('input');
//             inputElement.className = 'form-check-input classification';
//             inputElement.type = 'checkbox';
//             inputElement.id = `mob-classification_name${classification.id}`;
//             inputElement.name = 'classification-mobile';
//             inputElement.value = classification.classification_name;
//             inputElement.onclick = function() {
//                 getclassificationproduct(classification.id);
//             };

//             const labelElement = document.createElement('label');
//             labelElement.className = 'form-check-label';
//             labelElement.setAttribute('for', `mob-classification_name${classification.id}`);
//             labelElement.textContent = classification.classification_name;

//             innerDiv.appendChild(inputElement);
//             innerDiv.appendChild(labelElement);

//             formCheckDiv.appendChild(innerDiv);

//             mobileClassificationContainer.appendChild(formCheckDiv);
//         });
//     }

// }

// // Call the function with the JSON data
// updateMobileClassifications(JSON.parse($("#classification").val()));

// function updateMobileOtherFilters(others) {
//     const mobileOthersContainer = document.querySelector('#mobileOtherFilter .filter-inputs_wrapper');

//     others.forEach(other => {
//         mobileOthersContainer.innerHTML = ''; // Clear existing filters if any

//         const formCheckDiv = document.createElement('div');
//         formCheckDiv.className = 'form-check d-flex justify-content-between gap-2';

//         const innerDiv = document.createElement('div');

//         const inputElement = document.createElement('input');
//         inputElement.className = 'others form-check-input';
//         inputElement.type = 'checkbox';
//         inputElement.id = `other${other.id}`;
//         inputElement.name = 'other';
//         inputElement.value = other.collection_name;
//         inputElement.setAttribute('data-id', other.id);
//         inputElement.onclick = function() {
//             getCollectionWiseProducts(other.id);
//         };

//         const labelElement = document.createElement('label');
//         labelElement.className = 'form-check-label';
//         labelElement.setAttribute('for', `other${other.id}`);
//         labelElement.textContent = other.collection_name;

//         innerDiv.appendChild(inputElement);
//         innerDiv.appendChild(labelElement);

//         formCheckDiv.appendChild(innerDiv);

//         mobileOthersContainer.appendChild(formCheckDiv);
//     });
// }
// // Call the function with the JSON data
// updateMobileOtherFilters(JSON.parse($("#otherFilter").val()));

// Parse the JSON string into a JavaScript object

function appendWeightFilters() {
    let weights = JSON.parse($("#weights").val());
    var container = document.getElementById("weight-filters-container");
    container.innerHTML = ""; // Clear existing filters if any

    weights?.forEach(function (weight, key) {
        var label = "";

        if (
            weight.weight_range_from === 50 &&
            weight.weight_range_to === 10000
        ) {
            label = "Above 50grams";
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
// Call the function to append the filters
appendWeightFilters();

function appendCategoryFilters() {
    let categories = JSON.parse($("#categoryFilter").val());
    let container = document.getElementById("jewel-category-filter");
    if (container) {
        container.innerHTML = ""; // Clear existing filters if any

        categories.forEach(function (category) {
            var filterHtml = `
        <div class="form-check">
  
                <input class="category form-check-input" type="checkbox"
                    id="category${category.id}" name="category" data-id="${category.id}"
                    value="${category.category_name}" onclick="getcategoryproduct(${category.id})">
                <label class="form-check-label" for="category${category.id}">
                    ${category.category_name}
                </label>
 
        </div>
    `;
            container.insertAdjacentHTML("beforeend", filterHtml);
        });
    }
}

// Call the function to append the filters
appendCategoryFilters();
function appendUtensilCategoryFilters() {
    let categories = JSON.parse($("#utensilcategoryFilter").val());
    let container = document.getElementById("utensil-category-filter");
    if (container) {
        container.innerHTML = ""; // Clear existing filters if any

        categories.forEach(function (category) {
            var filterHtml = `
        <div class="form-check">
  
                <input class="category form-check-input" type="checkbox"
                    id="category${category.id}" name="category" data-id="${category.id}"
                    value="${category.category_name}" onclick="getcategoryproduct(${category.id})">
                <label class="form-check-label" for="category${category.id}">
                    ${category.category_name}
                </label>
 
        </div>
    `;
            container.insertAdjacentHTML("beforeend", filterHtml);
        });
    }
}

function appendBoxFilters() {
    let boxes = JSON.parse($("#boxFilter").val());

    let container = document.getElementById("box-filter");
    if (container) {
        container.innerHTML = ""; // Clear existing filters if any

        boxes.forEach(function (box) {
            var filterHtml = `
        <div class="form-check">
  
                <input class="box form-check-input" type="checkbox"
                    id="box${box.id}" name="box" data-id="${box.id}"
                    value="${box.style_name}" onclick="getBoxProduct(${
                box.id
            })">
                <label class="form-check-label" for="box${box.id}">
                    ${box.style_name == "-" ? "Default" : box.style_name}
                </label>
 
        </div>
    `;
            container.insertAdjacentHTML("beforeend", filterHtml);
        });
    }
}
function appendPurityFilters() {
    let purities = JSON.parse($("#purityFilter").val());

    let container = document.getElementById("purity-filter");
    if (container) {
        container.innerHTML = ""; // Clear existing filters if any

        purities.forEach(function (purity) {
            // Remove "SIL-" prefix if present
            let purityLabel = purity.silver_purity_percentage.replace(
                /^SIL-/,
                ""
            );

            var filterHtml = `
        <div class="form-check">
  
                <input class="purity form-check-input" type="checkbox"
                    id="purity${purity.id}" name="purity" data-id="${purity.id}"
                    value="${purityLabel}" onclick="getPurityProduct(${purity.id})">
                <label class="form-check-label" for="purity${purity.id}">
                    ${purityLabel}
                </label>
 
        </div>
    `;
            container.insertAdjacentHTML("beforeend", filterHtml);
        });
    }
}

// Call the function to append the filters
appendUtensilCategoryFilters();
appendBoxFilters();
appendPurityFilters();

//     function updateClassifications(classifications) {
//     const classificationContainer = document.querySelector('#classificationFilter .accordion-body');
//     if(classificationContainer){
//         classificationContainer.innerHTML = ''; // Clear existing filters if any
//         classifications.forEach(classification => {
//         const formCheckDiv = document.createElement('div');
//         formCheckDiv.className = 'form-check';

//         const inputElement = document.createElement('input');
//         inputElement.className = 'form-check-input classification classification_name_filter';
//         inputElement.type = 'checkbox';
//         inputElement.id = `classification${classification.id}`;
//         inputElement.name = 'classification';
//         inputElement.value = classification.classification_name;
//         inputElement.onclick = function() {
//             getclassificationproduct(classification.id);
//         };

//         const labelElement = document.createElement('label');
//         labelElement.className = 'form-check-label';
//         labelElement.setAttribute('for', `classification${classification.id}`);
//         labelElement.textContent = classification.classification_name;

//         formCheckDiv.appendChild(inputElement);
//         formCheckDiv.appendChild(labelElement);

//         classificationContainer.appendChild(formCheckDiv);
//     });
//     }

// }

// // Call the function with the JSON data
// updateClassifications(JSON.parse($("#classification").val()));
// });

// function updateOthersFilters(others) {
//     const othersContainer = document.querySelector('#others .accordion-body');

//    if(othersContainer){
//     othersContainer.innerHTML = ''; // Clear existing filters if any
//     others.forEach(other => {
//         const formCheckDiv = document.createElement('div');
//         formCheckDiv.className = 'form-check';

//         const inputElement = document.createElement('input');
//         inputElement.className = 'form-check-input others';
//         inputElement.type = 'checkbox';
//         inputElement.id = other.collection_name;
//         inputElement.name = 'other';
//         inputElement.value = other.collection_name;
//         inputElement.setAttribute('data-id', other.id);
//         inputElement.onclick = function() {
//             getCollectionWiseProducts(other.id);
//         };

//         const labelElement = document.createElement('label');
//         labelElement.className = 'form-check-label';
//         labelElement.setAttribute('for', other.collection_name);
//         labelElement.textContent = other.collection_name;

//         formCheckDiv.appendChild(inputElement);
//         formCheckDiv.appendChild(labelElement);

//         othersContainer.appendChild(formCheckDiv);
//     });
//    }
// }

// // Call the function with the JSON data
// updateOthersFilters(JSON.parse($("#otherFilter").val()));
