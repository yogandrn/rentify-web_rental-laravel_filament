<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'brands';
    protected $primary = 'id';

    protected $fillable = [
        'name', 
        'slug',
        'logo',
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
        
        while (Brand::withTrashed()->where('slug', $slug)->exists()) {
            // Jika slug sudah ada, tambahkan angka di belakang untuk membuatnya unik
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // Set slug yang unik
        $this->attributes['slug'] = $slug;
    }

    public function products() : HasMany {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    public function brand_categories() : HasMany {
        return $this->hasMany(BrandCategory::class, 'brand_id', 'id');
    }
}
