/*************************
 * Service worker for PWA
 * References: https://developers.google.com/web/ilt/pwa/caching-files-with-service-worker
 *************************/

const cacheName = 'herbio3-app';
const files = [
    "/css/style.css"
];


self.addEventListener('install', async e => {
    const cache = await caches.open(cacheName);
    await cache.addAll(files);
    return self.skipWaiting();
});

self.addEventListener('activate', e => {
    self.clients.claim();
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            return response || fetch(event.request);
        })
    );
});
