<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $parfumIdfCategory = Category::where('slug', 'parfum-idf')->first();
        $bodyMistCategory = Category::where('slug', 'body-mist')->first();

        if (!$parfumIdfCategory || !$bodyMistCategory) {
            $this->command->error('Categories must be seeded first! Run CategorySeeder.');
            return;
        }

        $products = [
            // --- Parfum IDF Collection (50 ml, Rp 249.000) ---
            [
                'category_id' => $parfumIdfCategory->id,
                'name' => 'Aura Marle',
                'slug' => 'aura-marle',
                'description' => 'Wewangian elegan yang memancarkan aura keanggunan lembut dan pesona mewah tak terlupakan.',
                'price' => 249000,
                'stock' => 50,
                'size' => '50ml',
                'top_notes' => 'Citrus Bergamot, Pear, Pink Pepper',
                'middle_notes' => 'White Floral, Jasmine, Iris',
                'base_notes' => 'Amberwood, Vanilla, White Musk',
                'image' => 'products/aura-marle.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => $parfumIdfCategory->id,
                'name' => 'Rose Haze',
                'slug' => 'rose-haze',
                'description' => 'Sentuhan aroma mawar mekar yang romantis dengan kehangatan kayu kasmir yang memikat.',
                'price' => 249000,
                'stock' => 50,
                'size' => '50ml',
                'top_notes' => 'Damask Rose, Red Apple',
                'middle_notes' => 'Peony, Violet, Rose Petals',
                'base_notes' => 'Sandalwood, Cashmere Wood',
                'image' => 'products/rose-haze.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => $parfumIdfCategory->id,
                'name' => 'Golden One',
                'slug' => 'golden-one',
                'description' => 'Kemewahan wewangian berkelas dengan kilau aroma amber emas dan kayu oud yang kharismatik.',
                'price' => 249000,
                'stock' => 50,
                'size' => '50ml',
                'top_notes' => 'Saffron, Mandarin Orange',
                'middle_notes' => 'Golden Amber, Cinnamon',
                'base_notes' => 'Oud, Smoky Vanilla, Cedarwood',
                'image' => 'products/golden-one.jpg',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'category_id' => $parfumIdfCategory->id,
                'name' => 'Eterna Black',
                'slug' => 'eterna-black',
                'description' => 'Karakter wewangian malam yang tegas, misterius, dan penuh daya pikat eksekutif.',
                'price' => 249000,
                'stock' => 50,
                'size' => '50ml',
                'top_notes' => 'Black Currant, Cardamom',
                'middle_notes' => 'Black Orchid, Leather',
                'base_notes' => 'Dark Patchouli, Vetiver, Amber',
                'image' => 'products/eterna-black.jpg',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'category_id' => $parfumIdfCategory->id,
                'name' => 'Botanica Rosea',
                'slug' => 'botanica-rosea',
                'description' => 'Keharmonisan segar taman bunga mawar alami yang memberikan ketenangan dan kesegaran abadi.',
                'price' => 249000,
                'stock' => 50,
                'size' => '50ml',
                'top_notes' => 'Green Leaf, Bergamot',
                'middle_notes' => 'Wild Rose, Lily of the Valley',
                'base_notes' => 'White Musk, Cedarwood',
                'image' => 'products/botanica-rosea.jpg',
                'is_featured' => false,
                'is_active' => true,
            ],

            // --- Body Mist Collection (100 ml, Rp 99.000) ---
            [
                'category_id' => $bodyMistCategory->id,
                'name' => 'Luxcury Out',
                'slug' => 'luxcury-out',
                'description' => 'Body mist segar dengan aroma gaya hidup aktif yang memberikan semangat setiap saat.',
                'price' => 99000,
                'stock' => 50,
                'size' => '100ml',
                'top_notes' => 'Citrus Zest, Sea Salt',
                'middle_notes' => 'Lavender, Sage',
                'base_notes' => 'Ambergris, Driftwood',
                'image' => 'products/luxcury-out.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => $bodyMistCategory->id,
                'name' => 'Night Eclipse',
                'slug' => 'night-eclipse',
                'description' => 'Kesegaran body mist beraroma buah gelap dan bunga malam yang hangat nan manis.',
                'price' => 99000,
                'stock' => 50,
                'size' => '100ml',
                'top_notes' => 'Midnight Plum, Blackberry',
                'middle_notes' => 'Night Orchid, Freesia',
                'base_notes' => 'Tonka Bean, Vanilla Musk',
                'image' => 'products/night-eclipse.jpg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => $bodyMistCategory->id,
                'name' => "Vleured'or",
                'slug' => 'vleuredor',
                'description' => 'Pancaran kesegaran buah peach dan kehangatan bunga emas yang manis mempesona.',
                'price' => 99000,
                'stock' => 50,
                'size' => '100ml',
                'top_notes' => 'Sweet Peach, Neroli',
                'middle_notes' => 'Golden Blossom, Orange Flower',
                'base_notes' => 'Soft Amber, Musk',
                'image' => 'products/vleuredor.jpg',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'category_id' => $bodyMistCategory->id,
                'name' => 'Royale Deluxe',
                'slug' => 'royale-deluxe',
                'description' => 'Body mist ringan bergaya mewah untuk kesegaran sehabis mandi dan aktivitas sehari-hari.',
                'price' => 99000,
                'stock' => 50,
                'size' => '100ml',
                'top_notes' => 'Sparkling Grapefruit, Mint',
                'middle_notes' => 'White Tea, Rosewater',
                'base_notes' => 'Sandalwood, Musk',
                'image' => 'products/royale-deluxe.jpg',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'category_id' => $bodyMistCategory->id,
                'name' => 'Baby Soie',
                'slug' => 'baby-soie',
                'description' => 'Keharuman lembut sehalus sutra dengan sentuhan aroma bedak bayi yang menenangkan.',
                'price' => 99000,
                'stock' => 50,
                'size' => '100ml',
                'top_notes' => 'Soft Powder, Almond Milk',
                'middle_notes' => 'Chamomile, White Rose',
                'base_notes' => 'Baby Musk, Soft Vanilla',
                'image' => 'products/baby-soie.jpg',
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        $validSlugs = [];

        foreach ($products as $productData) {
            $validSlugs[] = $productData['slug'];
            Product::updateOrCreate(
                ['slug' => $productData['slug']],
                $productData
            );
        }

        // Delete old sample products not in the valid list from products table
        Product::whereNotIn('slug', $validSlugs)->delete();

        // Delete old categories not in the valid 2 categories
        Category::whereNotIn('slug', ['parfum-idf', 'body-mist'])->delete();
    }
}
