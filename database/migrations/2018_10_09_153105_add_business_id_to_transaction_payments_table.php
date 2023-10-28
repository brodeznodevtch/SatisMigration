<?php

use App\Models\TransactionPayment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->integer('business_id')->after('transaction_id')->nullable();
        });

        $transaction_payments = TransactionPayment::with(['created_user'])->get();
        foreach ($transaction_payments as $transaction_payment) {
            $transaction_payment->business_id = $transaction_payment->created_user->business_id;
            $transaction_payment->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            //
        });
    }
};
