<?php
/**
 * Single Product Page Template
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$currency_symbol = isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '₦';

$product_id = isset($_GET['id']) ? intval($_GET['id']) : (isset($atts['id']) ? intval($atts['id']) : 0);
$product = get_post($product_id);

if (!$product || $product->post_type !== 'afrisol_product') {
    echo '<div class="afrisol-wrapper">';
    echo do_shortcode('[afrisol_header]');
    echo '<div class="afrisol-section" style="padding-top: 120px;"><div class="afrisol-container"><div class="afrisol-empty-state"><i class="fas fa-exclamation-circle"></i><h3>Product Not Found</h3><p>The product you are looking for does not exist.</p><a href="' . esc_url(home_url('/afrisol-products/')) . '" class="afrisol-btn afrisol-btn-primary">Back to Products</a></div></div></div>';
    echo do_shortcode('[afrisol_footer]');
    echo '</div>';
    return;
}

$price = get_post_meta($product_id, '_afrisol_price', true);
$stock = get_post_meta($product_id, '_afrisol_stock_status', true) ?: 'in_stock';
$brand = get_post_meta($product_id, '_afrisol_brand', true);
$power = get_post_meta($product_id, '_afrisol_power', true);
$warranty = get_post_meta($product_id, '_afrisol_warranty', true);
$rating = get_post_meta($product_id, '_afrisol_rating', true) ?: 4;
$categories = wp_get_object_terms($product_id, 'afrisol_product_cat');
$image = get_the_post_thumbnail_url($product_id, 'large');

$related = get_posts(array(
    'post_type' => 'afrisol_product',
    'posts_per_page' => 4,
    'post__not_in' => array($product_id),
    'tax_query' => !empty($categories) ? array(
        array(
            'taxonomy' => 'afrisol_product_cat',
            'field' => 'term_id',
            'terms' => $categories[0]->term_id,
        ),
    ) : array(),
));
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-section" style="padding-top: 120px;">
        <div class="afrisol-container">
            <!-- Breadcrumb -->
            <nav class="afrisol-breadcrumb afrisol-mb-4">
                <a href="<?php echo esc_url(home_url('/afrisol-home/')); ?>">Home</a>
                <i class="fas fa-chevron-right"></i>
                <a href="<?php echo esc_url(home_url('/afrisol-products/')); ?>">Products</a>
                <?php if (!empty($categories)): ?>
                    <i class="fas fa-chevron-right"></i>
                    <a href="<?php echo esc_url(add_query_arg('category', $categories[0]->slug, home_url('/afrisol-products/'))); ?>">
                        <?php echo esc_html($categories[0]->name); ?>
                    </a>
                <?php endif; ?>
                <i class="fas fa-chevron-right"></i>
                <span><?php echo esc_html($product->post_title); ?></span>
            </nav>
            
            <!-- Product Details -->
            <div class="afrisol-single-product">
                <div class="afrisol-product-gallery afrisol-fade-in">
                    <div class="afrisol-gallery-main">
                        <?php if ($image): ?>
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($product->post_title); ?>">
                        <?php else: ?>
                            <div class="afrisol-image-placeholder" style="height: 100%;">
                                <i class="fas fa-solar-panel" style="font-size: 5rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="afrisol-gallery-thumbs">
                        <?php
                        $gallery_images = get_post_meta($product_id, '_afrisol_gallery', true);
                        if ($image): ?>
                            <div class="afrisol-gallery-thumb active" data-large="<?php echo esc_url($image); ?>">
                                <img src="<?php echo esc_url($image); ?>" alt="">
                            </div>
                        <?php endif;
                        if (is_array($gallery_images)):
                            foreach ($gallery_images as $img_id):
                                $img_url = wp_get_attachment_url($img_id);
                                if ($img_url): ?>
                                    <div class="afrisol-gallery-thumb" data-large="<?php echo esc_url($img_url); ?>">
                                        <img src="<?php echo esc_url($img_url); ?>" alt="">
                                    </div>
                                <?php endif;
                            endforeach;
                        endif; ?>
                    </div>
                </div>
                
                <div class="afrisol-product-details afrisol-fade-in">
                    <?php if (!empty($categories)): ?>
                        <span class="afrisol-product-category"><?php echo esc_html($categories[0]->name); ?></span>
                    <?php endif; ?>
                    
                    <h1><?php echo esc_html($product->post_title); ?></h1>
                    
                    <div class="afrisol-product-meta">
                        <div class="afrisol-product-rating">
                            <div class="afrisol-stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="<?php echo $i <= $rating ? 'fas' : 'far'; ?> fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <span>(<?php echo esc_html(rand(10, 100)); ?> reviews)</span>
                        </div>
                        
                        <?php if ($brand): ?>
                            <span><i class="fas fa-tag"></i> <?php echo esc_html($brand); ?></span>
                        <?php endif; ?>
                        
                        <span class="afrisol-badge afrisol-stock-badge <?php echo $stock === 'in_stock' ? 'in-stock' : ($stock === 'out_of_stock' ? 'out-of-stock' : 'low-stock'); ?>">
                            <?php echo $stock === 'in_stock' ? 'In Stock' : ($stock === 'out_of_stock' ? 'Out of Stock' : 'Low Stock'); ?>
                        </span>
                    </div>
                    
                    <div class="afrisol-product-price-large">
                        <?php echo esc_html($currency_symbol . number_format($price)); ?>
                    </div>
                    
                    <p class="afrisol-product-description">
                        <?php echo esc_html(wp_trim_words($product->post_content, 50)); ?>
                    </p>
                    
                    <div class="afrisol-quantity-selector">
                        <label>Quantity:</label>
                        <div class="afrisol-quantity-input">
                            <button type="button" class="afrisol-quantity-btn" data-action="decrease">-</button>
                            <input type="number" value="1" min="1" class="afrisol-qty-value" id="product-qty">
                            <button type="button" class="afrisol-quantity-btn" data-action="increase">+</button>
                        </div>
                    </div>
                    
                    <div class="afrisol-product-actions-large">
                        <button class="afrisol-btn afrisol-btn-primary afrisol-add-to-cart" data-product-id="<?php echo esc_attr($product_id); ?>" <?php echo $stock === 'out_of_stock' ? 'disabled' : ''; ?>>
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                        <a href="<?php echo esc_url(home_url('/afrisol-checkout/?buy_now=' . $product_id)); ?>" class="afrisol-btn afrisol-btn-secondary" <?php echo $stock === 'out_of_stock' ? 'style="pointer-events: none; opacity: 0.5;"' : ''; ?>>
                            <i class="fas fa-bolt"></i> Buy Now
                        </a>
                        <button class="afrisol-btn afrisol-btn-outline afrisol-wishlist-btn" data-product-id="<?php echo esc_attr($product_id); ?>">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    
                    <a href="<?php echo esc_url(home_url('/afrisol-quote/?product=' . $product_id)); ?>" class="afrisol-btn afrisol-btn-outline afrisol-btn-block afrisol-mt-3">
                        <i class="fas fa-tools"></i> Request Installation Quote
                    </a>
                    
                    <!-- Specifications -->
                    <div class="afrisol-product-specs afrisol-mt-4">
                        <h4><i class="fas fa-list-ul"></i> Specifications</h4>
                        <table class="afrisol-specs-table">
                            <?php if ($brand): ?>
                                <tr><th>Brand</th><td><?php echo esc_html($brand); ?></td></tr>
                            <?php endif; ?>
                            <?php if ($power): ?>
                                <tr><th>Power/Capacity</th><td><?php echo esc_html($power); ?></td></tr>
                            <?php endif; ?>
                            <?php if ($warranty): ?>
                                <tr><th>Warranty</th><td><?php echo esc_html($warranty); ?></td></tr>
                            <?php endif; ?>
                            <?php if (!empty($categories)): ?>
                                <tr><th>Category</th><td><?php echo esc_html($categories[0]->name); ?></td></tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Tabs: Description, Reviews, Q&A -->
            <div class="afrisol-tabs-wrapper afrisol-mt-5 afrisol-fade-in">
                <div class="afrisol-tabs">
                    <div class="afrisol-tabs-nav">
                        <button class="afrisol-tab-btn active" data-tab="description">Description</button>
                        <button class="afrisol-tab-btn" data-tab="reviews">Reviews</button>
                        <button class="afrisol-tab-btn" data-tab="qna">Q&A</button>
                    </div>
                </div>
                
                <div class="afrisol-tab-panel active" data-tab-panel="description">
                    <div class="afrisol-card">
                        <div class="afrisol-card-body">
                            <?php echo wpautop(esc_html($product->post_content)); ?>
                        </div>
                    </div>
                </div>
                
                <div class="afrisol-tab-panel" data-tab-panel="reviews">
                    <div class="afrisol-card">
                        <div class="afrisol-card-body">
                            <div id="product-reviews">
                                <p class="afrisol-text-muted">Loading reviews...</p>
                            </div>
                            
                            <?php if (is_user_logged_in()): ?>
                                <hr class="afrisol-mt-4 afrisol-mb-4" style="border-color: var(--afrisol-glass-border);">
                                <h4>Write a Review</h4>
                                <form class="afrisol-review-form" id="review-form">
                                    <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">
                                    <div class="afrisol-form-group">
                                        <label>Your Rating</label>
                                        <div class="afrisol-star-rating-input">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="far fa-star" data-rating="<?php echo $i; ?>"></i>
                                            <?php endfor; ?>
                                            <input type="hidden" name="rating" value="0">
                                        </div>
                                    </div>
                                    <div class="afrisol-form-group">
                                        <label>Your Review</label>
                                        <textarea name="review" rows="4" placeholder="Share your experience with this product..."></textarea>
                                    </div>
                                    <button type="submit" class="afrisol-btn afrisol-btn-primary">
                                        <i class="fas fa-paper-plane"></i> Submit Review
                                    </button>
                                </form>
                            <?php else: ?>
                                <p class="afrisol-mt-4"><a href="<?php echo esc_url(home_url('/afrisol-login/')); ?>">Login</a> to write a review.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="afrisol-tab-panel" data-tab-panel="qna">
                    <div class="afrisol-card">
                        <div class="afrisol-card-body">
                            <h4>Have a Question?</h4>
                            <form class="afrisol-question-form">
                                <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">
                                <div class="afrisol-form-group">
                                    <textarea name="question" rows="3" placeholder="Ask a question about this product..."></textarea>
                                </div>
                                <button type="submit" class="afrisol-btn afrisol-btn-primary">
                                    <i class="fas fa-question-circle"></i> Ask Question
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            <?php if (!empty($related)): ?>
                <div class="afrisol-mt-5 afrisol-fade-in">
                    <h2>Related Products</h2>
                    <div class="afrisol-grid afrisol-grid-4 afrisol-mt-3">
                        <?php foreach ($related as $rel):
                            $rel_price = get_post_meta($rel->ID, '_afrisol_price', true);
                            $rel_image = get_the_post_thumbnail_url($rel->ID, 'medium');
                        ?>
                            <div class="afrisol-product-card">
                                <div class="afrisol-product-image">
                                    <?php if ($rel_image): ?>
                                        <img src="<?php echo esc_url($rel_image); ?>" alt="<?php echo esc_attr($rel->post_title); ?>">
                                    <?php else: ?>
                                        <div class="afrisol-image-placeholder" style="height: 100%;"><i class="fas fa-solar-panel"></i></div>
                                    <?php endif; ?>
                                </div>
                                <div class="afrisol-product-info">
                                    <h4 class="afrisol-product-title">
                                        <a href="<?php echo esc_url(home_url('/afrisol-product/?id=' . $rel->ID)); ?>">
                                            <?php echo esc_html($rel->post_title); ?>
                                        </a>
                                    </h4>
                                    <div class="afrisol-product-price"><?php echo esc_html($currency_symbol . number_format($rel_price)); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
    <?php echo do_shortcode('[afrisol_whatsapp]'); ?>
</div>
