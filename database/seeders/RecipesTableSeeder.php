<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = DB::table('categories')->pluck('id')->toArray();
        $users = DB::table('users')->pluck('id')->toArray();

        $imageCategories = [
            'food',
            'recipe',
            'cooking',
            'dinner',
            'lunch',
            'breakfast',
            'healthy',
            'delicious',
            'tasty',
            'cake',
            'coffee',
            'pasta',
            'salad',
            'dessert'
        ];

        for ($i = 0; $i < 20; $i++) {
            $category = $imageCategories[array_rand($imageCategories)];
            DB::table('recipes')->insert([
                'id' => Str::uuid(),
                'user_id' => $users[array_rand($users)],
                'category_id' => $categories[array_rand($categories)],
                'title' => 'Recipe of ' . Str::random(10),
                'description' => 'This is a sample recipe description for ' . Str::random(10),
                'image' => "https://picsum.photos/400/300?random=" . rand(0, 10),
                'views' => rand(0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}