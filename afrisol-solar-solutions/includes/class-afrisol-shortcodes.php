<?php
/**
 * Register all shortcodes
 */
class Afrisol_Shortcodes {
    
    /**
     * Initialize shortcodes
     */
    public static function init() {
        // Page shortcodes
        add_shortcode('afrisol_landing_page', array(__CLASS__, 'landing_page'));
        add_shortcode('afrisol_products_page', array(__CLASS__, 'products_page'));
        add_shortcode('afrisol_single_product', array(__CLASS__, 'single_product'));
        add_shortcode('afrisol_services_page', array(__CLASS__, 'services_page'));
        add_shortcode('afrisol_calculator_page', array(__CLASS__, 'calculator_page'));
        add_shortcode('afrisol_quote_page', array(__CLASS__, 'quote_page'));
        add_shortcode('afrisol_quote_thank_you', array(__CLASS__, 'quote_thank_you'));
        add_shortcode('afrisol_repair_page', array(__CLASS__, 'repair_page'));
        add_shortcode('afrisol_about_page', array(__CLASS__, 'about_page'));
        add_shortcode('afrisol_blog_page', array(__CLASS__, 'blog_page'));
        add_shortcode('afrisol_contact_page', array(__CLASS__, 'contact_page'));
        add_shortcode('afrisol_customer_portal', array(__CLASS__, 'customer_portal'));
        add_shortcode('afrisol_cart_page', array(__CLASS__, 'cart_page'));
        add_shortcode('afrisol_checkout_page', array(__CLASS__, 'checkout_page'));
        add_shortcode('afrisol_login_page', array(__CLASS__, 'login_page'));
        add_shortcode('afrisol_register_page', array(__CLASS__, 'register_page'));
        add_shortcode('afrisol_admin_frontend', array(__CLASS__, 'admin_frontend'));
        
        // Component shortcodes
        add_shortcode('afrisol_header', array(__CLASS__, 'header'));
        add_shortcode('afrisol_footer', array(__CLASS__, 'footer'));
        add_shortcode('afrisol_hero', array(__CLASS__, 'hero_section'));
        add_shortcode('afrisol_services', array(__CLASS__, 'services_section'));
        add_shortcode('afrisol_why_choose', array(__CLASS__, 'why_choose_section'));
        add_shortcode('afrisol_featured_products', array(__CLASS__, 'featured_products'));
        add_shortcode('afrisol_testimonials', array(__CLASS__, 'testimonials_section'));
        add_shortcode('afrisol_map', array(__CLASS__, 'map_section'));
        add_shortcode('afrisol_contact_form', array(__CLASS__, 'contact_form_section'));
        add_shortcode('afrisol_whatsapp', array(__CLASS__, 'whatsapp_widget'));
        add_shortcode('afrisol_scroll_top', array(__CLASS__, 'scroll_to_top'));
        add_shortcode('afrisol_pwa_prompt', array(__CLASS__, 'pwa_prompt'));
    }
    
    /**
     * Get template content
     */
    private static function get_template($template_name, $args = array()) {
        extract($args);
        ob_start();
        include AFRISOL_PLUGIN_DIR . 'templates/' . $template_name . '.php';
        return ob_get_clean();
    }
    
    /**
     * Landing page shortcode
     */
    public static function landing_page($atts) {
        $settings = get_option('afrisol_settings', array());
        return self::get_template('landing-page', array('settings' => $settings));
    }
    
    /**
     * Products page shortcode
     */
    public static function products_page($atts) {
        $atts = shortcode_atts(array(
            'category' => '',
            'per_page' => 12,
        ), $atts);
        
        return self::get_template('products-page', array('atts' => $atts));
    }
    
    /**
     * Single product shortcode
     */
    public static function single_product($atts) {
        $atts = shortcode_atts(array(
            'id' => 0,
        ), $atts);
        
        return self::get_template('single-product', array('atts' => $atts));
    }
    
    /**
     * Services page shortcode
     */
    public static function services_page($atts) {
        return self::get_template('services-page');
    }
    
    /**
     * Calculator page shortcode
     */
    public static function calculator_page($atts) {
        return self::get_template('calculator-page');
    }
    
    /**
     * Quote page shortcode
     */
    public static function quote_page($atts) {
        return self::get_template('quote-page');
    }
    
    /**
     * Quote thank you page shortcode
     */
    public static function quote_thank_you($atts) {
        return self::get_template('quote-thank-you');
    }
    
    /**
     * Repair page shortcode
     */
    public static function repair_page($atts) {
        return self::get_template('repair-page');
    }
    
