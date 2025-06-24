<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Zone;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ZoneController extends Controller
{
    use Common;

    function zone()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Zone')) {
            return view('backend.admin.master.zone');
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function zoneCreate(Request $request)
    {
        $request->validate([
            'zone_name' => [
                'required',
                Rule::unique('zones', 'zone_name')
                    ->whereNull('deleted_at')
                    ->ignore($request->zoneId)
            ]
        ]);

        DB::beginTransaction();
        try {
            if ($request->zoneId == Null) {
                Zone::Create([
                    'zone_name' => $request->zone_name,
                    'created_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Zone created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('zone')->with($notification);
            } else {

                Zone::findorfail($request->zoneId)->update([
                    'category_name' => $request->category_name,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Zone Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('zone')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('zone')->with($notification);
        }
    }

    public function getZoneData()
    {
        $zone = Zone::whereNull('deleted_at')
            ->orderBy('id', 'ASC')
            ->get();

        return datatables()->of($zone)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '"></a>';
                return $html;
            })->toJson();
    }

    function getZoneById($id)
    {
        try {
            $zone = Zone::where('id', $id)->first();
            return response()->json([
                'zone' => $zone
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteZone(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $zonecount = Product::where('zone_id', $id)->count();
            if ($zonecount == 0) {
                $zone = Zone::findorfail($id);
                $zone->delete();
                $zone->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Zone Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Zone Could Not Be Deleted!',
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
                'message' => 'Zone could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function zoneStatus($id, $status)
    {
        try {
            Zone::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
