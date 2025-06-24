var baseurl = window.location.origin;
$(document).ready(function () {
    //bannerlist
    bannerList();
});

function bannerList() {
    $("#tableBanner").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getbannerdata",
        fnRowCallback: serialNoCount,
        createdRow: function (row, data, dataIndex) {
            // Add tooltip to the 'Edit' icon in the 'Action' column (column index 5)
            $("td:eq(5) .edit", row)
                .attr("data-bs-toggle", "tooltip")
                .attr("data-bs-placement", "top")
                .attr("title", "Edit");

            // Add tooltip to the 'Delete' icon in the 'Action' column (column index 5)
            $("td:eq(5) .delete", row)
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
                data: "banner_image",
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
            { data: "project" },
            {
                data: "banner_url",
            },
            {
                data: "banner_position",
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkBanner${row.id}" 
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

$("#bannerposition").on("change", function () {
    size();
});

function size() {
    var size_id = $("#bannerposition").val();
    $.ajax({
        type: "GET",
        url: "getbannersize",
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
                "(" + data.size.width + "px" + " * " + data.size.height + "px)"
            );
            $("#banner_image").attr("height", data.size.height);
            $("#banner_image").attr("width", data.size.width);
            $("#height").val(data.size.height);
            $("#width").val(data.size.width);
        },
    });
}

function doEdit(id) {
    $("#bannerId").val(id);
    $("#banner_image").focus();
    $("#save").text("Update");
    $("#heading").text("Update Banner");
    getBannnerById(id);
}

function getBannnerById(id) {
    $.ajax({
        type: "GET",
        url: "getbanner/" + id,
        dataType: "json",
        success: function (data) {
            $("#bannerposition")
                .val(data.banner.banner_position_id)
                .trigger("change");
            $("#bannerImage").val(data.banner.banner_image);
            $("#project").val(data.banner.project);
            $("#banner_url").val(data.banner.banner_url);
            $("#banner_image").removeAttr("required");
            $("#img").attr("src", baseurl + "/" + data.banner.banner_image);
            $("#imglink").attr(
                "href",
                baseurl + "/" + data.banner.banner_image
            );
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deletebanner/", "tableBanner");
}

function doStatus(id) {
    var status = $("#chkBanner" + id).is(":checked");
    confirmStatusChange(
        id,
        "bannerstatus/",
        "tableBanner",
        status == true ? 1 : 0,
        "chkBanner"
    );
}

// imgPreview
const chooseFile = document.getElementById("banner_image");
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
