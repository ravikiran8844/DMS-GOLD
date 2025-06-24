var baseurl = window.location.origin;
$(document).ready(function () {
    $("#tableColor").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getcolordata",
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
                data: "color_name",
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkColor${row.id}" 
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
    $("#colorId").val(id);
    $("#color").focus();
    $("#save").text("Update");
    $("#heading").text("Update Color");
    getColorById(id);
}

function getColorById(id) {
    $.ajax({
        type: "GET",
        url: "getcolor/" + id,
        dataType: "json",
        success: function (data) {
            $("#color_name").val(data.color.color_name);
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deletecolor/", "tableColor");
}

function doStatus(id) {
    var status = $("#chkColor" + id).is(":checked");
    confirmStatusChange(
        id,
        "colorstatus/",
        "tableColor",
        status == true ? 1 : 0,
        "chkColor"
    );
}
