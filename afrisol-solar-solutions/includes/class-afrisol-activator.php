<?php
/**
 * Fired during plugin activation
 */
class Afrisol_Activator {
    
    /**
     * Activate the plugin
     */
    public static function activate() {
        self::create_pages();
        self::create_tables();
        self::set_default_options();
        self::create_default_content();
        
        // Flush rewrite rules
        flush_rewrite_rules();
    }
    
    /**
     * Create plugin pages
     */
    private static function create_pages() {
        $pages = array(
            'afrisol-home' => array(
                'title' => 'Home',
                'content' => '[afrisol_landing_page]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-products' => array(
                'title' => 'Products',
                'content' => '[afrisol_products_page]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-product' => array(
                'title' => 'Product Details',
                'content' => '[afrisol_single_product]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-services' => array(
                'title' => 'Services',
                'content' => '[afrisol_services_page]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-calculator' => array(
                'title' => 'Solar Calculator',
                'content' => '[afrisol_calculator_page]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-quote' => array(
                'title' => 'Get a Quote',
                'content' => '[afrisol_quote_page]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-quote-thank-you' => array(
                'title' => 'Thank You',
                'content' => '[afrisol_quote_thank_you]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-repair' => array(
                'title' => 'Repair Service',
                'content' => '[afrisol_repair_page]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-about' => array(
                'title' => 'About Us',
                'content' => '[afrisol_about_page]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-blog' => array(
                'title' => 'Blog & Resources',
                'content' => '[afrisol_blog_page]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-contact' => array(
                'title' => 'Contact Us',
                'content' => '[afrisol_contact_page]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-portal' => array(
                'title' => 'Customer Portal',
                'content' => '[afrisol_customer_portal]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-cart' => array(
                'title' => 'Shopping Cart',
                'content' => '[afrisol_cart_page]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-checkout' => array(
                'title' => 'Checkout',
                'content' => '[afrisol_checkout_page]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-login' => array(
                'title' => 'Login',
                'content' => '[afrisol_login_page]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-register' => array(
                'title' => 'Create Account',
                'content' => '[afrisol_register_page]',
                'template' => 'elementor_canvas'
            ),
            'afrisol-admin-frontend' => array(
                'title' => 'Admin Dashboard',
                'content' => '[afrisol_admin_frontend]',
                'template' => 'elementor_canvas'
            ),
        );
        
        foreach ($pages as $slug => $page_data) {
            // Check if page already exists
            $existing_page = get_page_by_path($slug);
            
            if (!$existing_page) {
                $page_id = wp_insert_post(array(
                    'post_title' => $page_data['title'],
                    'post_content' => $page_data['content'],
                    'post_status' => 'publish',
                    'post_type' => 'page',
                    'post_name' => $slug,
                    'comment_status' => 'closed',
                    'ping_status' => 'closed',
                ));
                
                if ($page_id && !is_wp_error($page_id)) {
                    // Set page template for full-width without title
                    update_post_meta($page_id, '_wp_page_template', $page_data['template']);
                    
                    // Elementor specific meta for full width
                    update_post_meta($page_id, '_elementor_template_type', 'wp-page');
                    update_post_meta($page_id, '_elementor_edit_mode', 'builder');
                    
                    // Hide title
                    update_post_meta($page_id, '_afrisol_hide_title', 'yes');
                }
            }
        }
        
        // Store page IDs in options
        $page_ids = array();
        foreach (array_keys($pages) as $slug) {
            $page = get_page_by_path($slug);
            if ($page) {
                $page_ids[$slug] = $page->ID;
            }
        }
        update_option('afrisol_page_ids', $page_ids);
    }
    
    /**
     * Create custom database tables
     */
    private static function create_tables() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Cart table
        $cart_table = $wpdb->prefix . 'afrisol_cart';
        $sql_cart = "CREATE TABLE IF NOT EXISTS $cart_table (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) DEFAULT NULL,
            session_id varchar(100) DEFAULT NULL,
            product_id bigint(20) NOT NULL,
            quantity int(11) NOT NULL DEFAULT 1,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY user_id (user_id),
            KEY session_id (session_id)
        ) $charset_collate;";
        
        // Wishlist table
        $wishlist_table = $wpdb->prefix . 'afrisol_wishlist';
        $sql_wishlist = "CREATE TABLE IF NOT EXISTS $wishlist_table (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            product_id bigint(20) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY user_id (user_id),
            UNIQUE KEY user_product (user_id, product_id)
        ) $charset_collate;";
        
        // Reviews table
        $reviews_table = $wpdb->prefix . 'afrisol_reviews';
        $sql_reviews = "CREATE TABLE IF NOT EXISTS $reviews_table (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            product_id bigint(20) NOT NULL,
            user_id bigint(20) NOT NULL,
            rating int(1) NOT NULL,
            review text,
            status varchar(20) DEFAULT 'pending',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY product_id (product_id),
            KEY user_id (user_id)
        ) $charset_collate;";
        
        // Loyalty points table
        $points_table = $wpdb->prefix . 'afrisol_loyalty_points';
        $sql_points = "CREATE TABLE IF NOT EXISTS $points_table (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            points int(11) NOT NULL,
            type varchar(50) NOT NULL,
            description varchar(255),
            order_id bigint(20) DEFAULT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY user_id (user_id)
        ) $charset_collate;";
        
        // Referrals table
        $referrals_table = $wpdb->prefix . 'afrisol_referrals';
        $sql_referrals = "CREATE TABLE IF NOT EXISTS $referrals_table (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            referrer_id bigint(20) NOT NULL,
            referred_id bigint(20) NOT NULL,
            status varchar(20) DEFAULT 'pending',
            reward_given tinyint(1) DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY referrer_id (referrer_id)
        ) $charset_collate;";
        
        // Warranties table
        $warranties_table = $wpdb->prefix . 'afrisol_warranties';
        $sql_warranties = "CREATE TABLE IF NOT EXISTS $warranties_table (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            order_id bigint(20) NOT NULL,
            product_id bigint(20) NOT NULL,
            serial_number varchar(100),
            purchase_date date,
            expiry_date date,
            status varchar(20) DEFAULT 'active',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY user_id (user_id)
        ) $charset_collate;";
        
        // Contact submissions table
        $contact_table = $wpdb->prefix . 'afrisol_contacts';
        $sql_contact = "CREATE TABLE IF NOT EXISTS $contact_table (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            name varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            phone varchar(30),
            subject varchar(255),
            message text,
            type varchar(50) DEFAULT 'contact',
            status varchar(20) DEFAULT 'new',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_cart);
        dbDelta($sql_wishlist);
        dbDelta($sql_reviews);
        dbDelta($sql_points);
        dbDelta($sql_referrals);
        dbDelta($sql_warranties);
        dbDelta($sql_contact);
    }
    
    /**
     * Set default plugin options
     */
    private static function set_default_options() {
        $default_settings = array(
            'company_name' => 'Afrisol',
            'tagline' => 'Solar Solutions for a Sustainable Africa',
            'address' => 'Suite 15C, Al-Noor Shopping Complex, Al-Noor Mosque, Ahmadu Bello Way Wuse 2, Abuja.',
            'phone' => '+234 803 221 2827',
            'email' => 'info@afrisol.com',
            'whatsapp' => '+2348032212827',
            'facebook' => 'https://facebook.com/afrisol',
            'instagram' => 'https://instagram.com/afrisol',
            'tiktok' => 'https://tiktok.com/@afrisol',
            'google_maps_api_key' => '',
            'google_maps_lat' => '9.0643',
            'google_maps_lng' => '7.4892',
            'paystack_public_key' => '',
            'paystack_secret_key' => '',
            'currency' => 'NGN',
            'currency_symbol' => '₦',
            'primary_color' => '#FF6B35',
            'secondary_color' => '#1a1a2e',
            'business_hours' => 'Mon - Fri: 8:00 AM - 6:00 PM\nSat: 9:00 AM - 4:00 PM\nSun: Closed',
            'hero_heading' => 'Solar Solutions for a Sustainable Africa',
            'hero_subheading' => 'Empowering homes and businesses with clean, affordable solar energy. Quality installations, expert maintenance, and innovative solar mobility solutions.',
            'hero_image' => '',
            'about_content' => '',
            'enable_pwa' => true,
            'loyalty_points_per_naira' => 1, // 1 point per 1000 Naira spent
            'referral_bonus_points' => 500,
        );
        
        if (!get_option('afrisol_settings')) {
            update_option('afrisol_settings', $default_settings);
        }
        
        // Set plugin version
        update_option('afrisol_version', AFRISOL_VERSION);
    }
    
    /**
     * Create default content
     */
    private static function create_default_content() {
        // Create default product categories
        $categories = array(
            'solar-panels' => array('name' => 'Solar Panels', 'description' => 'High-efficiency solar panels for residential and commercial use'),
            'inverters' => array('name' => 'Inverters', 'description' => 'Pure sine wave and hybrid inverters'),
            'batteries' => array('name' => 'Batteries', 'description' => 'Lithium and tubular batteries for solar storage'),
            'solar-accessories' => array('name' => 'Solar Accessories', 'description' => 'Charge controllers, mounting systems, and cables'),
            'security-systems' => array('name' => 'Security Systems', 'description' => 'CCTV cameras, AI cameras, and access control'),
            'solar-mobility' => array('name' => 'Solar Mobility', 'description' => 'Electric scooters, bikes, tricycles, and vehicles'),
        );
        
        foreach ($categories as $slug => $cat) {
            if (!term_exists($slug, 'afrisol_product_cat')) {
                wp_insert_term($cat['name'], 'afrisol_product_cat', array(
                    'slug' => $slug,
                    'description' => $cat['description']
                ));
            }
        }
        
        // Create sample products if none exist
        $existing_products = get_posts(array(
            'post_type' => 'afrisol_product',
            'posts_per_page' => 1
        ));
        
        if (empty($existing_products)) {
            $sample_products = array(
                array(
                    'title' => '450W Monocrystalline Solar Panel',
                    'content' => 'High-efficiency monocrystalline solar panel with excellent performance in all weather conditions. Features anti-reflective coating and robust aluminum frame.',
                    'price' => 185000,
                    'category' => 'solar-panels',
                    'brand' => 'SunPower',
                    'power' => '450W',
                    'warranty' => '25 years',
                ),
                array(
                    'title' => '5KVA Hybrid Inverter',
                    'content' => 'Advanced hybrid inverter with built-in MPPT charge controller. Supports both grid-tied and off-grid operation.',
                    'price' => 420000,
                    'category' => 'inverters',
                    'brand' => 'Growatt',
                    'power' => '5KVA',
                    'warranty' => '5 years',
                ),
                array(
                    'title' => '200Ah Lithium Battery',
                    'content' => 'Deep cycle lithium iron phosphate battery with 6000+ cycle life. Built-in BMS for safety and longevity.',
                    'price' => 650000,
                    'category' => 'batteries',
                    'brand' => 'Felicity',
                    'power' => '200Ah/48V',
                    'warranty' => '10 years',
                ),
                array(
                    'title' => 'Solar Electric Scooter',
                    'content' => 'Eco-friendly electric scooter with solar charging capability. Perfect for urban commuting with 80km range.',
                    'price' => 890000,
                    'category' => 'solar-mobility',
                    'brand' => 'Afrisol',
                    'power' => '2000W',
                    'warranty' => '2 years',
                ),
                array(
                    'title' => '4-Channel AI CCTV System',
                    'content' => 'Smart surveillance system with AI-powered motion detection, facial recognition, and mobile app access.',
                    'price' => 350000,
                    'category' => 'security-systems',
                    'brand' => 'Hikvision',
                    'power' => 'N/A',
                    'warranty' => '3 years',
                ),
                array(
                    'title' => '60A MPPT Charge Controller',
                    'content' => 'High-efficiency MPPT charge controller with LCD display. Supports 12V/24V/48V battery systems.',
                    'price' => 95000,
                    'category' => 'solar-accessories',
                    'brand' => 'Must',
                    'power' => '60A',
                    'warranty' => '2 years',
                ),
            );
            
            foreach ($sample_products as $product) {
                $post_id = wp_insert_post(array(
                    'post_title' => $product['title'],
                    'post_content' => $product['content'],
                    'post_status' => 'publish',
                    'post_type' => 'afrisol_product',
                ));
                
                if ($post_id && !is_wp_error($post_id)) {
                    update_post_meta($post_id, '_afrisol_price', $product['price']);
                    update_post_meta($post_id, '_afrisol_brand', $product['brand']);
                    update_post_meta($post_id, '_afrisol_power', $product['power']);
                    update_post_meta($post_id, '_afrisol_warranty', $product['warranty']);
                    update_post_meta($post_id, '_afrisol_stock_status', 'in_stock');
                    update_post_meta($post_id, '_afrisol_featured', 'yes');
                    
                    // Set category
                    $term = get_term_by('slug', $product['category'], 'afrisol_product_cat');
                    if ($term) {
                        wp_set_object_terms($post_id, $term->term_id, 'afrisol_product_cat');
                    }
                }
            }
        }
        
        // Create sample testimonials
        $existing_testimonials = get_posts(array(
            'post_type' => 'afrisol_testimonial',
            'posts_per_page' => 1
        ));
        
        if (empty($existing_testimonials)) {
            $testimonials = array(
                array(
                    'author' => 'Adaeze Okonkwo',
                    'location' => 'Abuja, Nigeria',
                    'rating' => 5,
                    'content' => 'Afrisol transformed our home with their solar installation. We now enjoy 24/7 power and have significantly reduced our electricity bills. The team was professional and completed the work on time.',
                ),
                array(
                    'author' => 'Ibrahim Musa',
                    'location' => 'Lagos, Nigeria',
                    'rating' => 5,
                    'content' => 'Professional service from start to finish. Their team was knowledgeable and completed the installation ahead of schedule. Highly recommend Afrisol for anyone looking to go solar.',
                ),
                array(
                    'author' => 'Chioma Eze',
                    'location' => 'Port Harcourt, Nigeria',
                    'rating' => 4,
                    'content' => 'Great products and excellent customer support. The solar calculator helped me choose the perfect system for my business. Very satisfied with my purchase.',
                ),
            );
            
            foreach ($testimonials as $testimonial) {
                $post_id = wp_insert_post(array(
                    'post_title' => $testimonial['author'],
                    'post_content' => $testimonial['content'],
                    'post_status' => 'publish',
                    'post_type' => 'afrisol_testimonial',
                ));
                
                if ($post_id && !is_wp_error($post_id)) {
                    update_post_meta($post_id, '_afrisol_location', $testimonial['location']);
                    update_post_meta($post_id, '_afrisol_rating', $testimonial['rating']);
                }
            }
        }
    }
}
