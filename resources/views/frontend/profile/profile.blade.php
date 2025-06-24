@extends('frontend.layout.frontendmaster')
@section('content')
@section('title')
Shop - Emerald OMS
@endsection
<main class="myaccount-page">
    <section class="container">
        <div class="row pt-4 pb-5">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-3 col-lg-3 col-xxl-2">
                        <div class="nav flex-row  flex-md-column nav-pills me-3" id="v-pills-tab" role="tablist"
						aria-orientation="vertical">
                            {{-- <button class="nav-link active" id="v-pills-dashboard-tab" data-bs-toggle="pill"
							data-bs-target="#v-pills-dashboard" type="button" role="tab"
							aria-controls="v-pills-dashboard" aria-selected="true">Dashboard</button>
                            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
							data-bs-target="#v-pills-profile" type="button" role="tab"
							aria-controls="v-pills-profile" aria-selected="false">My Profile</button>
                            <button class="nav-link" id="v-pills-orders-tab" data-bs-toggle="pill"
							data-bs-target="#v-pills-orders" type="button" role="tab"
							aria-controls="v-pills-orders" aria-selected="false">Total Orders</button>
                            <button class="nav-link" id="v-pills-logout-tab">Logout</button> --}}
                            <a class="nav-link" href="{{ route('dealerdashboard') }}">Dashboard</a>
                            <a class="nav-link" href="{{ route('myprofile') }}">My Profile</a>
                            <a class="nav-link" href="{{ route('orders') }}">Orders</a>
                            <a class="nav-link" href="">Logout</a>
						</div>
					</div>
                    <input type="hidden" name="sample" id="sample" value="1">
                    <div class="col-12 col-md-9 col-lg-9 col-xxl-10 mt-4 mt-md-0">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-dashboard" role="tabpanel"
							aria-labelledby="v-pills-dashboard-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <div class="dashboard-cards">
                                                    {{-- <div class="dashboard-card card">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-center ">
                                                                <h5 class="fw-bold">{{ $ordersCount }}</h5>
															</div>
                                                            <div class="d-flex justify-content-center">
                                                                <div>Total Orders</div>
															</div>
														</div>
													</div> --}}
                                                    {{-- <div class="dashboard-card card">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-center ">
                                                                <h5 class="fw-bold">0</h5>
															</div>
															
                                                            <div class="d-flex justify-content-center">
                                                                <div>Total Cancel Orders</div>
															</div>
															
														</div>
													</div>
                                                    <div class="dashboard-card card">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-center ">
                                                                <h5 class="fw-bold">0</h5>
															</div>
															
                                                            <div class="d-flex justify-content-center">
                                                                <div>Total Return & Exchange Orders</div>
															</div>
															
														</div>
													</div>
                                                    <div class="dashboard-card card">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-center ">
                                                                <h5 class="fw-bold">{{ $totalOrderQty }}</h5>
															</div>
															
                                                            <div class="d-flex justify-content-center">
                                                                <div>Total Orders Quantity</div>
															</div>
														</div>
													</div>
                                                    <div class="dashboard-card card">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-center ">
                                                                <h5 class="fw-bold">{{ $totalOrderWeight }}</h5>
															</div>
															
                                                            <div class="d-flex justify-content-center">
                                                                <div>Total Orders Weights</div>
															</div>
															
														</div>
													</div> --}}
												</div>
											</div>
										</div>
                                        <div class="row custom-card">
                                            <div class="col-12">
                                                <div class="card-style mb-30">
                                                    <div class="title d-flex gap-3 flex-wrap justify-content-between">
                                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                                            <h3 class="text-bold">Order Report</h3>
                                                            <div class="btn total-orders-btn">Total Orders <span
															class="fw-bold">120</span></div>
														</div>
                                                        <div id="chart-buttons-container" class="d-flex gap-2">
                                                            <button class="btn">Daily</button>
                                                            <button class="btn">Weekly</button>
                                                            <button class="btn active">Monthly</button>
                                                            <button class="btn">Yearly</button>
															
														</div>
													</div>
                                                    <!-- End Title -->
                                                    <div class="chart">
                                                        <canvas id="Chart1"
														style="width: 100%; height: 400px; margin-left: -35px;"></canvas>
													</div>
                                                    <!-- End Chart -->
												</div>
											</div>
											
                                            <!-- End Col -->
										</div>
										
										
										
									</div>
								</div>
							</div>
						</div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
						aria-labelledby="v-pills-profile-tab">
                            <form action="{{ route('frontendprofileupdate') }}" enctype="multipart/form-data"
							id="profileForm" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="h2 page-main-title">My Profile</div>
									</div>
                                    <div id="dealer-profile" class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 col-lg-9">
                                                        <div class="d-flex align-items-center flex-column flex-sm-row">
                                                            <div class="mr-3">
                                                                <div
																class="profile-page_img-wrapper d-flex justify-content-center align-items-center">
                                                                    <input name="user_image"
																	id="profile-photo-edit-input" class="d-none"
																	type="file" accept="image/*" disabled>
																	
                                                                    <label for="profile-photo-edit-input">
                                                                        <img id="user-profile-img" width="100"
																		height="100" class="img-fluid rounded-5"
																		src="{{ Auth::user()->user_image == null ? asset('frontend/img/no-image.jpg') : asset(Auth::user()->user_image) }}"
																		alt="user photo">
																	</label>
																</div>
															</div>
                                                            <div class="flex-grow-1 my-4 my-md-0">
                                                                <input class="form-control mb-3" type="text"
																name="shop_name" id="dealer-name" disabled
																value="{{ Auth::user()->shop_name == null ? 'no-shop-name' : Auth::user()->shop_name }}">
																
															</div>
														</div>
													</div>
                                                    <div class="col-12 col-lg-3">
                                                        <div class="d-flex justify-content-end">
                                                            <button type="button" id="dealer-profile-edit"
															class="edit-btn">Edit
                                                                <span class="ml-1">
                                                                    <svg width="12" height="13"
																	viewBox="0 0 12 13" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
                                                                        <path
																		d="M9.0629 9.88692C9.0629 10.518 8.54538 11.0356 7.91426 11.0356H2.10794C1.47682 11.0356 0.959304 10.518 0.959304 9.88692V4.0806C0.959304 3.44948 1.47682 2.93196 2.10794 2.93196H4.96061L5.91992 1.97266H2.10794C0.946682 1.97266 0 2.91934 0 4.0806V9.89954C0 11.0608 0.946682 12.0075 2.10794 12.0075H7.92688C9.08815 12.0075 10.0348 11.0608 10.0348 9.89954V6.08757L9.07552 7.04687V9.88692H9.0629Z"
																		fill="#7E7E7E" />
                                                                        <path
																		d="M3.5849 5.64552C3.4713 5.75912 3.40819 5.89797 3.39557 6.04944L3.19361 8.47294C3.18098 8.64966 3.33245 8.80112 3.50917 8.7885L5.93267 8.58654C6.08414 8.57392 6.23561 8.51081 6.33659 8.39721L10.2243 4.5095L7.48523 1.75781L3.5849 5.64552Z"
																		fill="#7E7E7E" />
                                                                        <path
																		d="M11.8523 2.23732L9.75703 0.142002C9.56769 -0.0473341 9.27738 -0.0473341 9.08804 0.142002L8.14136 1.08868L10.893 3.84037L11.8397 2.89369C12.0417 2.71698 12.0417 2.41404 11.8523 2.23732Z"
																		fill="#7E7E7E" />
																	</svg>
																</span>
															</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
                                    <div id="personal-information" class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-header pt-4">
                                                <div class="h3 fw-bold text-dark">Personal Information</div>
											</div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 col-lg-9">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-4">
                                                                    <label class="form-label h6 text-dark"
																	for="name">Name</label>
                                                                    <input class="form-control" type="text"
																	name="name" id="first-name" disabled
																	value="{{ Auth::user()->name }}">
																</div>
															</div>
															
                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-4">
                                                                    <label class="form-label h6 text-dark"
																	for="email-address">Email address</label>
                                                                    <input class="form-control" type="email"
																	name="email" id="email-address" disabled
																	readonly value="{{ Auth::user()->email }}">
																</div>
															</div>
															
                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-4">
                                                                    <label class="form-label h6 text-dark"
																	for="phone">Phone</label>
                                                                    <input class="form-control" type="text"
																	name="phone" id="phone" disabled
																	readonly value="{{ Auth::user()->mobile }}">
																</div>
															</div>
															
                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-4">
                                                                    <label class="form-label h6 text-dark"
																	for="gst">GST</label>
                                                                    <input class="form-control" type="text"
																	name="gst" id="gst" disabled
																	value="{{ Auth::user()->GST }}">
																</div>
															</div>
															
                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-4">
                                                                    <label class="form-label h6 text-dark"
																	for="pan">PAN</label>
                                                                    <input class="form-control" type="text"
																	name="pan" id="pan" disabled
																	value="{{ Auth::user()->PAN }}">
																</div>
															</div>
															
                                                            {{-- <div class="col-12 col-md-6">
																<div class="mb-4">
																	<label class="form-label h6 text-dark"
																	for="Admin">Bio</label>
																	<input class="form-control" type="text"
																	name="bio" id="Admin" disabled
																	value="{{ Auth::user()->bio != null ? Auth::user()->bio : '' }}">
																</div>
															</div> --}}
														</div>
													</div>
                                                    <div class="col-12 col-lg-3 mt-2">
                                                        <div class="d-flex justify-content-end">
                                                            <button type="button" id="personal-info-edit"
															class="edit-btn">Edit
                                                                <span class="ml-1">
                                                                    <svg width="12" height="13"
																	viewBox="0 0 12 13" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
                                                                        <path
																		d="M9.0629 9.88692C9.0629 10.518 8.54538 11.0356 7.91426 11.0356H2.10794C1.47682 11.0356 0.959304 10.518 0.959304 9.88692V4.0806C0.959304 3.44948 1.47682 2.93196 2.10794 2.93196H4.96061L5.91992 1.97266H2.10794C0.946682 1.97266 0 2.91934 0 4.0806V9.89954C0 11.0608 0.946682 12.0075 2.10794 12.0075H7.92688C9.08815 12.0075 10.0348 11.0608 10.0348 9.89954V6.08757L9.07552 7.04687V9.88692H9.0629Z"
																		fill="#7E7E7E" />
                                                                        <path
																		d="M3.5849 5.64552C3.4713 5.75912 3.40819 5.89797 3.39557 6.04944L3.19361 8.47294C3.18098 8.64966 3.33245 8.80112 3.50917 8.7885L5.93267 8.58654C6.08414 8.57392 6.23561 8.51081 6.33659 8.39721L10.2243 4.5095L7.48523 1.75781L3.5849 5.64552Z"
																		fill="#7E7E7E" />
                                                                        <path
																		d="M11.8523 2.23732L9.75703 0.142002C9.56769 -0.0473341 9.27738 -0.0473341 9.08804 0.142002L8.14136 1.08868L10.893 3.84037L11.8397 2.89369C12.0417 2.71698 12.0417 2.41404 11.8523 2.23732Z"
																		fill="#7E7E7E" />
																	</svg>
																</span>
															</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									
                                    <div id="address-information" class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-header pt-4">
                                                <div class="h3 fw-bold text-dark">Address</div>
											</div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 col-lg-9">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-4">
                                                                    <label class="form-label h6 text-dark"
																	for="country">Address</label>
                                                                    <input class="form-control" type="text"
																	name="address" id="country" disabled
																	value="{{ Auth::user()->address != null ? Auth::user()->address : '' }}">
																</div>
															</div>
														</div>
													</div>
                                                    <div class="col-12 col-lg-3 mt-2">
                                                        <div class="d-flex justify-content-end">
                                                            <button type="button" id="address-info-edit"
															class="edit-btn">Edit
                                                                <span class="ml-1">
                                                                    <svg width="12" height="13"
																	viewBox="0 0 12 13" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
                                                                        <path
																		d="M9.0629 9.88692C9.0629 10.518 8.54538 11.0356 7.91426 11.0356H2.10794C1.47682 11.0356 0.959304 10.518 0.959304 9.88692V4.0806C0.959304 3.44948 1.47682 2.93196 2.10794 2.93196H4.96061L5.91992 1.97266H2.10794C0.946682 1.97266 0 2.91934 0 4.0806V9.89954C0 11.0608 0.946682 12.0075 2.10794 12.0075H7.92688C9.08815 12.0075 10.0348 11.0608 10.0348 9.89954V6.08757L9.07552 7.04687V9.88692H9.0629Z"
																		fill="#7E7E7E" />
                                                                        <path
																		d="M3.5849 5.64552C3.4713 5.75912 3.40819 5.89797 3.39557 6.04944L3.19361 8.47294C3.18098 8.64966 3.33245 8.80112 3.50917 8.7885L5.93267 8.58654C6.08414 8.57392 6.23561 8.51081 6.33659 8.39721L10.2243 4.5095L7.48523 1.75781L3.5849 5.64552Z"
																		fill="#7E7E7E" />
                                                                        <path
																		d="M11.8523 2.23732L9.75703 0.142002C9.56769 -0.0473341 9.27738 -0.0473341 9.08804 0.142002L8.14136 1.08868L10.893 3.84037L11.8397 2.89369C12.0417 2.71698 12.0417 2.41404 11.8523 2.23732Z"
																		fill="#7E7E7E" />
																	</svg>
																</span>
															</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
                                    <div class="col-12 mb-5">
                                        <button class="btn btn-warning px-4">Save</button>
									</div>
								</div>
							</form>
						</div>
						
                        <div class="tab-pane fade" id="v-pills-orders" role="tabpanel"
						aria-labelledby="v-pills-orders-tab">
                            <div class="row">
								
                                <div class="col-12">
                                    <nav class="dasboard-top-menu-links mb-4">
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-tot-orders-tab"
											data-bs-toggle="tab" data-bs-target="#nav-tot-orders" type="button"
											role="tab" aria-controls="nav-tot-orders" aria-selected="true"
											onclick="orders(1)">Total Orders</button>
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
                                                            <div
															class="d-flex flex-wrap justify-content-between w-100">
                                                                <div>
                                                                    <h5>Recent Orders</h5>
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
																	name="datefilter" id="datefilter"
																	value="">
																	
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
		</div>
	</div>
