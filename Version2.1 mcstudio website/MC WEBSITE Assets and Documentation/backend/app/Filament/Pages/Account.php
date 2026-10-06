<?php

namespace App\Filament\Pages;

use App\Http\Middleware\EnsureBusinessSettingsAreSet;
use App\Http\Middleware\EnsureUserHasChangedPassword;
use Closure;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;


class Account extends Page
{
    protected static string $view = 'filament.pages.account';

    protected static bool $shouldRegisterNavigation = false;

    public $user;
    public $name;
    public $email;
    public $new_password;
    public $new_password_confirmation;


    public function mount()
    {
        if($user = Filament::auth()->user()){
            $this->user = $user;
            $this->updateProfileForm->fill($this->user->toArray());
        }
    }

    // public static function getRoutes(): Closure
    // {
    //     return function () {
    //         Route::get('/account', static::class)
    //         ->name(static::getSlug())
    //         ->withoutMiddleware([
    //             EnsureUserHasChangedPassword::class,
    //             EnsureBusinessSettingsAreSet::class
    //         ]);
    //     };
    // }

    protected function getPasswordUpdateFormSchema(): array
    {
        return [

            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\TextInput::make('new_password')
                                ->label('Password')
                                ->password()
                                ->required(),
                            Forms\Components\TextInput::make('new_password_confirmation')
                                ->label('Confirm Password')
                                ->password()
                                ->same("new_password")
                                ->required(),
                        ])
                        ->columns(2),
                ]),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        unset($data['password']);
    
        return $data;
    }

    protected function getUpdateProfileFormSchema(): array
    {
        return [

            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->disabled()
                                ->label('Name'),
                            Forms\Components\TextInput::make('email')
                                ->required()
                                ->disabled()
                                ->email()
                                ->unique(ignorable: $this->user)
                                ->label('Email'),
                        ])
                        ->columns(2),
                ]),
        ];
    }

    protected function getForms(): array
    {
        return array_merge(parent::getForms(),[

            "updateProfileForm" => $this->makeForm()
                ->schema($this->getUpdateProfileFormSchema())
                ->statePath('userData'),

            "updatePasswordForm" => $this->makeForm()->schema(
                $this->getPasswordUpdateFormSchema()
            )
        ]);
    }

    public function updatePassword(): void
    {
        $state = $this->updatePasswordForm->getState();
        $this->user->update([
            "password" => Hash::make($state["new_password"]),
            "changed_initial_password" => true,
        ]);
        session()->forget("password_hash_web");
        Filament::auth()->login($this->user);
        $this->notify("success", __('Your password has been updated successfully!'));
        $this->reset(["new_password", "new_password_confirmation"]);
    }
}
