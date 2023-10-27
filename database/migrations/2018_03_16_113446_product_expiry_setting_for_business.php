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
        Schema::table('business', function (Blueprint $table) {
            $table->enum('on_product_expiry', ['keep_selling', 'stop_selling', 'auto_delete'])->default('keep_selling')->after('expiry_type');
            $table->integer('stop_selling_before')->after('on_product_expiry')->comment('Stop selling expied item n days before expiry');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('business', function (Blueprint $table) {
            $table->dropColumn('on_product_expiry');
            $table->dropColumn('stop_selling_before');
        });
    }
};
