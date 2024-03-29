<?php

namespace App\Filament\Pages;

use App\Exports\DefaultExportHeading;
use App\Models\Plate;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class Reports extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reports';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationGroup = 'Admin';

    public $StartDate;

    public $StopDate;

    public $ReportType;

    public function mount(): void
    {
        $this->form->fill([
            'StartDate' => Carbon::now()->startOfMonth(),
            'StopDate' => Carbon::now(),
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\DatePicker::make('StartDate')->maxDate(Carbon::now())->required(),
            Forms\Components\DatePicker::make('StopDate')->maxDate(Carbon::now())->required(),
            Forms\Components\Select::make('ReportType')->options([
                'customervsitems' => 'Customer vs Items',
            ])
                ->required(),
        ];
    }

    public function submit()
    {
        if ($this->ReportType == 'customervsitems') {
            $plates = Plate::select(DB::raw('created_at, origin, customer, product_type, type, case when is_cod=1 then "COD" when is_rush=1 then "RUSH" else "" end, amount, replace(json_extract(datas, "$.payment_method"),"\"","") as payment_method, case when replace(json_extract(datas, "$.price"),"\"","") = "null" then "" else replace(json_extract(datas, "$.price"),"\"","") end'))->whereBetween('created_at', [$this->StartDate, $this->StopDate])->orderBy('created_at')->orderBy('origin')->orderBy('customer')->get()->toArray();

            $export = new DefaultExportHeading($plates, [
                'Date',
                'Origin',
                'Customer',
                'Product Type',
                'Type',
                'COD',
                'Amount',
                'Payment Method',
                'Price',
            ]);

            return Excel::download($export, 'CustomerVsItems-'.Carbon::createFromDate($this->StartDate)->format('Ymd').'-'.Carbon::createFromDate($this->StopDate)->format('Ymd').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        }
    }
}
