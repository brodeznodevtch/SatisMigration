<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RrhhTypeIncomeDiscountLocation extends Model
{
	protected $fillable = ['catalogue_id', 'business_location_id', 'rrhh_type_income_discount_id'];

	public function businessLocation() {
        return $this->belongsTo(\App\BusinessLocation::class, 'location_id');
    }

	public function rrhhTypeIncomeDiscount() {
        return $this->belongsTo('App\RrhhTypeIncomeDiscount');
    }

	public function catalogue(){
    	return $this->belongsTo('App\Catalogue');
    }
}
