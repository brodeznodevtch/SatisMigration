<?php

namespace App\Optics;

use Illuminate\Database\Eloquent\Model;

class InflowOutflow extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'business_id',
        'supplier_id',
        'document_type_id',
        'document_no',
        'amount',
        'cashier_id',
        'employee_id',
        'flow_reason_id',
        'created_by',
        'updated_by',
        'expense_category_id',
        'description',
    ];

    /**
     * Get contact.
     *
     * @return \App\Models\Contact
     */
    public function contact()
    {
        return $this->belongsTo(\App\Models\Contact::class, 'supplier_id');
    }

    /**
     * Get employee.
     *
     * @return \App\Models\Employees
     */
    public function employee()
    {
        return $this->belongsTo(\App\Models\Employees::class, 'employee_id');
    }
}
