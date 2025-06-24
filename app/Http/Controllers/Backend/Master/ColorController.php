<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
    use Common;

    function color()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Color')) {
            return view('backend.admin.master.color');
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function colorCreate(Request $request)
    {
        $request->validate([
            'color_name' => [
                'required',
                Rule::unique('colors', 'color_name')
                    ->whereNull('deleted_at')
                    ->ignore($request->colorId)
            ],
        ], [
            'color_name.required' => 'Color is required',
            'color_name.unique' => 'Color is already exists!',
        ]);

        DB::beginTransaction();
        try {
            if ($request->colorId == Null) {
                Color::Create([
                    'color_name' => $request->color_name,
                    'created_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Color Name created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('color')->with($notification);
            } else {

                Color::findorfail($request->colorId)->update([
                    'color_name' => $request->color_name,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Color Name Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('color')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('color')->with($notification);
        }
    }

    public function getColorData()
    {
        $color = Color::orderBy('id', 'ASC')
            ->get();

        return datatables()->of($color)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function getColorById($id)
    {
        try {
            $color = Color::where('id', $id)->first();
            return response()->json([
                'color' => $color
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteColor(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $colorcount = Product::where('color_id', $id)->count();
            if ($colorcount == 0) {
                $color = Color::findorfail($id);
                $color->delete();
                $color->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Color Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Color Could Not Be Deleted!',
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
                'message' => 'Color could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function colorStatus($id, $status)
    {
        try {
            Color::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
