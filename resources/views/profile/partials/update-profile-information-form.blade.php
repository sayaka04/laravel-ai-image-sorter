<section>
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-slate-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-slate-300">
                {{ __('Name') }}
            </label>
            <input id="name" name="name" type="text"
                class="block w-full p-2.5 bg-slate-950 border border-slate-800 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-600"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />

            @error('name')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-slate-300">
                {{ __('Email') }}
            </label>
            <input id="email" name="email" type="email"
                class="block w-full p-2.5 bg-slate-950 border border-slate-800 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-600"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />

            @error('email')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-2">
                <p class="text-sm text-slate-300">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-indigo-400 hover:text-indigo-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-500 focus:ring-4 focus:outline-none focus:ring-indigo-500/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
            <p class="text-sm text-green-400 fade-out-message">
                {{ __('Saved.') }}
            </p>
            @endif
        </div>
    </form>
</section>