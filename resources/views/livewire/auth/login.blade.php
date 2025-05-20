<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use App\Enums\UserRole;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string')]
    public string $email_or_username = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login()
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        $login_name = filter_var($this->email_or_username, FILTER_VALIDATE_EMAIL) ? "email" : "username" ;
        // filter_var() is a built-in PHP function used to validate and sanitize data.
        // filter_var($variable, $filter);
        // $variable: The value you want to check.
        // $filter: The filter you want to apply, like FILTER_VALIDATE_EMAIL, 
        // in my case it check if it is a valod email address or not if it is a valid email address it will return email otherwise it will return username


       if (! Auth::attempt([$login_name => $this->email_or_username, 'password' => $this->password], $this->remember))
    //    $this->remember is a boolean.If it's true, Laravel will "remember" the user 
        {
            RateLimiter::hit($this->throttleKey());

            // RateLimiter::hit(...) increases the count of failed attempts for the current user/IP to prevent brute-force attacks.
            // $this->throttleKey()=It generates a unique key (string) to track login attempts for rate limiting (to prevent brute-force attacks).

            throw ValidationException::withMessages([ 

                //  stops the login process and shows a custom error message under the email_or_username input field.

                'email_or_username' => __('auth.failed'),
                
                // __('auth.failed') comes from Laravel’s translation files and usually says: "These credentials do not match our records."


            ]);

        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        if(auth()->user()->role === UserRole::Admin){
            return redirect()->route('admin.dashboard')->with("success","log in sucessfull");
        }

        //         If the user is logged in, you get the User model instance. Then $user->role will return an enum instance, not just a string
        // === UserRole::Admin
        // his compares the user’s role with the enum value UserRole::Admin.
        // This is a strict comparison, meaning both:
        // The value must be 'admin'
        // The type must match the enum type 

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email_or_username' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email_or_username).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email_or_username"
            :label="__('Email/Username')"
            type="text"
            required
            autofocus
            placeholder="email@example.com/username"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Forgot your password?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Remember me')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif
</div>