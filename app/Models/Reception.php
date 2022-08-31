<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reception extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount_cash',
        'amount_bbc',
        'close_id'
    ];


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

    /**
     * 
     * @param mixed $price 
     * @return void 
     */
    public function setAmountCashAttribute($price): void
    {
        $this->attributes['amount_cash'] = $price * 100;
    }

    public function getAmountCashAttribute(): int|float
    {
        return $this->attributes['amount_cash'] / 100;
    }

    /**
     * 
     * @param mixed $price 
     * @return void 
     */
    public function setAmountBbcAttribute($price): void
    {
        $this->attributes['amount_bbc'] = $price * 100;
    }

    public function getAmountBbcAttribute(): int|float
    {
        return $this->attributes['amount_bbc'] / 100;
    }
}
