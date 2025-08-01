@extends('frontend.layout.frontendmaster')
@section('content')
@section('title')
    Dashboard - Emerald OMS
@endsection
<main class="myaccount-page dashboard-page">
    <section class="container">
        <div class="row pt-4 pt-lg-5 pb-5">
            <div class="col-12">

                <div class="row">
                    <div class="col-12 col-md-3 col-lg-3 col-xxl-2">
                        <div class="dashboard-sidebar p-2 py-md-4">
                            <div class="nav flex-row flex-md-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <a class="nav-link active" href="{{ route('dealerdashboard') }}">Dashboard</a>
                                <a class="nav-link" href="{{ route('myprofile') }}">My Profile</a>
                                <a class="nav-link" href="{{ route('orders') }}">Orders</a>
                                <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-9 col-lg-9 col-xxl-10 mt-4 mt-md-0">
                        <div class="row mb-4">
                            <div class="col-12 d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                <div class="fs-5 fw-bold">
                                    Dashboard
                                </div>

                                <!-- <div class="input-group" style="width: fit-content;">
         <span class="input-group-text bg-white ">
          <svg width="15" height="14" viewBox="0 0 15 14" fill="none"
          xmlns="http://www.w3.org/2000/svg">
           <path
           d="M3.62369 0.375183C3.48196 0.375183 3.34603 0.429119 3.2458 0.525126C3.14558 0.621132 3.08928 0.751346 3.08928 0.88712V1.66185H2.6279C2.06095 1.66185 1.51723 1.87759 1.11634 2.26162C0.715452 2.64565 0.490234 3.1665 0.490234 3.7096V11.7026C0.490234 12.2457 0.715452 12.7666 1.11634 13.1506C1.51723 13.5346 2.06095 13.7504 2.6279 13.7504H12.8424C13.4093 13.7504 13.953 13.5346 14.3539 13.1506C14.7548 12.7666 14.98 12.2457 14.98 11.7026V3.7096C14.98 3.1665 14.7548 2.64565 14.3539 2.26162C13.953 1.87759 13.4093 1.66185 12.8424 1.66185H12.381V0.88712C12.381 0.751346 12.3247 0.621132 12.2245 0.525126C12.1242 0.429119 11.9883 0.375183 11.8466 0.375183C11.7048 0.375183 11.5689 0.429119 11.4687 0.525126C11.3685 0.621132 11.3122 0.751346 11.3122 0.88712V1.66185H8.26955V0.88712C8.26955 0.751346 8.21324 0.621132 8.11302 0.525126C8.0128 0.429119 7.87687 0.375183 7.73513 0.375183C7.59339 0.375183 7.45746 0.429119 7.35724 0.525126C7.25702 0.621132 7.20071 0.751346 7.20071 0.88712V1.66185H4.15811V0.88712C4.15811 0.751346 4.1018 0.621132 4.00158 0.525126C3.90136 0.429119 3.76543 0.375183 3.62369 0.375183ZM13.9112 11.7026C13.9112 11.9742 13.7986 12.2346 13.5981 12.4266C13.3977 12.6186 13.1258 12.7265 12.8424 12.7265H2.6279C2.34443 12.7265 2.07256 12.6186 1.87212 12.4266C1.67167 12.2346 1.55907 11.9742 1.55907 11.7026V6.1157H13.9112V11.7026ZM7.20071 2.68572V3.46045C7.20071 3.59623 7.25702 3.72644 7.35724 3.82245C7.45746 3.91845 7.59339 3.97239 7.73513 3.97239C7.87687 3.97239 8.0128 3.91845 8.11302 3.82245C8.21324 3.72644 8.26955 3.59623 8.26955 3.46045V2.68572H11.3122V3.46045C11.3122 3.59623 11.3685 3.72644 11.4687 3.82245C11.5689 3.91845 11.7048 3.97239 11.8466 3.97239C11.9883 3.97239 12.1242 3.91845 12.2245 3.82245C12.3247 3.72644 12.381 3.59623 12.381 3.46045V2.68572H12.8424C13.1258 2.68572 13.3977 2.79359 13.5981 2.98561C13.7986 3.17762 13.9112 3.43805 13.9112 3.7096V5.09182H1.55907V3.7096C1.55907 3.43805 1.67167 3.17762 1.87212 2.98561C2.07256 2.79359 2.34443 2.68572 2.6279 2.68572H3.08928V3.46045C3.08928 3.59623 3.14558 3.72644 3.2458 3.82245C3.34603 3.91845 3.48196 3.97239 3.62369 3.97239C3.76543 3.97239 3.90136 3.91845 4.00158 3.82245C4.1018 3.72644 4.15811 3.59623 4.15811 3.46045V2.68572H7.20071Z"
           fill="#212121"></path>
          </svg>
          
         </span>
         <input class="form-control bg-white" placeholder="Date Range" type="text"
         name="datefilter" value="">
        </div> -->

                                <div class="input-group" style="width: fit-content;">
                                    <span class="input-group-text">
                                        <svg width="15" height="14" viewBox="0 0 15 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3.62369 0.375183C3.48196 0.375183 3.34603 0.429119 3.2458 0.525126C3.14558 0.621132 3.08928 0.751346 3.08928 0.88712V1.66185H2.6279C2.06095 1.66185 1.51723 1.87759 1.11634 2.26162C0.715452 2.64565 0.490234 3.1665 0.490234 3.7096V11.7026C0.490234 12.2457 0.715452 12.7666 1.11634 13.1506C1.51723 13.5346 2.06095 13.7504 2.6279 13.7504H12.8424C13.4093 13.7504 13.953 13.5346 14.3539 13.1506C14.7548 12.7666 14.98 12.2457 14.98 11.7026V3.7096C14.98 3.1665 14.7548 2.64565 14.3539 2.26162C13.953 1.87759 13.4093 1.66185 12.8424 1.66185H12.381V0.88712C12.381 0.751346 12.3247 0.621132 12.2245 0.525126C12.1242 0.429119 11.9883 0.375183 11.8466 0.375183C11.7048 0.375183 11.5689 0.429119 11.4687 0.525126C11.3685 0.621132 11.3122 0.751346 11.3122 0.88712V1.66185H8.26955V0.88712C8.26955 0.751346 8.21324 0.621132 8.11302 0.525126C8.0128 0.429119 7.87687 0.375183 7.73513 0.375183C7.59339 0.375183 7.45746 0.429119 7.35724 0.525126C7.25702 0.621132 7.20071 0.751346 7.20071 0.88712V1.66185H4.15811V0.88712C4.15811 0.751346 4.1018 0.621132 4.00158 0.525126C3.90136 0.429119 3.76543 0.375183 3.62369 0.375183ZM13.9112 11.7026C13.9112 11.9742 13.7986 12.2346 13.5981 12.4266C13.3977 12.6186 13.1258 12.7265 12.8424 12.7265H2.6279C2.34443 12.7265 2.07256 12.6186 1.87212 12.4266C1.67167 12.2346 1.55907 11.9742 1.55907 11.7026V6.1157H13.9112V11.7026ZM7.20071 2.68572V3.46045C7.20071 3.59623 7.25702 3.72644 7.35724 3.82245C7.45746 3.91845 7.59339 3.97239 7.73513 3.97239C7.87687 3.97239 8.0128 3.91845 8.11302 3.82245C8.21324 3.72644 8.26955 3.59623 8.26955 3.46045V2.68572H11.3122V3.46045C11.3122 3.59623 11.3685 3.72644 11.4687 3.82245C11.5689 3.91845 11.7048 3.97239 11.8466 3.97239C11.9883 3.97239 12.1242 3.91845 12.2245 3.82245C12.3247 3.72644 12.381 3.59623 12.381 3.46045V2.68572H12.8424C13.1258 2.68572 13.3977 2.79359 13.5981 2.98561C13.7986 3.17762 13.9112 3.43805 13.9112 3.7096V5.09182H1.55907V3.7096C1.55907 3.43805 1.67167 3.17762 1.87212 2.98561C2.07256 2.79359 2.34443 2.68572 2.6279 2.68572H3.08928V3.46045C3.08928 3.59623 3.14558 3.72644 3.2458 3.82245C3.34603 3.91845 3.48196 3.97239 3.62369 3.97239C3.76543 3.97239 3.90136 3.91845 4.00158 3.82245C4.1018 3.72644 4.15811 3.59623 4.15811 3.46045V2.68572H7.20071Z"
                                                fill="#212121"></path>
                                        </svg>
                                    </span>
                                    <!-- <input class="form-control custom-date-input flex-grow-1 bg-white p-2" type="text"
         placeholder="Date Range Filter" name="datefilter" id="daterangefilter"
         value=""> -->
                                    <input class="form-control bg-white" type="text" placeholder="Date Range Filter"
                                        name="datefilter" id="daterangefilter" value="">
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mb-5 dasboard-new__cards">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card py-2">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <div class="h6">Total Orders</div>
                                                <h3 class="fw-bold" id="totalorders">{{ $ordersCount }}</h3>
                                            </div>

                                            <div class="card-icon_wrapper">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="51" height="51"
                                                    viewBox="0 0 51 51" fill="none">
                                                    <rect width="50.5133" height="50.5133" rx="11.5752"
                                                        fill="#EBE0FF" />
                                                    <path
                                                        d="M36.9715 38.9862L35.0348 19.4243C34.9969 19.0113 34.6551 18.7109 34.2374 18.7109H30.5918V15.5194C30.5918 12.4781 28.0855 10 25.0096 10C21.9337 10 19.4273 12.4781 19.4273 15.5194V18.7109H15.7818C15.3641 18.7109 15.0223 19.0113 14.9843 19.4243L13.0097 39.0989C12.9717 39.3242 13.0477 39.5494 13.1995 39.7372C13.3514 39.9249 13.5793 40 13.8071 40H36.1741C36.6298 40 36.9715 39.6245 36.9715 39.2115C37.0095 39.0989 37.0095 39.0238 36.9715 38.9862ZM21.0602 15.4819C21.0602 13.3417 22.8071 11.577 25.0096 11.577C27.1741 11.577 28.9589 13.3041 28.9589 15.4819V18.6733H21.0602V15.4819ZM16.5413 20.2879H19.4653V21.9024C19.4653 22.3529 19.8451 22.6909 20.2628 22.6909C20.7185 22.6909 21.0602 22.3154 21.0602 21.9024V20.2879H28.9209V21.9024C28.9209 22.3529 29.3007 22.6909 29.7184 22.6909C30.1741 22.6909 30.5159 22.3154 30.5159 21.9024V20.2879H33.4399L34.9209 35.1564H15.0603L16.5413 20.2879ZM14.7185 38.3479L14.8704 36.771H35.1108L35.2627 38.3479H14.7185Z"
                                                        fill="#8C6FC0" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end">
                                        <div class="badge badge-blue totpcr">
                                            5.9%
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card py-2">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">

                                            <div>
                                                <div class="h6">Total Order Volume</div>
                                                <h3 class="fw-bold" id="totalweight">{{ $weightCount ?? 0 }}</h3>
                                            </div>

                                            <div class="card-icon_wrapper">
                                                <svg width="51" height="51" viewBox="0 0 51 51" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="51" height="51" rx="11.5752" fill="#daecdc" />
                                                    <path
                                                        d="M38.9935 32.449C38.9558 32.0674 38.7545 31.7362 38.4232 31.5181C37.9326 31.1953 37.2575 31.2791 36.8214 31.7194L34.3894 34.1515V20.838C34.3894 20.1462 33.8233 19.5801 33.1314 19.5801C32.4395 19.5801 31.8735 20.1462 31.8735 20.838V34.1515L29.4749 31.753C29.1982 31.4762 28.8334 31.3294 28.477 31.3294C28.2338 31.3294 27.9989 31.3965 27.8019 31.5349C27.4874 31.7571 27.2945 32.0884 27.2609 32.4616C27.2274 32.8348 27.3616 33.1954 27.6257 33.4596L30.0326 35.8665C30.5149 36.3487 31.039 36.6967 31.5883 36.9064C33.1775 37.5018 34.968 37.1203 36.1589 35.9336L38.6287 33.4638C38.8971 33.1954 39.0313 32.8264 38.9935 32.449Z"
                                                        fill="#003836" />
                                                    <path
                                                        d="M29.3535 12.0323H14.258C13.5661 12.0323 13 12.5984 13 13.2903C13 13.9822 13.5661 14.5483 14.258 14.5483H29.3535C30.0454 14.5483 30.6115 13.9822 30.6115 13.2903C30.6115 12.5984 30.0454 12.0323 29.3535 12.0323Z"
                                                        fill="#003836" />
                                                    <path
                                                        d="M25.9989 19.5801H14.258C13.5661 19.5801 13 20.1462 13 20.838C13 21.5299 13.5661 22.096 14.258 22.096H25.9989C26.6908 22.096 27.2569 21.5299 27.2569 20.838C27.2569 20.1462 26.6908 19.5801 25.9989 19.5801Z"
                                                        fill="#003836" />
                                                    <path
                                                        d="M22.6444 27.1279H14.258C13.5661 27.1279 13 27.694 13 28.3858C13 29.0777 13.5661 29.6438 14.258 29.6438H22.6444C23.3363 29.6438 23.9023 29.0777 23.9023 28.3858C23.9023 27.694 23.3363 27.1279 22.6444 27.1279Z"
                                                        fill="#003836" />
                                                    <path
                                                        d="M19.2898 34.6757H14.258C13.5661 34.6757 13 35.2417 13 35.9336C13 36.6255 13.5661 37.1916 14.258 37.1916H19.2898C19.9817 37.1916 20.5478 36.6255 20.5478 35.9336C20.5478 35.2417 19.9817 34.6757 19.2898 34.6757Z"
                                                        fill="#003836" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end">
                                        <div class="badge badge-orange orderwegpcr">
                                            5.9%
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card py-2">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">

                                            <div>
                                                <div class="h6">Total Projects</div>
                                                <h3 class="fw-bold" id="totalproject">{{ $projectCount }}</h3>
                                            </div>

                                            <div class="card-icon_wrapper">
                                                <svg width="51" height="51" viewBox="0 0 51 51"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="51" height="51" rx="11.5752"
                                                        fill="#EBF8EF" />
                                                    <path
                                                        d="M38.3324 14.6271H19.7693C19.4086 12.975 17.5218 12 15.7737 12C14.7748 12 13.8591 12.325 13.1931 12.8938C12.6659 13.3542 12 14.2479 12 15.7917V34.0458C12 34.0458 12 34.0458 12 34.0729V34.1C12 36.2667 13.8036 38 15.9956 38H16.0234H16.0511H38.3047C38.6932 38 38.9984 37.7021 38.9984 37.3229V15.3042C39.0261 14.925 38.6932 14.6271 38.3324 14.6271ZM13.3874 15.7917C13.3874 14.9521 13.6371 14.3292 14.1088 13.8958C14.525 13.5438 15.1077 13.3542 15.7737 13.3542C17.0778 13.3542 18.4652 14.1125 18.4652 15.2229V31.0396C17.7715 30.525 16.9391 30.2 15.9956 30.2C14.9967 30.2 14.0811 30.5521 13.3874 31.1479V15.7917ZM37.6387 36.6458H16.0511H16.0234H15.9956C14.5528 36.6458 13.3874 35.5083 13.3874 34.1C13.3874 32.7188 14.5528 31.5813 15.9956 31.5813C17.161 31.5813 18.1877 32.3396 18.4652 33.4229C18.5484 33.7479 18.8814 33.9646 19.2144 33.9375C19.5473 33.8833 19.8248 33.6125 19.8248 33.2604V15.9813H37.611V36.6458H37.6387ZM23.8205 32.5833H33.2824C33.6708 32.5833 33.9761 32.2854 33.9761 31.9062V24.1875C33.9761 23.9979 33.8928 23.8354 33.7541 23.7L29.2035 19.4479C28.9538 19.2042 28.5375 19.2042 28.2601 19.4208L23.3765 23.6729C23.2378 23.8083 23.1545 23.9979 23.1545 24.1875V31.9062C23.1268 32.2854 23.4597 32.5833 23.8205 32.5833ZM24.5142 24.4854L28.704 20.8563L32.5887 24.4854V31.2292H24.5142V24.4854Z"
                                                        fill="#18CE98" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end">
                                        <div class="badge badge-green ordpjpcr">
                                            5.9%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- <div class="row mb-5 dashboard-cards_wrapper">
                           <div class="col-12 d-flex justify-content-end align-items-lg-end mb-4">
                                <div class="input-group" style="width: fit-content;">
                                    <span class="input-group-text">
                                        <svg width="15" height="14" viewBox="0 0 15 14" fill="none"
          xmlns="http://www.w3.org/2000/svg">
                                            <path
           d="M3.62369 0.375183C3.48196 0.375183 3.34603 0.429119 3.2458 0.525126C3.14558 0.621132 3.08928 0.751346 3.08928 0.88712V1.66185H2.6279C2.06095 1.66185 1.51723 1.87759 1.11634 2.26162C0.715452 2.64565 0.490234 3.1665 0.490234 3.7096V11.7026C0.490234 12.2457 0.715452 12.7666 1.11634 13.1506C1.51723 13.5346 2.06095 13.7504 2.6279 13.7504H12.8424C13.4093 13.7504 13.953 13.5346 14.3539 13.1506C14.7548 12.7666 14.98 12.2457 14.98 11.7026V3.7096C14.98 3.1665 14.7548 2.64565 14.3539 2.26162C13.953 1.87759 13.4093 1.66185 12.8424 1.66185H12.381V0.88712C12.381 0.751346 12.3247 0.621132 12.2245 0.525126C12.1242 0.429119 11.9883 0.375183 11.8466 0.375183C11.7048 0.375183 11.5689 0.429119 11.4687 0.525126C11.3685 0.621132 11.3122 0.751346 11.3122 0.88712V1.66185H8.26955V0.88712C8.26955 0.751346 8.21324 0.621132 8.11302 0.525126C8.0128 0.429119 7.87687 0.375183 7.73513 0.375183C7.59339 0.375183 7.45746 0.429119 7.35724 0.525126C7.25702 0.621132 7.20071 0.751346 7.20071 0.88712V1.66185H4.15811V0.88712C4.15811 0.751346 4.1018 0.621132 4.00158 0.525126C3.90136 0.429119 3.76543 0.375183 3.62369 0.375183ZM13.9112 11.7026C13.9112 11.9742 13.7986 12.2346 13.5981 12.4266C13.3977 12.6186 13.1258 12.7265 12.8424 12.7265H2.6279C2.34443 12.7265 2.07256 12.6186 1.87212 12.4266C1.67167 12.2346 1.55907 11.9742 1.55907 11.7026V6.1157H13.9112V11.7026ZM7.20071 2.68572V3.46045C7.20071 3.59623 7.25702 3.72644 7.35724 3.82245C7.45746 3.91845 7.59339 3.97239 7.73513 3.97239C7.87687 3.97239 8.0128 3.91845 8.11302 3.82245C8.21324 3.72644 8.26955 3.59623 8.26955 3.46045V2.68572H11.3122V3.46045C11.3122 3.59623 11.3685 3.72644 11.4687 3.82245C11.5689 3.91845 11.7048 3.97239 11.8466 3.97239C11.9883 3.97239 12.1242 3.91845 12.2245 3.82245C12.3247 3.72644 12.381 3.59623 12.381 3.46045V2.68572H12.8424C13.1258 2.68572 13.3977 2.79359 13.5981 2.98561C13.7986 3.17762 13.9112 3.43805 13.9112 3.7096V5.09182H1.55907V3.7096C1.55907 3.43805 1.67167 3.17762 1.87212 2.98561C2.07256 2.79359 2.34443 2.68572 2.6279 2.68572H3.08928V3.46045C3.08928 3.59623 3.14558 3.72644 3.2458 3.82245C3.34603 3.91845 3.48196 3.97239 3.62369 3.97239C3.76543 3.97239 3.90136 3.91845 4.00158 3.82245C4.1018 3.72644 4.15811 3.59623 4.15811 3.46045V2.68572H7.20071Z"
           fill="#212121"></path>
          </svg>
         </span>
                                    <!-- <input class="form-control custom-date-input flex-grow-1 bg-white p-2" type="text"
         placeholder="Date Range Filter" name="datefilter" id="daterangefilter"
         value=""> -->
                        <!-- <input class="form-control bg-white" type="text"
         placeholder="Date Range Filter" name="datefilter" id="daterangefilter"
         value="">
        </div>
       </div>
                             <div class="col-12">
                                <div class="card p-2">
                                    <div class="card-body">
                                        <div class="row g-3 g-lg-4 dashboard__cards">
                                            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                                                <div class="card card1">
                                                    <div class="card-body">
                                                        <div class="text-center">
                                                            <div>Total Orders</div>
                                                            <div class="fs-5 fw-bold"><span class="fw-bold"
               id="totalorders">{{ $ordersCount }}</span></div>
              </div>
             </div>
            </div>
           </div>
                                            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                                                <div class="card card2">
                                                    <div class="card-body">
                                                        <div class="text-center">
                                                            <div>Total Order Volume</div>
                                                            <div class="fs-5 fw-bold"><span class="fw-bold"
                id="totalweight">{{ $weightCount ?? 0 }}</span>
               </div>
              </div>
             </div>
            </div>
           </div>
                                            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                                                <div class="card card3">
                                                    <div class="card-body">
                                                        <div class="text-center">
                                                            <div>Total Projects</div>
                                                            <div class="fs-5 fw-bold"><span class="fw-bold"
               id="totalproject">{{ $projectCount }}</span></div>
              </div>
             </div>
            </div>
           </div>
          </div>
         </div>
        </div>
       </div>
      </div> -->



                        <div class="row custom-card">
                            <div class="col-12">
                                <div class="card-style mb-30">
                                    <div
                                        class="title d-flex align-items-center gap-3 flex-wrap justify-content-between">
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <div class="fs-5 fw-semibold">Order Report </div>
                                            <div class="fs-6 text-secondary">(Volume vs Month)</div>
                                        </div>
                                        <div>
                                            <div class="input-group charts-input-group">
                                                <!--<span class="input-group-text">
             <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3.62369 0.375183C3.48196 0.375183 3.34603 0.429119 3.2458 0.525126C3.14558 0.621132 3.08928 0.751346 3.08928 0.88712V1.66185H2.6279C2.06095 1.66185 1.51723 1.87759 1.11634 2.26162C0.715452 2.64565 0.490234 3.1665 0.490234 3.7096V11.7026C0.490234 12.2457 0.715452 12.7666 1.11634 13.1506C1.51723 13.5346 2.06095 13.7504 2.6279 13.7504H12.8424C13.4093 13.7504 13.953 13.5346 14.3539 13.1506C14.7548 12.7666 14.98 12.2457 14.98 11.7026V3.7096C14.98 3.1665 14.7548 2.64565 14.3539 2.26162C13.953 1.87759 13.4093 1.66185 12.8424 1.66185H12.381V0.88712C12.381 0.751346 12.3247 0.621132 12.2245 0.525126C12.1242 0.429119 11.9883 0.375183 11.8466 0.375183C11.7048 0.375183 11.5689 0.429119 11.4687 0.525126C11.3685 0.621132 11.3122 0.751346 11.3122 0.88712V1.66185H8.26955V0.88712C8.26955 0.751346 8.21324 0.621132 8.11302 0.525126C8.0128 0.429119 7.87687 0.375183 7.73513 0.375183C7.59339 0.375183 7.45746 0.429119 7.35724 0.525126C7.25702 0.621132 7.20071 0.751346 7.20071 0.88712V1.66185H4.15811V0.88712C4.15811 0.751346 4.1018 0.621132 4.00158 0.525126C3.90136 0.429119 3.76543 0.375183 3.62369 0.375183ZM13.9112 11.7026C13.9112 11.9742 13.7986 12.2346 13.5981 12.4266C13.3977 12.6186 13.1258 12.7265 12.8424 12.7265H2.6279C2.34443 12.7265 2.07256 12.6186 1.87212 12.4266C1.67167 12.2346 1.55907 11.9742 1.55907 11.7026V6.1157H13.9112V11.7026ZM7.20071 2.68572V3.46045C7.20071 3.59623 7.25702 3.72644 7.35724 3.82245C7.45746 3.91845 7.59339 3.97239 7.73513 3.97239C7.87687 3.97239 8.0128 3.91845 8.11302 3.82245C8.21324 3.72644 8.26955 3.59623 8.26955 3.46045V2.68572H11.3122V3.46045C11.3122 3.59623 11.3685 3.72644 11.4687 3.82245C11.5689 3.91845 11.7048 3.97239 11.8466 3.97239C11.9883 3.97239 12.1242 3.91845 12.2245 3.82245C12.3247 3.72644 12.381 3.59623 12.381 3.46045V2.68572H12.8424C13.1258 2.68572 13.3977 2.79359 13.5981 2.98561C13.7986 3.17762 13.9112 3.43805 13.9112 3.7096V5.09182H1.55907V3.7096C1.55907 3.43805 1.67167 3.17762 1.87212 2.98561C2.07256 2.79359 2.34443 2.68572 2.6279 2.68572H3.08928V3.46045C3.08928 3.59623 3.14558 3.72644 3.2458 3.82245C3.34603 3.91845 3.48196 3.97239 3.62369 3.97239C3.76543 3.97239 3.90136 3.91845 4.00158 3.82245C4.1018 3.72644 4.15811 3.59623 4.15811 3.46045V2.68572H7.20071Z" fill="#212121"></path>
             </svg>
             
            </span>
            <input class="form-control" placeholder="Date Range" type="text" name="datefilter" value="">
            -->
                                                <input type="hidden" name="orderdata" id="orderdata"
                                                    value="{{ json_encode($totalWeightMonthly) }}">
                                                <input type="hidden" name="ordermonth" id="ordermonth"
                                                    value="{{ json_encode($monthNames) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Title -->
                                    <div class="chart Chart1div">
                                        <canvas id="Chart1"
                                            style="width: 100%; height: 400px; margin-left: -35px;"></canvas>
                                    </div>
                                    <!-- End Chart -->
                                </div>
                            </div>


                        </div>



                        <div class="row custom-card mt-5">
                            <div class="col-12">
                                <div class="card-style mb-30">
                                    <div
                                        class="title d-flex align-items-center gap-3 flex-wrap justify-content-between">
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <div class="fs-5 fw-semibold">Order Report </div>
                                            <div class="fs-6 text-secondary">(Project vs Volume vs Month)</div>
                                        </div>
                                        <div>
                                            <div class="input-group charts-input-group">
                                                <!--	<span class="input-group-text">
             <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3.62369 0.375183C3.48196 0.375183 3.34603 0.429119 3.2458 0.525126C3.14558 0.621132 3.08928 0.751346 3.08928 0.88712V1.66185H2.6279C2.06095 1.66185 1.51723 1.87759 1.11634 2.26162C0.715452 2.64565 0.490234 3.1665 0.490234 3.7096V11.7026C0.490234 12.2457 0.715452 12.7666 1.11634 13.1506C1.51723 13.5346 2.06095 13.7504 2.6279 13.7504H12.8424C13.4093 13.7504 13.953 13.5346 14.3539 13.1506C14.7548 12.7666 14.98 12.2457 14.98 11.7026V3.7096C14.98 3.1665 14.7548 2.64565 14.3539 2.26162C13.953 1.87759 13.4093 1.66185 12.8424 1.66185H12.381V0.88712C12.381 0.751346 12.3247 0.621132 12.2245 0.525126C12.1242 0.429119 11.9883 0.375183 11.8466 0.375183C11.7048 0.375183 11.5689 0.429119 11.4687 0.525126C11.3685 0.621132 11.3122 0.751346 11.3122 0.88712V1.66185H8.26955V0.88712C8.26955 0.751346 8.21324 0.621132 8.11302 0.525126C8.0128 0.429119 7.87687 0.375183 7.73513 0.375183C7.59339 0.375183 7.45746 0.429119 7.35724 0.525126C7.25702 0.621132 7.20071 0.751346 7.20071 0.88712V1.66185H4.15811V0.88712C4.15811 0.751346 4.1018 0.621132 4.00158 0.525126C3.90136 0.429119 3.76543 0.375183 3.62369 0.375183ZM13.9112 11.7026C13.9112 11.9742 13.7986 12.2346 13.5981 12.4266C13.3977 12.6186 13.1258 12.7265 12.8424 12.7265H2.6279C2.34443 12.7265 2.07256 12.6186 1.87212 12.4266C1.67167 12.2346 1.55907 11.9742 1.55907 11.7026V6.1157H13.9112V11.7026ZM7.20071 2.68572V3.46045C7.20071 3.59623 7.25702 3.72644 7.35724 3.82245C7.45746 3.91845 7.59339 3.97239 7.73513 3.97239C7.87687 3.97239 8.0128 3.91845 8.11302 3.82245C8.21324 3.72644 8.26955 3.59623 8.26955 3.46045V2.68572H11.3122V3.46045C11.3122 3.59623 11.3685 3.72644 11.4687 3.82245C11.5689 3.91845 11.7048 3.97239 11.8466 3.97239C11.9883 3.97239 12.1242 3.91845 12.2245 3.82245C12.3247 3.72644 12.381 3.59623 12.381 3.46045V2.68572H12.8424C13.1258 2.68572 13.3977 2.79359 13.5981 2.98561C13.7986 3.17762 13.9112 3.43805 13.9112 3.7096V5.09182H1.55907V3.7096C1.55907 3.43805 1.67167 3.17762 1.87212 2.98561C2.07256 2.79359 2.34443 2.68572 2.6279 2.68572H3.08928V3.46045C3.08928 3.59623 3.14558 3.72644 3.2458 3.82245C3.34603 3.91845 3.48196 3.97239 3.62369 3.97239C3.76543 3.97239 3.90136 3.91845 4.00158 3.82245C4.1018 3.72644 4.15811 3.59623 4.15811 3.46045V2.68572H7.20071Z" fill="#212121"></path>
             </svg>
             
            </span>
            <input class="form-control" placeholder="Date Range" type="text" name="datefilter" value="">
            -->

                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Title -->
                                    <div class="chart Chart2div">
                                        <canvas id="Chart2"></canvas>
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
    </section>

</main>
@endsection
@section('scripts')
<script src="{{ asset('frontend/lib/js/chart.min.js') }}"></script>
<script src="{{ asset('frontend/js/dashboard/dashboard.js') }}"></script>

<script>
    $('input[name="datefilter"]').daterangepicker();
</script>
@endsection
