<?php

namespace App\Console\Commands;

use App\Models\Plate;
use Illuminate\Console\Command;

class UpdateZipCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otm:update:zip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update plate zip';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $plates = Plate::all();
        foreach ($plates as $plate) {
            if (! empty($plate['datas'])) {
                if (isset($plate['datas']['destination_postal_code'])) {
                    $plate->delivery_zip = $plate['datas']['destination_postal_code'];
                }
                $plate->update();
            }
        }
    }
}
