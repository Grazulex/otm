<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class DefaultExport implements FromArray
{
    public function __construct(protected array $content, protected array $header = [])
    {
      //
    }

    public function array(): array
    {
        return $this->content;
    }

    public function headings(): array
    {
        return $this->header;
    }
}
