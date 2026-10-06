<div class="space-y-8">
    <p class="text-center">
        {{ __('This account is expired. Please contact an administrator.') }}
    </p>

    <div class="text-center">
        <a class="text-primary-600 hover:text-primary-700" href="{{ route('filament.auth.login') }}">
            {{ __('Back to login') }}
        </a>
    </div>
</div>