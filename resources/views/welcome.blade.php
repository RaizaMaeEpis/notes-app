<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        @endif
    </head>
    <body class="bg-slate-50 dark:bg-zinc-950 text-slate-900 flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        
        <header class="w-full lg:max-w-4xl max-w-xs text-sm mb-6">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-1.5 border border-slate-300 dark:border-zinc-700 rounded-sm hover:bg-slate-100 dark:hover:bg-zinc-800 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-1.5 hover:underline dark:text-zinc-300">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-1.5 border border-slate-300 dark:border-zinc-700 rounded-sm hover:bg-slate-100 dark:hover:bg-zinc-800 transition dark:text-zinc-300">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <div class="flex items-center justify-center w-full lg:grow">
            <main class="flex max-w-xs w-full flex-col-reverse lg:max-w-4xl lg:flex-row shadow-lg rounded-lg overflow-hidden border border-slate-200 dark:border-zinc-800">
                <div class="flex-1 p-8 lg:p-20 bg-white dark:bg-zinc-900">
                    <h1 class="mb-2 text-xl font-semibold text-slate-900 dark:text-white">Let's get started</h1>
                    <p class="mb-6 text-slate-600 dark:text-zinc-400">
                        Your Laravel application is ready. Begin by defining your routes or building your database schema.
                    </p>
                    
                    <div class="space-y-4">
                        <div class="p-4 rounded-md bg-slate-50 dark:bg-zinc-800/50 border border-slate-100 dark:border-zinc-700">
                            <h3 class="font-medium text-blue-600 dark:text-blue-400">Application Ready</h3>
                            <p class="text-sm text-slate-500 dark:text-zinc-500">Environment: {{ app()->environment() }}</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>

    </body>
</html>