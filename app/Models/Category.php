<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getImageUrlAttribute(): string
    {
        // 1. If absolute HTTP URL
        if (!empty($this->image) && str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        // 2. If path in storage exists (e.g. storage/app/public/categories/...)
        if (!empty($this->image) && file_exists(storage_path('app/public/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        // 3. Direct public path check (e.g. public/categories/{slug}.jpg)
        if (!empty($this->image) && file_exists(public_path($this->image))) {
            return asset($this->image);
        }

        // 4. Conventional beranda path: public/images/beranda/kategori-{slug}.*
        $extensions = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
        foreach ($extensions as $ext) {
            if (file_exists(public_path("images/beranda/kategori-{$this->slug}.{$ext}"))) {
                return asset("images/beranda/kategori-{$this->slug}.{$ext}");
            }
        }

        // 5. Conventional public path: public/images/categories/{slug}.*
        foreach ($extensions as $ext) {
            if (file_exists(public_path("images/categories/{$this->slug}.{$ext}"))) {
                return asset("images/categories/{$this->slug}.{$ext}");
            }
        }

        // 6. Fallback SVG placeholder
        return asset('images/placeholders/category-placeholder.svg');
    }
}