</section>
</main>
@section('scripts')
<script src="{{ asset('frontend/js/order/order.js') }}"></script>
<script src="{{ asset('frontend/lib/js/chart.min.js') }}"></script>
{{-- <script src="{{ asset('frontend/js/order/pendingorder.js') }}"></script> --}}
<script>
	$("#dealer-profile-edit").click(function() {
		$("#dealer-profile input").attr("disabled", false);
	})
	
	$("#personal-info-edit").click(function() {
		$("#personal-information input").attr("disabled", false);
	})
	
	$("#address-info-edit").click(function() {
		$("#address-information input").attr("disabled", false);
	})
	
	// Get references to the input and image elements
	const $inputElement = $('#profile-photo-edit-input');
	const $imageElement = $('#user-profile-img');
	
	// Add an event listener to the input element for the 'change' event
	$inputElement.on('change', function() {
		// Check if a file was selected
		if ($inputElement[0].files.length > 0) {
			// Get the selected file
			const selectedFile = $inputElement[0].files[0];
			
			// Create a FileReader to read the selected file
			const reader = new FileReader();
			
			// Define a function to execute when the FileReader has loaded the file
			reader.onload = function(e) {
				// Set the 'src' attribute of the image element to the data URL of the selected file
				$imageElement.attr('src', e.target.result);
			};
			
			// Read the selected file as a data URL
			reader.readAsDataURL(selectedFile);
		}
	});
