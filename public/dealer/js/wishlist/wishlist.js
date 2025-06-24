var baseurl = window.location.origin;
$(document).ready(function () {
    // Call the function to populate the cart on page load
    wishlistItems();
    displayItems();
});
// Sample JSON object representing wishlist items

// Function to display items from the JSON object
function wishlistItems() {
    $.ajax({
        type: "GET",
        url: "wishlistproducts", // Change this URL to the actual endpoint
        dataType: "json",
        success: function (response) {
            const wishlistItemsContainer =
                document.getElementById("wishlist-items");
            const wishlistContainer = document.getElementById("wishlist");
            wishlistItemsContainer.innerHTML = ""; // Clear the items container

            if (response.wishlist.length === 0) {
                wishlistContainer.innerHTML =
                    "<img src='" +
                    baseurl +
                    "/emptycart.gif' alt='' style='height:auto;width:35%;margin-left:30%'>";
            } else {
                response.wishlist.forEach((item) => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                    <td>
                    <div class="position-relative">
                    <input type='hidden' id='quantity${
                        item.product_id
                    }' name='quantity${item.product_id}' value='${item.moq}' />
                    <input type='hidden' id='size${item.product_id}' value='${
                        item.size_id
                    }' />
                    <input type='hidden' id='weight${item.product_id}' value='${
                        item.weight
                    }' />
                    <input type='hidden' id='plating${
                        item.product_id
                    }' value='${item.plating_id}' />
                    <input type='hidden' id='color${item.product_id}' value='${
                        item.color_id
                    }' />
                    <input type="hidden" name="stock${
                        item.product_id
                    }" id="stock${item.product_id}"
                                    value="1">
                        <img class="square bg-white p-2" src="${baseurl}/${
                        "upload/product/" + item.product_image
                    }" width="75" height="75" alt="">
                       
                    </div>
                  </td>
                  <td>${item.product_unique_id}</td>    
                  <td>
                    <div class="wishlist_item_title mt-0">${
                        item.product_name
                    }</div>
                  </td>
                  <td>
                    <div class="badge wishlist-in-stock">IN STOCK </div>
                  </td>
                  <td>
                  <button type="button" onclick="addforcart(${
                      item.product_id
                  })" class="btn wishlist_add-to-cart-btn d-flex justify-content-center align-items-center">Add to Cart </button>
                    </td>
                      <button class="border-0 bg-transparent" style='margin-top:30px;' onclick="removeItem(this,${
                          item.id
                      })">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="21" viewBox="0 0 18 21" fill="none">
                                <path d="M2.45462 19.0778C2.49236 19.6046 2.73018 20.0971 3.11911 20.4544C3.50823 20.8118 4.019 21.0069 4.54721 20.9998H13.5497C14.0779 21.0069 14.5887 20.8118 14.9778 20.4544C15.3668 20.0972 15.6046 19.6046 15.6423 19.0778L16.3489 6.89537C16.6508 6.77749 16.9102 6.57138 17.093 6.30376C17.276 6.0363 17.3739 5.71974 17.3741 5.39575V4.25921C17.3736 3.83217 17.2036 3.42288 16.9015 3.12095C16.5996 2.81902 16.1903 2.64912 15.7633 2.64841H12.6801L12.5071 1.43294C12.4581 1.03985 12.268 0.677795 11.9721 0.414284C11.6764 0.150787 11.2949 0.00361759 10.8989 0H7.19305C6.79772 0.00465301 6.41756 0.152512 6.12268 0.415837C5.82799 0.679335 5.63859 1.04071 5.58966 1.43295L5.41423 2.64842H2.33345C1.90641 2.64911 1.49713 2.81903 1.19519 3.12095C0.893093 3.42288 0.723186 3.83216 0.722656 4.25922V5.39576C0.722829 5.71974 0.820715 6.03633 1.00373 6.30377C1.18657 6.5714 1.44591 6.7775 1.74785 6.89538L2.45462 19.0778ZM14.4094 19.0061C14.3894 19.2181 14.2895 19.4146 14.1297 19.5555C13.97 19.6963 13.7625 19.7711 13.5497 19.7646H4.54718C4.33435 19.7711 4.12686 19.6963 3.96713 19.5555C3.80738 19.4145 3.70743 19.2181 3.68744 19.0061L2.99312 7.00676H15.0988L14.4094 19.0061ZM6.82484 1.60597C6.84276 1.40279 7.00648 1.24321 7.21017 1.23046H10.916C11.1081 1.25666 11.2562 1.41279 11.2717 1.60597L11.4223 2.6436L6.6643 2.64377L6.82484 1.60597ZM1.95786 4.25938C1.95907 4.05258 2.12657 3.88525 2.33337 3.88387H15.763C15.9698 3.88525 16.1373 4.05258 16.1385 4.25938V5.39592C16.1385 5.60324 15.9705 5.77143 15.763 5.77143H2.33337C2.12588 5.77143 1.95786 5.60324 1.95786 5.39592V4.25938Z" fill="#B6B6B6"/>
                                <path d="M9.04832 18.1588C9.21221 18.1588 9.3692 18.0937 9.48501 17.9779C9.60082 17.8621 9.66596 17.7049 9.66596 17.5412V8.5237C9.66596 8.18266 9.38937 7.90607 9.04832 7.90607C8.70728 7.90607 8.43069 8.18266 8.43069 8.5237V17.5364C8.42931 17.7009 8.49393 17.8593 8.60991 17.9763C8.72572 18.0932 8.88357 18.159 9.04832 18.159V18.1588Z" fill="#B6B6B6"/>
                                <path d="M6.20407 17.5042H6.23871C6.40311 17.4957 6.55735 17.4223 6.66712 17.2998C6.77707 17.1775 6.83359 17.0161 6.82429 16.8519L6.40414 9.12662C6.38588 8.78557 6.09429 8.52398 5.75324 8.54242C5.4122 8.56086 5.15061 8.85227 5.16887 9.19332L5.58901 16.9239C5.60849 17.2495 5.87784 17.5037 6.20405 17.5045L6.20407 17.5042Z" fill="#B6B6B6"/>
                                <path d="M11.857 17.5015H11.8916C12.2168 17.501 12.486 17.248 12.5066 16.9235L12.9242 9.19818C12.9426 8.85714 12.681 8.56555 12.34 8.54711C11.9988 8.52884 11.7074 8.79026 11.6889 9.13148L11.2714 16.8519C11.2627 17.0158 11.3194 17.1764 11.4294 17.2983C11.5392 17.4201 11.6931 17.4934 11.8569 17.5016L11.857 17.5015Z" fill="#B6B6B6"/>
                                </svg> 
    </button>
                  </td>`;
                    wishlistItemsContainer.appendChild(row);
                });
            }
        },
        error: function (error) {
            console.error("Error fetching wishlist items:", error);
        },
    });
}

// Function to display items from the JSON object
function displayItems() {
    $.ajax({
        type: "GET",
        url: "wishlistproducts", // Change this URL to the actual endpoint
        dataType: "json",
        success: function (response) {
            const mobileWishlistItemsContainer = document.getElementById(
                "mobile-wishlist-items"
            );
            const mobileWishlistContainer = document.getElementById("wishlist");
            mobileWishlistItemsContainer.innerHTML = ""; // Clear the items container
            if (response.wishlist.length === 0) {
                mobileWishlistContainer.innerHTML =
                    "<img src='" +
                    baseurl +
                    "/emptycart.gif' alt=''>";
            } else {
                const table = document.createElement("table");
                table.classList.add("table");
                const tbody = document.createElement("tbody");

                response.wishlist.forEach((item, index) => {
                    const tr = document.createElement("tr");
                    let number = Math.random();

                    // Column 1: Image
                    const tdImage = document.createElement("td");
                    tdImage.classList.add("mobile-cart-image-container");
                    tdImage.innerHTML = `<td  class="text-center">
              <div class="position-relative">
              <input type='hidden' id='quantity${
                  item.product_id
              }' name='quantity${item.product_id}' value='${item.moq}' />
            <input type='hidden' id='size${item.product_id}' value='${
                        item.size_id
                    }' />
            <input type='hidden' id='weight${item.product_id}' value='${
                        item.weight
                    }' />
            <input type='hidden' id='plating${item.product_id}' value='${
                        item.plating_id
                    }' />
            <input type='hidden' id='color${item.product_id}' value='${
                        item.color_id
                    }' />
                    <input type="hidden" name="stock${
                        item.product_id
                    }" id="stock${item.product_id}"
                                    value="1">
                                <img class="square bg-white p-2" src="${baseurl}/${
                        "upload/product/" + item.product_image
                    }" width="96" height="96" alt="">
                                <div class="${
                                    item.stock
                                        ? "d-none"
                                        : "wishlist-out-od-stock-overlay"
                                }">OUT OF STOCK</div>
                            </div>
              </td>`;
                    tr.appendChild(tdImage);

                    // Column 2: Item details
                    const tdDetails = document.createElement("td");
                    tdDetails.innerHTML = `<div>
                    <div class="d-flex justify-content-between">
                      <div class="d-flex gap-2">
                            
                            <div>
                              <div class="badge mb-2 ${
                                  item.stock
                                      ? "wishlist-in-stock"
                                      : "wishlist-out-of-stock"
                              }">${
                        item.stock ? "IN STOCK" : "OUT OF STOCK"
                    } </div>
                              <div class="mb-2 wishlist_light-text">Product SKU: <span class="wishlist_bold-text">${
                                  item.product_unique_id
                              }</span></div>
                              <div class="wishlist_item_title mb-2">${
                                  item.product_name
                              }hi</div>
                                <div class="wishlist_add-to-cart-btn_wrapper">
                                  <button onclick="addforcart(${
                                      item.product_id
                                  })" class="btn ${
                        item.stock
                            ? "wishlist_add-to-cart-btn"
                            : "wishlist_explore-btn"
                    }">${
                        item.stock ? "Add to Cart" : "EXPLORE SIMILAR"
                    }</button>
                                </div>
                              
                            </div>
                            
                        </div>
                      <div>
                        <button class="border-0 bg-transparent" onclick="removeItem(this,${
                            item.id
                        })">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="21" viewBox="0 0 18 21" fill="none">
                            <path d="M2.45462 19.0778C2.49236 19.6046 2.73018 20.0971 3.11911 20.4544C3.50823 20.8118 4.019 21.0069 4.54721 20.9998H13.5497C14.0779 21.0069 14.5887 20.8118 14.9778 20.4544C15.3668 20.0972 15.6046 19.6046 15.6423 19.0778L16.3489 6.89537C16.6508 6.77749 16.9102 6.57138 17.093 6.30376C17.276 6.0363 17.3739 5.71974 17.3741 5.39575V4.25921C17.3736 3.83217 17.2036 3.42288 16.9015 3.12095C16.5996 2.81902 16.1903 2.64912 15.7633 2.64841H12.6801L12.5071 1.43294C12.4581 1.03985 12.268 0.677795 11.9721 0.414284C11.6764 0.150787 11.2949 0.00361759 10.8989 0H7.19305C6.79772 0.00465301 6.41756 0.152512 6.12268 0.415837C5.82799 0.679335 5.63859 1.04071 5.58966 1.43295L5.41423 2.64842H2.33345C1.90641 2.64911 1.49713 2.81903 1.19519 3.12095C0.893093 3.42288 0.723186 3.83216 0.722656 4.25922V5.39576C0.722829 5.71974 0.820715 6.03633 1.00373 6.30377C1.18657 6.5714 1.44591 6.7775 1.74785 6.89538L2.45462 19.0778ZM14.4094 19.0061C14.3894 19.2181 14.2895 19.4146 14.1297 19.5555C13.97 19.6963 13.7625 19.7711 13.5497 19.7646H4.54718C4.33435 19.7711 4.12686 19.6963 3.96713 19.5555C3.80738 19.4145 3.70743 19.2181 3.68744 19.0061L2.99312 7.00676H15.0988L14.4094 19.0061ZM6.82484 1.60597C6.84276 1.40279 7.00648 1.24321 7.21017 1.23046H10.916C11.1081 1.25666 11.2562 1.41279 11.2717 1.60597L11.4223 2.6436L6.6643 2.64377L6.82484 1.60597ZM1.95786 4.25938C1.95907 4.05258 2.12657 3.88525 2.33337 3.88387H15.763C15.9698 3.88525 16.1373 4.05258 16.1385 4.25938V5.39592C16.1385 5.60324 15.9705 5.77143 15.763 5.77143H2.33337C2.12588 5.77143 1.95786 5.60324 1.95786 5.39592V4.25938Z" fill="#B6B6B6"/>
                            <path d="M9.04832 18.1588C9.21221 18.1588 9.3692 18.0937 9.48501 17.9779C9.60082 17.8621 9.66596 17.7049 9.66596 17.5412V8.5237C9.66596 8.18266 9.38937 7.90607 9.04832 7.90607C8.70728 7.90607 8.43069 8.18266 8.43069 8.5237V17.5364C8.42931 17.7009 8.49393 17.8593 8.60991 17.9763C8.72572 18.0932 8.88357 18.159 9.04832 18.159V18.1588Z" fill="#B6B6B6"/>
                            <path d="M6.20407 17.5042H6.23871C6.40311 17.4957 6.55735 17.4223 6.66712 17.2998C6.77707 17.1775 6.83359 17.0161 6.82429 16.8519L6.40414 9.12662C6.38588 8.78557 6.09429 8.52398 5.75324 8.54242C5.4122 8.56086 5.15061 8.85227 5.16887 9.19332L5.58901 16.9239C5.60849 17.2495 5.87784 17.5037 6.20405 17.5045L6.20407 17.5042Z" fill="#B6B6B6"/>
                            <path d="M11.857 17.5015H11.8916C12.2168 17.501 12.486 17.248 12.5066 16.9235L12.9242 9.19818C12.9426 8.85714 12.681 8.56555 12.34 8.54711C11.9988 8.52884 11.7074 8.79026 11.6889 9.13148L11.2714 16.8519C11.2627 17.0158 11.3194 17.1764 11.4294 17.2983C11.5392 17.4201 11.6931 17.4934 11.8569 17.5016L11.857 17.5015Z" fill="#B6B6B6"/>
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>`;
                    tr.appendChild(tdDetails);

                    tbody.appendChild(tr);
                });

                table.appendChild(tbody);
                mobileWishlistItemsContainer.appendChild(table);
            }
        },
        error: function (error) {
            console.error("Error fetching wishlist items:", error);
        },
    });
}

// Function to remove an item
function removeItem(button, id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "error",
        showCancelButton: true,
        confirmButtonText: "Yes, Remove it!",
        cancelButtonText:"No, Cancel this action",
        customClass: {
            confirmButton: "btn btn-success me-2",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    }).then((result) => {
        if (result.isConfirmed) {
            const row = button.closest("tr");
            row.remove();

            $.ajax({
                type: "GET",
                url: "/deletewishlist/" + id,
                dataType: "json",
                success: function (data) {
                    wishlistItems();
                    if (data.responseData.alert == "success") {
                        toastr.success(data.responseData.message);
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 1500,
                        };
                    } else {
                        toastr.error(data.response.message);
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 1500,
                        };
                    }
                },
            });
        }
    });
}
