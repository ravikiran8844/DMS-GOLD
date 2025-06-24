@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Orders - Emerald DMS Dashboard
@endsection


<section class="section">



    <div class="row">
      <div class="col-12 mb-4">
          <div class="h2 page-main-heading">Order Details</div>
      </div>
  </div>



  <div class="row">
    <div class="col-12 mb-4">
      <div class="d-flex flex-wrap  justify-content-between align-items-center w-100">
          <div class="d-flex">
            <div class="mr-3">
              <a href="/" class="btn btn-sm btn-outline-dark"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div>
              <div class="h4 text-dark">New Durga Jewellers - #999 5878</div>
              <div><b>Sub Dealer</b> - <span class="text-dark">Akshay Jewellery</span></div>

            </div>
          </div>

          <div class="d-flex flex-wrap align-items-center ">

              <div class="button-group custom-btn-border  bg-white">
                <button type="button" class="btn btn-default btn-sm dropdown-toggle text-dark  bg-white" data-toggle="dropdown">Status: <span class="text-success">Completed</span> <span class=" caret"></span></button>
                <ul id="designation-type" class="dropdown-menu custom-drop-down-checkboxes">
                  <li><a href="#" class="small" data-value="option1" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 1</a></li>
                  <li><a href="#" class="small" data-value="option2" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 2</a></li>
                  <li><a href="#" class="small" data-value="option3" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 3</a></li>
                  <li><a href="#" class="small" data-value="option4" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 4</a></li>
                  <li><a href="#" class="small" data-value="option5" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 5</a></li>
                  <li><a href="#" class="small" data-value="option6" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 6</a></li>
                </ul>
              </div>
              <div>
                  <a href="#" class="btn btn-lg btn-danger custom-orange-button">Download Invoice</a>
              </div>
          </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body order-details-page-table">
          <div class="fs-5 mb-2">Order Id : EJ/2324/00008089</div>
          <h4 class="text-dark mb-4">Order Details</h4>
          <div class="card">
            <div class="card-header">
              <h4>Projects Payments</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                  <thead>
                    <tr>
                      <th>ProductID</th>
                      <th>Product Name</th>
                      <th>Project</th>
                      <th>Purity</th>
                      <th>Color</th>
                      <th>Size</th>
                      <th>Style</th>
                      <th>Remarks</th>
                      <th>Quantity</th>
                      <th>Weight (in gms)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-dark">SFIDOL093-001</td>
                      <td>Silver Forming Idol </td>
                      <td>EF Idol</td>
                      <td  class="text-dark">SIL-99.9</td>
                      <td>-</td>
                      <td>Default</td>
                      <td>BX</td>
                      <td>ND1 SF SILVER IDOL 999 HOLO...</td>
                      <td  class="text-dark text-center">
                        <div>10</div>
                      </td>
                      <td  class="text-dark text-center">
                        <div>35.40</div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-dark">SFIDOL093-001</td>
                      <td>Silver Forming Idol </td>
                      <td>EF Idol</td>
                      <td  class="text-dark">SIL-99.9</td>
                      <td>-</td>
                      <td>Default</td>
                      <td>BX</td>
                      <td>ND1 SF SILVER IDOL 999 HOLO...</td>
                      <td  class="text-dark text-center">
                        <div>10</div>
                      </td>
                      <td  class="text-dark text-center">
                        <div>35.40</div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-dark">SFIDOL093-001</td>
                      <td>Silver Forming Idol </td>
                      <td>EF Idol</td>
                      <td  class="text-dark">SIL-99.9</td>
                      <td>-</td>
                      <td>Default</td>
                      <td>BX</td>
                      <td>ND1 SF SILVER IDOL 999 HOLO...</td>
                      <td  class="text-dark text-center">
                        <div>10</div>
                      </td>
                      <td  class="text-dark text-center">
                        <div>75.40</div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-dark">SFIDOL093-021</td>
                      <td>Silver Forming Idol </td>
                      <td>EF Idol</td>
                      <td  class="text-dark">SIL-99.9</td>
                      <td>-</td>
                      <td>Default</td>
                      <td>BX</td>
                      <td>ND1 SF SILVER IDOL 999 HOLO...</td>
                      <td  class="text-dark text-center">
                        <div>15</div>
                      </td>
                      <td  class="text-dark text-center">
                        <div>75.40</div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-dark">SFIDOL093-004</td>
                      <td>Silver Forming Idol </td>
                      <td>EF Idol</td>
                      <td  class="text-dark">SIL-99.9</td>
                      <td>-</td>
                      <td>Default</td>
                      <td>BX</td>
                      <td>ND1 SF SILVER IDOL 999 HOLO...</td>
                      <td  class="text-dark text-center">
                        <div>20</div>
                      </td>
                      <td  class="text-dark text-center">
                        <div>65.40</div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-6">
              <h4 class="text-dark mb-3">Timeline</h4>
              <div class="card  custom-cards">
                  
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-sm table-hover mb-0">
                        <thead>
                          <tr>
                            <th>Job card ID</th>
                            <th>Started Date</th>
                            <th>Lead Time</th>
                            <th>Due Date</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>999-5878</td>
                            <td>Aug 28, 2023</td>
                            <td>10:30 AM</td>
                            <td>Sep 05, 2023</td>
                            <td>
                              <div class="badge overdue d-flex align-items-center justify-content-center"><span class="mr-1">Overdue</span> <i class="fas fa-angle-down"></i></div>
                            </td>
                          </tr>
                          <tr>
                            <td>999-5878</td>
                            <td>Aug 28, 2023</td>
                            <td>10:30 AM</td>
                            <td>Sep 05, 2023</td>
                            <td>
                              <div class="badge pending d-flex align-items-center justify-content-center"><span class="mr-1">Pending</span> <i class="fas fa-angle-down"></i></div>
                            </td>
                          </tr>
                          <tr>
                            <td>999-5878</td>
                            <td>Aug 28, 2023</td>
                            <td>10:30 AM</td>
                            <td>Sep 05, 2023</td>
                            <td>
                              <div class="badge lifting d-flex align-items-center justify-content-center"><span class="mr-1">Lifting</span> <i class="fas fa-angle-down"></i></div>
                            </td>
                          </tr>
                          <tr>
                            <td>999-5878</td>
                            <td>Aug 28, 2023</td>
                            <td>10:30 AM</td>
                            <td>Sep 05, 2023</td>
                            <td>
                              <div class="badge starting d-flex align-items-center justify-content-center"><span class="mr-1">Starting</span> <i class="fas fa-angle-down"></i></div>
                            </td>
                          </tr>
                          <tr>
                            <td>999-5878</td>
                            <td>Aug 28, 2023</td>
                            <td>10:30 AM</td>
                            <td>Sep 05, 2023</td>
                            <td>
                              <div class="badge wip d-flex align-items-center justify-content-center"><span class="mr-1">WIP</span> <i class="fas fa-angle-down"></i></div>
                            </td>
                          </tr>
                          <tr>
                            <td>999-5878</td>
                            <td>Aug 28, 2023</td>
                            <td>10:30 AM</td>
                            <td>Sep 05, 2023</td>
                            <td>
                              <div class="badge overdue d-flex align-items-center justify-content-center"><span class="mr-1">Overdue</span> <i class="fas fa-angle-down"></i></div>
                            </td>
                          </tr>
                          <tr>
                            <td>999-5878</td>
                            <td>Aug 28, 2023</td>
                            <td>10:30 AM</td>
                            <td>Sep 05, 2023</td>
                            <td>
                              <div class="badge pending d-flex align-items-center justify-content-center"><span class="mr-1">Pending</span> <i class="fas fa-angle-down"></i></div>
                            </td>
                          </tr>
                          <tr>
                            <td>999-5878</td>
                            <td>Aug 28, 2023</td>
                            <td>10:30 AM</td>
                            <td>Sep 05, 2023</td>
                            <td>
                              <div class="badge starting d-flex align-items-center justify-content-center"><span class="mr-1">Starting</span> <i class="fas fa-angle-down"></i></div>
                            </td>
                          </tr>
                          <tr>
                            <td>999-5878</td>
                            <td>Aug 28, 2023</td>
                            <td>10:30 AM</td>
                            <td>Sep 05, 2023</td>
                            <td>
                              <div class="badge wip d-flex align-items-center justify-content-center"><span class="mr-1">WIP</span> <i class="fas fa-angle-down"></i></div>
                            </td>
                          </tr>
                          <tr>
                            <td>999-5878</td>
                            <td>Aug 28, 2023</td>
                            <td>10:30 AM</td>
                            <td>Sep 05, 2023</td>
                            <td>
                              <div class="badge wip d-flex align-items-center justify-content-center"><span class="mr-1">WIP</span> <i class="fas fa-angle-down"></i></div>
                            </td>
                          </tr>
                          <tr>
                            <td>999-5878</td>
                            <td>Aug 28, 2023</td>
                            <td>10:30 AM</td>
                            <td>Sep 05, 2023</td>
                            <td>
                              <div class="badge wip d-flex align-items-center justify-content-center"><span class="mr-1">WIP</span> <i class="fas fa-angle-down"></i></div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
              <h4 class="text-dark mb-3">Order information</h4>
              <div class="card card-secondary-bg custom-cards" style="background-color: #F5F6F6;border: 1px solid #E1E1E1">
                  <div class="card-body">
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-4 col-form-label">Order ID</label>
                      <div class="col-sm-8 m-auto">
                        <div class="d-flex justify-content-between">
                          <div><span  class="mr-2">:</span> <span>EJ/2324/00008089</span></div>
                          <div>
                            <a class="text-dark" href="#"><i class="fas fa-edit"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-4 col-form-label">Dealer Name</label>
                      <div class="col-sm-8 m-auto">
                        <div>
                          <div><span  class="mr-2">:</span> <span>New Durga Jewellers</span></div> 
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-4 col-form-label">Sub-Dealer Name</label>
                      <div class="col-sm-8 m-auto">
                        <div>
                          <div><span  class="mr-2">:</span> <span>Akshay Jewellery</span></div> 
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-4 col-form-label">Advance Received</label>
                      <div class="col-sm-8 m-auto">
                        <div>
                          <div><span  class="mr-2">:</span> <span>₹18,63,200.00</span></div> 
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-4 col-form-label">Total Credit Available</label>
                      <div class="col-sm-8 m-auto">
                        <div>
                          <div><span  class="mr-2">:</span> <span>₹80,12,200.00</span></div> 
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-4 col-form-label">Remarks</label>
                      <div class="col-sm-9 m-auto">
                        <div>
                          
                          <table class="table table-bordered">
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
                      </div>
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
@endsection
@section('scripts')
<script src="{{ asset('backend\assets\js\admin\order\order.js') }}"></script>
@endsection
