<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'collections';

    protected $fillable = [
        'collection_name',
        'collection_image',
        'size_id',
        'project_id',
        'category_id',
        'content',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function size()
    {
        return $this->belongsTo(CollectionImageSize::class, 'size_id');
    }
}
