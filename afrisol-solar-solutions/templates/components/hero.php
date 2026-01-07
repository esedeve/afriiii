<?php
/**
 * Hero Section Component
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$hero_heading = isset($settings['hero_heading']) ? $settings['hero_heading'] : 'Solar Solutions for a Sustainable Africa';
$hero_subheading = isset($settings['hero_subheading']) ? $settings['hero_subheading'] : 'Empowering homes and businesses with clean, affordable solar energy. Quality installations, expert maintenance, and innovative solar mobility solutions.';
$hero_image = isset($settings['hero_image']) ? $settings['hero_image'] : '';
?>
<section class="afrisol-hero afrisol-section-lg" id="hero">
    <div class="afrisol-container">
        <div class="afrisol-hero-inner">
            <div class="afrisol-hero-content afrisol-fade-in">
                <div class="afrisol-hero-badge">
                    <i class="fas fa-globe-africa"></i>
                    <span>#1 Solar Solutions in Africa</span>
                </div>
                
                <h1><?php echo esc_html($hero_heading); ?></h1>
                <p><?php echo esc_html($hero_subheading); ?></p>
                
                <div class="afrisol-hero-buttons">
                    <a href="<?php echo esc_url(home_url('/afrisol-quote/')); ?>" class="afrisol-btn afrisol-btn-primary">
                        <i class="fas fa-bolt"></i> Get Free Quote
                    </a>
                    <a href="<?php echo esc_url(home_url('/afrisol-products/')); ?>" class="afrisol-btn afrisol-btn-secondary">
                        <i class="fas fa-solar-panel"></i> Shop Products
                    </a>
                </div>
            </div>
            
            <div class="afrisol-hero-image afrisol-fade-in">
                <div class="afrisol-hero-image-wrapper">
                    <?php if ($hero_image): ?>
                        <img src="<?php echo esc_url($hero_image); ?>" alt="Solar Solutions">
                    <?php else: ?>
                        <div class="afrisol-image-placeholder">
                            <i class="fas fa-image"></i>
                            <span>Hero Image Placeholder</span>
                            <small>(Admin uploads via frontend)</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
