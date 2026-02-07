<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - SmartSorter AI</title>
    @include('partials.assets')
</head>

<body class="flex h-screen overflow-hidden bg-slate-950 text-slate-400 font-sans">

    @include('partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        @include('partials.navbar')

        <div class="flex-1 min-h-0 flex flex-col gap-6 p-4 md:p-6 lg:p-8 overflow-y-auto w-full">

            <section>
                <div class="flex flex-col gap-4 shrink-0">

                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-light text-white tracking-tight">Profile Settings</h1>
                            <p class="text-sm text-slate-500 mt-1">Manage your account information and security preferences.</p>
                        </div>
                    </div>

                    <div class="h-px w-full bg-slate-800"></div>

                </div>
            </section>

            <main class="flex-1 m-10">
                <section>
                    <div class="w-full flex justify-center mb-10">

                        <div class="space-y-6 w-full max-w-4xl">

                            <div class="p-6 bg-slate-900 border border-slate-800 rounded-xl shadow-lg">
                                <div class="max-w-xl mx-auto"> @include('profile.partials.update-profile-information-form')
                                </div>
                            </div>

                            <div class="p-6 bg-slate-900 border border-slate-800 rounded-xl shadow-lg">
                                <div class="max-w-xl mx-auto">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </div>

                            <div class="p-6 bg-red-500/5 border border-red-500/10 rounded-xl">
                                <div class="max-w-xl mx-auto">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            </main>

        </div>
    </div>
</body>

</html>