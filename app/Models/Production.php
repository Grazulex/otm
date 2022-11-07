<?php

namespace App\Models;

use App\Enums\TypeEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'is_bpost',
        'have_cod',
        'have_picking',
        'have_shipping',
    ];

    protected $casts = [
        'is_bpost' => 'boolean',
        'have_cod' => 'boolean',
        'have_picking' => 'boolean',
        'have_shipping' => 'boolean',
    ];

    public function checkIfCod()
    {
        foreach ($this->plates as $plate) {
            if (isset($plate->datas)) {
                if (array_key_exists('payment_method', $plate->datas)) {
                    if (strtolower($plate->datas['payment_method']) === 'cod') {
                        $this->have_cod = true;
                        $this->save();
                        break;
                    }
                }
            }
        }
    }

    public function checkIfShipping()
    {
        foreach ($this->plates as $plate) {
            if (!$plate->incoming_id) {
                $this->have_shipping = true;
                $this->save();
                break;
            }
        }
    }

    public function checkIfPicking()
    {
        foreach ($this->plates as $plate) {
            $otherItems = Plate::where('reference', $plate->reference)
            ->where('created_at', $plate->created_at)
            ->whereNotIn(
                'type',
                array_column(TypeEnums::cases(), 'name'),
            )
            ->exists();
            if ($otherItems) {
                $this->have_picking = true;
                $this->save();
                break;
            }
        }
    }

    public function plates(): HasMany
    {
        return $this->hasMany(
            related: Plate::class,
            foreignKey: 'production_id',
        )
            ->orderBy('box')
            ->orderBy('customer')
            ->orderBy('customer_key');
    }
}
