<?php

namespace App\Filament\Pages;

use App\Exports\DefaultExport;
use App\Models\Plate;
use Filament\Pages\Page;
use Filament\Forms;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

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
            'StopDate' => Carbon::now()
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
            $plates = Plate::select(DB::raw('origin, customer, product_type, plate_type,  count(*) as total'))->whereBetween('created_at', [$this->StartDate, $this->StopDate])->groupBy('origin', 'customer', 'product_type', 'plate_type')->orderBy('origin')->orderBy('customer')->get()->toArray();

            $export = new DefaultExport($plates);
    
            return Excel::download($export,'CustomerVsItems-'.Carbon::createFromDate($this->StartDate)->format('Ymd').'-'.Carbon::createFromDate($this->StopDate)->format('Ymd').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        }
    }

}
