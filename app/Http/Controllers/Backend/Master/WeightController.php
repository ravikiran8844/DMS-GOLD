<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Weight;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WeightController extends Controller
{
    use Common;

    function weight()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Weight')) {
            return view('backend.admin.master.weight');
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function weightCreate(Request $request)
    {
        $request->validate([
            'weight_range_from' => [
                'required',
                // Rule::unique('weights', 'weight_range_from')
                //     ->ignore($request->weightId)
            ],
            'weight_range_to' => [
                'required',
                // Rule::unique('weights', 'weight_range_to')
                //     ->ignore($request->weightId)
            ],
            'mc_charge' => 'required'
        ], [
            'weight.required' => 'Weight is required',
            'weight.unique' => 'Weight is already exists!',
        ]);

        DB::beginTransaction();
        try {
            if ($request->weightId == Null) {
                Weight::Create([
                    'weight_range_from' => $request->weight_range_from,
                    'weight_range_to' => $request->weight_range_to,
                    'mc_charge' => $request->mc_charge,
                    'created_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Weight created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('weight')->with($notification);
            } else {

                Weight::findorfail($request->weightId)->update([
                    'weight_range_from' => $request->weight_range_from,
                    'weight_range_to' => $request->weight_range_to,
                    'mc_charge' => $request->mc_charge,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Weight Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('weight')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('weight')->with($notification);
        }
    }

    public function getWeightData()
    {
        $weight = Weight::orderBy('id', 'ASC')
            ->get();

        return datatables()->of($weight)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function getWeightById($id)
    {
        try {
            $weight = Weight::where('id', $id)->first();
            return response()->json([
                'weight' => $weight
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteWeight(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $weightcount = Product::where('weight_id', $id)->count();
            if ($weightcount == 0) {
                $weight = Weight::findorfail($id);
                $weight->delete();
                $weight->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Weight Deleted Successfully',
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
                'message' => 'Weight could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function weightStatus($id, $status)
    {
        try {
            Weight::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
