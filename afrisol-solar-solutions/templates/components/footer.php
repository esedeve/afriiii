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
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="16" height="16"><path fill="currentColor" d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if ($instagram && $instagram !== '#'): ?>
                        <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if ($tiktok && $tiktok !== '#'): ?>
                        <a href="<?php echo esc_url($tiktok); ?>" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16"><path fill="currentColor" d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z"/></svg>
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
                <p>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14" style="flex-shrink: 0;"><path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
                    <span><?php echo esc_html($address); ?></span>
                </p>
                <p>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="14" height="14" style="flex-shrink: 0;"><path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>">
                        <?php echo esc_html($phone); ?>
                    </a>
                </p>
                <p>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="14" height="14" style="flex-shrink: 0;"><path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
                    <a href="mailto:<?php echo esc_attr($email); ?>">
                        <?php echo esc_html($email); ?>
                    </a>
                </p>
            </div>
        </div>
        
        <div class="afrisol-footer-bottom">
            <p>&copy; <?php echo esc_html(gmdate('Y')); ?> <?php echo esc_html($company_name); ?>. All rights reserved. | Powered by Clean Energy</p>
        </div>
    </div>
</footer>
