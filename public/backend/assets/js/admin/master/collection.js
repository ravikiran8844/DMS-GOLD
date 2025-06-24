var baseurl = window.location.origin;
$(document).ready(function () {
    //collectionlist
    collectionList();
});

function collectionList() {
    $("#tableCollection").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getcollectiondata",
        fnRowCallback: serialNoCount,
        createdRow: function (row, data, dataIndex) {
            // Add tooltip to the 'Edit' icon in the 'Action' column (column index 5)
            $("td:eq(6) .edit", row)
                .attr("data-bs-toggle", "tooltip")
                .attr("data-bs-placement", "top")
                .attr("title", "Edit");

            // Add tooltip to the 'Delete' icon in the 'Action' column (column index 5)
            $("td:eq(6) .delete", row)
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
                data: "collection_image",
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
                data: "collection_name",
            },
            {
                data: "project_name",
            },
            {
                data: "category_name",
            },
            {
                data: "content",
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkCollection${row.id}" 
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
}

$("#image_type").on("change", function () {
    size();
});

function size() {
    var size_id = $("#image_type").val();
    $.ajax({
        type: "GET",
        url: "getcollectionsize",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            size_id: size_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (data) {
            $("#size").text(
                "(" + data.size.height + "px" + " * " + data.size.width + "px)"
            );
            $("#collection_image").attr("height", data.size.height);
            $("#collection_image").attr("width", data.size.width);
            $("#height").val(data.size.height);
            $("#width").val(data.size.width);
        },
    });
}

function doEdit(id) {
    $("#collectionId").val(id);
    $("#collection_name").focus();
    $("#save").text("Update");
    $("#heading").text("Update Collecton");
    getCollectionById(id);
}

function getCollectionById(id) {
    $.ajax({
        type: "GET",
        url: "getcollection/" + id,
        dataType: "json",
        success: function (data) {
            $("#collection_name").val(data.collection.collection_name);
            $("#image_type").val(data.collection.size_id).trigger("change");
            setTimeout(function () {
                $("#project_name")
                    .val(data.collection.project_id)
                    .trigger("change");
            }, 500);
            setTimeout(function () {
                $("#category_name")
                    .val(data.collection.category_id)
                    .trigger("change");
            }, 800);
            $("#content").val(data.collection.content);
            $("#collectionImage").val(data.collection.collection_image);
            $("#collection_image").removeAttr("required");
            $("#img").attr(
                "src",
                baseurl + "/" + data.collection.collection_image
            );
            $("#imglink").attr(
                "href",
                baseurl + "/" + data.collection.collection_image
            );
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deletecollection/", "tableCollection");
}

function doStatus(id) {
    var status = $("#chkCollection" + id).is(":checked");
    confirmStatusChange(
        id,
        "collectionstatus/",
        "tableCollection",
        status == true ? 1 : 0,
        "chkCollcetion"
    );
}

// imgPreview
const chooseFile = document.getElementById("collection_image");
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
