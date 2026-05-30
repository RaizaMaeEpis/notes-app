self.addEventListener('install', event => {
  event.waitUntil(
    caches.open('notes-pwa-v1').then(cache => {
      return cache.addAll(['/', '/offline']);
    })
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    fetch(event.request).catch(() =>
      caches.match('/offline')
    )
  );
});