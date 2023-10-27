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
        Schema::table('claim_types', function (Blueprint $table) {
            $table->string('correlative')->nullable()->after('id');
            $table->integer('resolution_time')->nullable()->after('description');
            $table->boolean('required_customer')->default(0)->after('resolution_time');
            $table->boolean('required_invoice')->default(0)->after('required_customer');
            $table->boolean('required_product')->default(0)->after('required_customer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('claim_types', function (Blueprint $table) {
            //
        });
    }
};
