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
        Schema::create('claims', function (Blueprint $table) {
            $table->increments('id');
            $table->string('correlative');
            $table->integer('claim_type')->unsigned()->nullable();
            $table->foreign('claim_type')->references('id')->on('claim_types')->onDelete('cascade')->onUpdate('cascade');
            $table->string('description');
            $table->string('review_description')->nullable();
            $table->boolean('proceed')->nullable()->default(false);
            $table->string('resolution')->nullable();
            $table->integer('authorized_by')->unsigned()->nullable();
            $table->foreign('authorized_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->date('close_date')->nullable();
            $table->integer('register_by')->unsigned()->nullable();
            $table->foreign('register_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
