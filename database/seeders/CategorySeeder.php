<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'description' => 'Technology related items', 'sort_order' => 1],
            ['name' => 'Business', 'slug' => 'business', 'description' => 'Business related items', 'sort_order' => 2],
            ['name' => 'Healthcare', 'slug' => 'healthcare', 'description' => 'Healthcare related items', 'sort_order' => 3],
            ['name' => 'Education', 'slug' => 'education', 'description' => 'Education related items', 'sort_order' => 4],
            ['name' => 'Finance', 'slug' => 'finance', 'description' => 'Finance related items', 'sort_order' => 5],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
