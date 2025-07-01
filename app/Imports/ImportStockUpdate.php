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
            $stock = Product::where('DesignNo', $row['designno'])->first();

            if (!$stock) {
                continue;
            }

            $stock = Product::find($stock->id);
            $this->processedProductIds[] = $stock->id;

            $box = $row['style'];
            $purity = $row['purity'];
            $size = $row['size'];
            $weight = $row['weight'];
            

            // If same style, update; otherwise create new entry
            if ($stock->style === $box && $stock->weight === $weight && $stock->Purity === $purity && $stock->size === $size) {
                $stock->qty = $row['qty'];
                $stock->save();
            } else {
                Product::create([
                    'DesingNo' => $row['designno'],
                    'product_image' => $row['designno'] . '.jpg',
                    'weight' => $row['weight'],
                    'color' => $row['color'],
                    'style' => $row['style'],
                    'Project' => $stock->Project,
                    'Category' => $stock->Category,
                    'Subcategory' => $stock->Subcategory,
                    'Purity' => $row['purity'],
                    'size' => $row['size'],
                    'qty' => $row['qty'],
                    'Jeweltype' => $stock->Jeweltype,
                    'Item' => $stock->Item,
                    'Procatgory' => $stock->Procatgory,
                    'unit' => $row['unit'],
                    'making' => $row['making']
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
