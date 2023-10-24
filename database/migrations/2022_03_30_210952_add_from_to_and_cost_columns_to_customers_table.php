<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFromToAndCostColumnsToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->time('from')
                ->nullable()
                ->default(null)
                ->after('length');
            $table->time('to')
                ->nullable()
                ->default(null)
                ->after('from');
            $table->decimal('cost', 10, 2)
                ->nullable()
                ->default(null)
                ->after('to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('from');
            $table->dropColumn('to');
            $table->dropColumn('cost');
        });
    }
}
