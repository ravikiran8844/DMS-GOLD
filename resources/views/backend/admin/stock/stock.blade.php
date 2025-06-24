@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Stock - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row mt-2">
        <div class="col-12 mb-2 text-right">
            <span id="stock-status" class="badge p-2"></span><br>
            <small id="stock-uploaded-at" class="badge p-2 bg-success text-white mt-1"></small>
        </div>
        <div class="col-6 col-md-4 mb-4">
            <div class="h5 page-main-heading">Stock Maintenance</div>
        </div>
        <div class="col-6 col-md-8 mb-4 text-right">
            <!-- Button trigger modal -->
            <a data-bs-toggle="tooltip" data-placement="top" title="Sample Sheet" href="{{ url('downloadstock') }}"
                class="btn btn-success">Sample Sheet <i class="fas fa-download"></i></a>
            <button data-bs-toggle="tooltip" data-placement="top" title="Import" type="button" class="btn btn-success"
                data-toggle="modal" data-target="#importstock">Import</button>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="table-2_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                            <table class="table table-striped" id="stockTable">
                                <thead>
                                    <tr>
                                        <th>Product SKU</th>
                                        <th>Product Name</th>
                                        <th>Box</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($stock as $item)
                                        <tr>
                                            <td>{{ $item->product_unique_id }}</td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->style_name }}</td>
                                            <td>
                                                <form action="{{ route('stockupdate') }}" method="POST">
                                                    @csrf
                                                    <input type="text" name="qty" id="qty"
                                                        class="form-control" maxlength="50"
                                                        title="Please enter Quantity" value="{{ $item->qty }}">
                                            </td>
                                            <td>
                                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                                <button type="submit" title="Update"
                                                    class="btn btn-primary">Update</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('backend\assets\js\admin\stock\stock.js') }}"></script>
@endsection
<!-- Modal -->
<div class="modal fade" id="importstock" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Import Stock</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-body">
                <form action="{{ route('importstock') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file" class="form-control" name="stockimport" id="stockimport" required>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
