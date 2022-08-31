<?php

use App\Enums\OriginEnums;
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
        Schema::create('plates', function (Blueprint $table) {
            $table->id();
            $table->string('reference',25);
            $table->string('type',25);
            $table->string('order_id')->nullable();
            $table->string('customer_key')->nullable();
            $table->string('customer');
            $table->string('origin',10)->default(OriginEnums::ESHOP->name);
            $table->integer('amount')->nullable();
            $table->tinyInteger('is_cod')->default(0);
            $table->tinyInteger('is_rush')->default(0);
            $table->json('datas')->nullable();
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
        Schema::dropIfExists('plates');
    }
};
