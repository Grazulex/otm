<?php

namespace App\Services;

use App\Models\Incoming;
use App\Models\Plate;
use App\Models\Item;
use App\Enums\TypeEnums;
use Barryvdh\DomPDF\Facade\Pdf;

class IncomingService
{
    public $production;
    public $plates;

    public function __construct(Incoming $incoming)
    {
        $this->incoming = $incoming;
        $this->plates = Plate::where("incoming_id", $incoming->id)
            ->OrderBy("incoming_id", "desc")
            ->OrderBy("origin", "desc")
            ->OrderBy("order_id", "asc")
            ->get();
    }

    public function makeLabelKbc()
    {
        $plates = $this->plates;
        $df = Pdf::loadView("pdf/labelKbc", compact("plates"))->setpaper(
            "a4",
            "landscape"
        );

        return $pdf->download("lable.pdf");
    }

    public function makeLabelBelfius()
    {
        $plates = $this->plates;
        $pdf = Pdf::loadView("pdf/labelBelfius", compact("plates"))->setPaper(
            "a4",
            "landscape"
        );

        return $pdf->download("label.pdf");
    }

    public function makeBpostFile()
    {
        $content[] = [
            "ProductId",
            "Name",
            "Contact Name",
            "Contact Phone",
            "Street",
            "Street Number",
            "Box Number",
            "Postal Code",
            "City",
            "Country",
            "Sender Name",
            "Sender Contact Name",
            "Sender Street",
            "Sender Street Number",
            "Sender Box Number",
            "Sender Postal Code",
            "Sender City",
            "Weight",
            "Customer Reference",
            "Cost Center",
            "Free Message",
            "COD Amount",
            "COD Account",
            "Signature",
            "Insurance",
            "Automatic Second Presentation",
            "Before 11am",
            "Info Reminder",
            "Info Reminder Language",
            "Info Reminter Type",
            "Info Reminder Contact Data",
            "Info Next Day",
            "Info Next Day language",
            "Info Next Day Type",
            "Info Next day Contact Data",
            "Info Distributed",
            "Info Distributed Language",
            "Info Distributed Type",
            "Info Distributed Contact Data",
            "bic cod",
        ];
        $i = 1;
        foreach ($this->plates as $plate) {
            if ($plate->datas) {
                $message = $i . "*** / " . $plate->reference;
                $otherItems = Plate::where("reference", $plate->reference)
                    ->whereNotIn(
                        "type",
                        array_column(TypeEnums::cases(), "name")
                    )
                    ->get();
                if ($otherItems) {
                    foreach ($otherItems as $otherItem) {
                        $item = Item::where(
                            "reference_customer",
                            $plate->datas["plate_type"]
                        )->first();
                        if ($item) {
                            $message .=
                                " / 1 " . strtoupper($item->reference_otm);
                        }
                    }
                }
                $cod = null;
                if (isset($plate->datas["price"])) {
                    $cod = $plate->datas["price"];
                }

                $content[] = [
                    "TXP24H",
                    $plate->datas["destination_name"],
                    "",
                    "",
                    $plate->datas["destination_street"],
                    $plate->datas["destination_house_number"],
                    $plate->datas["destination_bus"],
                    $plate->datas["destination_postal_code"],
                    $plate->datas["destination_city"],
                    "BE",
                    "OTM-Shop",
                    "",
                    "Potaardestraat",
                    "42",
                    "",
                    "1082",
                    "Brussel",
                    "",
                    "",
                    "999786",
                    $message,
                    $cod,
                    (int) $cod > 0 ? "BE29096898971264" : "",
                    (int) $cod > 0 ? "" : "N",
                    (int) $cod > 0 ? "" : "N",
                    (int) $cod > 0 ? "" : "N",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    (int) $cod > 0 ? "GKCCBEBB" : "",
                ];
                $i++;
            }
        }
        return $this->array2csv($content);
    }

    function array2csv(
        $data,
        $delimiter = ",",
        $enclosure = '"',
        $escape_char = "\\"
    ) {
        $f = fopen("php://memory", "r+");
        foreach ($data as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
        }
        rewind($f);
        return stream_get_contents($f);
    }
}
