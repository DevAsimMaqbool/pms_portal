<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <!-- <h4 class="mb-1">Welcome to Assessment!</h4> -->
    <!-- <p class="mb-6">Make your app management easy and fun!</p> -->
    <form method="POST" action="{{ route('login') }}" id="formAuthentication" class="mb-4">
        @csrf

        <!-- Email Address -->
        <div class="mb-6 form-control-validation">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" placeholder="Enter your email or username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-6 form-password-toggle form-control-validation">
            <x-input-label for="password" :value="__('Password')" />
            <div class="input-group input-group-merge">
                <x-text-input id="password" class="form-control" type="password" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="my-8">
            <div class="d-flex justify-content-between">
                <div class="form-check mb-0 ms-2">
                    <input class="form-check-input" name="remember" type="checkbox" id="remember_me" />
                    <label class="form-check-label" for="remember-me">{{ __('Remember me') }}</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </div>
        <div class="mb-6">

            <x-primary-button class="btn btn-primary d-grid w-100">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
    {{-- <p class="text-center">
        <span>New on our platform?</span>
        @if (Route::has('register'))
            <a href="{{ route('register') }}">
                <span>Create an account</span>
            </a>
        @endif
    </p> --}}
</x-guest-layout>