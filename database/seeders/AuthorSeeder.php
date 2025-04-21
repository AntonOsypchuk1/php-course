<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            ['first_name' => 'Jane', 'last_name' => 'Austen', 'bio' => 'English novelist known for Pride and Prejudice.'],
            ['first_name' => 'Mark', 'last_name' => 'Twain', 'bio' => 'American writer, humorist, and lecturer.'],
            ['first_name' => 'George', 'last_name' => 'Orwell', 'bio' => 'English novelist, essayist, journalist.'],
            ['first_name' => 'J.K.', 'last_name' => 'Rowling', 'bio' => 'British author, best known for the Harry Potter series.'],
            ['first_name' => 'Fyodor', 'last_name' => 'Dostoevsky', 'bio' => 'Russian novelist and philosopher.'],
        ];

        foreach ($authors as $author) {
            DB::table('authors')->updateOrInsert(
                ['first_name' => $author['first_name'], 'last_name' => $author['last_name']],
                array_merge($author, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
