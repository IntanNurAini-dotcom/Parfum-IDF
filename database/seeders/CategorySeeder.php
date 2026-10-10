<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Parfum IDF',
                'slug' => 'parfum-idf',
                'description' => 'Koleksi wewangian mewah Parfum IDF dengan konsentrasi aroma intens untuk pesona elegan sepanjang hari.',
                'image' => 'images/beranda/kategori-parfum-idf.jpg',
            ],
            [
                'name' => 'Body Mist',
                'slug' => 'body-mist',
                'description' => 'Kesegaran wewangian ringan Body Mist untuk keceriaan dan keharuman lembut setiap saat.',
                'image' => 'images/beranda/kategori-body-mist.jpg',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }
    }
}
