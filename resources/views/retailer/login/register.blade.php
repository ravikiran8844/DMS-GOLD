<!DOCTYPE html>
<html lang="en">

<head>
    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments)
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "mopb0nhhuf");
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page - Emerald OMS</title>
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('retailer/assets/img/favicon.ico') }}' />
    <link rel="stylesheet" href="{{ asset('retailer/assets/lib/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('retailer/assets/css/login.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css"
        rel="stylesheet">
    <!---- Toaster ----->
    <link href="{{ asset('retailer/assets/lib/css/toastr.css') }}" rel="stylesheet" />
</head>

<body>
    <section class="sign-up-page-form_wrapper">
        <form action="{{ route('retailerregisterstore') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container py-5">
                <div
                    class="col-12 d-flex flex-column gap-4 flex-lg-row justify-content-between align-items-center border-1 border-bottom pb-4">
                    <div class="text-center">
                        <a href="{{ route('retailerlogin') }}">
                            <img width="120" height="120" class="img-fluid" src="assets/img/emerald-logo.png"
                                alt></a>
                        <div class="fs-5 mt-3">WELCOME TO</div>
                        <div class="fs-4 fw-bold mt-0">EMERALD JEWEL INDUSTRY</div>
                        <!-- <div class="fs-2 brittany-font mt-3">Retailer Program</div> -->
                    </div>
                    <div class="text-center ms-lg-auto">
                        <!-- <a href="{{ route('retailerlogin') }}">
        <img width="120" height="120" class="img-fluid" src="assets/img/emerald-logo.png"
       alt></a> -->
                        <div class="fs-4 brittany-font mt-3 mb-3">Retailer Program</div>
                        <div class="mt-3">Already have an account? <span class="fw-bold"><a
                                    class="text-decoration-none text-orange" style="color: #667B68"
                                    href="{{ route('retailerlogin') }}">Sign in
                                    now</a></span>
                        </div>
                    </div>
                </div>
                <div class="row gy-4 gy-lg-5 mt-0">
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label fw-semibold" for="">Name<span
                                class="text-danger">*</span></label>
                        <input required placeholder="Enter your name" class="form-control" type="text"
                            name="retailer_name" id="retailer_name" required>
                        @error('retailer_name')
                            <div class="text-danger">{{ $errors->first('retailer_name') }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label fw-semibold" for="">Shop Name<span
                                class="text-danger">*</span></label>
                        <input required placeholder="Enter your shop Name" class="form-control" type="text"
                            name="company_name" id="company_name" required>
                        @error('company_name')
                            <div class="text-danger">{{ $errors->first('company_name') }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label fw-semibold" for="">Mobile Number<span
                                class="text-danger">*</span></label>
                        <input required placeholder="Enter your mobile number" minlength="10" maxlength="10"
                            class="form-control" type="text" name="mobile" id="mobile" required>
                        @error('mobile')
                            <div class="text-danger">{{ $errors->first('mobile') }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label fw-semibold" for="">Email<span
                                class="text-danger">*</span></label>
                        <input type="email" required placeholder="Enter your email" class="form-control"
                            name="retailer_email" id="email" required>
                        @error('retailer_email')
                            <div class="text-danger">{{ $errors->first('retailer_email') }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label fw-semibold" for="">Address<span
                                class="text-danger">*</span></label>
                        <input required placeholder="Enter your Address" class="form-control" type="text"
                            name="address" id="address" required>
                        @error('address')
                            <div class="text-danger">{{ $errors->first('address') }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-lg-4">
                        <label class="form-label fw-semibold" for="">Pincode<span
                                class="text-danger">*</span></label>
                        <input placeholder="Enter your pincode" class="form-control" type="text" name="pincode"
                            id="pincode" required maxlength="6" minlength="6">
                        @error('pincode')
                            <div class="text-danger">{{ $errors->first('pincode') }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label fw-semibold" for="">District<span
                                class="text-danger">*</span></label>
                        <input required placeholder="Enter your district" class="form-control" type="text"
                            name="district" id="district" readonly>
                        @error('district')
                            <div class="text-danger">{{ $errors->first('district') }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label fw-semibold" for="">State<span
                                class="text-danger">*</span></label>
                        <input placeholder="Enter your state" class="form-control" type="text" name="state"
                            id="state" readonly required>
                        @error('state')
                            <div class="text-danger">{{ $errors->first('state') }}
                            </div>
                        @enderror
                    </div>
                    {{-- <div class="col-12 col-md-6 col-lg-4">
							<label class="form-label fw-semibold" for="">Zone<span
							class="text-danger">*</span></label>
							<select placeholder="Select Zone" class="form-select" name="zone" id="zone">
								<option value="" selected disabled>Please Select Zone</option>
								@foreach ($zone as $item)
                                <option value="{{ $item->id }}">{{ $item->zone_name }}</option>
								@endforeach
							</select>
							@error('zone')
                            <div class="text-danger">{{ $errors->first('zone') }}
							</div>
							@enderror
						</div> --}}
                    <div class="col-12 col-lg-4">
                        <label class="form-label fw-semibold" for="">GST</label>
                        <input placeholder="Enter your GST" class="form-control" type="text" name="GST"
                            id="GST">
                        @error('GST')
                            <div class="text-danger">{{ $errors->first('GST') }}
                            </div>
                        @enderror
                    </div>
                    {{-- <div class="col-12 col-lg-4">
							
							<label class="form-label fw-semibold" for="">Select Preferred Dealer 1<span
							class="text-danger">*</span></label>
							
							<select class="form-select" placeholder="Select preferred dealer 1" name="preferredDealer1"
                            id="preferredDealer1" required>
								<option value=""></option>
							</select>
							@error('preferredDealer1')
                            <div class="text-danger">{{ $errors->first('preferredDealer1') }}
							</div>
							@enderror
						</div>
						<div class="col-12 col-lg-4">
							
							<label class="form-label fw-semibold" for="">Select Preferred Dealer
							2<sup class="text-muted">(optional)</sup></label>
							
							<select class="form-select" placeholder="Select preferred dealer 2" name="preferredDealer2"
                            id="preferredDealer2">
								<option value=""></option>
							</select>
							@error('preferredDealer2')
                            <div class="text-danger">{{ $errors->first('preferredDealer2') }}
							</div>
							@enderror
						</div>
						<div class="col-12 col-lg-4">
							
							<label class="form-label fw-semibold" for="">Select Preferred Dealer
							3<sup class="text-muted">(optional)</sup></label>
							
							<select class="form-select" placeholder="Select preferred dealer 3" name="preferredDealer3"
                            id="preferredDealer3">
								<option value=""></option>
							</select>
							@error('preferredDealer3')
                            <div class="text-danger">{{ $errors->first('preferredDealer3') }}
							</div>
							@enderror
						</div> --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="">If you are currently purchasing from any
                            existing AUTHORISED EMERALD DEALERS, Please enter their name</label>
                        <textarea placeholder="Enter Dealer Name" class="form-control" style="height: 100px;" type="text"
                            name="dealer_details" id="dealer_details"></textarea>

                    </div>
                    <div class="col-12 col-md-4 d-flex justify-content-center align-items-center mx-auto">
                        <button class="btn sign-up-page_btn">Save</button>
                    </div>
                </div>
            </div>
        </form>
        <a style=" position: fixed; bottom: 30px; right: 10px; z-index: 9999; " target="_blank"
            href="https://api.whatsapp.com/send?phone=919791714333&text=I%20have%20questions%20regarding%20Retailer%20Management%20System">
            <img src="{{ asset('retailer/assets/img/whatsapp.png') }}" width="42" height="42"
                alt="whatsapp icon">
        </a>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('retailer\assets\lib\js\toastr.js') }}"></script>
    <script src="{{ asset('retailer/assets/lib/js/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert', 'info') }}";
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": 1500 // Adjust the timeOut value (in milliseconds) as per your requirement
            };
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;
                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;
                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;
                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $("#pincode").on('keyup', function() {
                var pincode = $(this).val();
                if (pincode.length === 6) {
                    getstatecity(pincode);
                }
            });

            function getstatecity(pincode) {
                $.ajax({
                    url: "https://api.postalpincode.in/pincode/" + pincode,
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    dataType: "json",
                    success: function(result) {
                        if (result && result[0] && result[0].PostOffice && result[0].PostOffice[0]) {
                            var postOffice = result[0].PostOffice[0];
                            $("#district").val(postOffice.District);
                            $("#state").val(postOffice.State);
                        } else {
                            toastr.error("no state and city found");
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 1500,
                            };
                            $("#district").val('');
                            $("#state").val('');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: ", status, error);
                    }
                });
            }
        });
    </script>
    {{-- <script>
			$(function() {
				$("#preferredDealer1").select2({
					theme: 'bootstrap4',
					width: 'style',
					placeholder: $("#preferredDealer1").attr('placeholder'),
					allowClear: Boolean($("#preferredDealer1").data('allow-clear')),
				});
			});
			
			$(function() {
				$("#preferredDealer2").select2({
					theme: 'bootstrap4',
					width: 'style',
					placeholder: $("#preferredDealer2").attr('placeholder'),
					allowClear: Boolean($("#preferredDealer2").data('allow-clear')),
				});
			});
			$(function() {
				$("#preferredDealer3").select2({
					theme: 'bootstrap4',
					width: 'style',
					placeholder: $("#preferredDealer3").attr('placeholder'),
					allowClear: Boolean($("#preferredDealer3").data('allow-clear')),
				});
			});
		</script> --}}
    {{-- <script>
			$("#zone").on('change', function() {
				getdealer();
			});
			
			function getdealer() {
				var zone = $("#zone").val();
				$.ajax({
					url: "getdealer",
					type: "GET",
					headers: {
						"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					},
					data: {
						zone: zone,
						_token: $('meta[name="csrf-token"]').attr("content"),
					},
					dataType: "json",
					success: function(result) {
						$("#preferredDealer1").html('<option value="">Select Preferred Dealer 1</option>');
						$.each(result.dealers, function(key, value) {
							$("#preferredDealer1").append(
                            '<option value="' +
                            value.id +
                            '">' +
                            value.name + ', ' +
                            value.city + "</option>"
							);
						});
						$("#preferredDealer2").html('<option value="">Select Preferred Dealer 2</option>');
						$.each(result.dealers, function(key, value) {
							$("#preferredDealer2").append(
                            '<option value="' +
                            value.id +
                            '">' +
                            value.name + ', ' +
                            value.city + "</option>"
							);
						});
						$("#preferredDealer3").html('<option value="">Select Preferred Dealer 3</option>');
						$.each(result.dealers, function(key, value) {
							$("#preferredDealer3").append(
                            '<option value="' +
                            value.id +
                            '">' +
                            value.name + ', ' +
                            value.city + "</option>"
							);
						});
					},
				});
			}
		</script> --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            font-family: Poppins;
        }

        @font-face {
            font-family: "Brittany Signature";
            src: url("/retailer/assets/fonts/BrittanySignature.ttf");
        }

        .brittany-font {
            font-family: "Brittany Signature";
        }

        @media (min-width:768px) {
            .login-page_card {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

        }

        .login-page-banner {
            max-height: 100vh;
        }

        .login-page_card p {
            color: #8A8A8A;
        }

        .login-page_card .phone-input {
            border-radius: 5px;
            border: 1px solid #E4E4E4;
        }

        .otp-input_wrapper input {
            border-radius: 4.177px;
            border: 0.835px solid #DADADA;
            background: #FFF;
            box-shadow: 0px 0px 14.202px 0px #D7D7D7;
            height: 48px;
            width: 100%;
            outline: none;

        }

        .login-page_card-btn {
            border-radius: 4.264px;
            background: #667B68 !important;
            color: #FFF !important;
            text-align: center;
            font-size: 16px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
            width: 100%;
            height: 52.237px;
        }

        .login-page_card .input-group {
            border-radius: 5px;
            border: 1px solid #E4E4E4;
            width: 100%;
            height: 48px;
            flex-shrink: 0;
        }

        .sign-up-text,
        .resend-text {
            color: #667B68;

        }

        .otp-field {
            flex-direction: row;
            column-gap: 10px;
            display: flex;
            align-items: center;
        }

        .otp-field input {
            height: 45px;
            width: 42px;
            border-radius: 4.177px;
            outline: none;
            font-size: 1.125rem;
            text-align: center;
            border: 0.835px solid #DADADA;

        }

        .otp-field input:focus {
            border-radius: 4.177px;
            border: 0.835px solid #DADADA;
            background: #FFF;
            box-shadow: 0px 0px 14.202px 0px #D7D7D7;
        }

        .otp-field input::-webkit-inner-spin-button,
        .otp-field input::-webkit-outer-spin-button {
            display: none;
        }

        .sign-up-page-form_wrapper input {
            border-radius: 5px;
            border: 1px solid #E4E4E4;
            height: 48px;
        }

        .sign-up-page_btn {
            border-radius: 4.264px;
            background: #667B68 !important;
            height: 48px;
            width: 100%;
            color: #FFF !important;
        }

        .select2-container--bootstrap4 .select2-selection--multiple {
            box-shadow: none !important;
            border-radius: 5px;
            border: 1px solid #E4E4E4 !important;
        }

        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
            border-radius: 4px;
            background: #2D2D2D !important;
            color: #fff !important;
        }

        .select2-container--bootstrap4 .select2-results__option--highlighted,
        .select2-container--bootstrap4 .select2-results__option--highlighted.select2-results__option[aria-selected="true"] {
            background: #667B68 !important;
        }

        .sign-up-page-form_wrapper select {
            border-radius: 5px;
            border: 1px solid #E4E4E4;
            height: 48px;
        }

        .select2-container--bootstrap4 .select2-selection--single {
            border-radius: 5px;
            border: 1px solid #E4E4E4;
            height: 48px !important;
            display: flex;
            align-items: center;
        }

        .select2-container--bootstrap4 .select2-search {
            padding-left: 10px;
        }
    </style>
</body>

</html>
