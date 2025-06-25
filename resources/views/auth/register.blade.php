<x-guest-layout>
    <!-- <h4 class="mb-1">Welcome to Assessment!</h4> -->
    <!-- <p class="mb-6">Make your app management easy and fun!</p> -->
    <form method="POST" action="{{ route('register') }}" id="formAuthentication" class="mb-6">
        @csrf

        <!-- Name -->
        <div class="mb-6 form-control-validation">
            <x-input-label for="username" :value="__('Name')" />
            <x-text-input id="username" class="form-control" type="text" name="username" :value="old('name')" required
                autocomplete="name" placeholder="Enter your name" autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-6 form-control-validation">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required
                autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-6 form-password-toggle form-control-validation">
            <x-input-label for="password" :value="__('Password')" />
            <div class="input-group input-group-merge">
                <x-text-input id="password" class="form-control" type="password" name="password" required
                    autocomplete="new-password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-6 form-password-toggle form-control-validation">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="input-group input-group-merge">
                <x-text-input id="password_confirmation" class="form-control" type="password"
                    name="password_confirmation" required autocomplete="new-password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="btn btn-primary d-grid w-100">
            {{ __('Register') }}
        </x-primary-button>
    </form>
    <p class="text-center">
        <span>Already have an account?</span>
        <a href="{{ route('login') }}">
            <span>Sign in instead</span>
        </a>
    </p>
</x-guest-layout>