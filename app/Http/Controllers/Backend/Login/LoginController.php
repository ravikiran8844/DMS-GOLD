<?php

namespace App\Http\Controllers\Backend\Login;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\User;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use Common;

    function login()
    {
        return view('backend.admin.login.login');
    }

    function generateOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile'   => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $setting = Settings::first();

        $generateOTP = $this->generateRandom($setting->otp_length);

        $user = User::where('mobile', $request->mobile)->first();

        if ($user) {
            $user->update([
                'mobile' => $request->mobile,
                // 'otp' => $generateOTP,  
                'otp' => 1111,
                'otp_expiry' => Carbon::now()->addMinutes($setting->otp_expiry_duration)
            ]);

            // Http::post('http://smpp.webtechsolution.co/http-tokenkeyapi.php?authentic-key=38365355504552434c55535445523438331659422996&senderid=SUPRPI&route=4&unicode=2&number=' . $request->mobile . '&message=%20Dear%20customer,%20Your%20OTP%20for%20SuperCluster-%CF%80%20is%20' . $generateOTP . '.%20Never%20share%20your%20OTP%20with%20anyone.%20Healthier%20YOU%20always.&templateid=1707165934779223803');
            // Http::post('http://smpp.webtechsolution.co/http-tokenkeyapi.php?authentic-key=38365355504552434c55535445523438331659422996&senderid=SUPRPI&route=4&unicode=2&number=' . $request->mobile . '&message=Dear%20Retailer,%20Your%20OTP%20for%20login%20is%20' . $generateOTP . '.%20Never%20share%20your%20OTP%20with%20anyone.%20Ghar%20Ghar%20Meh%20Emerald.%20Powered%20By%20SuperCluster%20Pi.&templateid=1707171619928618375');
        } else {
            $notification = array(
                'message' => 'You are not a Registered user please contact our CRM to register',
                'alert' => 'error'
            );
            return view('backend.admin.error.otperror')->with($notification);
        }

        // Store a value in the session
        Session::put('mobile', $request->mobile);

        $notification = array(
            'message' => 'OTP sent successfully!',
            'alert' => 'success'
        );

        return redirect()->route('adminloginverify')->with($notification);
    }

    function loginVerify()
    {
        // Retrieve the value from the session
        $mobile = Session::get('mobile');
        $otp = User::where('mobile', $mobile)->value('otp');
        return view('backend.admin.login.loginverify', compact('mobile', 'otp'));
    }

    function loginVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp'   => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user = User::where('mobile', $request->mobile)->first();
        if ($user) {
            if ($user->otp == $request->otp && Carbon::now() <= $user->otp_expiry && $user->is_active == 1) {
                Auth::login($user);
                // Store the user's role ID in the session
                // Store a value in the session
                Session::put('user_role_id', Auth::user()->role_id);
                $notification = array(
                    'message' => 'Logged In successfully!',
                    'alert' => 'success'
                );
                if (Auth::user()->role_id == Roles::Dealer) {
                    return redirect()->route('landing')->with($notification);
                } elseif (Auth::user()->role_id == Roles::CRM) {
                    return redirect()->route('order')->with($notification);
                } else {
                    return redirect()->route('order')->with($notification);
                }
            } else {
                if ($user->is_active == 0) {
                    $notification = array(
                        'message' => 'You are unable to login contact admin',
                        'alert' => 'error'
                    );
                } else {
                    $notification = array(
                        'message' =>  Carbon::now() <= $user->otp_expiry ? 'OTP Expired!' : 'Incorrect OTP!',
                        'alert' => 'error'
                    );
                }

                return redirect()->back()->with($notification);
            }
        } else {
            // Handle the case when the user does not exist
            $notification = array(
                'message' => 'User not found!',
                'alert' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    function logout()
    {
        Auth::logout();
        Session::flush();
        request()->session()->invalidate();
        $notification = array(
            'message' => 'Logged Out Successfully',
            'alert' => 'success'
        );

        return redirect()->route('adminlogin')->with($notification);
    }
}
