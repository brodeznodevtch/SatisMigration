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
        Schema::table('apportionments', function (Blueprint $table) {
            $table->enum('distributing_base', ['weight', 'value'])->nullable()->after('reference');
            $table->decimal('vat_amount', 20, 4)->nullable()->after('distributing_base');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('apportionments', function (Blueprint $table) {
            $table->dropColumn('distributing_base');
            $table->dropColumn('vat_amount');
        });
    }
};
