@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Prodcut List - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="h5 page-main-heading">Product List</div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <select name="categoryfilter" id="categoryfilter" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <select name="subcategoryfilter" id="subcategoryfilter" class="form-control">
                                    <option value="">Select Sub Category</option>
                                    @foreach ($subcategory as $item)
                                        <option value="{{ $item->id }}">{{ $item->sub_category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="tableProduct">
                                <thead>
                                    <tr>
                                        </th>
                                        <th>S.No</th>
                                        <th>Image</th>
                                        <th>SKU</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Color</th>
                                        {{-- <th>Zone</th> --}}
                                        <th>Project</th>
                                        <th>Qty</th>
                                        <th>Weight (in gms)</th>
                                        <th>Status</th>
                                        <th>Action</th>
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
</section>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="editmodal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body add-products_page">
                <form action="{{ route('productupdate') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="productId" id="productId" value="">
                    <input type="hidden" name="productImage" id="productImage" value="">
                    <input type="hidden" name="productUniqueId" id="productUniqueId" value="">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Product SKU<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="product_unique_id" name="product_unique_id"
                                placeholder="Product SKU" required>
                            @error('product_unique_id')
                                <div class="text-danger">{{ $errors->first('product_unique_id') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Product Name<span class="text-danger">*</span></label>
                            <input type="text" name="product_name" id="product_name" class="form-control"
                                placeholder="Product Name" required>
                            @error('product_name')
                                <div class="text-danger">{{ $errors->first('product_name') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Product Thumbnail
                                {{-- <sup><strong>(458px * 440px)</strong></sup> --}}
                                <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center justify-content-between">
                                <input id="product_image" class="product-image" type="file" accept="image/*"
                                    name="product_image" required>
                                <div id="img-preview">
                                    <a href="" id="imglink" data-lightbox="uploaded-image-1"
                                        data-title="Selected Image"><img id="img" class="img-fluid ml-2"
                                            width="40" height="40" src="" /></a>
                                </div>
                                @error('product_image')
                                    <div class="text-danger">{{ $errors->first('product_image') }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <div class="upload__box">
                                <div class="upload__btn-box">
                                    <label class="upload__btn">
                                        <p class="m-0">Upload Images</p>
                                        <input type="file" id="product_multiple_image"
                                            name="product_multiple_image[]" multiple
                                            class="form-control upload__inputfile">
                                    </label>
                                </div>
                                <div class="upload__img-wrap">
                                </div>
                                @error('product_multiple_image')
                                    <div class="text-danger">{{ $errors->first('product_multiple_image') }}
                                    </div>
                                @enderror
                            </div>
                        </div> --}}
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Product Price<span class="text-danger">*</span></label>
                            <input id="product_price" class="form-control" type="text" name="product_price"
                                placeholder="Product Price" required>
                            @error('product_price')
                                <div class="text-danger">{{ $errors->first('product_price') }}
                                </div>
                            @enderror
                        </div> --}}
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Designed Date<span class="text-danger">*</span></label>
                            <input id="designed_date" class="form-control" type="date" name="designed_date"
                                value="{{ old('designed_date') }}" required>
                            @error('designed_date')
                                <div class="text-danger">{{ $errors->first('designed_date') }}
                                </div>
                            @enderror
                        </div> --}}
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Design Updated Date<span
                                    class="text-danger">*</span></label>
                            <input id="design_updated_date" class="form-control" type="date"
                                name="design_updated_date" required>
                            @error('design_updated_date')
                                <div class="text-danger">{{ $errors->first('design_updated_date') }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Height<span class="text-danger">*</span></label>
                            <input id="height" class="form-control" type="text" name="height"
                                placeholder="Height" required>
                            @error('height')
                                <div class="text-danger">{{ $errors->first('height') }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Depth</label>
                            <input id="depth" class="form-control" type="text" name="depth"
                                placeholder="Depth">
                            @error('depth')
                                <div class="text-danger">{{ $errors->first('depth') }}
                                </div>
                            @enderror
                        </div> --}}
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Density</label>
                            <input id="density" class="form-control" type="text" name="density"
                                placeholder="Density">
                            @error('density')
                                <div class="text-danger">{{ $errors->first('density') }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Width<span class="text-danger">*</span></label>
                            <input id="width" class="form-control" type="text" name="width"
                                placeholder="Width" required>
                            @error('width')
                                <div class="text-danger">{{ $errors->first('width') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Weight<span class="text-danger">*</span></label>
                            {{-- <select class="form-control" name="weight" id="weight" required>
                                <option disabled selected value="">Select Product Weight</option>
                                @foreach ($weight as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('weight') == $item->id ? 'selected' : '' }}>
                                        {{ $item->weight }}</option>
                                @endforeach
                            </select> --}}
                            <input id="weight" class="form-control" type="text" name="weight"
                                placeholder="Weight" required>
                            @error('weight')
                                <div class="text-danger">{{ $errors->first('weight') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Product Carat<span class="text-danger">*</span></label>
                            <input id="product_carat" class="form-control" type="text" name="product_carat"
                                placeholder="Product Carat" required>
                            @error('product_carat')
                                <div class="text-danger">{{ $errors->first('product_carat') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">product color<span class="text-danger">*</span></label>
                            <select class="form-control" name="product_color" id="product_color" required>
                                <option disabled selected value="">Select Product Color</option>
                                @foreach ($color as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->color_name }}</option>
                                @endforeach
                            </select>
                            @error('product_color')
                                <div class="text-danger">{{ $errors->first('product_color') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">product finish<span class="text-danger">*</span></label>
                            <select class="form-control" name="product_finish" id="product_finish" required>
                                <option disabled selected value="">Select Product Finish</option>
                                @foreach ($finish as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->finish_name }}</option>
                                @endforeach
                            </select>
                            @error('product_finish')
                                <div class="text-danger">{{ $errors->first('product_finish') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">product style<span class="text-danger">*</span></label>
                            <select class="form-control" name="product_style" id="product_style" required>
                                <option disabled selected value="">Select Product Style</option>
                                @foreach ($style as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->style_name }}</option>
                                @endforeach
                            </select>
                            @error('product_style')
                                <div class="text-danger">{{ $errors->first('product_style') }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Product Size<span class="text-danger">*</span></label>
                            <select class="form-control" name="size" id="size" required>
                                <option disabled selected value="">Select Product Size</option>
                                @foreach ($size as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('size') == $item->id ? 'selected' : '' }}>
                                        {{ $item->size }}</option>
                                @endforeach
                            </select>
                            @error('size')
                                <div class="text-danger">{{ $errors->first('size') }}
                                </div>
                            @enderror
                        </div> --}}
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Finishing</label>
                            <input id="finishing" class="form-control" type="text" name="finishing"
                                placeholder="Product Finishing">
                            @error('finishing')
                                <div class="text-danger">{{ $errors->first('finishing') }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Project<span class="text-danger">*</span></label>
                            <select class="form-control" name="project" id="project" required>
                                <option disabled selected value="">Select Project Type</option>
                                @foreach ($project as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->project_name }}</option>
                                @endforeach
                            </select>
                            @error('project')
                                <div class="text-danger">{{ $errors->first('project') }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Base Product</label>
                            <input id="base_product" class="form-control" type="text" name="base_product"
                                placeholder="Base Product">
                            @error('base_product')
                                <div class="text-danger">{{ $errors->first('base_product') }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Category<span class="text-danger">*</span></label>
                            <select class="form-control" name="category" id="category" required>
                                <option disabled selected value="">Select Category Name</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="text-danger">{{ $errors->first('category') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Sub Category<span class="text-danger">*</span></label>
                            <select class="form-control" name="subcategory" id="subcategory" required>
                                <option disabled selected value="">Select Sub Category Name</option>
                            </select>
                            @error('subcategory')
                                <div class="text-danger">{{ $errors->first('subcategory') }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Collection<span class="text-danger">*</span></label>
                            <select class="form-control" name="collection" id="collection" required>
                                <option disabled selected value="">Select Collection</option>
                                @foreach ($collection as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('collection') == $item->id ? 'selected' : '' }}>
                                        {{ $item->collection_name }}</option>
                                @endforeach
                            </select>
                            @error('collection')
                                <div class="text-danger">{{ $errors->first('collection') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Sub Collection<span class="text-danger">*</span></label>
                            <select class="form-control" name="sub_collection" id="sub_collection" required>
                                <option disabled selected value="">Select Sub Collection</option>
                            </select>
                            @error('sub_collection')
                                <div class="text-danger">{{ $errors->first('sub_collection') }}
                                </div>
                            @enderror
                        </div> --}}
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Zone<span class="text-danger">*</span></label>
                            <select class="form-control" name="zone" id="zone" required>
                                <option disabled selected value="">Select Zone</option>
                                @foreach ($zone as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->zone_name }}</option>
                                @endforeach
                            </select>
                            @error('zone')
                                <div class="text-danger">{{ $errors->first('zone') }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Metal Type<span class="text-danger">*</span></label>
                            <select class="form-control" name="metal" id="metal" required>
                                <option disabled selected value="">Select Metal Type</option>
                                @foreach ($metal as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('metal') == $item->id ? 'selected' : '' }}>
                                        {{ $item->metal_name }}</option>
                                @endforeach
                            </select>
                            @error('metal')
                                <div class="text-danger">{{ $errors->first('metal') }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Brand Name<span class="text-danger">*</span></label>
                            <select class="form-control" name="brand" id="brand" required>
                                <option disabled selected value="">Select Collection</option>
                                @foreach ($brand as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('brand') == $item->id ? 'selected' : '' }}>
                                        {{ $item->brand_name }}</option>
                                @endforeach
                            </select>
                            @error('brand')
                                <div class="text-danger">{{ $errors->first('brand') }}
                                </div>
                            @enderror
                        </div> --}}
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Jewel Type<span class="text-danger">*</span></label>
                            <select class="form-control" name="jewel" id="jewel" required>
                                <option disabled selected value="">Select Jewel Type</option>
                                @foreach ($jewelTypes as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('jewel') == $item->id ? 'selected' : '' }}>
                                        {{ $item->jewel_type }}</option>
                                @endforeach
                            </select>
                            @error('jewel')
                                <div class="text-danger">{{ $errors->first('jewel') }}
                                </div>
                            @enderror
                        </div> --}}
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Silver Purity<span class="text-danger">*</span></label>
                            <select class="form-control" name="purity" id="purity" required>
                                <option disabled selected value="">Select Silver Purity</option>
                                @foreach ($sivlerPurities as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('purity') == $item->id ? 'selected' : '' }}>
                                        {{ $item->silver_purity_percentage }}</option>
                                @endforeach
                            </select>
                            @error('purity')
                                <div class="text-danger">{{ $errors->first('purity') }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Plating</label>
                            <select class="form-control" name="plating" id="plating" required>
                                <option disabled selected value="">Select Product Plating </option>
                                @foreach ($plating as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('plating') == $item->id ? 'selected' : '' }}>
                                        {{ $item->plating_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Shape</label>
                            <input id="shape" class="form-control" type="text" name="shape"
                                placeholder="Shape" value="{{ old('shape') }}">
                            @error('shape')
                                <div class="text-danger">{{ $errors->first('shape') }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Making Percent</label>
                            <input id="making_percent" class="form-control" type="text" name="making_percent"
                                placeholder="Making percent">
                            @error('making_percent')
                                <div class="text-danger">{{ $errors->first('making_percent') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">MOQ<span class="text-danger">*</span></label>
                            <input id="moq" class="form-control" type="text" name="moq"
                                placeholder="MOQ" required>
                            @error('moq')
                                <div class="text-danger">{{ $errors->first('moq') }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">HallMarking<span class="text-danger">*</span></label>
                            <input id="hallmarking" class="form-control" type="text" name="hallmarking"
                                placeholder="HallMarking" required>
                            @error('hallmarking')
                                <div class="text-danger">{{ $errors->first('hallmarking') }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">crwcolcode</label>
                            <input id="crwcolcode" class="form-control" type="text" name="crwcolcode"
                                placeholder="crwcolcode">
                            @error('crwcolcode')
                                <div class="text-danger">{{ $errors->first('crwcolcode') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">crwsubcolcode</label>
                            <input id="crwsubcolcode" class="form-control" type="text" name="crwsubcolcode"
                                placeholder="crwsubcolcode">
                            @error('crwsubcolcode')
                                <div class="text-danger">{{ $errors->first('crwsubcolcode') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Gender</label>
                            <select class="form-control" name="gender" id="gender">
                                <option disabled selected value="">Select Gender</option>
                                <option value="Male"> Male
                                </option>
                                <option value="Female">
                                    Female</option>
                            </select>
                            @error('gender')
                                <div class="text-danger">{{ $errors->first('gender') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">cwqty</label>
                            <input id="cwqty" class="form-control" type="text" name="cwqty"
                                placeholder="cwqty">
                            @error('cwqty')
                                <div class="text-danger">{{ $errors->first('cwqty') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">qty<span class="text-danger">*</span></label>
                            <input id="qty" class="form-control" type="text" name="qty"
                                placeholder="qty" required>
                            @error('qty')
                                <div class="text-danger">{{ $errors->first('qty') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Unit<span class="text-danger">*</span></label>
                            <select class="form-control" name="unit" id="unit" required>
                                <option disabled selected value="">Select Unit</option>
                                @foreach ($unit as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->unit_name }}</option>
                                @endforeach
                            </select>
                            @error('unit')
                                <div class="text-danger">{{ $errors->first('unit') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Net Weight<span class="text-danger">*</span></label>
                            <input id="net_weight" class="form-control" type="text" name="net_weight"
                                placeholder="Net Weight" required>
                            @error('net_weight')
                                <div class="text-danger">{{ $errors->first('net_weight') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Keyword Tags</label>
                            <input id="keywordtags" class="form-control inputtags" type="text" name="keywordtags"
                                placeholder="Keyword Tags">
                            @error('keywordtags')
                                <div class="text-danger">{{ $errors->first('keywordtags') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <label class="fs-5 form-label">Other Rate</label>
                            <input id="otherrate" class="form-control" type="text" name="otherrate"
                                placeholder="Other Rate">
                            @error('otherrate')
                                <div class="text-danger">{{ $errors->first('otherrate') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button class="btn btn-warning custom-orange-button mr-3 px-3">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script src="{{ asset('backend\assets\js\admin\master\product\productlist.js') }}"></script>
@endsection
@endsection
