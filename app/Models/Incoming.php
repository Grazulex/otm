<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incoming extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_id', 'close_id'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            related: Customer::class,
            foreignKey: 'customer_id',
        );
    }

    public function close(): BelongsTo
    {
        return $this->belongsTo(related: Close::class, foreignKey: 'close_id');
    }

    public function plates(): HasMany
    {
        return $this->hasMany(related: Plate::class, foreignKey: 'incoming_id');
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $this->plates()->sum('amount') * 100,
            get: fn ($value) => $this->plates()->sum('amount') / 100
        );
    }
}
