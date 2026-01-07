<?php
/**
 * Testimonials Section Component
 */
if (!defined('ABSPATH')) exit;

$testimonials = get_posts(array(
    'post_type' => 'afrisol_testimonial',
    'posts_per_page' => 3,
));

if (empty($testimonials)) {
    $testimonials = array(
        (object) array(
            'post_title' => 'Adaeze Okonkwo',
            'post_content' => 'Afrisol transformed our home with their solar installation. We now enjoy 24/7 power and have significantly reduced our electricity bills. The team was professional and completed the work on time.',
            'ID' => 0,
        ),
        (object) array(
            'post_title' => 'Ibrahim Musa',
            'post_content' => 'Professional service from start to finish. Their team was knowledgeable and completed the installation ahead of schedule. Highly recommend Afrisol for anyone looking to go solar.',
            'ID' => 0,
        ),
        (object) array(
            'post_title' => 'Chioma Eze',
            'post_content' => 'Great products and excellent customer support. The solar calculator helped me choose the perfect system for my business. Very satisfied with my purchase.',
            'ID' => 0,
        ),
    );
}
?>
<section class="afrisol-section" id="testimonials">
    <div class="afrisol-container">
        <div class="afrisol-section-header afrisol-fade-in">
            <span class="afrisol-badge"><i class="fab fa-google"></i> Google Reviews</span>
            <h2>What Our Customers Say</h2>
            <p>Real experiences from our valued customers</p>
        </div>
        
        <div class="afrisol-grid afrisol-grid-3">
            <?php foreach ($testimonials as $testimonial): 
                $rating = $testimonial->ID ? get_post_meta($testimonial->ID, '_afrisol_rating', true) : 5;
                $location = $testimonial->ID ? get_post_meta($testimonial->ID, '_afrisol_location', true) : 'Nigeria';
                $content = $testimonial->ID ? $testimonial->post_content : $testimonial->post_content;
                $name = $testimonial->post_title;
                $initials = implode('', array_map(function($word) { return strtoupper(substr($word, 0, 1)); }, explode(' ', $name)));
            ?>
                <div class="afrisol-testimonial-card afrisol-fade-in">
                    <div class="afrisol-testimonial-stars">
                        <div class="afrisol-stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= $rating): ?>
                                    <i class="fas fa-star"></i>
                                <?php else: ?>
                                    <i class="far fa-star"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                    
                    <p class="afrisol-testimonial-text">"<?php echo esc_html($content); ?>"</p>
                    
                    <div class="afrisol-testimonial-author">
                        <div class="afrisol-testimonial-avatar">
                            <?php echo esc_html($initials); ?>
                        </div>
                        <div>
                            <div class="afrisol-testimonial-name"><?php echo esc_html($name); ?></div>
                            <div class="afrisol-testimonial-location">
                                <i class="fas fa-map-marker-alt"></i> <?php echo esc_html($location ?: 'Nigeria'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
