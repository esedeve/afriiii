<?php
/**
 * Checkout Page Template
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$currency_symbol = isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '₦';
$cart_items = class_exists('Afrisol_Cart') ? Afrisol_Cart::get_items() : array();
$cart_total = class_exists('Afrisol_Cart') ? Afrisol_Cart::get_total() : 0;

if (empty($cart_items)) {
    wp_redirect(home_url('/afrisol-cart/'));
    exit;
}

$user = is_user_logged_in() ? wp_get_current_user() : null;
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-section" style="padding-top: 120px;">
        <div class="afrisol-container">
            <div class="afrisol-section-header afrisol-fade-in">
                <h1>Checkout</h1>
            </div>
            
            <form id="checkout-form" class="afrisol-fade-in">
                <div class="afrisol-cart-layout">
                    <div class="afrisol-cart-items">
                        <!-- Step 1: Cart Review -->
                        <div class="afrisol-card afrisol-mb-4">
                            <div class="afrisol-card-header">
                                <h3><i class="fas fa-shopping-cart"></i> 1. Review Cart</h3>
                            </div>
                            <div class="afrisol-card-body">
                                <?php foreach ($cart_items as $item): ?>
                                    <div class="afrisol-flex afrisol-gap-md afrisol-mb-3" style="border-bottom: 1px solid var(--afrisol-glass-border); padding-bottom: 15px;">
                                        <div style="width: 60px; height: 60px; background: var(--afrisol-glass-bg); border-radius: 8px; overflow: hidden;">
                                            <?php if ($item['image']): ?>
                                                <img src="<?php echo esc_url($item['image']); ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php endif; ?>
                                        </div>
                                        <div style="flex: 1;">
                                            <strong><?php echo esc_html($item['title']); ?></strong>
                                            <p class="afrisol-text-muted" style="margin: 5px 0; font-size: 0.875rem;">Qty: <?php echo esc_html($item['quantity']); ?></p>
                                        </div>
                                        <div style="text-align: right;">
                                            <strong style="color: var(--afrisol-primary);"><?php echo esc_html($currency_symbol . number_format($item['subtotal'])); ?></strong>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Step 2: Delivery Information -->
                        <div class="afrisol-card afrisol-mb-4">
                            <div class="afrisol-card-header">
                                <h3><i class="fas fa-truck"></i> 2. Delivery Information</h3>
                            </div>
                            <div class="afrisol-card-body">
                                <div class="afrisol-form-group">
                                    <label><i class="fas fa-shipping-fast"></i> Delivery Method</label>
                                    <div class="afrisol-flex afrisol-gap-lg">
                                        <label class="afrisol-checkbox">
                                            <input type="radio" name="delivery_method" value="delivery" checked>
                                            <span class="afrisol-checkbox-mark"></span>
                                            Home Delivery
                                        </label>
                                        <label class="afrisol-checkbox">
                                            <input type="radio" name="delivery_method" value="pickup">
                                            <span class="afrisol-checkbox-mark"></span>
                                            Store Pickup
                                        </label>
                                    </div>
                                </div>
                                
                                <div id="delivery-address-section">
                                    <div class="afrisol-form-row">
                                        <div class="afrisol-form-group">
                                            <label for="checkout-name"><i class="fas fa-user"></i> Full Name <span class="required">*</span></label>
                                            <input type="text" id="checkout-name" name="name" required value="<?php echo $user ? esc_attr($user->display_name) : ''; ?>">
                                        </div>
                                        <div class="afrisol-form-group">
                                            <label for="checkout-email"><i class="fas fa-envelope"></i> Email <span class="required">*</span></label>
                                            <input type="email" id="checkout-email" name="email" required value="<?php echo $user ? esc_attr($user->user_email) : ''; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="afrisol-form-group">
                                        <label for="checkout-phone"><i class="fas fa-phone"></i> Phone <span class="required">*</span></label>
                                        <input type="tel" id="checkout-phone" name="phone" required value="<?php echo $user ? esc_attr(get_user_meta($user->ID, 'afrisol_phone', true)) : ''; ?>">
                                    </div>
                                    
                                    <div class="afrisol-form-group">
                                        <label for="checkout-address"><i class="fas fa-map-marker-alt"></i> Delivery Address <span class="required">*</span></label>
                                        <textarea id="checkout-address" name="address" rows="2" required placeholder="Enter full delivery address"><?php echo $user ? esc_textarea(get_user_meta($user->ID, 'afrisol_address', true)) : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Step 3: Installation -->
                        <div class="afrisol-card afrisol-mb-4">
                            <div class="afrisol-card-header">
                                <h3><i class="fas fa-tools"></i> 3. Installation Required?</h3>
                            </div>
                            <div class="afrisol-card-body">
                                <div class="afrisol-form-group">
                                    <div class="afrisol-flex afrisol-gap-lg">
                                        <label class="afrisol-checkbox">
                                            <input type="radio" name="installation" value="yes">
                                            <span class="afrisol-checkbox-mark"></span>
                                            Yes, I need installation
                                        </label>
                                        <label class="afrisol-checkbox">
                                            <input type="radio" name="installation" value="no" checked>
                                            <span class="afrisol-checkbox-mark"></span>
                                            No, just delivery
                                        </label>
                                    </div>
                                </div>
                                
                                <div id="installation-date-section" style="display: none;">
                                    <div class="afrisol-form-group">
                                        <label for="installation-date"><i class="fas fa-calendar"></i> Preferred Installation Date</label>
                                        <input type="date" id="installation-date" name="installation_date" min="<?php echo date('Y-m-d', strtotime('+3 days')); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Step 4: Payment -->
                        <div class="afrisol-card">
                            <div class="afrisol-card-header">
                                <h3><i class="fas fa-credit-card"></i> 4. Payment Method</h3>
                            </div>
                            <div class="afrisol-card-body">
                                <div class="afrisol-form-group">
                                    <label class="afrisol-checkbox">
                                        <input type="radio" name="payment_method" value="paystack" checked>
                                        <span class="afrisol-checkbox-mark"></span>
                                        <img src="https://website-v3-assets.s3.amazonaws.com/assets/img/hero/Paystack-mark-white-twitter.png" alt="Paystack" style="height: 20px; margin-left: 10px; filter: invert(1);">
                                        Pay with Card (Paystack)
                                    </label>
                                </div>
                                
                                <div class="afrisol-form-group">
                                    <label for="checkout-notes"><i class="fas fa-sticky-note"></i> Order Notes (Optional)</label>
                                    <textarea id="checkout-notes" name="notes" rows="2" placeholder="Any special instructions?"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Summary -->
                    <div class="afrisol-cart-summary">
                        <div class="afrisol-cart-summary-card">
                            <h3>Order Summary</h3>
                            
                            <div class="afrisol-cart-summary-row">
                                <span>Subtotal (<?php echo count($cart_items); ?> items)</span>
                                <span><?php echo esc_html($currency_symbol . number_format($cart_total)); ?></span>
                            </div>
                            
                            <div class="afrisol-cart-summary-row">
                                <span>Delivery</span>
                                <span id="delivery-fee">Free</span>
                            </div>
                            
                            <div class="afrisol-cart-summary-row total">
                                <span>Total</span>
                                <span id="checkout-total"><?php echo esc_html($currency_symbol . number_format($cart_total)); ?></span>
                            </div>
                            
                            <button type="submit" class="afrisol-btn afrisol-btn-primary afrisol-btn-block afrisol-mt-3" id="pay-btn">
                                <i class="fas fa-lock"></i> Pay <?php echo esc_html($currency_symbol . number_format($cart_total)); ?>
                            </button>
                            
                            <p class="afrisol-text-muted afrisol-text-center" style="font-size: 0.75rem; margin-top: 15px;">
                                <i class="fas fa-lock"></i> Your payment is secure and encrypted
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
    <?php echo do_shortcode('[afrisol_whatsapp]'); ?>
</div>

<script src="https://js.paystack.co/v1/inline.js"></script>
