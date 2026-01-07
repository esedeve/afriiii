<?php
/**
 * PWA functionality
 */
class Afrisol_PWA {
    
    /**
     * Initialize PWA
     */
    public static function init() {
        add_action('wp_head', array(__CLASS__, 'add_pwa_meta'), 5);
        add_action('wp_footer', array(__CLASS__, 'add_service_worker_registration'));
        add_action('init', array(__CLASS__, 'serve_manifest'));
        add_action('init', array(__CLASS__, 'serve_service_worker'));
    }
    
    /**
     * Add PWA meta tags
     */
    public static function add_pwa_meta() {
        $settings = get_option('afrisol_settings', array());
        $pwa_enabled = isset($settings['enable_pwa']) ? $settings['enable_pwa'] : true;
        
        if (!$pwa_enabled) {
            return;
        }
        
        ?>
        <link rel="manifest" href="<?php echo esc_url(home_url('/afrisol-manifest.json')); ?>">
        <meta name="theme-color" content="#1a1a2e">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="Afrisol">
        <link rel="apple-touch-icon" href="<?php echo esc_url(AFRISOL_PLUGIN_URL . 'assets/images/logo-192.png'); ?>">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo esc_url(AFRISOL_PLUGIN_URL . 'assets/images/logo-152.png'); ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(AFRISOL_PLUGIN_URL . 'assets/images/logo-180.png'); ?>">
        <link rel="apple-touch-icon" sizes="167x167" href="<?php echo esc_url(AFRISOL_PLUGIN_URL . 'assets/images/logo-167.png'); ?>">
        <?php
    }
    
