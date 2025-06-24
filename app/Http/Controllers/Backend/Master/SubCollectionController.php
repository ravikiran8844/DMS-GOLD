<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Project;
use App\Models\SubCollection;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SubCollectionController extends Controller
{
    use Common;

    function subCollection()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Sub Collections')) {
            $collection = Collection::where('is_active', 1)->whereNull('deleted_at')->get();
            $project = Project::where('is_active', 1)->whereNull('deleted_at')->get();
            return view('backend.admin.master.subcollection', compact('collection', 'project'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function subCollectionCreate(Request $request)
    {
        $request->validate([
            'sub_collection_name' => [
                'required',
                Rule::unique('collections', 'collection_name')
                    ->whereNull('deleted_at')
                    ->ignore($request->collectionId)
            ]
        ], [
            'sub_collection_name.required' => 'Sub Collection Name is required',
            'sub_collection_name.unique' => 'Sub Collection Name is already exists!',
        ]);

        DB::beginTransaction();
        try {
            if ($request->subCollectionId == Null) {
                SubCollection::Create([
                    'project_id' => $request->project,
                    'collection_id' => $request->collection,
                    'sub_collection_name' => $request->sub_collection_name,
                    'created_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Sub Collection created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('subcollection')->with($notification);
            } else {

                SubCollection::findorfail($request->subCollectionId)->update([
                    'project_id' => $request->project,
                    'collection_id' => $request->collection,
                    'sub_collection_name' => $request->sub_collection_name,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Sub Collection Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('subcollection')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('subcollection')->with($notification);
        }
    }

    public function getSubCollectionData()
    {
        $subcollection = SubCollection::select('sub_collections.*', 'collections.collection_name', 'projects.project_name')
            ->join('projects', 'projects.id', 'sub_collections.project_id')
            ->join('collections', 'collections.id', 'sub_collections.collection_id')
            ->whereNull('collections.deleted_at')
            ->orderBy('collections.id', 'ASC')
            ->get();

        return datatables()->of($subcollection)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function getSubCollectionById($id)
    {
        try {
            $subcollection = SubCollection::where('id', $id)->first();
            return response()->json([
                'subcollection' => $subcollection
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteSubCollection(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $collectioncount = Collection::where('id', $id)->count();
            $productcollectioncount = Product::where('collection_id', $id)->count();
            if ($collectioncount == 0 && $productcollectioncount == 0) {
                $collection = Collection::findorfail($id);
                $collection->delete();
                $collection->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Sub Collection Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Sub Collection Could Not Be Deleted!',
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
                'message' => 'Sub Collection could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function subCollectionStatus($id, $status)
    {
        try {
            SubCollection::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
