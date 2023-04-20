<?php

namespace App\Filament\Pages;

use App\Exports\DefaultExportHeading;
use App\Jobs\ProcessUpdateDateInMotiv;
use App\Models\Plate;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Pages\Page;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Bpost extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms, WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.bpost';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationGroup = 'Plates';

    public $file;

    public $original_filename = '';

    public $filepath = '';

    public $success = 0;

    public $isImage = false;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\FileUpload::make('bpost')
                ->multiple(false)
                ->required(),
        ];
    }

    public function submit(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->success = 0;
        $this->isImage = false;
        $this->validate([
            'file' => 'required|mimes:csv,txt|max:2048', // 2MB Max
        ]);

        $csvFile = $this->file->get();

        $data = explode("\n", $csvFile);

        $csv = [];
        foreach ($data as $row) {
            $csv[] = $row;
        }

        $platesUpdates = [];
        foreach ($csv as $row => $fields) {
            if ($row == 0) {
                continue;
            }
            if (empty($fields)) {
                continue;
            }
            $data = explode(';', $fields);

            $plaque = str_replace('"', '', explode('/', $data[21])[1]);
            $tracking = str_replace('"', '', $data[0]);
            $plate = Plate::where('reference', $plaque)->latest()->first();
            if ($plate) {
                $plate->tracking = $tracking;
                $plate->save();
                $infos = ['barcode' => $tracking, 'send_date' => Carbon::now()->format('Y-m-d\TH:i:s')];
                ProcessUpdateDateInMotiv::dispatch($plate, $infos);
                $platesUpdates[] = [$tracking, 'OK'];
            } else {
                $platesUpdates[] = [$plaque, $tracking, 'NOK'];
            }

        }
        $export = new DefaultExportHeading($platesUpdates, [
            'plate',
            'tracking',
            'status',
        ]);

        return Excel::download($export, 'tracking-'.Carbon::now().'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
