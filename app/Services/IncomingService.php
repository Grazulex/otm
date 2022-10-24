<?php

namespace App\Services;

use App\Enums\TypeEnums;
use App\Models\Incoming;
use App\Models\Item;
use App\Models\Plate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class IncomingService
{
    public $incoming;

    public $plates;

    public function __construct(Incoming $incoming)
    {
        $this->incoming = $incoming;
        $this->plates = Plate::where('incoming_id', $incoming->id)
            ->OrderBy('origin', 'desc')
            ->OrderBy('delivery_zip', 'asc')
            ->OrderBy('customer_key', 'asc')
            ->OrderBy('reference', 'asc')
            ->get();
    }

    public function makeLabelKbc()
    {
        $plates = $this->plates;
        $pdf = Pdf::loadView('pdf/labelKbc', compact('plates'))->setpaper(
            'a4',
            'landscape',
        );

        return $pdf->download('lable.pdf');
    }

    public function makeLabelBelfius()
    {
        $plates = $this->plates;
        $customer = $this->incoming->customer;
        $pdf = Pdf::loadView('pdf/labelBelfius', compact('plates', 'customer'))->setPaper(
            'a4',
            'landscape',
        );

        return $pdf->download('label.pdf');
    }

    public function makeBpostFile(bool $needFirstLine = true)
    {
        if ($needFirstLine) {
            $content[] = [
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
            ];
        } else {
            $content = [];
        }
        if (count($this->incoming->customer->labels) > 0) {
            foreach ($this->incoming->customer->labels as $label) {
                $content[] = [
                    'TXP24H',
                    $label->delivery_contact,
                    '',
                    '',
                    $label->delivery_street,
                    $label->delivery_number,
                    $label->delivery_box,
                    $label->delivery_zip,
                    $label->delivery_city,
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
                    '',
                    '',
                    '',
                    'N',
                    'N',
                    'N',
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
                    '',
                ];
            }
        }
        if ($this->incoming->customer->is_delivery_grouped) {
            $quantity_max_grouped = env('OTM_PRODUCTIONS_QUANTITY_MAX_BOX');
            $groupes = DB::table('plates')
                ->select('customer_key')
                ->groupBy('customer_key')
                ->where('incoming_id', $this->incoming->id)
                ->whereNotNull('customer_key')
                ->OrderBy('origin', 'desc')
                ->OrderBy('delivery_zip', 'asc')
                ->OrderBy('customer_key', 'asc')
                ->OrderBy('reference', 'asc')
                ->get();
            foreach ($groupes as $group) {
                $plates = Plate::where('incoming_id', $this->incoming->id)
                    ->where('customer_key', $group->customer_key)
                    ->count();

                $lines = (int) ($plates / $quantity_max_grouped);
                if ($lines === 0) {
                    $lines = 1;
                }

                $location = Plate::where('incoming_id', $this->incoming->id)
                    ->where('customer_key', $group->customer_key)
                    ->first();

                for ($i = 1; $i <= $lines; $i++) {
                    if ($location->datas) {
                        $cod = null;
                        if (isset($location->datas['price'])) {
                            $cod = $location->datas['price'];
                        }

                        $content[] = [
                            'TXP24H',
                            $location->datas['destination_name'],
                            '',
                            '',
                            $location->datas['destination_street'],
                            $location->datas['destination_house_number'],
                            $location->datas['destination_bus'],
                            $location->datas['destination_postal_code'],
                            $location->datas['destination_city'],
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
                            '',
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
                        $i++;
                    }
                }
            }

            $plates = Plate::where('incoming_id', $this->incoming->id)
                ->OrderBy('origin', 'desc')
                ->OrderBy('delivery_zip', 'asc')
                ->OrderBy('customer_key', 'asc')
                ->OrderBy('reference', 'asc')
                ->whereNull('customer_key')
                ->get();
            $i = 1;
            foreach ($plates as $plate) {
                if ($plate->datas) {
                    $message = $i.'*** / '.$plate->reference;
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
                    $cod = null;
                    if (isset($plate->datas['price'])) {
                        $cod = $plate->datas['price'];
                    }

                    $content[] = [
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
                    $i++;
                }
            }
        } else {
            $plates = Plate::where('incoming_id', $this->incoming->id)
                ->OrderBy('origin', 'desc')
                ->OrderBy('delivery_zip', 'asc')
                ->OrderBy('customer_key', 'asc')
                ->OrderBy('reference', 'asc')
                ->get();

            $i = 1;
            foreach ($plates as $plate) {
                if ($plate->datas) {
                    $message = $i.'*** / '.$plate->reference;
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
                    $cod = null;
                    if (isset($plate->datas['price'])) {
                        $cod = $plate->datas['price'];
                    }

                    $content[] = [
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
                    $i++;
                }
            }
        }

        return $this->array2csv($content);
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
}
