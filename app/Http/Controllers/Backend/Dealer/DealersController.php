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
            'company_name' => 'required',
            'communication_address' => 'required',
            'mobile' => [
                'required',
                Rule::unique('dealers', 'mobile'),
            ],
            'email' => [
                'required',
                Rule::unique('dealers', 'email'),
            ],
            'zone' => 'required',
            'state' => 'required',
            'city' => 'required',
            'a_name' => 'required',
            'a_designation' => 'required',
            'a_mobile' => 'required',
            'a_email' => 'required',
            'b_name' => 'required',
            'b_designation' => 'required',
            'b_mobile' => 'required',
            'b_email' => 'required',
            'gst' => 'required',
            'income_tax_pan' => 'required',
            'bank_name' => 'required',
            'branch_name' => 'required',
            'address' => 'required',
            'account_number' => 'required',
            'account_type' => 'required',
            'ifsc' => 'required',
            // 'cheque_leaf' => 'required',
            // 'gst_certificate' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $dealer = Dealer::Create([
                'company_name' => $request->company_name,
                'communication_address' => $request->communication_address,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'zone_id' => $request->zone,
                'city' => $request->city,
                'state' => $request->state,
                'a_name' => $request->a_name,
                'a_designation' => $request->a_designation,
                'a_mobile' => $request->a_mobile,
                'a_email' => $request->a_email,
                'b_name' => $request->b_name,
                'b_designation' => $request->b_designation,
                'b_mobile' => $request->b_mobile,
                'b_email' => $request->b_email,
                'gst' => $request->gst,
                'income_tax_pan' => $request->income_tax_pan,
                'bank_name' => $request->bank_name,
                'branch_name' => $request->branch_name,
                'address' => $request->address,
                'account_number' => $request->account_number,
                'account_type' => $request->account_type,
                'ifsc' => $request->ifsc,
                'created_by' => Auth::user()->id
            ]);

            if ($request->hasFile('cheque_leaf')) {
                $file = $request->file('cheque_leaf');
                $extension = $file->getClientOriginalExtension();
                $fileName = $dealer->id . '.' . $extension;

                Dealer::where('id', $dealer->id)->update([
                    'cheque_leaf' => $this->fileUpload($file, 'upload/dealer/chequeleaf', $fileName)
                ]);
            }

            if ($request->hasFile('gst_certificate')) {
                $files = $request->file('gst_certificate');
                $extensions = $files->getClientOriginalExtension();
                $fileNames = $dealer->id . '.' . $extensions;

                Dealer::where('id', $dealer->id)->update([
                    'gst_certificate' => $this->fileUpload($files, 'upload/dealer/gstcertificate', $fileNames)
                ]);
            }

            //user create
            $user = $this->createUser(
                $request->company_name,
                $request->email,
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
            // ->whereRaw("DATE(created_at) BETWEEN '{$request->startdate}' AND '{$request->enddate}'");
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
        // $request->validate([
        //     'company_name' => 'required',
        //     'communication_address' => 'required',
        //     'mobile' => 'required',
        //     'email' => 'required',
        //     'a_name' => 'required',
        //     'a_designation' => 'required',
        //     'a_mobile' => 'required',
        //     'a_email' => 'required',
        //     'b_name' => 'required',
        //     'b_designation' => 'required',
        //     'b_mobile' => 'required',
        //     'b_email' => 'required',
        //     'gst' => 'required',
        //     'income_tax_pan' => 'required',
        //     'bank_name' => 'required',
        //     'branch_name' => 'required',
        //     'address' => 'required',
        //     'account_number' => 'required',
        //     'account_type' => 'required',
        //     'ifsc' => 'required'
        // ]);

        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'communication_address' => 'required',
            'mobile' => [
                'required',
                Rule::unique('dealers', 'mobile')
                    ->ignore($request->dealerId)
            ],
            'email' => [
                'required',
                Rule::unique('dealers', 'email')
                    ->ignore($request->dealerId)
            ],
            'zone' => 'required',
            'city' =>  'required',
            'state' =>  'required',
            'a_name' => 'required',
            'a_designation' => 'required',
            'a_mobile' => 'required',
            'a_email' => 'required',
            'b_name' => 'required',
            'b_designation' => 'required',
            'b_mobile' => 'required',
            'b_email' => 'required',
            'gst' => 'required',
            'income_tax_pan' => 'required',
            'bank_name' => 'required',
            'branch_name' => 'required',
            'address' => 'required',
            'account_number' => 'required',
            'account_type' => 'required',
            'ifsc' => 'required'
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

            $oldChequeLeaf = $request->chequeleaf;
            $dealerId = $request->dealerId;
            if ($request->hasFile('cheque_leaf')) {
                @unlink($oldChequeLeaf);
                $file = $request->file('cheque_leaf');
                $extension = $file->getClientOriginalExtension();
                $fileName = $dealerId . '.' . $extension;
            }

            $oldGstCertificate = $request->gstcertificate;
            if ($request->hasFile('gst_certificate')) {
                $files = $request->file('gst_certificate');
                @unlink($oldGstCertificate);
                $extensions = $files->getClientOriginalExtension();
                $fileNames = $dealerId . '.' . $extensions;
            }
            Dealer::where('id', $request->dealerId)->Update([
                'company_name' => $request->company_name,
                'communication_address' => $request->communication_address,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'zone_id' => $request->zone,
                'city' => $request->city,
                'state' => $request->state,
                'a_name' => $request->a_name,
                'a_designation' => $request->a_designation,
                'a_mobile' => $request->a_mobile,
                'a_email' => $request->a_email,
                'b_name' => $request->b_name,
                'b_designation' => $request->b_designation,
                'b_mobile' => $request->b_mobile,
                'b_email' => $request->b_email,
                'gst' => $request->gst,
                'income_tax_pan' => $request->income_tax_pan,
                'bank_name' => $request->bank_name,
                'branch_name' => $request->branch_name,
                'address' => $request->address,
                'account_number' => $request->account_number,
                'account_type' => $request->account_type,
                'ifsc' => $request->ifsc,
                'cheque_leaf' => ($request->hasFile('cheque_leaf')) ? $this->fileUpload($request->file('cheque_leaf'), 'upload/dealer/chequeleaf', $fileName) : $oldChequeLeaf,
                'gst_certificate' => ($request->hasFile('gst_certificate')) ? $this->fileUpload($request->file('gst_certificate'), 'upload/dealer/gstcertificate', $fileNames) : $oldGstCertificate,
                'updated_by' => Auth::user()->id
            ]);

            //user update
            User::where('id', $request->userId)->Update([
                'name' => $request->company_name,
                'email' => $request->email,
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
