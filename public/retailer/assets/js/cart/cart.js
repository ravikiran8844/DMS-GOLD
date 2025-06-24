var baseurl = window.location.origin;
$(document).ready(function () {
    // Call the function to populate the cart on page load
    populateCart();
    displayItems();
});

function decrementQuantity(button) {
    var dataId = $(button).data("id");
    var moq = $("#moq" + dataId).val();

    const container = $(button).closest(".quantity-container");
    const qtyInput = container.find(".qty");
    let currentValue = parseInt(qtyInput.val(), 10);

    if (currentValue > moq) {
        qtyInput.val(currentValue - 1);

        container.find(".qtyminus").css("color", "black");
    } else {
        qtyInput.val(moq);
        container.find(".qtyminus").css("color", "red");
    }

    $.ajax({
        type: "GET",
        url: "cartqty",
        data: {
            product_id: dataId,
            qty: qtyInput.val(),
        },
        dataType: "json",
        success: function (data, textStatus, xhr) {
            if (data.response && data.response.length > 0) {
                const totalQty = data.response.reduce(
                    (total, item) => total + item.qty,
                    0
                );

                $("#qty").text(totalQty + "Qtys");
                $("#navqty").text(totalQty + "Pcs");
                $("#navqty-mob").text(totalQty + "Pcs");
                $("#totweight").text(
                    data.response.reduce(
                        (total, item) => total + item.qty * item.weight,
                        0
                    ) + "gms"
                );
                $("#navweight").text(
                    data.response.reduce(
                        (total, item) => total + item.qty * item.weight,
                        0
                    ) + "gms"
                );
                $("#navweight-mob").text(
                    data.response.reduce(
                        (total, item) => total + item.qty * item.weight,
                        0
                    ) + "gms"
                );
                $("#hdweight").val(
                    data.response.reduce(
                        (total, item) => total + item.qty * item.weight,
                        0
                    )
                );

                const productData = data.response.find(
                    (item) => item.product_id === dataId
                );

                if (productData) {
                    const productWeightedPrice =
                        productData.qty * productData.weight;

                    $("#totalweight" + dataId).text(
                        productWeightedPrice + "gms"
                    );
                    $("#mobiletotalweight" + dataId).text(
                        productWeightedPrice + "gms"
                    );
                } else {
                    console.log(
                        "Product data not found for product_id: " + dataId
                    );
                }
            } else {
                console.log("Invalid response format");
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(xhr);
        },
    });
}

function incrementQuantity(button) {
    var dataId = $(button).data("id");
    var readystock = $("#readystock" + dataId).val();
    var stock = $("#stock" + dataId).val();
    const container = $(button).closest(".quantity-container");
    const qtyInput = container.find(".qty");
    let currentValue = parseInt(qtyInput.val(), 10);
    // qtyInput.val(currentValue + 1);

    if (readystock == 1 && currentValue >= stock) {
        // If readystock is 1 and current value is greater than or equal to stock,
        // do not increase quantity beyond available stock
        alert("Quantity cannot exceed available ready stock");
    } else {
        // Otherwise, increase quantity by 1
        qtyInput.val(currentValue + 1);
    }
    // Change the color of the minus button
    container.find(".qtyminus").css("color", "black");

    $.ajax({
        type: "GET",
        url: "cartqty",
        data: {
            product_id: dataId,
            qty: qtyInput.val(),
        },
        dataType: "json",
        success: function (data, textStatus, xhr) {
            if (data.response && data.response.length > 0) {
                const totalQty = data.response.reduce(
                    (total, item) => total + item.qty,
                    0
                );

                $("#qty").text(totalQty + "Qtys");
                $("#navqty").text(totalQty + "Pcs");
                $("#navqty-mob").text(totalQty + "Pcs");
                $("#totweight").text(
                    data.response.reduce(
                        (total, item) => total + item.qty * item.weight,
                        0
                    ) + "gms"
                );
                $("#navweight").text(
                    data.response.reduce(
                        (total, item) => total + item.qty * item.weight,
                        0
                    ) + "gms"
                );
                $("#navweight-mob").text(
                    data.response.reduce(
                        (total, item) => total + item.qty * item.weight,
                        0
                    ) + "gms"
                );
                $("#hdweight").val(
                    data.response.reduce(
                        (total, item) => total + item.qty * item.weight,
                        0
                    )
                );

                const productData = data.response.find(
                    (item) => item.product_id === dataId
                );

                if (productData) {
                    const productWeightedPrice =
                        productData.qty * productData.weight;

                    $("#totalweight" + dataId).text(
                        productWeightedPrice + "gms"
                    );
                    $("#mobiletotalweight" + dataId).text(
                        productWeightedPrice + "gms"
                    );
                } else {
                    console.log(
                        "Product data not found for product_id: " + dataId
                    );
                }
            } else {
                console.log("Invalid response format");
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(xhr);
        },
    });
}

// Function to dynamically populate the table with cart items
function populateCart() {
    $.ajax({
        type: "GET",
        url: "getcartproducts", // Change this URL to the actual endpoint
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (window.matchMedia("(max-width: 768px)").matches) {
                // If mobile view (max-width: 768px)
                var route = "category";
            } else {
                // If desktop view
                var route = "home";
            }
            const cartItemsContainer = document.getElementById("cart-items");
            const cartContainer = document.getElementById("cart");
            cartItemsContainer.innerHTML = ""; // Clear existing items
            if (response.carts.length === 0) {
                // Clear existing items and set the cart count to 0

                // cartContainer.innerHTML = "";
                $('span[id="cartCount"]').text(0);
                document.getElementById("cart").innerHTML = `<div class="py-5">
            <div class="text-center">

                <div>
                <img class="img-fluid" width="212" height="212" src="/cart-no-tems.gif" alt="">
                </div>
                <div class="fw-semibold fs-3">Your Shopping Cart is empty</div>

                <div class="my-4">
                <a href="${route}" class="btn custom-btn btn-warning px-5 py-2 fw-semibold text-uppercase">Start Shopping</a>
                </div>

                <div class="d-flex gap-2 flex-column flex-md-row align-items-center justify-content-center">
                <div class=" text-uppercase">For Queries :</div>
                <div><a href="tel:+918220017619" class="link-yellow fw-semibold fs-5">Vivin - +91 82200 17619</a></div>
                </div>
            </div>
        </div>`;
            } else {
                response.carts.forEach((item) => {
                    const row = document.createElement("tr");
                    var eid = $("#encrypt" + item.product_id).val();

                    var productDetailUrl = "productdetail/productId".replace(
                        "productId",
                        eid
                    );
                    row.innerHTML = `
                        <td class="text-center"><a href="${productDetailUrl}">
                                <img class="square bg-white p-2" src="${baseurl}/upload/product/${
                        item.product_image
                    }" width="60" height="60" alt=""></a>
                        </td>
                        <td class="text-center">${item.product_unique_id} 
                        <div class="product-cart-qty-text mt-2 text-center m-auto">In Stock: <span
                                                        class="fw-semibold"
                                                        style="font-size:10px;">${
                                                            item.stock
                                                        }</span>
                                                </div>
                         </td>
                        <td class="text-center">
                            <div class="input-group quantity-input-group quantity-container">
                                <input type='button' value='-' class='qtyminus' onclick="decrementQuantity(this)" field='quantity' data-id='${
                                    item.product_id
                                }' />
                                <input type='text' name='quantity' value='${
                                    item.qty
                                }' readonly class='qty' />
                                <input type='button' onclick="incrementQuantity(this)" value='+' class='qtyplus' field='quantity' data-id='${
                                    item.product_id
                                }' />
                            </div>
                        </td>                
                        <td class="text-center">${item.weight}gms</td>
                        <td class="text-center" id="totalweight${
                            item.product_id
                        }">${item.weight * item.qty}gms</td>
                        ${
                            item.height && item.width
                                ? `<td class="text-center">${item.height} x ${item.width}</td>`
                                : `<td class="text-center">-</td>`
                        }
                    <td class="text-center">${item.style_name}</td>
                        <td class="text-center">
                            <button type='button' class="border-0 bg-transparent" onclick="removeItem(this,${
                                item.id
                            })">
                                <svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.81443 19.9863C1.85397 20.5382 2.10311 21.0541 2.51057 21.4284C2.91822 21.8029 3.45332 22.0072 4.00668 21.9998H13.4379C13.9912 22.0072 14.5263 21.8028 14.934 21.4284C15.3415 21.0542 15.5906 20.5382 15.6301 19.9863L16.3703 7.22372C16.6866 7.10023 16.9584 6.88431 17.1499 6.60394C17.3416 6.32375 17.4442 5.99211 17.4443 5.65269V4.46203C17.4438 4.01465 17.2658 3.58588 16.9493 3.26956C16.633 2.95326 16.2042 2.77526 15.7568 2.77452H12.5268L12.3456 1.50118C12.2943 1.08937 12.0952 0.710071 11.7852 0.434012C11.4754 0.157968 11.0756 0.00378985 10.6608 0H6.7785C6.36435 0.00487458 5.96609 0.159775 5.65717 0.435639C5.34845 0.711684 5.15002 1.09027 5.09877 1.50119L4.91498 2.77453H1.6875C1.24013 2.77526 0.811352 2.95327 0.495038 3.26957C0.178553 3.58588 0.000554613 4.01465 0 4.46204V5.6527C0.000180526 5.99211 0.102728 6.32378 0.294457 6.60395C0.486007 6.88433 0.757698 7.10024 1.07401 7.22373L1.81443 19.9863ZM14.3385 19.9112C14.3176 20.1332 14.2129 20.3391 14.0455 20.4867C13.8781 20.6342 13.6608 20.7126 13.4378 20.7057H4.00664C3.78368 20.7126 3.56631 20.6342 3.39897 20.4867C3.23161 20.3391 3.1269 20.1332 3.10596 19.9112L2.37859 7.34042H15.0607L14.3385 19.9112ZM6.39276 1.68245C6.41154 1.46959 6.58305 1.30241 6.79645 1.28905H10.6787C10.88 1.3165 11.0351 1.48006 11.0514 1.68245L11.2092 2.76949L6.22458 2.76967L6.39276 1.68245ZM1.29402 4.46221C1.29529 4.24556 1.47077 4.07026 1.68741 4.06882H15.7566C15.9732 4.07026 16.1487 4.24556 16.1499 4.46221V5.65287C16.1499 5.87006 15.9739 6.04626 15.7566 6.04626H1.68741C1.47005 6.04626 1.29402 5.87006 1.29402 5.65287V4.46221Z" fill="#F78D1E"/>
                                    <path d="M8.72227 19.0236C8.89396 19.0236 9.05843 18.9553 9.17975 18.834C9.30107 18.7127 9.36931 18.5481 9.36931 18.3765V8.92964C9.36931 8.57235 9.07955 8.28259 8.72227 8.28259C8.36498 8.28259 8.07522 8.57235 8.07522 8.92964V18.3715C8.07377 18.5439 8.14148 18.7098 8.26298 18.8324C8.3843 18.9548 8.54967 19.0237 8.72227 19.0237V19.0236Z" fill="#F78D1E"/>
                                    <path d="M5.74266 18.3377H5.77895C5.95119 18.3289 6.11277 18.252 6.22777 18.1236C6.34295 17.9954 6.40216 17.8264 6.39242 17.6544L5.95227 9.56122C5.93313 9.20393 5.62766 8.92988 5.27037 8.9492C4.91308 8.96852 4.63904 9.27381 4.65817 9.6311L5.09832 17.7298C5.11872 18.0709 5.4009 18.3372 5.74264 18.3381L5.74266 18.3377Z" fill="#F78D1E"/>
                                    <path d="M11.6652 18.3349H11.7015C12.0421 18.3343 12.3241 18.0693 12.3458 17.7293L12.7832 9.63615C12.8025 9.27887 12.5285 8.97339 12.1712 8.95407C11.8137 8.93493 11.5084 9.20881 11.4891 9.56627L11.0517 17.6544C11.0427 17.8261 11.102 17.9943 11.2172 18.122C11.3322 18.2496 11.4935 18.3263 11.6651 18.335L11.6652 18.3349Z" fill="#F78D1E"/>
                                </svg>
                            </button>
                        </td>`;
                    cartItemsContainer.appendChild(row);
                });
            }
        },
        error: function (error) {
            console.error("Error fetching cart items:", error);
        },
    });
}

function displayItems() {
    $.ajax({
        type: "GET",
        url: "getcartproducts", // Change this URL to the actual endpoint
        dataType: "json",
        success: function (response) {
            const itemsContainer = document.getElementById("items-container");
            const cartContainer = document.getElementById("cart");
            itemsContainer.innerHTML = ""; // Clear the items container
            if (response.carts.length === 0) {
                $('span[id="cartCount"]').text(0);
                cartContainer.innerHTML = "<img src='/cart-no-tems.gif'>";
            } else {
                response.carts.forEach((item, index) => {
                    const itemDiv = document.createElement("div");
                    itemDiv.classList.add("mobile-cart_item");
                    var eid = $("#encrypt" + item.product_id).val();

                    var productDetailUrl = "productdetail/productId".replace(
                        "productId",
                        eid
                    );
                    itemDiv.innerHTML = `
                    <div class="d-flex">
                        <div class="me-2">
                            <a href="${productDetailUrl}"><img class="mobile-cart-img square bg-white" src="${baseurl}/${
                        "upload/product/" + item.product_image
                    }" width="80" height="80" alt=""></a>
                        </div>
                        
                            <div class="flex-grow-1">
                        <div class="d-flex justify-content-between">
                          
                            <div class="cart-page_card-bold-title mb-2">${
                                item.product_unique_id
                            }</div>
                            <div class="cart-page_card-bold-title mb-2">${
                                item.weight
                            }gms</div>
                        
                        </div>

                        <div class="d-flex justify-content-between">
                          
                            <div class="cart-page_card-bold-title mb-2 text-success">Box: ${
                                item.style_name
                            }</div>
                            <div class="cart-page_card-light-text mb-2">Size(cm): <b>${
                                item.height && item.width
                                    ? `${item.height} x ${item.width}`
                                    : "-"
                            }</b></div>
                        </div>

                        <div class="mb-2">
                          <div class="available-qty">Qty Available : ${
                              item.stock
                          } Pcs</div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="input-group quantity-input-group quantity-container">
                                <input type='button' onclick="decrementQuantity(this)" value='-' class='qtyminus' field='quantity'  data-id='${
                                    item.product_id
                                }'/>
                                <input type='text' name='quantity' value='${
                                    item.qty
                                }' class='qty' />
                                <input type='button' onclick="incrementQuantity(this)" value='+' class='qtyplus' field='quantity'  data-id='${
                                    item.product_id
                                }' />
                            </div>


                           <div>
                            <button type="button" class="border-0 bg-transparent" onclick="removeItem(this,${
                                item.id
                            })">
                                  <svg width="18" height="23" viewBox="0 0 18 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M1.83337 20.1949C1.87332 20.7525 2.12506 21.2739 2.53677 21.652C2.94867 22.0304 3.48935 22.2369 4.04849 22.2294H13.5781C14.1372 22.2369 14.6779 22.0304 15.0898 21.652C15.5016 21.2739 15.7533 20.7525 15.7932 20.1949L16.5412 7.29911C16.8608 7.17433 17.1353 6.95615 17.3289 6.67286C17.5226 6.38974 17.6262 6.05464 17.6264 5.71168V4.50859C17.6259 4.05655 17.446 3.6233 17.1262 3.30368C16.8066 2.98408 16.3733 2.80423 15.9213 2.80348H12.6576L12.4744 1.51685C12.4226 1.10074 12.2214 0.717481 11.9082 0.438542C11.5951 0.159616 11.1912 0.0038294 10.7721 0H6.84925C6.43077 0.00492546 6.02835 0.161442 5.71621 0.440185C5.40427 0.719111 5.20377 1.10164 5.15198 1.51686L4.96627 2.80349H1.70511C1.25307 2.80422 0.81982 2.98409 0.500204 3.30369C0.180416 3.6233 0.000560401 4.05654 0 4.5086V5.71169C0.00018241 6.05464 0.1038 6.38977 0.29753 6.67287C0.491079 6.95617 0.765605 7.17433 1.08522 7.29912L1.83337 20.1949ZM14.4882 20.119C14.467 20.3434 14.3612 20.5513 14.1921 20.7005C14.023 20.8496 13.8033 20.9287 13.5781 20.9218H4.04846C3.82317 20.9287 3.60353 20.8496 3.43444 20.7005C3.26534 20.5513 3.15953 20.3433 3.13838 20.119L2.40341 7.41703H15.2179L14.4882 20.119ZM6.45948 1.7C6.47845 1.48493 6.65175 1.316 6.86738 1.30251H10.7902C10.9936 1.33023 11.1503 1.49551 11.1667 1.7L11.3261 2.79839L6.28954 2.79857L6.45948 1.7ZM1.30753 4.50878C1.3088 4.28987 1.48612 4.11274 1.70502 4.11128H15.921C16.1399 4.11274 16.3172 4.28987 16.3185 4.50878V5.71187C16.3185 5.93132 16.1406 6.10936 15.921 6.10936H1.70502C1.48539 6.10936 1.30753 5.93132 1.30753 5.71187V4.50878Z" fill="#A9A9A9"/>
                                  <path d="M8.813 19.2222C8.98648 19.2222 9.15267 19.1533 9.27526 19.0307C9.39785 18.9081 9.4668 18.7417 9.4668 18.5684V9.02294C9.4668 8.66193 9.17402 8.36914 8.813 8.36914C8.45199 8.36914 8.1592 8.66193 8.1592 9.02294V18.5633C8.15774 18.7375 8.22615 18.9052 8.34892 19.029C8.47151 19.1527 8.63861 19.2224 8.813 19.2224V19.2222Z" fill="#A9A9A9"/>
                                  <path d="M5.80184 18.5292H5.83851C6.01254 18.5203 6.17581 18.4426 6.29201 18.3129C6.40839 18.1834 6.46823 18.0126 6.45838 17.8388L6.01363 9.66112C5.9943 9.30011 5.68564 9.0232 5.32462 9.04272C4.96361 9.06224 4.6867 9.37071 4.70603 9.73173L5.15078 17.915C5.17139 18.2596 5.45652 18.5287 5.80182 18.5296L5.80184 18.5292Z" fill="#A9A9A9"/>
                                  <path d="M11.7868 18.5263H11.8235C12.1677 18.5258 12.4527 18.258 12.4745 17.9144L12.9165 9.73679C12.9361 9.37577 12.6591 9.06711 12.2981 9.04759C11.9369 9.02825 11.6284 9.30498 11.6089 9.66617L11.1669 17.8387C11.1578 18.0122 11.2178 18.1822 11.3342 18.3111C11.4504 18.4401 11.6133 18.5177 11.7868 18.5264L11.7868 18.5263Z" fill="#A9A9A9"/>
                                  </svg>
                            </button>
                          </div>
                        </div>

                      </div>
                    </div>                  
                `;
                    itemsContainer.appendChild(itemDiv);
                });
            }
        },
        error: function (error) {
            console.error("Error fetching cart items:", error);
        },
    });
}

// Function to remove an item from the cart
function removeItem(button, id) {
    // Show the confirmation dialog
    Swal.fire({
        title: "Are you sure?",
        // text: "You won't be able to revert this!",
        icon: "error",
        showCancelButton: true,
        confirmButtonText: "Yes, remove it!",
        customClass: {
            confirmButton: "btn btn-success me-2",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    }).then((result) => {
        if (result.isConfirmed) {
            // Check if it's a mobile device based on screen width
            const isMobile = window.innerWidth <= 768; // Adjust the threshold as needed
            if (isMobile) {
                // Remove the item from the table (client-side) for mobile
                const itemDiv = button.closest(".mobile-cart_item");
                itemDiv.remove();
            } else {
                // Remove the item from the table (client-side) for desktop
                const row = button.closest("tr");
                row.remove();
            }
            // Proceed with the AJAX request to remove the item from the server
            $.ajax({
                type: "GET",
                url: "removecart/" + id,
                dataType: "json",
                success: function (data) {
                    // Handle the success response from the server
                    if (data.cartQty) {
                        $('span[id="cartCount"]').text(data.cartQty);
                    }
                    if (data.cartqtycount == 0) {
                        $("#navqty").text(data.cartqtycount + " Pcs");
                        $("#navqty-mob").text(data.cartqtycount + " Pcs");
                        $("#navweight").text(data.cartqtycount + "gms");
                        $("#navweight-mob").text(data.cartqtycount + "gms");
                    }
                    populateCart();
                    incrementQuantity();
                    var type = data.notification.alert;
                    var message = data.notification.message;

                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 1500,
                    };

                    switch (type) {
                        case "success":
                            toastr.success(message);
                            break;
                        case "error":
                            toastr.error(message);
                            break;
                    }
                },
            });
        }
    });
}

function removeAllCart() {
    Swal.fire({
        title: "Are you sure?",
        // text: "You won't be able to revert this!",
        icon: "error",
        showCancelButton: true,
        confirmButtonText: "Yes, remove it!",
        cancelButtonText: "No, cancel this action",
        customClass: {
            confirmButton: "btn btn-success me-2",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "GET",
                url: "removeallcart",
                dataType: "json",
                success: function (data) {
                    if (data.cartQty) {
                        $('span[id="cartCount"]').text(data.cartQty);
                    }
                    var type = data.notification.alert;
                    var message = data.notification.message;

                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 1500,
                    };

                    switch (type) {
                        case "success":
                            toastr.success(message);
                            break;
                        case "error":
                            toastr.error(message);
                            break;
                    }
                    window.location.reload();
                },
            });
        }
    });
}
