<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-red-400">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-slate-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button" onclick="document.getElementById('delete-account-modal').classList.remove('hidden')" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all">
        {{ __('Delete Account') }}
    </button>

    <div id="delete-account-modal" class="{{ $errors->userDeletion->isNotEmpty() ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4">

        <div class="relative w-full max-w-lg bg-slate-900 rounded-xl shadow-2xl border border-slate-800">

            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-white">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="mt-6">
                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                    <input id="password" name="password" type="password"
                        class="block w-3/4 p-2.5 bg-slate-950 border border-slate-800 text-white text-sm rounded-lg focus:ring-red-500 focus:border-red-500 placeholder-slate-600"
                        placeholder="{{ __('Password') }}" />

                    @error('password', 'userDeletion')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('delete-account-modal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-slate-300 bg-slate-800 border border-slate-700 rounded-lg hover:bg-slate-700 focus:outline-none focus:ring-4 focus:ring-slate-700 transition-all">
                        {{ __('Cancel') }}
                    </button>

                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 transition-all">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>