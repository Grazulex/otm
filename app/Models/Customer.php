<?php

namespace App\Models;

use App\Enums\DeliveryTypeEnums;
use App\Enums\LocationReportTypeEnums;
use App\Enums\ProcessTypeEnums;
use App\Enums\TypeEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'delivery_type',
        'delivery_key',
        'delivery_contact',
        'delivery_street',
        'delivery_number',
        'delivery_box',
        'delivery_zip',
        'delivery_city',
        'is_delivery_grouped',
        'process_type',
        'process_file',
        'logo_file',
        'location_report_type',
        'enum_ref',
        'plate_type',
        'need_co2_label',
        'co2_text',
        'need_order_label',
        'need_shipping_list',
    ];

    protected $casts = [
        'delivery_type' => DeliveryTypeEnums::class,
        'process_type' => ProcessTypeEnums::class,
        'location_report_type' => LocationReportTypeEnums::class,
        'plate_type' => TypeEnums::class,
        'is_delivery_grouped' => 'boolean',
        'need_co2_label' => 'boolean',
        'need_order_label' => 'boolean',
        'need_shipping_list' => 'boolean',
    ];

    protected $attributes = [
        'delivery_type' => DeliveryTypeEnums::BPOST,
        'process_type' => ProcessTypeEnums::DEFAULT,
        'location_report_type' => LocationReportTypeEnums::API,
        'plate_type' => TypeEnums::N1FR,
    ];

    public function incomings(): HasMany
    {
        return $this->hasMany(
            related: Incoming::class,
            foreignKey: 'customer_id',
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(related: CustomerItem::class);
    }

    public function labels(): HasMany
    {
        return $this->hasMany(related: CustomerLabel::class);
    }
}
