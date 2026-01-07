/**
 * Afrisol Service Worker
 */

const CACHE_NAME = 'afrisol-v1';
const STATIC_ASSETS = [
    '/afrisol-home/',
    '/wp-content/plugins/afrisol-solar-solutions/assets/css/afrisol-main.css',
    '/wp-content/plugins/afrisol-solar-solutions/assets/css/afrisol-components.css',
    '/wp-content/plugins/afrisol-solar-solutions/assets/css/afrisol-pages.css',
    '/wp-content/plugins/afrisol-solar-solutions/assets/css/afrisol-responsive.css',
    '/wp-content/plugins/afrisol-solar-solutions/assets/js/afrisol-main.js',
    '/wp-content/plugins/afrisol-solar-solutions/assets/js/afrisol-components.js',
    '/wp-content/plugins/afrisol-solar-solutions/assets/js/afrisol-cart.js',
    'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Open+Sans:wght@400;500;600;700&display=swap',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'
];

// Install event
self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function(cache) {
            console.log('Afrisol: Caching static assets');
            return cache.addAll(STATIC_ASSETS);
        }).catch(function(error) {
            console.log('Afrisol: Cache failed', error);
        })
    );
    self.skipWaiting();
});

// Activate event
self.addEventListener('activate', function(event) {
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.filter(function(cacheName) {
                    return cacheName !== CACHE_NAME;
                }).map(function(cacheName) {
                    console.log('Afrisol: Deleting old cache', cacheName);
                    return caches.delete(cacheName);
                })
            );
        })
    );
    self.clients.claim();
});

// Fetch event
self.addEventListener('fetch', function(event) {
    // Skip non-GET requests
    if (event.request.method !== 'GET') {
        return;
    }
    
    // Skip admin requests
    if (event.request.url.includes('/wp-admin/') || event.request.url.includes('/wp-login.php')) {
        return;
    }
    
    event.respondWith(
        caches.match(event.request).then(function(cachedResponse) {
            // Return cached response if available
            if (cachedResponse) {
                // Fetch and update cache in background
                fetch(event.request).then(function(response) {
                    if (response && response.status === 200) {
                        caches.open(CACHE_NAME).then(function(cache) {
                            cache.put(event.request, response.clone());
                        });
                    }
                }).catch(function() {});
                
                return cachedResponse;
            }
            
            // Fetch from network
            return fetch(event.request).then(function(response) {
                // Don't cache if not valid response
                if (!response || response.status !== 200 || response.type !== 'basic') {
                    return response;
                }
                
                // Clone response for caching
                var responseToCache = response.clone();
                
                caches.open(CACHE_NAME).then(function(cache) {
                    cache.put(event.request, responseToCache);
                });
                
                return response;
            }).catch(function() {
                // Return offline page if available
                if (event.request.mode === 'navigate') {
                    return caches.match('/afrisol-home/');
                }
            });
        })
    );
});

// Push notification event
self.addEventListener('push', function(event) {
    if (!event.data) return;
    
    var data = event.data.json();
    
    var options = {
        body: data.body || 'You have a new notification',
        icon: '/wp-content/plugins/afrisol-solar-solutions/assets/images/logo-192.png',
        badge: '/wp-content/plugins/afrisol-solar-solutions/assets/images/logo-72.png',
        vibrate: [100, 50, 100],
        data: {
            url: data.url || '/afrisol-home/'
        }
    };
    
    event.waitUntil(
        self.registration.showNotification(data.title || 'Afrisol', options)
    );
});

// Notification click event
self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    
    event.waitUntil(
        clients.openWindow(event.notification.data.url)
    );
});
