<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Maatwebsite\Excel\Sheet;
use \Maatwebsite\Excel\Writer;

class PHPExcelMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Page format macros
         */
        Writer::macro('setCreator', function (Writer $writer, string $creator) {
            $writer->getDelegate()
            ->getProperties()
            ->setCreator($creator);
        });

        Sheet::macro('setOrientation', function (Sheet $sheet, $orientation) {
            $sheet->getDelegate()
            ->getPageSetup()
            ->setOrientation($orientation);
        });

        /**
         * Cell macros
         */

        Writer::macro('setCellValue', function (Writer $writer, string $cell, string $data) {
            $writer->getDelegate()
            ->setCellValue($cell, $data);
        });

        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()
            ->getStyle($cellRange)
            ->applyFromArray($style);
        });

        Sheet::macro('horizontalAlign', function (Sheet $sheet, string $cellRange, string $align) {
            $sheet->getDelegate()
            ->getStyle($cellRange)
            ->getAlignment()
            ->setHorizontal($align);
        });

        Sheet::macro('verticalAlign', function (Sheet $sheet, string $cellRange, string $align) {
            $sheet->getDelegate()
            ->getStyle($cellRange)
            ->getAlignment()
            ->setVertical($align);
        });

        Sheet::macro('wrapText', function (Sheet $sheet, string $cellRange) {
            $sheet->getDelegate()
            ->getStyle($cellRange)
            ->getAlignment()
            ->setWrapText(true);
        });

        Sheet::macro('mergeCells', function (Sheet $sheet, string $cellRange) {
            $sheet->getDelegate()
            ->mergeCells($cellRange);
        });

        Sheet::macro('columnWidth', function (Sheet $sheet, string $column, float $width) {
            $sheet->getDelegate()
            ->getColumnDimension($column)
            ->setWidth($width);
        });

        Sheet::macro('rowHeight', function (Sheet $sheet, string $row, float $height) {
            $sheet->getDelegate()
            ->getRowDimension($row)
            ->setRowHeight($height);
        });

        Sheet::macro('setFontFamily', function (Sheet $sheet, string $cellRange, string $font) {
            $sheet->getDelegate()
            ->getStyle($cellRange)
            ->getFont()
            ->setName($font);
        });

        Sheet::macro('setFontSize', function (Sheet $sheet, string $cellRange, float $size) {
            $sheet->getDelegate()
            ->getStyle($cellRange)
            ->getFont()
            ->setSize($size);
        });

        Sheet::macro('textRotation', function (Sheet $sheet, string $cellRange, int $degrees) {
            $sheet->getDelegate()
            ->getStyle($cellRange)
            ->getAlignment()
            ->setTextRotation($degrees);
        });

        Sheet::macro('setBorderBottom', function (Sheet $sheet, string $cellRange, string $border) {
            $sheet->getDelegate()
            ->getStyle($cellRange)
            ->getBorders()
            ->getBottom()
            ->setBorderStyle($border);
        });

        Sheet::macro('setBorderTop', function (Sheet $sheet, string $cellRange, string $border) {
            $sheet->getDelegate()
            ->getStyle($cellRange)
            ->getBorders()
            ->getTop()
            ->setBorderStyle($border);
        });

        Sheet::macro('setAllBorders', function (Sheet $sheet, string $cellRange, string $border) {
            $sheet->getDelegate()
            ->getStyle($cellRange)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle($border);
        });        

        Sheet::macro('setFormat', function (Sheet $sheet, string $cellRange, string $format) {
            $sheet->getDelegate()
            ->getStyle($cellRange)
            ->getNumberFormat()
            ->setFormatCode($format);
        });

        Sheet::macro('setBold', function (Sheet $sheet, string $cellRange) {
            $sheet->getDelegate()
            ->getStyle( $cellRange )
            ->getFont()
            ->setBold( true );
        });

        Sheet::macro('setRowsToRepeatAtTopByStartAndEnd', function (Sheet $sheet, $start, $end) {
            $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($start, $end);
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
