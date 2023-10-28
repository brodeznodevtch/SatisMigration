<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\DocumentType;
use App\Models\PrintFormat;
use Illuminate\Database\Seeder;

class PrintFormatSeeder extends Seeder
{
    /**
     * Create default print formats.
     */
    public function run(): void
    {
        $print_formats = [
            'FCF' => 'invoice',
            'CCF' => 'fiscal_credit',
            'Ticket' => 'ticket',
            'NCR' => 'credit_note',
        ];

        $business = Business::pluck('id');

        foreach ($business as $b) {
            $locations = BusinessLocation::where('business_id', $b)->pluck('id');

            foreach ($locations as $l) {
                $document_types = DocumentType::where('business_id', $b)
                    ->select('id', 'short_name as doc')
                    ->get();

                $file = '';
                foreach ($document_types as $dt) {
                    $file = isset($print_formats[$dt->doc]) ? $print_formats[$dt->doc] : 'invoice';

                    PrintFormat::firstOrCreate(
                        [
                            'business_id' => $b,
                            'location_id' => $l,
                            'document_type_id' => $dt->id,
                        ],
                        ['format' => $file]
                    );
                }
            }
        }
    }
}
