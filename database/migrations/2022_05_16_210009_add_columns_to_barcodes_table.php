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
            $table->float('height_with_logo', 8, 2)->nullable()->after('height');
            $table->integer('stickers_in_one_sheet_with_logo')->nullable()->after('stickers_in_one_sheet');
        });

        $barcodes = Barcode::all();

        foreach ($barcodes as $barcode) {
            switch ($barcode->id) {
                case 1:
                    $barcode->name = __('barcode.barcode_name_'.$barcode->id);
                    $barcode->description = __('barcode.barcode_description_'.$barcode->id);
                    $barcode->height_with_logo = 1.5;
                    $barcode->stickers_in_one_sheet_with_logo = 12;
                    break;

                case 2:
                    $barcode->name = __('barcode.barcode_name_'.$barcode->id);
                    $barcode->description = __('barcode.barcode_description_'.$barcode->id);
                    $barcode->height_with_logo = 1.5;
                    $barcode->stickers_in_one_sheet_with_logo = 18;
                    break;

                case 3:
                    $barcode->name = __('barcode.barcode_name_'.$barcode->id);
                    $barcode->description = __('barcode.barcode_description_'.$barcode->id);
                    $barcode->height_with_logo = 1.75;
                    $barcode->stickers_in_one_sheet_with_logo = 20;
                    break;

                case 4:
                    $barcode->name = __('barcode.barcode_name_'.$barcode->id);
                    $barcode->description = __('barcode.barcode_description_'.$barcode->id);
                    $barcode->height_with_logo = 1.5;
                    $barcode->stickers_in_one_sheet_with_logo = 24;
                    break;

                case 5:
                    $barcode->name = __('barcode.barcode_name_'.$barcode->id);
                    $barcode->description = __('barcode.barcode_description_'.$barcode->id);
                    $barcode->height_with_logo = 1.5;
                    $barcode->stickers_in_one_sheet_with_logo = 30;
                    break;

                case 6:
                    $barcode->name = __('barcode.barcode_name_'.$barcode->id);
                    $barcode->description = __('barcode.barcode_description_'.$barcode->id);
                    $barcode->height_with_logo = 1.5;
                    $barcode->stickers_in_one_sheet_with_logo = null;
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
            $table->dropColumn('height_with_logo');
            $table->dropColumn('stickers_in_one_sheet_with_logo');
        });
    }
};
