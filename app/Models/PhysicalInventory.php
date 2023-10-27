<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhysicalInventory extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        'code',
        'name',
        'start_date',
        'location_id',
        'warehouse_id',
        'status',
        'responsible',
        'business_id',
        'created_by',
        'updated_by',
        'processed_by',
        'reviewed_by',
        'authorized_by',
        'finished_by',
        'category',
    ];

    /**
     * Get business location.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(\App\Models\BusinessLocation::class, 'location_id');
    }

    /**
     * Get warehouse.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Warehouse::class, 'warehouse_id');
    }

    /**
     * Get user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'responsible');
    }

    /**
     * Get physical inventory lines.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function physical_inventory_lines(): HasMany
    {
        return $this->hasMany(\App\Models\PhysicalInventoryLine::class);
    }
}
