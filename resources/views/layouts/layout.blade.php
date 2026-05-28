<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raiza Notes</title>

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0f172a">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-gradient-to-r from-indigo-700 via-purple-600 to-blue-500 shadow-xl border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <div class="flex items-center">
                    <h1 class="text-white text-3xl font-extrabold tracking-tighter italic">
                        Raiza Notes
                    </h1>
                </div>

                <div class="flex items-center space-x-6">
                    <button id="installBtn"
                            class="hidden bg-amber-400 hover:bg-amber-300 text-slate-900 px-4 py-2 rounded font-bold shadow-md transition duration-200">
                      Install App
                    </button>

                    <div class="text-right hidden sm:block">
                        <p class="text-white text-sm font-medium">Welcome back,</p>
                        <p class="text-white text-xs opacity-80">{{ auth()->user()->name }}</p>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg border border-white/30 transition duration-300 text-sm font-semibold">
                            Logout
                        </button>
                    </form>

                    <a href="{{ route('notes.create') }}" class="bg-white text-purple-700 hover:bg-purple-50 px-5 py-2.5 rounded-full font-bold shadow-lg transform hover:scale-105 transition duration-200">
                        + Add Note
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/service-worker.js');
    }
    </script>

    <script>
    let deferredPrompt;
    const installBtn = document.getElementById('installBtn');
    window.addEventListener('beforeinstallprompt', (e) => {
      e.preventDefault();
      deferredPrompt = e;
      installBtn.classList.remove('hidden');
    });
    installBtn.addEventListener('click', async () => {
      if (!deferredPrompt) return;
      deferredPrompt.prompt();
      const result = await deferredPrompt.userChoice;
      if (result.outcome === 'accepted') {
        installBtn.classList.add('hidden');
      }
      deferredPrompt = null;
    });
    </script>
</body>
</html>