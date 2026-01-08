<?php
/**
 * Featured Products Component
 */
if (!defined('ABSPATH')) exit;
$count = isset($atts['count']) ? intval($atts['count']) : 4;
$settings = get_option('afrisol_settings', array());
$currency_symbol = isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '₦';

$products = get_posts(array(
    'post_type' => 'afrisol_product',
    'posts_per_page' => $count,
    'meta_query' => array(
        array(
            'key' => '_afrisol_featured',
            'value' => 'yes',
        ),
    ),
));

if (empty($products)) {
    $products = get_posts(array(
        'post_type' => 'afrisol_product',
        'posts_per_page' => $count,
    ));
}
?>
<section class="afrisol-section" id="featured-products">
    <div class="afrisol-container">
        <div class="afrisol-section-header afrisol-fade-in">
            <span class="afrisol-badge afrisol-badge-primary">Best Sellers</span>
            <h2>Featured Products</h2>
            <p>Discover our top-rated solar and security solutions</p>
        </div>
        
        <div class="afrisol-grid afrisol-grid-4">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): 
                    $price = get_post_meta($product->ID, '_afrisol_price', true);
                    $stock = get_post_meta($product->ID, '_afrisol_stock_status', true);
                    $rating = get_post_meta($product->ID, '_afrisol_rating', true) ?: 4;
                    $categories = wp_get_object_terms($product->ID, 'afrisol_product_cat');
                    $category = !empty($categories) ? $categories[0]->name : '';
                    $image = get_the_post_thumbnail_url($product->ID, 'medium');
                ?>
                    <div class="afrisol-product-card afrisol-fade-in">
                        <div class="afrisol-product-image">
                            <?php if ($image): ?>
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($product->post_title); ?>">
                            <?php else: ?>
                                <div class="afrisol-image-placeholder" style="height: 100%;">
                                    <i class="fas fa-solar-panel"></i>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($stock === 'out_of_stock'): ?>
                                <span class="afrisol-badge afrisol-badge-error afrisol-product-badge">Out of Stock</span>
                            <?php endif; ?>
                            
                            <div class="afrisol-product-actions">
                                <button class="afrisol-product-action-btn afrisol-wishlist-btn" data-product-id="<?php echo esc_attr($product->ID); ?>" title="Add to Wishlist">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="afrisol-product-action-btn afrisol-quick-view-btn" data-product-id="<?php echo esc_attr($product->ID); ?>" title="Quick View">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="afrisol-product-info">
                            <?php if ($category): ?>
                                <span class="afrisol-product-category"><?php echo esc_html($category); ?></span>
                            <?php endif; ?>
                            
                            <h4 class="afrisol-product-title">
                                <a href="<?php echo esc_url(home_url('/afrisol-product/?id=' . $product->ID)); ?>">
                                    <?php echo esc_html($product->post_title); ?>
                                </a>
                            </h4>
                            
                            <div class="afrisol-product-rating">
                                <div class="afrisol-stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $rating): ?>
                                            <i class="fas fa-star"></i>
                                        <?php else: ?>
                                            <i class="far fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <span class="count">(<?php echo esc_html(get_post_meta($product->ID, '_afrisol_review_count', true) ?: 0); ?>)</span>
                            </div>
                            
                            <div class="afrisol-product-price">
                                <?php echo esc_html($currency_symbol . number_format($price)); ?>
                            </div>
                            
                            <div class="afrisol-product-buttons">
                                <button class="afrisol-btn afrisol-btn-primary afrisol-btn-sm afrisol-add-to-cart" data-product-id="<?php echo esc_attr($product->ID); ?>" <?php echo $stock === 'out_of_stock' ? 'disabled' : ''; ?>>
                                    <i class="fas fa-cart-plus"></i> Add
                                </button>
                                <a href="<?php echo esc_url(home_url('/afrisol-product/?id=' . $product->ID)); ?>" class="afrisol-btn afrisol-btn-secondary afrisol-btn-sm">
                                    Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="afrisol-col-12">
                    <div class="afrisol-empty-state">
                        <i class="fas fa-box-open"></i>
                        <h3>No Products Yet</h3>
                        <p>Products will appear here once added.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="afrisol-text-center afrisol-mt-5">
            <a href="<?php echo esc_url(home_url('/afrisol-products/')); ?>" class="afrisol-btn afrisol-btn-primary">
                <i class="fas fa-th-large"></i> View All Products
            </a>
        </div>
    </div>
</section>
