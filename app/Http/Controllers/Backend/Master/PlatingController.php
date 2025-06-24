<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\plating;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PlatingController extends Controller
{
    use Common;

    function plating()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Plating')) {
            return view('backend.admin.master.plating');
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function platingCreate(Request $request)
    {
        $request->validate([
            'plating_name' => [
                'required',
                Rule::unique('platings', 'plating_name')
                    ->ignore($request->platingId)
            ],
        ], [
            'plating_name.required' => 'Plating Name is required',
            'plating_name.unique' => 'Plating Name is already exists!',
        ]);

        DB::beginTransaction();
        try {
            if ($request->platingId == Null) {
                Plating::Create([
                    'plating_name' => $request->plating_name,
                    'created_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Plating Name created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('plating')->with($notification);
            } else {

                Plating::findorfail($request->platingId)->update([
                    'plating_name' => $request->plating_name,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Plating Name Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('plating')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('plating')->with($notification);
        }
    }

    public function getPlatingData()
    {
        $plating = Plating::orderBy('id', 'ASC')
            ->get();

        return datatables()->of($plating)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function getPlatingById($id)
    {
        try {
            $plating = Plating::where('id', $id)->first();
            return response()->json([
                'plating' => $plating
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deletePlating(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $platingcount = plating::where('plating_id', $id)->count();
            if ($platingcount == 0) {
                $plating = Plating::findorfail($id);
                $plating->delete();
                $plating->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Plating Deleted Successfully',
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
                'message' => 'Plating could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function platingStatus($id, $status)
    {
        try {
            Plating::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
