<?php

namespace App\Traits;

use App\Models\Log;
use App\Models\Product;
use App\Models\RolePermissions;
use App\Models\User;
use App\Models\UserRolePermission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait Common
{
    public function Log($transaction_name, $mode, $log_message, $user_id, $ip_address, $system_name, $is_app = 0)
    {
        Log::create([
            'transaction_name' => $transaction_name,
            'mode' => $mode,
            'log_message' => $log_message,
            'user_id' => $user_id,
            'ip_address' => $ip_address,
            'system_name' =>  $system_name,
            'is_app' =>  $is_app,
            'log_date' => Carbon::now()
        ]);
    }

    public function fileUpload($fileinput, $filepath, $fileName)
    {
        $fileinput->move(public_path($filepath), $fileName);
        return $filepath . '/' . $fileName;
    }

    public function generateRandom($digit)
    {
        $min = pow(10, $digit - 1);
        $max = pow(10, $digit) - 1;
        return rand($min, $max);
    }

    public function permissionCheck($user_id, $menu_name)
    {
        $user = User::find($user_id); // Retrieve the user by ID

        // Check if the user has the required role
        if ($user && $user->role_id !== 1) {
            $permissionCheck = UserRolePermission::join('menus', 'user_role_permissions.menu_id', 'menus.id')
                ->where('user_role_permissions.user_id', $user_id)
                ->select('menus.menu_name', 'user_role_permissions.menu_id')
                ->get()
                ->toArray();

            $filteredPermissions = array_filter($permissionCheck, function ($item) use ($menu_name) {
                return $item['menu_name'] === $menu_name;
            });

            return !empty($filteredPermissions);
        }

        return true; // User has role_id 1 or does not exist
    }

    function createUser($company_name, $email, $mobile, $role_id)
    {
        $user = User::Create([
            'role_id' => $role_id,
            'name' => $company_name,
            'email' => $email,
            'mobile' => $mobile
        ]);

        $menus = RolePermissions::where('role_id', $role_id)->pluck('menu_id')->toArray();
        foreach ($menus as $menu) {
            UserRolePermission::create([
                'user_id' => $user->id,
                'menu_id' => $menu,
                'is_edit' =>  0,
                'is_delete' =>  0,
                'is_view' => 0,
                'is_print' => 0,
                'created_by' => Auth::user()->id
            ]);
        }

        return $user;
    }

    function updateUser($user_id, $company_name, $email, $mobile, $role_id)
    {
        User::where('id', $user_id)->Update([
            'role_id' => $role_id,
            'name' => $company_name,
            'email' => $email,
            'mobile' => $mobile
        ]);

        $existing_role_id = User::where('id', $user_id)->value('role_id');

        if ($existing_role_id != $role_id) {
            $menus = RolePermissions::where('role_id', $role_id)->pluck('menu_id')->toArray();
            foreach ($menus as $menu) {
                UserRolePermission::create([
                    'user_id' => $user_id,
                    'menu_id' => $menu,
                    'is_edit' =>  0,
                    'is_delete' =>  0,
                    'is_view' => 0,
                    'is_print' => 0,
                    'created_by' => Auth::user()->id
                ]);
            }
        }
    }

    function getproducts($user_id)
    {
        $product = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.is_active', 1)
            ->whereNull('products.deleted_at')
            // ->where('product_unique_id', 'not like', '%A%')
            // ->where('product_unique_id', 'not like', '%GP%')
            // ->where('product_unique_id', 'not like', '%G%')
            ->whereNotExists(function ($query) {
                $query->selectRaw(1)
                    ->from('products as p2')
                    ->whereRaw('p2.product_unique_id = products.product_unique_id')
                    ->whereRaw('p2.created_at > products.created_at');
            });

        return $product;
    }
}
