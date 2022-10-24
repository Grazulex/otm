<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'is_bpost',
    ];

    protected $casts = [
        'is_bpost' => 'boolean',
    ];

    public function haveCod(): bool
    {
        foreach ($this->plates as $plate) {
            if (isset($plate->datas)) {
                if (array_key_exists('price', $plate->datas)) {
                    if ((int) $plate->datas['price'] > 0) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function plates(): HasMany
    {
        return $this->hasMany(
            related: Plate::class,
            foreignKey: 'production_id',
        )
            ->orderBy('customer')
            ->orderBy('customer_key');
    }
}
