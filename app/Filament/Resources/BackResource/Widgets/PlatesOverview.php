<?php

namespace App\Filament\Resources\BackResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class PlatesOverview extends Widget
{
    protected static string $view = 'filament.resources.back-resource.widgets.plates-overview';

    protected int|string|array $columnSpan = 'full';

    public ?Model $record = null;
}
