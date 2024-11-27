<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForumCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ForumCategory::insert([
            [
                'name' => 'Legal',
                'description' => 'Legal',
                'views' => 0
            ]
        ]);

        ForumCategory::insert([
            [
                'name' => 'Familiar',
                'description' => 'Familiar',
                'views' => 0
            ]
        ]);

        ForumCategory::insert([
            [
                'name' => 'Ambiental',
                'description' => 'Ambiental',
                'views' => 0
            ]
        ]);

    }
}
