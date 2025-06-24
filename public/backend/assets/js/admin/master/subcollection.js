var baseurl = window.location.origin;
$(document).ready(function () {
    //collectionlist
    subcollectionList();
});

function subcollectionList() {
    $("#tableSubCollection").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [
            [0, "ASC"]
        ],
        ajax: "getsubcollectiondata",
        fnRowCallback: serialNoCount,
        createdRow: function (row, data, dataIndex) {
            // Add tooltip to the 'Edit' icon in the 'Action' column (column index 5)
            $('td:eq(4) .edit', row).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Edit');

            // Add tooltip to the 'Delete' icon in the 'Action' column (column index 5)
            $('td:eq(4) .delete', row).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Delete');

            // Initialize tooltips for the created row
            $('[data-bs-toggle="tooltip"]', row).tooltip();
        },
        columns: [{
                data: "id"
            },
            {
                data: "project_name"
            },
            {
                data: "collection_name"
            },
            {
                data: "sub_collection_name"
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkSubCollection${row.id}" 
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
}

function doEdit(id) {
    $("#subCollectionId").val(id);
    $("#sub_collection_name").focus();
    $("#save").text("Update");
    $("#heading").text("Update Sub Collecton");
    getSubCollectionById(id);
}

function getSubCollectionById(id) {
    $.ajax({
        type: "GET",
        url: "getsubcollection/" + id,
        dataType: "json",
        success: function (data) {
            $("#sub_collection_name").val(data.subcollection.sub_collection_name);
            $("#collection").val(data.subcollection.collection_id).trigger("change");
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deletesubcollection/", "tableSubCollection");
}

function doStatus(id) {
    var status = $("#chkSubCollection" + id).is(":checked");
    confirmStatusChange(
        id,
        "subcollectionstatus/",
        "tableSubCollection",
        status == true ? 1 : 0,
        "chkSubCollcetion"
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
            imgPreview.innerHTML = '<a href="' + this.result +
                '" data-lightbox="uploaded-image-1" data-title="Selected Image"><img class="img-fluid ml-2" width="40" height="40" src="' +
                this.result + '" /></a>';
        });
    }
}
