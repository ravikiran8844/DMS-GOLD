<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Shape;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ShapeController extends Controller
{
    use Common;

    function shape()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Shape')) {
            return view('backend.admin.master.shape');
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function shapeCreate(Request $request)
    {
        $request->validate([
            'shape_name' => [
                'required',
                Rule::unique('shapes', 'shape_name')
                    ->ignore($request->shapeId)
            ],
        ], [
            'shape_name.required' => 'Shape Name is required',
            'shape_name.unique' => 'Shape Name is already exists!',
        ]);

        DB::beginTransaction();
        try {
            if ($request->shapeId == Null) {
                Shape::Create([
                    'shape_name' => $request->shape_name,
                    'created_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Shape Name created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('shape')->with($notification);
            } else {

                Shape::findorfail($request->shapeId)->update([
                    'shape_name' => $request->shape_name,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Shape Name Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('shape')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('shape')->with($notification);
        }
    }

    public function getShapeData()
    {
        $shape = Shape::orderBy('id', 'ASC')
            ->get();

        return datatables()->of($shape)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function getShapeById($id)
    {
        try {
            $shape = Shape::where('id', $id)->first();
            return response()->json([
                'shape' => $shape
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deletePlating(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $shape = Shape::findorfail($id);
            $shape->delete();
            $shape->update([
                'deleted_by' => Auth::user()->id
            ]);

            $notification = array(
                'message' => 'Shape Deleted Successfully',
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
                'message' => 'Shape could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function shapeStatus($id, $status)
    {
        try {
            Shape::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
