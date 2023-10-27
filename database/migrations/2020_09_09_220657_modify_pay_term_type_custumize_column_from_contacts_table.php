<?php

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
        Schema::table('contacts', function (Blueprint $table) {
            //$table->dropColumn('pay_term_type_custumize');
            $table->enum('payment_condition', ['cash', 'credit'])
                ->nullable()
                ->after('business_activity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('payment_condition');
            $table->string('pay_term_type_custumize')
                ->nullable()
                ->after('credit_limit');
        });
    }
};
