var baseurl = window.location.origin;
$(document).ready(function () {
    $("#tableCategory").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getcategorydata",
        fnRowCallback: serialNoCount,
                createdRow: function (row, data, dataIndex) {
            // Add tooltip to the 'Edit' icon in the 'Action' column (column index 5)
            $('td:eq(5) .edit', row).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Edit');

            // Add tooltip to the 'Delete' icon in the 'Action' column (column index 5)
            $('td:eq(5) .delete', row).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Delete');

            // Initialize tooltips for the created row
            $('[data-bs-toggle="tooltip"]', row).tooltip();
        },
        columns: [
            {
                data: "id",
            },
            {
                data: "category_image",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    var imageUrl = data
                        ? baseurl + "/" + data
                        : "/backend/assets/img/no-image.jpg";
                    return (
                        '<a href="' +
                        imageUrl +
                        '" data-lightbox="image-' +
                        row.id +
                        '" data-title="Product Image">' +
                        '<img src="' +
                        imageUrl +
                        '" class="avatar" width="38" height="38"/>' +
                        "</a>"
                    );
                },
            },
            {
                data: "project_name",
            },
            {
                data: "category_name",
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkCategory${row.id}" 
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

function cancels() {
    $("#category_name").val("");
    $("#save").text("Save");
    $("#heading").text("Add Category");
    $("#img").attr("src", baseurl + "/backend/assets/img/no-image.jpg");
}

function doEdit(id) {
    $("#hdCategoryId").val(id);
    $("#category_name").focus();
    $("#save").text("Update");
    $("#heading").text("Update Category");
    getCategoryById(id);
}

function getCategoryById(id) {
    $.ajax({
        type: "GET",
        url: "getcategory/" + id,
        dataType: "json",
        success: function (data) {
            $("#project_name").val(data.category.project_id).trigger("change");
            $("#category_name").val(data.category.category_name);
            $("#categoryImage").val(data.category.category_image);
            $("#img").attr("src", baseurl + "/" + data.category.category_image);
            $("#imglink").attr(
                "href",
                baseurl + "/" + data.category.category_image
            );
            $("#category_image").removeAttr("required");
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deletecategory/", "tableCategory");
}

function doStatus(id) {
    var status = $("#chkCategory" + id).is(":checked");
    confirmStatusChange(
        id,
        "categorystatus/",
        "tableCategory",
        status == true ? 1 : 0,
        "chkCategory"
    );
}

// imgPreview
const chooseFile = document.getElementById("category_image");
const imgPreview = document.getElementById("img-preview");

chooseFile.addEventListener("change", function () {
    getImgData();
});

function getImgData() {
    const files = chooseFile.files[0];
    if (files) {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(files);
        fileReader.addEventListener("load", function () {
            imgPreview.style.display = "block";
            imgPreview.innerHTML =
                '<a href="' +
                this.result +
                '" data-lightbox="uploaded-image-1" data-title="Selected Image"><img class="img-fluid ml-2" width="40" height="40" src="' +
                this.result +
                '" /></a>';
        });
    }
}



