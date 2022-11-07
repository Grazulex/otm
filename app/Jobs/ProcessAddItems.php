<?php

namespace App\Jobs;

use App\Models\Plate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAddItems implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Plate $plate)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = $this->plate->customer;
        if ($customer->items) {
            foreach ($customer->items as $item) {
                Plate::create([
                    'created_at' => $this->plate->created_at,
                    'reference' => $this->plate->reference,
                    'is_cod' => $this->plate->is_cod,
                    'is_rush' => $this->plate->is_rush,
                    'amount' => 0,
                    'plate_type' => $item->item->reference_otm,,
                    'product_type' => 'plates',
                    'type' => $item->item->reference_otm,
                    'incoming_id' => $this->plate->incoming_id,
                    'customer' => $this->plate->customer,
                    'customer_key' => $this->plate->customer_key,
                    'delivery_zip' => $this->plate->delivery_zip,
                    'origin' => $this->plate->origin,
                    'datas' => $this->plate->datas,
                ]);
            }
        }
    }
}
