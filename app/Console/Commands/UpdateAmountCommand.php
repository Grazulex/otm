<?php

namespace App\Console\Commands;

use App\Enums\OriginEnums;
use App\Enums\TypeEnums;
use App\Jobs\ProcessUpdateDateInMotiv;
use App\Jobs\ProcessUpdateDateEshop;
use App\Mail\Test;
use App\Models\Plate;
use App\Models\Production;
use App\Services\ProductionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class UpdateAmountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otm:update:amount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update plate amount (price)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $plates = Plate::all();
        foreach ($plates as $plate) {
            if (!empty($plate['datas'])) {
                if (isset($plate['datas']['price'])) {
                    $price = (float)(str_replace(',', '.', $plate['datas']['price']));
                    $this->info('Update plate '.$plate['reference'].' with price'. $price);
                    $plate->amount = $price*100;
                }
                if (isset($plate['datas']['plate_type'])) {
                    $plate->plate_type = $plate['datas']['plate_type'];
                }
                if (isset($plate['datas']['product_type'])) {
                    $plate->product_type = $plate['datas']['product_type'];
                }
                if (isset($plate['datas']['clientcode'])) {
                    $plate->client_code = $plate['datas']['clientcode'];
                }
                $plate->update();
            }
        }
    }
}
