<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RrhhTypeIncomeDiscount extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type', 
        'name', 
        'payroll_column', 
        'concept',
        'catalogue_id',
        'status', 
        'business_id', 
        'deleted_at'
    ];

    public function rrhhIncomeDiscounts() {
        return $this->hasMany('App\RrhhIncomeDiscount');
    }

    public function rrhhTypeIncomeDiscountLocations() {
        return $this->hasMany('App\RrhhTypeIncomeDiscountLocation');
    }

    public static $payrollColumns = [
        'Salario',
        'Horas extras',
        'Comisiones',
        'Otros ingresos',
        'Otras deducciones',
        'Aguinaldo',
        'Vacaciones',
        'Bonificaciones',
        'ISSS',
        'AFP',
        'Renta',
    ];
}
