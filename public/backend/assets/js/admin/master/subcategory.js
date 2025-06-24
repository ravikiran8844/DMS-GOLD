$(document).ready(function () {
    $("#tableSubCategory").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getsubcategorydata",
        fnRowCallback: serialNoCount,
        createdRow: function (row, data, dataIndex) {
            // Add tooltip to the 'Edit' icon in the 'Action' column (column index 5)
            $("td:eq(4) .edit", row)
                .attr("data-bs-toggle", "tooltip")
                .attr("data-bs-placement", "top")
                .attr("title", "Edit");

            // Add tooltip to the 'Delete' icon in the 'Action' column (column index 5)
            $("td:eq(4) .delete", row)
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
                data: "category_name",
            },
            {
                data: "sub_category_name",
            },
            {
                data: "is_active",  
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkSubCategory${row.id}" 
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

$("#project_name").on("change", function () {
    getCategory();
});

//get category
function getCategory() {
    var project_id = $("#project_name").val();
    $.ajax({
        url: "getcategory",
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            project_id: project_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#category_name").html(
                '<option disabled selected value="">Select Category Name</option>'
            );
            $.each(result.category, function (key, value) {
                $("#category_name").append(
                    '<option value="' +
                        value.id +
                        '">' +
                        value.category_name +
                        "</option>"
                );
            });
        },
    });
}

function cancels() {
    $("#category_name").val("").trigger("change");
    $("#subb_category_name").val("");
    $("#save").text("Save");
    $("#heading").text("Add Sub Category");
}

function doEdit(id) {
    $("#hdSubCategoryId").val(id);
    $("#sub_category_name").focus();
    $("#save").text("Update");
    $("#heading").text("Update Sub Category");
    getSubCategoryById(id);
}

function getSubCategoryById(id) {
    $.ajax({
        type: "GET",
        url: "getsubcategory/" + id,
        dataType: "json",
        success: function (data) {
            $("#project_name").val(data.subcategory.project_id).trigger("change");
            setTimeout(function () {
                $("#category_name")
                    .val(data.subcategory.category_id)
                    .trigger("change");
            }, 1000);
            $("#sub_category_name").val(data.subcategory.sub_category_name);
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deletesubcategory/", "tableSubCategory");
}

function doStatus(id) {
    var status = $("#chkSubCategory" + id).is(":checked");
    confirmStatusChange(
        id,
        "subcategorystatus/",
        "tableSubCategory",
        status == true ? 1 : 0,
        "chkSubCategory"
    );
}
