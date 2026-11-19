<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorderTaxEntry extends Model
{
    protected $fillable = [
        'user_id', 'state', 'service', 'service_type', 'vehicle_no', 'chassis_no',
        'owner_name', 'mobile_no', 'from_state', 'vehicle_type', 'vehicle_class',
        'seating_capacity', 'sleeper_cap', 'owner_type', 'maker_status',
        'permit_type', 'permit_no', 'permit_upto', 'issuing_authority',
        'tax_mode', 'barrier_name', 'tax_from', 'tax_upto', 'tax_lines',
        'amount', 'receipt_no', 'paid_on', 'notes',
    ];

    protected $casts = [
        'permit_upto' => 'date',
        'tax_from'    => 'date',
        'tax_upto'    => 'date',
        'paid_on'     => 'date',
        'tax_lines'   => 'array',
        'amount'      => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}