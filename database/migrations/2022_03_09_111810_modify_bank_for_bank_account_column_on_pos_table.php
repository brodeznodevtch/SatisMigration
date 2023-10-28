<?php

use App\Models\BankAccount;
use App\Models\Pos;
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
        /** get pos */
        $list_pos = Pos::select('id')->get();
        $pos_ids = [];
        foreach ($list_pos as $p) {
            $pos = Pos::find($p->id);
            $bank_account = BankAccount::where('bank_id', $pos->bank_id)->first();

            $pos_ids[] = [
                'pos_id' => $p->id,
                'bank_account_id' => $bank_account->id,
            ];
        }

        Schema::table('pos', function (Blueprint $table) {
            $table->unsignedInteger('bank_account_id')
                ->nullable()
                ->after('description');

            $table->foreign('bank_account_id')
                ->references('id')
                ->on('bank_accounts');

            $table->dropForeign('pos_bank_id_foreign');
            $table->dropIndex('pos_bank_id_foreign');
            $table->dropColumn('bank_id');
        });

        foreach ($pos_ids as $p) {
            $pos = Pos::find($p['pos_id']);
            $pos->bank_account_id = $p['bank_account_id'];
            $pos->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos', function (Blueprint $table) {
            //
        });
    }
};
