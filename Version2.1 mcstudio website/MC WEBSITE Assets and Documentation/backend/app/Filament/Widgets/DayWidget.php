<?php

namespace App\Filament\Widgets;

use Buildix\Timex\Widgets\Mini\DayWidget as BaseDayWidget;

class DayWidget extends BaseDayWidget
{
    public function openCalendar()
    {
        $base_path = app()['config']['filament']['path'];
        return \Redirect::to($base_path.'/'.$this->getPageClass()::getSlug());
    }
}
