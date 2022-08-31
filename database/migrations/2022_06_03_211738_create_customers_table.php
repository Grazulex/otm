<?php

use App\Enums\DeliveryTypeEnums;
use App\Enums\LocationReportTypeEnums;
use App\Enums\ProcessTypeEnums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('delivery_type')->default(DeliveryTypeEnums::BPOST->name);
            $table->string('delivery_contact')->nullable();
            $table->string('delivery_street')->nullable();
            $table->string('delivery_number')->nullable();
            $table->string('delivery_box')->nullable();
            $table->string('delivery_zip')->nullable();
            $table->string('delivery_city')->nullable();
            $table->boolean('is_delivery_grouped')->default(true);
            $table->boolean('is_delivery_bpost')->default(true);
            $table->boolean('is_inmotiv_customer')->default(true);
            $table->string('process_type')->default(ProcessTypeEnums::DEFAULT->name);
            $table->string('process_file')->nullable();
            $table->string('location_report_type')->default(LocationReportTypeEnums::API->name);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
