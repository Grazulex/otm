<?php

namespace App\Models;

use App\Enums\OriginEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plate extends Model {
    use HasFactory;

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
    ];

    protected $casts = [
        'origin' => OriginEnums::class,
        'datas' => 'array',
        'is_cod' => 'boolean',
        'is_rush' => 'boolean',
        'is_incoming' => 'boolean',
    ];

    protected $attributes = [
        'origin' => OriginEnums::ESHOP,
    ];

    /**
     *
     * @return BelongsTo
     */
    public function production(): BelongsTo {
        return $this->belongsTo(related: Production::class);
    }

    /**
     *
     * @return BelongsTo
     */
    public function incoming(): BelongsTo {
        return $this->belongsTo(related: Incoming::class);
    }

    public function setAmountAttribute($price): void {
        $this->attributes['amount'] = $price * 100;
    }

    public function getAmountAttribute(): int|float {
        return $this->attributes['amount'] / 100;
    }

    public function setReferenceAttribute($reference): void {
        $this->attributes['reference'] = strtoupper($reference);
    }

    public function getReferenceAttribute(): string {
        return strtoupper($this->attributes['reference']);
    }
}
