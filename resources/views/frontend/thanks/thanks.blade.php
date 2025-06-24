<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Thank You - Emerald OMS</title>
    <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />
    <link rel="stylesheet" href="{{ asset('frontend/lib/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">

</head>

<body class="thankyou-page_wrapper">

    <div class="confeti-wrapper">
        <canvas id="confeti" width="300" height="300" class="active"></canvas>
    </div>


    <section class="p-5 thankyou-page">
        <div class="mb-5 text-center text-md-start">
            <a
                href="@if (auth()->user()->role_id == 4) {{ route('retailerlanding') }}@else{{ route('landing') }} @endif">
                <img width="130" height="100" src="{{ asset('frontend/img/emerald-logo.png') }}" alt="">
            </a>
        </div>

        <div class="text-center">
            <div class="mb-3">
                <img class="img-fluid" width="250" height="240" src="{{ asset('frontend/img/thankyou.png') }}"
                    alt="Thanks for Shoping">
            </div>
            <div class="thankyou-page_title mt-4 mb-3">Thank you</div>
            <div class="thankyou-page_text">Your order successfully been
                placed.</div>
            <div class="mt-3">
                <button id="shopButton" class="btn btn-warning px-4" onclick="handleButtonClick()">Back to Shop</button>
            </div>

        </div>
    </section>

    <script src="{{ asset('frontend/lib/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/smartmenu.js') }}"></script>
    <script src="{{ asset('frontend/js/custom.js') }}"></script>
    <script src="{{ asset('frontend/lib/js/confetti.js') }}"></script>
    <script>
        function handleButtonClick() {
            // Get the button element
            var button = document.getElementById('shopButton');

            // Disable the button
            button.disabled = true;

            // Add a loading state (you can add a loading spinner or text)
            button.innerHTML = 'Loading...';

            // After 3 seconds, enable the button, revert the text, and redirect
            setTimeout(function() {
                button.disabled = false;
                button.innerHTML = 'Back to Shop';

                // Check the user's role and redirect accordingly
                @if (auth()->user()->role_id == 4)
                    window.location.href = "{{ route('retailerlanding') }}";
                @else
                    window.location.href = "{{ route('shop') }}";
                @endif
            }, 3000); // 3000 milliseconds = 3 seconds
        }
    </script>
</body>

</html>
