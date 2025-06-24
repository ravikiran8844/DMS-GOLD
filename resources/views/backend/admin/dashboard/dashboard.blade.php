@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="h2 page-main-heading">Dashboard</div>
            <div>Welcome to <span><b>EDMS</b></span> Silver </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center w-100">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="d-flex flex-column">
                        <label class="mb-0" for="datefilter">Date Range</label>
                        <input class="form-control custom-date-input flex-grow-1" type="text"
                            placeholder="Date Range Filter" name="datefilter" id="datefilter">
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center">
                    <div class="d-flex flex-column">
                        <label class="mb-0" for="dealerFilter">Dealer</label>
                        <select name="dealerfilter" id="dealerfilter" class="form-control select2">
                            <option value="">Select Dealer Name</option>
                            @foreach ($dealers as $dealer)
                                <option value="{{ $dealer->id }}">{{ $dealer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center">
                    <div class="d-flex flex-column">
                        <label class="mb-0" for="projectfilter">Project</label>
                        <select name="projectfilter" id="projectfilter" class="form-control select2">
                            <option value="">Select Project Name</option>
                            @foreach ($projectFilter as $item)
                                <option value="{{ $item->id }}">{{ $item->project_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center">
                    <div class="d-flex flex-column">
                        <label class="mb-0" for="zonefilter">Zone</label>
                        <select name="zonefilter" id="zonefilter" class="form-control select2">
                            <option value="">Select Zone Name</option>
                            @foreach ($zones as $zone)
                                <option value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12 order-1 order-xl-0">



            {{-- <span class="coming_soon"> --}}
            <div class="card custom-card py-2">
                <div class="card-header px-0 py-0">
                </div>
                <div class="card-body py-0">
                    <div class="d-flex">
                        <div class="card-icon_wrapper">
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
                        <div>
                            <div class="h6">Total Orders</div>

                            <h4><span class="text-dark" id="totalorders">{{ $ordersCount }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </span> --}}
            {{-- <span class="coming_soon"> --}}
            <div class="card custom-card py-2">
                <div class="card-header px-0 py-0">
                </div>
                <div class="card-body py-0">
                    <div class="d-flex">
                        <div class="card-icon_wrapper">
                            <div class="card-svg_item">
                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0 21.6667C0 19.2734 1.9401 17.3333 4.33333 17.3333H21.6667C24.0599 17.3333 26 19.2734 26 21.6667C26 24.0599 24.0599 26 21.6667 26H4.33333C1.9401 26 0 24.0599 0 21.6667ZM2.16667 21.6667C2.16667 22.8633 3.13672 23.8333 4.33333 23.8333H21.6667C22.8633 23.8333 23.8333 22.8633 23.8333 21.6667C23.8333 20.4701 22.8633 19.5 21.6667 19.5H4.33333C3.13672 19.5 2.16667 20.4701 2.16667 21.6667ZM13 15.1667C8.81184 15.1667 5.41667 11.7715 5.41667 7.58333C5.41667 3.39517 8.81184 0 13 0C17.1882 0 20.5833 3.39517 20.5833 7.58333C20.5833 11.7715 17.1882 15.1667 13 15.1667ZM13 13C15.9915 13 18.4167 10.5749 18.4167 7.58333C18.4167 4.59179 15.9915 2.16667 13 2.16667C10.0085 2.16667 7.58333 4.59179 7.58333 7.58333C7.58333 10.5749 10.0085 13 13 13ZM4.33333 22.75V20.5833H16.25V22.75H4.33333ZM14.0833 4.33333V7.1346L15.9327 8.98398L14.4006 10.516L11.9167 8.03207V4.33333H14.0833Z"
                                        fill="#EE743C" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <div class="h6">Total Order Volume</div>
                            <h4><span class="text-dark" id="totalweight">{{ $weightCount }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </span> --}}
            {{-- <span class="coming_soon"> --}}
            <div class="card custom-card py-2">
                {{-- <div class="card-header px-0 py-0">
                    <div class="ml-auto">
                        <select class="custom-btn-border" name="" id="">
                            <option selected value="0-15">0-7 Days</option>
                            <option value="0-15">0-15 Days</option>
                        </select>
                    </div>
                </div> --}}
                <div class="card-body py-0">
                    <div class="d-flex">
                        <div class="card-icon_wrapper">
                            <svg width="41" height="41" viewBox="0 0 41 41" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="40.5133" height="40.5133" rx="11.5752" fill="#FFD8EB"></rect>
                                <path
                                    d="M32.7867 13.342L31.2997 13.1768C31.1896 12.7638 31.0519 12.4058 30.8316 12.0478L31.7679 10.8638C31.9055 10.6986 31.878 10.4507 31.7403 10.2855L30.8867 9.43188C30.7215 9.26667 30.5012 9.26667 30.3084 9.40435L29.1519 10.3406C28.794 10.1478 28.4084 9.98261 28.0229 9.87246L27.8577 8.38551C27.8302 8.16522 27.665 8 27.4447 8H26.2331C26.0128 8 25.82 8.16522 25.82 8.38551L25.6824 9.9C25.2969 10.0101 24.9113 10.1754 24.5534 10.3681L23.3968 9.43188C23.2316 9.2942 22.9838 9.32174 22.8186 9.45942L21.965 10.313C21.7997 10.4783 21.7997 10.6986 21.9374 10.8913L22.8737 12.0754C22.6809 12.4333 22.5157 12.7913 22.4055 13.2043L20.9186 13.342C20.6983 13.3696 20.5331 13.5348 20.5331 13.7551V14.9667C20.5331 15.187 20.6983 15.3797 20.9186 15.3797L22.4055 15.5449C22.5157 15.958 22.6809 16.3159 22.8737 16.6739L21.9374 17.8304C21.7997 17.9957 21.7997 18.2435 21.965 18.4087L22.8186 19.2623C22.9838 19.4275 23.2041 19.4275 23.3968 19.2899L24.5534 18.3536C24.9113 18.5739 25.2969 18.7116 25.6824 18.8217L25.8476 20.3087C25.8751 20.529 26.0403 20.6942 26.2606 20.6942H27.4722C27.6925 20.6942 27.8853 20.529 27.8853 20.3087L28.0505 18.8217C28.436 18.7116 28.8215 18.5739 29.1795 18.3536L30.336 19.2899C30.5012 19.4275 30.749 19.4275 30.9142 19.2623L31.7679 18.4087C31.9331 18.2435 31.9331 18.0232 31.7954 17.8304L30.8316 16.6739C31.0244 16.3159 31.1896 15.958 31.2997 15.5449L32.7867 15.3797C33.007 15.3522 33.1722 15.187 33.1722 14.9667V13.7551C33.1722 13.5348 33.007 13.3696 32.7867 13.342ZM26.8664 16.5638C25.6548 16.5638 24.6635 15.5725 24.6635 14.3609C24.6635 13.1493 25.6548 12.158 26.8664 12.158C28.078 12.158 29.0693 13.1217 29.0693 14.3609C29.0693 15.6 28.078 16.5638 26.8664 16.5638Z"
                                    fill="#DC5A99"></path>
                                <path
                                    d="M23.0113 24.1089L21.1388 23.9162C21.0012 23.4481 20.8359 23.0075 20.5881 22.5944L21.7722 21.135C21.8823 20.9973 21.8823 20.777 21.7446 20.6394L20.5606 19.4828C20.4229 19.3452 20.2302 19.3452 20.0925 19.4553L18.633 20.6394C18.22 20.3915 17.7794 20.2263 17.3113 20.0886L17.1186 18.2162C17.091 18.0234 16.9533 17.8857 16.7606 17.8857H15.1084C14.9157 17.8857 14.778 18.0234 14.7504 18.2162L14.5577 20.0886C14.0896 20.2263 13.649 20.3915 13.2359 20.6394L11.7765 19.4553C11.6388 19.3452 11.4186 19.3452 11.3084 19.4828L10.1244 20.6394C9.98667 20.777 9.98667 20.9698 10.0968 21.135L11.2809 22.5944C11.033 23.0075 10.8678 23.4481 10.7302 23.9162L8.85769 24.1089C8.66493 24.1089 8.52725 24.2741 8.52725 24.4669V26.1191C8.52725 26.3118 8.66493 26.4495 8.85769 26.477L10.7302 26.6698C10.8678 27.1379 11.033 27.5785 11.2809 27.9915L10.0693 29.451C9.95914 29.5886 9.95914 29.8089 10.0968 29.9466L11.2809 31.1031C11.4186 31.2408 11.6113 31.2408 11.7765 31.1307L13.2359 29.9466C13.649 30.1944 14.0896 30.3597 14.5577 30.4973L14.7504 32.3698C14.778 32.5626 14.9157 32.7002 15.1084 32.7002H16.7606C16.9533 32.7002 17.091 32.5626 17.1186 32.3698L17.3113 30.4973C17.7794 30.3597 18.22 30.1944 18.633 29.9466L20.0925 31.1307C20.2302 31.2408 20.4504 31.2408 20.5881 31.1031L21.7722 29.9191C21.9099 29.7814 21.9099 29.5886 21.7997 29.4234L20.6157 27.964C20.8635 27.551 21.0287 27.1104 21.1664 26.6423L23.0388 26.4495C23.2316 26.422 23.3693 26.2843 23.3693 26.0915V24.4394C23.3417 24.2741 23.2041 24.1089 23.0113 24.1089ZM15.9345 27.8539C14.5026 27.8539 13.3461 26.6973 13.3461 25.2655C13.3461 23.8336 14.5026 22.7046 15.9345 22.7046C17.3664 22.7046 18.5229 23.8611 18.5229 25.2655C18.5229 26.6973 17.3664 27.8539 15.9345 27.8539Z"
                                    fill="#DC5A99"></path>
                                <path
                                    d="M14.2548 14.9116V15.9029C14.2548 16.2334 14.6128 16.4261 14.8606 16.2334L18.6881 13.8652C18.936 13.7 18.936 13.3421 18.6881 13.1768L14.8606 10.8087C14.5852 10.6435 14.2548 10.8363 14.2548 11.1392V12.158C12.6026 12.3507 8.44465 13.4797 7.01277 19.758C6.90262 20.1986 7.53596 20.4189 7.72871 19.9783C9.10552 16.9493 11.391 15.1594 14.2548 14.9116Z"
                                    fill="#DC5A99"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="h6">Total Project</div>
                            <h4><span class="text-dark" id="totalproject">{{ $projectCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </span> --}}

        </div>
        <noscript></noscript>
        <input type="hidden" name="orderdata" id="orderdata" value="{{ json_encode($monthNames) }}">
        <input type="hidden" name="ordermonth" id="ordermonth" value="{{ json_encode($totalWeightMonthly) }}">

        <div class="col-xl-6 col-12 order-0 order-xl-1 mb-4">
            <span class="coming_soon1">
                <div class="card h-100">
                    <div class="row ">
                        <div class="col-12 pt-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="h6 mb-2"> Total Orders</div>
                                        <div class="d-flex flex-column flex-md-row align-items-md-center">
                                            <h4 class="mb-3 mr-3 text-dark">
                                                688,000</h2>
                                                <div class="h6 mb-4">last 30 days order 563000gm</div>
                                        </div>
                                    </div>
                                    <div>
                                        <select class="custom-btn-border" name="" id="">
                                            <option selected="" value="0-30">Last 30 Days</option>
                                            <option value="0-15">Last 15 Days</option>
                                            <option value="0-7">Last 7 Days</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="myChart2div">
                                    <canvas id="myChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </span>

        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12 order-xl-2">
            <span class="coming_soon">
                <div class="card custom-card py-2">
                    {{-- <div class="card-header px-0 py-0">
                    <div class="ml-auto">
                        <select class="custom-btn-border" name="" id="">
                            <option selected="" value="0-15">0-7 Days</option>
                            <option value="0-15">0-15 Days</option>
                        </select>
                    </div>
                </div> --}}
                    <div class="card-body py-0">
                        <div class="d-flex">
                            <div class="card-icon_wrapper">
                                <svg width="41" height="41" viewBox="0 0 41 41" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="40.5133" height="40.5133" rx="11.5752" fill="#CEFAFF" />
                                    <path
                                        d="M23.1339 8.42122C24.1568 8.69201 25.1196 9.11323 26.0223 9.62472C26.9249 10.1663 27.7673 10.7981 28.5195 11.5503C29.2717 12.3025 29.9035 13.1449 30.4451 14.0476C30.9566 14.9502 31.3778 15.913 31.6486 16.936C31.799 17.4474 31.8893 17.9589 31.9495 18.5005C32.0096 19.012 32.0397 19.5536 32.0397 20.065C32.0397 20.5464 32.0096 20.9978 31.9495 21.4791C31.9495 21.5694 31.9194 21.6597 31.9194 21.7499C31.8592 22.2313 31.7389 22.7127 31.6185 23.164C31.3477 24.187 30.9566 25.1498 30.415 26.0524C29.8734 26.9551 29.2416 27.7975 28.4894 28.5497C27.7372 29.3019 26.8948 29.9337 25.9922 30.4753C25.0895 30.9868 24.1268 31.408 23.1038 31.6788H23.0737L22.0808 27.8878C23.9763 27.3763 25.6311 26.2029 26.7444 24.5781C27.8576 22.9534 28.3089 20.9677 28.0682 19.012C27.8275 17.0563 26.8647 15.2511 25.3904 13.9573C23.9161 12.6335 21.9905 11.9114 20.0349 11.9114V8C20.4862 8 20.9676 8.03009 21.4189 8.09026C21.5392 8.09026 21.6596 8.12035 21.7799 8.15044C22.2613 8.21061 22.7126 8.30087 23.1339 8.42122Z"
                                        fill="#5DB9C4" />
                                    <path
                                        d="M14.2882 25.7812L11.5202 28.5493C12.2724 29.3015 13.0847 29.9333 14.0175 30.4749L15.9731 27.075C15.3413 26.714 14.7696 26.2927 14.2882 25.7812Z"
                                        fill="#5DB9C4" />
                                    <path
                                        d="M18.9517 28.0983C18.5907 28.0381 18.2296 27.978 17.8987 27.8877L16.8757 31.6787C17.3872 31.7991 17.8987 31.9194 18.4101 31.9796C18.9517 32.0398 19.4632 32.0698 19.9747 32.0999V28.1886C19.6738 28.1585 19.3128 28.1284 18.9517 28.0983Z"
                                        fill="#5DB9C4" />
                                    <path
                                        d="M12.182 22.1406C12.3625 22.8326 12.6333 23.4946 12.9944 24.0963L9.59449 26.052C9.083 25.1494 8.66178 24.1866 8.39099 23.1636L12.182 22.1406Z"
                                        fill="#5DB9C4" />
                                    <path
                                        d="M15.9731 12.995C16.5748 12.6339 17.2367 12.3631 17.9288 12.1826L16.9058 8.3916C15.8828 8.66239 14.92 9.08361 14.0174 9.5951L15.9731 12.995Z"
                                        fill="#5DB9C4" />
                                    <path
                                        d="M14.2881 14.2885C13.7766 14.8 13.3554 15.3416 12.9944 15.9734L9.59448 14.0178C10.1361 13.1151 10.7679 12.2727 11.5201 11.5205L14.2881 14.2885Z"
                                        fill="#5DB9C4" />
                                    <path
                                        d="M8.09017 18.47C8.15035 17.9284 8.27069 17.4169 8.39104 16.9355L12.1821 17.9284C12.0918 18.2594 12.0316 18.6204 11.9714 18.9815C11.9113 19.3425 11.9113 19.7036 11.9113 20.0345H7.99991C7.99991 19.5231 8.03 18.9815 8.09017 18.47Z"
                                        fill="#5DB9C4" />
                                    <path
                                        d="M24.1268 16.4846C24.0967 16.4545 24.0365 16.4244 24.0065 16.3943C23.9463 16.3643 23.9162 16.3643 23.856 16.3643C23.7958 16.3643 23.7357 16.3643 23.7056 16.3943C23.6454 16.4244 23.6153 16.4545 23.5852 16.4846L18.3801 21.5995C18.2899 21.6596 18.1996 21.7198 18.0792 21.7198C17.9589 21.7198 17.8686 21.6897 17.7784 21.5995L16.4846 20.3358C16.3943 20.2756 16.3041 20.2154 16.1837 20.2154C16.0634 20.2154 15.9731 20.2455 15.8829 20.3358L15.1006 21.1181C15.0404 21.2083 14.9802 21.2986 14.9802 21.4189C14.9802 21.5393 15.0103 21.6296 15.1006 21.7198L17.7483 24.3374C17.8385 24.3976 17.9288 24.4578 18.0492 24.4578C18.1695 24.4578 18.2598 24.4277 18.35 24.3374L24.9392 17.8385C24.9693 17.8085 24.9993 17.7483 25.0294 17.7182C25.0595 17.658 25.0595 17.6279 25.0595 17.5678C25.0595 17.5076 25.0595 17.4474 25.0294 17.4173C24.9993 17.3571 24.9693 17.3271 24.9392 17.297L24.1268 16.4846Z"
                                        fill="#5DB9C4" />
                                </svg>
                            </div>
                            <div>
                                <div class="h6">Total Project</div>
                                <h4> <span class="text-dark" id="totalproject">{{ $projectCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </span>

            <span class="coming_soon">
                <div class="card custom-card py-2">
                    <div class="card-header px-0 py-0">
                        <div class="ml-auto">
                            <select class="custom-btn-border" name="" id="">
                                <option selected="" value="0-15">0-7 Days</option>
                                <option value="0-15">0-15 Days</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body py-0">
                        <div class="d-flex">
                            <div class="card-icon_wrapper">
                                <svg width="41" height="41" viewBox="0 0 41 41" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="40.5133" height="40.5133" rx="11.5752" fill="#F5F0BB" />
                                    <path
                                        d="M12.7079 20.215V21.4394L8.46308 20.0244C8.38226 20.0072 8.30601 19.9731 8.23934 19.9243C8.17267 19.8755 8.1171 19.8132 8.07629 19.7413C8.03549 19.6695 8.01037 19.5898 8.00259 19.5075C7.99482 19.4253 8.00457 19.3423 8.03119 19.2641C8.05782 19.1859 8.10072 19.1142 8.15707 19.0538C8.21341 18.9934 8.28192 18.9456 8.35809 18.9135C8.43425 18.8815 8.51634 18.866 8.59894 18.868C8.68153 18.87 8.76276 18.8895 8.83728 18.9252L12.7079 20.215ZM10.8954 22.5304C10.748 22.4853 10.5889 22.499 10.4515 22.5688C10.3141 22.6386 10.2091 22.759 10.1587 22.9046C10.1332 22.9767 10.1224 23.0532 10.1269 23.1296C10.1314 23.2059 10.1511 23.2806 10.1849 23.3492C10.2187 23.4179 10.2658 23.479 10.3236 23.5292C10.3813 23.5794 10.4485 23.6175 10.5212 23.6413L12.7079 24.3663V23.1385L10.8954 22.5304ZM16.6358 10.135L25.6552 13.2011C25.7279 13.2258 25.8048 13.236 25.8815 13.231C25.9581 13.226 26.033 13.206 26.1019 13.1721C26.1708 13.1381 26.2323 13.091 26.283 13.0333C26.3337 12.9755 26.3725 12.9084 26.3972 12.8357C26.4219 12.763 26.4321 12.6861 26.4271 12.6095C26.4221 12.5328 26.4021 12.4579 26.3682 12.389C26.3342 12.3201 26.2871 12.2586 26.2293 12.2079C26.1716 12.1573 26.1045 12.1185 26.0318 12.0937L17.0124 9.03113C16.8655 8.9812 16.7049 8.99165 16.5657 9.06018C16.4266 9.12871 16.3203 9.24971 16.2704 9.39656C16.2205 9.54341 16.2309 9.70408 16.2995 9.84323C16.368 9.98238 16.489 10.0886 16.6358 10.1385V10.135ZM9.60205 14.4114C9.52818 14.3834 9.4494 14.3706 9.37045 14.3738C9.2915 14.3771 9.21403 14.3963 9.14272 14.4303C9.0714 14.4643 9.00772 14.5124 8.95552 14.5718C8.90332 14.6311 8.86369 14.7003 8.83901 14.7754C8.81433 14.8505 8.80512 14.9298 8.81194 15.0085C8.81876 15.0872 8.84146 15.1637 8.87868 15.2334C8.9159 15.3031 8.96685 15.3645 9.02847 15.414C9.0901 15.4635 9.1611 15.4999 9.2372 15.5212L11.3421 16.2228C11.4017 16.2423 11.4641 16.2521 11.5268 16.252C11.6661 16.2526 11.8009 16.2034 11.9071 16.1133C12.0133 16.0233 12.0839 15.8983 12.1062 15.7609C12.1285 15.6234 12.101 15.4826 12.0286 15.3636C11.9563 15.2446 11.8439 15.1554 11.7116 15.1119L9.60205 14.4114ZM8.45372 12.4785L15.173 14.7178C15.2324 14.7381 15.2949 14.7484 15.3577 14.7482C15.4989 14.7515 15.6366 14.7036 15.7452 14.6133C15.8539 14.523 15.9261 14.3964 15.9487 14.2569C15.9712 14.1175 15.9425 13.9746 15.8678 13.8546C15.7931 13.7347 15.6776 13.6459 15.5425 13.6046L8.82325 11.3699C8.74963 11.3422 8.67118 11.3297 8.5926 11.333C8.51403 11.3363 8.43693 11.3555 8.36593 11.3893C8.29493 11.4232 8.23148 11.471 8.17939 11.5299C8.12729 11.5888 8.08762 11.6576 8.06275 11.7323C8.03788 11.8069 8.02832 11.8857 8.03464 11.9641C8.04096 12.0425 8.06303 12.1188 8.09953 12.1885C8.13603 12.2582 8.18622 12.3198 8.24707 12.3696C8.30793 12.4194 8.37822 12.4564 8.45372 12.4785ZM17.3948 15.8182L13.7837 17.1723L22.671 20.505L26.2809 19.1509L17.3948 15.8182ZM19.06 15.1937L27.9472 18.5265L31.5582 17.1723L22.671 13.8396L19.06 15.1937ZM12.7079 20.215L17.3152 21.7469C17.4514 21.7865 17.5686 21.8743 17.6449 21.9938C17.7212 22.1134 17.7514 22.2566 17.7299 22.3968C17.7085 22.537 17.6368 22.6646 17.5282 22.7559C17.4197 22.8472 17.2816 22.8959 17.1398 22.8929C17.0758 22.8937 17.0122 22.8818 16.9527 22.8578L12.7079 21.4394V23.135L15.5378 24.0822C15.6654 24.1282 15.7731 24.2171 15.8423 24.3338C15.9116 24.4504 15.9381 24.5875 15.9174 24.7216C15.8966 24.8556 15.8299 24.9783 15.7287 25.0686C15.6274 25.1589 15.4979 25.2112 15.3624 25.2165C15.2994 25.2152 15.2367 25.2073 15.1753 25.1931L12.7079 24.3628V27.3213L22.0863 30.8295V21.5329L12.7079 18.0131V20.215ZM23.2557 21.5353V30.8376L32.6387 27.319V18.0154L23.2557 21.5353Z"
                                        fill="#9F984E" />
                                </svg>
                            </div>
                            <div>
                                <div class="h6">Orders Shipped</div>
                                <h4 class="text-dark">30</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer px-2  py-0">
                        <div class="orders-shipped-card_bottom-text ml-auto p-1">
                            +5.9%
                        </div>
                    </div>
                </div>
            </span>

            <span class="coming_soon">
                <div class="card custom-card py-2">
                    <div class="card-header px-0 py-0">
                        <div class="ml-auto">
                            <select class="custom-btn-border" name="" id="">
                                <option selected="" value="0-15">0-7 Days</option>
                                <option value="0-15">0-15 Days</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body py-0">
                        <div class="d-flex">
                            <div class="card-icon_wrapper">
                                <svg width="41" height="41" viewBox="0 0 41 41" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="40.5133" height="40.5133" rx="11.5752" fill="#E8FAF5" />
                                    <path
                                        d="M12.6446 16.6623C12.6808 17.1613 14.0747 21.0024 16.6783 21.0024C19.2819 21.0024 20.6094 16.5902 20.6094 16.5902C20.6094 16.5902 21.5778 15.6645 21.4692 14.7027C21.3606 13.7409 20.8598 14.0625 20.8598 14.0625C20.8598 14.0625 21.252 12.3914 20.8598 10.7534C20.4676 9.11534 17.9303 7.4803 15.9663 8.15656C14.0023 8.83281 14.1803 9.5812 14.1803 9.5812C14.1803 9.5812 12.895 9.04621 12.3218 10.6842C11.7516 12.3223 12.3218 14.0655 12.3218 14.0655C10.928 14.7057 12.6114 16.6233 12.6114 16.6233C12.6114 16.6233 12.6084 16.1634 12.6446 16.6623Z"
                                        fill="#18CE98" />
                                    <path
                                        d="M20.7815 25.1114C20.7815 23.816 21.1224 22.5987 21.7137 21.5408L20.0755 20.8946C20.0755 20.8946 18.8808 22.214 16.6271 22.1419C14.3735 22.0698 13.5046 20.6992 13.5046 20.6992L9.10284 22.3463C7.30775 23.0165 5.9833 24.5614 5.60015 26.4339L5.04503 29.1599C4.76747 30.5154 5.80832 31.7868 7.19914 31.7868H25.1169C22.5615 30.6417 20.7815 28.0839 20.7815 25.1114Z"
                                        fill="#18CE98" />
                                    <path
                                        d="M28.1277 18.998C24.7366 18.998 21.9882 21.7361 21.9882 25.1144C21.9882 28.4927 24.7366 31.2307 28.1277 31.2307C31.5188 31.2307 34.2642 28.4897 34.2642 25.1114C34.2642 21.7331 31.5157 18.998 28.1277 18.998ZM32.089 23.0496L27.12 28.4175L24.0699 25.8598C23.8527 25.6794 23.8255 25.3578 24.0065 25.1414C24.1876 24.925 24.5104 24.898 24.7276 25.0783L27.0295 27.0079L31.3377 22.3583C31.5278 22.1509 31.8536 22.1389 32.0618 22.3282C32.267 22.5206 32.279 22.8422 32.089 23.0496Z"
                                        fill="#18CE98" />
                                </svg>
                            </div>
                            <div>
                                <div class="h6">Orders Near Completion</div>
                                <h4 class="text-dark">12</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer px-2  py-0">
                        <div class="orders-complted-card_bottom-text ml-auto p-1">
                            +5.9%
                        </div>
                    </div>
                </div>
            </span>

        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-lg-6 mb-4">
            <span class="coming_soon1">
                <div class="card custom-card-items">
                    <div class="card-header flex-wrap">
                        <h4>Order Report</h4>
                        <div class="card-header-action">
                            <a href="#" class="btn active">Week</a>
                            <a href="#" class="btn">Month</a>
                            <a href="#" class="btn">Year</a>
                            <div class="dropdown ml-2">
                                <button class="zone-btn dropdown-toggle" type="button" id="zone-dropdownMenuButton1"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span>
                                        <svg width="15" height="10" viewBox="0 0 15 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.4167 5.83333C9.4088 5.83333 8.56808 6.54903 8.37502 7.49992L0.416667 7.5C0.186548 7.5 0 7.68655 0 7.91667C0 8.14678 0.186548 8.33333 0.416667 8.33333L8.37511 8.33383C8.56833 9.28452 9.40894 10 10.4167 10C11.4244 10 12.265 9.28452 12.4582 8.33383L14.5833 8.33333C14.8135 8.33333 15 8.14678 15 7.91667C15 7.68655 14.8135 7.5 14.5833 7.5L12.4583 7.49992C12.2653 6.54903 11.4245 5.83333 10.4167 5.83333ZM10.4167 6.66667C11.107 6.66667 11.6667 7.22631 11.6667 7.91667C11.6667 8.60702 11.107 9.16667 10.4167 9.16667C9.72631 9.16667 9.16667 8.60702 9.16667 7.91667C9.16667 7.22631 9.72631 6.66667 10.4167 6.66667ZM4.58333 0C3.57546 0 2.73475 0.715696 2.54169 1.66659L0.416667 1.66667C0.186548 1.66667 0 1.85321 0 2.08333C0 2.31345 0.186548 2.5 0.416667 2.5L2.54178 2.5005C2.735 3.45118 3.57561 4.16667 4.58333 4.16667C5.59106 4.16667 6.43167 3.45118 6.62489 2.5005L14.5833 2.5C14.8135 2.5 15 2.31345 15 2.08333C15 1.85321 14.8135 1.66667 14.5833 1.66667L6.62498 1.66659C6.43192 0.715696 5.5912 0 4.58333 0ZM4.58333 0.833333C5.27369 0.833333 5.83333 1.39298 5.83333 2.08333C5.83333 2.77369 5.27369 3.33333 4.58333 3.33333C3.89298 3.33333 3.33333 2.77369 3.33333 2.08333C3.33333 1.39298 3.89298 0.833333 4.58333 0.833333Z"
                                                fill="#F96421"></path>
                                        </svg>
                                    </span>
                                    Zone
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start"
                                    style="position: absolute; transform: translate3d(-5px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item" href="#">North Zone</a>
                                    <a class="dropdown-item" href="#">South Zone</a>
                                    <a class="dropdown-item" href="#">West Zone</a>
                                    <a class="dropdown-item" href="#">East Zone</a>
                                    <a class="dropdown-item" href="#">Corporate</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body myChartdiv">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </span>

        </div>
        <div class="col-12 col-sm-12 col-lg-6 mb-4">
            <span class="coming_soon">
                <div class="card custom-card-items">
                    <div class="card-header">
                        <h4>Overdue Orders</h4>
                        <div class="card-header-action">
                            <a class="view-all_link" href="#">See All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <table class="table table-bordered table-md">
                                <thead>
                                    <tr>
                                        <th>Dealers</th>
                                        <th>Qty</th>
                                        <th>Due Date</th>
                                        <th class="text-red">Overdue Days</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="h6">Jai Durga Jewel..</div>
                                            <div>C023-10059628</div>
                                        </td>
                                        <td>448.81</td>
                                        <td>Sept 02, 2023</td>
                                        <td class="text-red">10 days</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="h6">Jai Durga Jewel..</div>
                                            <div>C023-10059628</div>
                                        </td>
                                        <td>448.81</td>
                                        <td>Sept 02, 2023</td>
                                        <td class="text-red">10 days</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="h6">Jai Durga Jewel..</div>
                                            <div>C023-10059628</div>
                                        </td>
                                        <td>448.81</td>
                                        <td>Sept 02, 2023</td>
                                        <td class="text-red">10 days</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="h6">Jai Durga Jewel..</div>
                                            <div>C023-10059628</div>
                                        </td>
                                        <td>448.81</td>
                                        <td>Sept 02, 2023</td>
                                        <td class="text-red">10 days</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="h6">Jai Durga Jewel..</div>
                                            <div>C023-10059628</div>
                                        </td>
                                        <td>448.81</td>
                                        <td>Sept 02, 2023</td>
                                        <td class="text-red">10 days</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="h6">Jai Durga Jewel..</div>
                                            <div>C023-10059628</div>
                                        </td>
                                        <td>448.81</td>
                                        <td>Sept 02, 2023</td>
                                        <td class="text-red">10 days</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="h6">Jai Durga Jewel..</div>
                                            <div>C023-10059628</div>
                                        </td>
                                        <td>448.81</td>
                                        <td>Sept 02, 2023</td>
                                        <td class="text-red">10 days</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </span>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <span class="coming_soon">
                <div class="card h-100">
                    <div class="card-header pt-3">
                        <div class="d-flex justify-content-between w-100">
                            <div>
                                <h5>Recent Orders</h5>
                            </div>
                            <div class="d-flex align-items-center">
                                <div>
                                    <select class="custom-btn-border recent-orders-select-box" name=""
                                        id="">
                                        <option value="0-30">Last Month</option>
                                        <option value="0-15">Last 15 Days</option>
                                        <option selected value="0-7">Last week</option>
                                    </select>
                                </div>
                                <div class="dropdown d-inline ml-2">
                                    <button class="zone-btn dropdown-toggle" type="button"
                                        id="zone-dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="true">
                                        <span>
                                            <svg width="15" height="10" viewBox="0 0 15 10" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M10.4167 5.83333C9.4088 5.83333 8.56808 6.54903 8.37502 7.49992L0.416667 7.5C0.186548 7.5 0 7.68655 0 7.91667C0 8.14678 0.186548 8.33333 0.416667 8.33333L8.37511 8.33383C8.56833 9.28452 9.40894 10 10.4167 10C11.4244 10 12.265 9.28452 12.4582 8.33383L14.5833 8.33333C14.8135 8.33333 15 8.14678 15 7.91667C15 7.68655 14.8135 7.5 14.5833 7.5L12.4583 7.49992C12.2653 6.54903 11.4245 5.83333 10.4167 5.83333ZM10.4167 6.66667C11.107 6.66667 11.6667 7.22631 11.6667 7.91667C11.6667 8.60702 11.107 9.16667 10.4167 9.16667C9.72631 9.16667 9.16667 8.60702 9.16667 7.91667C9.16667 7.22631 9.72631 6.66667 10.4167 6.66667ZM4.58333 0C3.57546 0 2.73475 0.715696 2.54169 1.66659L0.416667 1.66667C0.186548 1.66667 0 1.85321 0 2.08333C0 2.31345 0.186548 2.5 0.416667 2.5L2.54178 2.5005C2.735 3.45118 3.57561 4.16667 4.58333 4.16667C5.59106 4.16667 6.43167 3.45118 6.62489 2.5005L14.5833 2.5C14.8135 2.5 15 2.31345 15 2.08333C15 1.85321 14.8135 1.66667 14.5833 1.66667L6.62498 1.66659C6.43192 0.715696 5.5912 0 4.58333 0ZM4.58333 0.833333C5.27369 0.833333 5.83333 1.39298 5.83333 2.08333C5.83333 2.77369 5.27369 3.33333 4.58333 3.33333C3.89298 3.33333 3.33333 2.77369 3.33333 2.08333C3.33333 1.39298 3.89298 0.833333 4.58333 0.833333Z"
                                                    fill="#F96421" />
                                            </svg>
                                        </span>
                                        Zone
                                    </button>
                                    <div class="dropdown-menu" x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 27px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item" href="#">North Zone</a>
                                        <a class="dropdown-item" href="#">South Zone</a>
                                        <a class="dropdown-item" href="#">West Zone</a>
                                        <a class="dropdown-item" href="#">East Zone</a>
                                        <a class="dropdown-item" href="#">Corporate</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center pt-3">
                                            <div class="custom-checkbox custom-checkbox-table custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup"
                                                    data-checkbox-role="dad" class="custom-control-input"
                                                    id="checkbox-all">
                                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Order ID</th>
                                        <th>Dealer Name</th>
                                        <th>Project</th>
                                        <th>Weight in Grams</th>
                                        <th>Order date</th>
                                        <th>Order Started date</th>
                                        <th>Status</th>
                                        <th>Info <i class="fas fa-info-circle"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center pt-2">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup"
                                                    class="custom-control-input" id="checkbox-1">
                                                <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>999-5878</td>
                                        <td>
                                            <div class="text-dark h6">Jai Durga Jewellers</div>
                                            <div>9th,Teachers Colony,..</div>
                                        </td>
                                        <td>Silver Chain (+3)</td>
                                        <td>448.81</td>
                                        <td>Mar 13, 2023</td>
                                        <td>Mar 13, 2023
                                        </td>
                                        <td>
                                            <div class="badge wip">Completed <i class="ml-2 fas fa-chevron-down"></i>
                                            </div>
                                        </td>
                                        <td class="text-center"><button class="btn toggle-sub-table"><i
                                                    class="fas fa-angle-right"></i></button></td>
                                    </tr>
                                    <!-- <tr class="sub-table">
                                    <td colspan="9">
                                    <table class="table">
                                    <thead>
                                    <tr>
                                    <th>Jobcard ID</th>
                                    <th>Project</th>
                                    <th>Weight</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Comments</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                    <td>12175</td>
                                    <td>Silver Home Decor</td>
                                    <td>318</td>
                                    <td>Aug 13, 2023</td>
                                    <td>Aug 24, 2023</td>
                                    <td>Order delay due to Metal availability....</td>
                                    </tr>
                                    <tr>
                                    <td>12176</td>
                                    <td>Silver Cladding</td>
                                    <td>218</td>
                                    <td>Aug 14, 2023</td>
                                    <td>Aug 20, 2023</td>
                                    <td>Order delay due to Metal availability....</td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    </td>
                                    </tr> -->
                                    <tr>
                                        <td class="text-center pt-2">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup"
                                                    class="custom-control-input" id="checkbox-2">
                                                <label for="checkbox-2" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>999-5878</td>
                                        <td>
                                            <div class="text-dark h6">Chandi Bazar</div>
                                            <div>9th,Teachers Colony,..</div>
                                        </td>
                                        <td>Silver Chain (+3)</td>
                                        <td>448.81</td>
                                        <td>Mar 13, 2023</td>
                                        <td>Mar 13, 2023
                                        </td>
                                        <td>
                                            <div class="badge overdue">Overdue <i
                                                    class="ml-2 fas fa-chevron-down"></i>
                                            </div>
                                        </td>
                                        <td class="text-center"><button class="btn toggle-sub-table"><i
                                                    class="fas fa-angle-right"></i></button></td>
                                    </tr>
                                    <!-- <tr class="sub-table">
                                    <td colspan="9">
                                    <table class="table">
                                    <thead>
                                    <tr>
                                    <th>Jobcard ID</th>
                                    <th>Project</th>
                                    <th>Weight</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Comments</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                    <td>12177</td>
                                    <td>Silver Home Decor</td>
                                    <td>368</td>
                                    <td>Aug 23, 2023</td>
                                    <td>Aug 26, 2023</td>
                                    <td>Order delay due to Metal availability....</td>
                                    </tr>
                                    <tr>
                                    <td>12177</td>
                                    <td>Silver Cladding</td>
                                    <td>218</td>
                                    <td>Aug 16, 2023</td>
                                    <td>Aug 20, 2023</td>
                                    <td>Order delay due to Metal availability....</td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    </td>
                                    </tr> -->
                                    <tr>
                                        <td class="text-center pt-2">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup"
                                                    class="custom-control-input" id="checkbox-3">
                                                <label for="checkbox-3" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>999-5878</td>
                                        <td>
                                            <div class="text-dark h6">Arvind Jewellers</div>
                                            <div>9th,Teachers Colony,..</div>
                                        </td>
                                        <td>Silver Chain (+3)</td>
                                        <td>448.81</td>
                                        <td>Mar 13, 2023</td>
                                        <td>Mar 13, 2023
                                        </td>
                                        <td>
                                            <div class="badge pending">Pending <i
                                                    class="ml-2 fas fa-chevron-down"></i>
                                            </div>
                                        </td>
                                        <td class="text-center"><button class="btn toggle-sub-table"><i
                                                    class="fas fa-angle-right"></i></button></td>
                                    </tr>
                                    <!--
                                    <tr class="sub-table">
                                    <td colspan="9">
                                    <table class="table table-sm">
                                    <thead>
                                    <tr>
                                    <th>Jobcard ID</th>
                                    <th>Project</th>
                                    <th>Weight</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Comments</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                    <td>12167</td>
                                    <td>Silver Home Decor</td>
                                    <td>360</td>
                                    <td>Aug 13, 2023</td>
                                    <td>Aug 26, 2023</td>
                                    <td>Order delay due to Metal availability....</td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    </td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </span>

        </div>
    </div>
</section>
@section('scripts')
    <script src="{{ asset('backend/assets/js/admin/dashboard/dashboard.js') }}"></script>
@endsection
@endsection
