/*************************
 * Service worker for PWA
 * References: https://developers.google.com/web/ilt/pwa/caching-files-with-service-worker
 *************************/

const cacheName = 'herbio3-app-v11';
const files = [
    "./css/global.css",
    "./dashboard.php",
    "./index.php",
    "./img/herbio3.svg",
    "./img/icons/back.svg",
    "./img/icons/logout.svg",
    "./img/icons/settings.svg",
    "./img/level.svg",
    "./img/uv2.svg",
    "./img/temp2.svg",
    "./img/FrameHum.jpg"
];

const filesUpdate = cache => {
    const stack = [];
    files.forEach(file => stack.push(
        cache.add(file).catch(_=>console.error(`can't load ${file} to cache`))
    ));
    return Promise.all(stack);
};

self.addEventListener("install", (e) => {
    console.log("[Service Worker] Install");
    e.waitUntil(
        (async () => {
            const cache = await caches.open(cacheName);
            console.log("[Service Worker] Caching all");
            await filesUpdate(cache);
        })()
    );
});

// Vymaze stare caches (s inym nazvom ako aktualna)
self.addEventListener("activate", (e) => {
    e.waitUntil(
        caches.keys().then((keyList) => {
            return Promise.all(
                keyList.map((key) => {
                    if (key === cacheName) {
                        return;
                    }
                    return caches.delete(key);
                })
            );
        })
    );
});

self.addEventListener("fetch", (e) => {
    console.log(`[Service Worker] Fetched resource ${e.request.url}`);
});

self.addEventListener("fetch", (e) => {
    e.respondWith(
        (async () => {
            const r = await caches.match(e.request);
            console.log(`[Service Worker] Fetching resource: ${e.request.url}`);
            if (r) {
                return r;
            }
            const response = await fetch(e.request);
            const cache = await caches.open(cacheName);
            console.log(`[Service Worker] Caching new resource: ${e.request.url}`);
            cache.put(e.request, response.clone());
            return response;
        })()
    );
});
