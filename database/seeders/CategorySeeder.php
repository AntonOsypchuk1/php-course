<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiction', 'description' => 'Literary works of imaginative narration.'],
            ['name' => 'Non-Fiction', 'description' => 'Prose based on facts, real events, and real people.'],
            ['name' => 'Science Fiction', 'description' => 'Fiction based on imagined future scientific advances.'],
            ['name' => 'Fantasy', 'description' => 'Stories with magical or supernatural elements.'],
            ['name' => 'Philosophy', 'description' => 'Books about fundamental questions of existence and knowledge.'],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['name' => $cat['name']],
                array_merge($cat, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
