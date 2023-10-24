<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function purchase_lines()
    {
        return $this->hasMany(\App\Models\PurchaseLine::class);
    }

    public function expense_category()
    {
        return $this->belongsTo(\App\Models\ExpenseCategory::class, 'expense_category_id');
    }

    public function sell_lines()
    {
        return $this->hasMany(\App\Models\TransactionSellLine::class);
    }

    public function contact()
    {
        return $this->belongsTo(\App\Models\Contact::class, 'contact_id');
    }

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'customer_id');
    }

    public function payment_lines()
    {
        return $this->hasMany(\App\Models\TransactionPayment::class);
    }

    public function document_type()
    {
        return $this->belongsTo(\App\Models\DocumentType::class, 'document_types_id');
    }

    public function location()
    {
        return $this->belongsTo(\App\Models\BusinessLocation::class, 'location_id');
    }

    public function business()
    {
        return $this->belongsTo(\App\Models\Business::class, 'business_id');
    }

    public function tax()
    {
        return $this->belongsTo(\App\Models\TaxRate::class, 'tax_id');
    }

    public function stock_adjustment_lines()
    {
        return $this->hasMany(\App\Models\StockAdjustmentLine::class);
    }

    public function sales_person()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function return_parent()
    {
        return $this->hasOne(\App\Models\Transaction::class, 'return_parent_id');
    }

    public function table()
    {
        return $this->belongsTo(\App\Restaurant\ResTable::class, 'res_table_id');
    }

    public function service_staff()
    {
        return $this->belongsTo(\App\Models\User::class, 'res_waiter_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(\App\Models\Warehouse::class, 'warehouse_id');
    }

    public function transfer_state()
    {
        return $this->belongsTo(\App\Models\TransferState::class, 'transfer_state_id');
    }

    public function payment_term()
    {
        return $this->belongsTo(\App\Models\PaymentTerm::class, 'payment_term_id');
    }

    /**
     * Retrieves documents path if exists
     */
    public function getDocumentPathAttribute()
    {
        $path = ! empty($this->document) ? asset('/uploads/documents/'.$this->document) : null;

        return $path;
    }

    public function import_expenses()
    {
        return $this->hasMany(\App\Models\TransactionHasImportExpense::class);
    }

    /**
     * Removes timestamp from document name
     */
    public function getDocumentNameAttribute()
    {
        $document_name = ! empty(explode('_', $this->document, 2)[1]) ? explode('_', $this->document, 2)[1] : $this->document;

        return $document_name;

    }
}
