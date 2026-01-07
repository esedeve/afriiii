<?php
/**
 * Handle AJAX requests
 */
class Afrisol_Ajax {
    
    /**
     * Initialize AJAX handlers
     */
    public static function init() {
        // Cart actions
        add_action('wp_ajax_afrisol_add_to_cart', array(__CLASS__, 'add_to_cart'));
        add_action('wp_ajax_nopriv_afrisol_add_to_cart', array(__CLASS__, 'add_to_cart'));
        
        add_action('wp_ajax_afrisol_update_cart', array(__CLASS__, 'update_cart'));
        add_action('wp_ajax_nopriv_afrisol_update_cart', array(__CLASS__, 'update_cart'));
        
        add_action('wp_ajax_afrisol_remove_from_cart', array(__CLASS__, 'remove_from_cart'));
        add_action('wp_ajax_nopriv_afrisol_remove_from_cart', array(__CLASS__, 'remove_from_cart'));
        
        add_action('wp_ajax_afrisol_get_cart', array(__CLASS__, 'get_cart'));
        add_action('wp_ajax_nopriv_afrisol_get_cart', array(__CLASS__, 'get_cart'));
        
        add_action('wp_ajax_afrisol_apply_coupon', array(__CLASS__, 'apply_coupon'));
        add_action('wp_ajax_nopriv_afrisol_apply_coupon', array(__CLASS__, 'apply_coupon'));
        
        // Wishlist actions
        add_action('wp_ajax_afrisol_toggle_wishlist', array(__CLASS__, 'toggle_wishlist'));
        add_action('wp_ajax_afrisol_get_wishlist', array(__CLASS__, 'get_wishlist'));
        
        // Product actions
        add_action('wp_ajax_afrisol_get_products', array(__CLASS__, 'get_products'));
        add_action('wp_ajax_nopriv_afrisol_get_products', array(__CLASS__, 'get_products'));
        
        add_action('wp_ajax_afrisol_quick_view', array(__CLASS__, 'quick_view'));
        add_action('wp_ajax_nopriv_afrisol_quick_view', array(__CLASS__, 'quick_view'));
        
        add_action('wp_ajax_afrisol_compare_products', array(__CLASS__, 'compare_products'));
        add_action('wp_ajax_nopriv_afrisol_compare_products', array(__CLASS__, 'compare_products'));
        
        add_action('wp_ajax_afrisol_notify_stock', array(__CLASS__, 'notify_stock'));
        add_action('wp_ajax_nopriv_afrisol_notify_stock', array(__CLASS__, 'notify_stock'));
        
        // Review actions
        add_action('wp_ajax_afrisol_submit_review', array(__CLASS__, 'submit_review'));
        add_action('wp_ajax_afrisol_get_reviews', array(__CLASS__, 'get_reviews'));
        add_action('wp_ajax_nopriv_afrisol_get_reviews', array(__CLASS__, 'get_reviews'));
        
        // Q&A actions
        add_action('wp_ajax_afrisol_submit_question', array(__CLASS__, 'submit_question'));
        add_action('wp_ajax_nopriv_afrisol_submit_question', array(__CLASS__, 'submit_question'));
        
        // Form submissions
        add_action('wp_ajax_afrisol_submit_contact', array(__CLASS__, 'submit_contact'));
        add_action('wp_ajax_nopriv_afrisol_submit_contact', array(__CLASS__, 'submit_contact'));
        
        add_action('wp_ajax_afrisol_submit_quote', array(__CLASS__, 'submit_quote'));
        add_action('wp_ajax_nopriv_afrisol_submit_quote', array(__CLASS__, 'submit_quote'));
        
        add_action('wp_ajax_afrisol_submit_repair', array(__CLASS__, 'submit_repair'));
        add_action('wp_ajax_nopriv_afrisol_submit_repair', array(__CLASS__, 'submit_repair'));
        
        // Calculator
        add_action('wp_ajax_afrisol_calculate_solar', array(__CLASS__, 'calculate_solar'));
        add_action('wp_ajax_nopriv_afrisol_calculate_solar', array(__CLASS__, 'calculate_solar'));
        
        // User actions
        add_action('wp_ajax_afrisol_login', array(__CLASS__, 'user_login'));
        add_action('wp_ajax_nopriv_afrisol_login', array(__CLASS__, 'user_login'));
        
        add_action('wp_ajax_afrisol_register', array(__CLASS__, 'user_register'));
        add_action('wp_ajax_nopriv_afrisol_register', array(__CLASS__, 'user_register'));
        
        add_action('wp_ajax_afrisol_update_profile', array(__CLASS__, 'update_profile'));
        
        // Checkout
        add_action('wp_ajax_afrisol_process_checkout', array(__CLASS__, 'process_checkout'));
        add_action('wp_ajax_nopriv_afrisol_process_checkout', array(__CLASS__, 'process_checkout'));
        
        add_action('wp_ajax_afrisol_verify_payment', array(__CLASS__, 'verify_payment'));
        add_action('wp_ajax_nopriv_afrisol_verify_payment', array(__CLASS__, 'verify_payment'));
        
        // Admin actions
        add_action('wp_ajax_afrisol_save_settings', array(__CLASS__, 'save_settings'));
        add_action('wp_ajax_afrisol_upload_image', array(__CLASS__, 'upload_image'));
        add_action('wp_ajax_afrisol_get_dashboard_stats', array(__CLASS__, 'get_dashboard_stats'));
    }
    
