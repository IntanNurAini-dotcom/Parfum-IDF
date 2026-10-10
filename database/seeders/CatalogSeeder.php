<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $categories = [
            'parfum-idf' => [
                'name' => 'Parfum IDF',
                'description' => 'Koleksi parfum eksklusif Parfum IDF dengan karakter aroma yang elegan dan tahan lama.',
            ],
            'body-mist' => [
                'name' => 'Body Mist',
                'description' => 'Body mist yang segar dan lembut untuk menemani aktivitas sehari-hari.',
            ],
        ];

        $categoryIds = [];
        foreach ($categories as $slug => $c) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name' => $c['name'],
                    'description' => $c['description'],
                    'image' => "categories/{$slug}.jpg",
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
            $categoryIds[$slug] = DB::table('categories')->where('slug', $slug)->value('id');
        }

        $products = [
            [
                'cat' => 'parfum-idf', 'name' => 'Aura Marle', 'slug' => 'aura-marle',
                'price' => 249000, 'size' => '50 ml', 'featured' => true,
                'desc' => 'Aroma floral musk yang lembut dan bersih, memberi kesan anggun dan menenangkan sepanjang hari.',
                'top' => 'Bergamot, Pir', 'middle' => 'Melati, Peony', 'base' => 'White Musk, Cedar',
            ],
            [
                'cat' => 'parfum-idf', 'name' => 'Rose Haze', 'slug' => 'rose-haze',
                'price' => 249000, 'size' => '50 ml', 'featured' => false,
                'desc' => 'Mawar yang manis dan berkabut dengan sentuhan buah, feminin dan penuh pesona.',
                'top' => 'Raspberry, Lychee', 'middle' => 'Mawar Damascus, Peony', 'base' => 'Amber, Musk',
            ],
            [
                'cat' => 'parfum-idf', 'name' => 'Golden One', 'slug' => 'golden-one',
                'price' => 249000, 'size' => '50 ml', 'featured' => true,
                'desc' => 'Aroma hangat dan mewah dengan nuansa emas yang berkesan, cocok untuk momen istimewa.',
                'top' => 'Mandarin, Saffron', 'middle' => 'Melati, Oud Ringan', 'base' => 'Vanilla, Amber, Sandalwood',
            ],
            [
                'cat' => 'parfum-idf', 'name' => 'Eterna Black', 'slug' => 'eterna-black',
                'price' => 249000, 'size' => '50 ml', 'featured' => false,
                'desc' => 'Aroma gelap yang misterius dan berkarakter kuat, meninggalkan jejak yang sulit dilupakan.',
                'top' => 'Lada Hitam, Bergamot', 'middle' => 'Iris, Cedarwood', 'base' => 'Oud, Patchouli, Leather',
            ],
            [
                'cat' => 'parfum-idf', 'name' => 'Botanica Rosea', 'slug' => 'botanica-rosea',
                'price' => 249000, 'size' => '50 ml', 'featured' => false,
                'desc' => 'Perpaduan mawar dan hijau dedaunan yang segar, seperti berjalan di taman bunga di pagi hari.',
                'top' => 'Daun Hijau, Pir', 'middle' => 'Mawar, Lily of the Valley', 'base' => 'Cedar, White Musk',
            ],
            [
                'cat' => 'body-mist', 'name' => 'Luxcury Out', 'slug' => 'luxcury-out',
                'price' => 99000, 'size' => '100 ml', 'featured' => false,
                'desc' => 'Body mist segar dengan kesan mewah yang ringan, nyaman dipakai untuk aktivitas di luar ruangan.',
                'top' => 'Citrus, Apel Hijau', 'middle' => 'Freesia, Lily', 'base' => 'Musk, Kayu',
            ],
            [
                'cat' => 'body-mist', 'name' => 'Night Eclipse', 'slug' => 'night-eclipse',
                'price' => 99000, 'size' => '100 ml', 'featured' => true,
                'desc' => 'Aroma manis dan misterius yang pas untuk malam hari, hangat dan memikat.',
                'top' => 'Plum, Pink Pepper', 'middle' => 'Violet, Jasmine', 'base' => 'Vanilla, Tonka Bean, Amber',
            ],
            [
                'cat' => 'body-mist', 'name' => "Vleured'or", 'slug' => 'vleured-or',
                'price' => 99000, 'size' => '100 ml', 'featured' => false,
                'desc' => 'Sentuhan bunga putih yang lembut dengan kilau manis, terasa elegan dan feminin.',
                'top' => 'Mandarin, Peach', 'middle' => 'Orange Blossom, Bunga Putih', 'base' => 'Vanilla, Musk',
            ],
            [
                'cat' => 'body-mist', 'name' => 'Royale Deluxe', 'slug' => 'royale-deluxe',
                'price' => 99000, 'size' => '100 ml', 'featured' => true,
                'desc' => 'Aroma bunga dan buah yang kaya dengan kesan royal, memberi rasa percaya diri seharian.',
                'top' => 'Blackcurrant, Bergamot', 'middle' => 'Mawar, Peony', 'base' => 'Amber, Cedar',
            ],
            [
                'cat' => 'body-mist', 'name' => 'Baby Soie', 'slug' => 'baby-soie',
                'price' => 99000, 'size' => '100 ml', 'featured' => false,
                'desc' => 'Aroma lembut seperti sutra dengan sentuhan bedak yang manis dan menenangkan.',
                'top' => 'Pir, Cotton Flower', 'middle' => 'Heliotrope, Powdery Iris', 'base' => 'Sweet Musk, Vanilla',
            ],
        ];

        foreach ($products as $p) {
            DB::table('products')->updateOrInsert(
                ['slug' => $p['slug']],
                [
                    'category_id' => $categoryIds[$p['cat']],
                    'name' => $p['name'],
                    'description' => $p['desc'],
                    'price' => $p['price'],
                    'stock' => 50,
                    'size' => $p['size'],
                    'top_notes' => $p['top'],
                    'middle_notes' => $p['middle'],
                    'base_notes' => $p['base'],
                    'image' => "products/{$p['slug']}.jpg",
                    'is_featured' => $p['featured'],
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}