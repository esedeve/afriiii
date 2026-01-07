/**
 * Afrisol Cart JavaScript
 */

(function($) {
    'use strict';
    
    /**
     * Initialize Cart
     */
    Afrisol.initCart = function() {
        Afrisol.initAddToCart();
        Afrisol.initCartPage();
        Afrisol.updateCartCount();
    };
    
    /**
     * Add to cart functionality
     */
    Afrisol.initAddToCart = function() {
        $(document).on('click', '.afrisol-add-to-cart', function(e) {
            e.preventDefault();
            
            var btn = $(this);
            var productId = btn.data('product-id');
            var quantity = btn.closest('.afrisol-product-card, .afrisol-single-product, .afrisol-quick-view').find('.afrisol-qty-value').val() || 1;
            
            if (btn.prop('disabled')) return;
            
            var originalHtml = btn.html();
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
            
            $.ajax({
                url: afrisol_vars.ajax_url,
                type: 'POST',
                data: {
                    action: 'afrisol_add_to_cart',
                    nonce: afrisol_vars.nonce,
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        Afrisol.showToast(afrisol_vars.strings.added_to_cart, 'success');
                        Afrisol.updateCartCount(response.data.cart_count);
                        
                        // Animate cart icon
                        $('.afrisol-cart-icon').addClass('pulse');
                        setTimeout(function() {
                            $('.afrisol-cart-icon').removeClass('pulse');
                        }, 500);
                    } else {
                        Afrisol.showToast(response.data.message, 'error');
                    }
                },
                error: function() {
                    Afrisol.showToast(afrisol_vars.strings.error, 'error');
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalHtml);
                }
            });
        });
    };
    
    /**
     * Cart page functionality
     */
    Afrisol.initCartPage = function() {
        // Update quantity
        $(document).on('click', '.cart-update-qty', function() {
            var btn = $(this);
            var productId = btn.data('product-id');
            var action = btn.data('action');
            var input = btn.siblings('input.cart-qty-input');
            var currentQty = parseInt(input.val()) || 1;
            
            if (action === 'increase') {
                currentQty++;
            } else if (action === 'decrease' && currentQty > 1) {
                currentQty--;
            }
            
            input.val(currentQty);
            Afrisol.updateCartItem(productId, currentQty);
        });
        
        // Manual quantity change
        $(document).on('change', '.cart-qty-input', function() {
            var input = $(this);
            var productId = input.data('product-id');
            var quantity = parseInt(input.val()) || 1;
            
            if (quantity < 1) {
                quantity = 1;
                input.val(1);
            }
            
            Afrisol.updateCartItem(productId, quantity);
        });
        
        // Remove from cart
        $(document).on('click', '.afrisol-cart-remove', function() {
            var productId = $(this).data('product-id');
            
            if (confirm(afrisol_vars.strings.confirm_remove)) {
                Afrisol.removeFromCart(productId);
            }
        });
        
        // Clear cart
        $('#clear-cart').on('click', function() {
            if (confirm('Are you sure you want to clear your cart?')) {
                // Remove all items
                $('.afrisol-cart-item').each(function() {
                    var productId = $(this).data('product-id');
                    Afrisol.removeFromCart(productId);
                });
            }
        });
        
        // Apply coupon
        $('#apply-coupon').on('click', function() {
            var code = $('#coupon-code').val().trim();
            
            if (!code) {
                Afrisol.showToast('Please enter a coupon code', 'warning');
                return;
            }
            
            Afrisol.applyCoupon(code);
        });
        
        // Save for later
        $(document).on('click', '.save-for-later', function() {
            var productId = $(this).data('product-id');
            
            if (!afrisol_vars.is_logged_in) {
                Afrisol.showToast('Please login to save items', 'warning');
                return;
            }
            
            // Add to wishlist and remove from cart
            $.ajax({
                url: afrisol_vars.ajax_url,
                type: 'POST',
                data: {
                    action: 'afrisol_toggle_wishlist',
                    nonce: afrisol_vars.nonce,
                    product_id: productId
                },
                success: function(response) {
                    if (response.success && response.data.action === 'added') {
                        Afrisol.removeFromCart(productId);
                        Afrisol.showToast('Item saved for later', 'success');
                    }
                }
            });
        });
    };
    
    /**
     * Update cart item quantity
     */
    Afrisol.updateCartItem = function(productId, quantity) {
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'afrisol_update_cart',
                nonce: afrisol_vars.nonce,
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    Afrisol.updateCartCount(response.data.cart_count);
                    Afrisol.updateCartTotals(response.data.cart_total);
                    
                    // Update item subtotal
                    var item = response.data.cart.find(function(i) { return i.id == productId; });
                    if (item) {
                        $('[data-product-id="' + productId + '"]').find('.afrisol-text-muted strong')
                            .text(Afrisol.formatCurrency(item.subtotal));
                    }
                }
            }
        });
    };
    
    /**
     * Remove item from cart
     */
    Afrisol.removeFromCart = function(productId) {
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'afrisol_remove_from_cart',
                nonce: afrisol_vars.nonce,
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    Afrisol.showToast(afrisol_vars.strings.removed_from_cart, 'success');
                    Afrisol.updateCartCount(response.data.cart_count);
                    
                    // Remove item from DOM
                    $('[data-product-id="' + productId + '"].afrisol-cart-item').fadeOut(300, function() {
                        $(this).remove();
                        
                        // Check if cart is empty
                        if ($('.afrisol-cart-item').length === 0) {
                            location.reload();
                        } else {
                            Afrisol.updateCartTotals(response.data.cart_total);
                        }
                    });
                }
            }
        });
    };
    
    /**
     * Apply coupon
     */
    Afrisol.applyCoupon = function(code) {
        var btn = $('#apply-coupon');
        var originalText = btn.text();
        
        btn.prop('disabled', true).text('Applying...');
        
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'afrisol_apply_coupon',
                nonce: afrisol_vars.nonce,
                code: code
            },
            success: function(response) {
                if (response.success) {
                    Afrisol.showToast(response.data.message, 'success');
                    $('#discount-row').show();
                    
                    // Calculate discount
                    var subtotal = parseFloat($('#cart-subtotal').text().replace(/[^0-9.-]+/g, ''));
                    var discount = response.data.discount;
                    var discountAmount = 0;
                    
                    if (discount.type === 'percent') {
                        discountAmount = subtotal * (discount.value / 100);
                    } else {
                        discountAmount = discount.value;
                    }
                    
                    $('#cart-discount').text('-' + Afrisol.formatCurrency(discountAmount));
                    $('#cart-total').text(Afrisol.formatCurrency(subtotal - discountAmount));
                } else {
                    Afrisol.showToast(response.data.message, 'error');
                }
            },
            complete: function() {
                btn.prop('disabled', false).text(originalText);
            }
        });
    };
    
    /**
     * Update cart count in header
     */
    Afrisol.updateCartCount = function(count) {
        if (count === undefined) {
            $.ajax({
                url: afrisol_vars.ajax_url,
                type: 'POST',
                data: {
                    action: 'afrisol_get_cart'
                },
                success: function(response) {
                    if (response.success) {
                        Afrisol.updateCartCountUI(response.data.cart_count);
                    }
                }
            });
        } else {
            Afrisol.updateCartCountUI(count);
        }
    };
    
    Afrisol.updateCartCountUI = function(count) {
        var badge = $('.afrisol-cart-count');
        
        if (count > 0) {
            if (badge.length) {
                badge.text(count);
            } else {
                $('.afrisol-cart-icon').append('<span class="afrisol-cart-count">' + count + '</span>');
            }
        } else {
            badge.remove();
        }
    };
    
    /**
     * Update cart totals display
     */
    Afrisol.updateCartTotals = function(total) {
        $('#cart-subtotal').text(Afrisol.formatCurrency(total));
        
        // Check for applied discount
        var discountRow = $('#discount-row');
        if (discountRow.is(':visible')) {
            var discountText = $('#cart-discount').text();
            var discount = parseFloat(discountText.replace(/[^0-9.-]+/g, ''));
            $('#cart-total').text(Afrisol.formatCurrency(total - discount));
        } else {
            $('#cart-total').text(Afrisol.formatCurrency(total));
        }
    };
    
    // Initialize on document ready
    $(document).ready(function() {
        Afrisol.initCart();
    });
    
})(jQuery);
