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
        Schema::table('kit_has_products', function (Blueprint $table) {
            $table->dropForeign('kit_has_products_parent_id_foreign');
            $table->dropColumn('parent_id');

            $table->dropForeign('kit_has_products_children_id_foreign');
            $table->dropColumn('children_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('kit_has_products', function (Blueprint $table) {
            //
        });
    }
};
