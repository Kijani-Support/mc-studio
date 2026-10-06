<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class KijaniWidget extends Widget
{
    protected static string $view = 'filament.widgets.kijani-widget';

    protected static ?string $pollingInterval = null;
}
