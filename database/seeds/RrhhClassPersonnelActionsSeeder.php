<?php

use App\RrhhClassPersonnelAction;
use Illuminate\Database\Seeder;

class RrhhClassPersonnelActionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RrhhClassPersonnelAction::firstOrCreate([
            'name' => 'Entrada',
        ]);
        RrhhClassPersonnelAction::firstOrCreate([
            'name' => 'Movimiento',
        ]);
        RrhhClassPersonnelAction::firstOrCreate([
            'name' => 'Interna',
        ]);
        RrhhClassPersonnelAction::firstOrCreate([
            'name' => 'Salida',
        ]);
    }
}
