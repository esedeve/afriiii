<?php
/**
 * Plugin Name: Afrisol Solar Solutions
 * Plugin URI: https://afrisol.com
 * Description: A comprehensive WordPress plugin for Afrisol - Solar Solutions for a Sustainable Africa. Features include landing page, products, services, solar calculator, customer portal, and more.
 * Version: 1.0.0
 * Author: Afrisol
 * Author URI: https://afrisol.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: afrisol
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('AFRISOL_VERSION', '1.0.0');
define('AFRISOL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('AFRISOL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('AFRISOL_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main Afrisol Plugin Class
 */
class Afrisol_Solar_Solutions {
    
    /**
     * Single instance of the class
     */
    private static $instance = null;
    
    /**
     * Get single instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }
    
    /**
     * Load required files
     */
    private function load_dependencies() {
        // Core includes
        require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-activator.php';
        require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-deactivator.php';
        require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-shortcodes.php';
        require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-assets.php';
        require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-ajax.php';
        require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-cart.php';
        require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-user.php';
        require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-products.php';
        require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-calculator.php';
        require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-forms.php';
        require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-pwa.php';
        
        // Admin includes
        if (is_admin()) {
            require_once AFRISOL_PLUGIN_DIR . 'admin/class-afrisol-admin.php';
        }
    }
    
    /**
     * Initialize hooks
     */
    private function init_hooks() {
        // Activation/Deactivation hooks
        register_activation_hook(__FILE__, array('Afrisol_Activator', 'activate'));
        register_deactivation_hook(__FILE__, array('Afrisol_Deactivator', 'deactivate'));
        
        // Initialize components
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array('Afrisol_Assets', 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array('Afrisol_Assets', 'enqueue_admin_assets'));
        
        // Initialize shortcodes
        Afrisol_Shortcodes::init();
        
        // Initialize AJAX handlers
        Afrisol_Ajax::init();
        
        // Initialize Cart
        Afrisol_Cart::init();
        
        // Initialize User functionality
        Afrisol_User::init();
        
        // Initialize PWA
        Afrisol_PWA::init();
        
        // Initialize image optimization
        Afrisol_Assets::init_image_optimization();
        
        // Add theme support
        add_action('after_setup_theme', array($this, 'add_theme_support'));
        
        // Register custom post types
        add_action('init', array($this, 'register_post_types'));
        
        // Add body class for Afrisol pages
        add_filter('body_class', array($this, 'add_body_classes'));
        
        // Register REST API endpoints
        add_action('rest_api_init', array($this, 'register_rest_routes'));
    }
    
    /**
     * Plugin initialization
     */
    public function init() {
        // Load text domain
        load_plugin_textdomain('afrisol', false, dirname(AFRISOL_PLUGIN_BASENAME) . '/languages');
        
        // Start session if not started (for cart)
        if (!session_id() && !headers_sent()) {
            session_start();
        }
    }
    
    /**
     * Add theme support
     */
    public function add_theme_support() {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    }
    
