<?php

namespace App\Services;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class LoanService
{
    protected $settingService;
    protected $bookService;

    public function __construct(SystemSettingService $settingService, BookService $bookService)
    {
        $this->settingService = $settingService;
        $this->bookService    = $bookService;
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Loan::with(['user', 'book']);
        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
        return $query->paginate($perPage);
    }

    public function find(int $id): ?Loan
    {
        return Loan::with(['user', 'book'])->findOrFail($id);
    }

    public function create(array $data): Loan
    {
        $loanedAt    = Carbon::now();
        $maxLoanDays = (int) $this->settingService->get('max_loan_days');
        $dueAt       = $loanedAt->copy()->addDays($maxLoanDays);

        $data = array_merge($data, [
            'loaned_at' => $loanedAt,
            'due_at'    => $dueAt,
        ]);

        $loan = Loan::create($data);

        // decrement book quantity
        $this->bookService->find($data['book_id'])->decrement('quantity');

        return $loan;
    }

    public function return(int $id): Loan
    {
        $loan = $this->find($id);
        $loan->returned_at = Carbon::now();
        $loan->save();

        // increment book quantity
        $this->bookService->find($loan->book_id)->increment('quantity');

        return $loan;
    }

    public function delete(int $id): bool
    {
        $loan = $this->find($id);
        return $loan->delete();
    }
}
