<?php

namespace App\Http\Controllers\Backend\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use Common;

    function profile()
    {
        $user = User::select('users.*', 'roles.role_name')
            ->join('roles', 'roles.id', 'users.role_id')
            ->where('users.id', Auth::user()->id)
            ->first();
        return view('backend.admin.profile.profile', compact('user'));
    }

    function profileUpdate(Request $request)
    {
        try {
            $user = User::find(Auth::user()->id);
            User::where('id', Auth::user()->id)->update([
                'name' => $request->name != "" ? $request->name : $user->name,
                'bio' => $request->bio != "" ? $request->bio : $user->bio
            ]);
            if ($request->hasFile('user_image')) {
                if ($user->user_image) {
                    @unlink(public_path($user->user_image));
                }
                $file = $request->file('user_image');
                $extension = $file->getClientOriginalExtension();
                $fileName = $this->generateRandom(16) . '.' . $extension;

                User::findorfail(Auth::user()->id)->update([
                    'user_image' => $request->file('user_image') ? $this->fileUpload($file, 'upload/user/' . Auth::user()->id, $fileName) : $request->userImage
                ]);
            }
            $notification = array(
                'message' => 'Profile updated successfully',
                'alert' => 'success'
            );
            return redirect()->route('profile')->with($notification);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('profile')->with($notification);
        }
    }
}
