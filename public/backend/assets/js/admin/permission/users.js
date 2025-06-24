$(document).ready(function () {
    $("#tableUsers").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [
            [0, "ASC"]
        ],
        ajax: "userpermissiondata",
        fnRowCallback: serialNoCount,
        createdRow: function (row, data, dataIndex) {
            // Add tooltip to the 'Edit' icon in the 'Action' column (column index 5)
            $('td:eq(5) .edit', row).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Edit');
            // Initialize tooltips for the created row
            $('[data-bs-toggle="tooltip"]', row).tooltip();
        },
        columns: [{
                data: "id"
            },
            {
                data: "mobile"
            },
            {
                data: "role_name"
            },
            {
                data: "email"
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkUserPermission${row.id}" 
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
    $("#name").val("");
    $("#emsil").val("");
    $("#save").text("Save");
    $("#heading").text("Add Users");
    $("#role_name").removeAttr("disabled");
    $("input[type=checkbox]").prop("checked", false);
}

$("#role_name").on("change", function () {
    $("#tbodyMenuList").empty();
    var id = $("#role_name").val();
    LoadMenus(id);
});
//Append Menus
function LoadMenus(id) {
    jQuery
        .ajax({
            type: "GET",
            url: "listmenus/" + id,
            async: false,
            dataType: "json",
        })
        .done(function (menuData) {
            $("#tbodyMenuList tr").empty();
            var List = "";
            $.each(menuData.menu, function (idx, val) {
                List += "<tr id='trstu' >";
                List += "<td>" + (idx + 1) + "</td>";

                List +=
                    "<td>" +
                    val.menu_name +
                    "<input type='hidden' name='menuId[]' value=" +
                    val.id +
                    " ></td>";

                List +=
                    "<td><div class='pretty p-switch p-fill mb-2'><input type='checkbox'  name='checkEdit[" +
                    val.id +
                    "][]' id='checkEdit" +
                    val.id +
                    "' value='1'><div class='state p-success'><label></label></div></div></td>";

                List +=
                    "<td><div class='pretty p-switch p-fill mb-2'><input type='checkbox'  name='checkDelete[" +
                    val.id +
                    "][]' id='checkDelete" +
                    val.id +
                    "' value='1'><div class='state p-success'><label></label></div></div></td>";

                List +=
                    "<td><div class='pretty p-switch p-fill mb-2'><input type='checkbox'  name='checkPrint[" +
                    val.id +
                    "][]' id='checkPrint" +
                    val.id +
                    "' value='1'><div class='state p-success'><label></label></div></div></td>";

                List +=
                    "<td><div class='pretty p-switch p-fill mb-2'><input type='checkbox'  name='checkView[" +
                    val.id +
                    "][]' id='checkView" +
                    val.id +
                    "' value='1'><div class='state p-success'><label></label></div></div></td>";

                List += "</td>";
                List += "</tr>";
            });
            $("#tbodyMenuList").html(List);
        });

    var selectAllItems = "#chkall";
    var checkboxItem = ":checkbox";

    $(selectAllItems).click(function () {
        if (this.checked) {
            $(checkboxItem).each(function () {
                this.checked = true;
            });
        } else {
            $(checkboxItem).each(function () {
                this.checked = false;
            });
        }
    });
}

function doEdit(id) {
    $("#userId").val(id);
    $("#role_name").focus();
    $("#Save").text("Update");
    $("#heading").text("Update Users");
    getUserPermissionById(id);
}

function getUserPermissionById(id) {
    $.ajax({
        type: "GET",
        url: "getuserpermission/" + id,
        dataType: "json",
        success: function (data) {
            setTimeout(function () {
                $("#role_name")
                    .val(data.userPermission.role_id)
                    .trigger("change");
            }, 1000);
            $("#mobile").val(data.userPermission.mobile);
            $("#name").val(data.userPermission.name);
            $("#email").val(data.userPermission.email);

            $.each(data.userMenuPermission, function (idx, val) {
                var count = val.menu_id;

                setTimeout(function () {
                    if (val.is_delete == 1) {
                        $("#checkDelete" + count).attr("checked", true);
                    }
                    if (val.is_edit == 1) {
                        $("#checkEdit" + count).attr("checked", true);
                    }
                    if (val.is_print == 1) {
                        $("#checkPrint" + count).attr("checked", true);
                    }
                    if (val.is_view == 1) {
                        $("#checkView" + count).attr("checked", true);
                    }
                }, 2000);
            });
        },
    });
}

function doStatus(id) {
    var status = $("#chkUserPermission" + id).is(":checked");
    confirmStatusChange(
        id,
        "userpermission/",
        "tableUsers",
        status == true ? 1 : 0,
        "chkUserPermission"
    );
}
