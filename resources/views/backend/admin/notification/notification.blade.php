@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Notifications - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="h2 page-main-heading">Notifications</div>
            <div class="fs-5">You’ve got 6 recommendations to solve.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex flex-wrap  justify-content-between align-items-center w-100">
                <div class="search_bar mb-4">
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
                <div class="d-flex flex-wrap">
                    <div class="mr-3  mb-4">
                        <a class="text-dark  h5" href="#"><i class="mr-2" data-feather="refresh-cw">
                            </i>Refresh</a>
                    </div>
                    <div class="mr-3  mb-4">
                        <a class="text-dark  h5" href="#"><i class="mr-2" data-feather="pie-chart">
                            </i>Report</a>
                    </div>
                    <div class="text-dark h5">
                        <div class="pretty p-switch p-fill">
                            <input type="checkbox" checked>
                            <div class="state p-success">
                                <label>Online</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table notifications-table">
                            <thead>
                                <tr>
                                    <th>Dealer ID</th>
                                    <th>Project & Order ID</th>
                                    <th>Order By</th>
                                    <th>Order Date</th>
                                    <th>Delivery Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="6" class="h5">New Orders (1)</th>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="text-dark h5">59628</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Zilara</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Premlata Silver LLP - Silver</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Mar 13, 2023</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">April 05, 2023</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div>
                                            <a class="badge bg-success text-white" href="#"> View</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <th colspan="6" class="h5">Work in Progress (3)</th>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="text-dark h5">59628</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Avana</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Jai Durga Jewellers - Silver</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Mar 13, 2023</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">April 05, 2023</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div>
                                            <a class="badge bg-danger text-white" href="#"> Starting</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="text-dark h5">59628</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Avana</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Jai Durga Jewellers - Silver</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Mar 13, 2023</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">April 05, 2023</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div>
                                            <a class="badge bg-danger text-white" href="#"> Starting</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="text-dark h5">59628</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Avana</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Jai Durga Jewellers - Silver</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Mar 13, 2023</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">April 05, 2023</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div>
                                            <a class="badge bg-danger text-white" href="#"> Starting</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <th colspan="6" class="h5">Ready For Delivery (2)</th>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="text-dark h5">59628</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Zilara</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Premlata Silver LLP - Silver</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Mar 13, 2023</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">April 05, 2023</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div>
                                            <a class="badge bg-primary text-white" href="#"> Arrived</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="text-dark h5">59628</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Zilara</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Premlata Silver LLP - Silver</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">Mar 13, 2023</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div class="text-dark h5">April 05, 2023</div>
                                        <div>View Order</div>
                                    </td>
                                    <td>
                                        <div>
                                            <a class="badge bg-primary text-white" href="#"> Arrived</a>
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
