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
        Permission::create(['name' => 'purchase.payments']);
        Permission::create(['name' => 'sell.payments']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
