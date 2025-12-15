<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    $categories = [
        ['name' => 'Pendidikan'],
        ['name' => 'Kesehatan'],
        ['name' => 'Bencana Alam'],
        ['name' => 'Sosial'],
        ['name' => 'Lingkungan'],
        ['name' => 'Hewan'],
        ['name' => 'Komunitas'],
        ['name' => 'Budaya'],
    ];

    foreach ($categories as $category) {
        \App\Models\Category::create($category);
    }
}

}
