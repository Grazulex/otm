<?php

namespace App\Console\Commands;

use App\Models\Plate;
use App\Enums\OriginEnums;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Jobs\ProcessInsertNotification;

class ImportEshopCommand extends Command
{
   /**
    * The name and signature of the console command.
    *
    * @var string
    */
   protected $signature = 'otm:import:eshop';

   /**
    * The console command description.
    *
    * @var string
    */
   protected $description = 'Import order from Eshop';

   /**
    * Execute the console command.
    *
    * @return int
    */
   public function handle()
   {
      $response = Http::withHeaders([
         'Accept' => 'application/json',
         'Content-Type' => 'application/json'
      ])->get('https://arco.otm-shop.be/modules/otmprod/frontplate.php');
      if ((int)$response->successful()) {
         $orders = $response->json();
         $inserted = 0;
         foreach ($orders as $order) {
            $plate = Plate::where(['order_id' => $order['order_id']])->first();
            if (!$plate) {
               $this->info('Make new plate for order ' . $order['order_id']);
               $plate = Plate::create([
                  'created_at'    => $order['order_date'],
                  'reference'     => $order['plate_number'],
                  'type'          => $order['plate_type'],
                  'origin'        => OriginEnums::ESHOP->value,
                  'order_id'      => $order['order_id'],
                  'customer'      => $order['destination_name'] . ' ' . $order['destination_company'],
                  'customer_key'  => $order['destination_key'],
                  'amount'        => 0,
                  'is_cod'        => false,
                  'datas'         => $order
               ]);
               $inserted++;
            }
         }
         if ($inserted > 0) {
            ProcessInsertNotification::dispatch('Import Eshop Done. Find ' . $inserted . ' orders');
         }
      } else {
         $this->error($response->status());
      }
   }
}
