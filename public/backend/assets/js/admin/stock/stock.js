var baseurl = window.location.origin;
$(document).ready(function () {
    stock();
});

function stock() {
    $("#stockTable").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        ajax: {
            url: "/stockdata",
            type: "GET",
            error: function (xhr, error, thrown) {
                console.log(
                    "Error in DataTable AJAX request: ",
                    error,
                    thrown,
                    xhr.responseText
                );
                alert(
                    "An error occurred while fetching data. Please check the console for more details."
                );
            },
        },
        columns: [
            { data: "product_unique_id" },
            { data: "product_name" },
            { data: "style_name" },
            {
                data: "qty",
                render: function (data, type, row) {
                    return (
                        '<input type="text" id="qty' +
                        row.id +
                        '" name="qty" class="form-control" maxlength="50" title="Please enter Quantity" value="' +
                        data +
                        '">'
                    );
                },
            },
            //   {
            //     data: "action",
            //     orderable: false,
            //     searchable: false,
            //     render: function (data, type, row) {
            //       return `<input type="hidden" id="product_id${row.id}" name="product_id" value="${row.id}">
            // <button type="button" title="Update" class="btn btn-primary" onclick="stockUpdate(${row.id});">Update</button>`;
            //     },
            //   },
            {
                data: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });
}

function stockUpdate(id) {
    var product_id = $("#product_id" + id).val();
    console.log(product_id);
    var qty = $("#qty" + id).val();
    $.ajax({
        url: "/stockupdate",
        method: "get",
        data: {
            product_id: product_id,
            qty: qty,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // For Laravel, adjust as needed for your backend
        },
        success: function (response) {
            console.log(response);
            if (response && response.message) {
                iziToast.success({
                    title: "Success",
                    message: response.message,
                    position: "topRight",
                    timeout: 1500,
                });
            } else {
                iziToast.error({
                    title: "Error",
                    message: "Unexpected response format",
                    position: "topRight",
                    timeout: 1500,
                });
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseJSON, xhr.responseJSON.message, error);
            iziToast.error({
                title: "Error",
                message: xhr.responseJSON ? xhr.responseJSON.message : error,
                position: "topRight",
                timeout: 1500,
            });
        },
    });
}

function updateStockStatusBadge(status) {
    const badge = document.getElementById("stock-status");
    badge.className = "badge p-2";

    if (status === "completed") {
        badge.classList.add("bg-success", "text-white");
        badge.innerText = "✅ Stock Import Completed";
    } else if (status === "processing") {
        badge.classList.add("bg-warning", "text-white");
        badge.innerText = "⏳ Import In Progress";
    } else if (status === "pending") {
        badge.classList.add("bg-info", "text-white");
        badge.innerText = "⌛ Import Queued";
    } else if (status === "failed") {
        badge.classList.add("bg-danger");
        badge.innerText = "❌ Import Failed";
    } else {
        badge.innerText = "";
    }
}

function fetchStockStatus() {
    fetch("import-status")
        .then((res) => res.json())
        .then((data) => {
            updateStockStatusBadge(data.status);
            const uploadedAt = document.getElementById("stock-uploaded-at");
            uploadedAt.innerText = data.created_at
                ? `Last uploaded: ${data.created_at}`
                : "";
        });
}

// Initial call + periodic polling
fetchStockStatus();
setInterval(fetchStockStatus, 5000);
