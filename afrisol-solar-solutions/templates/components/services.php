<?php
/**
 * Services Section Component
 */
if (!defined('ABSPATH')) exit;

$services = array(
    array(
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M361.5 1.2c5 2.1 8.6 6.6 9.6 11.9L391 121l107.9 19.8c5.3 1 9.8 4.6 11.9 9.6s1.5 10.7-1.6 15.2L446.9 256l62.3 90.3c3.1 4.5 3.7 10.2 1.6 15.2s-6.6 8.6-11.9 9.6L391 391 371.1 498.9c-1 5.3-4.6 9.8-9.6 11.9s-10.7 1.5-15.2-1.6L256 446.9l-90.3 62.3c-4.5 3.1-10.2 3.7-15.2 1.6s-8.6-6.6-9.6-11.9L121 391 13.1 371.1c-5.3-1-9.8-4.6-11.9-9.6s-1.5-10.7 1.6-15.2L65.1 256 2.8 165.7c-3.1-4.5-3.7-10.2-1.6-15.2s6.6-8.6 11.9-9.6L121 121 140.9 13.1c1-5.3 4.6-9.8 9.6-11.9s10.7-1.5 15.2 1.6L256 65.1 346.3 2.8c4.5-3.1 10.2-3.7 15.2-1.6zM160 256a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zm224 0a128 128 0 1 0 -256 0 128 128 0 1 0 256 0z"/></svg>',
        'title' => 'Solar Energy Solutions',
        'description' => 'Premium solar panels, inverters, and batteries for residential and commercial installations.',
    ),
    array(
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0zm0 66.8l0 378.1C394 378 431.1 230.1 432 141.4L256 66.8s0 0 0 0z"/></svg>',
        'title' => 'Security & Surveillance',
        'description' => 'Advanced CCTV systems, AI cameras, and access control solutions for complete protection.',
    ),
    array(
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M280 32c-13.3 0-24 10.7-24 24s10.7 24 24 24l57.7 0 16.4 30.3L256 192l-45.3-45.3c-12-12-28.3-18.7-45.3-18.7L64 128c-17.7 0-32 14.3-32 32l0 32 96 0c88.4 0 160 71.6 160 160c0 11-1.1 21.7-3.2 32l70.4 0c-2.1-10.3-3.2-21-3.2-32c0-52.2 25-98.6 63.7-127.8l15.4 28.6C402.4 276.3 384 312.7 384 352c0 70.7 57.3 128 128 128s128-57.3 128-128s-57.3-128-128-128c-13.5 0-26.5 2.1-38.7 6L375.4 48.9C369.8 38.4 359 32 347.2 32L280 32zM512 304a48 48 0 1 1 0 96 48 48 0 1 1 0-96zM128 176a80 80 0 1 1 0 160 80 80 0 1 1 0-160zm0 208a128 128 0 1 0 0-256 128 128 0 1 0 0 256zm0-112a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/></svg>',
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
                        <?php echo $service['icon']; ?>
                    </div>
                    <h3><?php echo esc_html($service['title']); ?></h3>
                    <p><?php echo esc_html($service['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="afrisol-text-center afrisol-mt-5">
            <a href="<?php echo esc_url(home_url('/afrisol-services/')); ?>" class="afrisol-btn afrisol-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="14" height="14" style="margin-right: 8px;"><path fill="currentColor" d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/></svg>
                View All Services
            </a>
        </div>
    </div>
</section>
