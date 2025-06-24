<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Imports\ImportProduct;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Finish;
use App\Models\JewelType;
use App\Models\MetalType;
use App\Models\Plating;
use App\Models\ProductMultipleImage;
use App\Models\Product;
use App\Models\Project;
use App\Models\SilverPurity;
use App\Models\Size;
use App\Models\Style;
use App\Models\SubCategory;
use App\Models\SubCollection;
use App\Models\Unit;
use App\Models\Weight;
use App\Models\Zone;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    use Common;

    function product()
    {
        $color = Color::where('is_active', 1)->whereNull('deleted_at')->get();
        $finish = Finish::where('is_active', 1)->whereNull('deleted_at')->get();
        $project = Project::where('is_active', 1)->whereNull('deleted_at')->get();
        $category = Category::where('is_active', 1)->whereNull('deleted_at')->get();
        $subcategory = SubCategory::where('is_active', 1)->whereNull('deleted_at')->get();
        // $zone = Zone::where('is_active', 1)->whereNull('deleted_at')->get();
        $unit = Unit::get();
        // $collection = Collection::where('is_active', 1)->whereNull('deleted_at')->get();
        $metal = MetalType::where('is_active', 1)->whereNull('deleted_at')->get();
        // $brand = Brand::where('is_active', 1)->whereNull('deleted_at')->get();
        // $jewelTypes = JewelType::where('is_active', 1)->whereNull('deleted_at')->get();
        // $sivlerPurities = SilverPurity::get();
        // $weight = Weight::where('is_active', 1)->whereNull('deleted_at')->get();
        $plating = Plating::where('is_active', 1)->whereNull('deleted_at')->get();
        // $size = Size::where('is_active', 1)->whereNull('deleted_at')->get();
        $style = Style::get();
        if ($this->permissionCheck(Auth::user()->id, 'Add Product')) {
            return view('backend.admin.master.product.product', compact('project', 'category', 'subcategory', 'unit', 'color', 'metal', 'plating', 'finish', 'style'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function getSubCategory(Request $request)
    {
        $subcategory = SubCategory::where('category_id', $request->category_id)
            ->where('is_active', 1)
            ->WhereNull('deleted_at')
            ->get();

        // $subcollection = SubCollection::where('collection_id', $request->collection_id)
        //     ->where('is_active', 1)
        //     ->WhereNull('deleted_at')
        //     ->get();

        $category = Category::where('project_id', $request->project_id)
            ->where('is_active', 1)
            ->WhereNull('deleted_at')
            ->get();

        return response()->json([
            'subcategory' => $subcategory,
            // 'subcollection' => $subcollection,
            'category' => $category
        ]);
    }

    function productCreate(Request $request)
    {
        $request->validate([
            'product_unique_id' => [
                'required',
                Rule::unique('products', 'product_unique_id')
                    ->whereNull('deleted_at')
            ],
            'product_name' => 'required',
            'product_image' => 'required',
            // 'product_image' => 'required|dimensions:height=458,width=440',
            // 'product_price' => 'required',
            // 'designed_date' => 'required',
            // 'design_updated_date' => 'required',
            'height' => 'required',
            'width' => 'required',
            'weight' => 'required',
            'product_carat' => 'required',
            'product_finish' => 'required',
            'product_color' => 'required',
            'project' => 'required',
            'category' => 'required',
            'subcategory' => 'required',
            // 'zone' => 'required',
            // 'collection' => 'required',
            // 'sub_collection' => 'required',
            'metal' => 'required',
            // 'brand' => 'required',
            // 'jewel' => 'required',
            // 'purity' => 'required',
            'moq' => 'required',
            // 'hallmarking' => 'required',
            // 'gender' => 'required',
            'qty' => 'required',
            'unit' => 'required',
            'net_weight' => 'required',
            'product_style' => 'required',
            // 'size' => 'required',
            // 'plating' => 'required',
            // 'keywordtags' => 'required',
            // 'otherrate' => 'required',
            // 'depth' => 'required',
            // 'density' => 'required',
            // 'finishing' => 'required',
            // 'base_product' => 'required',
            // 'making_percent' => 'required',
            // 'cwqty' => 'required',
            // 'shape' => 'required',
            // 'crwcolcode' => 'required',
            // 'crwsubcolcode' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::Create([
                'product_unique_id' => $request->product_unique_id,
                'product_name' => $request->product_name,
                // 'product_price' => $request->product_price,
                // 'designed_date' => $request->designed_date,
                // 'design_updated_date' => $request->design_updated_date,
                'height' => $request->height,
                'width' => $request->width,
                // 'depth' => $request->depth,
                // 'density' => $request->density,
                'weight' => $request->weight,
                'product_carat' => $request->product_carat,
                'color_id' => $request->product_color,
                'style_id' => $request->product_style,
                'finish_id' => $request->product_finish,
                // 'size_id' => $request->size,
                // 'finishing' => $request->finishing,
                'project_id' => $request->project,
                // 'base_product' => $request->base_product,
                'category_id' => $request->category,
                'sub_category_id' => $request->subcategory,
                // 'zone_id' => $request->zone,
                // 'collection_id' => $request->collection,
                // 'sub_collection_id' => $request->sub_collection,
                // 'shape' => $request->shape,
                // 'brand_id' => $request->brand,
                'metal_type_id' => $request->metal,
                // 'jewel_type_id' => $request->jewel,
                // 'purity_id' => $request->purity,
                'plating_id' => $request->plating,
                'making_percent' => $request->making_percent,
                'moq' => $request->moq,
                // 'hallmarking' => $request->hallmarking,
                'crwcolcode' => $request->crwcolcode,
                'crwsubcolcode' => $request->crwsubcolcode,
                'gender' => $request->gender,
                'cwqty' => $request->cwqty,
                'qty' => $request->cwqty,
                'unit_id' => $request->unit,
                'net_weight' => $request->net_weight,
                'keywordtags' => $request->keywordtags,
                'otherrate' => $request->otherrate,
                'created_by' => Auth::user()->id,
            ]);
            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                $extension = $file->getClientOriginalExtension();
                $fileName = $product->product_unique_id . '.' . $extension;

                Product::findorfail($product->id)->update([
                    'product_image' => $this->fileUpload($file, 'upload/product', $fileName)
                ]);
            }

            // if ($request->hasFile('product_multiple_image')) {
            //     $files = $request->file('product_multiple_image');
            //     $suffix = ProductMultipleImage::where('product_id', $product->id)->count();
            //     foreach ($files as $value) {
            //         $extensions = $value->getClientOriginalExtension();
            //         $fileNames = $product->product_unique_id . '_' . $suffix . '.' . $extensions;

            //         ProductMultipleImage::Create([
            //             'product_id' => $product->id,
            //             'product_images' => $this->fileUpload($value, 'upload/product/multipleimages', $fileNames)
            //         ]);
            //         $suffix++;
            //     }
            // }

            DB::commit();
            $notification = array(
                'message' => 'Product Created sucessfully',
                'alert' => 'success'
            );
            return redirect()->route('product')->with($notification);
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('product')->with($notification);
        }
    }

    function productData(Request $request)
    {
        $product = Product::select(
            'products.*',
            'colors.color_name',
            'projects.project_name',
            'categories.category_name',
            'sub_categories.sub_category_name',
            // 'zones.zone_name',
            'units.unit_name',
            // 'weights.weight'
        )
            ->join('colors', 'colors.id', 'products.color_id')
            ->join('projects', 'projects.id', 'products.project_id')
            ->join('categories', 'categories.id', 'products.category_id')
            ->join('sub_categories', 'sub_categories.id', 'products.sub_category_id')
            // ->join('zones', 'zones.id', 'products.zone_id')
            ->join('units', 'units.id', 'products.unit_id')
            // ->join('weights', 'weights.id', 'products.weight_id')
            ->whereNull('products.deleted_at')
            ->orderBy('products.id', 'ASC');

        if ($request->category_id > 0) {
            $product = $product->where('products.category_id', $request->category_id);
        }

        if ($request->sub_category_id > 0) {
            $product = $product->where('products.sub_category_id', $request->sub_category_id);
        }

        $product = $product->get();
        return datatables()->of($product)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a data-toggle="modal"
                data-target="#editmodal" class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function productList(Request $request)
    {
        $color = Color::where('is_active', 1)->whereNull('deleted_at')->get();
        $finish = Finish::where('is_active', 1)->whereNull('deleted_at')->get();
        $project = Project::where('is_active', 1)->whereNull('deleted_at')->get();
        $category = Category::where('is_active', 1)->whereNull('deleted_at')->get();
        $subcategory = SubCategory::where('is_active', 1)->whereNull('deleted_at')->get();
        $unit = Unit::get();
        // $zone = Zone::where('is_active', 1)->whereNull('deleted_at')->get();
        // $collection = Collection::where('is_active', 1)->whereNull('deleted_at')->get();
        $metal = MetalType::where('is_active', 1)->whereNull('deleted_at')->get();
        // $brand = Brand::where('is_active', 1)->whereNull('deleted_at')->get();
        // $jewelTypes = JewelType::where('is_active', 1)->whereNull('deleted_at')->get();
        // $sivlerPurities = SilverPurity::get();
        // $weight = Weight::where('is_active', 1)->whereNull('deleted_at')->get();
        $plating = Plating::where('is_active', 1)->whereNull('deleted_at')->get();
        // $size = Size::where('is_active', 1)->whereNull('deleted_at')->get();
        $style = Style::get();
        if ($this->permissionCheck(Auth::user()->id, 'Product List')) {
            return view('backend.admin.master.product.productlist', compact('project', 'category', 'subcategory', 'unit', 'color', 'metal', 'plating', 'finish', 'style'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function getProductById($id)
    {
        $product = Product::select(
            'products.*',
            'colors.color_name',
            'projects.project_name',
            'categories.category_name',
            'sub_categories.sub_category_name',
            // 'zones.zone_name',
            'units.unit_name',
            // 'weights.weight',
            'platings.plating_name',
            // 'sizes.size',
            'finishes.finish_name'
        )
            ->join('colors', 'colors.id', 'products.color_id')
            ->join('projects', 'projects.id', 'products.project_id')
            ->join('categories', 'categories.id', 'products.category_id')
            ->join('sub_categories', 'sub_categories.id', 'products.sub_category_id')
            // ->join('zones', 'zones.id', 'products.zone_id')
            ->join('units', 'units.id', 'products.unit_id')
            // ->join('weights', 'weights.id', 'products.weight_id')
            // ->join('sizes', 'sizes.id', 'products.size_id')
            ->join('platings', 'platings.id', 'products.plating_id')
            ->leftjoin('finishes', 'finishes.id', 'products.finish_id')
            ->whereNull('products.deleted_at')
            ->where('products.id', $id)
            ->first();

        $productMultipleImage = ProductMultipleImage::where('product_id', $id)->get();
        return response()->json([
            'product' => $product,
            'productmultipleimage' => $productMultipleImage
        ]);
    }

    function productUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_unique_id' => [
                'required',
                Rule::unique('products', 'product_unique_id')
                    ->whereNull('deleted_at')
                    ->ignore($request->productId)
            ],
            'product_name' => 'required',
            // 'product_price' => 'required',
            // 'product_image' => 'dimensions:height=458,width=440',
            // 'designed_date' => 'required',
            // 'design_updated_date' => 'required',
            'height' => 'required',
            'width' => 'required',
            'weight' => 'required',
            'product_carat' => 'required',
            'product_finish' => 'required',
            'product_color' => 'required',
            'project' => 'required',
            'category' => 'required',
            'subcategory' => 'required',
            // 'zone' => 'required',
            // 'collection' => 'required',
            // 'sub_collection' => 'required',
            'metal' => 'required',
            // 'brand' => 'required',
            // 'jewel' => 'required',
            // 'purity' => 'required',
            'moq' => 'required',
            // 'hallmarking' => 'required',
            // 'gender' => 'required',
            'qty' => 'required',
            'unit' => 'required',
            'net_weight' => 'required',
            'product_style' => 'required',
            // 'plating' => 'required',
            // 'size' => 'required',
            // 'keywordtags' => 'required',
            // 'otherrate' => 'required',
            // 'depth' => 'required',
            // 'density' => 'required',
            // 'finishing' => 'required',
            // 'base_product' => 'required',
            // 'making_percent' => 'required',
            // 'cwqty' => 'required',
            // 'shape' => 'required',
            // 'crwcolcode' => 'required',
            // 'crwsubcolcode' => 'required',
        ]);

        if ($validator->fails()) {
            $notification = array(
                'message' => implode(",", $validator->errors()->all()),
                'alert' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        $oldImage = $request->productImage;
        $productUniqueId = $request->productUniqueId;
        if ($request->hasFile('product_image')) {
            @unlink($oldImage);
            $files = $request->file('product_image');
            $extensions = $files->getClientOriginalExtension();
            $fileNames = $productUniqueId . '.' . $extensions;
        }

        try {
            Product::findorfail($request->productId)->update([
                'product_unique_id' => $request->product_unique_id,
                'product_name' => $request->product_name,
                'product_image' => ($request->hasFile('product_image')) ? $this->fileUpload($request->file('product_image'), 'upload/product/', $fileNames) : $oldImage,
                // 'product_price' => $request->product_price,
                // 'designed_date' => $request->designed_date,
                // 'design_updated_date' => $request->design_updated_date,
                'height' => $request->height,
                'width' => $request->width,
                // 'depth' => $request->depth,
                // 'density' => $request->density,
                'weight' => $request->weight,
                'product_carat' => $request->product_carat,
                'finish_id' => $request->product_finish,
                'color_id' => $request->product_color,
                'style_id' => $request->product_style,
                // 'size_id' => $request->size,
                // 'finishing' => $request->finishing,
                'project_id' => $request->project,
                // 'base_product' => $request->base_product,
                'category_id' => $request->category,
                'sub_category_id' => $request->subcategory,
                // 'zone_id' => $request->zone,
                // 'collection_id' => $request->collection,
                // 'sub_collection_id' => $request->sub_collection,
                // 'shape' => $request->shape,
                // 'brand_id' => $request->brand,
                'metal_type_id' => $request->metal,
                // 'jewel_type_id' => $request->jewel,
                // 'purity_id' => $request->purity,
                'plating_id' => $request->plating,
                'making_percent' => $request->making_percent,
                'moq' => $request->moq,
                // 'hallmarking' => $request->hallmarking,
                'crwcolcode' => $request->crwcolcode,
                'crwsubcolcode' => $request->crwsubcolcode,
                'gender' => $request->gender,
                'cwqty' => $request->cwqty,
                'qty' => $request->cwqty,
                'unit_id' => $request->unit,
                'net_weight' => $request->net_weight,
                'keywordtags' => $request->keywordtags,
                'otherrate' => $request->otherrate,
                'updated_by' => Auth::user()->id,
            ]);

            // if ($request->hasFile('product_multiple_image')) {
            //     $files = $request->file('product_multiple_image');
            //     $suffix = ProductMultipleImage::where('product_id', $request->productId)->count();
            //     foreach ($files as $value) {
            //         $product = Product::where('id', $request->productId)->first();
            //         $extensions = $value->getClientOriginalExtension();
            //         $fileNames = $product->product_unique_id . '_' . $suffix . '.' . $extensions;
            //         ProductMultipleImage::Create([
            //             'product_id' => $product->id,
            //             'product_images' => $this->fileUpload($value, 'upload/product/multipleimages', $fileNames)
            //         ]);
            //         $suffix++;
            //     }
            // }
            $notification = array(
                'message' => 'Product Updated successfully',
                'alert' => 'success'
            );
            return redirect()->route('productlist')->with($notification);
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('productlist')->with($notification);
        }
    }

    public function productStatus($id, $status)
    {
        try {
            Product::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteProduct(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $order = 0;
            if ($order == 0) {
                $product = Product::findorfail($id);
                $product->delete();
                $product->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Product Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Product Could Not Be Deleted!',
                    'alert' => 'error'
                );
                return response()->json([
                    'responseData' => $notification
                ]);
            }
        } catch (Exception $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
            $notification = array(
                'message' => 'Product could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function importProduct(Request $request)
    {
        try {
            Excel::import(new ImportProduct, $request->file('productimport')->store('files'));
            $notification = array(
                'message' => 'Product imported successfully',
                'alert' => 'success'
            );
            return redirect()->route('product')->with($notification);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => $e->getMessage(),
                'alert' => 'error'
            );
            return redirect()->route('product')->with($notification);
        }
    }

    public function productMultiImageDelete($id)
    {
        $oldimg = ProductMultipleImage::findOrFail($id);
        @unlink($oldimg->product_images);
        ProductMultipleImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Product Image Deleted Successfully',
            'alert' => 'success'
        );

        return response()->json([
            'response' => $notification
        ]);
    }
    public function downloadproduct()
    {
        $file_path = public_path('template/Product.xlsx');
        return response()->download($file_path);
    }
}
