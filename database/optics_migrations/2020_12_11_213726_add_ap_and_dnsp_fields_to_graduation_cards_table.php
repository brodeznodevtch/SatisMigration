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
    public function up()
    {
        Schema::table('graduation_cards', function (Blueprint $table) {
            $table->float('dnsp_os', 8, 2)->nullable()->after('addition_od');
            $table->float('dnsp_od', 8, 2)->nullable()->after('dnsp_os');
            $table->float('ap', 8, 2)->nullable()->after('ao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
