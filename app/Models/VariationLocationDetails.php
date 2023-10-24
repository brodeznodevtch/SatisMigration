<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationLocationDetails extends Model
{
    /**
     * Gets the warehouse to which the variation location detail belongs.
     *
     * @return \Illuminate\Database\Eloquent\Concerns\HasRelationships
     */
    public function warehouse()
    {
        return $this->belongsTo(\App\Models\Warehouse::class);
    }

    /**
     * Gets the business location to which the variation location detail belongs.
     *
     * @return \Illuminate\Database\Eloquent\Concerns\HasRelationships
     */
    public function location()
    {
        return $this->belongsTo(\App\Models\BusinessLocation::class);
    }
}
