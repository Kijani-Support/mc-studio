<x-filament::page>
  <form wire:submit.prevent="updatePassword" class="col-span-2 sm:col-span-1 mt-5 md:mt-0">
    <x-filament::card>

        {{ $this->updateProfileForm }}

        {{ $this->updatePasswordForm }}

        <x-slot name="footer">
            <div class="text-right">
                <x-filament::button type="submit">
                    {{ __('Update Details') }}
                </x-filament::button>
            </div>
        </x-slot>
    </x-filament::card>
</form>
</x-filament::page>