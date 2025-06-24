<?php

namespace App\Imports;

use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportRole implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Define validation rules
        $validator = Validator::make(['role_name' => $row['role_name']], [
            'role_name' => [
                'required',
                Rule::unique('roles', 'role_name'),
            ],
        ]);

        if ($validator->fails()) {
            throw new Exception('Duplicate record found for Role: ' . $row['role_name']);
        }
        $role = new Role([
            'role_name' => $row['role_name'],
            'created_by' => Auth::user()->id
        ]);

        return $role;
    }
}
