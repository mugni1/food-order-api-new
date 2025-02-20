<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        $catgorys = [
            ['name' => 'heavy meals'],
            ['name' => 'seafoods'],
            ['name' => 'appetizers'],
            ['name' => 'drinks'],
        ];

        collect($catgorys)->map(function ($category) {
            Category::create([
                'name' => $category['name'],
            ]);
        });
    }
}