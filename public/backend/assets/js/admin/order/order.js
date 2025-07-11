var FromDate;
var ToDate;
var date = new Date();
var startdate =
    date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
var enddate =
    date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
var table;
var baseurl = window.location.origin;

// $(document).ready(function () {
//     FromDate = moment();
//     ToDate = moment();

//     $("#daterangefilter").daterangepicker(
//         {
//             ranges: {
//                 Today: [moment(), moment()],
//                 Yesterday: [
//                     moment().subtract("days", 1),
//                     moment().subtract("days", 1),
//                 ],
//                 "Last 7 Days": [moment().subtract("days", 6), moment()],
//                 "Last 30 Days": [moment().subtract("days", 29), moment()],
//                 "This Month": [
//                     moment().startOf("month"),
//                     moment().endOf("month"),
//                 ],
//                 "Last Month": [
//                     moment().subtract("month", 1).startOf("month"),
//                     moment().subtract("month", 1).endOf("month"),
//                 ],
//             },
//             FromDate: moment(),
//             ToDate: moment(),
//         },
//         getDate
//     );

//     getDate(FromDate, ToDate);
// });

// function getDate(start, end) {
//     startdate = start.format("YYYY-MM-DD");
//     enddate = end.format("YYYY-MM-DD");
//     if (table) {
//         table.draw();
//     }
//     $("#daterangefilter span").html(
//         start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
//     );

//     //orderList
//     orderList();
// }
$(document).ready(function () {
    orderList();
});
$("#userfilter").change(function () {
    orderList();
});
$("#rolefilter").change(function () {
    orderList();
});
function orderList() {
    var user_id =
        $("#userfilter option:selected").val() == undefined
            ? 0
            : $("#userfilter option:selected").val();
    var role_id =
        $("#rolefilter option:selected").val() == undefined
            ? 0
            : $("#rolefilter option:selected").val();
    table = $("#orders-table").DataTable({
        ordering: false,
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "dealerorderdata",
            data: function (order) {
                // order.startdate = startdate;
                // order.enddate = enddate;
                order.user_id = user_id;
                order.role_id = role_id;
            },
        },
        fnRowCallback: serialNoCount,
        createdRow: function (row, data, dataIndex) {
            // Add a click event listener to the name column
            $(row)
                .find("td:eq(4)")
                .on("click", function () {
                    // Populate the modal with data from the clicked row
                    $("#retailer_name").val(data.name);
                    $("#retailer_email").val(data.email);
                    $("#address").val(data.address);
                    $("#mobile").val(data.mobile);
                    $("#company_name").val(data.shop_name);
                    $("#GST").val(data.GST);
                    $("#state").val(data.state);
                    $("#district").val(data.district);
                    $("#pincode").val(data.pincode);
                    $("#dealer_details").val(data.dealer_details);
                    // Open the modal
                    $("#editmodal").modal("show");
                });
        },
        columns: [
            { data: "id" },
            { data: "role_name" },
            { data: "order_no" },
            {
                data: "created_at",
                render: function (data, type, row) {
                    // Format the date and time
                    return moment(data).format("MMMM Do YYYY, h:mm:ss a");
                },
            },
            { data: "name" },
            { data: "mobile" },
            { data: "totalweight" },
            { data: "totalqty" },
            {
                data: "invoice_no",
                render: function (data, type, row) {
                    if (row.invoice_path) {
                        // Remove "invoices/" and ".xlsx" from the string
                        const cleanedInvoiceNo = row.invoice_path
                            .replace("invoices/", "")
                            .replace("/", "")
                            .replace("/", "")
                            .replace(".xlsx", "");
                        return `<a href="
                        invoice/${cleanedInvoiceNo}"
                        class="badge-outline col-green"><i class="fas fa-arrow-down"></i> <b>Order Copy</b></a>`;
                    } else {
                        return `<span
                        class="badge bg-label-danger">NA</span>`;
                    }
                },
            },
            {
                className: "dt-control details-control",
                orderable: false,
                data: null,
                defaultContent:
                    '<button>View Details <span class="icon"><svg width="5" height="9" viewBox="0 0 5 9" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.70046 3.67918C4.79208 3.7659 4.86766 3.88678 4.92008 4.03041C4.97249 4.17404 5 4.33566 5 4.5C5 4.66434 4.97249 4.82596 4.92008 4.96959C4.86766 5.11322 4.79208 5.2341 4.70046 5.32082L0.972822 8.85345C0.876737 8.94462 0.766434 8.99509 0.653284 8.99966C0.540133 9.00423 0.42823 8.96274 0.329109 8.87946C0.229989 8.79618 0.147238 8.67412 0.0893878 8.52588C0.0315377 8.37764 0.000681549 8.20856 9.58295e-08 8.03609L1.14944e-08 0.963904C0.000681461 0.791435 0.0315376 0.622364 0.0893877 0.47412C0.147238 0.325875 0.229989 0.203822 0.329109 0.120542C0.42823 0.037262 0.540133 -0.00423083 0.653284 0.000340797C0.766434 0.00491243 0.876737 0.055383 0.972822 0.14655L4.70046 3.67918Z" fill="#2D2D2D"/> </svg></span></button>',
            },
        ],
    });
}

