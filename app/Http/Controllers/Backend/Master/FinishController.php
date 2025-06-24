<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Finish;
use App\Models\OrderDetail;
use App\Models\Project;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FinishController extends Controller
{
    use Common;

    function finish()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Finish')) {
            $project = Project::whereNull('deleted_at')->get();
            return view('backend.admin.master.finish', compact('project'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function finishCreate(Request $request)
    {
        $request->validate([
            'project_name' => 'required',
            'finish_name' => [
                'required',
                Rule::unique('finishes', 'finish_name')
                    ->where('project_id', $request->project_name)
                    ->whereNull('deleted_at')
                    ->ignore($request->finishId)
            ],
        ], [
            'project_name.required' => 'Project Name is required',
            'finish_name.required' => 'Finish Name is required',
            'finish_name.unique' => 'Finish Name is already exists!',
        ]);

        DB::beginTransaction();
        try {
            if ($request->finishId == Null) {
                Finish::Create([
                    'project_id' => $request->project_name,
                    'finish_name' => $request->finish_name,
                    'created_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Finish created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('finish')->with($notification);
            } else {


                Finish::findorfail($request->finishId)->update([
                    'project_id' => $request->project_name,
                    'finish_name' => $request->finish_name,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Finish Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('finish')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('finish')->with($notification);
        }
    }

    public function getFinishData()
    {
        $finish = Finish::select('finishes.*', 'projects.project_name')->join('projects', 'projects.id', 'finishes.project_id')->whereNull('finishes.deleted_at')
            ->orderBy('finishes.id', 'ASC')
            ->get();

        return datatables()->of($finish)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '"></a>';
                return $html;
            })->toJson();
    }

    function getFinishById($id)
    {
        try {
            $finish = Finish::where('id', $id)->first();
            return response()->json([
                'finish' => $finish
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteFinish(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $finishcount = OrderDetail::where('finish', $id)->count();
            if ($finishcount == 0) {
                $finish = Finish::findorfail($id);
                $finish->delete();
                $finish->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Finish Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Finish Could Not Be Deleted!',
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
                'message' => 'Finish could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function finishStatus($id, $status)
    {
        try {
            Finish::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
