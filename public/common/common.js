var baseurl = window.location.origin;

//tTooltip
// $(function () {
//     $('[data-bs-toggle="tooltip"]').tooltip();
// });
// Get all buttons with the class 'spinner-button'

const buttons = document.querySelectorAll(".spinner-button");

// Iterate over each button and attach the event listener
buttons.forEach((button) => {
    button.addEventListener("click", function () {
        const submitText = button.querySelector(".submit-text"); // Get the submit text element
        const spinner = button.querySelector(".spinner");
        // console.log(submitText);
        // Disable the button
        button.disabled = true;

        // Get the initial height of the button
        const initialHeight = button.offsetHeight;
        // Set a fixed height for the button to prevent changing size
        button.style.height = `${initialHeight}px`;

        // Hide submit text and show spinner
        submitText.style.display = "none";
        spinner.classList.remove("d-none");

        // Simulate loading process - replace with your actual task
        setTimeout(() => {
            // Hide spinner and show submit text again
            spinner.classList.add("d-none");
            submitText.style.display = "block";

            // Reset the height of the button to its initial value
            button.style.height = "";

            // Enable the button after 5 seconds
            button.disabled = false;
        }, 2000); // Adjust the timeout value to match your desired disabled duration
    });
});

const buttons1 = document.querySelectorAll(".spinner-button1");

// Iterate over each button and attach the event listener
buttons1.forEach((button) => {
    button.addEventListener("click", function () {
        const submitText = button.querySelector("span"); // Get the submit text element
        const spinner = button.querySelector(".spinner");

        // Disable the button
        // button.disabled = true;

        // Get the initial height of the button
        const initialHeight = button.offsetHeight;
        // Set a fixed height for the button to prevent changing size
        button.style.height = `${initialHeight}px`;

        // Hide submit text and show spinner
        submitText.style.display = "none";
        spinner.classList.remove("d-none");

        // Simulate loading process - replace with your actual task
        setTimeout(() => {
            // Hide spinner and show submit text again
            spinner.classList.add("d-none");
            submitText.style.display = "";

            // Reset the height of the button to its initial value
            button.style.height = "";

            // Enable the button after 5 seconds
            button.disabled = true;
        }, 2000); // Adjust the timeout value to match your desired disabled duration
    });
});

//Serial No Count
function serialNoCount(nRow, aData, iDisplayIndex) {
    var api = this.api();
    var currentPage = api.page.info().page;
    var index = currentPage * api.page.info().length + (iDisplayIndex + 1);
    $("td:first", nRow).html(index);
    return nRow;
}

//Check Confirmation Before Delete
function confirmDelete(id, url, tblId) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "error",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        customClass: {
            confirmButton: "btn btn-success mr-3",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            doDelete(id, url, tblId);
        }
    });
}

//Delete Data
function doDelete(id, url, tblId) {
    $.ajax({
        type: "GET",
        url: url + id,
        dataType: "json",
        success: function (data) {
            if (data.responseData.alert == "error") {
                Swal.fire({
                    title: "You won't be able to delete this!",
                    text: "This is referred in some other instance!",
                    icon: "error",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                    buttonsStyling: false,
                });
            } else {
                Swal.fire({
                    icon: "success",
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    customClass: {
                        confirmButton: "btn btn-success",
                    },
                });
            }
            refreshDatatable(tblId);
        },
    });
}

//Refresh DataTable After Actions/Functions Called
function refreshDatatable(tblId) {
    $("#" + tblId)
        .DataTable()
        .ajax.reload();
}

//Check Confirmation Before Change Status
function confirmStatusChange(id, url, tblId, status, chkswitch) {
    Swal.fire({
        title:
            status == 1
                ? "Are you sure want to Activate the status?"
                : "Are you sure want to DeActivate the status?",
        text: "You can able to revert this!",
        icon: status == 1 ? "warning" : "error",
        showCancelButton: true,
        confirmButtonText:
            status == 1 ? "Yes, Activate it!" : "Yes, DeActivate it!",
        customClass: {
            confirmButton: "btn btn-success mr-3",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            statusUpdate(id, url, status);
            Swal.fire({
                icon: "success",
                title: status == 0 ? "DeActivated!" : "Activated!",
                text:
                    status == 0
                        ? "Your file has been deactivated."
                        : "Your file has been activated.",
                customClass: {
                    confirmButton: "btn btn-success",
                },
            });
        } else {
            $("#" + chkswitch + id).prop("checked", status == 1 ? false : true);
        }
        refreshDatatable(tblId);
    });
}

