<?php

use App\Models\Book;
use App\Models\Loan;
use App\Models\SystemSetting;
use App\Models\User;
use Tests\TestCase;

class CronTest extends TestCase
{
    public function test_overdue_loans_generate_fines()
    {
        // Arrange: create a loan 5 days overdue
        $loan = Loan::create([
            'user_id'   => 1,
            'book_id'   => 1,
            'loaned_at' => now()->subDays(10),
            'due_at'    => now()->subDays(5),
        ]);

        // Act: call the command
        $this->artisan('loans:process-overdue')->assertExitCode(0);

        // Assert: a fine exists
        $this->assertDatabaseHas('fines', [
            'loan_id' => $loan->id,
            'amount'  => 5 * (float)SystemSetting::where('key','fine_per_day')->value('value'),
        ]);
    }
}
