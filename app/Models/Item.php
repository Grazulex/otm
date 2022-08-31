<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'reference_otm',
        'reference_customer'
    ];


    public function packs(): HasMany
    {
        return $this->hasMany(
            related: CustomerItem::class
        );
    }
}
