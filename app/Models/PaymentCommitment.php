<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentCommitment extends Model
{
    //

    public function payment_commitment_lines()
    {
        return $this->hasMany(\App\Models\PaymentCommitmentLine::class);
    }
}
