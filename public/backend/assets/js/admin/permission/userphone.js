$(document).ready(function () {
    document.getElementById("mobile").addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, ""); // Remove all non-digit characters
    });

    $("#tableUserPhone").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getuserphonedata",
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
                data: "name",
            },
            {
                data: "mobile",
                orderable: false,
            },
            {
                data: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });
});

function cancels() {
    $("#user").val("");
    $("#mobile").val("");
    $("#save").text("Save");
    $("#heading").text("Add User Phone");
}

function doEdit(id) {
    $("#hdUserPhoneId").val(id);
    $("#user").focus();
    $("#save").text("Update");
    $("#heading").text("Update User Phone");
    getUserPhoneById(id);
}

function getUserPhoneById(id) {
    $.ajax({
        type: "GET",
        url: "getuserphone/" + id,
        dataType: "json",
        success: function (data) {
            $("#mobile").val(data.user.mobile);
            $("#user").val(data.user.user_id).trigger("change");
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deleteuserphone/", "tableUserPhone");
}
