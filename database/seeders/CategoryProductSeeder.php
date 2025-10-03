<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'DERMOND' => [
                ['name' => 'DERMOND'],
            ],
        ];

        foreach ($data as $category => $products) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => $category . ' products'
            ]);
        }
    }
}
