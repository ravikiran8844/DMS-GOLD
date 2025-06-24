<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerPosition;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    use Common;

    function banner(Request $request)
    {
        if ($this->permissionCheck(Auth::user()->id, 'Banner')) {
            $bannerposition = BannerPosition::get();
            return view('backend.admin.master.banner', compact('bannerposition'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function getSize(Request $request)
    {
        $size = BannerPosition::where('id', $request->size_id)->first();
        return response()->json([
            'size' => $size
        ]);
    }

    function bannerCreate(Request $request)
    {
        $request->validate([
            'banner_image' => ($request->bannerId == null) ? 'required|dimensions:height=' . $request->height . ',width=' . $request->width . '' : 'dimensions:height=' . $request->height . ',width=' . $request->width . ',banner_image'
        ], [
            'banner_image.required' => 'Banner Image is Required',
            'banner_image.dimensions' => 'Please Upload Image in dimension ' . $request->height . ' * ' . $request->width . ' px',
        ]);

        DB::beginTransaction();
        try {
            if ($request->bannerId == Null) {
                $banner = Banner::Create([
                    'project' => $request->project,
                    'banner_url' => $request->banner_url,
                    'banner_position_id' => $request->bannerposition,
                    'created_by' => Auth::user()->id
                ]);

                if ($request->hasFile('banner_image')) {
                    $file = $request->file('banner_image');
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $banner->id . '.' . $extension;

                    Banner::findorfail($banner->id)->update([
                        'banner_image' => $this->fileUpload($file, 'upload/banner', $fileName)
                    ]);
                }

                $notification = array(
                    'message' => 'Banner created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('banner')->with($notification);
            } else {

                $oldImage = $request->bannerImage;
                if ($request->hasFile('banner_image')) {
                    @unlink($oldImage);
                    $files = $request->file('banner_image');
                    $extensions = $files->getClientOriginalExtension();
                    $fileNames = $request->bannerId . '.' . $extensions;
                }
                Banner::findorfail($request->bannerId)->update([
                    'banner_url' => $request->banner_url,
                    'project' => $request->project,
                    'banner_position_id' => $request->bannerposition,
                    'banner_image' => ($request->hasFile('banner_image')) ? $this->fileUpload($request->file('banner_image'), 'upload/banner', $fileNames) : $oldImage,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Banner Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('banner')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('banner')->with($notification);
        }
    }

    public function getBannerData()
    {
        $banner = Banner::select('banners.*', 'banner_positions.banner_position')
            ->join('banner_positions', 'banner_positions.id', 'banners.banner_position_id')
            ->orderBy('banners.id', 'ASC')
            ->get();

        return datatables()->of($banner)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function getBannerById($id)
    {
        try {
            $banner = Banner::where('id', $id)->first();
            return response()->json([
                'banner' => $banner
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteBanner(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $banner = Banner::findorfail($id);
            $banner->delete();
            $banner->update([
                'deleted_by' => Auth::user()->id
            ]);

            $notification = array(
                'message' => 'Banner Deleted Successfully',
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
                'message' => 'Banner could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function bannerStatus($id, $status)
    {
        try {
            Banner::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
