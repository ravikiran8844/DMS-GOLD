var baseurl = window.location.origin;
$(document).ready(function () {
    $("#tableJewel").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getjeweldata",
        fnRowCallback: serialNoCount,
        createdRow: function (row, data, dataIndex) {
            // Add tooltip to the 'Edit' icon in the 'Action' column (column index 5)
            $('td:eq(3) .edit', row).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Edit');

            // Add tooltip to the 'Delete' icon in the 'Action' column (column index 5)
            $('td:eq(3) .delete', row).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Delete');

            // Initialize tooltips for the created row
            $('[data-bs-toggle="tooltip"]', row).tooltip();
        },
        columns: [
            {
                data: "id",
            },
            {
                data: "jewel_type",
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkJewel${row.id}" 
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
    $("#jewelId").val(id);
    $("#jewel").focus();
    $("#save").text("Update");
    $("#heading").text("Update Jewel Type");
    getMetalById(id);
}

function getMetalById(id) {
    $.ajax({
        type: "GET",
        url: "getjewel/" + id,
        dataType: "json",
        success: function (data) {
            $("#jewel").val(data.jewel.jewel_type);
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deletejewel/", "tableJewel");
}

function doStatus(id) {
    var status = $("#chkJewel" + id).is(":checked");
    confirmStatusChange(
        id,
        "jewelstatus/",
        "tableJewel",
        status == true ? 1 : 0,
        "chkJewel"
    );
}
