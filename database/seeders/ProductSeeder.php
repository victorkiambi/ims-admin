<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        // Loop through each category and create products for it
        $categories->each(function ($category) {
            Product::factory(50)
                ->count(rand(3, 7)) // Randomize the number of products per category
                ->for($category, 'category') // Associate with the current category
                ->create();
        });

    }
}
