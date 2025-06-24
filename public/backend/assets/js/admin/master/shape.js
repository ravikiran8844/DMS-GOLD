var baseurl = window.location.origin;
$(document).ready(function () {
    $("#tableShape").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getshapedata",
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
                data: "shape_name",
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkShape${row.id}" 
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
    $("#shapeId").val(id);
    $("#shape").focus();
    $("#save").text("Update");
    $("#heading").text("Update Shape");
    getShapeById(id);
}

function getShapeById(id) {
    $.ajax({
        type: "GET",
        url: "getshape/" + id,
        dataType: "json",
        success: function (data) {
            $("#shape_name").val(data.shape.shape_name);
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deleteshape/", "tableShape");
}

function doStatus(id) {
    var status = $("#chkShape" + id).is(":checked");
    confirmStatusChange(
        id,
        "shapestatus/",
        "tableShape",
        status == true ? 1 : 0,
        "chkShape"
    );
}
