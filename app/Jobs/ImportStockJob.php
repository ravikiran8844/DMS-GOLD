<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Imports\ImportStockUpdate;
use App\Models\Product;
use App\Models\StockImport;

class ImportStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 3600; // Set the timeout for the job (in seconds)
    public $tries = 2; // Allow 2 attempts before failing completely

    protected $filePath;

    /**
     * Create a new job instance.
     *
     * @param string $filePath The path to the uploaded file.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            // Initialize the Import class
            $import = new ImportStockUpdate;

            // Run the import
            Excel::import($import, storage_path('app/' . $this->filePath));

            // Get all processed product IDs
            $processedProductIds = $import->getProcessedProductIds();
            Log::debug('Processed product IDs: ', $processedProductIds);
            // Reset qty to 0 for all products not processed in this import
            Product::whereNotIn('id', $processedProductIds)->update(['qty' => 0]);
            // Update import status to completed
            StockImport::where('file_path', $this->filePath)->update(['status' => 'completed']);
            // Optionally log success or notify admin/user
            Log::info('Stock import completed successfully.');
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Stock import failed: ' . $e->getMessage());
            // Optionally, you can implement notification to admin or user here
        }
    }
}
