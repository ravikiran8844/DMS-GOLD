<?php

namespace App\Http\Controllers\Backend\Dealer;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Imports\ImportDealer;
use App\Models\Dealer;
use App\Models\User;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class DealersController extends Controller
{
    use Common;

    function dealerList()
    {
        $activeDealersCount = User::where('role_id', Roles::Dealer)->where('is_active', 1)->count();

        if ($this->permissionCheck(Auth::user()->id, 'Dealer List')) {
            $users = User::where('role_id', Roles::Dealer)->get();
            return view('backend.admin.dealer.dealerlist', compact('activeDealersCount', 'users'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function dealerDetails()
    {
        return view('backend.admin.dealer.dealerdetails');
    }

    function dealerCreate(Request $request)
    {
        $request->validate([
            'mobile' => [
                'required',
                Rule::unique('dealers', 'mobile'),
            ],
            'zone' => 'required',
            'party_name' => 'required',
            'code' => 'required',
            'customer_code' => 'required',
            'person_name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $dealer = Dealer::Create([
                'mobile' => $request->mobile,
                'zone' => $request->zone,
                'code' => $request->code,
                'customer_code' => $request->customer_code,
                'person_name' => $request->person_name,
                'party_name' => $request->party_name,
                'created_by' => Auth::user()->id
            ]);

            //user create
            $user = $this->createUser(
                $request->party_name,
                $request->mobile,
                Roles::Dealer
            );

            //user_id update
            Dealer::where('id', $dealer->id)->update([
                'user_id' => $user->id
            ]);

            $notification = array(
                'message' => 'Dealer Created Successfully',
                'alert' => 'success'
            );
            DB::commit();
            return redirect()->route('dealerlist')->with($notification);
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('dealerdetails')->with($notification);
        }
    }

    public function importDealer(Request $request)
    {
        try {
            Excel::import(new ImportDealer, $request->file('dealerimport')->store('files'));
            $notification = array(
                'message' => 'Dealer imported successfully',
                'alert' => 'success'
            );
            return redirect()->route('dealerlist')->with($notification);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => $e->getMessage(),
                'alert' => 'error'
            );
            return redirect()->route('dealerdetails')->with($notification);
        }
    }

    function dealerData(Request $request)
    {
        $dealer = "";
        $dealer = Dealer::whereNull('deleted_at');
        if ($request->user_ids > 0) {
            $dealer = $dealer->where('dealers.user_id', $request->user_ids);
        }
        $dealer = $dealer->get();
        return datatables()->of($dealer)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a data-toggle="modal"
                data-target="#editmodal" class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '"></a>';
                return $html;
            })->toJson();
    }

    function dealerUpdate(Request $request)
    {
        $request->validate([
            'mobile' => [
                'required',
                Rule::unique('dealers', 'mobile'),
            ],
            'zone' => 'required',
            'party_name' => 'required',
            'code' => 'required',
            'customer_code' => 'required',
            'person_name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            Dealer::where('id', $request->dealerId)->Update([
                'mobile' => $request->mobile,
                'zone' => $request->zone,
                'code' => $request->code,
                'customer_code' => $request->customer_code,
                'person_name' => $request->person_name,
                'party_name' => $request->party_name,
                'updated_by' => Auth::user()->id
            ]);

            //user update
            User::where('id', $request->userId)->Update([
                'name' => $request->party_name,
                'mobile' => $request->mobile
            ]);

            $notification = array(
                'message' => 'Dealer Updated Successfully',
                'alert' => 'success'
            );
            DB::commit();
            return redirect()->route('dealerlist')->with($notification);
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('dealerdetails')->with($notification);
        }
    }
    function getDealerById($id)
    {
        $dealer = Dealer::where('id', $id)
            ->first();

        return response()->json([
            'dealer' => $dealer
        ]);
    }


    public function deleteDealer(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $order = 0;
            if ($order == 0) {
                $dealer = Dealer::findorfail($id);
                $dealer->delete();
                $dealer->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Dealer Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Dealer Could Not Be Deleted!',
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
                'message' => 'Dealer could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }


    public function dealerStatus($id, $status)
    {
        try {
            Dealer::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
    public  function dearlerdownload()
    {
        $file_path = public_path('template/Dealer.xlsx');
        return response()->download($file_path);
    }
}
