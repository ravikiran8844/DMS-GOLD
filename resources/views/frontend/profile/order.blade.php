@extends('frontend.layout.frontendmaster')
@section('content')
@section('title')
    Dashboard - Emerald OMS
@endsection
<main class="myaccount-page">
    <section class="container">
        <div class="row pt-4 pt-lg-5 pb-5">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-3 col-lg-3 col-xxl-2">
                        <div class="nav flex-row flex-md-column nav-pills me-3" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <a class="nav-link" href="{{ route('dealerdashboard') }}">Dashboard</a>
                            <a class="nav-link" href="{{ route('myprofile') }}">My Profile</a>
                            <a class="nav-link active" href="{{ route('orders') }}">Orders</a>
                            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 col-lg-9 col-xxl-10 mt-4 mt-md-0">
                        <div class="row">
                            <div class="col-12">
                                <nav class="dasboard-top-menu-links mb-4">
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-tot-orders-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-tot-orders" type="button" role="tab"
                                            aria-controls="nav-tot-orders" aria-selected="true"
                                            onclick="orders(1)">Total
                                            Orders</button>
                                        {{-- <button class="nav-link" id="nav-pending-orders-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-pending-orders"
                                            type="button" role="tab" aria-controls="nav-pending-orders"
                                            aria-selected="true" onclick="orders(2)">Pending Orders</button>
                                            <button class="nav-link" id="nav-exchange-orders-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-exchange-orders"
                                            type="button" role="tab" aria-controls="nav-exchange-orders"
                                            aria-selected="false" onclick="orders(3)">Exchange Orders</button>
                                            <button class="nav-link" id="nav-cancel-orders-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-cancel-orders"
                                            type="button" role="tab" aria-controls="nav-cancel-orders"
                                            aria-selected="false" onclick="orders(4)">Cancel
                                            Orders</button> --}}
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-tot-orders" role="tabpanel"
                                        aria-labelledby="nav-tot-orders-tab" tabindex="0">

                                        {{-- <div class="row mb-4">
                                            <div class="col-12">
                                            <div class="dashboard-cards">
                                            <div class="dashboard-card card">
                                            <div class="card-body">
                                            <div class="d-flex justify-content-between ">
                                            <h6 class="fw-bold">120</h6>
                                            <div class="small fw-medium  text-success">+5.9%
                                            </div>
                                            </div>
                                            <div>
                                            <div>Total Orders</div>
                                            </div>
                                            </div>
                                            </div>
                                            <div class="dashboard-card card">
                                            <div class="card-body">
                                            <div class="d-flex justify-content-between ">
                                            <h6 class="fw-bold">688,000</h6>
                                            <div class="small text-success fw-medium">+5.9%
                                            </div>
                                            </div>
                                            <div>
                                            <div>Total Order Volume</div>
                                            </div>
                                            </div>
                                            </div>
                                            <div class="dashboard-card card">
                                            <div class="card-body">
                                            <div class="d-flex justify-content-between ">
                                            <h6 class="fw-bold">400,000</h6>
                                            <div class="small text-success fw-medium">+5.9%
                                            </div>
                                            </div>
                                            <div>
                                            <div>Available Balance</div>
                                            </div>
                                            </div>
                                            </div>
                                            <div class="dashboard-card card">
                                            <div class="card-body">
                                            <div class="d-flex justify-content-between ">
                                            <h6 class="fw-bold">288,000</h6>
                                            <div class="small text-success fw-medium">+5.9%
                                            </div>
                                            </div>
                                            <div>
                                            <div>Pending Advance</div>
                                            </div>
                                            </div>
                                            </div>
                                            <div class="dashboard-card card">
                                            <div class="card-body">
                                            <div class="d-flex justify-content-between ">
                                            <h6 class="fw-bold">2</h6>
                                            <div class="small text-success fw-medium">+5.9%
                                            </div>
                                            </div>
                                            <div>
                                            <div>WIP Orders</div>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                            </div> --}}

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card h-100">
                                                    <div class="card-header pt-3">
                                                        <div class="d-flex flex-wrap justify-content-between w-100">
                                                            <div>
                                                                <h5>Recent Orders</h5>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-center custom-date-input_wrapper">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                                    height="14" viewBox="0 0 15 14" fill="none">
                                                                    <path
                                                                        d="M11.9998 1.76229H10.1209V1.17855C10.1209 0.903458 9.89783 0.68042 9.62274 0.68042C9.34765 0.68042 9.12462 0.903458 9.12462 1.17855V1.76229H5.34294V1.17855C5.34294 0.903458 5.1199 0.68042 4.84481 0.68042C4.56973 0.68042 4.34669 0.903458 4.34669 1.17855V1.76229H2.46777C1.10692 1.76229 0 2.86933 0 4.23018V11.2063C0 12.5491 1.09233 13.6414 2.43493 13.6414H12.0326C13.3752 13.6414 14.4676 12.5491 14.4676 11.2063V4.23018C14.4676 2.86933 13.3606 1.76229 11.9998 1.76229ZM2.46777 2.75854H4.34669V3.04761C4.34669 3.3227 4.56973 3.54574 4.84481 3.54574C5.1199 3.54574 5.34294 3.3227 5.34294 3.04761V2.75854H9.12462V3.04761C9.12462 3.3227 9.34765 3.54574 9.62274 3.54574C9.89783 3.54574 10.1209 3.3227 10.1209 3.04761V2.75854H11.9998C12.8112 2.75854 13.4713 3.41866 13.4713 4.23018V4.70264H0.996253V4.23018C0.996253 3.41866 1.65637 2.75854 2.46777 2.75854ZM12.0326 12.6452H2.43493C1.64153 12.6452 0.996253 11.9997 0.996253 11.2063V5.6989H13.4713V11.2063C13.4713 11.9997 12.826 12.6452 12.0326 12.6452Z"
                                                                        fill="#F96421" />
                                                                    <path
                                                                        d="M3.90841 7.17285H3.16414C2.88905 7.17285 2.66602 7.39589 2.66602 7.67098C2.66602 7.94607 2.88905 8.1691 3.16414 8.1691H3.90841C4.1835 8.1691 4.40654 7.94607 4.40654 7.67098C4.40654 7.39589 4.1835 7.17285 3.90841 7.17285Z"
                                                                        fill="#F96421" />
                                                                    <path
                                                                        d="M7.60568 7.17285H6.86141C6.58632 7.17285 6.36328 7.39589 6.36328 7.67098C6.36328 7.94607 6.58632 8.1691 6.86141 8.1691H7.60568C7.88077 8.1691 8.1038 7.94607 8.1038 7.67098C8.1038 7.39589 7.88077 7.17285 7.60568 7.17285Z"
                                                                        fill="#F96421" />
                                                                    <path
                                                                        d="M11.3049 7.17285H10.5606C10.2855 7.17285 10.0625 7.39589 10.0625 7.67098C10.0625 7.94607 10.2855 8.1691 10.5606 8.1691H11.3049C11.58 8.1691 11.803 7.94607 11.803 7.67098C11.803 7.39589 11.58 7.17285 11.3049 7.17285Z"
                                                                        fill="#F96421" />
                                                                    <path
                                                                        d="M3.90841 9.72797H3.16414C2.88905 9.72797 2.66602 9.951 2.66602 10.2261C2.66602 10.5012 2.88905 10.7242 3.16414 10.7242H3.90841C4.1835 10.7242 4.40654 10.5012 4.40654 10.2261C4.40654 9.951 4.1835 9.72797 3.90841 9.72797Z"
                                                                        fill="#F96421" />
                                                                    <path
                                                                        d="M7.60568 9.72797H6.86141C6.58632 9.72797 6.36328 9.951 6.36328 10.2261C6.36328 10.5012 6.58632 10.7242 6.86141 10.7242H7.60568C7.88077 10.7242 8.1038 10.5012 8.1038 10.2261C8.1038 9.951 7.88077 9.72797 7.60568 9.72797Z"
                                                                        fill="#F96421" />
                                                                    <path
                                                                        d="M11.3049 9.72797H10.5606C10.2855 9.72797 10.0625 9.951 10.0625 10.2261C10.0625 10.5012 10.2855 10.7242 10.5606 10.7242H11.3049C11.58 10.7242 11.803 10.5012 11.803 10.2261C11.803 9.951 11.58 9.72797 11.3049 9.72797Z"
                                                                        fill="#F96421" />
                                                                </svg>
                                                                <input
                                                                    class="form-control custom-date-input flex-grow-1 "
                                                                    type="text" placeholder="Date Range"
                                                                    name="datefilter" id="datefilter" value="">

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table id="tableOrders" class="pt-3 mb-3"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">S No</th>
                                                                        <th class="text-center">Order Number
                                                                        </th>
                                                                        <th class="text-center">Order date</th>
                                                                        <th class="text-center">Qty</th>
                                                                        <th class="text-center">Total Weight
                                                                        </th>
                                                                        <th class="text-center">Status</th>
                                                                        <th class="text-center">Action</th>
                                                                        <th class="text-center">Repeat</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="tab-pane fade" id="nav-pending-orders" role="tabpanel"
                                aria-labelledby="nav-pending-orders-tab" tabindex="0">
                                <div class="row">
                                <div class="col-12">
                                <div class="card h-100">
                                <div class="card-header pt-3">
                                <div
                                class="d-flex flex-wrap justify-content-between w-100">
                                <div>
                                <h5>Pending Orders</h5>
                                </div>
                                <div
                                class="d-flex align-items-center custom-date-input_wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                width="15" height="14"
                                viewBox="0 0 15 14" fill="none">
                                <path
                                d="M11.9998 1.76229H10.1209V1.17855C10.1209 0.903458 9.89783 0.68042 9.62274 0.68042C9.34765 0.68042 9.12462 0.903458 9.12462 1.17855V1.76229H5.34294V1.17855C5.34294 0.903458 5.1199 0.68042 4.84481 0.68042C4.56973 0.68042 4.34669 0.903458 4.34669 1.17855V1.76229H2.46777C1.10692 1.76229 0 2.86933 0 4.23018V11.2063C0 12.5491 1.09233 13.6414 2.43493 13.6414H12.0326C13.3752 13.6414 14.4676 12.5491 14.4676 11.2063V4.23018C14.4676 2.86933 13.3606 1.76229 11.9998 1.76229ZM2.46777 2.75854H4.34669V3.04761C4.34669 3.3227 4.56973 3.54574 4.84481 3.54574C5.1199 3.54574 5.34294 3.3227 5.34294 3.04761V2.75854H9.12462V3.04761C9.12462 3.3227 9.34765 3.54574 9.62274 3.54574C9.89783 3.54574 10.1209 3.3227 10.1209 3.04761V2.75854H11.9998C12.8112 2.75854 13.4713 3.41866 13.4713 4.23018V4.70264H0.996253V4.23018C0.996253 3.41866 1.65637 2.75854 2.46777 2.75854ZM12.0326 12.6452H2.43493C1.64153 12.6452 0.996253 11.9997 0.996253 11.2063V5.6989H13.4713V11.2063C13.4713 11.9997 12.826 12.6452 12.0326 12.6452Z"
                                fill="#F96421" />
                                <path
                                d="M3.90841 7.17285H3.16414C2.88905 7.17285 2.66602 7.39589 2.66602 7.67098C2.66602 7.94607 2.88905 8.1691 3.16414 8.1691H3.90841C4.1835 8.1691 4.40654 7.94607 4.40654 7.67098C4.40654 7.39589 4.1835 7.17285 3.90841 7.17285Z"
                                fill="#F96421" />
                                <path
                                d="M7.60568 7.17285H6.86141C6.58632 7.17285 6.36328 7.39589 6.36328 7.67098C6.36328 7.94607 6.58632 8.1691 6.86141 8.1691H7.60568C7.88077 8.1691 8.1038 7.94607 8.1038 7.67098C8.1038 7.39589 7.88077 7.17285 7.60568 7.17285Z"
                                fill="#F96421" />
                                <path
                                d="M11.3049 7.17285H10.5606C10.2855 7.17285 10.0625 7.39589 10.0625 7.67098C10.0625 7.94607 10.2855 8.1691 10.5606 8.1691H11.3049C11.58 8.1691 11.803 7.94607 11.803 7.67098C11.803 7.39589 11.58 7.17285 11.3049 7.17285Z"
                                fill="#F96421" />
                                <path
                                d="M3.90841 9.72797H3.16414C2.88905 9.72797 2.66602 9.951 2.66602 10.2261C2.66602 10.5012 2.88905 10.7242 3.16414 10.7242H3.90841C4.1835 10.7242 4.40654 10.5012 4.40654 10.2261C4.40654 9.951 4.1835 9.72797 3.90841 9.72797Z"
                                fill="#F96421" />
                                <path
                                d="M7.60568 9.72797H6.86141C6.58632 9.72797 6.36328 9.951 6.36328 10.2261C6.36328 10.5012 6.58632 10.7242 6.86141 10.7242H7.60568C7.88077 10.7242 8.1038 10.5012 8.1038 10.2261C8.1038 9.951 7.88077 9.72797 7.60568 9.72797Z"
                                fill="#F96421" />
                                <path
                                d="M11.3049 9.72797H10.5606C10.2855 9.72797 10.0625 9.951 10.0625 10.2261C10.0625 10.5012 10.2855 10.7242 10.5606 10.7242H11.3049C11.58 10.7242 11.803 10.5012 11.803 10.2261C11.803 9.951 11.58 9.72797 11.3049 9.72797Z"
                                fill="#F96421" />
                                </svg>
                                <input
                                class="form-control custom-date-input flex-grow-1 "
                                type="text" placeholder="Date Range"
                                name="pendingdatefilter"
                                id="pendingdatefilter" value="">
                                </div>
                                </div>
                                </div>
                                <div class="card-body">
                                <div class="table-responsive">
                                <table id="tablePendingOrders" class="pt-3 mb-3"
                                style="width:100%">
                                <thead>
                                <tr>
                                <th class="text-center">S No</th>
                                <th class="text-center">Order Number
                                </th>
                                <th class="text-center">Order date</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Total Weight
                                </th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                </table>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                <div class="tab-pane fade" id="nav-exchange-orders" role="tabpanel"
                                aria-labelledby="nav-exchange-orders-tab" tabindex="0">
                                <div class="row">
                                <div class="col-12">
                                <div class="card h-100">
                                <div class="card-header pt-3">
                                <div
                                class="d-flex flex-wrap justify-content-between w-100">
                                <div>
                                <h5>Exchange Orders</h5>
                                </div>
                                <div
                                class="d-flex align-items-center custom-date-input_wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                width="15" height="14"
                                viewBox="0 0 15 14" fill="none">
                                <path
                                d="M11.9998 1.76229H10.1209V1.17855C10.1209 0.903458 9.89783 0.68042 9.62274 0.68042C9.34765 0.68042 9.12462 0.903458 9.12462 1.17855V1.76229H5.34294V1.17855C5.34294 0.903458 5.1199 0.68042 4.84481 0.68042C4.56973 0.68042 4.34669 0.903458 4.34669 1.17855V1.76229H2.46777C1.10692 1.76229 0 2.86933 0 4.23018V11.2063C0 12.5491 1.09233 13.6414 2.43493 13.6414H12.0326C13.3752 13.6414 14.4676 12.5491 14.4676 11.2063V4.23018C14.4676 2.86933 13.3606 1.76229 11.9998 1.76229ZM2.46777 2.75854H4.34669V3.04761C4.34669 3.3227 4.56973 3.54574 4.84481 3.54574C5.1199 3.54574 5.34294 3.3227 5.34294 3.04761V2.75854H9.12462V3.04761C9.12462 3.3227 9.34765 3.54574 9.62274 3.54574C9.89783 3.54574 10.1209 3.3227 10.1209 3.04761V2.75854H11.9998C12.8112 2.75854 13.4713 3.41866 13.4713 4.23018V4.70264H0.996253V4.23018C0.996253 3.41866 1.65637 2.75854 2.46777 2.75854ZM12.0326 12.6452H2.43493C1.64153 12.6452 0.996253 11.9997 0.996253 11.2063V5.6989H13.4713V11.2063C13.4713 11.9997 12.826 12.6452 12.0326 12.6452Z"
                                fill="#F96421" />
                                <path
                                d="M3.90841 7.17285H3.16414C2.88905 7.17285 2.66602 7.39589 2.66602 7.67098C2.66602 7.94607 2.88905 8.1691 3.16414 8.1691H3.90841C4.1835 8.1691 4.40654 7.94607 4.40654 7.67098C4.40654 7.39589 4.1835 7.17285 3.90841 7.17285Z"
                                fill="#F96421" />
                                <path
                                d="M7.60568 7.17285H6.86141C6.58632 7.17285 6.36328 7.39589 6.36328 7.67098C6.36328 7.94607 6.58632 8.1691 6.86141 8.1691H7.60568C7.88077 8.1691 8.1038 7.94607 8.1038 7.67098C8.1038 7.39589 7.88077 7.17285 7.60568 7.17285Z"
                                fill="#F96421" />
                                <path
                                d="M11.3049 7.17285H10.5606C10.2855 7.17285 10.0625 7.39589 10.0625 7.67098C10.0625 7.94607 10.2855 8.1691 10.5606 8.1691H11.3049C11.58 8.1691 11.803 7.94607 11.803 7.67098C11.803 7.39589 11.58 7.17285 11.3049 7.17285Z"
                                fill="#F96421" />
                                <path
                                d="M3.90841 9.72797H3.16414C2.88905 9.72797 2.66602 9.951 2.66602 10.2261C2.66602 10.5012 2.88905 10.7242 3.16414 10.7242H3.90841C4.1835 10.7242 4.40654 10.5012 4.40654 10.2261C4.40654 9.951 4.1835 9.72797 3.90841 9.72797Z"
                                fill="#F96421" />
                                <path
                                d="M7.60568 9.72797H6.86141C6.58632 9.72797 6.36328 9.951 6.36328 10.2261C6.36328 10.5012 6.58632 10.7242 6.86141 10.7242H7.60568C7.88077 10.7242 8.1038 10.5012 8.1038 10.2261C8.1038 9.951 7.88077 9.72797 7.60568 9.72797Z"
                                fill="#F96421" />
                                <path
                                d="M11.3049 9.72797H10.5606C10.2855 9.72797 10.0625 9.951 10.0625 10.2261C10.0625 10.5012 10.2855 10.7242 10.5606 10.7242H11.3049C11.58 10.7242 11.803 10.5012 11.803 10.2261C11.803 9.951 11.58 9.72797 11.3049 9.72797Z"
                                fill="#F96421" />
                                </svg>
                                <input
                                class="form-control custom-date-input flex-grow-1 "
                                type="text" placeholder="Date Range"
                                name="exchangedatefilter"
                                id="exchangedatefilter" value="">
                                </div>
                                </div>
                                </div>
                                <div class="card-body">
                                <div class="table-responsive">
                                <table id="tableExchangeOrders" class="pt-3 mb-3"
                                style="width:100%">
                                <thead>
                                <tr>
                                <th class="text-center">S No</th>
                                <th class="text-center">Order Number
                                </th>
                                <th class="text-center">Order date</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Total Weight
                                </th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                </table>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                <div class="tab-pane fade" id="nav-cancel-orders" role="tabpanel"
                                aria-labelledby="nav-cancel-orders-tab" tabindex="0">
                                <div class="row">
                                <div class="col-12">
                                <div class="card h-100">
                                <div class="card-header pt-3">
                                <div
                                class="d-flex flex-wrap justify-content-between w-100">
                                <div>
                                <h5>Cancel Orders</h5>
                                </div>
                                <div
                                class="d-flex align-items-center custom-date-input_wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                width="15" height="14"
                                viewBox="0 0 15 14" fill="none">
                                <path
                                d="M11.9998 1.76229H10.1209V1.17855C10.1209 0.903458 9.89783 0.68042 9.62274 0.68042C9.34765 0.68042 9.12462 0.903458 9.12462 1.17855V1.76229H5.34294V1.17855C5.34294 0.903458 5.1199 0.68042 4.84481 0.68042C4.56973 0.68042 4.34669 0.903458 4.34669 1.17855V1.76229H2.46777C1.10692 1.76229 0 2.86933 0 4.23018V11.2063C0 12.5491 1.09233 13.6414 2.43493 13.6414H12.0326C13.3752 13.6414 14.4676 12.5491 14.4676 11.2063V4.23018C14.4676 2.86933 13.3606 1.76229 11.9998 1.76229ZM2.46777 2.75854H4.34669V3.04761C4.34669 3.3227 4.56973 3.54574 4.84481 3.54574C5.1199 3.54574 5.34294 3.3227 5.34294 3.04761V2.75854H9.12462V3.04761C9.12462 3.3227 9.34765 3.54574 9.62274 3.54574C9.89783 3.54574 10.1209 3.3227 10.1209 3.04761V2.75854H11.9998C12.8112 2.75854 13.4713 3.41866 13.4713 4.23018V4.70264H0.996253V4.23018C0.996253 3.41866 1.65637 2.75854 2.46777 2.75854ZM12.0326 12.6452H2.43493C1.64153 12.6452 0.996253 11.9997 0.996253 11.2063V5.6989H13.4713V11.2063C13.4713 11.9997 12.826 12.6452 12.0326 12.6452Z"
                                fill="#F96421" />
                                <path
                                d="M3.90841 7.17285H3.16414C2.88905 7.17285 2.66602 7.39589 2.66602 7.67098C2.66602 7.94607 2.88905 8.1691 3.16414 8.1691H3.90841C4.1835 8.1691 4.40654 7.94607 4.40654 7.67098C4.40654 7.39589 4.1835 7.17285 3.90841 7.17285Z"
                                fill="#F96421" />
                                <path
                                d="M7.60568 7.17285H6.86141C6.58632 7.17285 6.36328 7.39589 6.36328 7.67098C6.36328 7.94607 6.58632 8.1691 6.86141 8.1691H7.60568C7.88077 8.1691 8.1038 7.94607 8.1038 7.67098C8.1038 7.39589 7.88077 7.17285 7.60568 7.17285Z"
                                fill="#F96421" />
                                <path
                                d="M11.3049 7.17285H10.5606C10.2855 7.17285 10.0625 7.39589 10.0625 7.67098C10.0625 7.94607 10.2855 8.1691 10.5606 8.1691H11.3049C11.58 8.1691 11.803 7.94607 11.803 7.67098C11.803 7.39589 11.58 7.17285 11.3049 7.17285Z"
                                fill="#F96421" />
                                <path
                                d="M3.90841 9.72797H3.16414C2.88905 9.72797 2.66602 9.951 2.66602 10.2261C2.66602 10.5012 2.88905 10.7242 3.16414 10.7242H3.90841C4.1835 10.7242 4.40654 10.5012 4.40654 10.2261C4.40654 9.951 4.1835 9.72797 3.90841 9.72797Z"
                                fill="#F96421" />
                                <path
                                d="M7.60568 9.72797H6.86141C6.58632 9.72797 6.36328 9.951 6.36328 10.2261C6.36328 10.5012 6.58632 10.7242 6.86141 10.7242H7.60568C7.88077 10.7242 8.1038 10.5012 8.1038 10.2261C8.1038 9.951 7.88077 9.72797 7.60568 9.72797Z"
                                fill="#F96421" />
                                <path
                                d="M11.3049 9.72797H10.5606C10.2855 9.72797 10.0625 9.951 10.0625 10.2261C10.0625 10.5012 10.2855 10.7242 10.5606 10.7242H11.3049C11.58 10.7242 11.803 10.5012 11.803 10.2261C11.803 9.951 11.58 9.72797 11.3049 9.72797Z"
                                fill="#F96421" />
                                </svg>
                                <input
                                class="form-control custom-date-input flex-grow-1 "
                                type="text" placeholder="Date Range"
                                name="canceldatefilter"
                                id="canceldatefilter" value="">
                                </div>
                                </div>
                                </div>
                                <div class="card-body">
                                <div class="table-responsive">
                                <table id="tableCancelOrders" class="pt-3 mb-3"
                                style="width:100%">
                                <thead>
                                <tr>
                                <th class="text-center">S No</th>
                                <th class="text-center">Order Number
                                </th>
                                <th class="text-center">Order date</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Total Weight
                                </th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                </table>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
@section('scripts')
<script src="{{ asset('frontend/js/order/order.js') }}"></script>
@endsection
