<?php

namespace App\Http\Controllers\Retailer\Login;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Models\Dealer;
use App\Models\Role;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserPhone;
use App\Models\Zone;
use App\Traits\Common;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    use Common;

    function register()
    {
        $dealer = User::where('role_id', Roles::Dealer)->where('is_active', 1)->get();
        $state = User::select('state')->where('role_id', Roles::Dealer)
            ->where('is_active', 1)->where('state', '!=', NULL)->distinct()->get();
        $zone = Zone::where('is_active', 1)->whereNull('deleted_at')->get();
        return view('retailer.login.register', compact('dealer', 'state', 'zone'));
    }

    function registerStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'retailer_name' => 'required',
            // 'address' => 'required',
            'mobile' => [
                'required',
                Rule::unique('users', 'mobile')
                    ->ignore($request->dealerId)
            ],
            'retailer_email' => [
                'required',
                Rule::unique('users', 'email')
                    ->ignore($request->dealerId)
            ],
            'company_name' => 'required',
            'pincode' => 'required',
            'district' =>  'required',
            'state' =>  'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => implode(",", $validator->errors()->all())
            ]);
        }
        DB::beginTransaction();
        try {

            $user = User::Create([
                'role_id' => Roles::Retailer,
                'shop_name' => $request->company_name,
                'name' => $request->retailer_name,
                'mobile' => $request->mobile,
                'email' => $request->retailer_email,
                'state' => $request->state,
                'district' => $request->district,
                'pincode' => $request->pincode,
                'dealer_details' => $request->dealer_details,
                'GST' => $request->GST,
                'address' => $request->address,
            ]);
            DB::commit();
            Auth::login($user);
            return response()->json([
                'alert' => 'success',
                'message' => 'Retailer Created Successfully'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            return response()->json([
                'alert' => 'error',
                'message' => 'Something Went Wrong!'
            ]);
        }
    }

    function  getDealers(Request $request)
    {
        $dealer = User::select('id', 'name', 'city')->where('role_id', Roles::Dealer)->where('is_active', 1)->where('zone_id', $request->zone)->get();
        return response()->json([
            'dealers' => $dealer
        ]);
    }

    function login()
    {
        return view('retailer.login.login');
    }

    function generateOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => implode(",", $validator->errors()->all())
            ]);
        }
        $setting = Settings::first();

        $generateOTP = $this->generateRandom($setting->otp_length);

        $user = User::where('mobile', $request->mobile)
            ->where(function ($query) {
                $query->where('role_id', Roles::Retailer)
                    ->orWhere('role_id', Roles::CRM)
                    ->orWhere('role_id', Roles::Dealer);
            })->first();

        // Then check UserPhone
        $userPhone = UserPhone::where('mobile', $request->mobile)->first();

        if ($userPhone || $user) {
            // Update OTP in the correct table
            if ($userPhone) {
                $userPhone->update([
                    'otp' => $generateOTP,
                    'otp_expiry' => Carbon::now()->addSeconds($setting->otp_expiry_duration)
                ]);
                $role_id = 3;
            } elseif ($user) {
                $user->update([
                    'otp' => $generateOTP,
                    'otp_expiry' => Carbon::now()->addSeconds($setting->otp_expiry_duration)
                ]);
                $role_id = $user->role_id;
            }

            $client = new Client();

            $response = $client->request('GET', 'https://139.99.131.165/api/v2/SendSMS', [
                'query' => [
                    'SenderId' => 'EJIILD',
                    'TemplateId' => '1707172743911436796',
                    'Message' => 'Dear Retailer, Your OTP for login is ' . $generateOTP . '. Never Share your OTP with anyone. Ghar Ghar Meh Emerald.',
                    'PrincipleEntityId' => '1701158072168761159',
                    'ApiKey' => 'ef058d2a-cb22-42a4-b82d-bf42ce5dd0e4',
                    'ClientId' => '219f5c0d-d4ca-4a4a-8941-4874cc29083f',
                    'MobileNumbers' => '' . $request->mobile . '',
                ],
                'verify' => false, // Disable SSL verification
            ]);

            // Ensure session is started
            if (!session()->isStarted()) {
                session()->start();
            }

            // Store OTP in a cookie
            cookie()->queue('mobile', $request->mobile, 60);
            // Store a value in the session
            Session::put('mobile', $request->mobile);
            return response()->json(['message' => 'OTP sent successfully!', 'role_id' => $role_id], 200);
        } else {
            // Store a value in the session
            Session::put('mobile', $request->mobile);
            return response()->json(['message' => 'You are not a registered user. Please register first.'], 200);
        }
    }

    function loginVerify(Request $request)
    {
        // Retrieve the value from the session
        $mobile = $request->session()->get('mobile');
        // If session value is not available, retrieve it from the cookie
        if (!$mobile) {
            $mobile = $request->cookie('mobile');
        }
        $otp = User::where('mobile', $mobile)->value('otp');
        return view('retailer.login.loginverify', compact('mobile', 'otp'));
    }

    public function loginVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
            'mobilenumber' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'alert' => 'error',
                'message' => implode(",", $validator->errors()->all())
            ]);
        }

        $mobile = $request->mobilenumber;
        $otp = $request->otp;

        // Step 1: Check directly in User table
        $user = User::where('mobile', $mobile)
            ->whereIn('role_id', [Roles::Retailer, Roles::CRM, Roles::Dealer])
            ->first();

        if ($user) {
            // Found in User table
            if ($user->otp == $otp && Carbon::now()->lte($user->otp_expiry)) {
                if ($user->is_active == 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You are unable to login. Please contact admin.'
                    ]);
                }

                Auth::login($user);
                return response()->json([
                    'success' => true,
                    'message' => 'OTP verified successfully.'
                ]);
            } else {
                $message = 'Incorrect OTP.';
                if (Carbon::now()->gt($user->otp_expiry)) {
                    $message = 'OTP Expired.';
                }

                return response()->json([
                    'success' => false,
                    'message' => $message
                ]);
            }
        }

        // Step 2: If not in User table, check UserPhone
        $userPhone = UserPhone::where('mobile', $mobile)->first();

        if ($userPhone) {
            if ($userPhone->otp == $otp && Carbon::now()->lte($userPhone->otp_expiry)) {
                $linkedUser = User::find($userPhone->user_id);

                if ($linkedUser && $linkedUser->is_active == 1) {
                    Auth::login($linkedUser);
                    return response()->json([
                        'success' => true,
                        'message' => 'OTP verified successfully.'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'You are unable to login. Please contact admin.'
                    ]);
                }
            } else {
                $message = 'Incorrect OTP.';
                if (Carbon::now()->gt($userPhone->otp_expiry)) {
                    $message = 'OTP Expired.';
                }

                return response()->json([
                    'success' => false,
                    'message' => $message
                ]);
            }
        }

        // Step 3: No user found at all
        return response()->json([
            'success' => false,
            'message' => 'User not found.'
        ]);
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

        return redirect('/')->with($notification);
    }

    public function getPincodeData($pincode)
    {
        $response = Http::get("https://api.postalpincode.in/pincode/{$pincode}");

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Failed to fetch data'], $response->status());
    }
}
