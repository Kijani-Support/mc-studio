<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class SubscriptionExpired extends Component
{
    public function render(): View
    {
        return view('livewire.subscription-expired')
            ->layout('filament::components.layouts.card', [
                'title' => __('Account subscription expired'),
            ]);
    }
}
