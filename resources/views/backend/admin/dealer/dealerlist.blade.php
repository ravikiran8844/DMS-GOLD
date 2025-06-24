@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Dealers - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="h2 page-main-heading">Dealers</div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card pt-3">
                <div class="card-body py-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="h6">Total Orders</div>
                            <h4><span class="text-dark">120</span>/<span><small>200</small></span></h4>
                        </div>
                        <div class="card-icon_wrapper mr-0">
                            <svg width="41" height="41" viewBox="0 0 41 41" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="40.5133" height="40.5133" rx="11.5752" fill="#EBE0FF"></rect>
                                <path
                                    d="M20.2565 19.4669C22.0577 19.4669 23.5178 18.0068 23.5178 16.2056C23.5178 14.4045 22.0577 12.9443 20.2565 12.9443C18.4554 12.9443 16.9952 14.4045 16.9952 16.2056C16.9952 18.0068 18.4554 19.4669 20.2565 19.4669Z"
                                    fill="#8C6FC0"></path>
                                <path
                                    d="M28.0833 16.8575C29.8844 16.8575 31.3446 15.3974 31.3446 13.5962C31.3446 11.7951 29.8844 10.335 28.0833 10.335C26.2821 10.335 24.822 11.7951 24.822 13.5962C24.822 15.3974 26.2821 16.8575 28.0833 16.8575Z"
                                    fill="#8C6FC0"></path>
                                <path
                                    d="M12.4292 16.8575C14.2304 16.8575 15.6905 15.3974 15.6905 13.5962C15.6905 11.7951 14.2304 10.335 12.4292 10.335C10.6281 10.335 9.16797 11.7951 9.16797 13.5962C9.16797 15.3974 10.6281 16.8575 12.4292 16.8575Z"
                                    fill="#8C6FC0"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M26.1267 25.3373V29.2508C26.1267 29.4236 26.0582 29.59 25.9356 29.7119C25.8136 29.8346 25.6473 29.9031 25.4744 29.9031H15.0384C14.8655 29.9031 14.6992 29.8346 14.5772 29.7119C14.4546 29.59 14.3861 29.4236 14.3861 29.2508V25.3373C14.3861 22.8157 16.4303 20.7715 18.9519 20.7715H21.5609C24.0825 20.7715 26.1267 22.8157 26.1267 25.3373Z"
                                    fill="#8C6FC0"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M27.4314 27.2937H33.3017C33.4746 27.2937 33.6409 27.2252 33.7629 27.1026C33.8855 26.9806 33.954 26.8143 33.954 26.6414V22.7279C33.954 20.2063 31.9098 18.1621 29.3882 18.1621H26.7792C25.4016 18.1621 24.1662 18.7726 23.3287 19.7373C25.7069 20.4874 27.4314 22.7109 27.4314 25.3369V27.2937Z"
                                    fill="#8C6FC0"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M17.1843 19.7373C16.3468 18.7726 15.1114 18.1621 13.7339 18.1621H11.1249C8.60325 18.1621 6.55908 20.2063 6.55908 22.7279V26.6414C6.55908 26.8143 6.62757 26.9806 6.75019 27.1026C6.87216 27.2252 7.03849 27.2937 7.21134 27.2937H13.0816V25.3369C13.0816 22.7109 14.8062 20.4874 17.1843 19.7373Z"
                                    fill="#8C6FC0"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="card-footer pb-3">
                    <div class="d-flex justify-content-between">
                        <div class="total-dealers-card_bottom-text p-1">
                            +5.9%
                        </div>
                        <div class="dropdown custom-dropdown border-0 text-center">
                            <div class="btn btn-sm sharp tp-btn" data-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <circle fill="#000000" cx="12" cy="5" r="2"></circle>
                                        <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                        <circle fill="#000000" cx="12" cy="19" r="2"></circle>
                                    </g>
                                </svg>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-111px, 31px, 0px);">
                                <a class="dropdown-item" href="#">Option 1</a>
                                <a class="dropdown-item" href="#">Option 2</a>
                                <a class="dropdown-item" href="#">Option 3</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card pt-3">
                <div class="card-body py-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="h6">Active Dealers</div>
                            <h4 class="text-dark">{{$activeDealersCount}}</h4>
                        </div>
                        <div class="card-icon_wrapper mr-0">
                            <svg width="42" height="41" viewBox="0 0 42 41" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="0.708008" y="0.0439453" width="40.5133" height="40.5133" rx="11.5752"
                                    fill="#FEF0E9" />
                                <path
                                    d="M17.1888 19.5108C18.9899 19.5108 20.45 18.0507 20.45 16.2496C20.45 14.4484 18.9899 12.9883 17.1888 12.9883C15.3876 12.9883 13.9275 14.4484 13.9275 16.2496C13.9275 18.0507 15.3876 19.5108 17.1888 19.5108Z"
                                    fill="#F96421" />
                                <path
                                    d="M25.0158 16.9015C26.8169 16.9015 28.2771 15.4413 28.2771 13.6402C28.2771 11.839 26.8169 10.3789 25.0158 10.3789C23.2146 10.3789 21.7545 11.839 21.7545 13.6402C21.7545 15.4413 23.2146 16.9015 25.0158 16.9015Z"
                                    fill="#F96421" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M23.0589 25.3812V29.2947C23.0589 29.4676 22.9905 29.6339 22.8678 29.7559C22.7459 29.8785 22.5795 29.947 22.4067 29.947H11.9706C11.7978 29.947 11.6314 29.8785 11.5095 29.7559C11.3868 29.6339 11.3184 29.4676 11.3184 29.2947V25.3812C11.3184 22.8596 13.3625 20.8154 15.8841 20.8154H18.4932C21.0148 20.8154 23.0589 22.8596 23.0589 25.3812Z"
                                    fill="#F96421" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M24.3637 27.3376H30.234C30.4068 27.3376 30.5731 27.2691 30.6951 27.1465C30.8177 27.0245 30.8862 26.8582 30.8862 26.6854V22.7718C30.8862 20.2502 28.8421 18.2061 26.3204 18.2061H23.7114C22.3339 18.2061 21.0985 18.8166 20.261 19.7813C22.6391 20.5313 24.3637 22.7549 24.3637 25.3809V27.3376Z"
                                    fill="#F96421" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="card-footer pb-3">
                    <div class="d-flex justify-content-between">
                        <div class="active-dealers-card_bottom-text p-1">
                            +5.9%
                        </div>
                        <div class="dropdown custom-dropdown border-0 text-center">
                            <div class="btn btn-sm sharp tp-btn" data-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <circle fill="#000000" cx="12" cy="5" r="2">
                                        </circle>
                                        <circle fill="#000000" cx="12" cy="12" r="2">
                                        </circle>
                                        <circle fill="#000000" cx="12" cy="19" r="2">
                                        </circle>
                                    </g>
                                </svg>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-111px, 31px, 0px);">
                                <a class="dropdown-item" href="#">Option 1</a>
                                <a class="dropdown-item" href="#">Option 2</a>
                                <a class="dropdown-item" href="#">Option 3</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card pt-3">
                <div class="card-body py-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="h6">Dormant Dealers</div>
                            <h4 class="text-dark">12</h4>
                        </div>
                        <div>
                            <select class="custom-btn-border" name="" id="">
                                <option selected value="0-15">0-7 Days</option>
                                <option value="0-15">0-15 Days</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer pb-3">
                    <div class="d-flex justify-content-between">
                        <div class="dormant-dealers-card_bottom-text p-1">
                            +5.9%
                        </div>
                        <div class="dropdown custom-dropdown border-0 text-center">
                            <div class="btn btn-sm sharp tp-btn" data-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <circle fill="#000000" cx="12" cy="5" r="2">
                                        </circle>
                                        <circle fill="#000000" cx="12" cy="12" r="2">
                                        </circle>
                                        <circle fill="#000000" cx="12" cy="19" r="2">
                                        </circle>
                                    </g>
                                </svg>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-111px, 31px, 0px);">
                                <a class="dropdown-item" href="#">Option 1</a>
                                <a class="dropdown-item" href="#">Option 2</a>
                                <a class="dropdown-item" href="#">Option 3</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-12">
            {{-- <div class="card mb-4 p-3">
                <div class="d-flex flex-wrap  justify-content-between align-items-center">
                    <div class="d-flex flex-wrap  align-items-center">
                        <div>
                            <button class="custom-btn-border text-dark bg-transparent">Export <i
                                    class="fas fa-file-export"></i></button>
                        </div>
                        <div>
                            <button class="custom-btn-border text-dark bg-transparent">Print <i
                                    class="fas fa-print"></i></button>
                        </div>
                        <div class="button-group custom-btn-border bg-transparent">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle  bg-transparent"
                                data-toggle="dropdown"><span><svg width="9" height="15" viewBox="0 0 9 15"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M3.75 10.4167C3.75 9.4088 3.10587 8.56808 2.25007 8.37502L2.25 0.416666C2.25 0.186548 2.08211 -3.02391e-07 1.875 -3.11444e-07C1.66789 -3.20497e-07 1.5 0.186548 1.5 0.416666L1.49955 8.37511C0.643935 8.56833 5.42396e-07 9.40894 4.98347e-07 10.4167C4.54298e-07 11.4244 0.643935 12.265 1.49955 12.4582L1.5 14.5833C1.5 14.8135 1.66789 15 1.875 15C2.08211 15 2.25 14.8135 2.25 14.5833L2.25007 12.4583C3.10587 12.2653 3.75 11.4245 3.75 10.4167ZM3 10.4167C3 11.107 2.49632 11.6667 1.875 11.6667C1.25368 11.6667 0.75 11.107 0.75 10.4167C0.750001 9.72631 1.25368 9.16667 1.875 9.16667C2.49632 9.16667 3 9.72631 3 10.4167ZM9 4.58333C9 3.57546 8.35587 2.73475 7.50007 2.54169L7.5 0.416667C7.5 0.186548 7.33211 -7.29059e-08 7.125 -8.19588e-08C6.91789 -9.10118e-08 6.75 0.186548 6.75 0.416667L6.74955 2.54178C5.89394 2.735 5.25 3.57561 5.25 4.58333C5.25 5.59106 5.89393 6.43167 6.74955 6.62489L6.75 14.5833C6.75 14.8135 6.91789 15 7.125 15C7.33211 15 7.5 14.8135 7.5 14.5833L7.50007 6.62498C8.35587 6.43192 9 5.5912 9 4.58333ZM8.25 4.58333C8.25 5.27369 7.74632 5.83333 7.125 5.83333C6.50368 5.83333 6 5.27369 6 4.58333C6 3.89298 6.50368 3.33333 7.125 3.33333C7.74632 3.33333 8.25 3.89298 8.25 4.58333Z"
                                            fill="#212121" />
                                    </svg>
                                </span> More filters <span class=" caret"></span></button>
                            <ul id="order-delay" class="dropdown-menu custom-drop-down-checkboxes">
                                <li><a href="#" class="small" data-value="option1" tabIndex="-1"><input
                                            type="checkbox" />&nbsp;Option 1</a></li>
                                <li><a href="#" class="small" data-value="option2" tabIndex="-1"><input
                                            type="checkbox" />&nbsp;Option 2</a></li>
                                <li><a href="#" class="small" data-value="option3" tabIndex="-1"><input
                                            type="checkbox" />&nbsp;Option 3</a></li>
                                <li><a href="#" class="small" data-value="option4" tabIndex="-1"><input
                                            type="checkbox" />&nbsp;Option 4</a></li>
                                <li><a href="#" class="small" data-value="option5" tabIndex="-1"><input
                                            type="checkbox" />&nbsp;Option 5</a></li>
                                <li><a href="#" class="small" data-value="option6" tabIndex="-1"><input
                                            type="checkbox" />&nbsp;Option 6</a></li>
                            </ul>
                        </div>
                        <div class="button-group custom-btn-border bg-transparent">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle  bg-transparent"
                                data-toggle="dropdown"><span><svg width="14" height="14" viewBox="0 0 14 14"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.30187 10.6177C0.635872 9.57175 0.25 8.33059 0.25 7C0.25 3.27456 3.27456 0.25 7 0.25C10.7254 0.25 13.75 3.27456 13.75 7C13.75 8.35816 13.3478 9.62294 12.6568 10.6824C12.4869 10.9423 12.1382 11.0157 11.8783 10.8461C11.6181 10.6765 11.545 10.3275 11.7146 10.0676C12.2903 9.18503 12.625 8.13147 12.625 7C12.625 3.89556 10.1044 1.375 7 1.375C3.89556 1.375 1.375 3.89556 1.375 7C1.375 8.20375 1.75385 9.31975 2.39875 10.2347C2.51125 10.3944 2.5329 10.6008 2.45612 10.7803L1.8835 12.1165L3.21972 11.5439C3.39915 11.4671 3.60559 11.4888 3.76534 11.6012C4.68025 12.2462 5.79625 12.625 7 12.625C8.20291 12.625 9.31806 12.2467 10.2327 11.6027C10.4867 11.4238 10.8377 11.4848 11.0165 11.7388C11.1951 11.9925 11.1344 12.3437 10.8804 12.5223C9.78241 13.2958 8.44394 13.75 7 13.75C5.66941 13.75 4.42825 13.3641 3.38228 12.6981L1.03412 13.7044C0.822623 13.795 0.577375 13.7478 0.414812 13.5852C0.25225 13.4226 0.204996 13.1774 0.295559 12.9659L1.30187 10.6177Z"
                                            fill="#212121" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.375 4.75L3.625 4.75C3.3145 4.75 3.0625 5.002 3.0625 5.3125C3.0625 5.623 3.3145 5.875 3.625 5.875H10.375C10.6855 5.875 10.9375 5.623 10.9375 5.3125C10.9375 5.002 10.6855 4.75 10.375 4.75Z"
                                            fill="#212121" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.375 8.125H3.625C3.3145 8.125 3.0625 8.377 3.0625 8.6875C3.0625 8.998 3.3145 9.25 3.625 9.25H10.375C10.6855 9.25 10.9375 8.998 10.9375 8.6875C10.9375 8.377 10.6855 8.125 10.375 8.125Z"
                                            fill="#212121" />
                                    </svg>
                                </span> Status <span class=" caret"></span></button>
                            <ul id="lifting-pending" class="dropdown-menu custom-drop-down-checkboxes">
                                <li><a href="#" class="small" data-value="option1" tabIndex="-1"><input
                                            type="checkbox" />&nbsp;Option 1</a></li>
                                <li><a href="#" class="small" data-value="option2" tabIndex="-1"><input
                                            type="checkbox" />&nbsp;Option 2</a></li>
                                <li><a href="#" class="small" data-value="option3" tabIndex="-1"><input
                                            type="checkbox" />&nbsp;Option 3</a></li>
                                <li><a href="#" class="small" data-value="option4" tabIndex="-1"><input
                                            type="checkbox" />&nbsp;Option 4</a></li>
                                <li><a href="#" class="small" data-value="option5" tabIndex="-1"><input
                                            type="checkbox" />&nbsp;Option 5</a></li>
                                <li><a href="#" class="small" data-value="option6" tabIndex="-1"><input
                                            type="checkbox" />&nbsp;Option 6</a></li>
                            </ul>
                        </div>
                    </div> --}}
            {{-- <div class="text-right">
                        <a href="{{ route('dealerdetails') }}" class="btn custom-orange-button"><i
                                class="fas fa-plus-circle"></i> Add New Dealer</a>
                    </div> --}}
            {{-- </div>
            </div> --}}
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex flex-wrap  justify-content-between align-items-center w-100">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="d-flex flex-column">
                        <label class="mb-0" for="">User Filter</label>
                        <select name="userfilter" id="userfilter" class="form-control select2">
                            <option value="">Select User Name</option>
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="text-right">
                    <a href="{{ route('dealerdetails') }}" class="btn custom-orange-button"><i
                            class="fas fa-plus-circle"></i> Add New Dealer</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableDealer">
                            <thead>
                                <tr>
                                    {{-- <th class="text-center pt-3">
                                        <div class="custom-checkbox custom-checkbox-table custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                                class="custom-control-input" id="checkbox-all">
                                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </th> --}}
                                    {{-- <th>Dealer Code</th> --}}
                                    <th>S.No</th>
                                    <th>Dealer Name & Address</th>
                                    <th>Dealer Email</th>
                                    <th>Dealer Mobile</th>
                                    <th>Status</th>
                                    {{-- <th>Zone</th>
                                    <th>Advance Available</th>
                                    <th>Live orders</th>
                                    <th>orders</th> --}}
                                    <th>Action</th>
                                    {{-- <th>Info <i class="fas fa-info-circle"></i></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td class="text-center pt-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup"
                                                class="custom-control-input" id="checkbox-1">
                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>999-5878</td>
                                    <td>
                                        <div class="text-dark h6">Premlata Silver LLP</div>
                                        <div>3/91, 4th Kasthuribai Street,..</div>
                                    </td>
                                    <td>
                                        <div class="badge starting">North Zone <i
                                                class="ml-2 fas fa-chevron-down"></i></div>
                                    </td>
                                    <td>₹3,30,449.00</td>
                                    <td>4</td>
                                    <td>2</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="text-success mr-2"><img
                                                    src="{{ asset('backend/assets/img/icons/edit-pen.png') }}"
                                                    alt=""></a>
                                            <a href="#" class="text-danger"><img
                                                    src="{{ asset('backend/assets/img/icons/trash-bin.png') }}"
                                                    alt=""></a>
                                        </div>
                                    </td>
                                    <td class="text-center"><button class="btn toggle-sub-table"><i
                                                class="fas fa-angle-right"></i></button></td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="editmodal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Edit Dealer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dealerupdate') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="dealerId" id="dealerId" value="">
                    <input type="hidden" name="userId" id="userId" value="">
                    <input type="hidden" name="chequeleaf" id="chequeleaf" value="">
                    <input type="hidden" name="gstcertificate" id="gstcertificate" value="">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Company Name<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="company_name" id="company_name"
                                            value="{{ old('company_name') }}" placeholder="Company Name" required>
                                        @error('company_name')
                                            <div class="text-danger">{{ $errors->first('company_name') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Communication /
                                            Delivery Address<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="communication_address"
                                            id="communication_address" value="{{ old('communication_address') }}"
                                            placeholder="Communication / Delivery Address" required>
                                        @error('communication_address')
                                            <div class="text-danger">{{ $errors->first('communication_address') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Mail ID<span class="text-danger">*</span>
                                        </label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="{{ old('email') }}" placeholder="Mail ID" required>
                                        @error('email')
                                            <div class="text-danger">{{ $errors->first('email') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Land Line No<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="mobile" id="mobile"
                                        maxlength="10"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                            value="{{ old('mobile') }}" placeholder="Land Line No" required>
                                        @error('mobile')
                                            <div class="text-danger">{{ $errors->first('mobile') }}
                                            </div>
                                        @enderror
                                    </div>
                                    @php
                                        $zones = App\Models\Zone::get();
                                    @endphp
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Zone<span class="text-danger">*</span></label>
                                        <select name="zone" id="zone" class="form-control " required>
                                            <option value="">Select Zone Name</option>
                                            @foreach ($zones as $zone)
                                                <option value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('zone')
                                            <div class="text-danger">{{ $errors->first('zone') }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>City<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="city" id="city"
                                            value="{{ old('city') }}" placeholder="City" required>
                                        @error('city')
                                            <div class="text-danger">{{ $errors->first('city') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>State<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="state" id="state"
                                            value="{{ old('state') }}" placeholder="State" required>
                                        @error('state')
                                            <div class="text-danger">{{ $errors->first('state') }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="card-title m-0 me-2">(A) For Orders</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                                <label>Name<span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="a_name"
                                                    id="a_name" value="{{ old('a_name') }}" placeholder="Name"
                                                    required>
                                                @error('a_name')
                                                    <div class="text-danger">{{ $errors->first('a_name') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                                <label>Designation<span>*</span>
                                                </label>
                                                <input type="text" class="form-control" name="a_designation"
                                                    id="a_desingation" value="{{ old('a_designation') }}"
                                                    placeholder="Designation" required>
                                                @error('a_designation')
                                                    <div class="text-danger">{{ $errors->first('a_designation') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                                <label>Mobile No<span>*</span>
                                                </label>
                                                <input type="text" class="form-control" name="a_mobile"
                                                    id="a_mobile"
                                                    maxlength="10"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                    value="{{ old('a_mobile') }}" placeholder="Mobile No" required>
                                                @error('a_mobile')
                                                    <div class="text-danger">{{ $errors->first('a_mobile') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                                <label>Mail ID<span>*</span>
                                                </label>
                                                <input type="text" class="form-control" name="a_email"
                                                    id="a_email" value="{{ old('a_email') }}"
                                                    placeholder="Mail ID" required>
                                                @error('a_email')
                                                    <div class="text-danger">{{ $errors->first('a_email') }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="card-title m-0 me-2">(B) For Orders</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                                <label>Name<span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="b_name"
                                                    id="b_name" value="{{ old('b_name') }}" placeholder="Name"
                                                    required>
                                                @error('b_name')
                                                    <div class="text-danger">{{ $errors->first('b_name') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                                <label>Designation<span>*</span>
                                                </label>
                                                <input type="text" class="form-control" name="b_designation"
                                                    id="b_designation" value="{{ old('b_designation') }}"
                                                    placeholder="Desgination" required>
                                                @error('b_designation')
                                                    <div class="text-danger">{{ $errors->first('b_designation') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                                <label>Mobile No<span>*</span>
                                                </label>
                                                <input type="text" class="form-control" name="b_mobile"
                                                    id="b_mobile"
                                                    maxlength="10"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                    value="{{ old('b_mobile') }}" placeholder="Mobile No" required>
                                                @error('b_mobile')
                                                    <div class="text-danger">{{ $errors->first('b_mobile') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                                <label>Mail ID<span>*</span>
                                                </label>
                                                <input type="text" class="form-control" name="b_email"
                                                    id="b_email" value="{{ old('b_email') }}"
                                                    placeholder="Mail ID" required>
                                                @error('b_email')
                                                    <div class="text-danger">{{ $errors->first('b_email') }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title m-0 me-2">CIN (Only for Companies)</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>GSTN<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="gst" id="gst"
                                            value="{{ old('gst') }}" placeholder="GSTN" required>
                                        @error('gst')
                                            <div class="text-danger">{{ $errors->first('gst') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Income Tax Pan<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="income_tax_pan"
                                            id="income_tax_pan" value="{{ old('income_tax_pan') }}"
                                            placeholder="Income Tax Pan" required>
                                        @error('income_tax_pan')
                                            <div class="text-danger">{{ $errors->first('income_tax_pan') }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title m-0 me-2">Bank Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Bank Name<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="bank_name" id="bank_name"
                                            value="{{ old('bank_name') }}" placeholder="Bank Name" required>
                                        @error('bank_name')
                                            <div class="text-danger">{{ $errors->first('bank_name') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Branch Name<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="branch_name"
                                            id="branch_name" value="{{ old('branch_name') }}"
                                            placeholder="Branch Name" required>
                                        @error('branch_name')
                                            <div class="text-danger">{{ $errors->first('branch_name') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Address<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="address" id="address"
                                            value="{{ old('address') }}" placeholder="Address" required>
                                        @error('address')
                                            <div class="text-danger">{{ $errors->first('address') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Account No<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="account_number"
                                            value="{{ old('account_number') }}" id="account_number"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                            placeholder="Account No" required>
                                        @error('account_number')
                                            <div class="text-danger">{{ $errors->first('account_number') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Type of Account<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="account_type"
                                            id="account_type" value="{{ old('account_type') }}"
                                            placeholder="Type Of Account" required>
                                        @error('account_type')
                                            <div class="text-danger">{{ $errors->first('account_type') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>IFSC No<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="ifsc" id="ifsc"
                                            value="{{ old('ifsc') }}" placeholder="IFSC No" required>
                                        @error('ifsc')
                                            <div class="text-danger">{{ $errors->first('ifsc') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Cancelled Check Leaf<span class="text-danger">*</span></label>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <input type="file" class="form-control" id="cheque_leaf"
                                                name="cheque_leaf" required>
                                            <span class="ml-1" id="chequeview" style="display: none">
                                                <a id="chequelink" class="btn btn-primary">View</a>
                                            </span>
                                        </div>

                                        @error('cheque_leaf')
                                            <div class="text-danger">{{ $errors->first('cheque_leaf') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>GST Certificate<span class="text-danger">*</span></label>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <input type="file" class="form-control" id="gst_certificate"
                                                name="gst_certificate" required>
                                            <span class="ml-1" id="gstview" style="display: none">
                                                <a id="gstlink" class="btn btn-primary">View</a>
                                            </span>
                                        </div>
                                        @error('gst_certificate')
                                            <div class="text-danger">
                                                {{ $errors->first('gst_certificate') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button class="btn btn-warning custom-orange-button mr-3 px-3">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script src="{{ asset('backend/assets/js/admin/dealer/dealerlist.js') }}"></script>
@endsection
@endsection
