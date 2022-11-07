<?php

namespace App\Models;

use App\Enums\OriginEnums;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference',
        'type',
        'origin',
        'order_id',
        'customer',
        'customer_key',
        'is_cod',
        'is_incoming',
        'is_rush',
        'amount',
        'created_at',
        'production_id',
        'incoming_id',
        'datas',
        'plate_type',
        'product_type',
        'client_code',
        'delivery_zip',
        'box',
        'back_id',
        'return_reason',
        'is_damaged',
    ];

    protected $casts = [
        'origin' => OriginEnums::class,
        'datas' => 'array',
        'is_cod' => 'boolean',
        'is_rush' => 'boolean',
        'is_incoming' => 'boolean',
        'is_damaged' => 'boolean',
    ];

    protected $attributes = [
        'origin' => OriginEnums::ESHOP,
    ];

    public function production(): BelongsTo
    {
        return $this->belongsTo(related: Production::class);
    }

    public function incoming(): BelongsTo
    {
        return $this->belongsTo(related: Incoming::class);
    }

    public function back(): BelongsTo
    {
        return $this->belongsTo(related: Back::class);
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
            get: fn ($value) => $value / 100
        );
    }

    protected function reference(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtoupper($value),
            get: fn ($value) => strtoupper($value)
        );
    }
}
