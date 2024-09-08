<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPicture extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_pictures';
    protected $primary = 'id';

    protected $fillable = [
        'product_id', 
        'url_asset',
    ];
}
