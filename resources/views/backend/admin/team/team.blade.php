@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Team - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="h2 page-main-heading">Team</div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex flex-wrap  justify-content-between align-items-center w-100">
                <div class="search_bar">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="bg-transparent border-0  input-group-text h-100" id="inputGroupPrepend2">
                                <i data-feather="search"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control border-0  bg-transparent"
                            placeholder="Search anything...">
                        <div class="input-group-prepend">
                            <span class="bg-transparent border-0  input-group-text h-100" id="inputGroupPrepend2">
                                <svg width="15" height="10" viewBox="0 0 15 10" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.4167 5.83333C9.4088 5.83333 8.56808 6.54903 8.37502 7.49992L0.416667 7.5C0.186548 7.5 0 7.68655 0 7.91667C0 8.14678 0.186548 8.33333 0.416667 8.33333L8.37511 8.33383C8.56833 9.28452 9.40894 10 10.4167 10C11.4244 10 12.265 9.28452 12.4582 8.33383L14.5833 8.33333C14.8135 8.33333 15 8.14678 15 7.91667C15 7.68655 14.8135 7.5 14.5833 7.5L12.4583 7.49992C12.2653 6.54903 11.4245 5.83333 10.4167 5.83333ZM10.4167 6.66667C11.107 6.66667 11.6667 7.22631 11.6667 7.91667C11.6667 8.60702 11.107 9.16667 10.4167 9.16667C9.72631 9.16667 9.16667 8.60702 9.16667 7.91667C9.16667 7.22631 9.72631 6.66667 10.4167 6.66667ZM4.58333 0C3.57546 0 2.73475 0.715696 2.54169 1.66659L0.416667 1.66667C0.186548 1.66667 0 1.85321 0 2.08333C0 2.31345 0.186548 2.5 0.416667 2.5L2.54178 2.5005C2.735 3.45118 3.57561 4.16667 4.58333 4.16667C5.59106 4.16667 6.43167 3.45118 6.62489 2.5005L14.5833 2.5C14.8135 2.5 15 2.31345 15 2.08333C15 1.85321 14.8135 1.66667 14.5833 1.66667L6.62498 1.66659C6.43192 0.715696 5.5912 0 4.58333 0ZM4.58333 0.833333C5.27369 0.833333 5.83333 1.39298 5.83333 2.08333C5.83333 2.77369 5.27369 3.33333 4.58333 3.33333C3.89298 3.33333 3.33333 2.77369 3.33333 2.08333C3.33333 1.39298 3.89298 0.833333 4.58333 0.833333Z"
                                        fill="#212121" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center ">
                    <div class="button-group custom-btn-border bg-transparent">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle  bg-transparent"
                            data-toggle="dropdown">Designation Type <span class=" caret"></span></button>
                        <ul id="designation-type" class="dropdown-menu custom-drop-down-checkboxes">
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
                            data-toggle="dropdown">Order Delay <span class=" caret"></span></button>
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
                            data-toggle="dropdown">Lifting Pending <span class=" caret"></span></button>
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
                    <div>
                        <a href="#" class="btn btn-success"><i class="fas fa-plus-circle"></i> Add
                            Stackholder</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header justify-content-end">
                    <div class="d-flex align-items-end">
                        <div><a class="custom-view-all-link" href="#">View all Stackholders</a></div>
                        <div class="ml-3 dropdown custom-dropdown show">
                            <div class="btn btn-sm sharp tp-btn" data-toggle="dropdown" aria-expanded="true">
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
                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-120px, 40px, 0px);">
                                <a class="dropdown-item" href="#">Option 1</a>
                                <a class="dropdown-item" href="#">Option 2</a>
                                <a class="dropdown-item" href="#">Option 3</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-2">
                            <thead>
                                <tr>
                                    <th class="text-center pt-3">
                                        <div class="custom-checkbox custom-checkbox-table custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                                class="custom-control-input" id="checkbox-all">
                                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>Employee ID</th>
                                    <th>Dealer Name</th>
                                    <th>CRM</th>
                                    <th>Designation</th>
                                    <th>Status</th>
                                    <th>Mobile Number</th>
                                    <th>Action</th>
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
                                    <td>Premlata Silver L..</td>
                                    <td>CRM</td>
                                    <td>Manager</td>
                                    <td>
                                        <div class="badge transparent-badge-with-border"><i
                                                class="fa fa-solid fa-circle"></i> Offline</div>
                                    </td>
                                    <td>+91 90876 54321</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="text-success mr-2">
                                                <img src="{{ asset('backend/assets/img/icons/edit-pen.png') }}"
                                                    alt=""></a>
                                            <a href="#" class="text-danger">
                                                <img src="{{ asset('backend/assets/img/icons/trash-bin.png') }}"
                                                    alt=""></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center pt-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup"
                                                class="custom-control-input" id="checkbox-1">
                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>999-5878</td>
                                    <td>K D Coin Craft.</td>
                                    <td>CRM</td>
                                    <td>Manager</td>
                                    <td>
                                        <div class="badge badge-dark badge-shadow"><i
                                                class="fa fa-solid fa-circle"></i> Active</div>
                                    </td>
                                    <td>+91 90876 54321</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="text-success mr-2">
                                                <img src="{{ asset('backend/assets/img/icons/edit-pen.png') }}"
                                                    alt=""></a>
                                            <a href="#" class="text-danger">
                                                <img src="{{ asset('backend/assets/img/icons/trash-bin.png') }}"
                                                    alt=""></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center pt-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup"
                                                class="custom-control-input" id="checkbox-1">
                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>999-5878</td>
                                    <td>Chandi Bazar</td>
                                    <td>CRM</td>
                                    <td>Manager</td>
                                    <td>
                                        <div class="badge badge-dark badge-shadow"><i
                                                class="fa fa-solid fa-circle"></i> Active</div>
                                    </td>
                                    <td>+91 90876 54321</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="text-success mr-2">
                                                <img src="{{ asset('backend/assets/img/icons/edit-pen.png') }}"
                                                    alt=""></a>
                                            <a href="#" class="text-danger">
                                                <img src="{{ asset('backend/assets/img/icons/trash-bin.png') }}"
                                                    alt=""></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center pt-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup"
                                                class="custom-control-input" id="checkbox-1">
                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>999-5878</td>
                                    <td>Jai Durga Jewell...</td>
                                    <td>CRM</td>
                                    <td>Manager</td>
                                    <td>
                                        <div class="badge badge-dark badge-shadow"><i
                                                class="fa fa-solid fa-circle"></i> Active</div>
                                    </td>
                                    <td>+91 90876 54321</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="text-success mr-2">
                                                <img src="{{ asset('backend/assets/img/icons/edit-pen.png') }}"
                                                    alt=""></a>
                                            <a href="#" class="text-danger">
                                                <img src="{{ asset('backend/assets/img/icons/trash-bin.png') }}"
                                                    alt=""></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center pt-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup"
                                                class="custom-control-input" id="checkbox-1">
                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>999-5878</td>
                                    <td>Premlata Silver L..</td>
                                    <td>CRM</td>
                                    <td>Manager</td>
                                    <td>
                                        <div class="badge transparent-badge-with-border"><i
                                                class="fa fa-solid fa-circle"></i> Offline</div>
                                    </td>
                                    <td>+91 90876 54321</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="text-success mr-2">
                                                <img src="{{ asset('backend/assets/img/icons/edit-pen.png') }}"
                                                    alt=""></a>
                                            <a href="#" class="text-danger">
                                                <img src="{{ asset('backend/assets/img/icons/trash-bin.png') }}"
                                                    alt=""></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center pt-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup"
                                                class="custom-control-input" id="checkbox-1">
                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>999-5878</td>
                                    <td>K D Coin Craft.</td>
                                    <td>CRM</td>
                                    <td>Manager</td>
                                    <td>
                                        <div class="badge badge-dark badge-shadow"><i
                                                class="fa fa-solid fa-circle"></i> Active</div>
                                    </td>
                                    <td>+91 90876 54321</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="text-success mr-2">
                                                <img src="{{ asset('backend/assets/img/icons/edit-pen.png') }}"
                                                    alt=""></a>
                                            <a href="#" class="text-danger">
                                                <img src="{{ asset('backend/assets/img/icons/trash-bin.png') }}"
                                                    alt=""></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center pt-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup"
                                                class="custom-control-input" id="checkbox-1">
                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>999-5878</td>
                                    <td>Chandi Bazar</td>
                                    <td>CRM</td>
                                    <td>Manager</td>
                                    <td>
                                        <div class="badge badge-dark badge-shadow"><i
                                                class="fa fa-solid fa-circle"></i> Active</div>
                                    </td>
                                    <td>+91 90876 54321</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="text-success mr-2">
                                                <img src="{{ asset('backend/assets/img/icons/edit-pen.png') }}"
                                                    alt=""></a>
                                            <a href="#" class="text-danger">
                                                <img src="{{ asset('backend/assets/img/icons/trash-bin.png') }}"
                                                    alt=""></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center pt-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup"
                                                class="custom-control-input" id="checkbox-1">
                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>999-5878</td>
                                    <td>Jai Durga Jewell...</td>
                                    <td>CRM</td>
                                    <td>Manager</td>
                                    <td>
                                        <div class="badge badge-dark badge-shadow"><i
                                                class="fa fa-solid fa-circle"></i> Active</div>
                                    </td>
                                    <td>+91 90876 54321</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="text-success mr-2">
                                                <img src="{{ asset('backend/assets/img/icons/edit-pen.png') }}"
                                                    alt=""></a>
                                            <a href="#" class="text-danger">
                                                <img src="{{ asset('backend/assets/img/icons/trash-bin.png') }}"
                                                    alt=""></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center pt-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup"
                                                class="custom-control-input" id="checkbox-1">
                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>999-5878</td>
                                    <td>Premlata Silver L..</td>
                                    <td>CRM</td>
                                    <td>Manager</td>
                                    <td>
                                        <div class="badge transparent-badge-with-border"><i
                                                class="fa fa-solid fa-circle"></i> Offline</div>
                                    </td>
                                    <td>+91 90876 54321</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="text-success mr-2">
                                                <img src="{{ asset('backend/assets/img/icons/edit-pen.png') }}"
                                                    alt=""></a>
                                            <a href="#" class="text-danger">
                                                <img src="{{ asset('backend/assets/img/icons/trash-bin.png') }}"
                                                    alt=""></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center pt-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup"
                                                class="custom-control-input" id="checkbox-1">
                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>999-5878</td>
                                    <td>K D Coin Craft.</td>
                                    <td>CRM</td>
                                    <td>Manager</td>
                                    <td>
                                        <div class="badge badge-dark badge-shadow"><i
                                                class="fa fa-solid fa-circle"></i> Active</div>
                                    </td>
                                    <td>+91 90876 54321</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="text-success mr-2">
                                                <img src="{{ asset('backend/assets/img/icons/edit-pen.png') }}"
                                                    alt=""></a>
                                            <a href="#" class="text-danger">
                                                <img src="{{ asset('backend/assets/img/icons/trash-bin.png') }}"
                                                    alt=""></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center pt-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup"
                                                class="custom-control-input" id="checkbox-1">
                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>999-5878</td>
                                    <td>Chandi Bazar</td>
                                    <td>CRM</td>
                                    <td>Manager</td>
                                    <td>
                                        <div class="badge badge-dark badge-shadow"><i
                                                class="fa fa-solid fa-circle"></i> Active</div>
                                    </td>
                                    <td>+91 90876 54321</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="text-success mr-2">
                                                <img src="{{ asset('backend/assets/img/icons/edit-pen.png') }}"
                                                    alt=""></a>
                                            <a href="#" class="text-danger">
                                                <img src="{{ asset('backend/assets/img/icons/trash-bin.png') }}"
                                                    alt=""></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center pt-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup"
                                                class="custom-control-input" id="checkbox-1">
                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>999-5878</td>
                                    <td>Jai Durga Jewell...</td>
                                    <td>CRM</td>
                                    <td>Manager</td>
                                    <td>
                                        <div class="badge badge-dark badge-shadow"><i
                                                class="fa fa-solid fa-circle"></i> Active</div>
                                    </td>
                                    <td>+91 90876 54321</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="text-success mr-2">
                                                <img src="{{ asset('backend/assets/img/icons/edit-pen.png') }}"
                                                    alt=""></a>
                                            <a href="#" class="text-danger">
                                                <img src="{{ asset('backend/assets/img/icons/trash-bin.png') }}"
                                                    alt=""></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
