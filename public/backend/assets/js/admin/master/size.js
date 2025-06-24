var baseurl = window.location.origin;
$(document).ready(function () {
    $("#tableSize").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getsizedata",
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
                data: "size",
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkSize${row.id}" 
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
    $("#sizeId").val(id);
    $("#size").focus();
    $("#save").text("Update");
    $("#heading").text("Update Size");
    getSizeById(id);
}

function getSizeById(id) {
    $.ajax({
        type: "GET",
        url: "getsize/" + id,
        dataType: "json",
        success: function (data) {
            $("#size").val(data.size.size);
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deletesize/", "tableSize");
}

function doStatus(id) {
    var status = $("#chkSize" + id).is(":checked");
    confirmStatusChange(
        id,
        "sizestatus/",
        "tableSize",
        status == true ? 1 : 0,
        "chkSize"
    );
}
