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
        Schema::table('business_locations', function (Blueprint $table) {

            $table->boolean('print_receipt_on_invoice')->nullable()->default(1)->after('invoice_layout_id');

            $table->enum('receipt_printer_type', ['browser', 'printer'])->default('browser')->after('print_receipt_on_invoice');

            $table->integer('printer_id')->nullable()->after('receipt_printer_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_locations', function (Blueprint $table) {
            //
        });
    }
};
