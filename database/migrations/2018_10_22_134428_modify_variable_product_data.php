<?php

use App\Utils\InstallUtil;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $installUtil = new InstallUtil();
        $installUtil->createExistingProductsVariationsToTemplate();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
