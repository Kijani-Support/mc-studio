<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use FilipFonal\FilamentLogManager\Pages\Logs as BaseLogPage;

class Logs extends BaseLogPage
{
  protected static function shouldRegisterNavigation(): bool
  {
      return Filament::auth()->user()->hasRole(['Admin']);
      // return false;
  }

}
