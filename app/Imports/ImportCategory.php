<?php

namespace App\Imports;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportCategory implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        // Define validation rules
        $validator = Validator::make(['category_name' => $row['category_name']], [
            'category_name' => [
                'required',
                Rule::unique('categories', 'category_name'),
            ],
        ]);

        if ($validator->fails()) {
            throw new Exception('Duplicate record found for category: ' . $row['category_name']);
        }

        $category = new Category([
            'category_name' => $row['category_name'],
            'category_image' => $row['category_image'],
            'created_by' => Auth::user()->id
        ]);

        return $category;
    }
}
