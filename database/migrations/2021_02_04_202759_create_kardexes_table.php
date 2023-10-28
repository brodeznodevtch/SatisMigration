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
        Schema::create('kardexes', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('movement_type_id');
            $table->foreign('movement_type_id')->references('id')->on('movement_types')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('business_location_id');
            $table->foreign('business_location_id')->references('id')->on('business_locations')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('warehouse_id');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade')->onUpdate('cascade');

            $table->decimal('inputs_quantity', 8, 2)->default(0);
            $table->decimal('unit_cost_inputs', 8, 2)->default(0);
            $table->decimal('total_cost_inputs', 8, 2)->default(0);

            $table->decimal('outputs_quantity', 8, 2)->default(0);
            $table->decimal('unit_cost_outputs', 8, 2)->default(0);
            $table->decimal('total_cost_outputs', 8, 2)->default(0);

            $table->string('reference');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->dateTime('date_time');

            $table->unsignedInteger('business_id');
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade')->onUpdate('cascade');

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kardexes');
    }
};
