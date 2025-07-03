<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Style;
use App\Models\SilverPurity;
use App\Models\Size;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ImportStockUpdate implements ToCollection, WithHeadingRow
{
    protected $processedProductIds = []; // Keep track of processed product IDs globally

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Try to find a product with the exact match
            $stock = Product::where('DesignNo', $row['designno'])
                ->where('style', $row['style'])
                ->where('weight', $row['weight'])
                ->where('Purity', $row['purity'])
                ->where('size', $row['size'])
                ->first();

            if ($stock) {
                $this->processedProductIds[] = $stock->id;
                $stock->qty = $row['qty'];
                $stock->save();
            } else {
                // Fallback: get one product with just the DesignNo to copy project/category/etc
                $base = Product::where('DesignNo', $row['designno'])->first();

                if (!$base) {
                    continue; // Skip if nothing to clone from
                }

                $newProduct = Product::create([
                    'DesignNo' => $row['designno'],
                    'product_image' => $row['designno'] . '.jpg',
                    'weight' => $row['weight'],
                    'color' => $row['color'],
                    'style' => $row['style'],
                    'Project' => $base->Project,
                    'Category' => $base->Category,
                    'Subcategory' => $base->Subcategory,
                    'Purity' => $row['purity'],
                    'size' => $row['size'],
                    'qty' => $row['qty'],
                    'Jeweltype' => $row['jeweltype'],
                    'Item' => $base->Item,
                    'Procatgory' => $base->Procatgory,
                    'unit' => $row['unit'],
                    'making' => $row['making']
                ]);
                $this->processedProductIds[] = $newProduct->id;
            }
        }
    }


    // Retrieve the processed product IDs after the import is done
    public function getProcessedProductIds()
    {
        return $this->processedProductIds;
    }
}
