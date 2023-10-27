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
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id');
            $table->string('template_for');
            $table->text('email_body')->nullable();
            $table->text('sms_body')->nullable();
            $table->string('subject')->nullable();
            $table->boolean('auto_send')->default(0);
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
        Schema::dropIfExists('notification_templates');
    }
};
