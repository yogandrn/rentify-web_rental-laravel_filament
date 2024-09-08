<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'brand_categories';
    protected $primary = 'id';

    protected $fillable = [
        'brand_id', 
        'category_id',
    ];

    public function category() : BelongsTo 
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand() : BelongsTo 
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
}
