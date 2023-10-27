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
        Schema::table('binnacles', function (Blueprint $table) {
            $table->dateTime('realized_in')->nullable()->after('new_record');
            $table->string('machine_name')->nullable()->after('realized_in');
            $table->string('ip')->nullable()->after('machine_name');
            $table->string('city')->nullable()->after('ip');
            $table->string('country')->nullable()->after('city');
            $table->string('latitude')->nullable()->after('country');
            $table->string('longitude')->nullable()->after('latitude');
            $table->string('domain')->nullable()->after('longitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('binnacles', function (Blueprint $table) {
            $table->dropColumn('realized_in');
            $table->dropColumn('machine_name');
            $table->dropColumn('realized_in');
            $table->dropColumn('ip');
            $table->dropColumn('city');
            $table->dropColumn('country');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('domain');
        });
    }
};
