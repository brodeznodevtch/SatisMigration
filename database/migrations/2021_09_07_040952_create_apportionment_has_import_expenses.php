<?php

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
        Schema::create('apportionment_has_import_expenses', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('apportionment_id');
            $table->foreign('apportionment_id')->references('id')->on('apportionments')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('import_expense_id');
            $table->foreign('import_expense_id')->references('id')->on('import_expenses')->onDelete('cascade')->onUpdate('cascade');

            $table->decimal('amount', 20, 4)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apportionment_has_import_expenses');
    }
};
