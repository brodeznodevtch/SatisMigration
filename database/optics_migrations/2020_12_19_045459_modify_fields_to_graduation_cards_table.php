<?php

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
        DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN sphere_os VARCHAR(191)');
        DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN sphere_od VARCHAR(191)');
        DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN cylindir_os VARCHAR(191)');
        DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN cylindir_od VARCHAR(191)');
        DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN axis_os VARCHAR(191)');
        DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN axis_od VARCHAR(191)');
        DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN base_os VARCHAR(191)');
        DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN base_od VARCHAR(191)');
        DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN addition_os VARCHAR(191)');
        DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN addition_od VARCHAR(191)');
        DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN ao VARCHAR(191)');
        DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN ap VARCHAR(191)');
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
