<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportStockUpdate implements ToCollection, WithHeadingRow
{
    protected $processedProductIds = []; // Keep track of processed product IDs globally

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                // Find the base product by DesignNo
                $base = Product::where('DesignNo', $row['designno'])->first();

                // If not found, create the base product
                if (!$base) {
                    $base = Product::create([
                        'DesignNo' => $row['designno'],
                        'product_image' => $row['designno'] . '.jpg',
                        'weight' => $row['weight'],
                        'color' => $row['color'],
                        'style' => $row['style'],
                        'Project' => $row['project'] ?? null,
                        'Category' => $row['category'] ?? null,
                        'Subcategory' => $row['subcategory'] ?? null,
                        'Purity' => $row['purity'],
                        'size' => $row['size'],
                        'qty' => $row['qty'],
                        'Jeweltype' => $row['jeweltype'],
                        'Item' => $row['item'] ?? null,
                        'Procatgory' => $row['procatgory'] ?? null,
                        'unit' => $row['unit'],
                        'making' => $row['making']
                    ]);
                }

                // Check if this specific variant already exists
                $variant = ProductVariant::where('product_id', $base->id)
                    ->where('weight', $row['weight'])
                    ->where('color', $row['color'])
                    ->where('size', $row['size'])
                    ->where('Purity', $row['purity'])
                    ->where('style', $row['style'])
                    ->where('unit', $row['unit'])
                    ->where('making', $row['making'])
                    ->first();

                if ($variant) {
                    $variant->qty = $row['qty'];
                    $variant->save();
                } else {
                    ProductVariant::create([
                        'product_id' => $base->id,
                        'weight' => $row['weight'],
                        'color' => $row['color'],
                        'style' => $row['style'],
                        'Purity' => $row['purity'],
                        'size' => $row['size'],
                        'qty' => $row['qty'],
                        'unit' => $row['unit'],
                        'making' => $row['making'],
                    ]);
                }

                $this->processedProductIds[] = $base->id;
            } catch (Exception $e) {
                Log::error('Error processing row ' . $index . ': ' . $e->getMessage(), [
                    'row_data' => $row->toArray(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }
    }


    // Retrieve the processed product IDs after the import is done
    public function getProcessedProductIds()
    {
        return $this->processedProductIds;
    }
}
