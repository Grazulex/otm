<?php

namespace App\Filament\Resources\IncomingResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class PlatesOverview extends Widget {
    protected static string $view = 'filament.resources.incoming-resource.widgets.plates-overview';

    protected int|string|array $columnSpan = 'full';

    public ?Model $record = null;
}
