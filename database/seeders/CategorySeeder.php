<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // SQL: INSERT INTO categories (name, slug, parent_id)
        //      VALUES ('Desktop', 'desktop', null)
        // Query Builder
        DB::table('categories')->insert([
            'name' => 'TV & Audios',
            'slug' => 'tv-audios',
            'parent_id' => null,
            'created_at' => now(),
        ]);
        
        DB::table('categories')->insert([
            'name' => 'Desktop & Laptop',
            'slug' => 'desktop-laptop',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'name' => 'QLED TV',
            'slug' => 'qled-tv',
            'parent_id' => 1,
            'created_at' => now(),
        ]);
    }
}
