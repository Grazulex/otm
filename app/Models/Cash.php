<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cash extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'amount', 'total', 'comment', 'close_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'user_id');
    }

    public function close(): BelongsTo
    {
        return $this->belongsTo(related: Close::class, foreignKey: 'close_id');
    }

    protected function amout(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
            get: fn ($value) => $value / 100
        );
    }
}
