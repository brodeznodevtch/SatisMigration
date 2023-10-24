<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPaymentCommitmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_commitments', function (Blueprint $table) {
            $table->boolean('is_annulled')
                ->after('type')
                ->default(false);
            $table->unsignedInteger('updated_by')
                ->nullable()
                ->default(null)
                ->after('total');

            $table->foreign('updated_by')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_commitments', function (Blueprint $table) {
            $table->dropColumn('is_annulled');
            $table->dropForeign('updated_by');
            $table->dropColumn('updated_by');
        });
    }
}