//Change Status
function statusUpdate(id, url, status) {
    $.ajax({
        type: "POST",
        url: url + id + "/" + status,
        data: {
            status: status,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (data) {
            return true;
        },
    });
}

function addtocart(id) {
    var product_id = id;
    var qty = $("#quantity").val();
    var size = $("#size").val();
    var weight = $("#weight").val();
    var box = $("#box").val();
    var mqty = $("#quantity" + id).val();
    var msize = $("#size" + id).val();
    var mweight = $("#weight" + id).val();
    var mbox = $("#box" + id).val();
    $.ajax({
        type: "POST",
        url: "/retailer/addtocart",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            product_id: product_id,
            qty: qty,
            size: size,
            box: box,
            weight: weight,
            mqty: mqty,
            msize: msize,
            mweight: mweight,
            mbox: mbox,
        },
        dataType: "json",
        success: function (data, textStatus, xhr) {
            if (data.count_response) {
                $('span[id="cartCount"]').text(data.count_response.count);
                $("#navqty").text(data.count_qty + " Pcs");
                $("#navweight").text(data.count_weight + "gms");
                $("#navqty-mob").text(data.count_qty + " Pcs");
                $("#navweight-mob").text(data.count_weight + "gms");
            }
            if (data.notification_response.message) {
                var type = data.notification_response.alert;
                var message = data.notification_response.message;

                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 1500,
                };

                switch (type) {
                    case "success":
                        toastr.success(message);
                        break;
                    case "error":
                        toastr.error(message);
                        break;
                }
                if (
                    document.querySelector(
                        `button[data_id='card_id_` + id + `']`
                    )
                ) {
                    const button = document.querySelector(
                        `button[data_id='card_id_${id}']`
                    );

                    const submitText = button.querySelector("span");
                    submitText.innerText = "Added to cart";
                }
            }
        },
    });
}

function addforcart(id) {
    var product_id = id;
    var qty = $("#quantity" + id).val();
    var size = $("#size" + id).val();
    var weight = $("#weight" + id).val();
    var box = $("#box" + id).val();

    $.ajax({
        type: "POST",
        url: "/retailer/addforcart",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            product_id: product_id,
            qty: qty,
            box: box,
            size: size,
            weight: weight,
        },
        dataType: "json",
        success: function (data, textStatus, xhr) {
            console.log(data);
            if (data.count_response) {
                $('span[id="cartCount"]').text(data.count_response.count);
                $("#navqty").text(data.count_qty + " Pcs");
                $("#navweight").text(data.count_weight + "gms");
                $("#navqty-mob").text(data.count_qty + " Pcs");
                $("#navweight-mob").text(data.count_weight + "gms");
            }
            if (data.notification_response.message) {
                var type = data.notification_response.alert;
                var message = data.notification_response.message;

                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 1500,
                };

                switch (type) {
                    case "success":
                        toastr.success(message);
                        break;
                    case "error":
                        toastr.error(message);
                        break;
                }
                // Check if the button with the specified data_id exists
                const button = document.querySelector(
                    `button[data_id='card_id_${id}']`
                );
                if (button) {
                    const submitText = button.querySelector(".submit-text");
                    const badge = button.querySelector(".added-to-cart-badge");

                    // Update the button text to 'Added to cart'
                    submitText.innerText = "Added to cart";
                    // Update the badge text with the new qty
                    badge.innerText =
                        data.currentcartcount == undefined
                            ? notification_response.actualcartcount
                            : data.currentcartcount;
                    console.log(
                        "qty",
                        data.actualcartcount,
                        data.currentcartcount
                    );

                    // Add the class to indicate the item is added to the cart
                    button.classList.add("added-to-cart-btn");

                    // Show the spinner (optional if you want to indicate a process)
                    showSpinner(button);
                }
            }
        },
    });
}

function showSpinner(button) {
    const submitText = button.querySelector("span:not(.spinner)"); // Get the submit text element
    const spinner = button.querySelector(".spinner");

    // Get the initial height of the button
    const initialHeight = button.offsetHeight;
    // Set a fixed height for the button to prevent changing size
    button.style.height = `${initialHeight}px`;

    // Hide submit text and show spinner
    submitText.style.display = "none";
    spinner.classList.remove("d-none");

    // Simulate loading process - replace with your actual task
    setTimeout(() => {
        // Hide spinner and show submit text again
        spinner.classList.add("d-none");
        submitText.style.display = "";

        // Reset the height of the button to its initial value
        button.style.height = "";
    }, 2000); // Adjust the timeout value to match your desired disabled duration
}

