<?php
/**
 * Handle all asset enqueueing
 */
class Afrisol_Assets {
    
    /**
     * Enqueue frontend assets
     */
    public static function enqueue_frontend_assets() {
        // Only load on Afrisol pages or when shortcodes are present
        global $post;
        $load_assets = false;
        
        if (is_page() && $post) {
            if (strpos($post->post_name, 'afrisol') !== false || 
                has_shortcode($post->post_content, 'afrisol_landing_page') ||
                has_shortcode($post->post_content, 'afrisol_products_page') ||
                has_shortcode($post->post_content, 'afrisol_services_page') ||
                has_shortcode($post->post_content, 'afrisol_calculator_page') ||
                has_shortcode($post->post_content, 'afrisol_quote_page') ||
                has_shortcode($post->post_content, 'afrisol_repair_page') ||
                has_shortcode($post->post_content, 'afrisol_about_page') ||
                has_shortcode($post->post_content, 'afrisol_blog_page') ||
                has_shortcode($post->post_content, 'afrisol_contact_page') ||
                has_shortcode($post->post_content, 'afrisol_customer_portal') ||
                has_shortcode($post->post_content, 'afrisol_cart_page') ||
                has_shortcode($post->post_content, 'afrisol_checkout_page') ||
                has_shortcode($post->post_content, 'afrisol_login_page') ||
                has_shortcode($post->post_content, 'afrisol_register_page') ||
                has_shortcode($post->post_content, 'afrisol_admin_frontend') ||
                has_shortcode($post->post_content, 'afrisol_single_product') ||
                has_shortcode($post->post_content, 'afrisol_quote_thank_you')) {
                $load_assets = true;
            }
        }
        
        // Always load on custom post type pages
        if (is_singular('afrisol_product') || is_singular('afrisol_service') || 
            is_post_type_archive('afrisol_product') || is_post_type_archive('afrisol_service')) {
            $load_assets = true;
        }
        
        if (!$load_assets) {
            return;
        }
        
        // Google Fonts
        wp_enqueue_style(
            'afrisol-google-fonts',
            'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Open+Sans:wght@400;500;600;700&display=swap',
            array(),
            AFRISOL_VERSION
        );
        
        // Font Awesome Icons - Using multiple CDN sources for reliability
        wp_enqueue_style(
            'font-awesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
            array(),
            '6.5.1'
        );
        
        // Add fallback Font Awesome from jsDelivr if CDNJS fails
        wp_enqueue_style(
            'font-awesome-fallback',
            'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css',
            array(),
            '6.5.1'
        );
        
        // Main stylesheet
        wp_enqueue_style(
            'afrisol-main',
            AFRISOL_PLUGIN_URL . 'assets/css/afrisol-main.css',
            array('font-awesome'),
            AFRISOL_VERSION
        );
        
        // Components stylesheet
        wp_enqueue_style(
            'afrisol-components',
            AFRISOL_PLUGIN_URL . 'assets/css/afrisol-components.css',
            array('afrisol-main'),
            AFRISOL_VERSION
        );
        
        // Pages stylesheet
        wp_enqueue_style(
            'afrisol-pages',
            AFRISOL_PLUGIN_URL . 'assets/css/afrisol-pages.css',
            array('afrisol-components'),
            AFRISOL_VERSION
        );
        
        // Responsive stylesheet
        wp_enqueue_style(
            'afrisol-responsive',
            AFRISOL_PLUGIN_URL . 'assets/css/afrisol-responsive.css',
            array('afrisol-pages'),
            AFRISOL_VERSION
        );
        
        // Main JavaScript
        wp_enqueue_script(
            'afrisol-main',
            AFRISOL_PLUGIN_URL . 'assets/js/afrisol-main.js',
            array('jquery'),
            AFRISOL_VERSION,
            true
        );
        
        // Components JavaScript
        wp_enqueue_script(
            'afrisol-components',
            AFRISOL_PLUGIN_URL . 'assets/js/afrisol-components.js',
            array('afrisol-main'),
            AFRISOL_VERSION,
            true
        );
        
        // Pages JavaScript
        wp_enqueue_script(
            'afrisol-pages',
            AFRISOL_PLUGIN_URL . 'assets/js/afrisol-pages.js',
            array('afrisol-components'),
            AFRISOL_VERSION,
            true
        );
        
        // Cart JavaScript
        wp_enqueue_script(
            'afrisol-cart',
            AFRISOL_PLUGIN_URL . 'assets/js/afrisol-cart.js',
            array('afrisol-main'),
            AFRISOL_VERSION,
            true
        );
        
        // Get settings
        $settings = get_option('afrisol_settings', array());
        
        // Localize script
        wp_localize_script('afrisol-main', 'afrisol_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'rest_url' => rest_url('afrisol/v1/'),
            'nonce' => wp_create_nonce('afrisol_nonce'),
            'currency_symbol' => isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '₦',
            'is_logged_in' => is_user_logged_in(),
            'user_id' => get_current_user_id(),
            'cart_url' => home_url('/afrisol-cart/'),
            'checkout_url' => home_url('/afrisol-checkout/'),
            'login_url' => home_url('/afrisol-login/'),
            'portal_url' => home_url('/afrisol-portal/'),
            'whatsapp' => isset($settings['whatsapp']) ? $settings['whatsapp'] : '',
            'paystack_public_key' => isset($settings['paystack_public_key']) ? $settings['paystack_public_key'] : '',
            'google_maps_api_key' => isset($settings['google_maps_api_key']) ? $settings['google_maps_api_key'] : '',
            'google_maps_lat' => isset($settings['google_maps_lat']) ? $settings['google_maps_lat'] : '9.0643',
            'google_maps_lng' => isset($settings['google_maps_lng']) ? $settings['google_maps_lng'] : '7.4892',
            'strings' => array(
                'added_to_cart' => __('Added to cart!', 'afrisol'),
                'removed_from_cart' => __('Removed from cart', 'afrisol'),
                'error' => __('An error occurred. Please try again.', 'afrisol'),
                'confirm_remove' => __('Are you sure you want to remove this item?', 'afrisol'),
                'loading' => __('Loading...', 'afrisol'),
            ),
        ));
        
