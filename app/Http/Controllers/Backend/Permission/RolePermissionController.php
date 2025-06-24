<?php

namespace App\Http\Controllers\Backend\Permission;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RolePermissions;
use App\Models\User;
use App\Models\UserPhone;
use App\Models\UserRolePermission;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RolePermissionController extends Controller
{
    use Common;

    function rolePermission()
    {
        $roles = Role::where('id', '!=', 1)->get();
        $menus = Menu::where('is_visible', 1)->get();

        if ($this->permissionCheck(Auth::user()->id, 'Menu Permission')) {
            return view('backend.admin.permissions.role_permission', compact('roles', 'menus'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function rolePermissionCreate(Request $request)
    {
        $request->validate([
            'role_name' => $request->roleId == null ? ['required', Rule::unique('role_permissions', 'role_id')
                ->ignore($request->roleId)] : ''
        ]);

        $menus = Menu::where('is_visible', 1)->get();

        DB::beginTransaction();

        try {
            if ($request->roleId == null) {
                // Create role permissions
                foreach ($menus as $item) {
                    $menuValues = $request->input("menu{$item->id}", []);

                    if (!empty($menuValues) && is_array($menuValues)) {
                        foreach ($menuValues as $value) {
                            RolePermissions::create([
                                'role_id' => $request->role_name,
                                'menu_id' => $value,
                                'created_by' => Auth::user()->id
                            ]);
                        }
                    }
                }
            } else {
                // Update role permissions
                $existingMenuIds = [];

                foreach ($menus as $item) {
                    $menuValues = $request->input("menu{$item->id}", []);

                    if (!empty($menuValues) && is_array($menuValues)) {
                        $existingMenuIds = array_merge($existingMenuIds, $menuValues);
                    }
                }

                // Delete role permissions not in $existingMenuIds
                RolePermissions::where('role_id', $request->roleId)
                    ->whereNotIn('menu_id', $existingMenuIds)
                    ->delete();

                // Update or create role permissions for each menu
                foreach ($menus as $item) {
                    $menuValues = $request->input("menu{$item->id}", []);

                    if (!empty($menuValues) && is_array($menuValues)) {
                        foreach ($menuValues as $value) {
                            RolePermissions::updateOrCreate(
                                [
                                    'role_id' => $request->roleId,
                                    'menu_id' => $value
                                ],
                                [
                                    'updated_by' => Auth::user()->id
                                ]
                            );
                        }
                    }
                }
            }

            // Commit the transaction
            DB::commit();

            $notification = [
                'message' => $request->roleId == null ? 'Role Permission created successfully' : 'Role Permission updated successfully',
                'alert' => 'success'
            ];

            return redirect()->route('rolepermission')->with($notification);
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            $notification = [
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            ];

            return redirect()->route('rolepermission')->with($notification);
        }
    }

    public function getRolePermissionData()
    {
        $rolepermission = RolePermissions::select('roles.id as id', DB::raw('MAX(roles.role_name) as role_name'))
            ->join('roles', 'roles.id', 'role_permissions.role_id')
            ->groupBy('roles.id')
            ->get();

        return datatables()->of($rolepermission)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');" ><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '"></a>';
                return $html;
            })->toJson();
    }

    function getRolePermissionById($id)
    {
        try {
            $rolepermission = RolePermissions::where('role_id', $id)
                ->get();
            return response()->json([
                'rolepermission' => $rolepermission
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function users()
    {
        $roles = RolePermissions::select('roles.id as id', DB::raw('MAX(roles.role_name) as role_name'))
            ->join('roles', 'roles.id', 'role_permissions.role_id')
            ->groupBy('roles.id')
            ->get();

        if ($this->permissionCheck(Auth::user()->id, 'Users')) {
            return view('backend.admin.permissions.user', compact('roles'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    public function listMenus($id)
    {
        try {
            $getMenuId = RolePermissions::select('menu_id')->where('role_id', '=', $id)->get()->toArray();
            $menu = Menu::where('is_visible', 1)->whereIn('id', $getMenuId)->get();
            return response()->json([
                'menu' => $menu
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function createUser(Request $request)
    {

        $request->validate([
            'mobile' => [
                'required',
                Rule::unique('users', 'mobile')
                    ->ignore($request->userId)
            ],
            'email' => [
                'required',
                Rule::unique('users', 'email')
                    ->ignore($request->userId)
            ],
        ]);

        DB::beginTransaction();
        try {
            $user_id = $request->userId;

            if ($user_id === null) {
                $user = User::create([
                    'role_id' => $request->role_name,
                    'mobile' => $request->mobile,
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
                $user_id = $user->id;
            } else {
                $user = User::findOrFail($user_id);
                $user->update([
                    'role_id' => $request->role_name,
                    'mobile' => $request->mobile,
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
            }

            // Delete existing role permissions for the user
            UserRolePermission::where('user_id', $user_id)->delete();

            $menuIds = $request['menuId'];

            foreach ($menuIds as $row) {
                $menuPermissionData = [
                    'menu_id' => $row,
                    'is_edit' => $request['checkEdit'][$row][0] ?? 0,
                    'is_delete' => $request['checkDelete'][$row][0] ?? 0,
                    'is_view' => $request['checkView'][$row][0] ?? 0,
                    'is_print' => $request['checkPrint'][$row][0] ?? 0,
                    'user_id' => $user_id,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ];

                UserRolePermission::create($menuPermissionData);
            }

            $notification = [
                'message' => ($user_id === null) ? 'User Created Successfully' : 'User Updated Successfully',
                'alert' => 'success',
            ];

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $notification = [
                'message' => 'User Not Updated!',
                'alert' => 'error',
            ];
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }

        return redirect()->route('users')->with($notification);
    }

    public function getUserPermissionData()
    {
        $userRoleData = User::select('users.*', 'roles.role_name')
            ->join('roles', 'roles.id', 'users.role_id')
            ->where('users.role_id', '!=', Roles::SuperAdmin)
            ->get();

        return datatables()->of($userRoleData)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    public function getUserPermissionById($id)
    {
        try {
            $userPermission = User::select('users.*', 'roles.role_name')->join('roles', 'roles.id', 'users.role_id')
                ->where('users.id', '!=', 1)->where('users.id', $id)->first();

            $userMenuPermission = UserRolePermission::where('user_id', $id)->get();

            return response()->json([
                'userPermission' => $userPermission,
                'userMenuPermission' => $userMenuPermission
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function rolePermissionStatus($id, $status)
    {
        try {
            User::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    function addUserPhone()
    {
        $users = User::where('role_id', 3)
            ->get();
        return view('backend.admin.permissions.add_user_phone', compact('users'));
    }

    function userPhoneCreate(Request $request)
    {
        $request->validate([
            'mobile' => [
                'required',
                'min:10',
                function ($attribute, $value, $fail) use ($request) {
                    $existsInUsers = DB::table('users')->where('mobile', $value)->exists();
                    $existsInUserPhones = DB::table('user_phones')
                        ->where('mobile', $value)
                        ->where('id', '!=', $request->hdUserPhoneId) // ignore current editing ID
                        ->exists();

                    if ($existsInUsers || $existsInUserPhones) {
                        $fail('Mobile already exists!');
                    }
                },
            ],
            'user' => 'required',
        ], [
            'mobile.required' => 'Mobile is required',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hdUserPhoneId == Null) {
                UserPhone::Create([
                    'user_id' => $request->user,
                    'mobile' => $request->mobile
                ]);

                $notification = array(
                    'message' => 'User Phone created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('adduserphone')->with($notification);
            } else {
                UserPhone::findorfail($request->hdUserPhoneId)->update([
                    'user_id' => $request->user,
                    'mobile' => $request->mobile
                ]);

                $notification = array(
                    'message' => 'User Phone Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('adduserphone')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('adduserphone')->with($notification);
        }
    }

    public function getUserPhoneData()
    {
        $user = UserPhone::select('user_phones.*', 'users.name')
            ->join('users', 'users.id', 'user_phones.user_id')
            ->get();

        return datatables()->of($user)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function getUserPhoneById($id)
    {
        try {
            $user = UserPhone::where('id', $id)->first();
            return response()->json([
                'user' => $user
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteUserPhone(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = UserPhone::findorfail($id);
            $user->delete();

            $notification = array(
                'message' => 'User Phone Deleted Successfully',
                'alert' => 'success'
            );
            DB::commit();
            return response()->json([
                'responseData' => $notification
            ]);
        } catch (Exception $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
            $notification = array(
                'message' => 'Role could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }
}