    /**
     * Register service worker
     */
    public static function add_service_worker_registration() {
        $settings = get_option('afrisol_settings', array());
        $pwa_enabled = isset($settings['enable_pwa']) ? $settings['enable_pwa'] : true;
        
        if (!$pwa_enabled) {
            return;
        }
        
        ?>
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('<?php echo esc_url(home_url('/afrisol-sw.js')); ?>')
                        .then(function(registration) {
                            console.log('Afrisol ServiceWorker registered');
                        })
                        .catch(function(err) {
                            console.log('Afrisol ServiceWorker registration failed: ', err);
                        });
                });
            }
            
            // PWA Install Prompt
            let deferredPrompt;
            const installPrompt = document.getElementById('afrisol-pwa-prompt');
            
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;
                
                // Show install prompt after 3 seconds
                setTimeout(() => {
                    if (installPrompt && !localStorage.getItem('afrisol_pwa_dismissed')) {
                        installPrompt.classList.add('show');
                    }
                }, 3000);
            });
            
            // Install button click
            document.addEventListener('click', function(e) {
                if (e.target.closest('.afrisol-pwa-install')) {
                    if (deferredPrompt) {
                        deferredPrompt.prompt();
                        deferredPrompt.userChoice.then((choiceResult) => {
                            if (choiceResult.outcome === 'accepted') {
                                console.log('User accepted PWA install');
                            }
                            deferredPrompt = null;
                            if (installPrompt) {
                                installPrompt.classList.remove('show');
                            }
                        });
                    }
                }
                
                if (e.target.closest('.afrisol-pwa-dismiss')) {
                    if (installPrompt) {
                        installPrompt.classList.remove('show');
                        localStorage.setItem('afrisol_pwa_dismissed', 'true');
                    }
                }
            });
        </script>
        <?php
    }
    
    /**
     * Serve manifest.json
     */
    public static function serve_manifest() {
        if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'afrisol-manifest.json') !== false) {
            $settings = get_option('afrisol_settings', array());
            
            $manifest = array(
                'name' => isset($settings['company_name']) ? $settings['company_name'] : 'Afrisol',
                'short_name' => 'Afrisol',
                'description' => isset($settings['tagline']) ? $settings['tagline'] : 'Solar Solutions for a Sustainable Africa',
                'start_url' => home_url('/afrisol-home/'),
                'display' => 'standalone',
                'background_color' => '#1a1a2e',
                'theme_color' => '#1a1a2e',
                'orientation' => 'portrait-primary',
                'icons' => array(
                    array(
                        'src' => AFRISOL_PLUGIN_URL . 'assets/images/logo-72.png',
                        'sizes' => '72x72',
                        'type' => 'image/png',
                        'purpose' => 'any maskable',
                    ),
                    array(
                        'src' => AFRISOL_PLUGIN_URL . 'assets/images/logo-96.png',
                        'sizes' => '96x96',
                        'type' => 'image/png',
                        'purpose' => 'any maskable',
                    ),
                    array(
                        'src' => AFRISOL_PLUGIN_URL . 'assets/images/logo-128.png',
                        'sizes' => '128x128',
                        'type' => 'image/png',
                        'purpose' => 'any maskable',
                    ),
                    array(
                        'src' => AFRISOL_PLUGIN_URL . 'assets/images/logo-144.png',
                        'sizes' => '144x144',
                        'type' => 'image/png',
                        'purpose' => 'any maskable',
                    ),
                    array(
                        'src' => AFRISOL_PLUGIN_URL . 'assets/images/logo-152.png',
                        'sizes' => '152x152',
                        'type' => 'image/png',
                        'purpose' => 'any maskable',
                    ),
                    array(
                        'src' => AFRISOL_PLUGIN_URL . 'assets/images/logo-192.png',
                        'sizes' => '192x192',
                        'type' => 'image/png',
                        'purpose' => 'any maskable',
                    ),
                    array(
                        'src' => AFRISOL_PLUGIN_URL . 'assets/images/logo-384.png',
                        'sizes' => '384x384',
                        'type' => 'image/png',
                        'purpose' => 'any maskable',
                    ),
                    array(
                        'src' => AFRISOL_PLUGIN_URL . 'assets/images/logo-512.png',
                        'sizes' => '512x512',
                        'type' => 'image/png',
                        'purpose' => 'any maskable',
                    ),
                ),
                'categories' => array('business', 'shopping', 'utilities'),
                'screenshots' => array(
                    array(
                        'src' => AFRISOL_PLUGIN_URL . 'assets/images/screenshot-wide.png',
                        'sizes' => '1280x720',
                        'type' => 'image/png',
                        'form_factor' => 'wide',
                    ),
                    array(
                        'src' => AFRISOL_PLUGIN_URL . 'assets/images/screenshot-narrow.png',
                        'sizes' => '750x1334',
                        'type' => 'image/png',
                        'form_factor' => 'narrow',
                    ),
                ),
            );
            
            header('Content-Type: application/json');
            echo wp_json_encode($manifest);
            exit;
        }
    }
    
    /**
     * Serve service worker
     */
    public static function serve_service_worker() {
        if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'afrisol-sw.js') !== false) {
            header('Content-Type: application/javascript');
            header('Service-Worker-Allowed: /');
            
            ?>
const CACHE_NAME = 'afrisol-v<?php echo esc_js(AFRISOL_VERSION); ?>';
const STATIC_ASSETS = [
    '<?php echo esc_url(AFRISOL_PLUGIN_URL . 'assets/css/afrisol-main.css'); ?>',
    '<?php echo esc_url(AFRISOL_PLUGIN_URL . 'assets/css/afrisol-components.css'); ?>',
    '<?php echo esc_url(AFRISOL_PLUGIN_URL . 'assets/css/afrisol-pages.css'); ?>',
    '<?php echo esc_url(AFRISOL_PLUGIN_URL . 'assets/js/afrisol-main.js'); ?>',
    '<?php echo esc_url(AFRISOL_PLUGIN_URL . 'assets/js/afrisol-components.js'); ?>',
    '<?php echo esc_url(AFRISOL_PLUGIN_URL . 'assets/images/logo-192.png'); ?>',
    'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Open+Sans:wght@400;500;600;700&display=swap',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'
];

// Install event
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                return cache.addAll(STATIC_ASSETS);
            })
            .then(() => self.skipWaiting())
    );
});

// Activate event
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((name) => name !== CACHE_NAME)
                    .map((name) => caches.delete(name))
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch event
self.addEventListener('fetch', (event) => {
    // Skip non-GET requests
    if (event.request.method !== 'GET') {
        return;
    }
    
    // Skip admin and API requests
    if (event.request.url.includes('/wp-admin/') || 
        event.request.url.includes('/wp-json/') ||
        event.request.url.includes('admin-ajax.php')) {
        return;
    }
    
    event.respondWith(
        caches.match(event.request)
            .then((cachedResponse) => {
                if (cachedResponse) {
                    return cachedResponse;
                }
                
                return fetch(event.request)
                    .then((response) => {
                        // Don't cache non-successful responses
                        if (!response || response.status !== 200 || response.type !== 'basic') {
                            return response;
                        }
                        
                        // Clone the response
                        const responseToCache = response.clone();
                        
                        // Cache images, css, js
                        if (event.request.url.match(/\.(png|jpg|jpeg|gif|webp|svg|css|js)$/)) {
                            caches.open(CACHE_NAME)
                                .then((cache) => {
                                    cache.put(event.request, responseToCache);
                                });
                        }
                        
                        return response;
                    })
                    .catch(() => {
                        // Return offline page for navigation requests
                        if (event.request.mode === 'navigate') {
                            return caches.match('<?php echo esc_url(home_url('/afrisol-home/')); ?>');
                        }
                    });
            })
    );
});
            <?php
            exit;
        }
    }
}
