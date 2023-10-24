<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrintFormatToBankCheckbooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_checkbooks', function (Blueprint $table) {
            $table->string('print_format')->nullable()->after('actual_correlative');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_checkbooks', function (Blueprint $table) {
            $table->dropColumn('print_format');
        });
    }
}
