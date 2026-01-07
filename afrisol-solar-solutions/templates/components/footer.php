<?php
/**
 * Footer Component
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$company_name = isset($settings['company_name']) ? $settings['company_name'] : 'Afrisol';
$tagline = isset($settings['tagline']) ? $settings['tagline'] : 'Solar Solutions for a Sustainable Africa';
$address = isset($settings['address']) ? $settings['address'] : 'Suite 15C, Al-Noor Shopping Complex, Wuse 2, Abuja.';
$phone = isset($settings['phone']) && $settings['phone'] !== '+234 XXX XXX XXXX' ? $settings['phone'] : '+234 803 221 2827';
$email = isset($settings['email']) ? $settings['email'] : 'info@afrisol.com';
$facebook = isset($settings['facebook']) ? $settings['facebook'] : '#';
$instagram = isset($settings['instagram']) ? $settings['instagram'] : '#';
$tiktok = isset($settings['tiktok']) ? $settings['tiktok'] : '#';
$logo_url = isset($settings['logo']) && !empty($settings['logo']) ? $settings['logo'] : AFRISOL_PLUGIN_URL . 'assets/images/afrisol-logo.webp';
?>
<footer class="afrisol-footer">
    <div class="afrisol-container">
        <div class="afrisol-footer-grid">
            <div class="afrisol-footer-brand">
                <a href="<?php echo esc_url(home_url('/afrisol-home/')); ?>" class="afrisol-logo">
                    <div class="afrisol-logo-icon">
                        <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($company_name); ?>">
                    </div>
                    <span class="afrisol-logo-text"><?php echo esc_html(strtoupper($company_name)); ?></span>
                </a>
                <p><?php echo esc_html($tagline); ?></p>
                
                <div class="afrisol-social-links">
                    <?php if ($facebook && $facebook !== '#'): ?>
                        <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    <?php endif; ?>
                    <?php if ($instagram && $instagram !== '#'): ?>
                        <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    <?php endif; ?>
                    <?php if ($tiktok && $tiktok !== '#'): ?>
                        <a href="<?php echo esc_url($tiktok); ?>" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="afrisol-footer-links">
                <h4>Quick Links</h4>
                <a href="<?php echo esc_url(home_url('/afrisol-home/')); ?>">Home</a>
                <a href="<?php echo esc_url(home_url('/afrisol-products/')); ?>">Products</a>
                <a href="<?php echo esc_url(home_url('/afrisol-services/')); ?>">Services</a>
                <a href="<?php echo esc_url(home_url('/afrisol-calculator/')); ?>">Solar Calculator</a>
                <a href="<?php echo esc_url(home_url('/afrisol-about/')); ?>">About Us</a>
                <a href="<?php echo esc_url(home_url('/afrisol-blog/')); ?>">Blog</a>
            </div>
            
            <div class="afrisol-footer-links">
                <h4>Services</h4>
                <a href="<?php echo esc_url(home_url('/afrisol-services/')); ?>">Solar Installation</a>
                <a href="<?php echo esc_url(home_url('/afrisol-repair/')); ?>">Repair Services</a>
                <a href="<?php echo esc_url(home_url('/afrisol-quote/')); ?>">Get a Quote</a>
                <a href="<?php echo esc_url(home_url('/afrisol-services/')); ?>">Security Systems</a>
                <a href="<?php echo esc_url(home_url('/afrisol-services/')); ?>">Solar Mobility</a>
            </div>
            
            <div class="afrisol-footer-contact">
                <h4>Contact Info</h4>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($address); ?></p>
                <p>
                    <i class="fas fa-phone"></i> 
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>">
                        <?php echo esc_html($phone); ?>
                    </a>
                </p>
                <p>
                    <i class="fas fa-envelope"></i> 
                    <a href="mailto:<?php echo esc_attr($email); ?>">
                        <?php echo esc_html($email); ?>
                    </a>
                </p>
            </div>
        </div>
        
        <div class="afrisol-footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html($company_name); ?>. All rights reserved. | Powered by Clean Energy</p>
        </div>
    </div>
</footer>
