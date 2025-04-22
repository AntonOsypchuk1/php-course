<?php

namespace App\Console\Commands;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessOverdueLoans extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'loans:process-overdue';

    /**
     * The console command description.
     */
    protected $description = 'Scan for overdue loans and generate/update fines';

    public function handle()
    {
        $this->info('Starting overdue–loan processing...');

        $ratePerDay = (float) \App\Models\SystemSetting::where('key','fine_per_day')->value('value');
        $now = Carbon::now();

        $overdueLoans = Loan::whereNull('returned_at')
            ->where('due_at', '<', $now)
            ->get();

        if ($overdueLoans->isEmpty()) {
            $this->info('No overdue loans found.');
            return 0;
        }

        foreach ($overdueLoans as $loan) {
            $daysOverdue = $now->diffInDays($loan->due_at);
            $amount     = $daysOverdue * $ratePerDay;

            $fine = $loan->fines()->first();
            if ($fine) {
                $fine->update(['amount' => $amount]);
                $this->info("Updated fine for Loan #{$loan->id} to \${$amount}");
            } else {
                $loan->fines()->create([
                    'amount' => $amount,
                ]);
                $this->info("Created fine \${$amount} for Loan #{$loan->id}");
            }
        }

        $this->info('Overdue–loan processing complete.');
        return 0;
    }
}
