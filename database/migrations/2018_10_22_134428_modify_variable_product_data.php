<?php

use App\Utils\InstallUtil;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $installUtil = new InstallUtil();
        $installUtil->createExistingProductsVariationsToTemplate();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
