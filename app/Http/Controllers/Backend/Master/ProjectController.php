<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Project;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    use Common;

    function project()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Project')) {
            return view('backend.admin.master.project');
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function projectCreate(Request $request)
    {
        $request->validate([
            'project_name' => [
                'required',
                Rule::unique('projects', 'project_name')
                    ->whereNull('deleted_at')
                    ->ignore($request->projectId)
            ],
        ], [
            'project_name.required' => 'Project Name is required',
            'project_name.unique' => 'Project Name is already exists!',
        ]);

        DB::beginTransaction();
        try {
            if ($request->projectId == Null) {
                Project::Create([
                    'project_name' => $request->project_name,
                    'created_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Project created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('project')->with($notification);
            } else {


                Project::findorfail($request->projectId)->update([
                    'project_name' => $request->project_name,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Project Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('project')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('project')->with($notification);
        }
    }

    public function getProjectData()
    {
        $project = Project::whereNull('deleted_at')
            ->orderBy('id', 'ASC')
            ->get();

        return datatables()->of($project)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function getProjectById($id)
    {
        try {
            $project = Project::where('id', $id)->first();
            return response()->json([
                'project' => $project
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteProject(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $projectcount = Product::where('project_id', $id)->count();
            $categorycount = Category::where('project_id', $id)->count();
            if ($projectcount == 0 && $categorycount == 0) {
                $project = Project::findorfail($id);
                $project->delete();
                $project->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Project Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Project Could Not Be Deleted!',
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
                'message' => 'Project could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function projectStatus($id, $status)
    {
        try {
            Project::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
