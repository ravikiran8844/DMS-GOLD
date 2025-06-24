var baseurl = window.location.origin;
$(document).ready(function () {
    $("#tablePlating").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getplatingdata",
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
                data: "plating_name",
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkPlating${row.id}" 
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
    $("#platingId").val(id);
    $("#plating").focus();
    $("#save").text("Update");
    $("#heading").text("Update Plating");
    getPlatingById(id);
}

function getPlatingById(id) {
    $.ajax({
        type: "GET",
        url: "getplating/" + id,
        dataType: "json",
        success: function (data) {
            $("#plating_name").val(data.plating.plating_name);
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deleteplating/", "tablePlating");
}

function doStatus(id) {
    var status = $("#chkPlating" + id).is(":checked");
    confirmStatusChange(
        id,
        "platingstatus/",
        "tablePlating",
        status == true ? 1 : 0,
        "chkPlating"
    );
}
