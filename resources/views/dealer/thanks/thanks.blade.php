@extends('dealer.layout.dealermaster')
@section('content')
@section('title')
    Thank You Page - Emerald RMS
@endsection
<section class="container py-5">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="fs-1 fw-bold mb-5">Thank you for your order!</h1>

            <img width="161" height="152" class="img-fluid" src="{{ asset('thankyou.png') }}" alt="">

            <div class="fw-semibold fs-5 mt-4">Your order Id is <span class="text-success">{{ $orderno }}</span> &
                Your order <span class="text-success"> is under
                    process...</span></div>
        </div>

        <div class="col-12 col-lg-10 col-xl-8 mt-4 m-auto">
            <div class="fs-3 fw-semibold text-center">
                Please read the instructions regarding your order:
            </div>

            <div class="mt-4 p-3 p-lg-4"
                style="border: 0.78px solid #F78D1E; background: #F78D1E33; border-radius: 10px;">
                <ul class="fs-6 gap-2 thankyou-page_list">
                    <li>We will be checking your order against the dealer you have selected or with any of our
                        authorised dealers near you.</li>
                    <li>Please expect a call from our dealers regarding order price and fulfilment.</li>
                    <li>The order will be sent to you through our authorised dealers in your area.</li>
                </ul>

                <div class="mt-4 p-3 text-white" style=" background: #F78D1E; border-radius: 10px; ">
                    <div>NOTE: Due to high demand, there are chances that one or more of the items that you have ordered
                        cannot be fulfilled. You will receive a call incase of such a cancellation occurs.</div>
                </div>
            </div>
        </div>

    </div>

</section>
<style>
    body {
        font-family: Inter;
    }

    .thankyou-page_list {
        list-style-image: url("data:image/svg+xml,%3Csvg width='11' height='12' viewBox='0 0 11 12' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M0.680139 11.7539L10.0469 6.36094L0.680138 0.967968C2.11511 4.42136 2.11511 8.28475 0.680139 11.7539Z' fill='%23F78D1E'/%3E%3C/svg%3E%0A");
        padding-left: 15px;
    }

    .thankyou-page_list li {
        margin-bottom: 10px;
    }
</style>
@endsection
