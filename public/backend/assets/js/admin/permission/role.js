$(document).ready(function () {
    $("#tableRole").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [
            [0, "ASC"]
        ],
        ajax: "getroledata",
        fnRowCallback: serialNoCount,
        createdRow: function (row, data, dataIndex) {
            // Add tooltip to the 'Edit' icon in the 'Action' column (column index 5)
            $('td:eq(3) .edit', row).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Edit');

            // Add tooltip to the 'Delete' icon in the 'Action' column (column index 5)
            $('td:eq(3) .delete', row).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Delete');

            // Initialize tooltips for the created row
            $('[data-bs-toggle="tooltip"]', row).tooltip();
        },
        columns: [{
                data: "id"
            },
            {
                data: "role_name"
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkRole${row.id}" 
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
});

function cancels() {
    $("#role_name").val("");
    $("#save").text("Save");
    $("#heading").text("Add Role");
}

function doEdit(id) {
    $("#hdRoleId").val(id);
    $("#role_name").focus();
    $("#save").text("Update");
    $("#heading").text("Update Role");
    getRoleById(id);
}

function getRoleById(id) {
    $.ajax({
        type: "GET",
        url: "getrole/" + id,
        dataType: "json",
        success: function (data) {
            $("#role_name").val(data.role.role_name);
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deleterole/", "tableRole");
}

function doStatus(id) {
    var status = $("#chkRole" + id).is(":checked");
    confirmStatusChange(
        id,
        "rolestatus/",
        "tableRole",
        status == true ? 1 : 0,
        "chkRole"
    );
}
