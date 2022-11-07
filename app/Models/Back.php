<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Back extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'close_id',
    ];

    public function plates(): HasMany
    {
        return $this->hasMany(related: Plate::class, foreignKey: 'back_id');
    }
}
