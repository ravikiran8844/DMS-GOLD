$(document).ready(function () {
    $("#tablePermission").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [
            [0, "ASC"]
        ],
        ajax: "rolepermissiondata",
        fnRowCallback: serialNoCount,
        createdRow: function (row, data, dataIndex) {
            // Add tooltip to the 'Edit' icon in the 'Action' column (column index 5)
            $('td:eq(2) .edit', row).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Edit');
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
                data: "action",
                orderable: false,
                searchable: false
            },
        ],
    });
});
// Listen for changes in the is_mainmenu checkboxes
$('.mainmenu').on('change', function () {
    var parentId = $(this).attr('id').replace('menu', '');
    var isChecked = $(this).is(':checked');

    // Check/uncheck child menu items based on data-parent-id
    $('.mainmenu').each(function () {
        if ($(this).data('parent-id') == parentId) {
            $(this).prop('checked', isChecked);
        }
    });
});

function doEdit(id) {
    $("#roleId").val(id);
    $("#role_name").focus();
    $("#save").text("Update");
    $("#heading").text("Update Role Permission");
    getRolePermissionById(id);
}

function getRolePermissionById(id) {
    $.ajax({
        type: "GET",
        url: "getrolepermission/" + id,
        dataType: "json",
        success: function (data) {
            $("#role_name").val(null).trigger("change");
            $("input[type=checkbox]").prop("checked", false);
            $.each(data.rolepermission, function (idx, val) {
                $("#role_name").val(val.role_id).trigger("change");
                $("#menu" + val.menu_id).prop("checked", true);
            })
            $("#role_name").attr("disabled", "disabled");
        },
    });
}

function cancels() {
    $("#role_name").val("");
    $("#save").text("Save");
    $("#heading").text("Role Permission");
    $("#role_name").removeAttr("disabled");
}
