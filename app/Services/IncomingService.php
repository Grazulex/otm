<?php

namespace App\Services;

use App\Models\Incoming;
use App\Models\Plate;

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
      $content[] = array('Plate nr.', 'Ref plaque', 'Order date', 'OwnerID', 'Nom Client', 'Rue Client', 'Nr. Client', 'Boite ClIENT', 'Commune', 'Code postal');
      foreach ($this->plates as $plate) {
         //$datas = $plate->datas;
         $content[] =  array($plate->reference, $plate->type, $plate->created_at, $plate->order_id, $plate->customer, $plate->datas['destination_street'], $plate->datas['destination_house_number'], $plate->datas['destination_bus'], $plate->datas['destination_city'], $plate->datas['destination_postal_code']);
      }
      return $this->array2pdf($content);
   }

   function array2pdf($data, $delimiter = ',', $enclosure = '"', $escape_char = "\\")
   {
      $f = fopen('php://memory', 'r+');
      foreach ($data as $item) {
         fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
      }
      rewind($f);
      return stream_get_contents($f);
   }
}
