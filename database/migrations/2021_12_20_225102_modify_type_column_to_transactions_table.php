<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN type ENUM('purchase', 'sell', 'expense', 'stock_adjustment', 'sell_transfer', 'purchase_transfer', 'opening_stock', 'sell_return', 'opening_balance', 'purchase_return', 'physical_inventory', 'retention') DEFAULT NULL");

        $transactions = Transaction::whereNull('type')->get();

        foreach ($transactions as $transaction) {
            $transaction->type = 'physical_inventory';
            $transaction->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN type ENUM('purchase', 'sell', 'expense', 'stock_adjustment', 'sell_transfer', 'purchase_transfer', 'opening_stock', 'sell_return', 'opening_balance', 'purchase_return') DEFAULT NULL");
    }
};
