<?php

namespace App\Jobs;

use App\Models\Plate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessUpdateDateEshop implements ShouldQueue
{
   use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


   private $plate;
   private $datas;
   /**
    * Create a new job instance.
    *
    * @return void
    */
   public function __construct(Plate $plate, array $datas = [])
   {
      $this->plate = $plate;
      $this->datas = $datas;
   }

   /**
    * Execute the job.
    *
    * @return void
    */
   public function handle()
   {
      $response = Http::withHeaders([
         'Accept' => 'application/json',
         'Content-Type' => 'application/json'
      ])->get('https://arco.otm-shop.be/modules/otmprod/frontplatepatch.php?order_id=' . $this->plate->order_id, $this->datas);
      if ((int)$response->successful()) {
      }
   }
}
