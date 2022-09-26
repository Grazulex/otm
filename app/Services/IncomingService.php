<?php

namespace App\Services;

use App\Models\Incoming;
use App\Models\Plate;
use Barryvdh\DomPDF\Facade\Pdf;

class IncomingService
{

   public $production;
   public $plates;

   public function __construct(Incoming $incoming)
   {
      $this->incoming = $incoming;
      $this->plates = Plate::where('incoming_id', $incoming->id)->OrderBy('incoming_id', 'desc')->OrderBy('origin', 'desc')->OrderBy('order_id', 'asc')->get();
   }

   public function makeLabel()
   {
      $plates = $this->plates;
      $pdf = Pdf::loadView('pdf/label4', compact('plates'));

      return $pdf->download('label.pdf');
   }

   public function makeBpostFile()
   {
      $content[] = array('Plate nr.', 'Ref plaque', 'Order date', 'OwnerID', 'Nom Client', 'Rue Client', 'Nr. Client', 'Boite ClIENT', 'Commune', 'Code postal');
      foreach ($this->plates as $plate) {
         //$datas = $plate->datas;
         $content[] =  array($plate->reference);
      }
      return $this->array2csv($content);
   }

   function array2csv($data, $delimiter = ',', $enclosure = '"', $escape_char = "\\")
   {
      $f = fopen('php://memory', 'r+');
      foreach ($data as $item) {
         fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
      }
      rewind($f);
      return stream_get_contents($f);
   }
}
