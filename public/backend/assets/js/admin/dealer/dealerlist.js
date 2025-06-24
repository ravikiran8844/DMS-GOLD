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

    $("#daterangefilter").daterangepicker({
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
    dealerList();
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
    dealerList();
});
function dealerList() {
    var user_ids =
    $("#userfilter option:selected").val() == undefined
        ? 0
        : $("#userfilter option:selected").val();
        
    dtDealer = $("#tableDealer").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [
            [0, "ASC"]
        ],
        bDestroy: true,
        ajax: {
            url: "dealerdata",
            data: function (dealer) {
                dealer.startdate = startdate;
                dealer.enddate = enddate;
                dealer.user_ids = user_ids;
            }
        },
        fnRowCallback: serialNoCount,
        createdRow: function (row, data, dataIndex) {
            // Add tooltip to the 'Edit' icon in the 'Action' column (column index 5)
            $('td:eq(5) .edit', row).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Edit');

            // Add tooltip to the 'Delete' icon in the 'Action' column (column index 5)
            $('td:eq(5) .delete', row).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Delete');

            // Initialize tooltips for the created row
            $('[data-bs-toggle="tooltip"]', row).tooltip();
        },
        columns: [{
                data: "id"
            },
            {
                data: "company_name"
            },
            {
                data: "email"
            },
            {
                data: "mobile"
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkDealer${row.id}" 
                    onclick="doStatus(${row.id});" ${data == 1 ? "checked" : ""}>
                    <div class="state p-success">
                        <label></label>
                    </div>
                </div>`;
                },
            },
            {
                data: "action",
                orderable: false,
                searchable: false
            },
        ],
    });
}

function doEdit(id) {
    $("#dealerId").val(id);
    getDealerById(id);
}

function getDealerById(id) {
    $.ajax({
        type: "GET",
        url: "getdealer/" + id,
        dataType: "json",
        success: function (data) {
            $("#userId").val(data.dealer.user_id);
            $("#cheque_leaf").removeAttr("required");
            $("#gst_certificate").removeAttr("required");
            $("#chequeleaf").val(data.dealer.cheque_leaf);
            $("#gstcertificate").val(data.dealer.gst_certificate);
            if (data.dealer.cheque_leaf) {
                $("#chequeview").removeAttr("style").css("display", "block");
                $("#chequelink").attr('href', baseurl + '/' + data.dealer.cheque_leaf)
                    .attr('target', '_blank');
            }
            if (data.dealer.gst_certificate) {
                $("#gstview").removeAttr("style").css("display", "block");
                $("#gstlink").attr('href', baseurl + '/' + data.dealer.gst_certificate)
                    .attr('target', '_blank');
            }
            $("#company_name").val(data.dealer.company_name);
            $("#communication_address").val(data.dealer.communication_address);
            $("#email").val(data.dealer.email);
            $("#mobile").val(data.dealer.mobile);
            $("#zone").val(data.dealer.zone_id);
            $("#city").val(data.dealer.city);
            $("#state").val(data.dealer.state);
            $("#a_name").val(data.dealer.a_name);
            $("#a_desingation").val(data.dealer.a_designation);
            $("#a_mobile").val(data.dealer.a_mobile);
            $("#a_email").val(data.dealer.a_email);
            $("#b_name").val(data.dealer.b_name);
            $("#b_designation").val(data.dealer.b_designation);
            $("#b_mobile").val(data.dealer.b_mobile);
            $("#b_email").val(data.dealer.b_email);
            $("#gst").val(data.dealer.gst);
            $("#income_tax_pan").val(data.dealer.income_tax_pan);
            $("#bank_name").val(data.dealer.bank_name);
            $("#branch_name").val(data.dealer.branch_name);
            $("#address").val(data.dealer.address);
            $("#account_number").val(data.dealer.account_number);
            $("#account_type").val(data.dealer.account_type);
            $("#ifsc").val(data.dealer.ifsc);
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deletedealer/", "tableDealer");
}

function doStatus(id) {
    var status = $("#chkDealer" + id).is(":checked");
    confirmStatusChange(
        id,
        "dealerstatus/",
        "tableDealer",
        status == true ? 1 : 0,
        "chkDealer"
    );
}




