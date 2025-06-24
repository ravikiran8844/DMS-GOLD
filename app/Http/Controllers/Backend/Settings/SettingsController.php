<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\OrderSetting;
use App\Models\Settings;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    use Common;
    function setting()
    {
        $setting = Settings::first();
        $data = OrderSetting::first();
        $prefix = $data->prefix ?? 0;
        $length = $data->length ?? 0;
        $live = (int)($data->live ?? 0) + 1;

        if ($live) {
            $number = $live;
        }

        $man = sprintf("%0{$length}d", $number);
        $example = $prefix . $man;
        return view('backend.admin.settings.settings', compact('setting', 'example', 'data'));
    }

    function settingStore(Request $request)
    {
        $request->validate([
            'otp_length' => 'required',
            'otp_expiry_duration' => 'required',
            'east_zone_name' => 'required',
            'east_zone_incharge_name' => 'required',
            'east_zone_mobile_no' => 'required',
            'east_zone_incharge_email' => 'required',
            'west_zone_name' => 'required',
            'west_zone_incharge_name' => 'required',
            'west_zone_mobile_no' => 'required',
            'west_zone_incharge_email' => 'required',
            'north_zone_name' => 'required',
            'north_zone_incharge_name' => 'required',
            'north_zone_mobile_no' => 'required',
            'north_zone_incharge_email' => 'required',
            'south_zone_name' => 'required',
            'south_zone_incharge_name' => 'required',
            'south_zone_mobile_no' => 'required',
            'south_zone_incharge_email' => 'required',
        ]);
        DB::beginTransaction();
        try {
            if ($request->settingId == null) {
                $isMaintenanceMode = $request->has('is_maintanance_mode') && $request->input('is_maintanance_mode') === 'on' ? 1 : 0;
                $setting = Settings::Create([
                    'is_maintanance_mode' => $isMaintenanceMode,
                    'otp_length' => $request->otp_length,
                    'otp_expiry_duration' => $request->otp_expiry_duration,
                    'east_zone_name' => $request->east_zone_name,
                    'east_zone_incharge_name' => $request->east_zone_incharge_name,
                    'east_zone_mobile_no' => $request->east_zone_mobile_no,
                    'east_zone_incharge_email' => $request->east_zone_incharge_email,
                    'west_zone_name' => $request->west_zone_name,
                    'west_zone_incharge_name' => $request->west_zone_incharge_name,
                    'west_zone_mobile_no' => $request->west_zone_mobile_no,
                    'west_zone_incharge_email' => $request->west_zone_incharge_email,
                    'north_zone_name' => $request->north_zone_name,
                    'north_zone_incharge_name' => $request->north_zone_incharge_name,
                    'north_zone_mobile_no' => $request->north_zone_mobile_no,
                    'north_zone_incharge_email' => $request->north_zone_incharge_email,
                    'north_zone_name1' => $request->north_zone_name1,
                    'north_zone_incharge_name1' => $request->north_zone_incharge_name1,
                    'north_zone_mobile_no1' => $request->north_zone_mobile_no1,
                    'north_zone_incharge_email1' => $request->north_zone_incharge_email1,
                    'south_zone_name' => $request->south_zone_name,
                    'south_zone_incharge_name' => $request->south_zone_incharge_name,
                    'south_zone_mobile_no' => $request->south_zone_mobile_no,
                    'south_zone_incharge_email' => $request->south_zone_incharge_email,
                    'south_zone_name1' => $request->south_zone_name1,
                    'south_zone_incharge_name1' => $request->south_zone_incharge_name1,
                    'south_zone_mobile_no1' => $request->south_zone_mobile_no1,
                    'south_zone_incharge_email1' => $request->south_zone_incharge_email1,
                ]);

                if ($request->hasFile('company_logo')) {
                    $file = $request->file('company_logo');
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $setting->id . '.' . $extension;

                    Settings::findorfail($setting->id)->update([
                        'company_logo' => $this->fileUpload($file, 'upload/logo', $fileName)
                    ]);
                }

                $notification = array(
                    'message' => 'Settings created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('settings')->with($notification);
            } else {
                $oldImage = $request->logo;
                if ($request->hasFile('company_logo')) {
                    @unlink($oldImage);
                    $files = $request->file('company_logo');
                    $extensions = $files->getClientOriginalExtension();
                    $fileNames = $request->settingId . '.' . $extensions;
                }
                $isMaintenanceMode = $request->has('is_maintanance_mode') && $request->input('is_maintanance_mode') === 'on' ? 1 : 0;
                // dd($isMaintenanceMode);
                Settings::find(1)->update([
                    'is_maintanance_mode' => $isMaintenanceMode,
                    'otp_length' => $request->otp_length,
                    'otp_expiry_duration' => $request->otp_expiry_duration,
                    'company_logo' => ($request->hasFile('company_logo')) ? $this->fileUpload($request->file('company_logo'), 'upload/logo', $fileNames) : $oldImage,
                    'east_zone_name' => $request->east_zone_name,
                    'east_zone_incharge_name' => $request->east_zone_incharge_name,
                    'east_zone_mobile_no' => $request->east_zone_mobile_no,
                    'east_zone_incharge_email' => $request->east_zone_incharge_email,
                    'west_zone_name' => $request->west_zone_name,
                    'west_zone_incharge_name' => $request->west_zone_incharge_name,
                    'west_zone_mobile_no' => $request->west_zone_mobile_no,
                    'west_zone_incharge_email' => $request->west_zone_incharge_email,
                    'north_zone_name' => $request->north_zone_name,
                    'north_zone_incharge_name' => $request->north_zone_incharge_name,
                    'north_zone_mobile_no' => $request->north_zone_mobile_no,
                    'north_zone_incharge_email' => $request->north_zone_incharge_email,
                    'north_zone_name1' => $request->north_zone_name1,
                    'north_zone_incharge_name1' => $request->north_zone_incharge_name1,
                    'north_zone_mobile_no1' => $request->north_zone_mobile_no1,
                    'north_zone_incharge_email1' => $request->north_zone_incharge_email1,
                    'south_zone_name' => $request->south_zone_name,
                    'south_zone_incharge_name' => $request->south_zone_incharge_name,
                    'south_zone_mobile_no' => $request->south_zone_mobile_no,
                    'south_zone_incharge_email' => $request->south_zone_incharge_email,
                    'south_zone_name1' => $request->south_zone_name1,
                    'south_zone_incharge_name1' => $request->south_zone_incharge_name1,
                    'south_zone_mobile_no1' => $request->south_zone_mobile_no1,
                    'south_zone_incharge_email1' => $request->south_zone_incharge_email1,
                ]);

                $notification = array(
                    'message' => 'Settings updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('settings')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('settings')->with($notification);
        }
    }

    function orderSettingStore(Request $request)
    {
        $request->validate([
            'prefix' => 'required',
        ]);
        try {
            $data = orderSetting::first();
            $live = str_pad($data->live ?? 0, $request->length, "0", STR_PAD_LEFT);

            if ($request->orderId == null) {
                orderSetting::create([
                    'prefix' => $request->prefix,
                    'length' => $request->length,
                    'live' => $live
                ]);
                DB::commit();
                $notification = array(
                    'message' => 'Order No Settings Created Successfully',
                    'alert' => 'success'
                );
            } else {
                orderSetting::findorfail($request->orderId)->update([
                    'prefix' => $request->prefix,
                    'length' => $request->length,
                    'live' => $live
                ]);
                DB::commit();
                $notification = array(
                    'message' => 'Order No Settings Updated Successfully',
                    'alert' => 'success'
                );
            }
        } catch (Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Order No Settings Not Updated!',
                'alert' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        return redirect()->route('settings')->with($notification);
    }
}
