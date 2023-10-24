<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //

    public function cashier()
    {
        return belongsTo(App\Models\Cashier::class);
    }
}
