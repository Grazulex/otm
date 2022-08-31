<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Plate;
use App\Enums\TypeEnums;
use App\Enums\OriginEnums;
use App\Models\Production;
use Illuminate\Console\Command;
use App\Services\HolidayService;
use App\Services\ProductionService;
use App\Jobs\ProcessUpdateDateEshop;
use Illuminate\Support\Facades\Mail;
use App\Jobs\ProcessUpdateDateInMotiv;
use App\Mail\Production as MailProduction;
use Str;

class ExportProductionCommande extends Command
{
   /**
    * The name and signature of the console command.
    *
    * @var string
    */
   protected $signature = 'otm:export:production';

   /**
    * The console command description.
    *
    * @var string
    */
   protected $description = 'Export order to email';

   /**
    * Execute the console command.
    *
    * @return int
    */
   public function handle()
   {
      $holidays = HolidayService::get();
      if ($holidays->isHoliday(Carbon::today()->month, Carbon::today()->day)) {
         return false;
         die();
      }

      $plates = Plate::whereIn('type', array_column(TypeEnums::cases(), 'name'))
         ->whereNull('production_id')
         ->where(function ($q) {
            $q->orWhere(function ($q) {
               $q->where('is_incoming', 0);
            });
            $q->orWhere(function ($q) {
               $q->where('is_incoming', 1)->whereNotNull('incoming_id');
            });
         })->get();
      if ($plates->count() > 0) {
         $production = Production::create();
         foreach ($plates as $plate) {
            $plate->production_id = $production->id;
            $plate->forceFill([
               'datas->production_date' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            $plate->update();
            if ($plate->origin === OriginEnums::INMOTIV) {
               $datas = ['PRODUCTION_DATE' => Carbon::now()->format('Y-m-d\TH:i:s')];
               ProcessUpdateDateInMotiv::dispatch($plate, $datas);
            }
            if ($plate->origin === OriginEnums::ESHOP) {
               $datas = ['SEND_DATE' => Carbon::now()->format('Y-m-d\TH:i:s')];
               //ProcessUpdateDateEshop::dispatch($plate, $datas);
            }
         }

         $productionService = new ProductionService($production);
         $productionService->makeCsvAttach();

         $destinataires = explode(',', env('OTM_PRODUCTIONS_EMAILS'));
         foreach ($destinataires as $recipient) {
            $this->info('Mail send to  ' . $recipient);
            Mail::to($recipient)->send(new MailProduction($production));
         }

         $productionService->deleteCSV();
      }
   }
}
