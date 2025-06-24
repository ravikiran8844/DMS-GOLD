var baseurl = window.location.origin;
$(document).ready(function () {
    $("#tableProject").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getprojectdata",
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
                data: "project_name",
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkProject${row.id}" 
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
    $("#projectId").val(id);
    $("#project_name").focus();
    $("#save").text("Update");
    $("#heading").text("Update Project");
    getBrandById(id);
}

function getBrandById(id) {
    $.ajax({
        type: "GET",
        url: "getproject/" + id,
        dataType: "json",
        success: function (data) {
            $("#project_name").val(data.project.project_name);
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deleteproject/", "tableProject");
}

function doStatus(id) {
    var status = $("#chkProject" + id).is(":checked");
    confirmStatusChange(
        id,
        "projectstatus/",
        "tableProject",
        status == true ? 1 : 0,
        "chkProject"
    );
}
