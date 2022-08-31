<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Production extends Model
{
    use HasFactory;


    /**
     *
     * @return HasMany
     */
    public function plates(): HasMany
    {
        return $this->hasMany(
            related: Plate::class,
            foreignKey: 'production_id'
        )->orderBy('customer')->orderBy('customer_key');
    }
}
