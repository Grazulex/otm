<?php

namespace App\Services;

use App\Models\Production;

class ProductionService {

    public $production;

    public function __construct(Production $production)
    {
        $this->production = $production;
    }

    public function makeCsvAttach()
    {
      $fp = fopen('prod_'.$this->production->id.'.csv', 'w');
      fputcsv($fp, array('Plate nr.', 'Ref plaque', 'Order date', 'OwnerID', 'Nom Client', 'Rue Client', 'Nr. Client', 'Boite ClIENT', 'Commune', 'Code postal'), ";");
      foreach ($this->production->plates as $plate) {
          //$datas = $plate->datas;
          fputcsv($fp, array($plate->reference, $plate->type, $plate->created_at, $plate->order_id, $plate->customer, $plate->datas['destination_street'], $plate->datas['destination_house_number'], $plate->datas['destination_bus'], $plate->datas['destination_city'], $plate->datas['destination_postal_code']), ";");
      }
      fclose($fp);

    }

    public function makeCsv()
    {
      $content[] = array('Plate nr.', 'Ref plaque', 'Order date', 'OwnerID', 'Nom Client', 'Rue Client', 'Nr. Client', 'Boite ClIENT', 'Commune', 'Code postal');
        foreach ($this->production->plates as $plate) {
            //$datas = $plate->datas;
            $content[] =  array($plate->reference, $plate->type, $plate->created_at, $plate->order_id, $plate->customer, $plate->datas['destination_street'], $plate->datas['destination_house_number'], $plate->datas['destination_bus'], $plate->datas['destination_city'], $plate->datas['destination_postal_code']);
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

   public function deleteCSV()
   {
       unlink('prod_'.$this->production->id.'.csv');
   }


}
