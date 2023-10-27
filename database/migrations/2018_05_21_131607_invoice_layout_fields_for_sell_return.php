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
        Schema::table('invoice_layouts', function (Blueprint $table) {
            $table->string('cn_heading')->after('design')->nullable()->comment('cn = credit note');
            $table->string('cn_no_label')->after('cn_heading')->nullable();
            $table->string('cn_amount_label')->after('cn_no_label')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('invoice_layouts', function (Blueprint $table) {
            //
        });
    }
};
