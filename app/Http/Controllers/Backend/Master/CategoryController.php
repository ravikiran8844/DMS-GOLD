<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Imports\ImportCategory;
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

class CategoryController extends Controller
{
    use Common;

    function category()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Category')) {
            $project = Project::where('is_active', 1)->whereNull('deleted_at')->get();
            return view('backend.admin.master.category', compact('project'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function categoryCreate(Request $request)
    {
        $request->validate([
            'project_name' => 'required',
            'category_name' => [
                'required',
                Rule::unique('categories', 'category_name')
                    ->where('project_id', $request->project_name)
                    ->whereNull('deleted_at')
                    ->ignore($request->hdCategoryId)
            ],
            'category_image' => ($request->hdCategoryId == null) ? 'required|dimensions:height=280,width=280' : 'dimensions:height=280,width=280,category_image'
        ], [
            'category_name.required' => 'Category Name is required',
            'category_name.unique' => 'Category Name is already exists!',
            'category_image.required' => 'Category Image is Required',
            'category_image.dimensions' => 'Please Upload Image in dimension 280 * 280 px',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hdCategoryId == Null) {
                $category = Category::Create([
                    'project_id' => $request->project_name,
                    'category_name' => $request->category_name,
                    'created_by' => Auth::user()->id
                ]);

                if ($request->hasFile('category_image')) {
                    $file = $request->file('category_image');
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $category->id . '.' . $extension;

                    Category::findorfail($category->id)->update([
                        'category_image' => $this->fileUpload($file, 'upload/category', $fileName)
                    ]);
                }

                $notification = array(
                    'message' => 'Category created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('category')->with($notification);
            } else {

                $oldImage = $request->categoryImage;
                if ($request->hasFile('category_image')) {
                    @unlink($oldImage);
                    $files = $request->file('category_image');
                    $extensions = $files->getClientOriginalExtension();
                    $fileNames = $request->hdCategoryId . '.' . $extensions;
                }
                Category::findorfail($request->hdCategoryId)->update([
                    'project_id' => $request->project_name,
                    'category_name' => $request->category_name,
                    'category_image' => ($request->hasFile('category_image')) ? $this->fileUpload($request->file('category_image'), 'upload/category/', $fileNames) : $oldImage,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Category Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('category')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('category')->with($notification);
        }
    }

    public function getCategoryData()
    {
        $category = Category::select('categories.*', 'projects.project_name')
            ->join('projects', 'projects.id', 'categories.project_id')
            ->whereNull('categories.deleted_at')
            ->orderBy('categories.id', 'ASC')
            ->get();

        return datatables()->of($category)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function getCategoryById($id)
    {
        try {
            $category = Category::where('id', $id)->first();
            return response()->json([
                'category' => $category
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteCategory(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $categorycount = SubCategory::where('category_id', $id)->count();
            $productcategorycount = Product::where('category_id', $id)->count();
            if ($categorycount == 0 && $productcategorycount) {
                $category = Category::findorfail($id);
                $category->delete();
                $category->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Category Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Category Could Not Be Deleted!',
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
                'message' => 'Category could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function categoryStatus($id, $status)
    {
        try {
            Category::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function importCategory(Request $request)
    {
        try {
            Excel::import(new ImportCategory, $request->file('categoryimport')->store('files'));
            $notification = array(
                'message' => 'Category imported successfully',
                'alert' => 'success'
            );
            return redirect()->route('category')->with($notification);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => $e->getMessage(),
                'alert' => 'error'
            );
            return redirect()->route('category')->with($notification);
        }
    }
    public function downloadcategory()
    {
        $file_path = public_path('template/Category.xlsx');
        return response()->download($file_path);
    }
}
