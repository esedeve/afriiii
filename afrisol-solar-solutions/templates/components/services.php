<?php
/**
 * Services Section Component
 */
if (!defined('ABSPATH')) exit;

$services = array(
    array(
        'icon' => 'fas fa-sun',
        'title' => 'Solar Energy Solutions',
        'description' => 'Premium solar panels, inverters, and batteries for residential and commercial installations.',
    ),
    array(
        'icon' => 'fas fa-shield-alt',
        'title' => 'Security & Surveillance',
        'description' => 'Advanced CCTV systems, AI cameras, and access control solutions for complete protection.',
    ),
    array(
        'icon' => 'fas fa-motorcycle',
        'title' => 'Solar Mobility',
        'description' => 'Electric scooters, bikes, tricycles, and vehicles powered by clean solar energy.',
    ),
);
?>
<section class="afrisol-section" id="services">
    <div class="afrisol-container">
        <div class="afrisol-section-header afrisol-fade-in">
            <h2>Our Services</h2>
            <p>Comprehensive solar and security solutions for every need</p>
        </div>
        
        <div class="afrisol-grid afrisol-grid-3">
            <?php foreach ($services as $service): ?>
                <div class="afrisol-service-card afrisol-fade-in">
                    <div class="afrisol-service-icon">
                        <i class="<?php echo esc_attr($service['icon']); ?>"></i>
                    </div>
                    <h3><?php echo esc_html($service['title']); ?></h3>
                    <p><?php echo esc_html($service['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="afrisol-text-center afrisol-mt-5">
            <a href="<?php echo esc_url(home_url('/afrisol-services/')); ?>" class="afrisol-btn afrisol-btn-primary">
                <i class="fas fa-arrow-right"></i> View All Services
            </a>
        </div>
    </div>
</section>
