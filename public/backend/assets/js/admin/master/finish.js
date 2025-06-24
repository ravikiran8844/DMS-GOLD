var baseurl = window.location.origin;
$(document).ready(function () {
    $("#tableFinish").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getfinishdata",
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
                data: "project_name",
            },
            {
                data: "finish_name",
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkFinish${row.id}" 
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
    $("#finishId").val(id);
    $("#finish_name").focus();
    $("#save").text("Update");
    $("#heading").text("Update Finish");
    getBrandById(id);
}

function getBrandById(id) {
    $.ajax({
        type: "GET",
        url: "getfinish/" + id,
        dataType: "json",
        success: function (data) {
            $("#project_name").val(data.finish.project_id).trigger("change");
            $("#finish_name").val(data.finish.finish_name);
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deletefinish/", "tableFinish");
}

function doStatus(id) {
    var status = $("#chkFinish" + id).is(":checked");
    confirmStatusChange(
        id,
        "finishstatus/",
        "tableFinish",
        status == true ? 1 : 0,
        "chkFinish"
    );
}
