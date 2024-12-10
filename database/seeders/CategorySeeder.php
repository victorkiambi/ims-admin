<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array of categories
        $categoriesData = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic products',
                'slug' => 'electronics',
            ],
            [
                'name' => 'Clothing',
                'description' => 'Clothing products',
                'slug' => 'clothing',
            ],
            [
                'name' => 'Books',
                'description' => 'Books products',
                'slug' => 'books',
            ],
            [
                'name' => 'Furniture',
                'description' => 'Furniture products',
                'slug' => 'furniture',
            ],
            [
                'name' => 'Toys',
                'description' => 'Toys products',
                'slug' => 'toys',
            ],
        ];

        // Loop through the categories
        foreach ($categoriesData as $categoryData) {
           Category::create($categoryData);
        }
    }

}
