@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Emerald DMS Dashboard
@endsection
<span class="coming_soon">
<section class="section">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="h2 page-main-heading">Dealers Dashboard</div>
        </div>
    </div>


    <div class="row">
        <div class="col-12 mb-4 d-flex justify-content-between align-items-center">

            <div class="text-gray h6">
                Overview
            </div>
            <div>
                <div class="input-group custom-input-group">
                  <div class="m-auto">
                    <span>
                      <svg width="20" height="20" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.7826 0.972126H9.09423V0.447598C9.09423 0.200414 8.89382 0 8.64663 0C8.39945 0 8.19903 0.200414 8.19903 0.447598V0.972126H4.80096V0.447598C4.80096 0.200414 4.60055 0 4.35337 0C4.10618 0 3.90577 0.200414 3.90577 0.447598V0.972126H2.21744C0.994637 0.972126 0 1.96687 0 3.18968V9.45812C0 10.6648 0.981524 11.6463 2.18794 11.6463H10.8121C12.0185 11.6463 13 10.6648 13 9.45812V3.18968C13 1.96687 12.0054 0.972126 10.7826 0.972126ZM2.21744 1.86732H3.90577V2.12707C3.90577 2.37426 4.10618 2.57467 4.35337 2.57467C4.60055 2.57467 4.80096 2.37426 4.80096 2.12707V1.86732H8.19903V2.12707C8.19903 2.37426 8.39945 2.57467 8.64663 2.57467C8.89382 2.57467 9.09423 2.37426 9.09423 2.12707V1.86732H10.7826C11.5117 1.86732 12.1048 2.46048 12.1048 3.18968V3.61422H0.895195V3.18968C0.895195 2.46048 1.48835 1.86732 2.21744 1.86732ZM10.8121 10.7511H2.18794C1.47502 10.7511 0.895195 10.171 0.895195 9.45812V4.50942H12.1048V9.45812C12.1048 10.171 11.525 10.7511 10.8121 10.7511Z" fill="#F96421"></path>
                        <path d="M3.51084 5.83398H2.84207C2.59488 5.83398 2.39447 6.0344 2.39447 6.28158C2.39447 6.52877 2.59488 6.72918 2.84207 6.72918H3.51084C3.75803 6.72918 3.95844 6.52877 3.95844 6.28158C3.95844 6.0344 3.75803 5.83398 3.51084 5.83398Z" fill="#F96421"></path>
                        <path d="M6.83437 5.83398H6.1656C5.91842 5.83398 5.718 6.0344 5.718 6.28158C5.718 6.52877 5.91842 6.72918 6.1656 6.72918H6.83437C7.08156 6.72918 7.28197 6.52877 7.28197 6.28158C7.28197 6.0344 7.08156 5.83398 6.83437 5.83398Z" fill="#F96421"></path>
                        <path d="M10.1579 5.83398H9.48916C9.24198 5.83398 9.04156 6.0344 9.04156 6.28158C9.04156 6.52877 9.24198 6.72918 9.48916 6.72918H10.1579C10.4051 6.72918 10.6055 6.52877 10.6055 6.28158C10.6055 6.0344 10.4051 5.83398 10.1579 5.83398Z" fill="#F96421"></path>
                        <path d="M3.51084 8.12891H2.84207C2.59488 8.12891 2.39447 8.32932 2.39447 8.5765C2.39447 8.82369 2.59488 9.0241 2.84207 9.0241H3.51084C3.75803 9.0241 3.95844 8.82369 3.95844 8.5765C3.95844 8.32932 3.75803 8.12891 3.51084 8.12891Z" fill="#F96421"></path>
                        <path d="M6.83437 8.12891H6.1656C5.91842 8.12891 5.718 8.32932 5.718 8.5765C5.718 8.82369 5.91842 9.0241 6.1656 9.0241H6.83437C7.08156 9.0241 7.28197 8.82369 7.28197 8.5765C7.28197 8.32932 7.08156 8.12891 6.83437 8.12891Z" fill="#F96421"></path>
                        <path d="M10.1579 8.12891H9.48916C9.24198 8.12891 9.04156 8.32932 9.04156 8.5765C9.04156 8.82369 9.24198 9.0241 9.48916 9.0241H10.1579C10.4051 9.0241 10.6055 8.82369 10.6055 8.5765C10.6055 8.32932 10.4051 8.12891 10.1579 8.12891Z" fill="#F96421"></path>
                        </svg>
                        
                    </span>
                  </div>

                  <input class="form-control" type="text" placeholder="Date Range" name="datefilter" value="">
                </div>
              </div>
        </div>
    </div>

    <div class="row">


        <div class="col-12 col-md-6 col-xl dashboard-card_item">
            <div class="card dashboard-card dashboard-card_1">

                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5>120</h5>
                        <div class="text-success ">+5.9%</div>
                    </div>


                    <div class=" text-gray mt-3">Total Orders</div>
                </div>
            </div>
        </div>


        <div class="col-12 col-md-6 col-xl dashboard-card_item">
            <div class="card dashboard-card dashboard-card_2">

                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5>688,000</h5>
                        <div class="text-success ">+5.9%</div>
                    </div>


                    <div class=" text-gray mt-3">Total Order Volume</div>
                </div>
            </div>
        </div>



        <div class="col-12 col-md-6 col-xl dashboard-card_item">
            <div class="card dashboard-card dashboard-card_3">

                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5>400,000</h5>
                        <div class="text-success ">+5.9%</div>
                    </div>


                    <div class=" text-gray mt-3">Available Balance</div>
                </div>
            </div>
        </div>


        <div class="col-12 col-md-6 col-xl dashboard-card_item">
            <div class="card dashboard-card dashboard-card_4">

                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5>288,000</h5>
                        <div class="text-success ">+5.9%</div>
                    </div>


                    <div class=" text-gray mt-3">Pending Advance</div>
                </div>
            </div>
        </div>


        <div class="col-12 col-md-6 col-xl dashboard-card_item">
            <div class="card dashboard-card dashboard-card_5">

                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5>2</h5>
                        <div class="text-success ">+5.9%</div>
                    </div>


                    <div class=" text-gray mt-3">WIP Orders</div>
                </div>
            </div>
        </div>





    </div>


    <div class="row">
        <div class="col-12">
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
                                <button class="zone-btn dropdown-toggle" type="button" id="zone-dropdownMenuButton2"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
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
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                                class="custom-control-input" id="checkbox-all">
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
                                    <td class="toggle-container">
                                        <div class="d-flex">
                                            <div>
                                                <div class="text-dark ">Jai Durga Jewellers</div>
                                                <div>9th,Teachers Colony,..</div>
                                            </div>

                                            <div>
                                                <button onclick="toggleContent(this)" class="icon-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="13"
                                                        height="13" viewBox="0 0 13 13" fill="none">
                                                        <path
                                                            d="M6.75337 1.94538C6.4216 2.069 6.21777 2.41511 6.21777 2.85643C6.21777 3.17671 6.29108 3.38486 6.45811 3.53066C6.64111 3.69053 6.83303 3.70892 7.07053 3.59233C7.30398 3.47588 7.43896 3.29343 7.51862 2.98722C7.6862 2.33558 7.26326 1.76333 6.75337 1.94538Z"
                                                            fill="#7E7E7E" />
                                                        <path
                                                            d="M6.18529 4.15336C5.78075 4.23695 5.33631 4.57927 4.93529 5.11892C4.65127 5.4979 4.52765 5.76339 4.58215 5.86591C4.60393 5.90622 4.64383 5.93868 4.67358 5.93868C4.69928 5.93868 4.84833 5.74933 5.00495 5.51629C5.16143 5.2865 5.33631 5.05711 5.39474 5.00585C5.61331 4.82042 5.78494 4.94404 5.70433 5.23564C5.68648 5.31247 5.48928 5.96424 5.27423 6.68567C4.80789 8.23497 4.71294 8.64208 4.7097 9.09017C4.7097 9.37068 4.72038 9.43627 4.79315 9.54934C4.96113 9.82228 5.32915 9.85555 5.76979 9.64131C6.37112 9.342 7.23402 8.31112 7.1975 7.93215C7.19101 7.85884 7.1691 7.81542 7.13651 7.81542C7.08132 7.81542 7.03088 7.87764 6.6519 8.40268C6.32365 8.85402 6.11306 8.928 6.11306 8.58852C6.11306 8.50832 6.30214 7.77201 6.53153 6.94846C6.76091 6.12546 6.96907 5.34993 6.99098 5.2186C7.04629 4.91645 7.01694 4.55533 6.92511 4.4025C6.79743 4.18244 6.51679 4.0875 6.18529 4.15336Z"
                                                            fill="#7E7E7E" />
                                                        <path
                                                            d="M6.07589 12.1523C2.72531 12.1523 0 9.42606 0 6.07575C0 2.72545 2.72531 0 6.07589 0C9.42592 0 12.152 2.72531 12.152 6.07575C12.152 9.42619 9.42579 12.1523 6.07589 12.1523ZM6.07589 0.437132C2.96687 0.437132 0.437132 2.96687 0.437132 6.07575C0.437132 9.1845 2.96646 11.7146 6.07589 11.7146C9.18504 11.7146 11.7144 9.18531 11.7144 6.07575C11.7144 2.96646 9.18504 0.437132 6.07589 0.437132Z"
                                                            fill="#7E7E7E" />
                                                    </svg></button>
                                            </div>
                                        </div>

                                        <div class="hidden-content mt-3">
                                            <table class="table table-md">
                                                <tr>
                                                    <td>Dealer Name:</td>
                                                    <td>Jai Durga Jewellers... </td>
                                                </tr>
                                                <tr>
                                                    <td>Sub Dealer Name:</td>
                                                    <td>Akshay Jewellery</td>
                                                </tr>
                                                <tr>
                                                    <td>Remarks:</td>
                                                    <td></td>
                                                </tr>
                                            </table>

                                            <table class="mt-4 table table-md">
                                                <thead>
                                                    <tr>
                                                        <th>Operation ID</th>
                                                        <th>Comment</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Finish</td>
                                                        <td>Only Silver no Gold (Only Silver Idol)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alterations</td>
                                                        <td>Only air tight box</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Stone</td>
                                                        <td>Finishing as per images</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

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
                                    <td>
                                        <div class="dropdown custom-dropdown border-0 text-center">
                                            <div class="btn btn-sm sharp tp-btn" data-toggle="dropdown"
                                                aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="18px"
                                                    height="18px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
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
                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-115px, 28px, 0px);">
                                                <a class="dropdown-item" href="#">Option 1</a>
                                                <a class="dropdown-item" href="#">Option 2</a>
                                                <a class="dropdown-item" href="#">Option 3</a>
                                            </div>
                                        </div>
                                    </td>
                                    
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
                                    <td class="toggle-container">
                                        <div class="d-flex">
                                            <div>
                                                <div class="text-dark ">Jai Durga Jewellers</div>
                                                <div>9th,Teachers Colony,..</div>
                                            </div>

                                            <div>
                                                <button onclick="toggleContent(this)" class="icon-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="13"
                                                        height="13" viewBox="0 0 13 13" fill="none">
                                                        <path
                                                            d="M6.75337 1.94538C6.4216 2.069 6.21777 2.41511 6.21777 2.85643C6.21777 3.17671 6.29108 3.38486 6.45811 3.53066C6.64111 3.69053 6.83303 3.70892 7.07053 3.59233C7.30398 3.47588 7.43896 3.29343 7.51862 2.98722C7.6862 2.33558 7.26326 1.76333 6.75337 1.94538Z"
                                                            fill="#7E7E7E" />
                                                        <path
                                                            d="M6.18529 4.15336C5.78075 4.23695 5.33631 4.57927 4.93529 5.11892C4.65127 5.4979 4.52765 5.76339 4.58215 5.86591C4.60393 5.90622 4.64383 5.93868 4.67358 5.93868C4.69928 5.93868 4.84833 5.74933 5.00495 5.51629C5.16143 5.2865 5.33631 5.05711 5.39474 5.00585C5.61331 4.82042 5.78494 4.94404 5.70433 5.23564C5.68648 5.31247 5.48928 5.96424 5.27423 6.68567C4.80789 8.23497 4.71294 8.64208 4.7097 9.09017C4.7097 9.37068 4.72038 9.43627 4.79315 9.54934C4.96113 9.82228 5.32915 9.85555 5.76979 9.64131C6.37112 9.342 7.23402 8.31112 7.1975 7.93215C7.19101 7.85884 7.1691 7.81542 7.13651 7.81542C7.08132 7.81542 7.03088 7.87764 6.6519 8.40268C6.32365 8.85402 6.11306 8.928 6.11306 8.58852C6.11306 8.50832 6.30214 7.77201 6.53153 6.94846C6.76091 6.12546 6.96907 5.34993 6.99098 5.2186C7.04629 4.91645 7.01694 4.55533 6.92511 4.4025C6.79743 4.18244 6.51679 4.0875 6.18529 4.15336Z"
                                                            fill="#7E7E7E" />
                                                        <path
                                                            d="M6.07589 12.1523C2.72531 12.1523 0 9.42606 0 6.07575C0 2.72545 2.72531 0 6.07589 0C9.42592 0 12.152 2.72531 12.152 6.07575C12.152 9.42619 9.42579 12.1523 6.07589 12.1523ZM6.07589 0.437132C2.96687 0.437132 0.437132 2.96687 0.437132 6.07575C0.437132 9.1845 2.96646 11.7146 6.07589 11.7146C9.18504 11.7146 11.7144 9.18531 11.7144 6.07575C11.7144 2.96646 9.18504 0.437132 6.07589 0.437132Z"
                                                            fill="#7E7E7E" />
                                                    </svg></button>
                                            </div>
                                        </div>

                                        <div class="hidden-content mt-3">
                                            <table class="table table-md">
                                                <tr>
                                                    <td>Dealer Name:</td>
                                                    <td>Jai Durga Jewellers... </td>
                                                </tr>
                                                <tr>
                                                    <td>Sub Dealer Name:</td>
                                                    <td>Akshay Jewellery</td>
                                                </tr>
                                                <tr>
                                                    <td>Remarks:</td>
                                                    <td></td>
                                                </tr>
                                            </table>

                                            <table class="mt-4 table table-md">
                                                <thead>
                                                    <tr>
                                                        <th>Operation ID</th>
                                                        <th>Comment</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Finish</td>
                                                        <td>Only Silver no Gold (Only Silver Idol)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alterations</td>
                                                        <td>Only air tight box</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Stone</td>
                                                        <td>Finishing as per images</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </td>
                                    <td>Silver Chain (+3)</td>
                                    <td>448.81</td>
                                    <td>Mar 13, 2023</td>
                                    <td>Mar 13, 2023
                                    </td>
                                    <td>
                                        <div class="badge overdue">Overdue <i class="ml-2 fas fa-chevron-down"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown custom-dropdown border-0 text-center">
                                            <div class="btn btn-sm sharp tp-btn" data-toggle="dropdown"
                                                aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="18px"
                                                    height="18px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
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
                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-115px, 28px, 0px);">
                                                <a class="dropdown-item" href="#">Option 1</a>
                                                <a class="dropdown-item" href="#">Option 2</a>
                                                <a class="dropdown-item" href="#">Option 3</a>
                                            </div>
                                        </div>
                                    </td>
                                    
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
                                    <td class="toggle-container">
                                        <div class="d-flex">
                                            <div>
                                                <div class="text-dark ">Jai Durga Jewellers</div>
                                                <div>9th,Teachers Colony,..</div>
                                            </div>

                                            <div>
                                                <button onclick="toggleContent(this)" class="icon-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="13"
                                                        height="13" viewBox="0 0 13 13" fill="none">
                                                        <path
                                                            d="M6.75337 1.94538C6.4216 2.069 6.21777 2.41511 6.21777 2.85643C6.21777 3.17671 6.29108 3.38486 6.45811 3.53066C6.64111 3.69053 6.83303 3.70892 7.07053 3.59233C7.30398 3.47588 7.43896 3.29343 7.51862 2.98722C7.6862 2.33558 7.26326 1.76333 6.75337 1.94538Z"
                                                            fill="#7E7E7E" />
                                                        <path
                                                            d="M6.18529 4.15336C5.78075 4.23695 5.33631 4.57927 4.93529 5.11892C4.65127 5.4979 4.52765 5.76339 4.58215 5.86591C4.60393 5.90622 4.64383 5.93868 4.67358 5.93868C4.69928 5.93868 4.84833 5.74933 5.00495 5.51629C5.16143 5.2865 5.33631 5.05711 5.39474 5.00585C5.61331 4.82042 5.78494 4.94404 5.70433 5.23564C5.68648 5.31247 5.48928 5.96424 5.27423 6.68567C4.80789 8.23497 4.71294 8.64208 4.7097 9.09017C4.7097 9.37068 4.72038 9.43627 4.79315 9.54934C4.96113 9.82228 5.32915 9.85555 5.76979 9.64131C6.37112 9.342 7.23402 8.31112 7.1975 7.93215C7.19101 7.85884 7.1691 7.81542 7.13651 7.81542C7.08132 7.81542 7.03088 7.87764 6.6519 8.40268C6.32365 8.85402 6.11306 8.928 6.11306 8.58852C6.11306 8.50832 6.30214 7.77201 6.53153 6.94846C6.76091 6.12546 6.96907 5.34993 6.99098 5.2186C7.04629 4.91645 7.01694 4.55533 6.92511 4.4025C6.79743 4.18244 6.51679 4.0875 6.18529 4.15336Z"
                                                            fill="#7E7E7E" />
                                                        <path
                                                            d="M6.07589 12.1523C2.72531 12.1523 0 9.42606 0 6.07575C0 2.72545 2.72531 0 6.07589 0C9.42592 0 12.152 2.72531 12.152 6.07575C12.152 9.42619 9.42579 12.1523 6.07589 12.1523ZM6.07589 0.437132C2.96687 0.437132 0.437132 2.96687 0.437132 6.07575C0.437132 9.1845 2.96646 11.7146 6.07589 11.7146C9.18504 11.7146 11.7144 9.18531 11.7144 6.07575C11.7144 2.96646 9.18504 0.437132 6.07589 0.437132Z"
                                                            fill="#7E7E7E" />
                                                    </svg></button>
                                            </div>
                                        </div>

                                        <div class="hidden-content mt-3">
                                            <table class="table table-md">
                                                <tr>
                                                    <td>Dealer Name:</td>
                                                    <td>Jai Durga Jewellers... </td>
                                                </tr>
                                                <tr>
                                                    <td>Sub Dealer Name:</td>
                                                    <td>Akshay Jewellery</td>
                                                </tr>
                                                <tr>
                                                    <td>Remarks:</td>
                                                    <td></td>
                                                </tr>
                                            </table>

                                            <table class="mt-4 table table-md">
                                                <thead>
                                                    <tr>
                                                        <th>Operation ID</th>
                                                        <th>Comment</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Finish</td>
                                                        <td>Only Silver no Gold (Only Silver Idol)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alterations</td>
                                                        <td>Only air tight box</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Stone</td>
                                                        <td>Finishing as per images</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </td>
                                    <td>Silver Chain (+3)</td>
                                    <td>448.81</td>
                                    <td>Mar 13, 2023</td>
                                    <td>Mar 13, 2023
                                    </td>
                                    <td>
                                        <div class="badge pending">Pending <i class="ml-2 fas fa-chevron-down"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown custom-dropdown border-0 text-center">
                                            <div class="btn btn-sm sharp tp-btn" data-toggle="dropdown"
                                                aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="18px"
                                                    height="18px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
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
                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-115px, 28px, 0px);">
                                                <a class="dropdown-item" href="#">Option 1</a>
                                                <a class="dropdown-item" href="#">Option 2</a>
                                                <a class="dropdown-item" href="#">Option 3</a>
                                            </div>
                                        </div>
                                    </td>
                                    
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

        </div>
    </div>
</section>
</span>
@endsection
