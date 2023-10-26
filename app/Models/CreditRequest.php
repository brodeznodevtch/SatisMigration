<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'correlative',
        'type_person',
        'business_name',
        'trade_name',
        'nrc',
        'nit_business',
        'business_type',
        'address',
        'category_business',
        'phone_business',
        'fax_business',
        'legal_representative',
        'dui_legal_representative',
        'purchasing_agent',
        'phone_purchasing_agent',
        'fax_purchasing_agent',
        'email_purchasing_agent',
        'payment_manager',
        'phone_payment_manager',
        'email_payment_manager',
        'amount_request_business',
        'term_business',
        'warranty_business',
        'name_natural',
        'dui_natural',
        'age',
        'birthday',
        'phone_natural',
        'category_natural',
        'nit_natural',
        'address_natural',
        'amount_request_natural',
        'term_natural',
        'warranty_natural',
        'own_business_name',
        'own_business_address',
        'own_business_time',
        'own_business_phone',
        'own_business_fax',
        'own_business_email',
        'average_monthly_income',
        'spouse_name',
        'spouse_dui',
        'spouse_work_address',
        'spouse_phone',
        'spouse_income_date',
        'spouse_position',
        'spouse_salary',
        'order_purchase',
        'order_via_fax',
        'date_request',
        'file',
        'observations',
        'status',
    ];
}
