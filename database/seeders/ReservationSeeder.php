<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberId = DB::table('users')->where('email', 'member@example.com')->value('id');
        $bookIds  = DB::table('books')->pluck('id')->toArray();

        DB::table('reservations')->updateOrInsert(
            ['user_id' => $memberId, 'book_id' => $bookIds[3]],
            [
                'reserved_at' => now(),
                'status'      => 'pending',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        );
    }
}
