<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'Pride and Prejudice', 'isbn' => '9780141199078', 'publisher' => 'Penguin Classics',
                'category' => 'Fiction', 'quantity' => 5,
                'authors' => ['Jane Austen'],
            ],
            [
                'title' => '1984', 'isbn' => '9780451524935', 'publisher' => 'Signet Classics',
                'category' => 'Science Fiction', 'quantity' => 4,
                'authors' => ['George Orwell'],
            ],
            [
                'title' => 'Adventures of Huckleberry Finn', 'isbn' => '9780486280615', 'publisher' => 'Dover Publications',
                'category' => 'Fiction', 'quantity' => 3,
                'authors' => ['Mark Twain'],
            ],
            [
                'title' => 'Harry Potter and the Sorcerer\'s Stone', 'isbn' => '9780590353427', 'publisher' => 'Scholastic',
                'category' => 'Fantasy', 'quantity' => 6,
                'authors' => ['J.K. Rowling'],
            ],
            [
                'title' => 'Notes from Underground', 'isbn' => '9780140449242', 'publisher' => 'Penguin Classics',
                'category' => 'Philosophy', 'quantity' => 2,
                'authors' => ['Fyodor Dostoevsky'],
            ],
        ];

        foreach ($books as $data) {
            $categoryId = DB::table('categories')->where('name', $data['category'])->value('id');
            $bookId = DB::table('books')->updateOrInsert(
                ['isbn' => $data['isbn']],
                [
                    'title' => $data['title'],
                    'publisher' => $data['publisher'],
                    'category_id' => $categoryId,
                    'quantity' => $data['quantity'],
                ]
            );

            // attach authors
            foreach ($data['authors'] as $authorName) {
                [$first, $last] = explode(' ', $authorName, 2);
                $authorId = DB::table('authors')
                    ->where('first_name', $first)
                    ->where('last_name', $last)
                    ->value('id');
                DB::table('author_book')->updateOrInsert(
                    ['author_id' => $authorId, 'book_id' => $bookId],
                );
            }
        }
    }
}
