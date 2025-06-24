<?php

namespace App\Http\Controllers\Backend\Stock;

use App\Http\Controllers\Controller;
use App\Imports\ImportStockUpdate;
use App\Jobs\ImportStockJob;
use App\Models\Order;
use App\Models\Product;
use App\Models\StockImport;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    use Common;

    function stock()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Stock Maintenance')) {
            return view('backend.admin.stock.stock');
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    public function getStockData()
    {
        try {
            $query = Product::select('products.*', 'styles.style_name')
                ->join('styles', 'styles.id', 'products.style_id')
                ->whereNull('products.deleted_at')
                ->orderBy('products.id', 'ASC');

            return DataTables::of($query)
                ->filterColumn('style_name', function ($query, $keyword) {
                    $query->where('styles.style_name', 'like', "%{$keyword}%");
                })
                ->addColumn('action', function ($row) {
                    return '<input type="hidden" id="product_id' . $row->id . '" name="product_id" value="' . $row->id . '"><button type="button" title="Update" class="btn btn-primary" onclick="stockUpdate(' . $row->id . ');">Update</button>';
                })
                ->rawColumns(['action'])
                ->toJson();
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => $e->getMessage(),
                'alert' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function stockUpdate(Request $request)
    {
        $id = $request->product_id;
        Product::findOrFail($id)->update([
            'qty' => $request->qty
        ]);

        return response()->json(['message' => 'Stock Updated Successfully!']);
    }

    public function downloadStock()
    {
        $file_path = public_path('template/Stock.xlsx');
        return response()->download($file_path);
    }

    public function importStock(Request $request)
    {
        try {
            // Validate the uploaded file
            $request->validate([
                'stockimport' => 'required|file|mimes:xlsx,xls,csv',
            ]);

            // Store the uploaded file
            $filePath = $request->file('stockimport')->store('imports');

            // Create stock import record
            StockImport::create([
                'user_id' => Auth::id(),
                'file_path' => $filePath,
                'status' => 'pending'
            ]);

            // Dispatch the import job
            ImportStockJob::dispatch($filePath);

            // Return success message
            $notification = [
                'message' => 'Stock import started successfully. You will be notified once it is completed.',
                'alert' => 'success',
            ];

            return redirect()->route('stock')->with($notification);
        } catch (\Exception $e) {
            // Log the exception
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::id(), $request->ip(), gethostname());

            // Return error message
            $notification = [
                'message' => 'Error starting stock import: ' . $e->getMessage(),
                'alert' => 'error',
            ];

            return redirect()->route('stock')->with($notification);
        }
    }

    public function checkImportStatus()
    {
        $latest = StockImport::where('user_id', Auth::id())->latest()->first();

        return response()->json([
            'status' => $latest->status ?? null,
            'created_at' => $latest ? $latest->created_at->format('d M Y h:i A') : null
        ]);
    }
}