        // PWA manifest
        $pwa_enabled = isset($settings['enable_pwa']) ? $settings['enable_pwa'] : true;
        if ($pwa_enabled) {
            add_action('wp_head', array(__CLASS__, 'add_pwa_meta'));
        }
        
        // Add performance optimizations
        add_action('wp_head', array(__CLASS__, 'add_performance_hints'), 1);
    }
    
    /**
     * Add performance hints for faster loading
     */
    public static function add_performance_hints() {
        // DNS prefetch for external resources
        echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
        echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">' . "\n";
        echo '<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">' . "\n";
        
        // Preconnect for critical resources
        echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>' . "\n";
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        
        // Preload critical fonts
        echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Open+Sans:wght@400;500&display=swap" as="style">' . "\n";
    }
    
    /**
     * Add PWA meta tags
     */
    public static function add_pwa_meta() {
        $settings = get_option('afrisol_settings', array());
        $logo_url = isset($settings['logo']) && !empty($settings['logo']) ? $settings['logo'] : AFRISOL_PLUGIN_URL . 'assets/images/afrisol-logo.webp';
        
        echo '<link rel="manifest" href="' . esc_url(AFRISOL_PLUGIN_URL . 'assets/manifest.json') . '">' . "\n";
        echo '<meta name="theme-color" content="#1a1a2e">' . "\n";
        echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
        echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">' . "\n";
        echo '<meta name="apple-mobile-web-app-title" content="Afrisol">' . "\n";
        echo '<link rel="apple-touch-icon" href="' . esc_url($logo_url) . '">' . "\n";
        echo '<link rel="icon" type="image/webp" href="' . esc_url($logo_url) . '">' . "\n";
        echo '<link rel="shortcut icon" type="image/webp" href="' . esc_url($logo_url) . '">' . "\n";
    }
    
    /**
     * Enqueue admin assets
     */
    public static function enqueue_admin_assets($hook) {
        // Only load on Afrisol admin pages
        if (strpos($hook, 'afrisol') === false && 
            !in_array(get_current_screen()->post_type, array('afrisol_product', 'afrisol_service', 'afrisol_testimonial', 'afrisol_order', 'afrisol_repair', 'afrisol_quote'))) {
            return;
        }
        
        // Admin stylesheet
        wp_enqueue_style(
            'afrisol-admin',
            AFRISOL_PLUGIN_URL . 'assets/css/afrisol-admin.css',
            array(),
            AFRISOL_VERSION
        );
        
        // Admin JavaScript
        wp_enqueue_script(
            'afrisol-admin',
            AFRISOL_PLUGIN_URL . 'assets/js/afrisol-admin.js',
            array('jquery', 'wp-media-utils'),
            AFRISOL_VERSION,
            true
        );
        
        // Localize admin script
        wp_localize_script('afrisol-admin', 'afrisol_admin_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('afrisol_admin_nonce'),
        ));
    }
    
    /**
     * Initialize image optimization hooks
     */
    public static function init_image_optimization() {
        // Optimize images on upload
        add_filter('wp_handle_upload', array(__CLASS__, 'optimize_uploaded_image'));
        
        // Add lazy loading to images
        add_filter('the_content', array(__CLASS__, 'add_lazy_loading'));
        add_filter('post_thumbnail_html', array(__CLASS__, 'add_lazy_loading'));
    }
    
    /**
     * Optimize uploaded images
     */
    public static function optimize_uploaded_image($upload) {
        if (!isset($upload['file']) || !isset($upload['type'])) {
            return $upload;
        }
        
        // Only process images
        if (strpos($upload['type'], 'image/') !== 0) {
            return $upload;
        }
        
        $file = $upload['file'];
        
        // Get image editor
        $editor = wp_get_image_editor($file);
        
        if (is_wp_error($editor)) {
            return $upload;
        }
        
        // Get original size
        $size = $editor->get_size();
        $max_width = 1920;
        $max_height = 1080;
        
        // Resize if larger than max dimensions
        if ($size['width'] > $max_width || $size['height'] > $max_height) {
            $editor->resize($max_width, $max_height, false);
        }
        
        // Set quality for compression
        $editor->set_quality(82);
        
        // Save optimized image
        $saved = $editor->save($file);
        
        if (!is_wp_error($saved)) {
            // Update file size in upload array
            $upload['file'] = $saved['path'];
        }
        
        return $upload;
    }
    
    /**
     * Add lazy loading attribute to images
     */
    public static function add_lazy_loading($content) {
        if (empty($content)) {
            return $content;
        }
        
        // Add loading="lazy" to img tags that don't have it
        $content = preg_replace(
            '/<img((?!loading=)[^>]*)>/i',
            '<img$1 loading="lazy">',
            $content
        );
        
        return $content;
    }
}
