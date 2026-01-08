/**
 * Afrisol Components JavaScript
 */

(function($) {
    'use strict';
    
    /**
     * Tabs
     */
    Afrisol.initTabs = function(container) {
        container = container || document;
        
        $(container).find('.afrisol-tab-btn').on('click', function() {
            var tab = $(this);
            var target = tab.data('tab');
            var tabContainer = tab.closest('.afrisol-tabs-wrapper');
            
            tabContainer.find('.afrisol-tab-btn').removeClass('active');
            tabContainer.find('.afrisol-tab-panel').removeClass('active');
            
            tab.addClass('active');
            tabContainer.find('[data-tab-panel="' + target + '"]').addClass('active');
        });
    };
    
    /**
     * Accordion
     */
    Afrisol.initAccordion = function() {
        $(document).on('click', '.afrisol-accordion-header', function() {
            var item = $(this).closest('.afrisol-accordion-item');
            var accordion = item.closest('.afrisol-accordion');
            
            // Close others
            accordion.find('.afrisol-accordion-item').not(item).removeClass('active');
            
            // Toggle current
            item.toggleClass('active');
        });
    };
    
    /**
     * Modal
     */
    Afrisol.openModal = function(modalId) {
        var modal = $('#' + modalId);
        modal.addClass('active');
        $('body').css('overflow', 'hidden');
    };
    
    Afrisol.closeModal = function(modalId) {
        var modal = modalId ? $('#' + modalId) : $('.afrisol-modal.active');
        modal.removeClass('active');
        $('body').css('overflow', '');
    };
    
    // Modal event handlers
    $(document).on('click', '.afrisol-modal-close, .afrisol-modal', function(e) {
        if (e.target === this) {
            Afrisol.closeModal();
        }
    });
    
    $(document).on('keyup', function(e) {
        if (e.key === 'Escape') {
            Afrisol.closeModal();
        }
    });
    
    $(document).on('click', '[data-modal]', function(e) {
        e.preventDefault();
        Afrisol.openModal($(this).data('modal'));
    });
    
    /**
     * Product Quick View
     */
    Afrisol.quickView = function(productId) {
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'afrisol_quick_view',
                product_id: productId
            },
            beforeSend: function() {
                // Show loading modal
                if (!$('#afrisol-quick-view-modal').length) {
                    $('body').append('<div class="afrisol-modal" id="afrisol-quick-view-modal">' +
                        '<div class="afrisol-modal-content afrisol-quick-view-content">' +
                        '<button class="afrisol-modal-close">&times;</button>' +
                        '<div class="afrisol-modal-body"><div class="afrisol-loading"><div class="afrisol-spinner afrisol-spinner-lg"></div></div></div>' +
                        '</div></div>');
                }
                Afrisol.openModal('afrisol-quick-view-modal');
            },
            success: function(response) {
                if (response.success) {
                    var product = response.data.product;
                    var html = Afrisol.renderQuickView(product);
                    $('#afrisol-quick-view-modal .afrisol-modal-body').html(html);
                }
            }
        });
    };
    
    Afrisol.renderQuickView = function(product) {
        var starsHtml = Afrisol.renderStars(product.rating);
        var stockClass = product.stock_status === 'in_stock' ? 'in-stock' : 
                        product.stock_status === 'out_of_stock' ? 'out-of-stock' : 'low-stock';
        var stockText = product.stock_status === 'in_stock' ? 'In Stock' : 
                       product.stock_status === 'out_of_stock' ? 'Out of Stock' : 'Low Stock';
        
        return '<div class="afrisol-quick-view">' +
            '<div class="afrisol-quick-view-image">' +
                '<img src="' + (product.image || '') + '" alt="' + product.title + '">' +
            '</div>' +
            '<div class="afrisol-quick-view-info">' +
                '<span class="afrisol-product-category">' + (product.categories.join(', ') || '') + '</span>' +
                '<h2>' + product.title + '</h2>' +
                '<div class="afrisol-product-rating">' + starsHtml + ' <span class="count">(' + product.review_count + ')</span></div>' +
                '<div class="afrisol-product-price-large">' + Afrisol.formatCurrency(product.price) + '</div>' +
                '<p class="afrisol-product-description">' + product.excerpt + '</p>' +
                '<span class="afrisol-badge afrisol-stock-badge ' + stockClass + '">' + stockText + '</span>' +
                '<div class="afrisol-quantity-selector afrisol-mt-3">' +
                    '<label>Quantity:</label>' +
                    '<div class="afrisol-quantity-input">' +
                        '<button type="button" class="afrisol-quantity-btn" data-action="decrease">-</button>' +
                        '<input type="number" value="1" min="1" class="afrisol-qty-value">' +
                        '<button type="button" class="afrisol-quantity-btn" data-action="increase">+</button>' +
                    '</div>' +
                '</div>' +
                '<div class="afrisol-product-actions-large afrisol-mt-3">' +
                    '<button class="afrisol-btn afrisol-btn-primary afrisol-add-to-cart" data-product-id="' + product.id + '">' +
                        '<i class="fas fa-shopping-cart"></i> Add to Cart' +
                    '</button>' +
                    '<a href="' + product.url + '" class="afrisol-btn afrisol-btn-secondary">' +
                        '<i class="fas fa-eye"></i> View Details' +
                    '</a>' +
                '</div>' +
            '</div>' +
        '</div>';
    };
    
    $(document).on('click', '.afrisol-quick-view-btn', function(e) {
        e.preventDefault();
        Afrisol.quickView($(this).data('product-id'));
    });
    
    /**
     * Quantity selector
     */
    $(document).on('click', '.afrisol-quantity-btn', function() {
        var input = $(this).siblings('input');
        var value = parseInt(input.val()) || 1;
        var action = $(this).data('action');
        
        if (action === 'increase') {
            input.val(value + 1);
        } else if (action === 'decrease' && value > 1) {
            input.val(value - 1);
        }
        
        input.trigger('change');
    });
    
    /**
     * Product Compare
     */
    Afrisol.compareProducts = [];
    
    Afrisol.toggleCompare = function(productId) {
        var index = Afrisol.compareProducts.indexOf(productId);
        
        if (index > -1) {
            Afrisol.compareProducts.splice(index, 1);
            return false;
        } else {
            if (Afrisol.compareProducts.length >= 4) {
                Afrisol.showToast('You can compare up to 4 products', 'warning');
                return false;
            }
            Afrisol.compareProducts.push(productId);
            return true;
        }
    };
    
    Afrisol.showCompare = function() {
        if (Afrisol.compareProducts.length < 2) {
            Afrisol.showToast('Select at least 2 products to compare', 'warning');
            return;
        }
        
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'afrisol_compare_products',
                products: Afrisol.compareProducts
            },
            success: function(response) {
                if (response.success) {
                    Afrisol.renderCompareModal(response.data.products);
                }
            }
        });
    };
    
    Afrisol.renderCompareModal = function(products) {
        // Implementation for compare modal
        console.log('Compare products:', products);
    };
    
    $(document).on('change', '.afrisol-compare-checkbox', function() {
        var productId = parseInt($(this).data('product-id'));
        Afrisol.toggleCompare(productId);
        Afrisol.updateCompareButton();
    });
    
    Afrisol.updateCompareButton = function() {
        var count = Afrisol.compareProducts.length;
        var btn = $('.afrisol-compare-btn');
        
        if (count > 0) {
            btn.show().find('.count').text(count);
        } else {
            btn.hide();
        }
    };
    
    /**
     * Wishlist toggle
     */
    $(document).on('click', '.afrisol-wishlist-btn', function(e) {
        e.preventDefault();
        var btn = $(this);
        var productId = btn.data('product-id');
        
        if (!afrisol_vars.is_logged_in) {
            Afrisol.showToast('Please login to add to wishlist', 'warning');
            return;
        }
        
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'afrisol_toggle_wishlist',
                nonce: afrisol_vars.nonce,
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    if (response.data.action === 'added') {
                        btn.addClass('active');
                        btn.find('i').removeClass('far').addClass('fas');
                    } else {
                        btn.removeClass('active');
                        btn.find('i').removeClass('fas').addClass('far');
                    }
                    Afrisol.showToast(response.data.message, 'success');
                } else {
                    Afrisol.showToast(response.data.message, 'error');
                }
            }
        });
    });
    
    /**
     * Notify when in stock
     */
    $(document).on('submit', '.afrisol-notify-form', function(e) {
        e.preventDefault();
        var form = $(this);
        
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'afrisol_notify_stock',
                nonce: afrisol_vars.nonce,
                product_id: form.find('[name="product_id"]').val(),
                email: form.find('[name="email"]').val()
            },
            success: function(response) {
                if (response.success) {
                    Afrisol.showToast(response.data.message, 'success');
                    form[0].reset();
                } else {
                    Afrisol.showToast(response.data.message, 'error');
                }
            }
        });
    });
    
    /**
     * Render star rating
     */
    Afrisol.renderStars = function(rating) {
        var html = '<div class="afrisol-stars">';
        for (var i = 1; i <= 5; i++) {
            if (i <= rating) {
                html += '<i class="fas fa-star"></i>';
            } else if (i - 0.5 <= rating) {
                html += '<i class="fas fa-star-half-alt"></i>';
            } else {
                html += '<i class="far fa-star"></i>';
            }
        }
        html += '</div>';
        return html;
    };
    
    /**
     * Star rating input
     */
    $(document).on('click', '.afrisol-star-rating-input i', function() {
        var star = $(this);
        var rating = star.data('rating');
        var container = star.closest('.afrisol-star-rating-input');
        
        container.find('i').each(function(index) {
            if (index < rating) {
                $(this).removeClass('far').addClass('fas');
            } else {
                $(this).removeClass('fas').addClass('far');
            }
        });
        
        container.find('input[type="hidden"]').val(rating);
    });
    
    /**
     * Product gallery
     */
    $(document).on('click', '.afrisol-gallery-thumb', function() {
        var thumb = $(this);
        var mainImage = thumb.closest('.afrisol-product-gallery').find('.afrisol-gallery-main img');
        
        thumb.siblings().removeClass('active');
        thumb.addClass('active');
        
        mainImage.attr('src', thumb.data('large'));
    });
    
    /**
     * Image zoom
     */
    $(document).on('click', '.afrisol-gallery-main img', function() {
        var img = $(this);
        var src = img.attr('src');
        
        if (!$('#afrisol-image-zoom-modal').length) {
            $('body').append('<div class="afrisol-modal" id="afrisol-image-zoom-modal">' +
                '<div class="afrisol-modal-content" style="max-width: 90vw; max-height: 90vh; overflow: auto;">' +
                '<button class="afrisol-modal-close">&times;</button>' +
                '<img src="" style="width: 100%;">' +
                '</div></div>');
        }
        
        $('#afrisol-image-zoom-modal img').attr('src', src);
        Afrisol.openModal('afrisol-image-zoom-modal');
    });
    
    /**
     * Product filters
     */
    Afrisol.filterProducts = function(filters) {
        var productsContainer = $('.afrisol-products-grid');
        
        productsContainer.addClass('loading');
        
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: $.extend({
                action: 'afrisol_get_products'
            }, filters),
            success: function(response) {
                if (response.success) {
                    Afrisol.renderProducts(response.data.products, productsContainer);
                    Afrisol.updatePagination(response.data);
                }
            },
            complete: function() {
                productsContainer.removeClass('loading');
            }
        });
    };
    
    Afrisol.renderProducts = function(products, container) {
        if (!products.length) {
            container.html('<div class="afrisol-empty-state">' +
                '<i class="fas fa-box-open"></i>' +
                '<h3>No products found</h3>' +
                '<p>Try adjusting your filters or search terms.</p>' +
            '</div>');
            return;
        }
        
        var html = '';
        products.forEach(function(product) {
            html += Afrisol.renderProductCard(product);
        });
        
        container.html(html);
    };
    
    Afrisol.renderProductCard = function(product) {
        var starsHtml = Afrisol.renderStars(product.rating);
        var stockClass = product.stock_status === 'in_stock' ? 'in-stock' : 
                        product.stock_status === 'out_of_stock' ? 'out-of-stock' : 'low-stock';
        
        return '<div class="afrisol-product-card">' +
            '<div class="afrisol-product-image">' +
                '<img src="' + (product.thumbnail || product.image || '') + '" alt="' + product.title + '">' +
                '<div class="afrisol-product-actions">' +
                    '<button class="afrisol-product-action-btn afrisol-wishlist-btn" data-product-id="' + product.id + '">' +
                        '<i class="far fa-heart"></i>' +
                    '</button>' +
                    '<button class="afrisol-product-action-btn afrisol-quick-view-btn" data-product-id="' + product.id + '">' +
                        '<i class="far fa-eye"></i>' +
                    '</button>' +
                '</div>' +
            '</div>' +
            '<div class="afrisol-product-info">' +
                '<span class="afrisol-product-category">' + (product.categories[0] || '') + '</span>' +
                '<h4 class="afrisol-product-title"><a href="' + product.url + '">' + product.title + '</a></h4>' +
                '<div class="afrisol-product-rating">' + starsHtml + ' <span class="count">(' + product.review_count + ')</span></div>' +
                '<div class="afrisol-product-price">' + Afrisol.formatCurrency(product.price) + '</div>' +
                '<div class="afrisol-product-buttons">' +
                    '<button class="afrisol-btn afrisol-btn-primary afrisol-btn-sm afrisol-add-to-cart" data-product-id="' + product.id + '">' +
                        '<i class="fas fa-cart-plus"></i> Add' +
                    '</button>' +
                    '<a href="' + product.url + '" class="afrisol-btn afrisol-btn-secondary afrisol-btn-sm">' +
                        'Details' +
                    '</a>' +
                '</div>' +
            '</div>' +
        '</div>';
    };
    
    Afrisol.updatePagination = function(data) {
        // Update pagination based on data
        var pagination = $('.afrisol-pagination');
        var html = '';
        
        for (var i = 1; i <= data.pages; i++) {
            html += '<button class="afrisol-pagination-btn' + (i === data.current_page ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
        }
        
        pagination.html(html);
    };
    
    // View toggle
    $(document).on('click', '.afrisol-view-btn', function() {
        var view = $(this).data('view');
        var grid = $('.afrisol-products-grid');
        
        $('.afrisol-view-btn').removeClass('active');
        $(this).addClass('active');
        
        if (view === 'list') {
            grid.addClass('list-view');
        } else {
            grid.removeClass('list-view');
        }
    });
    
    // Sort change
    $(document).on('change', '.afrisol-sort-select', function() {
        var sort = $(this).val();
        Afrisol.filterProducts({ sort: sort, page: 1 });
    });
    
    // Pagination click
    $(document).on('click', '.afrisol-pagination-btn', function() {
        var page = $(this).data('page');
        Afrisol.filterProducts({ page: page });
        
        // Scroll to products
        $('html, body').animate({
            scrollTop: $('.afrisol-products-content').offset().top - 100
        }, 300);
    });
    
    // Initialize components
    $(document).ready(function() {
        Afrisol.initTabs();
        Afrisol.initAccordion();
    });
    
})(jQuery);
