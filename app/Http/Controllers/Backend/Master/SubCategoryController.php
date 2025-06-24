<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Imports\ImportSubCategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\Project;
use App\Models\SubCategory;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class SubCategoryController extends Controller
{
    use Common;

    function subCategory()
    {
        $project = Project::where('is_active', 1)->whereNull('deleted_at')->get();
        if ($this->permissionCheck(Auth::user()->id, 'Sub Category')) {
            return view('backend.admin.master.subcategory', compact('project'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function getCategory(Request $request)
    {
        $category = Category::where('project_id', $request->project_id)
            ->where('is_active', 1)
            ->WhereNull('deleted_at')
            ->get();

        return response()->json([
            'category' => $category
        ]);
    }

    function subCategoryCreate(Request $request)
    {
        $request->validate([
            'project_name' => 'required',
            'category_name' => 'required',
            'sub_category_name' => [
                'required',
                Rule::unique('sub_categories', 'sub_category_name')
                    ->where('category_id', $request->category_name)
                    ->whereNull('deleted_at')
                    ->ignore($request->hdSubCategoryId)
            ]
        ], [
            'project_name.required' => 'Project Name is required',
            'category_name.required' => 'Category Name is required',
            'sub_category_name.required' => 'Sub Category Name is required',
            'sub_category_name.unique' => 'Category Name is already exists!',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hdSubCategoryId == Null) {
                SubCategory::Create([
                    'project_id' => $request->project_name,
                    'category_id' => $request->category_name,
                    'sub_category_name' => $request->sub_category_name,
                    'created_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Sub Category created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('subcategory')->with($notification);
            } else {
                SubCategory::findorfail($request->hdSubCategoryId)->update([
                    'project_id' => $request->project_name,
                    'category_id' => $request->category_name,
                    'sub_category_name' => $request->sub_category_name,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Sub Category Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('subcategory')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('subcategory')->with($notification);
        }
    }

    public function getSubCategoryData()
    {
        $category = SubCategory::select('sub_categories.*', 'categories.category_name', 'projects.project_name')
            ->join('projects', 'projects.id', 'sub_categories.project_id')
            ->join('categories', 'categories.id', 'sub_categories.category_id')
            ->whereNull('sub_categories.deleted_at')
            ->orderBy('sub_categories.id', 'ASC')
            ->get();

        return datatables()->of($category)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '"></a>';
                return $html;
            })->toJson();
    }

    function getSubCategoryById($id)
    {
        try {
            $subcategory = SubCategory::where('id', $id)->first();
            return response()->json([
                'subcategory' => $subcategory
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteSubCategory(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $categorycount = Product::where('category_id', $id)->count();
            if ($categorycount == 0) {
                $subCategory = SubCategory::findorfail($id);
                $subCategory->delete();
                $subCategory->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Sub Category Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Sub Category Could Not Be Deleted!',
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
                'message' => 'Sub Category could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function subCategoryStatus($id, $status)
    {
        try {
            SubCategory::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function importSubCategory(Request $request)
    {
        try {
            Excel::import(new ImportSubCategory, $request->file('subcategoryimport')->store('files'));
            $notification = array(
                'message' => 'Sub Category imported successfully',
                'alert' => 'success'
            );
            return redirect()->route('subcategory')->with($notification);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => $e->getMessage(),
                'alert' => 'error'
            );
            return redirect()->route('subcategory')->with($notification);
        }
    }

    public function downloadsubcategory()
    {
        $file_path = public_path('template/Subcategory.xlsx');
        return response()->download($file_path);
    }
}
