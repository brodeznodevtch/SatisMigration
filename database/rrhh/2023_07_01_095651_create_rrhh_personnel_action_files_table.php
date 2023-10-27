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
        Schema::create('rrhh_personnel_action_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file');
            $table->integer('rrhh_personnel_action_id')->unsigned();
            $table->foreign('rrhh_personnel_action_id', 'rrhh_pa_paf_id_foreign')->references('id')->on('rrhh_personnel_actions')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('rrhh_personnel_action_files');
    }
};
