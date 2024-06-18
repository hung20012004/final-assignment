<!-- resources/views/profile.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="container py-4">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <hr class="my-4" />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-4">
                    @livewire('profile.update-password-form')
                </div>

                <hr class="my-4" />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-4">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <hr class="my-4" />
            @endif

            <div class="mt-4">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <hr class="my-4" />

                <div class="mt-4">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
