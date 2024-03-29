<?php

namespace App\Services;

use App\Enums\OriginEnums;
use App\Enums\TypeEnums;
use App\Exports\DefaultExport;
use App\Exports\DefaultExportHeading;
use App\Models\Item;
use App\Models\Plate;
use App\Models\Production;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ProductionService
{
    public $production;

    public $plates;

    public function __construct(Production $production)
    {
        $this->production = $production;
        $this->plates = Plate::where('production_id', $production->id)
            ->OrderBy('origin', 'desc')
            ->OrderBy('delivery_zip', 'asc')
            ->OrderBy('customer_key', 'asc')
            ->OrderBy('reference', 'asc')
            ->get();
    }

    public function makeCsvAttach()
    {
        $fp = fopen('prod_'.$this->production->id.'.csv', 'w');
        fputcsv(
            $fp,
            [
                'Plate nr.',
                'Ref plaque',
                'OwnerID',
                'Order date',
                'Nom Client',
                'Rue Client',
                'Nr. Client',
                'Boite ClIENT',
                'Commune',
                'Code postal',
            ],
            ';',
        );
        foreach ($this->plates as $plate) {
            //$datas = $plate->datas;
            fputcsv(
                $fp,
                [
                    $plate->reference,
                    $plate->type,
                    $plate->order_id, //max 8 alpĥanum
                    $plate->created_at,
                    $plate->customer,
                    (isset($plate->datas['destination_street'])) ? $plate->datas['destination_street'] : '',
                    (isset($plate->datas['destination_house_number'])) ? $plate->datas['destination_house_number'] : '',
                    (isset($plate->datas['destination_bus'])) ? $plate->datas['destination_bus'] : '',
                    (isset($plate->datas['destination_city'])) ? $plate->datas['destination_city'] : '',
                    (isset($plate->datas['destination_postal_code'])) ? $plate->datas['destination_postal_code'] : '',
                ],
                ';',
            );
        }
        fclose($fp);
    }

    public function makeCsv()
    {
        foreach ($this->plates as $plate) {
            //$datas = $plate->datas;
            $content[] = [
                $plate->reference,
                $plate->type,
                $plate->order_id, //max 8 alpĥanum
                $plate->created_at,
                $plate->customer,
                (isset($plate->datas['destination_street'])) ? $plate->datas['destination_street'] : '',
                (isset($plate->datas['destination_house_number'])) ? $plate->datas['destination_house_number'] : '',
                (isset($plate->datas['destination_bus'])) ? $plate->datas['destination_bus'] : '',
                (isset($plate->datas['destination_city'])) ? $plate->datas['destination_city'] : '',
                (isset($plate->datas['destination_postal_code'])) ? $plate->datas['destination_postal_code'] : '',

            ];
        }

        $export = new DefaultExportHeading($content, [
            'Plate nr.',
            'Ref plaque',
            'OwnerID',
            'Order date',
            'Nom Client',
            'Rue Client',
            'Nr. Client',
            'Boite ClIENT',
            'Commune',
            'Code postal',
        ]);

        return Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);

        //return $this->array2csv($content);
    }

    public function makeLetterCod()
    {
        $allPlates = $this->plates;
        $plates = [];
        foreach ($allPlates as $plate) {
            if (isset($plate->datas)) {
                if (array_key_exists('payment_method', $plate->datas)) {
                    if (strtolower($plate->datas['payment_method']) === 'cod') {
                        $plates[] = $plate;
                    }
                }
            }
        }
        $pdf = Pdf::loadView('pdf/letterCod', compact('plates'))->setPaper(
            'a4',
            'portrait',
        );

        return $pdf->download('Cod_'.$this->getPartDateForFilename().'.pdf');
    }

    public function closeProduction()
    {
        $quantity_max_grouped = env('OTM_PRODUCTIONS_QUANTITY_MAX_BOX');
        $plates = Plate::where('production_id', $this->production->id)
            ->OrderBy('origin', 'desc')
            ->OrderBy('delivery_zip', 'asc')
            ->OrderBy('customer_key', 'asc')
            ->OrderBy('reference', 'asc')
            ->with('incoming')
            ->get();
        $i = 1;
        $group = 1;
        $last_customer_key = null;
        foreach ($plates as $plate) {
            if ($plate->datas) {
                $this->saveBox($plate, $i);
                if ($plate->customer_key != '' && $plate->customer_key === $last_customer_key) {
                    $group++;
                    if ($group >= $quantity_max_grouped) {
                        $group = 1;
                        $i++;
                    }
                } else {
                    $group = 1;
                    $i++;
                }
                $last_customer_key = $plate->customer_key;
            }
        }

        $this->production->is_bpost = true;
        $this->production->save();

        $this->production->checkIfCod();
        $this->production->checkIfPicking();
        $this->production->checkIfShipping();
    }

    public function makeBpostFile(bool $needFirstLine = true)
    {
        $quantity_max_grouped = env('OTM_PRODUCTIONS_QUANTITY_MAX_BOX');
        $content = [];

        $plates = Plate::where('production_id', $this->production->id)
            ->OrderBy('origin', 'desc')
            ->OrderBy('delivery_zip', 'asc')
            ->OrderBy('customer_key', 'asc')
            ->OrderBy('reference', 'asc')
            ->with('incoming')
            ->get();
        $i = 1;
        $group = 1;
        $last_customer_key = null;
        foreach ($plates as $plate) {
            if ($plate->datas) {
                //$this->saveBox($plate, $i);
                if ($plate->customer_key != '' && $plate->customer_key === $last_customer_key) {
                    $group++;
                    if ($group >= $quantity_max_grouped) {
                        $group = 1;
                        $content[] = $this->addline($plate, $i, false);
                        $i++;
                    }
                } else {
                    $group = 1;
                    $content[] = $this->addline($plate, $i, true);
                    $i++;
                }
                $last_customer_key = $plate->customer_key;
            }
        }

        /*
        $this->production->is_bpost = true;
        $this->production->save();

        $this->production->checkIfCod();
        $this->production->checkIfPicking();
        $this->production->checkIfShipping();
        */

        if ($needFirstLine) {
            $export = new DefaultExportHeading($content, [
                'ProductId',
                'Name',
                'Contact Name',
                'Contact Phone',
                'Street',
                'Street Number',
                'Box Number',
                'Postal Code',
                'City',
                'Country',
                'Sender Name',
                'Sender Contact Name',
                'Sender Street',
                'Sender Street Number',
                'Sender Box Number',
                'Sender Postal Code',
                'Sender City',
                'Weight',
                'Customer Reference',
                'Cost Center',
                'Free Message',
                'COD Amount',
                'COD Account',
                'Signature',
                'Insurance',
                'Automatic Second Presentation',
                'Before 11am',
                'Info Reminder',
                'Info Reminder Language',
                'Info Reminter Type',
                'Info Reminder Contact Data',
                'Info Next Day',
                'Info Next Day language',
                'Info Next Day Type',
                'Info Next day Contact Data',
                'Info Distributed',
                'Info Distributed Language',
                'Info Distributed Type',
                'Info Distributed Contact Data',
                'bic cod',
            ]);
        } else {
            $export = new DefaultExport($content);
        }

        return Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);
    }

    private function saveBox(Plate $plate, $i)
    {
        $plate->box = $i;
        $plate->save();
    }

    private function addline(Plate $plate, $i, $needMessage = true)
    {
        if ($needMessage) {
            $message = $i.' *** / '.$plate->reference;
            $otherItems = Plate::where('reference', $plate->reference)
                ->whereNotIn(
                    'type',
                    array_column(TypeEnums::cases(), 'name'),
                )
                ->get();
            if ($otherItems) {
                foreach ($otherItems as $otherItem) {
                    $item = Item::where(
                        'reference_customer',
                        $plate->datas['plate_type'],
                    )->first();
                    if ($item) {
                        $message .=
                            ' / 1 '.strtoupper($item->reference_otm);
                    }
                }
            }
        } else {
            $message = $i;
        }
        $cod = null;
        if (isset($plate->datas['price'])) {
            $cod = $plate->datas['price'];
        }

        return [
            'TXP24H',
            $plate->datas['destination_name'],
            '',
            '',
            $plate->datas['destination_street'],
            $plate->datas['destination_house_number'],
            $plate->datas['destination_bus'],
            $plate->datas['destination_postal_code'],
            $plate->datas['destination_city'],
            'BE',
            'OTM-Shop',
            '',
            'Potaardestraat',
            '42',
            '',
            '1082',
            'Brussel',
            '',
            '',
            '999786',
            $message,
            $cod,
            (int) $cod > 0 ? 'BE29096898971264' : '',
            (int) $cod > 0 ? '' : 'N',
            (int) $cod > 0 ? '' : 'N',
            (int) $cod > 0 ? '' : 'N',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            (int) $cod > 0 ? 'GKCCBEBB' : '',
        ];
    }

    public function makePicking()
    {
        $allPlates = $this->plates;
        $items = [];
        $resumes = [];
        foreach ($allPlates as $plate) {
            $otherItems = Plate::where('reference', $plate->reference)
                ->where('created_at', $plate->created_at)
                ->whereNotIn(
                    'type',
                    array_column(TypeEnums::cases(), 'name'),
                )
                ->get();
            if (count($otherItems) > 0) {
                $items[] = [
                    'box' => $plate->box,
                    'items' => $otherItems,
                ];
                foreach ($otherItems as $otherItem) {
                    $name = Item::where(
                        'reference_customer',
                        $otherItem->type,
                    )->first();
                    $resumes[isset($name->name) ? $name->name : $otherItem->type] = isset($resumes[$otherItem->type]) ? $resumes[$otherItem->type] + 1 : 1;
                }
            }
        }

        $pdf = Pdf::loadView('pdf/picking', compact('resumes', 'items'))->setPaper(
            'a4',
            'portrait',
        );

        return $pdf->download('Pick_'.$this->getPartDateForFilename().'.pdf');
    }

    public function makeShipping()
    {
        $allPlates = $this->plates;
        $items = [];
        foreach ($allPlates as $plate) {
            if ($plate->incoming_id == null && $plate->origin === OriginEnums::INMOTIV) {
                $items[$plate->customer_key]['datas'] = $plate->datas;
                $items[$plate->customer_key]['items'][] = ['ref' => $plate->reference, 'type' => $plate->type];
            }
        }
        foreach ($items as $key => $item) {
            if (count($item['items']) === 1) {
                unset($items[$key]);
            }
        }

        $pdf = Pdf::loadView('pdf/shipping', compact('items'))->setPaper(
            'a4',
            'portrait',
        );

        return $pdf->download('Ship_'.$this->getPartDateForFilename().'.pdf');
    }

    public function array2csv(
        $data,
        $delimiter = ',',
        $enclosure = '"',
        $escape_char = '\\',
    ) {
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

    public function getPartDateForFilename()
    {
        return Carbon::now()->format('Ymd_Hi');
    }
}
