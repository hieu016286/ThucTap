<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Category 1',
                'slug' => Str::slug('Category 1'),
                'parent_id' => 0
            ],
            [
                'name' => 'Category 2',
                'slug' => Str::slug('Category 2'),
                'parent_id' => 0
            ],
            [
                'name' => 'Category 3',
                'slug' => Str::slug('Category 3'),
                'parent_id' => 0
            ],
            [
                'name' => 'Category 1.1',
                'slug' => Str::slug('Category 1.1'),
                'parent_id' => 1
            ],
            [
                'name' => 'Category 1.2',
                'slug' => Str::slug('Category 1.2'),
                'parent_id' => 1
            ],
            [
                'name' => 'Category 1.3',
                'slug' => Str::slug('Category 1.3'),
                'parent_id' => 1
            ],
            [
                'name' => 'Category 1.1.1',
                'slug' => Str::slug('Category 1.1.1'),
                'parent_id' => 4
            ],
            [
                'name' => 'Category 2.1',
                'slug' => Str::slug('Category 2.1'),
                'parent_id' => 2
            ],
            [
                'name' => 'Category 3.1',
                'slug' => Str::slug('Category 3.1'),
                'parent_id' => 3
            ]
        ]);
    }
}
