$(document).ready(function () {
    $("#pincode").on("keyup", function () {
        var pincode = $(this).val();
        if (pincode.length === 6) {
            getstatecity(pincode);
        }
    });

    function getstatecity(pincode) {
        $.ajax({
            url: "retailer/proxy/pincode/" + pincode,
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (result) {
                if (
                    result &&
                    result[0] &&
                    result[0].PostOffice &&
                    result[0].PostOffice[0]
                ) {
                    var postOffice = result[0].PostOffice[0];
                    $("#district").val(postOffice.District);
                    $("#state").val(postOffice.State);
                } else {
                    toastr.error("No state and city found");
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 1500,
                    };
                    $("#district").val("");
                    $("#state").val("");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                toastr.error("Failed to fetch data");
            },
        });
    }
});

const dummyData = {
    phoneNumber: document.getElementById("phoneNumber").value,
    otp: document.getElementById("otp").value,
};
let isLoggedIn = $("#authlog").val(); // Change this based on actual login status

function isValidPhoneNumber(phoneNumber) {
    const phonePattern = /^\d{10}$/;
    return phonePattern.test(phoneNumber);
}

function handleLogin() {
    const phoneNumber = document.getElementById("authmob").value;

    const phoneError = document.getElementById("phoneError");
    if (!isValidPhoneNumber(phoneNumber)) {
        phoneError.style.display = "block";
        return;
    } else {
        phoneError.style.display = "none";
    }
    if (phoneNumber) {
        showScreen("otpScreen");
        startResendTimer();
    }
}

function handleOTP() {
    const otp = document.getElementById("otp").value;
    if (otp) {
        window.location.href = "retailer/home";
        isLoggedIn = true;
        $("#authModal").modal("hide");
    } else {
        alert("Invalid OTP");
    }
}

function handleSignup() {
    const name = document.getElementById("name").value;
    const shopName = document.getElementById("shopName").value;
    const signupPhoneNumber =
        document.getElementById("signupPhoneNumber").value;
    const email = document.getElementById("email").value;
    const address = document.getElementById("address").value;
    const pincode = document.getElementById("pincode").value;
    const district = document.getElementById("district").value;
    const state = document.getElementById("state").value;
    const gst = document.getElementById("gst").value;
    const dealerName = document.getElementById("dealerName").value;

    // Email validation
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        document.getElementById("email").focus();
        return;
    }

    if (
        name.trim() === "" ||
        shopName.trim() === "" ||
        signupPhoneNumber.trim() === "" ||
        email.trim() === "" ||
        // address.trim() === "" ||
        pincode.trim() === "" ||
        district.trim() === "" ||
        state.trim() === ""
    ) {
        document.getElementById("signupErrorMessage").style.display = "block";
        return;
    }

    const formData = {
        retailer_name: name,
        company_name: shopName,
        mobile: signupPhoneNumber,
        retailer_email: email,
        address: address,
        pincode: pincode,
        district: district,
        state: state,
        dealer_details: dealerName,
        GST: gst,
    };

    $.ajax({
        url: $("#signupForm").attr("action"), // Get the form action URL
        type: "POST",
        data: formData,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        beforeSend: function () {
            $(".sign-up-page_btn").prop("disabled", true).text("Saving...");
        },
        success: function (response) {
            if (response.alert === "success") {
                toastr.success(response.message);
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 1500,
                };
                window.location.href = "retailer/home";
            } else {
                toastr.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: ", status, error);
            toastr.error("An error occurred during signup.");
        },
        complete: function () {
            $(".sign-up-page_btn").prop("disabled", false).text("Save");
        },
    });
}

function displayErrorMessage(fieldId, message) {
    const errorElement = document.querySelector(`#${fieldId} + .error-message`);
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = "block";
    }
}

function hideErrorMessage(fieldId) {
    const errorElement = document.querySelector(`#${fieldId} + .error-message`);
    if (errorElement) {
        errorElement.style.display = "none";
    }
}

function showLoginScreen() {
    showScreen("loginScreen");
}

function showSignupScreenFromLogin() {
    const phoneNumber = document.getElementById("phoneNumber").value;
    if (phoneNumber) {
        document.getElementById("signupPhoneNumber").value = phoneNumber;
    }
    showScreen("signupScreen");
}

function showScreen(screenId) {
    const screens = document.querySelectorAll(".screen");
    const modalDialog = document.querySelector("#authModal .modal-dialog");

    // Remove any existing size classes
    modalDialog.classList.remove("modal-lg", "modal-md");

    // Set the modal size based on the screenId
    if (screenId === "signupScreen") {
        modalDialog.classList.add("modal-lg"); // Large modal for signup
    } else {
        modalDialog.classList.add("modal-md"); // Medium modal for other screens
    }

    // Show the appropriate screen
    screens.forEach((screen) => screen.classList.remove("active"));
    document.getElementById(screenId).classList.add("active");
}

