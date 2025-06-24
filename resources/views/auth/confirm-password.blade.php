<x-guest-layout>
    <h4 class="mb-1">Confirm Password? 🔒</h4>
    <p class="mb-6">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </p>

    <form method="POST" action="{{ route('password.confirm') }}" id="formAuthentication" class="mb-6">
        @csrf

        <!-- Password -->
        <div class="mb-6 form-control-validation">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="form-control"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
    </form>
</x-guest-layout>
