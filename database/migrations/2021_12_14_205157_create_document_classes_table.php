<?php

use App\Models\DocumentClass;
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
        Schema::create('document_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        DocumentClass::create([
            'code' => 1,
            'name' => 'IMPRESO POR IMPRENTA O TIQUETES',
        ]);

        DocumentClass::create([
            'code' => 2,
            'name' => 'FORMULARIO ÚNICO',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('document_classes');
    }
};
