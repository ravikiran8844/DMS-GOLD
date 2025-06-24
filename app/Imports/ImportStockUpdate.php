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
            // Validate each row
            $validator = Validator::make([
                'product_unique_id' => $row['product_sku'],
                'qty' => $row['qty'],
                'purity' => $row['purity']
            ], [
                'product_unique_id' => 'required',
                'qty' => 'required|integer|min:0', // Validate quantity as an integer and non-negative
                'purity' => 'required|string',
            ]);

            if ($validator->fails()) {
                // Handle validation failure and continue to the next row
                continue; // Optionally log the error or send notifications for skipped rows
            }

            // Process if SKU is not empty
            if (!empty($row['product_sku'])) {
                $product = Product::where('product_unique_id', $row['product_sku'])
                    ->orderBy('id', 'desc')
                    ->first();

                if (!$product) {
                    // Skip if the product is not found
                    continue;
                }

                // Find the existing stock for the product
                $stock = Product::find($product->id);

                if ($stock) {
                    // Track this product's ID as processed
                    $this->processedProductIds[] = $stock->id;

                    // Find the box style or get the default one
                    $box_id = Style::where('style_name', $row['box'])
                        ->where('project_id', $stock->project_id)
                        ->value('id');

                    $defaultbox_id = $box_id === null ? Style::where('project_id', $stock->project_id)->value('id') : null;

                    // Find purity and size IDs
                    $purityId = SilverPurity::where('silver_purity_percentage', $row['purity'])->value('id');
                    $sizeId = Size::where('project_id', $stock->project_id)
                        ->where('size', $row['size'])
                        ->where('is_active', 1)
                        ->value('id');

                    // If the product style matches the box or no box was found, update the stock
                    if ($stock->style_id == $box_id || !$box_id) {
                        $stock->qty = $row['qty'];
                        $stock->purity_id = $purityId;
                        $stock->size_id = $sizeId;
                        $stock->updated_by = Auth::id();
                        $stock->save();
                    } else {
                        // Create a new product entry if the box/style doesn't match
                        Product::create([
                            'product_unique_id' => $stock->product_unique_id,
                            'product_name' => $stock->product_name,
                            'product_image' => str_replace('+', '-', $stock->product_image),
                            'product_price' => $stock->product_price,
                            'designed_date' => $stock->designed_date,
                            'design_updated_date' => $stock->design_updated_date,
                            'height' => $stock->height,
                            'depth' => $stock->depth,
                            'density' => $stock->density,
                            'width' => $stock->width,
                            'weight' => $stock->weight,
                            'product_carat' => $stock->product_carat,
                            'color_id' => $stock->color_id,
                            'style_id' => $box_id ?? $defaultbox_id,
                            'finish_id' => $stock->finish_id,
                            'project_id' => $stock->project_id,
                            'category_id' => $stock->category_id,
                            'sub_category_id' => $stock->sub_category_id,
                            'collection_id' => $stock->collection_id,
                            'sub_collection_id' => $stock->sub_collection_id,
                            'metal_type_id' => $stock->metal_type_id,
                            'plating_id' => $stock->plating_id,
                            'purity_id' => $purityId,
                            'size_id' => $sizeId,
                            'classification_id' => $stock->classification_id,
                            'crwcolcode' => $stock->crwcolcode,
                            'crwsubcolcode' => $stock->crwsubcolcode,
                            'keywordtags' => $stock->keywordtags,
                            'net_weight' => $stock->net_weight,
                            'qty' => $row['qty'],
                            'moq' => 1,
                            'created_by' => Auth::id(),
                        ]);
                    }
                }
            }
        }
    }

    // Retrieve the processed product IDs after the import is done
    public function getProcessedProductIds()
    {
        return $this->processedProductIds;
    }
}
