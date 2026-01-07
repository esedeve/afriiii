<?php
/**
 * Why Choose Section Component
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$why_image = isset($settings['why_choose_image']) ? $settings['why_choose_image'] : '';

$features = array(
    array('icon' => 'fas fa-award', 'text' => 'Certified Installers'),
    array('icon' => 'fas fa-clock', 'text' => '24/7 Support'),
    array('icon' => 'fas fa-tools', 'text' => 'Expert Maintenance'),
    array('icon' => 'fas fa-shield-alt', 'text' => 'Quality Guarantee'),
    array('icon' => 'fas fa-truck', 'text' => 'Nationwide Delivery'),
    array('icon' => 'fas fa-leaf', 'text' => 'Eco-Friendly Solutions'),
);
?>
<section class="afrisol-section" id="why-choose">
    <div class="afrisol-container">
        <div class="afrisol-why-choose">
            <div class="afrisol-why-image afrisol-fade-in">
                <div class="afrisol-why-image-wrapper">
                    <?php if ($why_image): ?>
                        <img src="<?php echo esc_url($why_image); ?>" alt="Why Choose Afrisol">
                    <?php else: ?>
                        <div class="afrisol-image-placeholder">
                            <i class="fas fa-image"></i>
                            <span>Image Placeholder</span>
                            <small>(Admin uploads via frontend)</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="afrisol-why-content afrisol-fade-in">
                <h2>Why Choose Afrisol?</h2>
                <p>With over a decade of experience in renewable energy solutions, Afrisol has become the trusted partner for thousands of homes and businesses across Africa. We combine cutting-edge technology with local expertise to deliver sustainable energy solutions that power progress.</p>
                <p>Our commitment to quality, customer satisfaction, and environmental sustainability sets us apart as the leading provider of solar and security solutions in the region.</p>
                
                <div class="afrisol-why-features">
                    <?php foreach ($features as $feature): ?>
                        <div class="afrisol-why-feature">
                            <div class="afrisol-why-feature-icon">
                                <i class="<?php echo esc_attr($feature['icon']); ?>"></i>
                            </div>
                            <span><?php echo esc_html($feature['text']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="afrisol-mt-4">
                    <a href="<?php echo esc_url(home_url('/afrisol-about/')); ?>" class="afrisol-btn afrisol-btn-primary">
                        <i class="fas fa-info-circle"></i> Learn More About Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
