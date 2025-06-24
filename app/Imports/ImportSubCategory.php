<?php

namespace App\Imports;

use App\Models\SubCategory;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportSubCategory implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Define validation rules
        $validator = Validator::make(['sub_category_name' => $row['sub_category_name']], [
            'sub_category_name' => [
                'required',
                Rule::unique('sub_categories', 'sub_category_name')
                    ->where('category_id', $row['category_id']),
            ],
        ]);

        if ($validator->fails()) {
            throw new Exception('Duplicate record found for Subcategory: ' . $row['sub_category_name']);
        }

        $category = new SubCategory([
            'category_id' => $row['category_id'],
            'sub_category_name' => $row['sub_category_name'],
            'created_by' => Auth::user()->id
        ]);

        return $category;
    }
}
