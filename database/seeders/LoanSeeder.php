<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberId = DB::table('users')->where('email', 'member@example.com')->value('id');
        $maxLoanDays = (int) DB::table('system_settings')
            ->where('key', 'max_loan_days')
            ->value('value');
        $bookIds  = DB::table('books')->pluck('id')->toArray();

        foreach (array_slice($bookIds, 0, 3) as $bookId) {
            $loanedAt = Carbon::now()->subDays(10);
            $dueAt = $loanedAt->copy()->addDays($maxLoanDays);

            DB::table('loans')->updateOrInsert(
                [
                    'user_id' => $memberId,
                    'book_id' => $bookId,
                    'loaned_at' => $loanedAt,
                ],
                [
                    'due_at' => $dueAt,
                    'returned_at' => null,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );
        }
    }
}
