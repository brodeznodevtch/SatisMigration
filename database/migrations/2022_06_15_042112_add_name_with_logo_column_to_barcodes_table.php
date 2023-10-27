<?php

use App\Models\Barcode;
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
        Schema::table('barcodes', function (Blueprint $table) {
            $table->integer('name_with_logo')->nullable()->after('name');
        });

        $barcodes = Barcode::all();

        foreach ($barcodes as $barcode) {
            switch ($barcode->id) {
                case 1:
                    $barcode->name_with_logo = __('barcode.barcode_name_with_logo_'.$barcode->id);
                    break;

                case 2:
                    $barcode->name_with_logo = __('barcode.barcode_name_with_logo_'.$barcode->id);
                    break;

                case 3:
                    $barcode->name_with_logo = __('barcode.barcode_name_with_logo_'.$barcode->id);
                    break;

                case 4:
                    $barcode->name_with_logo = __('barcode.barcode_name_with_logo_'.$barcode->id);
                    break;

                case 5:
                    $barcode->name_with_logo = __('barcode.barcode_name_with_logo_'.$barcode->id);
                    break;

                case 6:
                    $barcode->name_with_logo = __('barcode.barcode_name_'.$barcode->id);
                    break;
            }

            $barcode->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barcodes', function (Blueprint $table) {
            $table->dropColumn('name_with_logo');
        });
    }
};
