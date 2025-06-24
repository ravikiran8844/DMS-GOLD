<?php

namespace App\Http\Controllers\Backend\Retailer;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Models\Dealer;
use App\Models\User;
use App\Models\Zone;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RetailerController extends Controller
{
    use Common;

    function retailer()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Retailer List')) {
            $dealers = Dealer::where('is_active', 1)->whereNull('deleted_at')->get();
            $state = User::select('state')->where('role_id', Roles::Dealer)
                ->where('is_active', 1)->where('state', '!=', NULL)->distinct()->get();
            $zone = Zone::where('is_active', 1)->whereNull('deleted_at')->get();
            return view('backend.admin.retailer.retailer', compact('dealers', 'state', 'zone'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function retailerData()
    {
        $retailer = "";
        $retailer = User::select('users.*', 'dealers.company_name')
            ->join('dealers', 'users.preferred_dealer_id', 'dealers.user_id')
            ->where('users.role_id', Roles::Retailer)
            ->get();
        return datatables()->of($retailer)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a data-toggle="modal"
                data-target="#editmodal" class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function getRetailerById($id)
    {
        $retailer = User::where('id', $id)
            ->first();

        return response()->json([
            'retailer' => $retailer
        ]);
    }

    function retailerUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'retailer_name' => 'required',
            'address' => 'required',
            'mobile' => [
                'required',
                Rule::unique('dealers', 'mobile')
                    ->ignore($request->dealerId)
            ],
            'retailer_email' => [
                'required',
                Rule::unique('dealers', 'email')
                    ->ignore($request->dealerId)
            ],
            'company_name' => 'required',
            'pincode' => 'required',
            'state' =>  'required',
            'district' =>  'required'
        ]);

        if ($validator->fails()) {
            $notification = array(
                'message' => implode(",", $validator->errors()->all()),
                'alert' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        DB::beginTransaction();
        try {
            User::where('id', $request->userId)->Update([
                'shop_name' => $request->company_name,
                'name' => $request->retailer_name,
                'mobile' => $request->mobile,
                'email' => $request->retailer_email,
                'GST' => $request->GST,
                'address' => $request->address,
                'state' => $request->state,
                'dealer_details' => $request->dealer_details
            ]);

            $notification = array(
                'message' => 'Retailer Updated Successfully',
                'alert' => 'success'
            );
            DB::commit();
            return redirect()->route('retailer')->with($notification);
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('retailer')->with($notification);
        }
    }

    public function retailerStatus($id, $status)
    {
        try {
            User::findorfail($id)->update([
                'is_active' => $status
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function pincode($pincode)
    {
        $response = Http::get("https://api.postalpincode.in/pincode/{$pincode}");
        return response($response->body(), $response->status());
    }
}
