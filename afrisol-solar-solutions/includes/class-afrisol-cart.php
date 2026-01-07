<?php
/**
 * Cart functionality
 */
class Afrisol_Cart {
    
    /**
     * Initialize cart
     */
    public static function init() {
        // Start session for cart
        add_action('init', array(__CLASS__, 'start_session'), 1);
        
        // Sync session cart with user cart on login
        add_action('wp_login', array(__CLASS__, 'sync_cart_on_login'), 10, 2);
    }
    
    /**
     * Start session
     */
    public static function start_session() {
        if (!session_id() && !headers_sent()) {
            session_start();
        }
    }
    
    /**
     * Get session ID
     */
    private static function get_session_id() {
        if (!session_id()) {
            self::start_session();
        }
        return session_id();
    }
    
    /**
     * Get cart items
     */
    public static function get_items() {
        global $wpdb;
        
        $table = $wpdb->prefix . 'afrisol_cart';
        $items = array();
        
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $results = $wpdb->get_results($wpdb->prepare(
                "SELECT * FROM $table WHERE user_id = %d",
                $user_id
            ));
        } else {
            $session_id = self::get_session_id();
            $results = $wpdb->get_results($wpdb->prepare(
                "SELECT * FROM $table WHERE session_id = %s",
                $session_id
            ));
        }
        
        foreach ($results as $row) {
            $product = get_post($row->product_id);
            if ($product) {
                $price = get_post_meta($row->product_id, '_afrisol_price', true);
                $items[] = array(
                    'id' => $row->product_id,
                    'title' => $product->post_title,
                    'price' => floatval($price),
                    'quantity' => intval($row->quantity),
                    'subtotal' => floatval($price) * intval($row->quantity),
                    'image' => get_the_post_thumbnail_url($row->product_id, 'thumbnail'),
                    'stock_status' => get_post_meta($row->product_id, '_afrisol_stock_status', true),
                );
            }
        }
        
        return $items;
    }
    
    /**
     * Add item to cart
     */
    public static function add_item($product_id, $quantity = 1) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'afrisol_cart';
        
        // Check if product exists
        $product = get_post($product_id);
        if (!$product || $product->post_type !== 'afrisol_product') {
            return false;
        }
        
        // Check stock
        $stock_status = get_post_meta($product_id, '_afrisol_stock_status', true);
        if ($stock_status === 'out_of_stock') {
            return false;
        }
        
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            
            // Check if item already in cart
            $existing = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM $table WHERE user_id = %d AND product_id = %d",
                $user_id, $product_id
            ));
            
            if ($existing) {
                $wpdb->update(
                    $table,
                    array('quantity' => $existing->quantity + $quantity),
                    array('id' => $existing->id)
                );
            } else {
                $wpdb->insert($table, array(
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                ));
            }
        } else {
            $session_id = self::get_session_id();
            
            $existing = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM $table WHERE session_id = %s AND product_id = %d",
                $session_id, $product_id
            ));
            
            if ($existing) {
                $wpdb->update(
                    $table,
                    array('quantity' => $existing->quantity + $quantity),
                    array('id' => $existing->id)
                );
            } else {
                $wpdb->insert($table, array(
                    'session_id' => $session_id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                ));
            }
        }
        
        return true;
    }
    
    /**
     * Update item quantity
     */
    public static function update_item($product_id, $quantity) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'afrisol_cart';
        
        if ($quantity <= 0) {
            return self::remove_item($product_id);
        }
        
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $wpdb->update(
                $table,
                array('quantity' => $quantity),
                array('user_id' => $user_id, 'product_id' => $product_id)
            );
        } else {
            $session_id = self::get_session_id();
            $wpdb->update(
                $table,
                array('quantity' => $quantity),
                array('session_id' => $session_id, 'product_id' => $product_id)
            );
        }
        
        return true;
    }
    
    /**
     * Remove item from cart
     */
    public static function remove_item($product_id) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'afrisol_cart';
        
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $wpdb->delete($table, array('user_id' => $user_id, 'product_id' => $product_id));
        } else {
            $session_id = self::get_session_id();
            $wpdb->delete($table, array('session_id' => $session_id, 'product_id' => $product_id));
        }
        
        return true;
    }
    
    /**
     * Clear cart
     */
    public static function clear() {
        global $wpdb;
        
        $table = $wpdb->prefix . 'afrisol_cart';
        
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $wpdb->delete($table, array('user_id' => $user_id));
        } else {
            $session_id = self::get_session_id();
            $wpdb->delete($table, array('session_id' => $session_id));
        }
    }
    
    /**
     * Get cart count
     */
    public static function get_count() {
        $items = self::get_items();
        $count = 0;
        
        foreach ($items as $item) {
            $count += $item['quantity'];
        }
        
        return $count;
    }
    
    /**
     * Get cart total
     */
    public static function get_total() {
        $items = self::get_items();
        $total = 0;
        
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }
        
        return $total;
    }
    
    /**
     * Sync session cart with user cart on login
     */
    public static function sync_cart_on_login($user_login, $user) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'afrisol_cart';
        $session_id = self::get_session_id();
        
        // Get session cart items
        $session_items = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table WHERE session_id = %s",
            $session_id
        ));
        
        // Merge with user cart
        foreach ($session_items as $item) {
            $existing = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM $table WHERE user_id = %d AND product_id = %d",
                $user->ID, $item->product_id
            ));
            
            if ($existing) {
                // Update quantity
                $wpdb->update(
                    $table,
                    array('quantity' => $existing->quantity + $item->quantity),
                    array('id' => $existing->id)
                );
            } else {
                // Add to user cart
                $wpdb->update(
                    $table,
                    array('user_id' => $user->ID, 'session_id' => null),
                    array('id' => $item->id)
                );
            }
        }
        
        // Delete remaining session items
        $wpdb->delete($table, array('session_id' => $session_id));
    }
}
