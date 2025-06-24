<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Color;
use App\Models\Finish;
use App\Models\Product;
use App\Models\ProductMultipleImage;
use App\Models\Project;
use App\Models\SubCategory;
use App\Models\Unit;
use App\Traits\Common;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportProduct implements ToModel, WithHeadingRow
{
    use Common;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Define validation rules
        $validator = Validator::make(
            ['product_unique_id' => $row['product_unique_id']],
            ['product_name' => $row['product_name']],
            [
                'product_unique_id' => [
                    'required',
                    Rule::unique('products', 'product_unique_id'),
                ]
            ]
        );

        if ($validator->fails()) {
            throw new Exception('Duplicate record found for product: ' . $row['product_unique_id']);
        }

        $colorId = Color::where('color_name', 'like', '%' . $row['default_color']  . '%')->value('id');
        $styleId = Color::where('color_name', 'like', '%' . $row['default_style']  . '%')->value('id');
        $finishId = Finish::where('finish_name', 'like', '%' . $row['finish']  . '%')->value('id');
        $projectName = $row['project'];
        // Remove "SIL" from the project name
        $projectNameWithoutSIL = str_replace('SIL ', '', $projectName);
        $projectId = Project::where('project_name', 'like', '%' . $projectNameWithoutSIL . '%')->value('id');
        $categoryId = Category::where('category_name', $row['category_id'])->value('id');
        $subCategoryId = SubCategory::where('sub_category_name', $row['sub_category_id'])->value('id');
        $unitId = Unit::where('unit_name', $row['unit_id'])->value('id');
        $product = new Product([
            'product_unique_id' => $row['product_unique_id'],
            'product_name' => $row['product_name'],
            // 'product_price' => $row['product_price'],
            'product_image' => $row['product_image'],
            // 'designed_date' => Carbon::parse($row['designed_date'])->format('Y-m-d'),
            // 'design_updated_date' => Carbon::parse($row['design_updated_date'])->format('Y-m-d'),
            'height' => $row['height'],
            'width' => $row['width'],
            // 'depth' => $row['depth'],
            // 'density' => $row['density'],
            'weight' => $row['weight'],
            'product_carat' => $row['product_carat'],
            'color_id' => $colorId,
            'style_id' => $styleId,
            'finish_id' => $finishId,
            // 'size_id' => $row['size_id'],
            // 'finishing' => $row['finishing'],
            'project_id' => $projectId,
            // 'base_product' => $row['base_product'],
            'category_id' => $categoryId,
            'sub_category_id' => $subCategoryId,
            // 'zone_id' => $row['zone_id'],
            // 'collection_id' => $row['collection_id'],
            // 'sub_collection_id' => $row['sub_collection_id'],
            'metal_type_id' => $row['metal_type_id'],
            // 'brand_id' => $row['brand_id'],
            // 'jewel_type_id' => $row['jewel_type_id'],
            // 'purity_id' => $row['purity_id'],
            'plating_id' => $row['plating_id'],
            // 'shape' => $row['shape'],
            'making_percent' => $row['making_percent'],
            'moq' => $row['moq'],
            // 'hallmarking' => $row['hallmarking'],
            'crwcolcode' => $row['crwcolcode'],
            'crwsubcolcode' => $row['crwsubcolcode'],
            'gender' => $row['gender'],
            'cwqty' => $row['cwqty'],
            'qty' => $row['qty'],
            'unit_id' => $unitId,
            'net_weight' => $row['net_weight'],
            'keywordtags' => $row['keywordtags'],
            'otherrate' => $row['otherrate'],
            'created_by' => Auth::user()->id
        ]);

        $product->save();

        // if (isset($row['product_multiple_image']) && $row['product_multiple_image'] != "") {
        //     $productMultipleImages = explode(',', $row['product_multiple_image']);

        //     foreach ($productMultipleImages as $imagePath) {
        //         ProductMultipleImage::create([
        //             'product_id' => $product->id,
        //             'product_images' => $imagePath
        //         ]);
        //     }
        // }

        return $product;
    }
}
