var baseurl = window.location.origin;
$(document).ready(function () {
    //popuplist
    popupList();
});

function popupList() {
    $("#tablePopup").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getpopupdata",
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
                data: "popup_image",
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
                        '" class="avatar" width="300" height="50"/>' +
                        "</a>"
                    );
                },
            },
            {
                data: "popup_url",
            },
            {
                data: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });
}

function doEdit(id) {
    $("#popupId").val(id);
    $("#popup_image").focus();
    $("#save").text("Update");
    $("#heading").text("Update Popup");
    getPopupById(id);
}

function getPopupById(id) {
    $.ajax({
        type: "GET",
        url: "getpopup/" + id,
        dataType: "json",
        success: function (data) {
            $("#popupImage").val(data.popup.popup_image);
            $("#popup_url").val(data.popup.popup_url);
            $("#popup_image").removeAttr("required");
            $("#img").attr("src", baseurl + "/" + data.popup.popup_image);
            $("#imglink").attr("href", baseurl + "/" + data.popup.popup_image);
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deletepopup/", "tablePopup");
}

function doStatus(id) {
    var status = $("#chkPopup" + id).is(":checked");
    confirmStatusChange(
        id,
        "popupstatus/",
        "tablePopup",
        status == true ? 1 : 0,
        "chkPopup"
    );
}

// imgPreview
const chooseFile = document.getElementById("popup_image");
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