    /**
     * Verify nonce
     */
    private static function verify_nonce() {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'afrisol_nonce')) {
            wp_send_json_error(array('message' => 'Security check failed'));
            exit;
        }
    }
    
    /**
     * Add to cart
     */
    public static function add_to_cart() {
        self::verify_nonce();
        
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        
        if (!$product_id) {
            wp_send_json_error(array('message' => 'Invalid product'));
            return;
        }
        
        $result = Afrisol_Cart::add_item($product_id, $quantity);
        
        if ($result) {
            wp_send_json_success(array(
                'message' => 'Added to cart',
                'cart_count' => Afrisol_Cart::get_count(),
                'cart_total' => Afrisol_Cart::get_total()
            ));
        } else {
            wp_send_json_error(array('message' => 'Failed to add to cart'));
        }
    }
    
    /**
     * Update cart
     */
    public static function update_cart() {
        self::verify_nonce();
        
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        
        $result = Afrisol_Cart::update_item($product_id, $quantity);
        
        wp_send_json_success(array(
            'cart' => Afrisol_Cart::get_items(),
            'cart_count' => Afrisol_Cart::get_count(),
            'cart_total' => Afrisol_Cart::get_total()
        ));
    }
    
    /**
     * Remove from cart
     */
    public static function remove_from_cart() {
        self::verify_nonce();
        
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        
        Afrisol_Cart::remove_item($product_id);
        
        wp_send_json_success(array(
            'cart' => Afrisol_Cart::get_items(),
            'cart_count' => Afrisol_Cart::get_count(),
            'cart_total' => Afrisol_Cart::get_total()
        ));
    }
    
    /**
     * Get cart
     */
    public static function get_cart() {
        wp_send_json_success(array(
            'cart' => Afrisol_Cart::get_items(),
            'cart_count' => Afrisol_Cart::get_count(),
            'cart_total' => Afrisol_Cart::get_total()
        ));
    }
    
    /**
     * Apply coupon
     */
    public static function apply_coupon() {
        self::verify_nonce();
        
        $code = isset($_POST['code']) ? sanitize_text_field(wp_unslash($_POST['code'])) : '';
        
        // Check if coupon exists and is valid
        // For now, we'll use a simple implementation
        $valid_coupons = array(
            'SOLAR10' => array('type' => 'percent', 'value' => 10),
            'SAVE5000' => array('type' => 'fixed', 'value' => 5000),
        );
        
        if (isset($valid_coupons[strtoupper($code)])) {
            $coupon = $valid_coupons[strtoupper($code)];
            $_SESSION['afrisol_coupon'] = $coupon;
            $_SESSION['afrisol_coupon_code'] = strtoupper($code);
            
            wp_send_json_success(array(
                'message' => 'Coupon applied successfully',
                'discount' => $coupon
            ));
        } else {
            wp_send_json_error(array('message' => 'Invalid coupon code'));
        }
    }
    
    /**
     * Toggle wishlist
     */
    public static function toggle_wishlist() {
        self::verify_nonce();
        
        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => 'Please login to add to wishlist'));
            return;
        }
        
        global $wpdb;
        $user_id = get_current_user_id();
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        
        $table = $wpdb->prefix . 'afrisol_wishlist';
        
        // Check if already in wishlist
        $existing = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table WHERE user_id = %d AND product_id = %d",
            $user_id, $product_id
        ));
        
        if ($existing) {
            $wpdb->delete($table, array('id' => $existing->id));
            wp_send_json_success(array('action' => 'removed', 'message' => 'Removed from wishlist'));
        } else {
            $wpdb->insert($table, array(
                'user_id' => $user_id,
                'product_id' => $product_id
            ));
            wp_send_json_success(array('action' => 'added', 'message' => 'Added to wishlist'));
        }
    }
    
    /**
     * Get wishlist
     */
    public static function get_wishlist() {
        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => 'Not logged in'));
            return;
        }
        
        global $wpdb;
        $user_id = get_current_user_id();
        $table = $wpdb->prefix . 'afrisol_wishlist';
        
        $wishlist = $wpdb->get_results($wpdb->prepare(
            "SELECT product_id FROM $table WHERE user_id = %d",
            $user_id
        ));
        
        $products = array();
        foreach ($wishlist as $item) {
            $product = get_post($item->product_id);
            if ($product) {
                $products[] = array(
                    'id' => $product->ID,
                    'title' => $product->post_title,
                    'price' => get_post_meta($product->ID, '_afrisol_price', true),
                    'image' => get_the_post_thumbnail_url($product->ID, 'medium'),
                );
            }
        }
        
        wp_send_json_success(array('wishlist' => $products));
    }
    
    /**
     * Get products with filters
     */
    public static function get_products() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $per_page = isset($_POST['per_page']) ? intval($_POST['per_page']) : 12;
        $category = isset($_POST['category']) ? sanitize_text_field(wp_unslash($_POST['category'])) : '';
        $min_price = isset($_POST['min_price']) ? intval($_POST['min_price']) : 0;
        $max_price = isset($_POST['max_price']) ? intval($_POST['max_price']) : 0;
        $brand = isset($_POST['brand']) ? sanitize_text_field(wp_unslash($_POST['brand'])) : '';
        $sort = isset($_POST['sort']) ? sanitize_text_field(wp_unslash($_POST['sort'])) : 'date';
        $search = isset($_POST['search']) ? sanitize_text_field(wp_unslash($_POST['search'])) : '';
        
        $args = array(
            'post_type' => 'afrisol_product',
            'posts_per_page' => $per_page,
            'paged' => $page,
            'post_status' => 'publish',
        );
        
        // Search
        if ($search) {
            $args['s'] = $search;
        }
        
        // Category filter
        if ($category) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'afrisol_product_cat',
                    'field' => 'slug',
                    'terms' => $category,
                ),
            );
        }
        
        // Meta query for price and brand
        $meta_query = array();
        
        if ($min_price > 0 || $max_price > 0) {
            $price_query = array('key' => '_afrisol_price', 'type' => 'NUMERIC');
            if ($min_price > 0) {
                $price_query['value'] = $min_price;
                $price_query['compare'] = '>=';
            }
            if ($max_price > 0) {
                $price_query['value'] = $max_price;
                $price_query['compare'] = '<=';
            }
            if ($min_price > 0 && $max_price > 0) {
                $price_query['value'] = array($min_price, $max_price);
                $price_query['compare'] = 'BETWEEN';
            }
            $meta_query[] = $price_query;
        }
        
        if ($brand) {
            $meta_query[] = array(
                'key' => '_afrisol_brand',
                'value' => $brand,
            );
        }
        
        if (!empty($meta_query)) {
            $args['meta_query'] = $meta_query;
        }
        
        // Sorting
        switch ($sort) {
            case 'price_low':
                $args['meta_key'] = '_afrisol_price';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'ASC';
                break;
            case 'price_high':
                $args['meta_key'] = '_afrisol_price';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
            case 'popular':
                $args['meta_key'] = '_afrisol_sales';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
            case 'rating':
                $args['meta_key'] = '_afrisol_rating';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
            default:
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
        }
        
        $query = new WP_Query($args);
        $products = array();
        
        while ($query->have_posts()) {
            $query->the_post();
            $products[] = Afrisol_Products::get_product_data(get_the_ID());
        }
        
        wp_reset_postdata();
        
        wp_send_json_success(array(
            'products' => $products,
            'total' => $query->found_posts,
            'pages' => $query->max_num_pages,
            'current_page' => $page,
        ));
    }
    
    /**
     * Quick view product
     */
    public static function quick_view() {
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        
        if (!$product_id) {
            wp_send_json_error(array('message' => 'Invalid product'));
            return;
        }
        
        $product = Afrisol_Products::get_product_data($product_id);
        
        if ($product) {
            wp_send_json_success(array('product' => $product));
        } else {
            wp_send_json_error(array('message' => 'Product not found'));
        }
    }
    
    /**
     * Compare products
     */
    public static function compare_products() {
        $product_ids = isset($_POST['products']) ? array_map('intval', $_POST['products']) : array();
        
        if (empty($product_ids)) {
            wp_send_json_error(array('message' => 'No products selected'));
            return;
        }
        
        $products = array();
        foreach ($product_ids as $id) {
            $products[] = Afrisol_Products::get_product_data($id);
        }
        
        wp_send_json_success(array('products' => $products));
    }
    
    /**
     * Notify when product back in stock
     */
    public static function notify_stock() {
        self::verify_nonce();
        
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
        
        if (!$product_id || !$email) {
            wp_send_json_error(array('message' => 'Invalid data'));
            return;
        }
        
        // Store notification request
        $notifications = get_post_meta($product_id, '_afrisol_stock_notifications', true);
        if (!is_array($notifications)) {
            $notifications = array();
        }
        
        if (!in_array($email, $notifications)) {
            $notifications[] = $email;
            update_post_meta($product_id, '_afrisol_stock_notifications', $notifications);
        }
        
        wp_send_json_success(array('message' => 'You will be notified when this product is back in stock'));
    }
    
    /**
     * Submit review
     */
    public static function submit_review() {
        self::verify_nonce();
        
        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => 'Please login to submit a review'));
            return;
        }
        
        global $wpdb;
        
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
        $review = isset($_POST['review']) ? sanitize_textarea_field(wp_unslash($_POST['review'])) : '';
        
        if (!$product_id || !$rating) {
            wp_send_json_error(array('message' => 'Please provide a rating'));
            return;
        }
        
        $table = $wpdb->prefix . 'afrisol_reviews';
        
        $wpdb->insert($table, array(
            'product_id' => $product_id,
            'user_id' => get_current_user_id(),
            'rating' => $rating,
            'review' => $review,
            'status' => 'pending',
        ));
        
        wp_send_json_success(array('message' => 'Thank you for your review! It will be visible after approval.'));
    }
    
    /**
     * Get reviews
     */
    public static function get_reviews() {
        global $wpdb;
        
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $table = $wpdb->prefix . 'afrisol_reviews';
        
        $reviews = $wpdb->get_results($wpdb->prepare(
            "SELECT r.*, u.display_name as author_name FROM $table r 
             LEFT JOIN {$wpdb->users} u ON r.user_id = u.ID 
             WHERE r.product_id = %d AND r.status = 'approved' 
             ORDER BY r.created_at DESC",
            $product_id
        ));
        
        wp_send_json_success(array('reviews' => $reviews));
    }
    
    /**
     * Submit question
     */
    public static function submit_question() {
        self::verify_nonce();
        
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $question = isset($_POST['question']) ? sanitize_textarea_field(wp_unslash($_POST['question'])) : '';
        $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
        $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
        
        if (!$product_id || !$question) {
            wp_send_json_error(array('message' => 'Please provide a question'));
            return;
        }
        
        // Store as comment
        $comment_data = array(
            'comment_post_ID' => $product_id,
            'comment_author' => $name,
            'comment_author_email' => $email,
            'comment_content' => $question,
            'comment_type' => 'afrisol_question',
            'comment_approved' => 0,
        );
        
        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            $comment_data['user_id'] = $user->ID;
            $comment_data['comment_author'] = $user->display_name;
            $comment_data['comment_author_email'] = $user->user_email;
        }
        
        wp_insert_comment($comment_data);
        
        wp_send_json_success(array('message' => 'Your question has been submitted'));
    }
    
    /**
     * Submit contact form
     */
    public static function submit_contact() {
        self::verify_nonce();
        
        global $wpdb;
        
        $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
        $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
        $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
        $subject = isset($_POST['subject']) ? sanitize_text_field(wp_unslash($_POST['subject'])) : '';
        $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';
        $type = isset($_POST['type']) ? sanitize_text_field(wp_unslash($_POST['type'])) : 'contact';
        
        if (!$name || !$email || !$message) {
            wp_send_json_error(array('message' => 'Please fill in all required fields'));
            return;
        }
        
        $table = $wpdb->prefix . 'afrisol_contacts';
        
        $wpdb->insert($table, array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'type' => $type,
        ));
        
        // Send email notification
        $settings = get_option('afrisol_settings', array());
        $admin_email = isset($settings['email']) ? $settings['email'] : get_option('admin_email');
        
        $email_subject = 'New Contact Form Submission - ' . $subject;
        $email_body = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";
        
        wp_mail($admin_email, $email_subject, $email_body);
        
        wp_send_json_success(array('message' => 'Thank you for your message. We will get back to you soon!'));
    }
    
    /**
     * Submit quote request
     */
    public static function submit_quote() {
        self::verify_nonce();
        
        $data = array();
        
        // Collect all form data
        $fields = array('service_type', 'category', 'location', 'address', 'property_type', 
                       'budget_range', 'name', 'email', 'phone', 'whatsapp', 'preferred_contact', 
                       'best_time', 'notes');
        
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $data[$field] = sanitize_text_field(wp_unslash($_POST[$field]));
            }
        }
        
        // Generate confirmation number
        $confirmation = 'AFR-' . strtoupper(wp_generate_password(8, false));
        
        // Create quote post
        $post_id = wp_insert_post(array(
            'post_title' => $confirmation . ' - ' . $data['name'],
            'post_content' => wp_json_encode($data),
            'post_status' => 'publish',
            'post_type' => 'afrisol_quote',
        ));
        
        if ($post_id) {
            update_post_meta($post_id, '_afrisol_confirmation', $confirmation);
            update_post_meta($post_id, '_afrisol_status', 'pending');
            
            foreach ($data as $key => $value) {
                update_post_meta($post_id, '_afrisol_' . $key, $value);
            }
            
            // Handle file uploads
            if (!empty($_FILES['photos'])) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');
                
                $files = $_FILES['photos'];
                $uploaded = array();
                
                if (is_array($files['name'])) {
                    for ($i = 0; $i < count($files['name']); $i++) {
                        if ($files['error'][$i] === UPLOAD_ERR_OK) {
                            $file = array(
                                'name' => $files['name'][$i],
                                'type' => $files['type'][$i],
                                'tmp_name' => $files['tmp_name'][$i],
                                'error' => $files['error'][$i],
                                'size' => $files['size'][$i],
                            );
                            $_FILES['upload_file'] = $file;
                            $attachment_id = media_handle_upload('upload_file', $post_id);
                            if (!is_wp_error($attachment_id)) {
                                $uploaded[] = $attachment_id;
                            }
                        }
                    }
                }
                
                if (!empty($uploaded)) {
                    update_post_meta($post_id, '_afrisol_attachments', $uploaded);
                }
            }
            
            // Send confirmation email
            $settings = get_option('afrisol_settings', array());
            $admin_email = isset($settings['email']) ? $settings['email'] : get_option('admin_email');
            
            // Email to admin
            $admin_subject = 'New Quote Request - ' . $confirmation;
            $admin_body = "A new quote request has been submitted.\n\n";
            $admin_body .= "Confirmation: $confirmation\n";
            $admin_body .= "Name: " . $data['name'] . "\n";
            $admin_body .= "Email: " . $data['email'] . "\n";
            $admin_body .= "Phone: " . $data['phone'] . "\n";
            $admin_body .= "Service Type: " . $data['service_type'] . "\n";
            $admin_body .= "Category: " . (isset($data['category']) ? $data['category'] : 'N/A') . "\n";
            
            wp_mail($admin_email, $admin_subject, $admin_body);
            
            // Email to customer
            if (!empty($data['email'])) {
                $customer_subject = 'Quote Request Confirmation - ' . $confirmation;
                $customer_body = "Dear " . $data['name'] . ",\n\n";
                $customer_body .= "Thank you for your quote request. We have received your submission.\n\n";
                $customer_body .= "Your confirmation number is: $confirmation\n\n";
                $customer_body .= "Our team will review your request and get back to you within 24-48 hours.\n\n";
                $customer_body .= "Best regards,\nAfrisol Team";
                
                wp_mail($data['email'], $customer_subject, $customer_body);
            }
            
            wp_send_json_success(array(
                'message' => 'Quote request submitted successfully',
                'confirmation' => $confirmation,
                'redirect' => home_url('/afrisol-quote-thank-you/?confirmation=' . $confirmation)
            ));
        } else {
            wp_send_json_error(array('message' => 'Failed to submit quote request'));
        }
    }
    
    /**
     * Submit repair request
     */
    public static function submit_repair() {
        self::verify_nonce();
        
        $data = array(
            'equipment_type' => isset($_POST['equipment_type']) ? sanitize_text_field(wp_unslash($_POST['equipment_type'])) : '',
            'brand' => isset($_POST['brand']) ? sanitize_text_field(wp_unslash($_POST['brand'])) : '',
            'model' => isset($_POST['model']) ? sanitize_text_field(wp_unslash($_POST['model'])) : '',
            'problem' => isset($_POST['problem']) ? sanitize_textarea_field(wp_unslash($_POST['problem'])) : '',
            'warranty' => isset($_POST['warranty']) ? sanitize_text_field(wp_unslash($_POST['warranty'])) : 'no',
            'service_type' => isset($_POST['service_type']) ? sanitize_text_field(wp_unslash($_POST['service_type'])) : '',
            'urgency' => isset($_POST['urgency']) ? sanitize_text_field(wp_unslash($_POST['urgency'])) : '',
            'name' => isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '',
            'email' => isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '',
            'phone' => isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '',
            'address' => isset($_POST['address']) ? sanitize_textarea_field(wp_unslash($_POST['address'])) : '',
        );
        
        // Generate ticket number
        $ticket = 'REP-' . strtoupper(wp_generate_password(8, false));
        
        // Create repair post
        $post_id = wp_insert_post(array(
            'post_title' => $ticket . ' - ' . $data['equipment_type'],
            'post_content' => $data['problem'],
            'post_status' => 'publish',
            'post_type' => 'afrisol_repair',
        ));
        
        if ($post_id) {
            update_post_meta($post_id, '_afrisol_ticket', $ticket);
            update_post_meta($post_id, '_afrisol_status', 'pending');
            
            foreach ($data as $key => $value) {
                update_post_meta($post_id, '_afrisol_' . $key, $value);
            }
            
            wp_send_json_success(array(
                'message' => 'Repair request submitted successfully',
                'ticket' => $ticket
            ));
        } else {
            wp_send_json_error(array('message' => 'Failed to submit repair request'));
        }
    }
    
    /**
     * Calculate solar needs
     */
    public static function calculate_solar() {
        self::verify_nonce();
        
        $result = Afrisol_Calculator::calculate($_POST);
        
        if ($result) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error(array('message' => 'Calculation failed'));
        }
    }
    
    /**
     * User login
     */
    public static function user_login() {
        self::verify_nonce();
        
        $username = isset($_POST['username']) ? sanitize_text_field(wp_unslash($_POST['username'])) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $remember = isset($_POST['remember']) && $_POST['remember'] === 'true';
        
        $credentials = array(
            'user_login' => $username,
            'user_password' => $password,
            'remember' => $remember,
        );
        
        $user = wp_signon($credentials, is_ssl());
        
        if (is_wp_error($user)) {
            wp_send_json_error(array('message' => 'Invalid username or password'));
        } else {
            wp_send_json_success(array(
                'message' => 'Login successful',
                'redirect' => home_url('/afrisol-portal/')
            ));
        }
    }
    
    /**
     * User registration
     */
    public static function user_register() {
        self::verify_nonce();
        
        $username = isset($_POST['username']) ? sanitize_user(wp_unslash($_POST['username'])) : '';
        $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $first_name = isset($_POST['first_name']) ? sanitize_text_field(wp_unslash($_POST['first_name'])) : '';
        $last_name = isset($_POST['last_name']) ? sanitize_text_field(wp_unslash($_POST['last_name'])) : '';
        $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
        $referral = isset($_POST['referral']) ? sanitize_text_field(wp_unslash($_POST['referral'])) : '';
        
        // Validation
        if (empty($username) || empty($email) || empty($password)) {
            wp_send_json_error(array('message' => 'Please fill in all required fields'));
            return;
        }
        
        if (username_exists($username)) {
            wp_send_json_error(array('message' => 'Username already exists'));
            return;
        }
        
        if (email_exists($email)) {
            wp_send_json_error(array('message' => 'Email already registered'));
            return;
        }
        
        // Create user
        $user_id = wp_create_user($username, $password, $email);
        
        if (is_wp_error($user_id)) {
            wp_send_json_error(array('message' => $user_id->get_error_message()));
            return;
        }
        
        // Update user meta
        wp_update_user(array(
            'ID' => $user_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'display_name' => $first_name . ' ' . $last_name,
        ));
        
        update_user_meta($user_id, 'afrisol_phone', $phone);
        
        // Handle referral
        if ($referral) {
            $referrer = get_user_by('login', $referral);
            if (!$referrer) {
                $referrer = get_user_by('ID', $referral);
            }
            
            if ($referrer) {
                global $wpdb;
                $table = $wpdb->prefix . 'afrisol_referrals';
                $wpdb->insert($table, array(
                    'referrer_id' => $referrer->ID,
                    'referred_id' => $user_id,
                ));
            }
        }
        
        // Auto login
        wp_set_auth_cookie($user_id, true);
        
        wp_send_json_success(array(
            'message' => 'Registration successful',
            'redirect' => home_url('/afrisol-portal/')
        ));
    }
    
    /**
     * Update profile
     */
    public static function update_profile() {
        self::verify_nonce();
        
        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => 'Not logged in'));
            return;
        }
        
        $user_id = get_current_user_id();
        
        $data = array('ID' => $user_id);
        
        if (isset($_POST['first_name'])) {
            $data['first_name'] = sanitize_text_field(wp_unslash($_POST['first_name']));
        }
        if (isset($_POST['last_name'])) {
            $data['last_name'] = sanitize_text_field(wp_unslash($_POST['last_name']));
        }
        if (isset($_POST['email'])) {
            $data['user_email'] = sanitize_email(wp_unslash($_POST['email']));
        }
        
        $result = wp_update_user($data);
        
        if (is_wp_error($result)) {
            wp_send_json_error(array('message' => $result->get_error_message()));
        } else {
            // Update custom meta
            if (isset($_POST['phone'])) {
                update_user_meta($user_id, 'afrisol_phone', sanitize_text_field(wp_unslash($_POST['phone'])));
            }
            if (isset($_POST['address'])) {
                update_user_meta($user_id, 'afrisol_address', sanitize_textarea_field(wp_unslash($_POST['address'])));
            }
            
            wp_send_json_success(array('message' => 'Profile updated successfully'));
        }
    }
    
    /**
     * Process checkout
     */
    public static function process_checkout() {
        self::verify_nonce();
        
        $cart_items = Afrisol_Cart::get_items();
        
        if (empty($cart_items)) {
            wp_send_json_error(array('message' => 'Cart is empty'));
            return;
        }
        
        $data = array(
            'name' => isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '',
            'email' => isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '',
            'phone' => isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '',
            'address' => isset($_POST['address']) ? sanitize_textarea_field(wp_unslash($_POST['address'])) : '',
            'delivery_method' => isset($_POST['delivery_method']) ? sanitize_text_field(wp_unslash($_POST['delivery_method'])) : 'delivery',
            'installation' => isset($_POST['installation']) ? sanitize_text_field(wp_unslash($_POST['installation'])) : 'no',
            'installation_date' => isset($_POST['installation_date']) ? sanitize_text_field(wp_unslash($_POST['installation_date'])) : '',
            'notes' => isset($_POST['notes']) ? sanitize_textarea_field(wp_unslash($_POST['notes'])) : '',
        );
        
        // Generate order number
        $order_number = 'ORD-' . strtoupper(wp_generate_password(8, false));
        
        // Calculate totals
        $subtotal = Afrisol_Cart::get_total();
        $discount = 0;
        
        // Apply coupon
        if (isset($_SESSION['afrisol_coupon'])) {
            $coupon = $_SESSION['afrisol_coupon'];
            if ($coupon['type'] === 'percent') {
                $discount = $subtotal * ($coupon['value'] / 100);
            } else {
                $discount = $coupon['value'];
            }
        }
        
        $total = $subtotal - $discount;
        
        // Create order
        $post_id = wp_insert_post(array(
            'post_title' => $order_number,
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'afrisol_order',
        ));
        
        if ($post_id) {
            update_post_meta($post_id, '_afrisol_order_number', $order_number);
            update_post_meta($post_id, '_afrisol_status', 'pending_payment');
            update_post_meta($post_id, '_afrisol_items', $cart_items);
            update_post_meta($post_id, '_afrisol_subtotal', $subtotal);
            update_post_meta($post_id, '_afrisol_discount', $discount);
            update_post_meta($post_id, '_afrisol_total', $total);
            update_post_meta($post_id, '_afrisol_customer_data', $data);
            
            if (is_user_logged_in()) {
                update_post_meta($post_id, '_afrisol_user_id', get_current_user_id());
            }
            
            // Initialize Paystack
            $settings = get_option('afrisol_settings', array());
            
            wp_send_json_success(array(
                'order_id' => $post_id,
                'order_number' => $order_number,
                'total' => $total,
                'email' => $data['email'],
                'paystack_key' => isset($settings['paystack_public_key']) ? $settings['paystack_public_key'] : '',
            ));
        } else {
            wp_send_json_error(array('message' => 'Failed to create order'));
        }
    }
    
    /**
     * Verify payment
     */
    public static function verify_payment() {
        self::verify_nonce();
        
        $reference = isset($_POST['reference']) ? sanitize_text_field(wp_unslash($_POST['reference'])) : '';
        $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        
        if (!$reference || !$order_id) {
            wp_send_json_error(array('message' => 'Invalid payment data'));
            return;
        }
        
        $settings = get_option('afrisol_settings', array());
        $secret_key = isset($settings['paystack_secret_key']) ? $settings['paystack_secret_key'] : '';
        
        // Verify with Paystack
        $response = wp_remote_get('https://api.paystack.co/transaction/verify/' . $reference, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $secret_key,
            ),
        ));
        
        if (is_wp_error($response)) {
            wp_send_json_error(array('message' => 'Payment verification failed'));
            return;
        }
        
        $body = json_decode(wp_remote_retrieve_body($response), true);
        
        if ($body['status'] && $body['data']['status'] === 'success') {
            // Update order status
            update_post_meta($order_id, '_afrisol_status', 'processing');
            update_post_meta($order_id, '_afrisol_payment_reference', $reference);
            update_post_meta($order_id, '_afrisol_payment_date', current_time('mysql'));
            
            // Clear cart
            Afrisol_Cart::clear();
            unset($_SESSION['afrisol_coupon']);
            unset($_SESSION['afrisol_coupon_code']);
            
            // Add loyalty points if logged in
            if (is_user_logged_in()) {
                $total = get_post_meta($order_id, '_afrisol_total', true);
                $points_settings = get_option('afrisol_settings');
                $points_per_naira = isset($points_settings['loyalty_points_per_naira']) ? $points_settings['loyalty_points_per_naira'] : 1;
                $points = floor($total / 1000) * $points_per_naira;
                
                if ($points > 0) {
                    global $wpdb;
                    $table = $wpdb->prefix . 'afrisol_loyalty_points';
                    $wpdb->insert($table, array(
                        'user_id' => get_current_user_id(),
                        'points' => $points,
                        'type' => 'purchase',
                        'description' => 'Points earned from order ' . get_post_meta($order_id, '_afrisol_order_number', true),
                        'order_id' => $order_id,
                    ));
                }
            }
            
            // Send confirmation email
            $customer_data = get_post_meta($order_id, '_afrisol_customer_data', true);
            $order_number = get_post_meta($order_id, '_afrisol_order_number', true);
            
            if (!empty($customer_data['email'])) {
                $subject = 'Order Confirmation - ' . $order_number;
                $message = "Dear " . $customer_data['name'] . ",\n\n";
                $message .= "Thank you for your order!\n\n";
                $message .= "Order Number: " . $order_number . "\n";
                $message .= "Total: ₦" . number_format(get_post_meta($order_id, '_afrisol_total', true)) . "\n\n";
                $message .= "We will process your order and keep you updated.\n\n";
                $message .= "Best regards,\nAfrisol Team";
                
                wp_mail($customer_data['email'], $subject, $message);
            }
            
            wp_send_json_success(array(
                'message' => 'Payment successful',
                'order_number' => $order_number,
            ));
        } else {
            update_post_meta($order_id, '_afrisol_status', 'payment_failed');
            wp_send_json_error(array('message' => 'Payment verification failed'));
        }
    }
    
    /**
     * Save admin settings
     */
    public static function save_settings() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Permission denied'));
            return;
        }
        
        check_ajax_referer('afrisol_admin_nonce', 'nonce');
        
        $settings = get_option('afrisol_settings', array());
        
        // Update settings from POST data
        $allowed_fields = array(
            'company_name', 'tagline', 'address', 'phone', 'email', 'whatsapp',
            'facebook', 'instagram', 'tiktok', 'google_maps_api_key', 'google_maps_lat',
            'google_maps_lng', 'paystack_public_key', 'paystack_secret_key', 'currency',
            'currency_symbol', 'primary_color', 'secondary_color', 'business_hours',
            'hero_heading', 'hero_subheading', 'hero_image', 'about_content', 'enable_pwa',
            'loyalty_points_per_naira', 'referral_bonus_points'
        );
        
        foreach ($allowed_fields as $field) {
            if (isset($_POST[$field])) {
                $settings[$field] = sanitize_text_field(wp_unslash($_POST[$field]));
            }
        }
        
        update_option('afrisol_settings', $settings);
        
        wp_send_json_success(array('message' => 'Settings saved successfully'));
    }
    
    /**
     * Upload image
     */
    public static function upload_image() {
        if (!current_user_can('upload_files')) {
            wp_send_json_error(array('message' => 'Permission denied'));
            return;
        }
        
        check_ajax_referer('afrisol_admin_nonce', 'nonce');
        
        if (empty($_FILES['image'])) {
            wp_send_json_error(array('message' => 'No file uploaded'));
            return;
        }
        
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        
        $attachment_id = media_handle_upload('image', 0);
        
        if (is_wp_error($attachment_id)) {
            wp_send_json_error(array('message' => $attachment_id->get_error_message()));
        } else {
            wp_send_json_success(array(
                'id' => $attachment_id,
                'url' => wp_get_attachment_url($attachment_id),
            ));
        }
    }
    
    /**
     * Get dashboard stats
     */
    public static function get_dashboard_stats() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Permission denied'));
            return;
        }
        
        global $wpdb;
        
        // Get stats
        $total_orders = wp_count_posts('afrisol_order')->publish;
        $total_products = wp_count_posts('afrisol_product')->publish;
        $total_quotes = wp_count_posts('afrisol_quote')->publish;
        $total_repairs = wp_count_posts('afrisol_repair')->publish;
        
        // Get revenue (sum of completed orders)
        $orders = get_posts(array(
            'post_type' => 'afrisol_order',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_afrisol_status',
                    'value' => array('processing', 'completed', 'delivered'),
                    'compare' => 'IN',
                ),
            ),
        ));
        
        $revenue = 0;
        foreach ($orders as $order) {
            $revenue += floatval(get_post_meta($order->ID, '_afrisol_total', true));
        }
        
        // Recent orders
        $recent_orders = get_posts(array(
            'post_type' => 'afrisol_order',
            'posts_per_page' => 5,
            'orderby' => 'date',
            'order' => 'DESC',
        ));
        
        $recent = array();
        foreach ($recent_orders as $order) {
            $recent[] = array(
                'id' => $order->ID,
                'number' => get_post_meta($order->ID, '_afrisol_order_number', true),
                'total' => get_post_meta($order->ID, '_afrisol_total', true),
                'status' => get_post_meta($order->ID, '_afrisol_status', true),
                'date' => $order->post_date,
            );
        }
        
        wp_send_json_success(array(
            'orders' => $total_orders,
            'products' => $total_products,
            'quotes' => $total_quotes,
            'repairs' => $total_repairs,
            'revenue' => $revenue,
            'recent_orders' => $recent,
        ));
    }
}
