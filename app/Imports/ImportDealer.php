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
        $validator = Validator::make(['email' => $row['email']], [
            'email' => [
                'required',
                Rule::unique('dealers', 'email'),
                Rule::unique('users', 'email'),
            ]
        ]);
        if ($validator->fails()) {
            throw new Exception('Duplicate record found for dealer: ' . $row['email']);
        }

        $zones = Zone::where('zone_name', $row['zone'])->get();
        // Choose the first matching zone, or handle multiple matches as needed
        $zone = $zones->first();

        $zoneId = $zone ? $zone->id : null;

        $dealer = new Dealer([
            'company_name' => $row['company_name'],
            'communication_address' => $row['communication_address'],
            'mobile' => $row['mobile'],
            'email' => $row['email'],
            'a_name' => $row['a_name'],
            'a_designation' => $row['a_designation'],
            'a_mobile' => $row['a_mobile'],
            'a_email' => $row['a_email'],
            'b_name' => $row['b_name'],
            'b_designation' => $row['b_designation'],
            'b_mobile' => $row['b_mobile'],
            'b_email' => $row['b_email'],
            'gst' => $row['gst'],
            'income_tax_pan' => $row['income_tax_pan'],
            'bank_name' => $row['bank_name'],
            'branch_name' => $row['branch_name'],
            'address' => $row['address'],
            'account_number' => $row['account_number'],
            'account_type' => $row['account_type'],
            'ifsc' => $row['ifsc'],
            'cheque_leaf' => $row['cheque_leaf'],
            'gst_certificate' => $row['gst_certificate'],
            'zone_id' =>  $zoneId,
            'city' => $row['city'],
            'state' => $row['state'],
            'created_by' => Auth::user()->id
        ]);
        $user = User::create([
            'role_id' => Roles::Dealer,
            'name' => $row['company_name'],
            'email' => $row['email'],
            'mobile' => $row['mobile'],
            'zone_id' => $zoneId,
            'city' => $row['city'],
            'state' => $row['state'],
        ]);
        // Update the user_id on the Dealer model
        $dealer->user_id = $user->id;
        $dealer->save(); // Save the dealer again with the updated user_id

        return $dealer;
    }
}
