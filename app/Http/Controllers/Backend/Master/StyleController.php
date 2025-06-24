<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Style;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StyleController extends Controller
{
    use Common;

    function style()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Style')) {
            return view('backend.admin.master.style');
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function styleCreate(Request $request)
    {
        $request->validate([
            'style' => [
                'required',
                Rule::unique('styles', 'style_name')
                    ->ignore($request->styleId)
            ],
        ], [
            'style.required' => 'Style is required',
            'style.unique' => 'Style is already exists!',
        ]);

        DB::beginTransaction();
        try {
            if ($request->styleId == Null) {
                Style::Create([
                    'style_name' => $request->style,
                    'created_by' => Auth::user()->id
                ]);
                                                                                            
                $notification = array(
                    'message' => 'Style created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('style')->with($notification);
            } else {

                Style::findorfail($request->styleId)->update([
                    'style_name' => $request->style,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Style Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('style')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('style')->with($notification);
        }
    }

    public function getStyleData()
    {
        $style = Style::orderBy('id', 'ASC')
            ->get();

        return datatables()->of($style)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '"></a>';
                return $html;
            })->toJson();
    }

    function getStyleById($id)
    {
        try {
            $style = Style::where('id', $id)->first();
            return response()->json([
                'style' => $style
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteStyle(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $stylecount = Product::where('style_id', $id)->count();
            if ($stylecount == 0) {
                $style = Style::findorfail($id);
                $style->delete();
                $style->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Style Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Style Could Not Be Deleted!',
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
                'message' => 'Style could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function styleStatus($id, $status)
    {
        try {
            Style::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
