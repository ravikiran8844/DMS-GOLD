@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Project Detail - Emerald DMS Dashboard
@endsection
@section('header')
    <link rel="stylesheet" href="{{ asset('backend/assets/bundles/dropzonejs/dropzone.css') }}">
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 px-4">
            <div class="h2 page-main-heading">Project Details</div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 p-4 m-auto">
            <div class="custom-nav-tabs">
                <ul class="nav nav-pills bg-white px-3" id="myTabNew" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active py-4" id="tab1" href="#content1" role="tab"
                            aria-controls="content1" aria-selected="true" disabled>Project Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-4" id="tab2" href="#content2" role="tab" aria-controls="content2"
                            aria-selected="false" disabled>Choose Category</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContentNew">
                    <div class="tab-pane fade active show" id="content1" role="tabpanel" aria-labelledby="tab1">
                        <div class="my-5">
                            <div class="row add-new-projects_wrapper">
                                <div class="col-12 col-lg-6 card">
                                    <div class="card-body text-dark">
                                        <div class="py-3">
                                            <div class="row file-upload_wrapper">
                                                <div
                                                    class="col-4 logo-wrapper d-flex justify-content-center align-items-center ">
                                                    <div class="h5">Logo</div>
                                                </div>
                                                <div class="col-8 px-0 file-uploader_container">
                                                    <form action="#" class="dropzone dz-clickable" id="mydropzone">

                                                        <div class="dz-default dz-message"><span>Drag & drop to change
                                                                logo</span></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="">Project Name<span class="required">*</span></label>
                                            <input class="text-dark form-control" type="text"
                                                placeholder="Project Name">
                                        </div>
                                        <div class="mb-4">
                                            <label for="">Website URL</label>
                                            <input placeholder="URL" class="text-dark form-control" type="text">
                                        </div>
                                        <div class="mb-4">
                                            <label for="">Location<span class="required">*</span></label>
                                            <input class="text-dark form-control" type="text"
                                                placeholder="City, District">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 card bg-transparent ">
                                    <div class="card-body text-dark">
                                        <div class="mb-4">
                                            <label for="">Project Starting Date<span
                                                    class="required">*</span></label>
                                            <input class="form-control bg-transparent " type="date" name=""
                                                id="">
                                        </div>
                                        <div class="mb-4">
                                            <label for="">Project Type</label>
                                            <select class="form-control bg-transparent" name="" id="">
                                                <option selected disabled value="">Project Type</option>
                                                <option value="">option 1</option>
                                                <option value="">option 2</option>
                                                <option value="">option 3</option>
                                                <option value="">option 4</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="">Project Starting Date<span
                                                    class="required">*</span></label>
                                            <input class="form-control bg-transparent " type="date" name=""
                                                id="">
                                        </div>
                                        <div class="mb-4">
                                            <label for="">Description</span></label>
                                            <textarea class="form-control bg-transparent" name="" id="" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="float-right">
                                <a href="#" class="btn px-4 py-2 next-button custom-orange-button"
                                    data-next="content2">Next To Choose Category</a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="content2" role="tabpanel" aria-labelledby="tab2">
                        <div class="my-5">
                            <div class="row add-new-projects_wrapper">
                                <div class="col-12 col-lg-6 card">
                                    <div class="card-body text-dark">
                                        <div class="mb-4">
                                            <label for="">Choose Category<span
                                                    class="required">*</span></label>
                                            <select class="form-control bg-transparent" name=""
                                                id="">
                                                <option selected disabled value="">Zilara</option>
                                                <option value="">option 1</option>
                                                <option value="">option 2</option>
                                                <option value="">option 3</option>
                                                <option value="">option 4</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <div>Drag & drop to Add Peoples Or Search</div>
                                        </div>
                                        <div class="mb-4">
                                            <ul
                                                class="list-unstyled avatar-tooltip-images_wrapper justify-content-start order-list m-b-0 m-b-0">
                                                <li class="team-member team-member-sm"><img class="rounded-circle"
                                                        src="{{ asset('backend/assets/img/users/user-3.png') }}"
                                                        alt="user" data-toggle="tooltip" title=""
                                                        data-original-title="Wildan Ahdian"></li>
                                                <li class="team-member team-member-sm"><img class="rounded-circle"
                                                        src="{{ asset('backend/assets/img/users/user-4.png') }}"
                                                        alt="user" data-toggle="tooltip" title=""
                                                        data-original-title="John Deo"></li>
                                                <li class="team-member team-member-sm"><img class="rounded-circle"
                                                        src="{{ asset('backend/assets/img/users/user-5.png') }}"
                                                        alt="user" data-toggle="tooltip" title=""
                                                        data-original-title="Sarah Smith"></li>
                                                <li class="team-member team-member-sm"><img class="rounded-circle"
                                                        src="{{ asset('backend/assets/img/users/user-2.png') }}"
                                                        alt="user" data-toggle="tooltip" title=""
                                                        data-original-title="John Smith"></li>
                                            </ul>
                                        </div>
                                        <div class="mb-4">
                                            <div>Assign role</div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="">Choose Category<span
                                                    class="required">*</span></label>
                                            <select class="form-control bg-transparent" name=""
                                                id="">
                                                <option selected value="">Zilara</option>
                                                <option value="">option 1</option>
                                                <option value="">option 2</option>
                                                <option value="">option 3</option>
                                                <option value="">option 4</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 card">
                                    <div class="card-body text-dark">
                                        <div class="mb-4">
                                            <label for="">Invoice Type<span class="required">*</span></label>
                                            <select class="form-control bg-transparent" name=""
                                                id="">
                                                <option selected value="">Auto Generated</option>
                                                <option value="">option 1</option>
                                                <option value="">option 2</option>
                                                <option value="">option 3</option>
                                                <option value="">option 4</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="">Invoice Time<span class="required">*</span></label>
                                            <select class="form-control bg-transparent" name=""
                                                id="">
                                                <option selected value="">30 Days</option>
                                                <option value="">option 1</option>
                                                <option value="">option 2</option>
                                                <option value="">option 3</option>
                                                <option value="">option 4</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="">Zilara Project Timeline<span
                                                    class="required">*</span></label>
                                            <div class="d-flex align-items-center">
                                                <span><i class="far fa-calendar-alt"></i></span>
                                                <input class="form-control custom-btn-border" type="text"
                                                    placeholder="Date Range" name="datefilter" value="">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="">Description</span></label>
                                            <textarea class="form-control bg-transparent" name="" id="" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a class="btn btn-outline-dark previous-button" href="#"
                                        data-previous="content1">Previous</a>
                                </div>
                                <div>
                                    <a href="#" class="px-3 py-2 btn btn-outline-dark mr-3">Add New Category</a>
                                    <a href="#" class="px-3 py-2 btn btn-success finish-project_btn">Finish
                                        Project</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('backend/assets/bundles/dropzonejs/min/dropzone.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/page/multiple-upload.js') }}"></script>
<script>
    $(document).ready(function() {
        $(".next-button").click(function() {
            var nextTabId = $(this).data("next");
            $('a[href="#' + nextTabId + '"]').tab('show');
        });

        $(".previous-button").click(function() {
            var previousTabId = $(this).data("previous");
            $('a[href="#' + previousTabId + '"]').tab('show');
        });
    });
</script>
@endsection
