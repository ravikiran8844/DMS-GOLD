var FromDate;
var ToDate;
var date = new Date();
var startdate =
    date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
var enddate =
    date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
var dtDealer;
var baseurl = window.location.origin;

$(document).ready(function () {
    FromDate = moment();
    ToDate = moment();

    $("#daterangefilter").daterangepicker(
        {
            ranges: {
                Today: [moment(), moment()],
                Yesterday: [
                    moment().subtract("days", 1),
                    moment().subtract("days", 1),
                ],
                "Last 7 Days": [moment().subtract("days", 6), moment()],
                "Last 30 Days": [moment().subtract("days", 29), moment()],
                "This Month": [
                    moment().startOf("month"),
                    moment().endOf("month"),
                ],
                "Last Month": [
                    moment().subtract("month", 1).startOf("month"),
                    moment().subtract("month", 1).endOf("month"),
                ],
            },
            FromDate: moment(),
            ToDate: moment(),
        },
        getDate
    );

    getDate(FromDate, ToDate);

    //dealer list
    retailerList();
});

function getDate(start, end) {
    startdate = start.format("YYYY-MM-DD");
    enddate = end.format("YYYY-MM-DD");
    if (dtDealer) {
        dtDealer.draw();
    }
    $("#daterangefilter span").html(
        start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
    );
}
$("#userfilter").change(function () {
    retailerList();
});

// $("#zone").on("change", function () {
//     getdealer();
// });

// function getdealer() {
//     var zone = $("#zone").val();
//     $.ajax({
//         url: "retailer/getdealer",
//         type: "GET",
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//         },
//         data: {
//             zone: zone,
//             _token: $('meta[name="csrf-token"]').attr("content"),
//         },
//         dataType: "json",
//         success: function (result) {
//             $("#preferredDealer1").html(
//                 '<option value="">Select Preferred Dealer 1</option>'
//             );
//             $.each(result.dealers, function (key, value) {
//                 $("#preferredDealer1").append(
//                     '<option value="' +
//                         value.id +
//                         '">' +
//                         value.name +
//                         ", " +
//                         value.city +
//                         "</option>"
//                 );
//             });
//             $("#preferredDealer2").html(
//                 '<option value="">Select Preferred Dealer 2</option>'
//             );
//             $.each(result.dealers, function (key, value) {
//                 $("#preferredDealer2").append(
//                     '<option value="' +
//                         value.id +
//                         '">' +
//                         value.name +
//                         ", " +
//                         value.city +
//                         "</option>"
//                 );
//             });
//             $("#preferredDealer3").html(
//                 '<option value="">Select Preferred Dealer 3</option>'
//             );
//             $.each(result.dealers, function (key, value) {
//                 $("#preferredDealer3").append(
//                     '<option value="' +
//                         value.id +
//                         '">' +
//                         value.name +
//                         ", " +
//                         value.city +
//                         "</option>"
//                 );
//             });
//         },
//     });
// }
function retailerList() {
    dtDealer = $("#tableRetailer").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "retailerdata",
        },
        fnRowCallback: serialNoCount,
        createdRow: function (row, data, dataIndex) {
            // Add tooltip to the 'Edit' icon in the 'Action' column (column index 5)
            $("td:eq(5) .edit", row)
                .attr("data-bs-toggle", "tooltip")
                .attr("data-bs-placement", "top")
                .attr("title", "Edit");

            // Initialize tooltips for the created row
            $('[data-bs-toggle="tooltip"]', row).tooltip();
        },
        columns: [
            {
                data: "id",
            },
            {
                data: "name",
            },
            {
                data: "email",
            },
            {
                data: "mobile",
            },
            {
                data: "dealer_details",
            },
            {
                data: "company_name",
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkRetailer${row.id}" 
                    onclick="doStatus(${row.id});" ${
                        data == 1 ? "checked" : ""
                    }>
                    <div class="state p-success">
                        <label></label>
                    </div>
                </div>`;
                },
            },
            {
                data: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });
}

function doEdit(id) {
    $("#dealerId").val(id);
    getRetailerById(id);
}

function getRetailerById(id) {
    $.ajax({
        type: "GET",
        url: "getretailer/" + id,
        dataType: "json",
        success: function (data) {
            $("#userId").val(data.retailer.id);
            $("#retailer_name").val(data.retailer.name);
            $("#retailer_email").val(data.retailer.email);
            $("#address").val(data.retailer.address);
            $("#mobile").val(data.retailer.mobile);
            $("#company_name").val(data.retailer.shop_name);
            $("#GST").val(data.retailer.GST);
            $("#pincode").val(data.retailer.pincode);
            $("#state").val(data.retailer.state);
            $("#district").val(data.retailer.district);
            $("#dealer_details").val(data.retailer.dealer_details);
            // $("#city").val(data.retailer.city);
            // setTimeout(function () {
            //     $("#zone").val(data.retailer.zone_id).trigger("change");
            // }, 500);
            // setTimeout(function () {
            //     $("#preferredDealer1")
            //         .val(data.retailer.preferred_dealer1)
            //         .trigger("change");
            // }, 1000);
            // setTimeout(function () {
            //     $("#preferredDealer2")
            //         .val(data.retailer.preferred_dealer2)
            //         .trigger("change");
            // }, 1500);
            // setTimeout(function () {
            //     $("#preferredDealer3")
            //         .val(data.retailer.preferred_dealer3)
            //         .trigger("change");
            // }, 2000);
        },
    });
}

function doStatus(id) {
    var status = $("#chkRetailer" + id).is(":checked");
    confirmStatusChange(
        id,
        "retailerstatus/",
        "tableRetailer",
        status == true ? 1 : 0,
        "chkRetailer"
    );
}

$("#pincode").on("keyup", function () {
    var pincode = $(this).val();
    if (pincode.length === 6) {
        getstatecity(pincode);
    }
});

function getstatecity(pincode) {
    $.ajax({
        url: "/proxy-pincode/" + pincode,
        type: "GET",
        dataType: "json",
        success: function (result) {
            if (
                result &&
                result[0] &&
                result[0].PostOffice &&
                result[0].PostOffice[0]
            ) {
                var postOffice = result[0].PostOffice[0];
                $("#district").val(postOffice.District);
                $("#state").val(postOffice.State);
            } else {
                iziToast.error({
                    title: "Error",
                    message: "No state and city found",
                    position: "topRight",
                    timeout: 1500,
                });
                $("#district").val("");
                $("#state").val("");
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: ", status, error);
        },
    });
}
