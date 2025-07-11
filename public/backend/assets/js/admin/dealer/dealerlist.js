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
                data: "party_name",
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
            $("#party_name").val(data.dealer.party_name);
            $("#code").val(data.dealer.code);
            $("#customer_code").val(data.dealer.customer_code);
            $("#mobile").val(data.dealer.mobile);
            $("#zone").val(data.dealer.zone);
            $("#person_name").val(data.dealer.person_name);
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




