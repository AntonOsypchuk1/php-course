<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $loan = DB::table('loans')
            ->whereNull('returned_at')
            ->first();

        if ($loan) {
            $dueAt = Carbon::parse($loan->due_at);
            $daysOverdue = Carbon::now()->diffInDays($dueAt, false);
            $rate = DB::table('system_settings')->where('key', 'fine_per_day')->value('value');

            if ($daysOverdue > 0) {
                DB::table('fines')->updateOrInsert(
                    ['loan_id' => $loan->id],
                    [
                        'amount'     => $daysOverdue * $rate,
                        'paid_at'    => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
