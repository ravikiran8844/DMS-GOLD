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
//     if (dtOrder) {
//         dtOrder.draw();
//     }
//     $("#daterangefilter span").html(
//         start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
//     );

//     //orderList
//     orderList();
// }
// $("#userfilter").change(function () {
//     orderList();
// });
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
    table = $("#disapprovedorder").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "disapprovedorderdata",
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
                className: "dt-control details-control",
                orderable: false,
                data: null,
                defaultContent:
                    '<button>View Details <span class="icon"><svg width="5" height="9" viewBox="0 0 5 9" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.70046 3.67918C4.79208 3.7659 4.86766 3.88678 4.92008 4.03041C4.97249 4.17404 5 4.33566 5 4.5C5 4.66434 4.97249 4.82596 4.92008 4.96959C4.86766 5.11322 4.79208 5.2341 4.70046 5.32082L0.972822 8.85345C0.876737 8.94462 0.766434 8.99509 0.653284 8.99966C0.540133 9.00423 0.42823 8.96274 0.329109 8.87946C0.229989 8.79618 0.147238 8.67412 0.0893878 8.52588C0.0315377 8.37764 0.000681549 8.20856 9.58295e-08 8.03609L1.14944e-08 0.963904C0.000681461 0.791435 0.0315376 0.622364 0.0893877 0.47412C0.147238 0.325875 0.229989 0.203822 0.329109 0.120542C0.42823 0.037262 0.540133 -0.00423083 0.653284 0.000340797C0.766434 0.00491243 0.876737 0.055383 0.972822 0.14655L4.70046 3.67918Z" fill="#2D2D2D"/> </svg></span></button>',
            },
        ],
    });
}

// Formatting function for row details - modify as you need
function format(d) {
    let productsHtml = d.products
        .map((product) => {
            let totalQuantity = parseInt(product.order_qty);
            let availableQuantity = parseInt(product.available_qty);
            let badgeClass =
                availableQuantity < totalQuantity
                    ? "badge-danger"
                    : "badge-success";

            return `
                    <tr>
                        <td><a href="${baseurl}/upload/product/${
                product.product_image
            }"
                                    data-lightbox="image-${Math.random()}" data-title="${
                product.sku
            }"><img
                                   width="50" height="50"
                                  src="${baseurl}/upload/product/${
                product.product_image
            }" alt="img"></a></td>
                        <td>${product.product_unique_id}</td>
                        <td>${product.style_name}</td>
                        <td>${product.weight}</td>
                        <td>${product.order_qty}</td>
                        <td>
                            <span class="badge ${badgeClass}" style="width:70px;">
                                ${product.available_qty}
                            </span>
                        </td>
                    </tr>`;
        })
        .join("");

    return `<table cellpadding="5" cellspacing="0" border="0" class="table" style="padding-left:50px;" width="100%">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>SKU</th>
                            <th>Box</th>
                            <th>Total Weight</th>
                            <th>Total Quantity</th>
                            <th>Available Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${productsHtml}
                    </tbody>
                </table>
                <div class="d-flex flex-wrap justify-content-between px-5 pt-2 border-1 border-bottom">
                <div class="d-flex flex-column">
                <label for="" class="mr-2 mb-1" style="font-weight: 700;color: #000;">Remarks</label>
                    <textarea readonly class="form-control" style="width:350px;height: 42px !important;" name="admin_remarks" id="admin_remarks">${
                        d.admin_remarks == null ? "" : d.admin_remarks
                    }</textarea>
                </div>
                </div>  
              </div>
                `;
}

$(document).ready(function () {
    // Add event listener for opening and closing details
    $("#disapprovedorder tbody").on("click", "td.dt-control", function () {
        let tr = $(this).closest("tr");
        let row = table.row(tr);

        // Check if any row is already shown
        let shownRows = $("#disapprovedorder tbody tr.shown");
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
    });
});
