<?php

namespace App\Imports;

use App\Enums\Roles;
use App\Models\Dealer;
use App\Models\User;
use App\Models\Zone;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportDealer implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Define validation rules
        $validator = Validator::make(['mobile' => $row['phone_number']], [
            'mobile' => [
                'required',
                Rule::unique('dealers', 'mobile'),
                Rule::unique('users', 'mobile'),
            ]
        ]);
        if ($validator->fails()) {
            throw new Exception('Duplicate record found for dealer: ' . $row['phone_number']);
        }
        $dealer = new Dealer([
            'mobile' => $row['phone_number'],
            'zone' => $row['zone'],
            'code' => $row['code'],
            'customer_code' => $row['cus_code'],
            'person_name' => $row['person_name'],
            'party_name' => $row['party_name'],
            'created_by' => Auth::user()->id
        ]);
        $user = User::create([
            'role_id' => Roles::Dealer,
            'name' => $row['party_name'],
            'mobile' => $row['phone_number'],
            'zone' => $row['zone'],
        ]);
        // Update the user_id on the Dealer model
        $dealer->user_id = $user->id;
        $dealer->save(); // Save the dealer again with the updated user_id

        return $dealer;
    }
}
