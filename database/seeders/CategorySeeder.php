<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Category::create([
            'name' => 'carros',
            'img' => 'teste',
        ]);

        Category::create([
            'name' => 'motos',
            'img' => 'teste',
        ]);
    }
}
