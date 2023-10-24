<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;

class UpdateProductTypeToSingleIfNullInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Product::whereNull('type')->update(['type' => 'single']);
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
}