    /**
     * About page shortcode
     */
    public static function about_page($atts) {
        return self::get_template('about-page');
    }
    
    /**
     * Blog page shortcode
     */
    public static function blog_page($atts) {
        $atts = shortcode_atts(array(
            'per_page' => 9,
        ), $atts);
        
        return self::get_template('blog-page', array('atts' => $atts));
    }
    
    /**
     * Contact page shortcode
     */
    public static function contact_page($atts) {
        return self::get_template('contact-page');
    }
    
    /**
     * Customer portal shortcode
     */
    public static function customer_portal($atts) {
        if (!is_user_logged_in()) {
            wp_redirect(home_url('/afrisol-login/'));
            exit;
        }
        return self::get_template('customer-portal');
    }
    
    /**
     * Cart page shortcode
     */
    public static function cart_page($atts) {
        return self::get_template('cart-page');
    }
    
    /**
     * Checkout page shortcode
     */
    public static function checkout_page($atts) {
        return self::get_template('checkout-page');
    }
    
    /**
     * Login page shortcode
     */
    public static function login_page($atts) {
        if (is_user_logged_in()) {
            wp_redirect(home_url('/afrisol-portal/'));
            exit;
        }
        return self::get_template('login-page');
    }
    
    /**
     * Register page shortcode
     */
    public static function register_page($atts) {
        if (is_user_logged_in()) {
            wp_redirect(home_url('/afrisol-portal/'));
            exit;
        }
        return self::get_template('register-page');
    }
    
    /**
     * Admin frontend shortcode
     */
    public static function admin_frontend($atts) {
        if (!current_user_can('manage_options')) {
            return '<div class="afrisol-error">You do not have permission to access this page.</div>';
        }
        return self::get_template('admin-frontend');
    }
    
    /**
     * Header shortcode
     */
    public static function header($atts) {
        $settings = get_option('afrisol_settings', array());
        return self::get_template('components/header', array('settings' => $settings));
    }
    
    /**
     * Footer shortcode
     */
    public static function footer($atts) {
        $settings = get_option('afrisol_settings', array());
        return self::get_template('components/footer', array('settings' => $settings));
    }
    
    /**
     * Hero section shortcode
     */
    public static function hero_section($atts) {
        $settings = get_option('afrisol_settings', array());
        return self::get_template('components/hero', array('settings' => $settings));
    }
    
    /**
     * Services section shortcode
     */
    public static function services_section($atts) {
        return self::get_template('components/services');
    }
    
    /**
     * Why choose section shortcode
     */
    public static function why_choose_section($atts) {
        $settings = get_option('afrisol_settings', array());
        return self::get_template('components/why-choose', array('settings' => $settings));
    }
    
    /**
     * Featured products shortcode
     */
    public static function featured_products($atts) {
        $atts = shortcode_atts(array(
            'count' => 4,
        ), $atts);
        
        return self::get_template('components/featured-products', array('atts' => $atts));
    }
    
    /**
     * Testimonials section shortcode
     */
    public static function testimonials_section($atts) {
        return self::get_template('components/testimonials');
    }
    
    /**
     * Map section shortcode
     */
    public static function map_section($atts) {
        $settings = get_option('afrisol_settings', array());
        return self::get_template('components/map', array('settings' => $settings));
    }
    
    /**
     * Contact form section shortcode
     */
    public static function contact_form_section($atts) {
        return self::get_template('components/contact-form');
    }
    
    /**
     * WhatsApp widget shortcode
     */
    public static function whatsapp_widget($atts) {
        $settings = get_option('afrisol_settings', array());
        $whatsapp = isset($settings['whatsapp']) ? $settings['whatsapp'] : '';
        
        if (empty($whatsapp)) {
            return '';
        }
        
        return '<a href="https://wa.me/' . esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)) . '" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="afrisol-whatsapp-widget" 
                   aria-label="Chat on WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>';
    }
    
    /**
     * Scroll to top shortcode
     */
    public static function scroll_to_top($atts) {
        return '<div class="afrisol-scroll-top" id="afrisol-scroll-top">
                    <svg class="afrisol-scroll-progress" viewBox="0 0 100 100">
                        <circle class="afrisol-scroll-progress-bg" cx="50" cy="50" r="46"></circle>
                        <circle class="afrisol-scroll-progress-bar" cx="50" cy="50" r="46"></circle>
                    </svg>
                    <i class="fas fa-arrow-up"></i>
                </div>';
    }
    
    /**
     * PWA install prompt shortcode
     */
    public static function pwa_prompt($atts) {
        return self::get_template('components/pwa-prompt');
    }
}
