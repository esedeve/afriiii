<?php
/**
 * Admin functionality
 */
class Afrisol_Admin {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        // Main menu
        add_menu_page(
            __('Afrisol', 'afrisol'),
            __('Afrisol', 'afrisol'),
            'manage_options',
            'afrisol',
            array($this, 'render_dashboard'),
            'dashicons-sun',
            25
        );
        
        // Dashboard submenu
        add_submenu_page(
            'afrisol',
            __('Dashboard', 'afrisol'),
            __('Dashboard', 'afrisol'),
            'manage_options',
            'afrisol',
            array($this, 'render_dashboard')
        );
        
        // Settings submenu
        add_submenu_page(
            'afrisol',
            __('Settings', 'afrisol'),
            __('Settings', 'afrisol'),
            'manage_options',
            'afrisol-settings',
            array($this, 'render_settings')
        );
        
        // Contacts submenu
        add_submenu_page(
            'afrisol',
            __('Contact Messages', 'afrisol'),
            __('Messages', 'afrisol'),
            'manage_options',
            'afrisol-contacts',
            array($this, 'render_contacts')
        );
    }
    
    /**
     * Render dashboard page
     */
    public function render_dashboard() {
        ?>
        <div class="wrap afrisol-admin-wrap">
            <h1><?php esc_html_e('Afrisol Dashboard', 'afrisol'); ?></h1>
            
            <div class="afrisol-admin-stats">
                <div class="afrisol-stat-card">
                    <div class="afrisol-stat-icon"><span class="dashicons dashicons-cart"></span></div>
                    <div class="afrisol-stat-content">
                        <h3><?php echo esc_html(wp_count_posts('afrisol_order')->publish); ?></h3>
                        <p><?php esc_html_e('Orders', 'afrisol'); ?></p>
                    </div>
                </div>
                
                <div class="afrisol-stat-card">
                    <div class="afrisol-stat-icon"><span class="dashicons dashicons-products"></span></div>
                    <div class="afrisol-stat-content">
                        <h3><?php echo esc_html(wp_count_posts('afrisol_product')->publish); ?></h3>
                        <p><?php esc_html_e('Products', 'afrisol'); ?></p>
                    </div>
                </div>
                
                <div class="afrisol-stat-card">
                    <div class="afrisol-stat-icon"><span class="dashicons dashicons-media-document"></span></div>
                    <div class="afrisol-stat-content">
                        <h3><?php echo esc_html(wp_count_posts('afrisol_quote')->publish); ?></h3>
                        <p><?php esc_html_e('Quote Requests', 'afrisol'); ?></p>
                    </div>
                </div>
                
                <div class="afrisol-stat-card">
                    <div class="afrisol-stat-icon"><span class="dashicons dashicons-admin-tools"></span></div>
                    <div class="afrisol-stat-content">
                        <h3><?php echo esc_html(wp_count_posts('afrisol_repair')->publish); ?></h3>
                        <p><?php esc_html_e('Repair Tickets', 'afrisol'); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="afrisol-admin-row">
                <div class="afrisol-admin-col">
                    <div class="afrisol-admin-box">
                        <h2><?php esc_html_e('Recent Orders', 'afrisol'); ?></h2>
                        <?php
                        $orders = get_posts(array(
                            'post_type' => 'afrisol_order',
                            'posts_per_page' => 5,
                            'orderby' => 'date',
                            'order' => 'DESC',
                        ));
                        
                        if ($orders) {
                            echo '<table class="wp-list-table widefat fixed striped">';
                            echo '<thead><tr><th>' . esc_html__('Order', 'afrisol') . '</th><th>' . esc_html__('Status', 'afrisol') . '</th><th>' . esc_html__('Total', 'afrisol') . '</th><th>' . esc_html__('Date', 'afrisol') . '</th></tr></thead>';
                            echo '<tbody>';
                            foreach ($orders as $order) {
                                $order_number = get_post_meta($order->ID, '_afrisol_order_number', true);
                                $status = get_post_meta($order->ID, '_afrisol_status', true);
                                $total = get_post_meta($order->ID, '_afrisol_total', true);
                                
                                echo '<tr>';
                                echo '<td><a href="' . esc_url(get_edit_post_link($order->ID)) . '">' . esc_html($order_number) . '</a></td>';
                                echo '<td><span class="afrisol-status afrisol-status-' . esc_attr($status) . '">' . esc_html(ucfirst(str_replace('_', ' ', $status))) . '</span></td>';
                                echo '<td>₦' . esc_html(number_format($total)) . '</td>';
                                echo '<td>' . esc_html(get_the_date('M j, Y', $order)) . '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody></table>';
                        } else {
                            echo '<p>' . esc_html__('No orders yet.', 'afrisol') . '</p>';
                        }
                        ?>
                    </div>
                </div>
                
                <div class="afrisol-admin-col">
                    <div class="afrisol-admin-box">
                        <h2><?php esc_html_e('Quick Links', 'afrisol'); ?></h2>
                        <ul class="afrisol-quick-links">
                            <li><a href="<?php echo esc_url(admin_url('post-new.php?post_type=afrisol_product')); ?>"><span class="dashicons dashicons-plus-alt"></span> <?php esc_html_e('Add New Product', 'afrisol'); ?></a></li>
                            <li><a href="<?php echo esc_url(admin_url('edit.php?post_type=afrisol_product')); ?>"><span class="dashicons dashicons-cart"></span> <?php esc_html_e('Manage Products', 'afrisol'); ?></a></li>
                            <li><a href="<?php echo esc_url(admin_url('edit.php?post_type=afrisol_order')); ?>"><span class="dashicons dashicons-clipboard"></span> <?php esc_html_e('View Orders', 'afrisol'); ?></a></li>
                            <li><a href="<?php echo esc_url(admin_url('edit.php?post_type=afrisol_quote')); ?>"><span class="dashicons dashicons-media-document"></span> <?php esc_html_e('Quote Requests', 'afrisol'); ?></a></li>
                            <li><a href="<?php echo esc_url(admin_url('edit.php?post_type=afrisol_repair')); ?>"><span class="dashicons dashicons-admin-tools"></span> <?php esc_html_e('Repair Tickets', 'afrisol'); ?></a></li>
                            <li><a href="<?php echo esc_url(admin_url('admin.php?page=afrisol-settings')); ?>"><span class="dashicons dashicons-admin-settings"></span> <?php esc_html_e('Settings', 'afrisol'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/afrisol-admin-frontend/')); ?>" target="_blank"><span class="dashicons dashicons-admin-customizer"></span> <?php esc_html_e('Frontend Admin', 'afrisol'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render settings page
     */
    public function render_settings() {
        // Save settings
        if (isset($_POST['afrisol_settings_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['afrisol_settings_nonce'])), 'afrisol_save_settings')) {
            $settings = array();
            
            $fields = array(
                'company_name', 'tagline', 'address', 'phone', 'email', 'whatsapp',
                'facebook', 'instagram', 'tiktok', 'google_maps_api_key', 'google_maps_lat',
                'google_maps_lng', 'paystack_public_key', 'paystack_secret_key', 'currency',
                'currency_symbol', 'primary_color', 'secondary_color', 'business_hours',
                'hero_heading', 'hero_subheading', 'hero_image', 'about_content'
            );
            
            foreach ($fields as $field) {
                if (isset($_POST[$field])) {
                    $settings[$field] = sanitize_text_field(wp_unslash($_POST[$field]));
                }
            }
            
            $settings['enable_pwa'] = isset($_POST['enable_pwa']);
            $settings['loyalty_points_per_naira'] = isset($_POST['loyalty_points_per_naira']) ? intval($_POST['loyalty_points_per_naira']) : 1;
            $settings['referral_bonus_points'] = isset($_POST['referral_bonus_points']) ? intval($_POST['referral_bonus_points']) : 500;
            
            update_option('afrisol_settings', $settings);
            
            echo '<div class="notice notice-success"><p>' . esc_html__('Settings saved successfully.', 'afrisol') . '</p></div>';
        }
        
        $settings = get_option('afrisol_settings', array());
        
        ?>
        <div class="wrap afrisol-admin-wrap">
            <h1><?php esc_html_e('Afrisol Settings', 'afrisol'); ?></h1>
            
            <form method="post" action="">
                <?php wp_nonce_field('afrisol_save_settings', 'afrisol_settings_nonce'); ?>
                
                <div class="afrisol-settings-tabs">
                    <nav class="nav-tab-wrapper">
                        <a href="#general" class="nav-tab nav-tab-active"><?php esc_html_e('General', 'afrisol'); ?></a>
                        <a href="#appearance" class="nav-tab"><?php esc_html_e('Appearance', 'afrisol'); ?></a>
                        <a href="#payment" class="nav-tab"><?php esc_html_e('Payment', 'afrisol'); ?></a>
                        <a href="#integrations" class="nav-tab"><?php esc_html_e('Integrations', 'afrisol'); ?></a>
                        <a href="#loyalty" class="nav-tab"><?php esc_html_e('Loyalty', 'afrisol'); ?></a>
                    </nav>
                    
                    <div id="general" class="afrisol-settings-panel active">
                        <h2><?php esc_html_e('General Settings', 'afrisol'); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th><label for="company_name"><?php esc_html_e('Company Name', 'afrisol'); ?></label></th>
                                <td><input type="text" name="company_name" id="company_name" value="<?php echo esc_attr($settings['company_name'] ?? 'Afrisol'); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th><label for="tagline"><?php esc_html_e('Tagline', 'afrisol'); ?></label></th>
                                <td><input type="text" name="tagline" id="tagline" value="<?php echo esc_attr($settings['tagline'] ?? ''); ?>" class="large-text"></td>
                            </tr>
                            <tr>
                                <th><label for="address"><?php esc_html_e('Address', 'afrisol'); ?></label></th>
                                <td><textarea name="address" id="address" rows="3" class="large-text"><?php echo esc_textarea($settings['address'] ?? ''); ?></textarea></td>
                            </tr>
                            <tr>
                                <th><label for="phone"><?php esc_html_e('Phone', 'afrisol'); ?></label></th>
                                <td><input type="text" name="phone" id="phone" value="<?php echo esc_attr($settings['phone'] ?? ''); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th><label for="email"><?php esc_html_e('Email', 'afrisol'); ?></label></th>
                                <td><input type="email" name="email" id="email" value="<?php echo esc_attr($settings['email'] ?? ''); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th><label for="whatsapp"><?php esc_html_e('WhatsApp', 'afrisol'); ?></label></th>
                                <td><input type="text" name="whatsapp" id="whatsapp" value="<?php echo esc_attr($settings['whatsapp'] ?? ''); ?>" class="regular-text" placeholder="+234XXXXXXXXXX"></td>
                            </tr>
                            <tr>
                                <th><label for="business_hours"><?php esc_html_e('Business Hours', 'afrisol'); ?></label></th>
                                <td><textarea name="business_hours" id="business_hours" rows="3" class="large-text"><?php echo esc_textarea($settings['business_hours'] ?? ''); ?></textarea></td>
                            </tr>
                        </table>
                        
                        <h3><?php esc_html_e('Social Media', 'afrisol'); ?></h3>
                        <table class="form-table">
                            <tr>
                                <th><label for="facebook"><?php esc_html_e('Facebook URL', 'afrisol'); ?></label></th>
                                <td><input type="url" name="facebook" id="facebook" value="<?php echo esc_url($settings['facebook'] ?? ''); ?>" class="large-text"></td>
                            </tr>
                            <tr>
                                <th><label for="instagram"><?php esc_html_e('Instagram URL', 'afrisol'); ?></label></th>
                                <td><input type="url" name="instagram" id="instagram" value="<?php echo esc_url($settings['instagram'] ?? ''); ?>" class="large-text"></td>
                            </tr>
                            <tr>
                                <th><label for="tiktok"><?php esc_html_e('TikTok URL', 'afrisol'); ?></label></th>
                                <td><input type="url" name="tiktok" id="tiktok" value="<?php echo esc_url($settings['tiktok'] ?? ''); ?>" class="large-text"></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div id="appearance" class="afrisol-settings-panel">
                        <h2><?php esc_html_e('Appearance Settings', 'afrisol'); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th><label for="primary_color"><?php esc_html_e('Primary Color', 'afrisol'); ?></label></th>
                                <td><input type="color" name="primary_color" id="primary_color" value="<?php echo esc_attr($settings['primary_color'] ?? '#FF6B35'); ?>"></td>
                            </tr>
                            <tr>
                                <th><label for="secondary_color"><?php esc_html_e('Secondary Color', 'afrisol'); ?></label></th>
                                <td><input type="color" name="secondary_color" id="secondary_color" value="<?php echo esc_attr($settings['secondary_color'] ?? '#1a1a2e'); ?>"></td>
                            </tr>
                            <tr>
                                <th><label for="hero_heading"><?php esc_html_e('Hero Heading', 'afrisol'); ?></label></th>
                                <td><input type="text" name="hero_heading" id="hero_heading" value="<?php echo esc_attr($settings['hero_heading'] ?? ''); ?>" class="large-text"></td>
                            </tr>
                            <tr>
                                <th><label for="hero_subheading"><?php esc_html_e('Hero Subheading', 'afrisol'); ?></label></th>
                                <td><textarea name="hero_subheading" id="hero_subheading" rows="3" class="large-text"><?php echo esc_textarea($settings['hero_subheading'] ?? ''); ?></textarea></td>
                            </tr>
                            <tr>
                                <th><label for="hero_image"><?php esc_html_e('Hero Image URL', 'afrisol'); ?></label></th>
                                <td>
                                    <input type="text" name="hero_image" id="hero_image" value="<?php echo esc_url($settings['hero_image'] ?? ''); ?>" class="large-text">
                                    <button type="button" class="button afrisol-upload-btn" data-target="hero_image"><?php esc_html_e('Upload Image', 'afrisol'); ?></button>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="enable_pwa"><?php esc_html_e('Enable PWA', 'afrisol'); ?></label></th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="enable_pwa" id="enable_pwa" <?php checked($settings['enable_pwa'] ?? true); ?>>
                                        <?php esc_html_e('Enable Progressive Web App features', 'afrisol'); ?>
                                    </label>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div id="payment" class="afrisol-settings-panel">
                        <h2><?php esc_html_e('Payment Settings', 'afrisol'); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th><label for="currency"><?php esc_html_e('Currency', 'afrisol'); ?></label></th>
                                <td><input type="text" name="currency" id="currency" value="<?php echo esc_attr($settings['currency'] ?? 'NGN'); ?>" class="small-text"></td>
                            </tr>
                            <tr>
                                <th><label for="currency_symbol"><?php esc_html_e('Currency Symbol', 'afrisol'); ?></label></th>
                                <td><input type="text" name="currency_symbol" id="currency_symbol" value="<?php echo esc_attr($settings['currency_symbol'] ?? '₦'); ?>" class="small-text"></td>
                            </tr>
                            <tr>
                                <th><label for="paystack_public_key"><?php esc_html_e('Paystack Public Key', 'afrisol'); ?></label></th>
                                <td><input type="text" name="paystack_public_key" id="paystack_public_key" value="<?php echo esc_attr($settings['paystack_public_key'] ?? ''); ?>" class="large-text"></td>
                            </tr>
                            <tr>
                                <th><label for="paystack_secret_key"><?php esc_html_e('Paystack Secret Key', 'afrisol'); ?></label></th>
                                <td><input type="password" name="paystack_secret_key" id="paystack_secret_key" value="<?php echo esc_attr($settings['paystack_secret_key'] ?? ''); ?>" class="large-text"></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div id="integrations" class="afrisol-settings-panel">
                        <h2><?php esc_html_e('Integrations', 'afrisol'); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th><label for="google_maps_api_key"><?php esc_html_e('Google Maps API Key', 'afrisol'); ?></label></th>
                                <td><input type="text" name="google_maps_api_key" id="google_maps_api_key" value="<?php echo esc_attr($settings['google_maps_api_key'] ?? ''); ?>" class="large-text"></td>
                            </tr>
                            <tr>
                                <th><label for="google_maps_lat"><?php esc_html_e('Latitude', 'afrisol'); ?></label></th>
                                <td><input type="text" name="google_maps_lat" id="google_maps_lat" value="<?php echo esc_attr($settings['google_maps_lat'] ?? '9.0643'); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th><label for="google_maps_lng"><?php esc_html_e('Longitude', 'afrisol'); ?></label></th>
                                <td><input type="text" name="google_maps_lng" id="google_maps_lng" value="<?php echo esc_attr($settings['google_maps_lng'] ?? '7.4892'); ?>" class="regular-text"></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div id="loyalty" class="afrisol-settings-panel">
                        <h2><?php esc_html_e('Loyalty Program', 'afrisol'); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th><label for="loyalty_points_per_naira"><?php esc_html_e('Points per ₦1000 spent', 'afrisol'); ?></label></th>
                                <td><input type="number" name="loyalty_points_per_naira" id="loyalty_points_per_naira" value="<?php echo esc_attr($settings['loyalty_points_per_naira'] ?? 1); ?>" class="small-text" min="1"></td>
                            </tr>
                            <tr>
                                <th><label for="referral_bonus_points"><?php esc_html_e('Referral Bonus Points', 'afrisol'); ?></label></th>
                                <td><input type="number" name="referral_bonus_points" id="referral_bonus_points" value="<?php echo esc_attr($settings['referral_bonus_points'] ?? 500); ?>" class="small-text" min="0"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'afrisol'); ?>">
                </p>
            </form>
        </div>
        
        <script>
            jQuery(document).ready(function($) {
                // Settings tabs
                $('.nav-tab').on('click', function(e) {
                    e.preventDefault();
                    var target = $(this).attr('href');
                    
                    $('.nav-tab').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active');
                    
                    $('.afrisol-settings-panel').removeClass('active');
                    $(target).addClass('active');
                });
            });
        </script>
        <?php
    }
    
    /**
     * Render contacts page
     */
    public function render_contacts() {
        global $wpdb;
        $table = $wpdb->prefix . 'afrisol_contacts';
        
        // Handle delete
        if (isset($_GET['delete']) && isset($_GET['_wpnonce'])) {
            if (wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'delete_contact')) {
                $wpdb->delete($table, array('id' => intval($_GET['delete'])));
                echo '<div class="notice notice-success"><p>' . esc_html__('Message deleted.', 'afrisol') . '</p></div>';
            }
        }
        
        $contacts = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC LIMIT 50");
        
        ?>
        <div class="wrap afrisol-admin-wrap">
            <h1><?php esc_html_e('Contact Messages', 'afrisol'); ?></h1>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Name', 'afrisol'); ?></th>
                        <th><?php esc_html_e('Email', 'afrisol'); ?></th>
                        <th><?php esc_html_e('Subject', 'afrisol'); ?></th>
                        <th><?php esc_html_e('Type', 'afrisol'); ?></th>
                        <th><?php esc_html_e('Date', 'afrisol'); ?></th>
                        <th><?php esc_html_e('Actions', 'afrisol'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($contacts) : foreach ($contacts as $contact) : ?>
                        <tr>
                            <td><?php echo esc_html($contact->name); ?></td>
                            <td><a href="mailto:<?php echo esc_attr($contact->email); ?>"><?php echo esc_html($contact->email); ?></a></td>
                            <td><?php echo esc_html($contact->subject); ?></td>
                            <td><?php echo esc_html(ucfirst($contact->type)); ?></td>
                            <td><?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($contact->created_at))); ?></td>
                            <td>
                                <a href="#" class="afrisol-view-message" data-message="<?php echo esc_attr($contact->message); ?>"><?php esc_html_e('View', 'afrisol'); ?></a> |
                                <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=afrisol-contacts&delete=' . $contact->id), 'delete_contact')); ?>" onclick="return confirm('<?php esc_attr_e('Are you sure?', 'afrisol'); ?>');"><?php esc_html_e('Delete', 'afrisol'); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; else : ?>
                        <tr>
                            <td colspan="6"><?php esc_html_e('No messages found.', 'afrisol'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div id="afrisol-message-modal" style="display:none;">
            <div class="afrisol-modal-content">
                <span class="afrisol-modal-close">&times;</span>
                <h3><?php esc_html_e('Message', 'afrisol'); ?></h3>
                <div id="afrisol-message-content"></div>
            </div>
        </div>
        
        <script>
            jQuery(document).ready(function($) {
                $('.afrisol-view-message').on('click', function(e) {
                    e.preventDefault();
                    $('#afrisol-message-content').text($(this).data('message'));
                    $('#afrisol-message-modal').show();
                });
                
                $('.afrisol-modal-close').on('click', function() {
                    $('#afrisol-message-modal').hide();
                });
            });
        </script>
        <?php
    }
    
    /**
     * Add meta boxes
     */
    public function add_meta_boxes() {
        // Product meta box
        add_meta_box(
            'afrisol_product_details',
            __('Product Details', 'afrisol'),
            array($this, 'render_product_meta_box'),
            'afrisol_product',
            'normal',
            'high'
        );
        
        // Order meta box
        add_meta_box(
            'afrisol_order_details',
            __('Order Details', 'afrisol'),
            array($this, 'render_order_meta_box'),
            'afrisol_order',
            'normal',
            'high'
        );
        
        // Testimonial meta box
        add_meta_box(
            'afrisol_testimonial_details',
            __('Testimonial Details', 'afrisol'),
            array($this, 'render_testimonial_meta_box'),
            'afrisol_testimonial',
            'normal',
            'high'
        );
    }
    
    /**
     * Render product meta box
     */
    public function render_product_meta_box($post) {
        wp_nonce_field('afrisol_save_product', 'afrisol_product_nonce');
        
        $price = get_post_meta($post->ID, '_afrisol_price', true);
        $sale_price = get_post_meta($post->ID, '_afrisol_sale_price', true);
        $brand = get_post_meta($post->ID, '_afrisol_brand', true);
        $power = get_post_meta($post->ID, '_afrisol_power', true);
        $warranty = get_post_meta($post->ID, '_afrisol_warranty', true);
        $stock = get_post_meta($post->ID, '_afrisol_stock_status', true) ?: 'in_stock';
        $featured = get_post_meta($post->ID, '_afrisol_featured', true);
        
        ?>
        <table class="form-table">
            <tr>
                <th><label for="afrisol_price"><?php esc_html_e('Price (₦)', 'afrisol'); ?></label></th>
                <td><input type="number" name="afrisol_price" id="afrisol_price" value="<?php echo esc_attr($price); ?>" class="regular-text" step="0.01"></td>
            </tr>
            <tr>
                <th><label for="afrisol_sale_price"><?php esc_html_e('Sale Price (₦)', 'afrisol'); ?></label></th>
                <td><input type="number" name="afrisol_sale_price" id="afrisol_sale_price" value="<?php echo esc_attr($sale_price); ?>" class="regular-text" step="0.01"></td>
            </tr>
            <tr>
                <th><label for="afrisol_brand"><?php esc_html_e('Brand', 'afrisol'); ?></label></th>
                <td><input type="text" name="afrisol_brand" id="afrisol_brand" value="<?php echo esc_attr($brand); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="afrisol_power"><?php esc_html_e('Power/Capacity', 'afrisol'); ?></label></th>
                <td><input type="text" name="afrisol_power" id="afrisol_power" value="<?php echo esc_attr($power); ?>" class="regular-text" placeholder="e.g., 450W, 5KVA, 200Ah"></td>
            </tr>
            <tr>
                <th><label for="afrisol_warranty"><?php esc_html_e('Warranty', 'afrisol'); ?></label></th>
                <td><input type="text" name="afrisol_warranty" id="afrisol_warranty" value="<?php echo esc_attr($warranty); ?>" class="regular-text" placeholder="e.g., 2 years, 25 years"></td>
            </tr>
            <tr>
                <th><label for="afrisol_stock"><?php esc_html_e('Stock Status', 'afrisol'); ?></label></th>
                <td>
                    <select name="afrisol_stock" id="afrisol_stock">
                        <option value="in_stock" <?php selected($stock, 'in_stock'); ?>><?php esc_html_e('In Stock', 'afrisol'); ?></option>
                        <option value="out_of_stock" <?php selected($stock, 'out_of_stock'); ?>><?php esc_html_e('Out of Stock', 'afrisol'); ?></option>
                        <option value="low_stock" <?php selected($stock, 'low_stock'); ?>><?php esc_html_e('Low Stock', 'afrisol'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="afrisol_featured"><?php esc_html_e('Featured', 'afrisol'); ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" name="afrisol_featured" id="afrisol_featured" value="yes" <?php checked($featured, 'yes'); ?>>
                        <?php esc_html_e('Show on homepage', 'afrisol'); ?>
                    </label>
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * Render order meta box
     */
    public function render_order_meta_box($post) {
        $order_number = get_post_meta($post->ID, '_afrisol_order_number', true);
        $status = get_post_meta($post->ID, '_afrisol_status', true);
        $total = get_post_meta($post->ID, '_afrisol_total', true);
        $items = get_post_meta($post->ID, '_afrisol_items', true);
        $customer = get_post_meta($post->ID, '_afrisol_customer_data', true);
        
        wp_nonce_field('afrisol_save_order', 'afrisol_order_nonce');
        
        ?>
        <table class="form-table">
            <tr>
                <th><?php esc_html_e('Order Number', 'afrisol'); ?></th>
                <td><strong><?php echo esc_html($order_number); ?></strong></td>
            </tr>
            <tr>
                <th><label for="afrisol_order_status"><?php esc_html_e('Status', 'afrisol'); ?></label></th>
                <td>
                    <select name="afrisol_order_status" id="afrisol_order_status">
                        <option value="pending_payment" <?php selected($status, 'pending_payment'); ?>><?php esc_html_e('Pending Payment', 'afrisol'); ?></option>
                        <option value="processing" <?php selected($status, 'processing'); ?>><?php esc_html_e('Processing', 'afrisol'); ?></option>
                        <option value="shipped" <?php selected($status, 'shipped'); ?>><?php esc_html_e('Shipped', 'afrisol'); ?></option>
                        <option value="delivered" <?php selected($status, 'delivered'); ?>><?php esc_html_e('Delivered', 'afrisol'); ?></option>
                        <option value="completed" <?php selected($status, 'completed'); ?>><?php esc_html_e('Completed', 'afrisol'); ?></option>
                        <option value="cancelled" <?php selected($status, 'cancelled'); ?>><?php esc_html_e('Cancelled', 'afrisol'); ?></option>
                        <option value="refunded" <?php selected($status, 'refunded'); ?>><?php esc_html_e('Refunded', 'afrisol'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><?php esc_html_e('Total', 'afrisol'); ?></th>
                <td><strong>₦<?php echo esc_html(number_format($total)); ?></strong></td>
            </tr>
        </table>
        
        <h3><?php esc_html_e('Customer Details', 'afrisol'); ?></h3>
        <?php if ($customer) : ?>
        <table class="form-table">
            <tr>
                <th><?php esc_html_e('Name', 'afrisol'); ?></th>
                <td><?php echo esc_html($customer['name'] ?? ''); ?></td>
            </tr>
            <tr>
                <th><?php esc_html_e('Email', 'afrisol'); ?></th>
                <td><?php echo esc_html($customer['email'] ?? ''); ?></td>
            </tr>
            <tr>
                <th><?php esc_html_e('Phone', 'afrisol'); ?></th>
                <td><?php echo esc_html($customer['phone'] ?? ''); ?></td>
            </tr>
            <tr>
                <th><?php esc_html_e('Address', 'afrisol'); ?></th>
                <td><?php echo esc_html($customer['address'] ?? ''); ?></td>
            </tr>
        </table>
        <?php endif; ?>
        
        <h3><?php esc_html_e('Order Items', 'afrisol'); ?></h3>
        <?php if ($items && is_array($items)) : ?>
        <table class="widefat">
            <thead>
                <tr>
                    <th><?php esc_html_e('Product', 'afrisol'); ?></th>
                    <th><?php esc_html_e('Price', 'afrisol'); ?></th>
                    <th><?php esc_html_e('Quantity', 'afrisol'); ?></th>
                    <th><?php esc_html_e('Subtotal', 'afrisol'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) : ?>
                <tr>
                    <td><?php echo esc_html($item['title']); ?></td>
                    <td>₦<?php echo esc_html(number_format($item['price'])); ?></td>
                    <td><?php echo esc_html($item['quantity']); ?></td>
                    <td>₦<?php echo esc_html(number_format($item['subtotal'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
        <?php
    }
    
    /**
     * Render testimonial meta box
     */
    public function render_testimonial_meta_box($post) {
        wp_nonce_field('afrisol_save_testimonial', 'afrisol_testimonial_nonce');
        
        $location = get_post_meta($post->ID, '_afrisol_location', true);
        $rating = get_post_meta($post->ID, '_afrisol_rating', true) ?: 5;
        
        ?>
        <table class="form-table">
            <tr>
                <th><label for="afrisol_location"><?php esc_html_e('Location', 'afrisol'); ?></label></th>
                <td><input type="text" name="afrisol_location" id="afrisol_location" value="<?php echo esc_attr($location); ?>" class="regular-text" placeholder="e.g., Abuja, Nigeria"></td>
            </tr>
            <tr>
                <th><label for="afrisol_rating"><?php esc_html_e('Rating', 'afrisol'); ?></label></th>
                <td>
                    <select name="afrisol_rating" id="afrisol_rating">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <option value="<?php echo esc_attr($i); ?>" <?php selected($rating, $i); ?>><?php echo esc_html($i); ?> <?php echo esc_html(str_repeat('★', $i)); ?></option>
                        <?php endfor; ?>
                    </select>
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * Save meta boxes
     */
    public function save_meta_boxes($post_id) {
        // Skip autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        // Save product meta
        if (isset($_POST['afrisol_product_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['afrisol_product_nonce'])), 'afrisol_save_product')) {
            if (isset($_POST['afrisol_price'])) {
                update_post_meta($post_id, '_afrisol_price', floatval($_POST['afrisol_price']));
            }
            if (isset($_POST['afrisol_sale_price'])) {
                update_post_meta($post_id, '_afrisol_sale_price', floatval($_POST['afrisol_sale_price']));
            }
            if (isset($_POST['afrisol_brand'])) {
                update_post_meta($post_id, '_afrisol_brand', sanitize_text_field(wp_unslash($_POST['afrisol_brand'])));
            }
            if (isset($_POST['afrisol_power'])) {
                update_post_meta($post_id, '_afrisol_power', sanitize_text_field(wp_unslash($_POST['afrisol_power'])));
            }
            if (isset($_POST['afrisol_warranty'])) {
                update_post_meta($post_id, '_afrisol_warranty', sanitize_text_field(wp_unslash($_POST['afrisol_warranty'])));
            }
            if (isset($_POST['afrisol_stock'])) {
                update_post_meta($post_id, '_afrisol_stock_status', sanitize_text_field(wp_unslash($_POST['afrisol_stock'])));
            }
            update_post_meta($post_id, '_afrisol_featured', isset($_POST['afrisol_featured']) ? 'yes' : 'no');
        }
        
        // Save order meta
        if (isset($_POST['afrisol_order_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['afrisol_order_nonce'])), 'afrisol_save_order')) {
            if (isset($_POST['afrisol_order_status'])) {
                update_post_meta($post_id, '_afrisol_status', sanitize_text_field(wp_unslash($_POST['afrisol_order_status'])));
            }
        }
        
        // Save testimonial meta
        if (isset($_POST['afrisol_testimonial_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['afrisol_testimonial_nonce'])), 'afrisol_save_testimonial')) {
            if (isset($_POST['afrisol_location'])) {
                update_post_meta($post_id, '_afrisol_location', sanitize_text_field(wp_unslash($_POST['afrisol_location'])));
            }
            if (isset($_POST['afrisol_rating'])) {
                update_post_meta($post_id, '_afrisol_rating', intval($_POST['afrisol_rating']));
            }
        }
    }
}

// Initialize admin
new Afrisol_Admin();