// Function to create dealer options
function createDealerOptions(dealer_id) {
    dealers = JSON.parse($("#dealers").val());
    return dealers
        .map(
            (dealer) =>
                `<option value="${dealer.id}" ${
                    dealer.id === dealer_id ? "selected" : ""
                }>${dealer.name}</option>`
        )
        .join("");
}

// Formatting function for row details - modify as you need
function format(d) {
    let productsHtml = d.products
        .map((product) => {
            return `
                <tr>
                    <td>
                        <a href="${baseurl}/upload/product/${product.product_image}"
                           data-lightbox="image-${Math.random()}"
                           data-title="${product.sku}">
                            <img class="img-fluid prouduct_card-image load-secure-image"
                                 width="50"
                                 height="50"
                                 src="http://imageurl.ejindia.com/api/image/secure"
                                 data-secure="${product.secureFilename}" alt>
                        </a>
                    </td>
                    <td>${product.DesignNo}</td>
                    <td>${product.style ?? "-"}</td>
                    <td id="totalWeight">${product.weight}</td>
                    <td>${product.order_qty}</td>
                </tr>`;
        })
        .join("");

    return `
        <table cellpadding="5" cellspacing="0" border="0" class="table" style="padding-left:50px;" width="100%">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>SKU</th>
                    <th>Box</th>
                    <th>Total Weight</th>
                    <th>Total Quantity</th>
                </tr>
            </thead>
            <tbody>
                ${productsHtml}
            </tbody>
        </table>
        <div class="d-flex flex-wrap align-items-center justify-content-between px-5 pt-2 border-1 border-bottom">
            <div class="d-flex flex-wrap">
                <div class="d-flex flex-column align-items-center mr-3">
                    <label for="" class="mr-2" style="font-weight: 700;color: #000;">Select Dealer</label>
                    <select class="form-control mb-4 select-dealers" name="dealer" id="dealer" required>
                        <option value="">Select Dealer</option>
                        ${createDealerOptions(d.preferred_dealer_id)}
                    </select>
                </div>
                <div class="mb-4 mr-4">
                    <label for="" class="mr-2" style="font-weight: 700;color: #000;">Remarks</label>
                    <textarea class="form-control" style="width:350px;" name="admin_remarks" id="admin_remarks"></textarea>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-warning mb-4" onclick="proceed(${d.id});">Proceed Now</button>
                <button type="button" class="btn btn-outline-dark mb-4" onclick="orderCancel(${d.id});">Cancel Order</button>
            </div>
        </div>
        <div class="form-check px-5">
            <input class="form-check-input" type="checkbox" value="" id="parent-checkbox-${d.id}">
            <label class="form-check-label" for="parent-checkbox-${d.id}">Select All Items in Order</label>
        </div>
    `;
}


