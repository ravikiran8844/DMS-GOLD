var baseurl = window.location.origin;
$(document).ready(function () {
    $("#tableBrand").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[0, "ASC"]],
        ajax: "getbranddata",
        fnRowCallback: serialNoCount,
        createdRow: function (row, data, dataIndex) {
            // Add tooltip to the 'Edit' icon in the 'Action' column (column index 5)
            $('td:eq(3) .edit', row).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Edit');

            // Add tooltip to the 'Delete' icon in the 'Action' column (column index 5)
            $('td:eq(3) .delete', row).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Delete');

            // Initialize tooltips for the created row
            $('[data-bs-toggle="tooltip"]', row).tooltip();
        },
        columns: [
            {
                data: "id",
            },
            {
                data: "brand_name",
            },
            {
                data: "is_active",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<div class="pretty p-switch p-fill">
                    <input type="checkbox" id="chkBrand${row.id}" 
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
    $("#brandId").val(id);
    $("#brand_name").focus();
    $("#save").text("Update");
    $("#heading").text("Update Brand");
    getBrandById(id);
}

function getBrandById(id) {
    $.ajax({
        type: "GET",
        url: "getbrand/" + id,
        dataType: "json",
        success: function (data) {
            $("#brand_name").val(data.brand.brand_name);
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "deletebrand/", "tableBrand");
}

function doStatus(id) {
    var status = $("#chkBrand" + id).is(":checked");
    confirmStatusChange(
        id,
        "brandstatus/",
        "tableBrand",
        status == true ? 1 : 0,
        "chkBrand"
    );
}
