<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Product::whereNull('type')->update(['type' => 'single']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
