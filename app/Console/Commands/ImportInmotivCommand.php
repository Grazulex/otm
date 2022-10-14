<?php

namespace App\Console\Commands;

use App\Enums\OriginEnums;
use App\Models\Plate;
use App\Models\User;
use App\Notifications\ImportNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportInmotivCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otm:import:inmotiv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import order from InMotiv';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])
            ->asForm()
            ->post(env('OTM_INMOTIV_ENDPOINT_TOKEN'), [
                'client_id' => env('OTM_INMOTIV_CLIENT_ID'),
                'client_secret' => env('OTM_INMOTIV_SECRET_ID'),
                'scope' => 'openid',
                'grant_type' => 'client_credentials',
            ]);
        if ($response->successful()) {
            $token = $response->json('access_token');
            $responseDatas = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ])->get(env('OTM_INMOTIV_ENDPOINT_API').'/webdiv/orders/1.0'); //?start=2022-09-18T00:00:00&end=2022-09-21T22:00:00
            if ($responseDatas->successful()) {
                $orders = $responseDatas->json('orders');
                //$orders = $orders['orders'];
                $inserted = 0;
                foreach ($orders as $order) {
                    $plate = Plate::where([
                        'order_id' => $order['order_id'],
                    ])->first();
                    if (! $plate) {
                        $this->info(
                            'Make new plate for order '.$order['order_id'],
                        );
                        $is_incoming = false;
                        if (
                            isset($order['product_type']) &&
                            $order['product_type'] === 'packs'
                        ) {
                            $is_incoming = true;
                            $order['plate_type'] = 'N1FR';
                        }

                        $plate = Plate::create([
                            'created_at' => $order['order_date'],
                            'reference' => $order['plate_number'],
                            'type' => $order['plate_type'],
                            'origin' => OriginEnums::INMOTIV->value,
                            'order_id' => $order['order_id'],
                            'customer' => $order['destination_name'],
                            'customer_key' => $order['destination_key'],
                            'delivery_zip' => $order['destination_postal_code'],
                            'amount' => 0,
                            'is_cod' => false,
                            'is_incoming' => $is_incoming,
                            'datas' => $order,
                        ]);

                        if (isset($order['plate_type'])) {
                            $plate->plate_type = $order['plate_type'];
                        }
                        if (isset($order['product_type'])) {
                            $plate->product_type = $order['product_type'];
                        }
                        if (isset($order['clientcode'])) {
                            $plate->client_code = $order['clientcode'];
                        }
                        $plate->update();
                        $inserted++;
                    }
                }
                if ($inserted > 0) {
                    foreach (User::all() as $user) {
                        $user->notify(
                            new ImportNotification(
                                type: 'inmotiv',
                                message: $inserted.' order(s) imported',
                            ),
                        );
                    }
                }
            } else {
                $this->error($response->status());
            }
        } else {
            $this->error($response->status());
        }
    }
}
