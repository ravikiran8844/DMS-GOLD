var FromDate;
var ToDate;
var date = new Date();
var startdate =
    date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
var enddate =
    date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
var dtOrder;
var baseurl = window.location.origin;

$(document).ready(function () {
    FromDate = moment().subtract(6, "days");
    ToDate = moment();

    $("#datefilter").daterangepicker({
        ranges: {
            Today: [moment(), moment()],
            Yesterday: [
                moment().subtract("days", 1),
                moment().subtract("days", 1),
            ],
            "Last 7 Days": [moment().subtract("days", 6), moment()],
            "Last 30 Days": [moment().subtract("days", 29), moment()],
            "This Month": [moment().startOf("month"), moment().endOf("month")],
            "Last Month": [
                moment().subtract("month", 1).startOf("month"),
                moment().subtract("month", 1).endOf("month"),
            ],
        },
        //FromDate: moment(),
        //ToDate: moment(),
        startDate: moment().subtract(6, "days"),
        endDate: moment(),
        locale: {
            format: "DD-MM-YYYY",
        },
        getDate,
    });
    // Update filter and reload data when date range changes
    $("#datefilter").on("apply.daterangepicker", function (ev, picker) {
        getDate(picker.startDate, picker.endDate);
        orderList(); // Reload data
    });
    getDate(FromDate, ToDate);

    //orderList
    orderList();
});

function getDate(start, end) {
    startdate = start.format("YYYY-MM-DD");
    enddate = end.format("YYYY-MM-DD");

    // Redraw the DataTable with the new date range
    if (dtOrder) {
        dtOrder.draw();
    }

    $("#datefilter span").html(
        start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
    );
}

function orderList() {
    var roleId = $("#auth").val();
    var columns = [
        {
            data: "id",
            className: "text-center",
        },
        {
            data: "order_no",
            className: "text-center",
        },
        {
            data: "created_at",
            className: "text-center",
            render: function (data, type, row) {
                // Assuming 'created_at' is a date string
                var date = new Date(data);
                return date.toLocaleDateString("en-IN", {
                    year: "numeric",
                    month: "short",
                    day: "numeric",
                });
            },
        },
        {
            data: "total_qty",
            className: "text-center",
        },
        {
            data: "totalweight",
            className: "text-center",
        },
    ];

    // Add these columns only if roleId is 5
    if (roleId == 5) {
        columns.push(
            {
                data: "name",
                className: "text-center",
            },
            {
                data: "invoice_no",
                render: function (data, type, row) {
                    if (row.approved_invoice) {
                        const cleanedInvoiceNo = row.approved_invoice
                            .replace("approvedinvoice/", "")
                            .replace("/", "")
                            .replace("/", "")
                            .replace(".xlsx", "");
                        return `<a href="${baseurl}/download/${cleanedInvoiceNo}"
                        class="badge-outline col-green"><i class="fas fa-arrow-down"></i> <b>Order Copy</b></a>`;
                    } else {
                        return `<span
                        class="badge bg-label-danger">NA</span>`;
                    }
                },
            }
        );
    }

    // Common columns
    columns.push(
        {
            data: "action",
            className: "text-center",
            orderable: false,
            searchable: false,
        },
        {
            data: "repeatOrders",
            className: "text-center",
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
                return `
                <button type="button" class="btn btn-warning ms-2" data_id="${data}" onclick="repeatOrderById(this)">Repeat Order</button>`;
            },
        }
    );

    dtOrder = $("#tableOrders").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        bDestroy: true,
        order: [[0, "ASC"]],
        language: {
            processing:
                '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        },
        ajax: {
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "orderdata",
            data: function (order) {
                order.startdate = startdate;
                order.enddate = enddate;
            },
        },
        fnRowCallback: serialNoCount,
        columns: columns,
    });
}
