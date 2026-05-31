<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artisan Canvas</title>

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1E40AF">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { font-family: 'DM Sans', sans-serif; }
        h1, h2, h3, .brand { font-family: 'Sora', sans-serif; }

        body { background: #F0F4F8; min-height: 100vh; }

        .navbar {
            background: linear-gradient(135deg, #1E40AF 0%, #3B82F6 100%);
            box-shadow: 0 4px 24px rgba(30, 64, 175, 0.15);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .profile-dropdown { position: relative; }
        .profile-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(30, 64, 175, 0.15);
            min-width: 200px;
            overflow: hidden;
            z-index: 999;
        }
        .profile-menu.open { display: block; }
        .profile-menu a, .profile-menu button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            background: none;
            border: none;
            cursor: pointer;
            text-align: left;
            transition: background 0.15s;
            text-decoration: none;
        }
        .profile-menu a:hover, .profile-menu button:hover { background: #EBF8FF; color: #1E40AF; }
        .profile-menu .divider { height: 1px; background: #E2E8F0; margin: 4px 0; }

        .avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.6);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 15px; color: white;
            cursor: pointer;
            transition: transform 0.15s;
            font-family: 'Sora', sans-serif;
        }
        .avatar:hover { transform: scale(1.07); }

        .install-btn {
            background: #00F5D4;
            color: #0F172A;
            font-weight: 700;
            font-size: 13px;
            padding: 8px 16px;
            border-radius: 99px;
            border: none;
            cursor: pointer;
            display: none;
            align-items: center;
            gap: 6px;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 2px 8px rgba(0, 245, 212, 0.3);
        }
        .install-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(0, 245, 212, 0.5); }
        .install-btn.visible { display: flex; }

        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: white;
            border-top: 1px solid #E2E8F0;
            padding: 8px 0 calc(8px + env(safe-area-inset-bottom));
            z-index: 99;
            box-shadow: 0 -4px 20px rgba(30, 64, 175, 0.06);
        }
        .bottom-nav-items {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
        .bottom-nav-item {
            display: flex; flex-direction: column; align-items: center;
            gap: 3px; color: #6B7280; text-decoration: none;
            font-size: 10px; font-weight: 500;
            padding: 4px 16px; border-radius: 12px;
            transition: color 0.15s;
            background: none; border: none; cursor: pointer;
        }
        .bottom-nav-item.active, .bottom-nav-item:hover { color: #1E40AF; }
        .bottom-nav-item svg { width: 22px; height: 22px; }
        .bottom-nav-add {
            background: #1E40AF;
            border-radius: 50%;
            width: 52px; height: 52px;
            display: flex; align-items: center; justify-content: center;
            color: white; box-shadow: 0 4px 16px rgba(30, 64, 175, 0.4);
            text-decoration: none;
            transition: transform 0.15s;
            margin-top: -16px;
        }
        .bottom-nav-add:hover { transform: scale(1.08); }
        .bottom-nav-add svg { width: 26px; height: 26px; }

        @media (max-width: 768px) {
            .bottom-nav { display: block; }
            .desktop-only { display: none !important; }
            main { padding-bottom: 90px !important; }
        }
        @media (min-width: 769px) {
            .mobile-only { display: none !important; }
        }

        .alert-success {
            background: #ECFDF5; border-left: 4px solid #10B981;
            color: #065F46; border-radius: 12px; padding: 12px 16px;
            margin-bottom: 20px; font-size: 14px;
        }
    </style>
</head>
<body>

    <nav class="navbar" role="navigation" aria-label="Main navigation">
        <div class="max-w-5xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">

                <a href="{{ route('notes.index') }}" aria-label="Artisan Canvas Home" class="brand text-white text-xl font-extrabold tracking-tight italic" style="text-decoration:none;">
                    🎨 Artisan Canvas
                </a>

                <div class="flex items-center gap-3">

                    <button id="installBtn" class="install-btn" aria-label="Install app">
                        ⬇ Install
                    </button>

                    <a href="{{ route('notes.create') }}" class="desktop-only bg-white text-blue-700 px-4 py-2 rounded-full font-bold text-sm hover:bg-blue-50 transition" style="text-decoration:none;" aria-label="Create new artwork">
                        + New Artwork
                    </a>

                    <div class="profile-dropdown">
                        <div class="avatar" onclick="toggleProfile()" id="avatarBtn" role="button" aria-label="Open profile menu" tabindex="0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="profile-menu" id="profileMenu" role="menu">
                            <div style="padding: 16px 18px 12px; border-bottom: 1px solid #E2E8F0;">
                                <div style="font-weight: 700; font-size: 14px; color: #1F2937; font-family: 'Sora', sans-serif;">{{ auth()->user()->name }}</div>
                                <div style="font-size: 12px; color: #6B7280; margin-top: 2px;">{{ auth()->user()->email }}</div>
                            </div>
                            <a href="{{ route('profile.edit') }}" role="menuitem" aria-label="My Profile">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                My Gallery Profile
                            </a>
                            <div class="divider" role="separator"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" role="menuitem" aria-label="Logout">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </nav>

    <main class="py-6" role="main">
        <div class="max-w-5xl mx-auto px-4">
            @if(session('success'))
                <div class="alert-success" role="alert">✓ {{ session('success') }}</div>
            @endif
            @yield('content')
        </div>
    </main>

    <nav class="bottom-nav mobile-only" role="navigation" aria-label="Bottom navigation">
        <div class="bottom-nav-items">
            <a href="{{ route('notes.index') }}" class="bottom-nav-item active" aria-label="Home">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Gallery
            </a>
            <a href="{{ route('notes.create') }}" class="bottom-nav-add" aria-label="Create new artwork">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            </a>
            <a href="{{ route('profile.edit') }}" class="bottom-nav-item" aria-label="Profile">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profile
            </a>
        </div>
    </nav>

    <script>
    function toggleProfile() {
        document.getElementById('profileMenu').classList.toggle('open');
    }
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profileMenu');
        const avatar = document.getElementById('avatarBtn');
        if (!avatar.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove('open');
        }
    });

    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/service-worker.js');
    }

    let deferredPrompt;
    const installBtn = document.getElementById('installBtn');
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        installBtn.classList.add('visible');
    });
    installBtn.addEventListener('click', async () => {
        if (!deferredPrompt) return;
        deferredPrompt.prompt();
        const result = await deferredPrompt.userChoice;
        if (result.outcome === 'accepted') {
            installBtn.classList.remove('visible');
        }
        deferredPrompt = null;
    });
    </script>
</body>
</html>