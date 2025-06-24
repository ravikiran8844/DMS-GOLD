<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\CollectionImageSize;
use App\Models\Product;
use App\Models\Project;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CollectionController extends Controller
{
    use Common;

    function collection()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Collections')) {
            $imageType = CollectionImageSize::get();
            $project = Project::where('is_active', 1)->whereNull('deleted_at')->get();
            $category = Category::where('is_active', 1)->whereNull('deleted_at')->get();
            return view('backend.admin.master.collection', compact('imageType', 'project', 'category'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function getSize(Request $request)
    {
        $size = CollectionImageSize::where('id', $request->size_id)->first();
        return response()->json([
            'size' => $size
        ]);
    }

    function collectionCreate(Request $request)
    {
        $request->validate([
            'collection_name' => [
                'required',
                Rule::unique('collections', 'collection_name')
                    ->whereNull('deleted_at')
                    ->ignore($request->collectionId)
            ],
            // 'collection_image' => ($request->collectionId == null) ? 'required|dimensions:height=' . $request->height . ',width=' . $request->width . '' : 'dimensions:' . $request->height . ',width=' . $request->width . ',collection_image'
        ], [
            'collection_name.required' => 'Collection Name is required',
            'collection_name.unique' => 'Collection Name is already exists!',
            // 'collection_image.required' => 'Collection Image is Required',
            // 'collection_image.dimensions' => 'Please Upload Image in dimension ' . $request->height . ' * ' . $request->width . ' px',
        ]);

        DB::beginTransaction();
        try {
            if ($request->collectionId == Null) {
                $collection = Collection::Create([
                    'collection_name' => $request->collection_name,
                    'size_id' => $request->image_type,
                    'project_id' => $request->project_name,
                    'category_id' => $request->category_name,
                    'content' => $request->content,
                    'created_by' => Auth::user()->id
                ]);

                if ($request->hasFile('collection_image')) {
                    $file = $request->file('collection_image');
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $collection->id . '.' . $extension;

                    Collection::findorfail($collection->id)->update([
                        'collection_image' => $this->fileUpload($file, 'upload/collection', $fileName)
                    ]);
                }

                $notification = array(
                    'message' => 'Collection created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('collection')->with($notification);
            } else {

                $oldImage = $request->collectionImage;
                if ($request->hasFile('collection_image')) {
                    @unlink($oldImage);
                    $files = $request->file('collection_image');
                    $extensions = $files->getClientOriginalExtension();
                    $fileNames = $request->hdCategoryId . '.' . $extensions;
                }
                Collection::findorfail($request->collectionId)->update([
                    'collection_name' => $request->collection_name,
                    'size_id' => $request->image_type,
                    'project_id' => $request->project_name,
                    'category_id' => $request->category_name,
                    'content' => $request->content,
                    'collection_image' => ($request->hasFile('collection_image')) ? $this->fileUpload($request->file('collection_image'), 'upload/collection/', $fileNames) : $oldImage,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Collection Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('collection')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('collection')->with($notification);
        }
    }

    public function getCollectionData()
    {
        $collection = Collection::select('collections.*', 'categories.category_name', 'projects.project_name')
            ->join('projects', 'projects.id', 'collections.project_id')
            ->join('categories', 'categories.id', 'collections.category_id')
            ->whereNull('collections.deleted_at')
            ->orderBy('collections.id', 'ASC')
            ->get();

        return datatables()->of($collection)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function getCollectionById($id)
    {
        try {
            $collection = Collection::where('id', $id)->first();
            return response()->json([
                'collection' => $collection
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteCollection(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $collectioncount = Product::where('collection_id', $id)->count();
            if ($collectioncount == 0) {
                $collection = Collection::findorfail($id);
                $collection->delete();
                $collection->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Collection Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Collection Could Not Be Deleted!',
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
                'message' => 'Collection could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function collectionStatus($id, $status)
    {
        try {
            Collection::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
