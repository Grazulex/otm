<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Close extends Model {
    use HasFactory;

    protected $fillable = ['diff'];

    /**
     *
     * @return HasMany
     */
    public function cashes(): HasMany {
        return $this->hasMany(related: Cash::class, foreignKey: 'close_id');
    }

    /**
     *
     * @return HasMany
     */
    public function receptions(): HasMany {
        return $this->hasMany(
            related: Reception::class,
            foreignKey: 'close_id',
        );
    }

    /**
     *
     * @return HasMany
     */
    public function incomings(): HasMany {
        return $this->hasMany(related: Incoming::class, foreignKey: 'close_id');
    }

    public function setDiffAttribute($price): void {
        $this->attributes['diff'] = $price * 100;
    }

    public function getDiffAttribute(): int|float {
        return $this->attributes['diff'] / 100;
    }
}
