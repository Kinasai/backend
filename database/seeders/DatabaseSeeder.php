<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $array = [
            [
                'layout_id' => 1,
                'parent_id' => '',
                'ordering_id' => 1,
                'name' => 'Featured',
                'external_id' => 'AACAAK',
                'region' => 'ALL'
            ],
            [
                'layout_id' => 0,
                'parent_id' => '',
                'ordering_id' => 2,
                'name' => 'Bundles',
                'external_id' => 'AACAAB',
                'region' => 'ALL'
            ],
            [
                'layout_id' => 0,
                'parent_id' => '',
                'ordering_id' => 3,
                'name' => 'Consumables',
                'external_id' => 'AACAAA',
                'region' => 'ALL'
            ],
            [
                'layout_id' => 0,
                'parent_id' => '',
                'ordering_id' => 4,
                'name' => 'Costumes/Weapons',
                'external_id' => 'AACAAD',
                'region' => 'ALL'
            ],
            [
                'layout_id' => 0,
                'parent_id' => '',
                'ordering_id' => 5,
                'name' => 'Mounts',
                'external_id' => 'AACAAC',
                'region' => 'ALL'
            ]
        ];

        foreach ($array as $item) {
            Category::query()->create($item);
        }

        Tag::query()->create([
            'name' => 'WelcomeScreen',
            'external_id' => 1,
        ]);

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

    }
}
