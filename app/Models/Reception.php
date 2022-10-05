<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reception extends Model
{
    use HasFactory;

    protected $fillable = ['amount_cash', 'amount_bbc', 'close_id'];


    public function close(): BelongsTo
    {
        return $this->belongsTo(related: Close::class, foreignKey: 'close_id');
    }

    protected function amoutCash(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
            get: fn ($value) => $value / 100
        );
    }

    protected function amoutBbc(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
            get: fn ($value) => $value / 100
        );
    }
}
