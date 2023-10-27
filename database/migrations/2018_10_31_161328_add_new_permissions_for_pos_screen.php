<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Permission::create(['name' => 'edit_product_price_from_sale_screen']);
        Permission::create(['name' => 'edit_product_discount_from_sale_screen']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