$(document).on("change", "[id^='parent-checkbox-']", function () {
    const orderId = this.id.replace("parent-checkbox-", "");
    const checkboxes = document.querySelectorAll(
        `input[type="checkbox"][id^="order-${orderId}-"]`
    );
    checkboxes.forEach((cb) => (cb.checked = this.checked));
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

$(document).ready(function () {
    // Add event listener for opening and closing details
    $("#orders-table tbody").on("click", "td.dt-control", function () {
        let tr = $(this).closest("tr");
        let row = table.row(tr);

        // Check if any row is already shown
        let shownRows = $("#orders-table tbody tr.shown");
        if (shownRows.length > 0) {
            // Hide the child row and remove 'shown' class
            let shownRow = table.row(shownRows[0]);
            shownRow.child.hide();
            shownRows.removeClass("shown");

            // If the clicked row is the same as the previously shown row, return
            if (shownRow.index() === row.index()) return;
        }

        // Show the child row and add 'shown' class
        row.child(format(row.data())).show();
        tr.addClass("shown");

        // ✅ Load secure images inside the expanded row
        loadSecureImages();
    });
});

function proceed(order_id) {
    var dealer = document.getElementById("dealer").value;
    if (dealer === "") {
        alert("Please select a dealer.");
        return false;
    }
    var checkedValues = [];
    $(".checkbox-class:checked").each(function () {
        checkedValues.push($(this).val());
    });

    var productIds = [];
    $(".checkbox-class:checked").each(function () {
        checkedValues.push($(this).val());
        productIds.push($(this).data("product-id"));
    });
    var dealer = $("#dealer").val();
    var admin_remarks = $("#admin_remarks").val();
    $.ajax({
        url: "/approve", // Change this to your actual endpoint
        method: "post",
        data: {
            checkedValues: checkedValues,
            dealer: dealer,
            order_id: order_id,
            productIds: productIds,
            admin_remarks: admin_remarks,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // For Laravel, adjust as needed for your backend
        },
        success: function (response) {
            iziToast.success({
                title: "Success",
                message: response.message,
                position: "topRight",
                timeout: 1500,
            });
            window.location.reload();
        },
        error: function (xhr, status, error) {
            iziToast.error({
                title: "Error",
                message: error,
                position: "topRight",
                timeout: 1500,
            });
        },
    });
}

function orderCancel(order_id) {
    var admin_remarks = $("#admin_remarks").val();
    $.ajax({
        url: "/cancel", // Change this to your actual endpoint
        method: "POST",
        data: {
            order_id: order_id,
            admin_remarks: admin_remarks,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // For Laravel, adjust as needed for your backend
        },
        success: function (response) {
            iziToast.success({
                title: "Success",
                message: response.message,
                position: "topRight",
                timeout: 1500,
            });
            window.location.reload();
        },
        error: function (xhr, status, error) {
            iziToast.error({
                title: "Error",
                message: error,
                position: "topRight",
                timeout: 1500,
            });
        },
    });
}
$(document).ready(function () {
    // This function waits for the document to be fully loaded before executing the code inside.
    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            // Check if any nodes are added
            if (
                mutation.type === "childList" &&
                mutation.addedNodes.length > 0
            ) {
                // Check if the added nodes include select boxes with the class '.select-dealers'
                const selectBoxes =
                    document.querySelectorAll(".select-dealers");
                if (selectBoxes.length > 0) {
                    selectBoxes.forEach(function (selectBox) {
                        $(selectBox).select2();
                    });
                    // Disconnect the observer as it's no longer needed
                    observer.disconnect();
                }
            }
        });
    });

    // Start observing changes to the document
    observer.observe(document.body, {
        childList: true, // Observe changes to the child nodes
        subtree: true, // Observe changes within the entire subtree of the body
    });
});

// function decrementQuantity(button) {
//     var dataId = $(button).data("id");
//     var avl = $("#avlqty" + dataId).val();

//     const container = $(button).closest(".quantity-container");
//     const qtyInput = container.find(".qty");
//     let currentValue = parseInt(qtyInput.val(), 10);

//     if (currentValue > avl) {
//         qtyInput.val(currentValue - 1);
//     } else {
//         qtyInput.val(avl);
//     }

//     $.ajax({
//         type: "GET",
//         url: "orderqty",
//         data: {
//             product_id: dataId,
//             qty: qtyInput.val(),
//         },
//         dataType: "json",
//         success: function (data, textStatus, xhr) {
//             var totalweight = $("#totalWeight").val();
//             var avlqty = $("#avlqty").val();
//             var qty = $("#qty").val();
//             console.log(totalweight, avlqty);
//         },
//         error: function (xhr, textStatus, errorThrown) {
//             console.log(xhr);
//         },
//     });
// }

// function incrementQuantity(button) {
//     var dataId = $(button).data("id");
//     var readystock = $("#readystock" + dataId).val();
//     var stock = $("#stock" + dataId).val();
//     const container = $(button).closest(".quantity-container");
//     const qtyInput = container.find(".qty");
//     let currentValue = parseInt(qtyInput.val(), 10);

//     if (readystock == 1 && currentValue >= stock) {
//         alert("Quantity cannot exceed available qty");
//     } else {
//         // Otherwise, increase quantity by 1
//         qtyInput.val(currentValue + 1);
//     }
//     // Change the color of the minus button
//     container.find(".qtyminus").css("color", "black");

//     $.ajax({
//         type: "GET",
//         url: "orderqty",
//         data: {
//             product_id: dataId,
//             qty: qtyInput.val(),
//         },
//         dataType: "json",
//         success: function (data, textStatus, xhr) {},
//         error: function (xhr, textStatus, errorThrown) {
//             console.log(xhr);
//         },
//     });
// }
