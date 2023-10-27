<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->date('document_date')->nullable()->after('transaction_date');
        });

        $transactions = Transaction::whereIn('type', ['purchase', 'expense'])->get();

        foreach ($transactions as $transaction) {
            $transaction->document_date = \Carbon::parse($transaction->transaction_date)->format('Y-m-d');
            $transaction->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('document_date');
        });
    }
};
