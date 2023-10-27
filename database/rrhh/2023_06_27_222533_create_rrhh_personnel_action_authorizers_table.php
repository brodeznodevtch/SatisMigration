<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rrhh_personnel_action_authorizers', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('authorized')->default(false);
            $table->integer('rrhh_personnel_action_id')->unsigned();
            $table->foreign('rrhh_personnel_action_id', 'rrhh_pa_paa_id_foreign')->references('id')->on('rrhh_personnel_actions')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @r
     */
    public function down(): void
    {
        Schema::dropIfExists('rrhh_personnel_action_authorizers');
    }
};
