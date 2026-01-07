<?php
/**
 * Products Page Template
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$currency_symbol = isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '₦';
$atts = isset($atts) ? $atts : array();

$categories = get_terms(array(
    'taxonomy' => 'afrisol_product_cat',
    'hide_empty' => false,
));

$current_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
$search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

$args = array(
    'post_type' => 'afrisol_product',
    'posts_per_page' => isset($atts['per_page']) ? intval($atts['per_page']) : 12,
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
);

if ($current_category) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'afrisol_product_cat',
            'field' => 'slug',
            'terms' => $current_category,
        ),
    );
}

if ($search) {
    $args['s'] = $search;
}

$products = new WP_Query($args);
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-section" style="padding-top: 120px;">
        <div class="afrisol-container">
            <div class="afrisol-section-header afrisol-fade-in">
                <h1>Our Products</h1>
                <p>Discover our range of solar panels, inverters, batteries, security systems, and more</p>
            </div>
            
            <!-- Search Bar -->
            <div class="afrisol-search-bar afrisol-fade-in">
                <form method="get" action="<?php echo esc_url(home_url('/afrisol-products/')); ?>">
                    <input type="text" name="search" placeholder="Search products..." value="<?php echo esc_attr($search); ?>">
                    <button type="submit" class="afrisol-btn afrisol-btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                </form>
            </div>
            
            <div class="afrisol-products-layout">
                <!-- Sidebar -->
                <aside class="afrisol-products-sidebar afrisol-fade-in">
                    <!-- Categories -->
                    <div class="afrisol-filter-card">
                        <h4 class="afrisol-filter-title"><i class="fas fa-folder"></i> Categories</h4>
                        <ul class="afrisol-filter-list">
                            <li>
                                <a href="<?php echo esc_url(home_url('/afrisol-products/')); ?>" <?php echo empty($current_category) ? 'class="active"' : ''; ?>>
                                    All Products
                                    <span class="count"><?php echo wp_count_posts('afrisol_product')->publish; ?></span>
                                </a>
                            </li>
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a href="<?php echo esc_url(add_query_arg('category', $category->slug, home_url('/afrisol-products/'))); ?>" <?php echo $current_category === $category->slug ? 'class="active"' : ''; ?>>
                                        <?php echo esc_html($category->name); ?>
                                        <span class="count"><?php echo esc_html($category->count); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <!-- Price Range -->
                    <div class="afrisol-filter-card">
                        <h4 class="afrisol-filter-title"><i class="fas fa-tag"></i> Price Range</h4>
                        <div class="afrisol-price-range">
                            <div class="afrisol-price-inputs">
                                <input type="number" placeholder="Min" id="price-min">
                                <span>to</span>
                                <input type="number" placeholder="Max" id="price-max">
                            </div>
                            <button class="afrisol-btn afrisol-btn-secondary afrisol-btn-sm afrisol-btn-block afrisol-mt-2" id="apply-price-filter">
                                Apply Filter
                            </button>
                        </div>
                    </div>
                    
                    <!-- Stock Status -->
                    <div class="afrisol-filter-card">
                        <h4 class="afrisol-filter-title"><i class="fas fa-box"></i> Availability</h4>
                        <ul class="afrisol-filter-list">
                            <li>
                                <label class="afrisol-checkbox">
                                    <input type="checkbox" name="in_stock" checked>
                                    <span class="afrisol-checkbox-mark"></span>
                                    In Stock
                                </label>
                            </li>
                            <li>
                                <label class="afrisol-checkbox">
                                    <input type="checkbox" name="out_of_stock">
                                    <span class="afrisol-checkbox-mark"></span>
                                    Out of Stock
                                </label>
                            </li>
                        </ul>
                    </div>
                </aside>
                
                <!-- Products Grid -->
                <div class="afrisol-products-content">
                    <div class="afrisol-products-header">
                        <span class="afrisol-products-count">
                            Showing <?php echo $products->post_count; ?> of <?php echo $products->found_posts; ?> products
                        </span>
                        
                        <div class="afrisol-products-controls">
                            <div class="afrisol-view-toggle">
                                <button class="afrisol-view-btn active" data-view="grid" title="Grid View">
                                    <i class="fas fa-th-large"></i>
                                </button>
                                <button class="afrisol-view-btn" data-view="list" title="List View">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                            
                            <select class="afrisol-sort-select">
                                <option value="date">Newest First</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                                <option value="popular">Most Popular</option>
                                <option value="rating">Top Rated</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="afrisol-products-grid">
                        <?php if ($products->have_posts()): ?>
                            <?php while ($products->have_posts()): $products->the_post();
                                $product_id = get_the_ID();
                                $price = get_post_meta($product_id, '_afrisol_price', true);
                                $stock = get_post_meta($product_id, '_afrisol_stock_status', true);
                                $rating = get_post_meta($product_id, '_afrisol_rating', true) ?: 4;
                                $cats = wp_get_object_terms($product_id, 'afrisol_product_cat');
                                $category = !empty($cats) ? $cats[0]->name : '';
                                $image = get_the_post_thumbnail_url($product_id, 'medium');
                            ?>
                                <div class="afrisol-product-card afrisol-fade-in">
                                    <div class="afrisol-product-image">
                                        <?php if ($image): ?>
                                            <img src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>">
                                        <?php else: ?>
                                            <div class="afrisol-image-placeholder" style="height: 100%;">
                                                <i class="fas fa-solar-panel"></i>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($stock === 'out_of_stock'): ?>
                                            <span class="afrisol-badge afrisol-badge-error afrisol-product-badge">Out of Stock</span>
                                        <?php endif; ?>
                                        
                                        <div class="afrisol-product-actions">
                                            <button class="afrisol-product-action-btn afrisol-wishlist-btn" data-product-id="<?php echo esc_attr($product_id); ?>">
                                                <i class="far fa-heart"></i>
                                            </button>
                                            <button class="afrisol-product-action-btn afrisol-quick-view-btn" data-product-id="<?php echo esc_attr($product_id); ?>">
                                                <i class="far fa-eye"></i>
                                            </button>
                                            <label class="afrisol-product-action-btn">
                                                <input type="checkbox" class="afrisol-compare-checkbox" data-product-id="<?php echo esc_attr($product_id); ?>" style="display: none;">
                                                <i class="fas fa-exchange-alt"></i>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="afrisol-product-info">
                                        <?php if ($category): ?>
                                            <span class="afrisol-product-category"><?php echo esc_html($category); ?></span>
                                        <?php endif; ?>
                                        
                                        <h4 class="afrisol-product-title">
                                            <a href="<?php echo esc_url(home_url('/afrisol-product/?id=' . $product_id)); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h4>
                                        
                                        <div class="afrisol-product-rating">
                                            <div class="afrisol-stars">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="<?php echo $i <= $rating ? 'fas' : 'far'; ?> fa-star"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="count">(<?php echo esc_html(rand(5, 50)); ?>)</span>
                                        </div>
                                        
                                        <div class="afrisol-product-price">
                                            <?php echo esc_html($currency_symbol . number_format($price)); ?>
                                        </div>
                                        
                                        <div class="afrisol-product-buttons">
                                            <button class="afrisol-btn afrisol-btn-primary afrisol-btn-sm afrisol-add-to-cart" data-product-id="<?php echo esc_attr($product_id); ?>" <?php echo $stock === 'out_of_stock' ? 'disabled' : ''; ?>>
                                                <i class="fas fa-cart-plus"></i> Add
                                            </button>
                                            <a href="<?php echo esc_url(home_url('/afrisol-product/?id=' . $product_id)); ?>" class="afrisol-btn afrisol-btn-secondary afrisol-btn-sm">
                                                Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; wp_reset_postdata(); ?>
                        <?php else: ?>
                            <div class="afrisol-empty-state" style="grid-column: 1 / -1;">
                                <i class="fas fa-box-open"></i>
                                <h3>No Products Found</h3>
                                <p>Try adjusting your search or filter criteria.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($products->max_num_pages > 1): ?>
                        <div class="afrisol-pagination">
                            <?php for ($i = 1; $i <= $products->max_num_pages; $i++): ?>
                                <button class="afrisol-pagination-btn <?php echo $i == get_query_var('paged', 1) ? 'active' : ''; ?>" data-page="<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </button>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
    <?php echo do_shortcode('[afrisol_whatsapp]'); ?>
</div>