</script>

<script>
	// Define initial chart data
	let initialData = {
		labels: [
		"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
		],
		datasets: [{
			label: "Total Weight",
			backgroundColor: "transparent",
			borderColor: "#F78D1E",
			data: [
			226000, 289000, 389000, 189000, 289000, 389000, 726000, 189000, 289000, 389000, 189000,
			289000
			],
			pointBackgroundColor: "transparent",
			pointHoverBackgroundColor: "#F78D1E",
			pointBorderColor: "transparent",
			pointHoverBorderColor: "#fff",
			pointHoverBorderWidth: 5,
			borderWidth: 1,
			pointRadius: 8,
			pointHoverRadius: 8,
			cubicInterpolationMode: "monotone"
		}]
	};
	
	// Get chart canvas and context
	const ctx1 = document.getElementById("Chart1").getContext("2d");
	
	// Initialize chart with initial data
	const chart1 = new Chart(ctx1, {
		type: "line",
		data: initialData,
		options: {
			plugins: {
				tooltip: {
					callbacks: {
						labelColor: function(context) {
							return {
								backgroundColor: "#ffffff",
								color: "#171717"
							};
						},
					},
					intersect: false,
					backgroundColor: "#F78D1E",
					title: {
						fontFamily: "Poppins",
						color: "#8F92A1",
						fontSize: 14,
					},
					body: {
						fontFamily: "Poppins",
						color: "#171717",
						fontStyle: "600",
						fontSize: 16,
					},
					multiKeyBackground: "transparent",
					displayColors: false,
					padding: {
						x: 30,
						y: 10,
					},
					bodyAlign: "center",
					titleAlign: "center",
					titleColor: "#ffffff",
					bodyColor: "#ffffff",
					bodyFont: {
						family: "Inter",
						size: "16",
						weight: "600",
					},
				},
				legend: {
					display: false,
				},
			},
			responsive: true,
			maintainAspectRatio: false,
			title: {
				display: false,
			},
			scales: {
				y: {
					grid: {
						display: false,
						drawTicks: false,
						drawBorder: false,
					},
					ticks: {
						padding: 35,
						max: 1200,
						min: 500,
					},
				},
				x: {
					grid: {
						drawBorder: false,
						color: "rgba(143, 146, 161, .1)",
						zeroLineColor: "rgba(143, 146, 161, .1)",
					},
					ticks: {
						padding: 20,
					},
				},
			},
		},
	});
	
	// Function to update chart data
	function updateChartData(newData, newLabels) {
		chart1.data.datasets[0].data = newData;
		chart1.data.labels = newLabels;
		chart1.update();
	}
	
	// Event listeners for buttons
	document.querySelectorAll('#chart-buttons-container .btn').forEach(btn => {
		btn.addEventListener('click', function() {
			// Remove active class from all buttons
			document.querySelectorAll('.btn').forEach(button => {
				button.classList.remove('active');
			});
			
			// Add active class to the current button
			this.classList.add('active');
			
			const btnType = this.innerText.toLowerCase();
			let newData;
			
			// Sample data for different button types
			switch (btnType) {
				case 'daily':
				newData = [1200, 1300, 1400, 1500, 1600, 1700, 1800, 1400, 2000, 2100, 2200, 1400];
				newLabels = ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7', 'Day 8',
				'Day 9', 'Day 10', 'Day 11', 'Day 12'
				];
				break;
				case 'weekly':
				newData = [8000, 8500, 8000, 9500, 10000, 8000, 11000];
				newLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7'];
				break;
				case 'monthly':
				newData = [226000, 289000, 389000, 189000, 289000, 389000, 726000, 189000, 289000,
				389000, 189000, 289000
				];
				newLabels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct",
				"Nov", "Dec"
				];
				break;
				case 'yearly':
				newData = [200000, 220000, 240000, 260000, 280000, 300000, 320000, 220000, 360000,
				220000, 400000, 220000
				];
				newLabels = ['Year 1', 'Year 2', 'Year 3', 'Year 4', 'Year 5', 'Year 6', 'Year 7',
				'Year 8', 'Year 9', 'Year 10', 'Year 11', 'Year 12'
				];
				break;
				default:
				newData = initialData.datasets[0].data; // Use initial data as default
				newLabels = initialData.labels;
			}
			
			// Update chart data and labels
			updateChartData(newData, newLabels);
			
		});
		
	});
</script>
@endsection
@endsection
