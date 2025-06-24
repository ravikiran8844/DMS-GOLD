<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\MetalType;
use App\Models\Product;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MetalController extends Controller
{
    use Common;

    function metal()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Metal Type')) {
            return view('backend.admin.master.metal');
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function metalCreate(Request $request)
    {
        $request->validate([
            'metal_name' => [
                'required',
                Rule::unique('metal_types', 'metal_name')
                    ->whereNull('deleted_at')
                    ->ignore($request->metalId)
            ],
        ], [
            'metal_name.required' => 'Metal Name is required',
            'metal_name.unique' => 'Metal Name is already exists!',
        ]);

        DB::beginTransaction();
        try {
            if ($request->metalId == Null) {
                MetalType::Create([
                    'metal_name' => $request->metal_name,
                    'created_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Metal Name created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('metal')->with($notification);
            } else {


                MetalType::findorfail($request->metalId)->update([
                    'metal_name' => $request->metal_name,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Metal Name Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('metal')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('metal')->with($notification);
        }
    }

    public function getMetalData()
    {
        $metal = MetalType::whereNull('deleted_at')
            ->orderBy('id', 'ASC')
            ->get();

        return datatables()->of($metal)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '"></a>';
                return $html;
            })->toJson();
    }

    function getMetalById($id)
    {
        try {
            $metal = MetalType::where('id', $id)->first();
            return response()->json([
                'metal' => $metal
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteMetal(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $metalcount = Product::where('metal_type_id', $id)->count();
            if ($metalcount == 0) {
                $metal = MetalType::findorfail($id);
                $metal->delete();
                $metal->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Metal Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Metal Could Not Be Deleted!',
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
                'message' => 'Metal could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function metalStatus($id, $status)
    {
        try {
            MetalType::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
