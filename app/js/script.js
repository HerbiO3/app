// serviceworker registration
navigator.serviceWorker.register('./serviceworker.js?v=01').then(function(registration) {
    console.log('ServiceWorker registered: ', registration.scope);
}, function(err) {
    console.log('ServiceWorker not registered: ', err);
});