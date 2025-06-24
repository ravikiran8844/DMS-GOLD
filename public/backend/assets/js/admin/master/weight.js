var baseurl = window.location.origin;
$(document).ready(function () {
    $("#tableWeight").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getweightdata",
        fnRowCallback: serialNoCount,
        createdRow: function (row, data, dataIndex) {
            // Add tooltip to the 'Edit' icon in the 'Action' column (column index 5)
            $("td:eq(3) .edit", row)
                .attr("data-bs-toggle", "tooltip")
                .attr("data-bs-placement", "top")
                .attr("title", "Edit");

            // Add tooltip to the 'Delete' icon in the 'Action' column (column index 5)
            $("td:eq(3) .delete", row)
                .attr("data-bs-toggle", "tooltip")
                .attr("data-bs-placement", "top")
                .attr("title", "Delete");

            // Initialize tooltips for the created row
            $('[data-bs-toggle="tooltip"]', row).tooltip();
        },
        columns: [
            {
                data: "id",
            },
            {
                data: "weight_range_from",
            },
            {
                data: "weight_range_to",
            },
            {
                data: "mc_charge",
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkWeight${row.id}" 
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
});

function doEdit(id) {
    $("#weightId").val(id);
    $("#weight").focus();
    $("#save").text("Update");
    $("#heading").text("Update Weight");
    getBrandById(id);
}

function getBrandById(id) {
    $.ajax({
        type: "GET",
        url: "getweight/" + id,
        dataType: "json",
        success: function (data) {
            $("#weight_range_from").val(data.weight.weight_range_from);
            $("#weight_range_to").val(data.weight.weight_range_to);
            $("#mc_charge").val(data.weight.mc_charge);
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deleteweight/", "tableWeight");
}

function doStatus(id) {
    var status = $("#chkWeight" + id).is(":checked");
    confirmStatusChange(
        id,
        "weightstatus/",
        "tableWeight",
        status == true ? 1 : 0,
        "chkWeight"
    );
}
