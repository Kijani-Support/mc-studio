<?php

namespace App\Filament\Responses;

use App\Filament\Responses\Contracts\LoginResponse;
use Filament\Facades\Filament;
use Livewire\Redirector;
use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\Support\Responsable;

class LoginLinkResponse implements LoginResponse
{

    public function __construct(){

        $this->toResponse(request());
    }
    public function toResponse($request)
    {
        return redirect()->intended(route('filament.pages.account'));
    }
}
