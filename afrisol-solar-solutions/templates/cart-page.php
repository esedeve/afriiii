<?php
/**
 * Cart Page Template
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$currency_symbol = isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '₦';
$cart_items = class_exists('Afrisol_Cart') ? Afrisol_Cart::get_items() : array();
$cart_total = class_exists('Afrisol_Cart') ? Afrisol_Cart::get_total() : 0;
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-section" style="padding-top: 120px;">
        <div class="afrisol-container">
            <div class="afrisol-section-header afrisol-fade-in">
                <h1>Shopping Cart</h1>
            </div>
            
            <?php if (!empty($cart_items)): ?>
                <div class="afrisol-cart-layout">
                    <div class="afrisol-cart-items afrisol-fade-in">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="afrisol-cart-item" data-product-id="<?php echo esc_attr($item['id']); ?>">
                                <div class="afrisol-cart-item-image">
                                    <?php if ($item['image']): ?>
                                        <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
                                    <?php else: ?>
                                        <div class="afrisol-image-placeholder" style="height: 100%;">
                                            <i class="fas fa-solar-panel"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="afrisol-cart-item-details">
                                    <h4 class="afrisol-cart-item-title">
                                        <a href="<?php echo esc_url(home_url('/afrisol-product/?id=' . $item['id'])); ?>">
                                            <?php echo esc_html($item['title']); ?>
                                        </a>
                                    </h4>
                                    <div class="afrisol-cart-item-price">
                                        <?php echo esc_html($currency_symbol . number_format($item['price'])); ?>
                                    </div>
                                    
                                    <div class="afrisol-cart-item-actions">
                                        <div class="afrisol-quantity-input">
                                            <button type="button" class="afrisol-quantity-btn cart-update-qty" data-action="decrease" data-product-id="<?php echo esc_attr($item['id']); ?>">-</button>
                                            <input type="number" value="<?php echo esc_attr($item['quantity']); ?>" min="1" class="cart-qty-input" data-product-id="<?php echo esc_attr($item['id']); ?>">
                                            <button type="button" class="afrisol-quantity-btn cart-update-qty" data-action="increase" data-product-id="<?php echo esc_attr($item['id']); ?>">+</button>
                                        </div>
                                        
                                        <span class="afrisol-text-muted">
                                            Subtotal: <strong><?php echo esc_html($currency_symbol . number_format($item['subtotal'])); ?></strong>
                                        </span>
                                        
                                        <button class="afrisol-cart-remove" data-product-id="<?php echo esc_attr($item['id']); ?>">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                        
                                        <button class="afrisol-btn afrisol-btn-ghost afrisol-btn-sm save-for-later" data-product-id="<?php echo esc_attr($item['id']); ?>">
                                            <i class="far fa-bookmark"></i> Save for later
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="afrisol-flex-between afrisol-mt-3">
                            <a href="<?php echo esc_url(home_url('/afrisol-products/')); ?>" class="afrisol-btn afrisol-btn-ghost">
                                <i class="fas fa-arrow-left"></i> Continue Shopping
                            </a>
                            <button class="afrisol-btn afrisol-btn-secondary" id="clear-cart">
                                <i class="fas fa-trash"></i> Clear Cart
                            </button>
                        </div>
                    </div>
                    
                    <div class="afrisol-cart-summary afrisol-fade-in">
                        <div class="afrisol-cart-summary-card">
                            <h3>Order Summary</h3>
                            
                            <div class="afrisol-cart-summary-row">
                                <span>Subtotal</span>
                                <span id="cart-subtotal"><?php echo esc_html($currency_symbol . number_format($cart_total)); ?></span>
                            </div>
                            
                            <div class="afrisol-cart-summary-row">
                                <span>Delivery</span>
                                <span>Calculated at checkout</span>
                            </div>
                            
                            <div class="afrisol-cart-summary-row" id="discount-row" style="display: none;">
                                <span>Discount</span>
                                <span id="cart-discount">-<?php echo esc_html($currency_symbol); ?>0</span>
                            </div>
                            
                            <div class="afrisol-coupon-input">
                                <input type="text" placeholder="Coupon code" id="coupon-code">
                                <button class="afrisol-btn afrisol-btn-secondary afrisol-btn-sm" id="apply-coupon">Apply</button>
                            </div>
                            
                            <div class="afrisol-cart-summary-row total">
                                <span>Total</span>
                                <span id="cart-total"><?php echo esc_html($currency_symbol . number_format($cart_total)); ?></span>
                            </div>
                            
                            <p class="afrisol-text-muted" style="font-size: 0.75rem; margin-top: 10px;">
                                <i class="fas fa-calendar"></i> Estimated delivery: 3-7 business days
                            </p>
                            
                            <a href="<?php echo esc_url(home_url('/afrisol-checkout/')); ?>" class="afrisol-btn afrisol-btn-primary afrisol-btn-block afrisol-mt-3">
                                <i class="fas fa-lock"></i> Proceed to Checkout
                            </a>
                            
                            <div class="afrisol-text-center afrisol-mt-3">
                                <img src="https://via.placeholder.com/200x30?text=Secure+Payment" alt="Secure Payment" style="max-width: 100%; opacity: 0.7;">
                            </div>
                        </div>
                        
                        <!-- Recommended Products -->
                        <div class="afrisol-mt-4">
                            <h4>You May Also Like</h4>
                            <!-- Products will be loaded dynamically -->
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="afrisol-empty-state afrisol-fade-in">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Your Cart is Empty</h3>
                    <p>Looks like you haven't added any products yet.</p>
                    <a href="<?php echo esc_url(home_url('/afrisol-products/')); ?>" class="afrisol-btn afrisol-btn-primary">
                        <i class="fas fa-shopping-bag"></i> Start Shopping
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
    <?php echo do_shortcode('[afrisol_whatsapp]'); ?>
</div>