function addAllToCart() {
    // Assuming you are using jQuery
    var checkedIds = $(".card-checkbox:checked")
        .map(function () {
            return $(this).data("id");
        })
        .get();
    var size = [];
    var weight = [];
    var qty = [];
    var box = [];

    checkedIds.forEach(function (id) {
        size.push($("#size" + id).val());
        weight.push($("#weight" + id).val());
        qty.push($("#quantity" + id).val());
        box.push($("#box" + id).val());
    });
    $.ajax({
        type: "POST",
        url: "/retailer/addalltocart",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            product_id: checkedIds,
            size: size,
            weight: weight,
            qty: qty,
            box: box,
        },
        dataType: "json",
        success: function (data, textStatus, xhr) {
            if (data.count_response) {
                $('span[id="cartCount"]').text(data.count_response.count);
                $("#navqty").text(data.count_qty + " Pcs");
                $("#navweight").text(data.count_weight + "gms");
                $("#navqty-mob").text(data.count_qty + " Pcs");
                $("#navweight-mob").text(data.count_weight + "gms");
            }
            if (data.notification_response.message) {
                var type = data.notification_response.alert;
                var message = data.notification_response.message;
                switch (type) {
                    case "success":
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: message,
                            timer: 3500,
                            showConfirmButton: false,
                        });
                        break;
                    case "error":
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: message,
                            timer: 3500,
                            showConfirmButton: false,
                        });
                        break;
                }
                checkedIds.forEach(function (id) {
                    if (
                        document.querySelector(
                            `button[data_id='card_id_` + id + `']`
                        )
                    ) {
                        const button = document.querySelector(
                            `button[data_id='card_id_${id}']`
                        );
                        const badge = button.querySelector(
                            ".added-to-cart-badge"
                        );

                        const submitText = button.querySelector("span");
                        submitText.innerText = "Added to cart";
                        badge.innerText = $(`#quantity${id}`).val();
                        button.classList.add("added-to-cart-btn");
                    }
                });
            }
            $('input[type="checkbox"]').prop("checked", false);
            $("#addalltocart").attr("disabled", true);
        },
    });
}

function repeatOrder() {
    var productIds = $("#productIds").val();
    var productIdsArray = productIds.split(",");

    var qtys = [];
    var finish_ids = [];

    productIdsArray.forEach(function (id) {
        qtys.push($("#quantitys" + id).val());
        finish_ids.push($("#finishs" + id).val());
        console.log(id, $("#finishs" + id).val());
    });

    $.ajax({
        type: "POST",
        url: "/repeatorder",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            product_ids: productIdsArray,
            qtys: qtys,
            finish_ids: finish_ids,
        },
        dataType: "json",
        success: function (data, textStatus, xhr) {
            if (data.count_response) {
                $('span[id="cartCount"]').text(data.count_response.count);
            }
            if (data.notification_response.message) {
                var type = data.notification_response.alert;
                var message = data.notification_response.message;

                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 1500,
                };

                var roleId = $("#auth").val();
                console.log(roleId); // Get the role ID
                if (roleId == 4 || roleId == 5) {
                    var url = "/retailer/cart"; // URL for role_id 4
                } else {
                    var url = "/cart"; // Default URL for role_id 3
                }
                switch (type) {
                    case "success":
                        // Redirect to cart route
                        window.location.href = url;
                        toastr.success(message);
                        break;
                    case "error":
                        toastr.error(message);
                        break;
                }
            }
        },
    });
}

function repeatOrderById(e) {
    $.ajax({
        type: "POST",
        url: "/repeatorderByid",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            order_id: e.getAttribute("data_id"),
        },
        dataType: "json",
        success: function (data, textStatus, xhr) {
            if (data.count_response) {
                $('span[id="cartCount"]').text(data.count_response.count);
            }
            if (data.notification_response.message) {
                var type = data.notification_response.alert;
                var message = data.notification_response.message;

                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 1500,
                };

                var roleId = $("#auth").val(); // Get the role ID
                if (roleId == 4 || roleId == 5) {
                    var url = "/retailer/cart"; // URL for role_id 4
                } else {
                    var url = "/cart"; // Default URL for role_id 3
                }
                switch (type) {
                    case "success":
                        // Redirect to cart route
                        window.location.href = url;
                        toastr.success(message);
                        break;
                    case "error":
                        toastr.error(message);
                        break;
                }
            }
        },
    });
}

function addtowishlist(id) {
    var product_id = id;
    $.ajax({
        type: "GET",
        url: "/addtowishlist",
        data: {
            product_id: product_id,
        },
        dataType: "json",
        success: function (data, textStatus, xhr) {
            if (data.response.alert == "success") {
                toastr.success(data.response.message);
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 1500,
                };
            } else {
                toastr.error(data.response.message);
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 1500,
                };
            }
        },
    });
}
