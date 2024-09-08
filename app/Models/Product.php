<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';
    protected $primary = 'id';

    protected $fillable = [
        'name', 
        'slug',
        'about',
        'thumbnail',
        'price',
        'category_id',
        'brand_id',
    ];

    protected $with = [
        'category:id,name,slug',
        'brand:id,name,slug',
        'pictures:id,product_id,url_asset'
    ];

    protected $casts = [
        'price' => MoneyCast::class,
    ];

    public function setNameAttribute($value) 
    {
        $this->attributes['name'] = $value;
        
        // Hanya menghasilkan slug jika nama baru berbeda dari nama sebelumnya
        if ($this->exists && $this->name === $value) {
            // Jika nama tidak berubah, jangan ubah slug
            return;
        }

        // Buat slug dasar
        $slug = Str::slug($value);
        
        // Cek apakah slug sudah ada, termasuk data yang di-soft delete
        $originalSlug = $slug;
        $count = 1;
        
        while (Product::withTrashed()->where('slug', $slug)->exists()) {
            // Jika slug sudah ada, tambahkan angka di belakang untuk membuatnya unik
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // Set slug yang unik
        $this->attributes['slug'] = $slug;
    }

    public function category() : BelongsTo {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand() : BelongsTo {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function pictures() : HasMany {
        return $this->hasMany(ProductPicture::class, 'product_id', 'id');
    }

}
