<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cash extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'total',
        'comment',
        'close_id'
    ];


    /**
     * 
     * @return BelongsTo 
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id'
        );
    }

    /**
     * 
     * @return BelongsTo 
     */
    public function close(): BelongsTo
    {
        return $this->belongsTo(
            related: Close::class,
            foreignKey: 'close_id'
        );
    }

    public function setAmountAttribute($price): void
    {
        $this->attributes['amount'] = $price * 100;
    }

    public function getAmountAttribute(): int|float
    {
        return $this->attributes['amount'] / 100;
    }

}
