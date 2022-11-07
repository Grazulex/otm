<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Close extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['diff'];

    public function cashes(): HasMany
    {
        return $this->hasMany(related: Cash::class, foreignKey: 'close_id');
    }

    public function receptions(): HasMany
    {
        return $this->hasMany(
            related: Reception::class,
            foreignKey: 'close_id',
        );
    }

    public function incomings(): HasMany
    {
        return $this->hasMany(related: Incoming::class, foreignKey: 'close_id');
    }

    public function backs(): HasMany
    {
        return $this->hasMany(related: Back::class, foreignKey: 'close_id');
    }

    protected function diff(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
            get: fn ($value) => $value / 100
        );
    }
}
