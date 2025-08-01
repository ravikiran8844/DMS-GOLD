<!DOCTYPE html>
<html lang="en">
	<!-- errors-404.html  21 Nov 2019 04:05:02 GMT -->
	<head>
		<meta charset="UTF-8">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
		<title>404 - Error</title>
		<!-- General CSS Files -->
		<link rel="stylesheet" href="{{ asset('backend/assets/css/app.min.css') }}">
		<!-- Template CSS -->
		<link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/assets/css/components.css') }}">
		<!-- Custom style CSS -->
		<link rel="stylesheet" href="{{ asset('backend/assets/css/custom.css') }}">
		<link rel='shortcut icon' type='image/x-icon' href="{{ asset('backend/>assets/img/favicon.ico') }}" />
	</head>
	
	<body>
		<div class="loader"></div>
		<div id="app">
			<section class="section">
				<div class="container mt-5">
					<div class="page-error">
						<div class="page-inner">
							<h1>404</h1>
							<div class="page-description">
								The page you were looking for could not be found.
							</div>
							<div class="page-search">
								<div class="mt-3">
									@php
									
                                    $maintanance = App\Models\Settings::first();
									
									@endphp
									@if ($maintanance->is_maintanance_mode == 1)
                                    <a href="{{ route('maintanance') }}">Back to Home</a>
									@else
                                    <a href="{{ route('dashboard') }}">Back to Home</a>
									@endif
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<!-- General JS Scripts -->
		<script src="{{ asset('backend/assets/js/app.min.js') }}"></script>
		<!-- JS Libraies -->
		<!-- Page Specific JS File -->
		<!-- Template JS File -->
		<script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
		<!-- Custom JS File -->
		<script src="{{ asset('backend/assets/js/custom.js') }}"></script>
	</body>
	<!-- errors-404.html  21 Nov 2019 04:05:02 GMT -->
	
</html>
