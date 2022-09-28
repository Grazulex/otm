<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incoming extends Model {
    use HasFactory;

    protected $fillable = ['customer_id', 'close_id'];

    /**
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo {
        return $this->belongsTo(
            related: Customer::class,
            foreignKey: 'customer_id',
        );
    }

    /**
     *
     * @return BelongsTo
     */
    public function close(): BelongsTo {
        return $this->belongsTo(related: Close::class, foreignKey: 'close_id');
    }

    /**
     *
     * @return HasMany
     */
    public function plates(): HasMany {
        return $this->hasMany(related: Plate::class, foreignKey: 'incoming_id');
    }

    public function getAmountAttribute(): int|float {
        return $this->plates()->sum('amount') / 100;
    }
}
