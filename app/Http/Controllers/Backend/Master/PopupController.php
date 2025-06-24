<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PopupController extends Controller
{
    use Common;

    function popup()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Popup')) {
            $popup = Popup::get();
            return view('backend.admin.master.popup', compact('popup'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function popupCreate(Request $request)
    {
        $request->validate([
            'popup_image' => 'required|dimensions:height=414,width=1106', 'popup_image'
        ], [
            'popup_image.required' => 'Popup Image is Required',
            'popup_image.dimensions' => 'Please Upload Image in dimension 414 * 1106 px',
        ]);

        DB::beginTransaction();
        try {
            if ($request->popupId == Null) {
                $popup = Popup::Create([
                    'popup_url' => $request->popup_url
                ]);

                if ($request->hasFile('popup_image')) {
                    $file = $request->file('popup_image');
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $popup->id . '.' . $extension;

                    Popup::findorfail($popup->id)->update([
                        'popup_image' => $this->fileUpload($file, 'upload/popup', $fileName)
                    ]);
                }

                $notification = array(
                    'message' => 'Popup created successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('popup')->with($notification);
            } else {

                $oldImage = $request->PopupImage;
                if ($request->hasFile('popup_image')) {
                    @unlink($oldImage);
                    $files = $request->file('Popup_image');
                    $extensions = $files->getClientOriginalExtension();
                    $fileNames = $request->popupId . '.' . $extensions;
                }
                Popup::findorfail($request->popupId)->update([
                    'Popup_url' => $request->Popup_url,
                    'popup_image' => ($request->hasFile('Popup_image')) ? $this->fileUpload($request->file('popup_image'), 'upload/Popup', $fileNames) : $oldImage
                ]);

                $notification = array(
                    'message' => 'Popup Updated successfully',
                    'alert' => 'success'
                );

                DB::commit();
                return redirect()->route('popup')->with($notification);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            );
            return redirect()->route('popup')->with($notification);
        }
    }

    public function getPopupData()
    {
        $popup = Popup::orderBy('popups.id', 'ASC')
            ->get();

        return datatables()->of($popup)
            ->addColumn('action', function ($row) {
                $html = "";
                $html = '<a class="text-success mr-2 edit" onclick="doEdit(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/edit-pen.png') . '" ></a>';
                $html .= '<a class="text-danger delete" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"><img src="' . asset('backend/assets/img/icons/trash-bin.png') . '" ></a>';
                return $html;
            })->toJson();
    }

    function getPopupById($id)
    {
        try {
            $popup = Popup::where('id', $id)->first();
            return response()->json([
                'popup' => $popup
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deletePopup(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $popup = Popup::findorfail($id);
            $popup->delete();
            $popup->update([
                'deleted_by' => Auth::user()->id
            ]);

            $notification = array(
                'message' => 'Popup Deleted Successfully',
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
                'message' => 'Popup could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }
}
