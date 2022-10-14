<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerLabel extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'delivery_contact',
        'delivery_street',
        'delivery_number',
        'delivery_box',
        'delivery_zip',
        'delivery_city',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
