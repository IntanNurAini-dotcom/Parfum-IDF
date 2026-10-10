<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'size',
        'top_notes',
        'middle_notes',
        'base_notes',
        'image',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getImageUrlAttribute(): string
    {
        // 1. If absolute HTTP URL (e.g. Unsplash or external CDN)
        if (!empty($this->image) && str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        // 2. If uploaded path in storage exists (e.g. storage/app/public/products/...)
        if (!empty($this->image) && file_exists(storage_path('app/public/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        // 3. Direct public path check (e.g. public/products/{slug}.jpg)
        if (!empty($this->image) && file_exists(public_path($this->image))) {
            return asset($this->image);
        }

        // 4. Conventional slug check in storage: storage/app/public/products/{slug}.*
        $extensions = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
        foreach ($extensions as $ext) {
            if (file_exists(storage_path("app/public/products/{$this->slug}.{$ext}"))) {
                return asset("storage/products/{$this->slug}.{$ext}");
            }
        }

        // 5. Conventional slug check in public: public/images/products/{slug}.*
        foreach ($extensions as $ext) {
            if (file_exists(public_path("images/products/{$this->slug}.{$ext}"))) {
                return asset("images/products/{$this->slug}.{$ext}");
            }
        }

        // 6. Elegant Pink Gold SVG Placeholder fallback
        return asset('images/placeholders/product-placeholder.svg');
    }
}
