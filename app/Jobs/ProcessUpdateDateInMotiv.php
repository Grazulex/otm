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
use Illuminate\Support\Facades\Log;

class ProcessUpdateDateInMotiv implements ShouldQueue
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
         'Content-Type' => 'application/x-www-form-urlencoded'
      ])->asForm()->post(
         env('OTM_INMOTIV_ENDPOINT_TOKEN'),
         [
            'client_id' => env('OTM_INMOTIV_CLIENT_ID'),
            'client_secret' => env('OTM_INMOTIV_SECRET_ID'),
            'scope' => 'openid',
            'grant_type' => 'client_credentials'
         ]
      );
      if ($response->successful()) {
         $token = $response->json('access_token');
         try {

            Log::debug(env('OTM_INMOTIV_ENDPOINT_API') . '/webdiv/orders/1.0/' . $this->plate->order_id);
            Log::debug($this->datas);

            $responseDatas = Http::withHeaders([
               'Accept' => 'application/json',
               'Content-Type' => 'application/json',
               'Authorization' => 'Bearer ' . $token
            ])->patch(env('OTM_INMOTIV_ENDPOINT_API') . '/webdiv/orders/1.0/' . $this->plate->order_id, $this->datas);

            Log::debug("API: ok");
            Log::debug($responseDatas->body());
            Log::debug($responseDatas->headers());
            if (!$responseDatas->successful()) {
               Log::debug("API: not successful");
               Log::debug($responseDatas->status());
            }
         } catch (\Exception $e) {
            Log::debug("API: nok");
            Log::debug($responseDatas->body());
            Log::debug($responseDatas->headers());
            Log::debug($e->getCode());
            Log::debug($e->getMessage());
         }
      }
   }
}
