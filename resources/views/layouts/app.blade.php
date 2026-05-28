<!DOCTYPE html>
<html>
<head>
  <link rel="manifest" href="/manifest.json">
  <meta name="theme-color" content="#0f172a">
  ...other head tags...
</head>
<body>
  ...your page content...
  <!-- Step F: Install button -->
  <button id="installBtn"
    class="hidden bg-indigo-600 text-white px-4 py-2 rounded">
    Install App
  </button>
  <!-- Step G: Install prompt script -->
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
  <!-- Step D: service worker script -->
  <script>
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js');
  }
  </script>
</body>
</html>