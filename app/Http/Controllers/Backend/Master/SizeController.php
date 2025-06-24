<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Size;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SizeController extends Controller
{
    use Common;

    function size()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Size')) {
            return view('backend.admin.master.size');
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function sizeCreate(Request $request)
    {
        $request->validate([
            'size' => [
                'required',
                Rule::unique('sizes', 'size')
                    ->ignore($request->sizeId)
            ],
        ], [
            'size.required' => 'Size is required',
            'size.unique' => 'Size is already exists!',
        ]);

        DB::beginTransaction();
        try {
            if ($request->sizeId == Null) {
                Size::Create([
                    'size' => $request->size,
                    'created_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Size created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('size')->with($notification);
            } else {

                Size::findorfail($request->sizeId)->update([
                    'size' => $request->size,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Size Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('size')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('size')->with($notification);
        }
    }

    public function getSizeData()
    {
        $size = Size::orderBy('id', 'ASC')
            ->get();

        return datatables()->of($size)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '"></a>';
                return $html;
            })->toJson();
    }

    function getSizeById($id)
    {
        try {
            $size = Size::where('id', $id)->first();
            return response()->json([
                'size' => $size
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteSize(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $sizecount = Product::where('size_id', $id)->count();
            if ($sizecount == 0) {
                $size = Size::findorfail($id);
                $size->delete();
                $size->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Size Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Sub Category Could Not Be Deleted!',
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
                'message' => 'Size could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function sizeStatus($id, $status)
    {
        try {
            Size::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
