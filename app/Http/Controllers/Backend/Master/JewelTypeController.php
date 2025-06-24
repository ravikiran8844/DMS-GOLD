<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\JewelType;
use App\Models\Product;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class JewelTypeController extends Controller
{
    use Common;

    function jewel()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Jewel Type')) {
            return view('backend.admin.master.jewel');
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function jewelCreate(Request $request)
    {
        $request->validate([
            'jewel' => [
                'required',
                Rule::unique('jewel_types', 'jewel_type')
                    ->whereNull('deleted_at')
                    ->ignore($request->jewelId)
            ],
        ], [
            'jewel.required' => 'Jewel Type is required',
            'jewel.unique' => 'Jewel Type is already exists!',
        ]);

        DB::beginTransaction();
        try {
            if ($request->jewelId == Null) {
                JewelType::Create([
                    'jewel_type' => $request->jewel,
                    'created_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Jewel Type created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('jeweltype')->with($notification);
            } else {


                JewelType::findorfail($request->jewelId)->update([
                    'jewel_type' => $request->jewel,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Jewel Type Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('jeweltype')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('jeweltype')->with($notification);
        }
    }

    public function getJewelData()
    {
        $jewel = JewelType::whereNull('deleted_at')
            ->orderBy('id', 'ASC')
            ->get();

        return datatables()->of($jewel)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function getJewelById($id)
    {
        try {
            $jewel = JewelType::where('id', $id)->first();
            return response()->json([
                'jewel' => $jewel
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteJewel(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $jeweltypecount = Product::where('jewel_type_id', $id)->count();
            if ($jeweltypecount == 0) {
                $jewel = JewelType::findorfail($id);
                $jewel->delete();
                $jewel->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Jewel Type Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Jewel Type Could Not Be Deleted!',
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
                'message' => 'Jewel Type could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function jewelStatus($id, $status)
    {
        try {
            JewelType::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
