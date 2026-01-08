<?php
/**
 * Services Page Template
 */
if (!defined('ABSPATH')) exit;

$service_categories = array(
    'installation' => array(
        'title' => 'Installation Services',
        'icon' => 'fas fa-tools',
        'services' => array(
            'Residential Solar Installation',
            'Commercial/Industrial Installation',
            'Security System Installation',
            'Network Setup',
        ),
    ),
    'repair' => array(
        'title' => 'Repair & Maintenance',
        'icon' => 'fas fa-wrench',
        'services' => array(
            'Solar Panel Repair',
            'Inverter Repair',
            'Battery Replacement',
            'CCTV Maintenance',
            'Electric Vehicle Servicing',
        ),
    ),
);
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-section" style="padding-top: 120px;">
        <div class="afrisol-container">
            <div class="afrisol-section-header afrisol-fade-in">
                <h1>Our Services</h1>
                <p>Professional installation, maintenance, and repair services for all your solar and security needs</p>
            </div>
            
            <!-- Service Categories -->
            <div class="afrisol-services-categories">
                <?php foreach ($service_categories as $key => $category): ?>
                    <div class="afrisol-service-category afrisol-fade-in">
                        <h3>
                            <i class="<?php echo esc_attr($category['icon']); ?>"></i>
                            <?php echo esc_html($category['title']); ?>
                        </h3>
                        <ul class="afrisol-service-list">
                            <?php foreach ($category['services'] as $service): ?>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <?php echo esc_html($service); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="<?php echo esc_url(home_url('/afrisol-quote/')); ?>" class="afrisol-btn afrisol-btn-primary afrisol-btn-sm afrisol-mt-3">
                            <i class="fas fa-file-alt"></i> Get Quote
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Service Process -->
            <div class="afrisol-section afrisol-fade-in">
                <div class="afrisol-section-header">
                    <h2>Our Process</h2>
                    <p>How we deliver excellence at every step</p>
                </div>
                
                <div class="afrisol-grid afrisol-grid-4">
                    <?php
                    $steps = array(
                        array('icon' => 'fas fa-comments', 'title' => 'Consultation', 'desc' => 'Free assessment of your energy needs'),
                        array('icon' => 'fas fa-clipboard-list', 'title' => 'Custom Quote', 'desc' => 'Detailed proposal tailored to you'),
                        array('icon' => 'fas fa-hard-hat', 'title' => 'Installation', 'desc' => 'Professional installation by experts'),
                        array('icon' => 'fas fa-headset', 'title' => 'Support', 'desc' => '24/7 maintenance and support'),
                    );
                    foreach ($steps as $index => $step): ?>
                        <div class="afrisol-card afrisol-text-center">
                            <div class="afrisol-service-icon" style="margin: 0 auto 20px;">
                                <i class="<?php echo esc_attr($step['icon']); ?>"></i>
                            </div>
                            <h4><?php echo esc_html($step['title']); ?></h4>
                            <p><?php echo esc_html($step['desc']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Service Guarantee -->
            <div class="afrisol-card afrisol-mt-5 afrisol-fade-in">
                <div class="afrisol-card-body afrisol-text-center">
                    <h3><i class="fas fa-shield-alt" style="color: var(--afrisol-primary);"></i> Service Guarantee</h3>
                    <p>All our installations come with a comprehensive warranty and satisfaction guarantee. Our certified technicians ensure quality workmanship, and we stand behind every project we complete.</p>
                    <div class="afrisol-flex-center afrisol-gap-lg afrisol-mt-3" style="flex-wrap: wrap;">
                        <span class="afrisol-badge"><i class="fas fa-certificate"></i> Certified Installers</span>
                        <span class="afrisol-badge"><i class="fas fa-clock"></i> On-Time Completion</span>
                        <span class="afrisol-badge"><i class="fas fa-thumbs-up"></i> Satisfaction Guaranteed</span>
                    </div>
                </div>
            </div>
            
            <!-- CTA -->
            <div class="afrisol-text-center afrisol-mt-5 afrisol-fade-in">
                <h3>Ready to Get Started?</h3>
                <p class="afrisol-text-muted">Contact us today for a free consultation</p>
                <div class="afrisol-flex-center afrisol-gap-md afrisol-mt-3">
                    <a href="<?php echo esc_url(home_url('/afrisol-quote/')); ?>" class="afrisol-btn afrisol-btn-primary">
                        <i class="fas fa-file-alt"></i> Request Quote
                    </a>
                    <a href="<?php echo esc_url(home_url('/afrisol-repair/')); ?>" class="afrisol-btn afrisol-btn-secondary">
                        <i class="fas fa-tools"></i> Request Repair
                    </a>
                </div>
            </div>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
    <?php echo do_shortcode('[afrisol_whatsapp]'); ?>
</div>