    /**
     * Register custom post types
     */
    public function register_post_types() {
        // Products Post Type
        register_post_type('afrisol_product', array(
            'labels' => array(
                'name' => __('Products', 'afrisol'),
                'singular_name' => __('Product', 'afrisol'),
                'add_new' => __('Add New Product', 'afrisol'),
                'add_new_item' => __('Add New Product', 'afrisol'),
                'edit_item' => __('Edit Product', 'afrisol'),
                'new_item' => __('New Product', 'afrisol'),
                'view_item' => __('View Product', 'afrisol'),
                'search_items' => __('Search Products', 'afrisol'),
                'not_found' => __('No products found', 'afrisol'),
                'not_found_in_trash' => __('No products found in trash', 'afrisol'),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'afrisol-products'),
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'menu_icon' => 'dashicons-cart',
            'show_in_rest' => true,
        ));
        
        // Product Categories Taxonomy
        register_taxonomy('afrisol_product_cat', 'afrisol_product', array(
            'labels' => array(
                'name' => __('Product Categories', 'afrisol'),
                'singular_name' => __('Product Category', 'afrisol'),
            ),
            'hierarchical' => true,
            'rewrite' => array('slug' => 'product-category'),
            'show_in_rest' => true,
        ));
        
        // Services Post Type
        register_post_type('afrisol_service', array(
            'labels' => array(
                'name' => __('Services', 'afrisol'),
                'singular_name' => __('Service', 'afrisol'),
                'add_new' => __('Add New Service', 'afrisol'),
                'add_new_item' => __('Add New Service', 'afrisol'),
                'edit_item' => __('Edit Service', 'afrisol'),
                'new_item' => __('New Service', 'afrisol'),
                'view_item' => __('View Service', 'afrisol'),
                'search_items' => __('Search Services', 'afrisol'),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'afrisol-services'),
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'menu_icon' => 'dashicons-hammer',
            'show_in_rest' => true,
        ));
        
        // Testimonials Post Type
        register_post_type('afrisol_testimonial', array(
            'labels' => array(
                'name' => __('Testimonials', 'afrisol'),
                'singular_name' => __('Testimonial', 'afrisol'),
            ),
            'public' => true,
            'has_archive' => false,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'menu_icon' => 'dashicons-format-quote',
            'show_in_rest' => true,
        ));
        
        // Blog Posts Category
        register_taxonomy('afrisol_blog_cat', 'post', array(
            'labels' => array(
                'name' => __('Afrisol Categories', 'afrisol'),
                'singular_name' => __('Afrisol Category', 'afrisol'),
            ),
            'hierarchical' => true,
            'rewrite' => array('slug' => 'afrisol-blog-category'),
            'show_in_rest' => true,
        ));
        
        // Orders Post Type
        register_post_type('afrisol_order', array(
            'labels' => array(
                'name' => __('Orders', 'afrisol'),
                'singular_name' => __('Order', 'afrisol'),
            ),
            'public' => false,
            'show_ui' => true,
            'supports' => array('title', 'custom-fields'),
            'menu_icon' => 'dashicons-clipboard',
            'show_in_rest' => true,
            'capability_type' => 'post',
            'capabilities' => array(
                'create_posts' => 'do_not_allow',
            ),
            'map_meta_cap' => true,
        ));
        
        // Repair Tickets Post Type
        register_post_type('afrisol_repair', array(
            'labels' => array(
                'name' => __('Repair Tickets', 'afrisol'),
                'singular_name' => __('Repair Ticket', 'afrisol'),
            ),
            'public' => false,
            'show_ui' => true,
            'supports' => array('title', 'editor', 'custom-fields'),
            'menu_icon' => 'dashicons-admin-tools',
            'show_in_rest' => true,
        ));
        
        // Quote Requests Post Type
        register_post_type('afrisol_quote', array(
            'labels' => array(
                'name' => __('Quote Requests', 'afrisol'),
                'singular_name' => __('Quote Request', 'afrisol'),
            ),
            'public' => false,
            'show_ui' => true,
            'supports' => array('title', 'editor', 'custom-fields'),
            'menu_icon' => 'dashicons-media-document',
            'show_in_rest' => true,
        ));
    }
    
    /**
     * Add body classes for Afrisol pages
     */
    public function add_body_classes($classes) {
        global $post;
        
        if (is_page() && $post) {
            $afrisol_pages = array(
                'afrisol-home',
                'afrisol-products',
                'afrisol-services',
                'afrisol-calculator',
                'afrisol-quote',
                'afrisol-repair',
                'afrisol-about',
                'afrisol-blog',
                'afrisol-contact',
                'afrisol-portal',
                'afrisol-cart',
                'afrisol-checkout',
                'afrisol-login',
                'afrisol-register'
            );
            
            if (in_array($post->post_name, $afrisol_pages)) {
                $classes[] = 'afrisol-page';
                $classes[] = 'afrisol-' . $post->post_name;
            }
        }
        
        return $classes;
    }
    
    /**
     * Register REST API routes
     */
    public function register_rest_routes() {
        register_rest_route('afrisol/v1', '/settings', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_settings'),
            'permission_callback' => '__return_true',
        ));
        
        register_rest_route('afrisol/v1', '/settings', array(
            'methods' => 'POST',
            'callback' => array($this, 'update_settings'),
            'permission_callback' => function() {
                return current_user_can('manage_options');
            },
        ));
    }
    
    /**
     * Get plugin settings
     */
    public function get_settings($request) {
        $settings = get_option('afrisol_settings', array());
        return rest_ensure_response($settings);
    }
    
    /**
     * Update plugin settings
     */
    public function update_settings($request) {
        $settings = $request->get_json_params();
        update_option('afrisol_settings', $settings);
        return rest_ensure_response(array('success' => true));
    }
}

// Initialize the plugin
function afrisol_init() {
    return Afrisol_Solar_Solutions::get_instance();
}

// Start the plugin
afrisol_init();
