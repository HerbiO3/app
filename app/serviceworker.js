/*************************
 * Service worker for PWA
 * References: https://developers.google.com/web/ilt/pwa/caching-files-with-service-worker
 *************************/

const cacheName = 'herbio3-app-v04';
const files = [
    "./app/css/style.css",
    "./app/dashboard.php",
    "./app/index.php",
    "./app/img/herbio3.svg"
];


self.addEventListener('install', async e => {
    try{
        const cache = await caches.open(cacheName);
        await cache.addAll(files);
        return self.skipWaiting();
    }catch (e) {
        console.log(e)
    }
});

// Vymaze stare caches (s inym nazvom ako aktualna)
self.addEventListener('activate', e => {
    e.waitUntil((async () => {
        const cacheNames = await caches.keys();
        await Promise.all(cacheNames.map(async (cacheName) => {
            if (self.cacheName !== cacheName) {
                await caches.delete(cacheName);
            }
        }));
    })());
    self.clients.claim();
});

addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request)
            .then(function(response) {
                if (response) {
                    return response;     // if valid response is found in cache return it
                } else {
                    return fetch(event.request)     //fetch from internet
                        .then(function(res) {
                            return caches.open(cacheName)
                                .then(function(cache) {
                                    cache.put(event.request.url, res.clone());    //save the response for future
                                    return res;   // return the fetched data
                                })
                        })
                }
            })
    );
});
