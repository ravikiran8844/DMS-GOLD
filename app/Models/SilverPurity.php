<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SilverPurity extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'silver_purity_name',
        'silver_purity_percentage'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'purity_id');
    }
}
