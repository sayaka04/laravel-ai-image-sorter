<section>
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-slate-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block mb-2 text-sm font-medium text-slate-300">
                {{ __('Current Password') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="block w-full p-2.5 bg-slate-950 border border-slate-800 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-600"
                autocomplete="current-password" />

            @error('current_password', 'updatePassword')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block mb-2 text-sm font-medium text-slate-300">
                {{ __('New Password') }}
            </label>
            <input id="update_password_password" name="password" type="password"
                class="block w-full p-2.5 bg-slate-950 border border-slate-800 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-600"
                autocomplete="new-password" />

            @error('password', 'updatePassword')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block mb-2 text-sm font-medium text-slate-300">
                {{ __('Confirm Password') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="block w-full p-2.5 bg-slate-950 border border-slate-800 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-600"
                autocomplete="new-password" />

            @error('password_confirmation', 'updatePassword')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-500 focus:ring-4 focus:outline-none focus:ring-indigo-500/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
            <p class="text-sm text-green-400 fade-out-message">
                {{ __('Saved.') }}
            </p>
            @endif
        </div>
    </form>
</section>