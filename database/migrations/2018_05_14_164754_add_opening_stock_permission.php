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
        $insert_data = ['name' => 'product.opening_stock',
            'guard_name' => 'web',
        ];

        Permission::create($insert_data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
