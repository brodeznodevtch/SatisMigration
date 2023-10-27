<?php

namespace Database\Seeders;

use App\Models\ExpenseLine;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class ModifyExpensesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $current_expenses = Transaction::select('id', 'expense_category_id', 'total_before_tax as line_total')
            ->where('type', 'expense')
            ->whereNotIn('id', function ($query) {
                $query->select('transaction_id')
                    ->from('expense_lines');
            })->where('expense_category_id', '<>', null)->get();

        foreach ($current_expenses as $ce) {
            ExpenseLine::create([
                'transaction_id' => $ce->id,
                'expense_category_id' => $ce->expense_category_id,
                'line_total_exc_tax' => $ce->line_total,
            ]);
        }
    }
}
