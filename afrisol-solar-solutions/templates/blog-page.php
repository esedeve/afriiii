<?php
/**
 * Blog/Resources Page Template
 */
if (!defined('ABSPATH')) exit;
$atts = isset($atts) ? $atts : array();
$per_page = isset($atts['per_page']) ? intval($atts['per_page']) : 9;

$posts = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => $per_page,
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
));

$categories = get_categories();
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-section" style="padding-top: 120px;">
        <div class="afrisol-container">
            <div class="afrisol-section-header afrisol-fade-in">
                <span class="afrisol-badge"><i class="fas fa-book-open"></i> Resources</span>
                <h1>Blog & Resources</h1>
                <p>Educational articles, guides, and industry news</p>
            </div>
            
            <!-- Categories -->
            <div class="afrisol-flex-center afrisol-gap-md afrisol-mb-5 afrisol-fade-in" style="flex-wrap: wrap;">
                <a href="<?php echo esc_url(home_url('/afrisol-blog/')); ?>" class="afrisol-btn afrisol-btn-sm <?php echo !isset($_GET['category']) ? 'afrisol-btn-primary' : 'afrisol-btn-secondary'; ?>">
                    All Posts
                </a>
                <?php foreach ($categories as $category): ?>
                    <a href="<?php echo esc_url(add_query_arg('category', $category->slug, home_url('/afrisol-blog/'))); ?>" class="afrisol-btn afrisol-btn-sm <?php echo isset($_GET['category']) && $_GET['category'] === $category->slug ? 'afrisol-btn-primary' : 'afrisol-btn-secondary'; ?>">
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
            
            <!-- Search -->
            <div class="afrisol-search-bar afrisol-fade-in afrisol-mb-5" style="max-width: 600px; margin-left: auto; margin-right: auto;">
                <form method="get" action="<?php echo esc_url(home_url('/afrisol-blog/')); ?>">
                    <input type="text" name="search" placeholder="Search articles..." value="<?php echo isset($_GET['search']) ? esc_attr($_GET['search']) : ''; ?>">
                    <button type="submit" class="afrisol-btn afrisol-btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <!-- Blog Grid -->
            <div class="afrisol-blog-grid">
                <?php if ($posts->have_posts()): ?>
                    <?php while ($posts->have_posts()): $posts->the_post(); ?>
                        <article class="afrisol-blog-card afrisol-fade-in">
                            <div class="afrisol-blog-image">
                                <?php if (has_post_thumbnail()): ?>
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium_large')); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php else: ?>
                                    <div class="afrisol-image-placeholder" style="height: 100%;">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="afrisol-blog-content">
                                <div class="afrisol-blog-meta">
                                    <span><i class="far fa-calendar"></i> <?php echo get_the_date(); ?></span>
                                    <span><i class="far fa-user"></i> <?php the_author(); ?></span>
                                </div>
                                <h3 class="afrisol-blog-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <p class="afrisol-blog-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                <a href="<?php the_permalink(); ?>" class="afrisol-btn afrisol-btn-ghost afrisol-btn-sm">
                                    Read More <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php else: ?>
                    <div class="afrisol-empty-state" style="grid-column: 1 / -1;">
                        <i class="fas fa-newspaper"></i>
                        <h3>No Articles Yet</h3>
                        <p>Check back soon for educational content and industry news.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Featured Resources -->
            <div class="afrisol-section afrisol-fade-in">
                <div class="afrisol-section-header">
                    <h2>Featured Resources</h2>
                </div>
                <div class="afrisol-grid afrisol-grid-3">
                    <div class="afrisol-card">
                        <div class="afrisol-card-body afrisol-text-center">
                            <i class="fas fa-book" style="font-size: 2.5rem; color: var(--afrisol-primary); margin-bottom: 15px;"></i>
                            <h4>Buyer's Guide</h4>
                            <p class="afrisol-text-muted">How to Choose the Right Solar System for Your Home</p>
                            <a href="#" class="afrisol-btn afrisol-btn-secondary afrisol-btn-sm">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                    <div class="afrisol-card">
                        <div class="afrisol-card-body afrisol-text-center">
                            <i class="fas fa-video" style="font-size: 2.5rem; color: var(--afrisol-primary); margin-bottom: 15px;"></i>
                            <h4>Video Tutorials</h4>
                            <p class="afrisol-text-muted">Installation guides and maintenance tips</p>
                            <a href="#" class="afrisol-btn afrisol-btn-secondary afrisol-btn-sm">
                                <i class="fas fa-play"></i> Watch
                            </a>
                        </div>
                    </div>
                    <div class="afrisol-card">
                        <div class="afrisol-card-body afrisol-text-center">
                            <i class="fas fa-battery-full" style="font-size: 2.5rem; color: var(--afrisol-primary); margin-bottom: 15px;"></i>
                            <h4>Battery Guide</h4>
                            <p class="afrisol-text-muted">Understanding Lithium vs Tubular Batteries</p>
                            <a href="#" class="afrisol-btn afrisol-btn-secondary afrisol-btn-sm">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <?php if ($posts->max_num_pages > 1): ?>
                <div class="afrisol-pagination">
                    <?php for ($i = 1; $i <= $posts->max_num_pages; $i++): ?>
                        <a href="<?php echo esc_url(add_query_arg('paged', $i)); ?>" class="afrisol-pagination-btn <?php echo $i == get_query_var('paged', 1) ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
    <?php echo do_shortcode('[afrisol_whatsapp]'); ?>
</div>
