<x-guest-layout>
    <h4 class="mb-1">Forgot Password? 🔒</h4>
    <p class="mb-6">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" id="formAuthentication" class="mb-6">
        @csrf

        <!-- Email Address -->
        <div class="mb-6 form-control-validation">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
    </form>
    <div class="text-center">
              <a href="{{ route('login') }}" class="d-flex justify-content-center">
                <i class="icon-base ti tabler-chevron-left scaleX-n1-rtl me-1_5"></i>
                Back to login
              </a>
            </div>
</x-guest-layout>
