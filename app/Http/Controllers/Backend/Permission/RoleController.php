<?php

namespace App\Http\Controllers\Backend\Permission;

use App\Http\Controllers\Controller;
use App\Imports\ImportRole;
use App\Models\Role;
use App\Models\User;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class RoleController extends Controller
{
    use Common;

    public function roles()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Roles')) {
            return view('backend.admin.permissions.roles');
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function roleCreate(Request $request)
    {
        $request->validate([
            'role_name' => [
                'required',
                Rule::unique('roles', 'role_name')
                    ->whereNull('deleted_at')
                    ->ignore($request->hdRoleId)
            ],
        ], [
            'role_name.required' => 'Role Name is required',
            'role_name.unique' => 'Role Name is already exists!',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hdRoleId == Null) {
                Role::Create([
                    'role_name' => $request->role_name,
                    'created_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Role created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('role')->with($notification);
            } else {
                Role::findorfail($request->hdRoleId)->update([
                    'role_name' => $request->role_name,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Role Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('role')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('role')->with($notification);
        }
    }

    public function getRoleData()
    {
        $role = Role::where('id', '!=', 1)
            ->whereNull('deleted_at')
            ->orderBy('id', 'ASC')
            ->get();

        return datatables()->of($role)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function getRoleById($id)
    {
        try {
            $role = Role::where('id', $id)->first();
            return response()->json([
                'role' => $role
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteRole(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $rolecount = User::where('role_id', $id)->count();
            if ($rolecount == 0) {
                $role = Role::findorfail($id);
                $role->delete();
                $role->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Role Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Role Could Not Be Deleted!',
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
                'message' => 'Role could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function roleStatus($id, $status)
    {
        try {
            Role::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function importRole(Request $request)
    {
        try {
            Excel::import(new ImportRole, $request->file('roleimport')->store('files'));
            $notification = array(
                'message' => 'Role imported successfully',
                'alert' => 'success'
            );
            return redirect()->route('role')->with($notification);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => $e->getMessage(),
                'alert' => 'error'
            );
            return redirect()->route('role')->with($notification);
        }
    }
}
