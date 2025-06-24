<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    use Common;

    function brand()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Brand')) {
            return view('backend.admin.master.brand');
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function brandCreate(Request $request)
    {
        $request->validate([
            'brand_name' => [
                'required',
                Rule::unique('brands', 'brand_name')
                    ->whereNull('deleted_at')
                    ->ignore($request->brandId)
            ],
        ], [
            'brand_name.required' => 'Brand Name is required',
            'brand_name.unique' => 'Brand Name is already exists!',
        ]);

        DB::beginTransaction();
        try {
            if ($request->brandId == Null) {
                Brand::Create([
                    'brand_name' => $request->brand_name,
                    'created_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Brand created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('brand')->with($notification);
            } else {


                Brand::findorfail($request->brandId)->update([
                    'brand_name' => $request->brand_name,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Brand Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('brand')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('brand')->with($notification);
        }
    }

    public function getBrandData()
    {
        $brand = Brand::whereNull('deleted_at')
            ->orderBy('id', 'ASC')
            ->get();

        return datatables()->of($brand)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '"></a>';
                return $html;
            })->toJson();
    }

    function getBrandById($id)
    {
        try {
            $brand = Brand::where('id', $id)->first();
            return response()->json([
                'brand' => $brand
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteBrand(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $brandcount = Product::where('brand_id', $id)->count();
            if ($brandcount == 0) {
                $brand = Brand::findorfail($id);
                $brand->delete();
                $brand->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Brand Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Brand Could Not Be Deleted!',
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
                'message' => 'Brand could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function brandStatus($id, $status)
    {
        try {
            Brand::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
