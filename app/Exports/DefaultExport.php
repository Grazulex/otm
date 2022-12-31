<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class DefaultExport implements FromArray
{

   public function __construct(protected array $content)
   {
      //
   }

   public function array(): array
   {
       return $this->content;
   }
}