document.addEventListener("DOMContentLoaded", () => {
    // Show modal if user clicks on a link and is not logged in
    document.querySelectorAll("a:not(.no-login-required)").forEach((link) => {
        link.addEventListener("click", function (event) {
            if (!isLoggedIn) {
                event.preventDefault();
                console.log("clicked");
                $("#authModal").modal("show");
                $("#searchModal").modal("hide");
            }
        });
    });

    // Reopen modal if user closes it without logging in
    $("#authModal").on("hidden.bs.modal", function () {
        if (!isLoggedIn) {
            document
                .querySelectorAll("a:not(.no-login-required)")
                .forEach((link) => {
                    link.addEventListener(
                        "click",
                        function (event) {
                            if (!isLoggedIn) {
                                event.preventDefault();
                                $("#authModal").modal("show");
                                $("#searchModal").modal("hide");
                            }
                        },
                        {
                            once: true,
                        }
                    );
                });
        }
    });
});

function generateOTP(event) {
    event.preventDefault();
    const phoneNumber = $("#phoneNumber").val();
    // Storing the mobile number in localStorage
    localStorage.setItem("mobile", phoneNumber);
    // You can access localStorage data in JavaScript and use it in your Blade view
    const mobile = localStorage.getItem("mobile");
    document.getElementById("authmob").value = mobile;
    $("#loginnum").html("+91 " + mobile);
    $("#mobilenumber").val(mobile);
    $("#signupPhoneNumber").html(mobile ? mobile : "");
    if (phoneNumber.length === 10) {
        $.ajax({
            url: "retailer/generateotp",
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                mobile: phoneNumber,
            },
            beforeSend: function () {
                $("#loginButton").prop("disabled", true);
                $(".spinner-border").show();
                $(".loginBtn_text").hide();
            },
            success: function (response) {
                if (response.message == "OTP sent successfully!") {
                    toastr.success(response.message);
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 1500,
                    };
                    $("#hdroleid").val(response.role_id);
                    handleLogin();
                } else {
                    toastr.error(response.message);
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 1500,
                    };
                    showScreen("signupScreen");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                toastr.error("You Are Not Register Please Register First");
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 1500,
                };
            },
            complete: function () {
                $("#loginButton").prop("disabled", false);
                $(".spinner-border").hide();
                $(".loginBtn_text").show();
            },
        });
    } else {
        $("#phoneError").show();
    }
}

$("#otpForm").submit(function (event) {
    event.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
        url: $(this).attr("action"),
        type: "GET",
        data: formData,
        beforeSend: function () {
            $("#loginVerifyBtn").prop("disabled", true);
            $(".spinner-border").show();
            $(".loginBtn_text").text("Submitting...");
        },
        success: function (response) {
            if (response.success) {
                toastr.success(response.message);
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 1500,
                };
                console.log($("#hdroleid").val());

                if ($("#hdroleid").val() == 3) {
                    window.location.href = "/home";
                } else {
                    window.location.href = "retailer/home";
                }
            } else {
                toastr.error(response.message);
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 1500,
                };
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: ", status, error);
            alert("An error occurred during OTP verification.");
        },
        complete: function () {
            $("#loginVerifyBtn").prop("disabled", false);
            $(".spinner-border").hide();
            $(".loginBtn_text").text("Submit");
        },
    });
});

$(document).ready(function () {
    $("#phoneError").hide();
});

// Set the initial timer value to 5 minutes (300 seconds)
let timerSeconds = $("#otpexpiry").val();

// Function to update the timer text
function updateTimerText() {
    // Calculate minutes and seconds
    const minutes = Math.floor(timerSeconds / 60);
    const seconds = timerSeconds % 60;

    // Format the timer values to display leading zero if needed
    const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes;
    const formattedSeconds = seconds < 10 ? `0${seconds}` : seconds;

    document.getElementById(
        "resendLinkContainer"
    ).innerHTML = `Resend in <span class="text-warning">${formattedMinutes}:${formattedSeconds}</span>`;
}

// Function to handle the countdown and show the "Resend" text element
function startResendTimer() {
    // Update the timer text initially
    updateTimerText();

    // Decrement the timer every second
    const timerInterval = setInterval(() => {
        timerSeconds--;

        // Update the timer text
        updateTimerText();

        // If the timer reaches 0, show the "Resend" text element and clear the interval
        if (timerSeconds === 0) {
            clearInterval(timerInterval);
            showResendText();
        }
    }, 1000);
}

// Function to show the "Resend" text element
function showResendText() {
    const resendLinkContainer = document.getElementById("resendLinkContainer");
    resendLinkContainer.innerHTML =
        '<a href="#" class="resend-otp-text" onclick="restartTimer()">Resend</a>';
}

// Function to restart the timer
function restartTimer() {
    // Reset the timerSeconds value to the value from #otpexpiry (or set it to 5 minutes if needed)
    timerSeconds = $("#otpexpiry").val();

    // Clear the OTP input field
    $("#otp").val("").focus(); // Clear the input and set focus

    // Start the timer again
    startResendTimer();

    // Get the phone number from the input field
    const phoneNumber = $("#authmob").val();

    $.ajax({
        url: "retailer/generateotp",
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            mobile: phoneNumber,
        },
        success: function (response) {
            if (response.message === "OTP sent successfully!") {
                toastr.success(response.message);
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 1500,
                };
            } else {
                toastr.error(response.message);
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 1500,
                };
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: ", status, error);
            toastr.error("Failed to resend OTP. Please try again.");
            toastr.options = {
                closeButton: true,
                progressBar: true,
                timeOut: 1500,
            };
        },
    });
}
