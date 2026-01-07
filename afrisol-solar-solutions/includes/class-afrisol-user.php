<?php
/**
 * User functionality
 */
class Afrisol_User {
    
    /**
     * Initialize
     */
    public static function init() {
        // Add custom user meta fields
        add_action('show_user_profile', array(__CLASS__, 'add_custom_fields'));
        add_action('edit_user_profile', array(__CLASS__, 'add_custom_fields'));
        add_action('personal_options_update', array(__CLASS__, 'save_custom_fields'));
        add_action('edit_user_profile_update', array(__CLASS__, 'save_custom_fields'));
    }
    
    /**
     * Add custom user fields
     */
    public static function add_custom_fields($user) {
        ?>
        <h3><?php esc_html_e('Afrisol Information', 'afrisol'); ?></h3>
        <table class="form-table">
            <tr>
                <th><label for="afrisol_phone"><?php esc_html_e('Phone Number', 'afrisol'); ?></label></th>
                <td>
                    <input type="text" name="afrisol_phone" id="afrisol_phone" 
                           value="<?php echo esc_attr(get_user_meta($user->ID, 'afrisol_phone', true)); ?>" 
                           class="regular-text">
                </td>
            </tr>
            <tr>
                <th><label for="afrisol_address"><?php esc_html_e('Address', 'afrisol'); ?></label></th>
                <td>
                    <textarea name="afrisol_address" id="afrisol_address" rows="3" 
                              class="regular-text"><?php echo esc_textarea(get_user_meta($user->ID, 'afrisol_address', true)); ?></textarea>
                </td>
            </tr>
            <tr>
                <th><label><?php esc_html_e('Loyalty Points', 'afrisol'); ?></label></th>
                <td>
                    <strong><?php echo esc_html(self::get_loyalty_points($user->ID)); ?></strong> points
                </td>
            </tr>
            <tr>
                <th><label><?php esc_html_e('Referral Code', 'afrisol'); ?></label></th>
                <td>
                    <code><?php echo esc_html(self::get_referral_code($user->ID)); ?></code>
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * Save custom user fields
     */
    public static function save_custom_fields($user_id) {
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }
        
        if (isset($_POST['afrisol_phone'])) {
            update_user_meta($user_id, 'afrisol_phone', sanitize_text_field(wp_unslash($_POST['afrisol_phone'])));
        }
        if (isset($_POST['afrisol_address'])) {
            update_user_meta($user_id, 'afrisol_address', sanitize_textarea_field(wp_unslash($_POST['afrisol_address'])));
        }
    }
    
    /**
     * Get user loyalty points
     */
    public static function get_loyalty_points($user_id) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'afrisol_loyalty_points';
        
        $points = $wpdb->get_var($wpdb->prepare(
            "SELECT SUM(points) FROM $table WHERE user_id = %d",
            $user_id
        ));
        
        return intval($points);
    }
    
    /**
     * Get referral code
     */
    public static function get_referral_code($user_id) {
        $code = get_user_meta($user_id, 'afrisol_referral_code', true);
        
        if (!$code) {
            $code = 'REF' . strtoupper(wp_generate_password(6, false));
            update_user_meta($user_id, 'afrisol_referral_code', $code);
        }
        
        return $code;
    }
    
    /**
     * Get user orders
     */
    public static function get_orders($user_id, $limit = -1) {
        $orders = get_posts(array(
            'post_type' => 'afrisol_order',
            'posts_per_page' => $limit,
            'meta_query' => array(
                array(
                    'key' => '_afrisol_user_id',
                    'value' => $user_id,
                ),
            ),
            'orderby' => 'date',
            'order' => 'DESC',
        ));
        
        $result = array();
        foreach ($orders as $order) {
            $result[] = array(
                'id' => $order->ID,
                'number' => get_post_meta($order->ID, '_afrisol_order_number', true),
                'date' => $order->post_date,
                'status' => get_post_meta($order->ID, '_afrisol_status', true),
                'total' => get_post_meta($order->ID, '_afrisol_total', true),
                'items' => get_post_meta($order->ID, '_afrisol_items', true),
            );
        }
        
        return $result;
    }
    
    /**
     * Get user repair tickets
     */
    public static function get_repair_tickets($user_id) {
        $user = get_user_by('ID', $user_id);
        
        if (!$user) {
            return array();
        }
        
        $tickets = get_posts(array(
            'post_type' => 'afrisol_repair',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_afrisol_email',
                    'value' => $user->user_email,
                ),
            ),
            'orderby' => 'date',
            'order' => 'DESC',
        ));
        
        $result = array();
        foreach ($tickets as $ticket) {
            $result[] = array(
                'id' => $ticket->ID,
                'ticket' => get_post_meta($ticket->ID, '_afrisol_ticket', true),
                'date' => $ticket->post_date,
                'status' => get_post_meta($ticket->ID, '_afrisol_status', true),
                'equipment' => get_post_meta($ticket->ID, '_afrisol_equipment_type', true),
                'problem' => $ticket->post_content,
            );
        }
        
        return $result;
    }
    
    /**
     * Get user wishlist
     */
    public static function get_wishlist($user_id) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'afrisol_wishlist';
        
        $wishlist = $wpdb->get_results($wpdb->prepare(
            "SELECT product_id FROM $table WHERE user_id = %d ORDER BY created_at DESC",
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
                    'url' => home_url('/afrisol-product/?id=' . $product->ID),
                );
            }
        }
        
        return $products;
    }
    
    /**
     * Get user warranties
     */
    public static function get_warranties($user_id) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'afrisol_warranties';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT w.*, p.post_title as product_name FROM $table w 
             LEFT JOIN {$wpdb->posts} p ON w.product_id = p.ID 
             WHERE w.user_id = %d ORDER BY w.expiry_date DESC",
            $user_id
        ));
    }
    
    /**
     * Get referrals
     */
    public static function get_referrals($user_id) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'afrisol_referrals';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT r.*, u.display_name as referred_name FROM $table r 
             LEFT JOIN {$wpdb->users} u ON r.referred_id = u.ID 
             WHERE r.referrer_id = %d ORDER BY r.created_at DESC",
            $user_id
        ));
    }
    
    /**
     * Get points history
     */
    public static function get_points_history($user_id) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'afrisol_loyalty_points';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table WHERE user_id = %d ORDER BY created_at DESC LIMIT 50",
            $user_id
        ));
    }
}
