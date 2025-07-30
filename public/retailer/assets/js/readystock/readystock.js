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
                $.each(result.weightrange.data,function (key, value) {
                    $("#notfound").empty(); // Clear 'no results' notice if any
                    let encryptedId = $("#encrypt" + value.id).val();
                    let productDetailUrl = "/retailer/productdetail/" + encryptedId;
                    let secureImg = value.secureFilename;
                    let variantCount = value.variant_count ?? 1;
                    let variants = value.variants ?? [];
                
                    let safeDesignNo = value.DesignNo.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                    let productHTML = `
                    <div class="card shop-page_product-card">
                        <div class="card-img-top d-flex align-items-center justify-content-center position-relative">
                            <a href="${productDetailUrl}">
                                <img class="img-fluid prouduct_card-image load-secure-image" src="${baseurl}/load-loading.gif" data-secure="${secureImg}" width="255" height="255" alt="">
                            </a>
                            <div class="position-absolute card-purity purity-list">Purity: ${value.variant_purity ?? 'N/A'}</div>
                        </div>
                
                        <div class="card-body d-flex flex-column">
                            <div class="card-title">
                                <a href="${productDetailUrl}" class="text-decoration-none">${value.DesignNo}</a>
                            </div>`;
                
                    // MULTIPLE VARIANTS
                    if (variantCount > 1 && variants.length > 1) {
                        productHTML += `
                        <div class="mt-3">
                            <div class="card-text fw-bold">Multiple Sizes Available</div>
                            <button class="btn btn-warning mt-2" data-bs-toggle="modal" data-bs-target="#productModal-${safeDesignNo}">
                                View All Options
                            </button>
                
                            <!-- Modal -->
                            <div class="modal fade product-variants-modal" id="productModal-${safeDesignNo}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content rounded-4 overflow-hidden">
                                        <div class="modal-body p-4 d-flex flex-column flex-lg-row gap-4">
                                            <div class="modal-image text-center flex-shrink-0" style="flex: 0 0 200px;">
                                                <img class="img-fluid load-secure-image" src="${baseurl}/load-loading.gif" data-secure="${secureImg}" width="200" height="200" alt="${value.DesignNo}">
                                            </div>
                                            <div class="modal-details flex-grow-1 overflow-auto">
                                                <h6 class="mb-2 fs-5" style="color:#7E7E7E;">Design Code: <span class="font-semibold text-dark">${value.DesignNo}</span></h6>
                                                <p class="fw-medium fs-6 mb-4" style="color:#F78D1E;">Multiple Sizes Available</p>
                                                <div class="overflow-auto">
                                                    <table class="table table-bordered text-center align-middle">
                                                        <thead class="table-dark border-0"><tr><th></th>`;
                
                        variants.forEach((_, i) => {
                            productHTML += `<th>Variant #${i + 1}</th>`;
                        });
                
                        productHTML += `</tr></thead><tbody>`;
                
                        // Dynamic rows for variant attributes
                        const attrs = ['Purity', 'color', 'unit', 'style', 'making', 'size', 'weight', 'qty'];
                        const labels = ['Purity', 'Color', 'Unit', 'Style', 'Making %', 'Size', 'Weight', 'In Stock'];
                        
                        attrs.forEach((attr, i) => {
                            productHTML += `<tr><td>${labels[i]}</td>`;
                            variants.forEach(variant => {
                                let val = variant[attr] ?? '-';
                                if (attr === 'Weight' && val !== '-') val += 'g';
                                if (attr === 'Qty' && val !== '-') val += ' Pcs';
                                productHTML += `<td>${val}</td>`;
                            });
                            productHTML += `</tr>`;
                        });
                
                        // Quantity input row
                        productHTML += `<tr><td>Qty</td>`;
                        variants.forEach(variant => {
                            productHTML += `<td>
                                <div class="input-group quantity-input-group quantity-container">
                                    <input type="button" value="-" class="qtyminus" field="quantity">
                                    <input type="text" name="mquantity${variant.productID}" id="mquantity${variant.productID}" value="1" class="qty">
                                    <input type="button" value="+" class="qtyplus" field="quantity">
                                </div>
                            </td>`;
                        });
                        productHTML += `</tr>`;
                
                        // Add to cart row
                        productHTML += `<tr><td>Add to Cart</td>`;
                        variants.forEach(variant => {
                            let inCart = result.cart[variant.productID]?.length > 0;
                            let cartQty = result.cartcount[variant.productID] ?? 0;
                            productHTML += `<td>
                                <button onclick="addforcart(${variant.productID})" class="btn ${inCart ? 'added-to-cart-btn' : 'add-to-cart-btn'} spinner-button" data_id="card_id_${variant.productID}">
                                    <span class="submit-text">${inCart ? 'ADDED TO CART' : 'ADD TO CART'}</span>
                                    <span class="d-none spinner">
                                        <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                                        <span role="status">Adding...</span>
                                    </span>
                                    <span id="applycurrentcartcount${variant.productID}" class="added-to-cart-badge ms-2">${cartQty}</span>
                                </button>
                            </td>`;
                        });
                
                        productHTML += `
                            </tr></tbody></table>
                        </div></div></div>
                            <button type="button" class="btn btn-link close-btn" data-bs-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                height="25" viewBox="0 0 25 25" fill="none">
                                                                <path
                                                                    d="M12.375 23.75C10.8812 23.75 9.40205 23.4558 8.02198 22.8841C6.6419 22.3125 5.38793 21.4746 4.33166 20.4183C3.27539 19.3621 2.43752 18.1081 1.86587 16.728C1.29422 15.3479 1 13.8688 1 12.375C1 10.8812 1.29422 9.40205 1.86587 8.02197C2.43752 6.6419 3.27539 5.38793 4.33166 4.33166C5.38793 3.27539 6.6419 2.43752 8.02198 1.86587C9.40206 1.29422 10.8812 1 12.375 1C13.8688 1 15.3479 1.29422 16.728 1.86587C18.1081 2.43752 19.3621 3.2754 20.4183 4.33166C21.4746 5.38793 22.3125 6.6419 22.8841 8.02198C23.4558 9.40206 23.75 10.8812 23.75 12.375C23.75 13.8688 23.4558 15.3479 22.8841 16.728C22.3125 18.1081 21.4746 19.3621 20.4183 20.4183C19.3621 21.4746 18.1081 22.3125 16.728 22.8841C15.3479 23.4558 13.8688 23.75 12.375 23.75L12.375 23.75Z"
                                                                    stroke="#535353" stroke-width="1.47967"
                                                                    stroke-linecap="round" />
                                                                <path d="M8.58203 8.58398L16.1654 16.1673"
                                                                    stroke="#535353" stroke-width="1.47967"
                                                                    stroke-linecap="round" />
                                                                <path d="M16.168 8.58398L8.58464 16.1673"
                                                                    stroke="#535353" stroke-width="1.47967"
                                                                    stroke-linecap="round" />
                                                            </svg></button>
                        </div>
                    </div>
                </div>`;
                    } else {
                        // SINGLE VARIANT
                        productHTML += `<div class="mt-3 grid cols-3 card-content_wrapper">`;
                
                        const singleAttrs = [
                            { key: 'variant_unit', label: 'Unit' },
                            { key: 'variant_style', label: 'Style' },
                            { key: 'variant_making', label: 'Making %' },
                            { key: 'variant_color', label: 'Color' },
                            { key: 'variant_size', label: 'Size' },
                            { key: 'variant_weight', label: 'Weight', suffix: 'g' }
                        ];
                
                        singleAttrs.forEach(attr => {
                            if (value[attr.key]) {
                                productHTML += `
                                <div class="d-flex flex-column gap-1">
                                    <div class="card-text text-dark">${attr.label}</div>
                                    <div class="product-card-badge">${value[attr.key]}${attr.suffix || ''}</div>
                                </div>`;
                            }
                        });
                
                        productHTML += `</div>
                            <div class="product-cart-qty-text mt-2">In Stock: <span>${value.variant_qty ?? '-'}</span> Pcs</div>
                            <div class="shop-page-add-to-cart-btn mt-3">
                                <div class="d-flex align-items-center">
                                    <label class="me-2">Qty</label>
                                    <div class="input-group quantity-input-group quantity-container">
                                        <input type="button" value="-" class="qtyminus" field="quantity">
                                        <input type="text" name="quantity" id="quantity${value.id}" value="1" class="qty">
                                        <input type="button" value="+" class="qtyplus" field="quantity">
                                    </div>
                                </div>
                                <button onclick="addforcart(${value.id})" class="btn mt-3 ${result.cart[value.id]?.length ? 'added-to-cart-btn' : 'add-to-cart-btn'} spinner-button" data_id="card_id_${value.id}">
                                    <span class="submit-text">${result.cart[value.id]?.length ? 'ADDED TO CART' : 'ADD TO CART'}</span>
                                    <span class="d-none spinner">
                                        <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                                        <span role="status">Adding...</span>
                                    </span>
                                    <span class="added-to-cart-badge ms-2">${result.cartcount[value.id] ?? ''}</span>
                                </button>
                            </div>`;
                    }
                
                    productHTML += `</div></div>`; // Close .card-body and .card
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
            console.log(result, "result");
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
                    $("#notfound").empty(); // Clear 'no results' notice if any
                    let encryptedId = $("#encrypt" + value.id).val();
                    let productDetailUrl = "/retailer/productdetail/" + encryptedId;
                    let secureImg = value.secureFilename;
                    let variantCount = value.variant_count ?? 1;
                    let variants = value.variants ?? [];
                
                    let safeDesignNo = value.DesignNo.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                    let productHTML = `
                    <div class="card shop-page_product-card">
                        <div class="card-img-top d-flex align-items-center justify-content-center position-relative">
                            <a href="${productDetailUrl}">
                                <img class="img-fluid prouduct_card-image load-secure-image" src="${baseurl}/load-loading.gif" data-secure="${secureImg}" width="255" height="255" alt="">
                            </a>
                            <div class="position-absolute card-purity purity-list">Purity: ${value.variant_purity ?? 'N/A'}</div>
                        </div>
                
                        <div class="card-body d-flex flex-column">
                            <div class="card-title">
                                <a href="${productDetailUrl}" class="text-decoration-none">${value.DesignNo}</a>
                            </div>`;
                
                    // MULTIPLE VARIANTS
                    if (variantCount > 1 && variants.length > 1) {
                        productHTML += `
                        <div class="mt-3">
                            <div class="card-text fw-bold">Multiple Sizes Available</div>
                            <button class="btn btn-warning mt-2" data-bs-toggle="modal" data-bs-target="#productModal-${safeDesignNo}">
                                View All Options
                            </button>
                
                            <!-- Modal -->
                            <div class="modal fade product-variants-modal" id="productModal-${safeDesignNo}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content rounded-4 overflow-hidden">
                                        <div class="modal-body p-4 d-flex flex-column flex-lg-row gap-4">
                                            <div class="modal-image text-center flex-shrink-0" style="flex: 0 0 200px;">
                                                <img class="img-fluid load-secure-image" src="${baseurl}/load-loading.gif" data-secure="${secureImg}" width="200" height="200" alt="${value.DesignNo}">
                                            </div>
                                            <div class="modal-details flex-grow-1 overflow-auto">
                                                <h6 class="mb-2 fs-5" style="color:#7E7E7E;">Design Code: <span class="font-semibold text-dark">${value.DesignNo}</span></h6>
                                                <p class="fw-medium fs-6 mb-4" style="color:#F78D1E;">Multiple Sizes Available</p>
                                                <div class="overflow-auto">
                                                    <table class="table table-bordered text-center align-middle">
                                                        <thead class="table-dark border-0"><tr><th></th>`;
                
                        variants.forEach((_, i) => {
                            productHTML += `<th>Variant #${i + 1}</th>`;
                        });
                
                        productHTML += `</tr></thead><tbody>`;
                
                        // Dynamic rows for variant attributes
                        const attrs = ['Purity', 'color', 'unit', 'style', 'making', 'size', 'weight', 'qty'];
                        const labels = ['Purity', 'Color', 'Unit', 'Style', 'Making %', 'Size', 'Weight', 'In Stock'];
                        
                        attrs.forEach((attr, i) => {
                            productHTML += `<tr><td>${labels[i]}</td>`;
                            variants.forEach(variant => {
                                let val = variant[attr] ?? '-';
                                if (attr === 'Weight' && val !== '-') val += 'g';
                                if (attr === 'Qty' && val !== '-') val += ' Pcs';
                                productHTML += `<td>${val}</td>`;
                            });
                            productHTML += `</tr>`;
                        });
                
                        // Quantity input row
                        productHTML += `<tr><td>Qty</td>`;
                        variants.forEach(variant => {
                            productHTML += `<td>
                                <div class="input-group quantity-input-group quantity-container">
                                    <input type="button" value="-" class="qtyminus" field="quantity">
                                    <input type="text" name="mquantity${variant.productID}" id="mquantity${variant.productID}" value="1" class="qty">
                                    <input type="button" value="+" class="qtyplus" field="quantity">
                                </div>
                            </td>`;
                        });
                        productHTML += `</tr>`;
                
                        // Add to cart row
                        productHTML += `<tr><td>Add to Cart</td>`;
                        variants.forEach(variant => {
                            let inCart = result.cart[variant.productID]?.length > 0;
                            let cartQty = result.cartcount[variant.productID] ?? 0;
                            productHTML += `<td>
                                <button onclick="addforcart(${variant.productID})" class="btn ${inCart ? 'added-to-cart-btn' : 'add-to-cart-btn'} spinner-button" data_id="card_id_${variant.productID}">
                                    <span class="submit-text">${inCart ? 'ADDED TO CART' : 'ADD TO CART'}</span>
                                    <span class="d-none spinner">
                                        <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                                        <span role="status">Adding...</span>
                                    </span>
                                    <span id="applycurrentcartcount${variant.productID}" class="added-to-cart-badge ms-2">${cartQty}</span>
                                </button>
                            </td>`;
                        });
                
                        productHTML += `
                            </tr></tbody></table>
                        </div></div></div>
                            <button type="button" class="btn btn-link close-btn" data-bs-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                height="25" viewBox="0 0 25 25" fill="none">
                                                                <path
                                                                    d="M12.375 23.75C10.8812 23.75 9.40205 23.4558 8.02198 22.8841C6.6419 22.3125 5.38793 21.4746 4.33166 20.4183C3.27539 19.3621 2.43752 18.1081 1.86587 16.728C1.29422 15.3479 1 13.8688 1 12.375C1 10.8812 1.29422 9.40205 1.86587 8.02197C2.43752 6.6419 3.27539 5.38793 4.33166 4.33166C5.38793 3.27539 6.6419 2.43752 8.02198 1.86587C9.40206 1.29422 10.8812 1 12.375 1C13.8688 1 15.3479 1.29422 16.728 1.86587C18.1081 2.43752 19.3621 3.2754 20.4183 4.33166C21.4746 5.38793 22.3125 6.6419 22.8841 8.02198C23.4558 9.40206 23.75 10.8812 23.75 12.375C23.75 13.8688 23.4558 15.3479 22.8841 16.728C22.3125 18.1081 21.4746 19.3621 20.4183 20.4183C19.3621 21.4746 18.1081 22.3125 16.728 22.8841C15.3479 23.4558 13.8688 23.75 12.375 23.75L12.375 23.75Z"
                                                                    stroke="#535353" stroke-width="1.47967"
                                                                    stroke-linecap="round" />
                                                                <path d="M8.58203 8.58398L16.1654 16.1673"
                                                                    stroke="#535353" stroke-width="1.47967"
                                                                    stroke-linecap="round" />
                                                                <path d="M16.168 8.58398L8.58464 16.1673"
                                                                    stroke="#535353" stroke-width="1.47967"
                                                                    stroke-linecap="round" />
                                                            </svg></button>
                        </div>
                    </div>
                </div>`;
                    } else {
                        // SINGLE VARIANT
                        productHTML += `<div class="mt-3 grid cols-3 card-content_wrapper">`;
                
                        const singleAttrs = [
                            { key: 'variant_unit', label: 'Unit' },
                            { key: 'variant_style', label: 'Style' },
                            { key: 'variant_making', label: 'Making %' },
                            { key: 'variant_color', label: 'Color' },
                            { key: 'variant_size', label: 'Size' },
                            { key: 'variant_weight', label: 'Weight', suffix: 'g' }
                        ];
                
                        singleAttrs.forEach(attr => {
                            if (value[attr.key]) {
                                productHTML += `
                                <div class="d-flex flex-column gap-1">
                                    <div class="card-text text-dark">${attr.label}</div>
                                    <div class="product-card-badge">${value[attr.key]}${attr.suffix || ''}</div>
                                </div>`;
                            }
                        });
                
                        productHTML += `</div>
                            <div class="product-cart-qty-text mt-2">In Stock: <span>${value.variant_qty ?? '-'}</span> Pcs</div>
                            <div class="shop-page-add-to-cart-btn mt-3">
                                <div class="d-flex align-items-center">
                                    <label class="me-2">Qty</label>
                                    <div class="input-group quantity-input-group quantity-container">
                                        <input type="button" value="-" class="qtyminus" field="quantity">
                                        <input type="text" name="quantity" id="quantity${value.id}" value="1" class="qty">
                                        <input type="button" value="+" class="qtyplus" field="quantity">
                                    </div>
                                </div>
                                <button onclick="addforcart(${value.id})" class="btn mt-3 ${result.cart[value.id]?.length ? 'added-to-cart-btn' : 'add-to-cart-btn'} spinner-button" data_id="card_id_${value.id}">
                                    <span class="submit-text">${result.cart[value.id]?.length ? 'ADDED TO CART' : 'ADD TO CART'}</span>
                                    <span class="d-none spinner">
                                        <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                                        <span role="status">Adding...</span>
                                    </span>
                                    <span class="added-to-cart-badge ms-2">${result.cartcount[value.id] ?? ''}</span>
                                </button>
                            </div>`;
                    }
                
                    productHTML += `</div></div>`; // Close .card-body and .card
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
                $.each(result.procategorywiseproduct.data, function (key, value) {
                    $("#notfound").empty(); // Clear 'no results' notice if any
                    let encryptedId = $("#encrypt" + value.id).val();
                    let productDetailUrl = "/retailer/productdetail/" + encryptedId;
                    let secureImg = value.secureFilename;
                    let variantCount = value.variant_count ?? 1;
                    let variants = value.variants ?? [];
                
                    let safeDesignNo = value.DesignNo.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                    let productHTML = `
                    <div class="card shop-page_product-card">
                        <div class="card-img-top d-flex align-items-center justify-content-center position-relative">
                            <a href="${productDetailUrl}">
                                <img class="img-fluid prouduct_card-image load-secure-image" src="${baseurl}/load-loading.gif" data-secure="${secureImg}" width="255" height="255" alt="">
                            </a>
                            <div class="position-absolute card-purity purity-list">Purity: ${value.variant_purity ?? 'N/A'}</div>
                        </div>
                
                        <div class="card-body d-flex flex-column">
                            <div class="card-title">
                                <a href="${productDetailUrl}" class="text-decoration-none">${value.DesignNo}</a>
                            </div>`;
                
                    // MULTIPLE VARIANTS
                    if (variantCount > 1 && variants.length > 1) {
                        productHTML += `
                        <div class="mt-3">
                            <div class="card-text fw-bold">Multiple Sizes Available</div>
                            <button class="btn btn-warning mt-2" data-bs-toggle="modal" data-bs-target="#productModal-${safeDesignNo}">
                                View All Options
                            </button>
                
                            <!-- Modal -->
                            <div class="modal fade product-variants-modal" id="productModal-${safeDesignNo}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content rounded-4 overflow-hidden">
                                        <div class="modal-body p-4 d-flex flex-column flex-lg-row gap-4">
                                            <div class="modal-image text-center flex-shrink-0" style="flex: 0 0 200px;">
                                                <img class="img-fluid load-secure-image" src="${baseurl}/load-loading.gif" data-secure="${secureImg}" width="200" height="200" alt="${value.DesignNo}">
                                            </div>
                                            <div class="modal-details flex-grow-1 overflow-auto">
                                                <h6 class="mb-2 fs-5" style="color:#7E7E7E;">Design Code: <span class="font-semibold text-dark">${value.DesignNo}</span></h6>
                                                <p class="fw-medium fs-6 mb-4" style="color:#F78D1E;">Multiple Sizes Available</p>
                                                <div class="overflow-auto">
                                                    <table class="table table-bordered text-center align-middle">
                                                        <thead class="table-dark border-0"><tr><th></th>`;
                
                        variants.forEach((_, i) => {
                            productHTML += `<th>Variant #${i + 1}</th>`;
                        });
                
                        productHTML += `</tr></thead><tbody>`;
                
                        // Dynamic rows for variant attributes
                        const attrs = ['Purity', 'color', 'unit', 'style', 'making', 'size', 'weight', 'qty'];
                        const labels = ['Purity', 'Color', 'Unit', 'Style', 'Making %', 'Size', 'Weight', 'In Stock'];
                        
                        attrs.forEach((attr, i) => {
                            productHTML += `<tr><td>${labels[i]}</td>`;
                            variants.forEach(variant => {
                                let val = variant[attr] ?? '-';
                                if (attr === 'Weight' && val !== '-') val += 'g';
                                if (attr === 'Qty' && val !== '-') val += ' Pcs';
                                productHTML += `<td>${val}</td>`;
                            });
                            productHTML += `</tr>`;
                        });
                
                        // Quantity input row
                        productHTML += `<tr><td>Qty</td>`;
                        variants.forEach(variant => {
                            productHTML += `<td>
                                <div class="input-group quantity-input-group quantity-container">
                                    <input type="button" value="-" class="qtyminus" field="quantity">
                                    <input type="text" name="mquantity${variant.productID}" id="mquantity${variant.productID}" value="1" class="qty">
                                    <input type="button" value="+" class="qtyplus" field="quantity">
                                </div>
                            </td>`;
                        });
                        productHTML += `</tr>`;
                
                        // Add to cart row
                        productHTML += `<tr><td>Add to Cart</td>`;
                        variants.forEach(variant => {
                            let inCart = result.cart[variant.productID]?.length > 0;
                            let cartQty = result.cartcount[variant.productID] ?? 0;
                            productHTML += `<td>
                                <button onclick="addforcart(${variant.productID})" class="btn ${inCart ? 'added-to-cart-btn' : 'add-to-cart-btn'} spinner-button" data_id="card_id_${variant.productID}">
                                    <span class="submit-text">${inCart ? 'ADDED TO CART' : 'ADD TO CART'}</span>
                                    <span class="d-none spinner">
                                        <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                                        <span role="status">Adding...</span>
                                    </span>
                                    <span id="applycurrentcartcount${variant.productID}" class="added-to-cart-badge ms-2">${cartQty}</span>
                                </button>
                            </td>`;
                        });
                
                        productHTML += `
                            </tr></tbody></table>
                        </div></div></div>
                            <button type="button" class="btn btn-link close-btn" data-bs-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                height="25" viewBox="0 0 25 25" fill="none">
                                                                <path
                                                                    d="M12.375 23.75C10.8812 23.75 9.40205 23.4558 8.02198 22.8841C6.6419 22.3125 5.38793 21.4746 4.33166 20.4183C3.27539 19.3621 2.43752 18.1081 1.86587 16.728C1.29422 15.3479 1 13.8688 1 12.375C1 10.8812 1.29422 9.40205 1.86587 8.02197C2.43752 6.6419 3.27539 5.38793 4.33166 4.33166C5.38793 3.27539 6.6419 2.43752 8.02198 1.86587C9.40206 1.29422 10.8812 1 12.375 1C13.8688 1 15.3479 1.29422 16.728 1.86587C18.1081 2.43752 19.3621 3.2754 20.4183 4.33166C21.4746 5.38793 22.3125 6.6419 22.8841 8.02198C23.4558 9.40206 23.75 10.8812 23.75 12.375C23.75 13.8688 23.4558 15.3479 22.8841 16.728C22.3125 18.1081 21.4746 19.3621 20.4183 20.4183C19.3621 21.4746 18.1081 22.3125 16.728 22.8841C15.3479 23.4558 13.8688 23.75 12.375 23.75L12.375 23.75Z"
                                                                    stroke="#535353" stroke-width="1.47967"
                                                                    stroke-linecap="round" />
                                                                <path d="M8.58203 8.58398L16.1654 16.1673"
                                                                    stroke="#535353" stroke-width="1.47967"
                                                                    stroke-linecap="round" />
                                                                <path d="M16.168 8.58398L8.58464 16.1673"
                                                                    stroke="#535353" stroke-width="1.47967"
                                                                    stroke-linecap="round" />
                                                            </svg></button>
                        </div>
                    </div>
                </div>`;
                    } else {
                        // SINGLE VARIANT
                        productHTML += `<div class="mt-3 grid cols-3 card-content_wrapper">`;
                
                        const singleAttrs = [
                            { key: 'variant_unit', label: 'Unit' },
                            { key: 'variant_style', label: 'Style' },
                            { key: 'variant_making', label: 'Making %' },
                            { key: 'variant_color', label: 'Color' },
                            { key: 'variant_size', label: 'Size' },
                            { key: 'variant_weight', label: 'Weight', suffix: 'g' }
                        ];
                
                        singleAttrs.forEach(attr => {
                            if (value[attr.key]) {
                                productHTML += `
                                <div class="d-flex flex-column gap-1">
                                    <div class="card-text text-dark">${attr.label}</div>
                                    <div class="product-card-badge">${value[attr.key]}${attr.suffix || ''}</div>
                                </div>`;
                            }
                        });
                
                        productHTML += `</div>
                            <div class="product-cart-qty-text mt-2">In Stock: <span>${value.variant_qty ?? '-'}</span> Pcs</div>
                            <div class="shop-page-add-to-cart-btn mt-3">
                                <div class="d-flex align-items-center">
                                    <label class="me-2">Qty</label>
                                    <div class="input-group quantity-input-group quantity-container">
                                        <input type="button" value="-" class="qtyminus" field="quantity">
                                        <input type="text" name="quantity" id="quantity${value.id}" value="1" class="qty">
                                        <input type="button" value="+" class="qtyplus" field="quantity">
                                    </div>
                                </div>
                                <button onclick="addforcart(${value.id})" class="btn mt-3 ${result.cart[value.id]?.length ? 'added-to-cart-btn' : 'add-to-cart-btn'} spinner-button" data_id="card_id_${value.id}">
                                    <span class="submit-text">${result.cart[value.id]?.length ? 'ADDED TO CART' : 'ADD TO CART'}</span>
                                    <span class="d-none spinner">
                                        <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                                        <span role="status">Adding...</span>
                                    </span>
                                    <span class="added-to-cart-badge ms-2">${result.cartcount[value.id] ?? ''}</span>
                                </button>
                            </div>`;
                    }
                
                    productHTML += `</div></div>`; // Close .card-body and .card
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
