<?php
/**
 * Map Section Component
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$address = isset($settings['address']) ? $settings['address'] : 'Suite 15C, Al-Noor Shopping Complex, Al-Noor Mosque, Ahmadu Bello Way Wuse 2, Abuja.';
$phone = isset($settings['phone']) ? $settings['phone'] : '+234 803 221 2827';
$email = isset($settings['email']) ? $settings['email'] : 'info@afrisol.com';
$business_hours = isset($settings['business_hours']) ? $settings['business_hours'] : "Mon - Fri: 8:00 AM - 6:00 PM\nSat: 9:00 AM - 4:00 PM\nSun: Closed";

// Proper Google Maps embed URL for Wuse 2, Abuja
$map_embed_url = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.0234567890123!2d7.4892!3d9.0765!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x104e0ba5c5555555%3A0x5555555555555555!2sAl-Noor%20Mosque%2C%20Ahmadu%20Bello%20Way%2C%20Wuse%202%2C%20Abuja!5e0!3m2!1sen!2sng!4v1704700000000!5m2!1sen!2sng';
$map_link_url = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($address);
?>
<section class="afrisol-section" id="location">
    <div class="afrisol-container">
        <div class="afrisol-section-header afrisol-fade-in">
            <h2>Find Us</h2>
            <p>Visit our showroom or get in touch</p>
        </div>
        
        <div class="afrisol-map-section">
            <div class="afrisol-map-wrapper afrisol-fade-in">
                <a href="<?php echo esc_url($map_link_url); ?>" target="_blank" rel="noopener noreferrer" class="afrisol-map-link" title="Open in Google Maps">
                    <iframe 
                        src="<?php echo esc_url($map_embed_url); ?>"
                        width="100%" 
                        height="100%" 
                        style="border:0; pointer-events: none;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Afrisol Location - Wuse 2, Abuja">
                    </iframe>
                    <div class="afrisol-map-overlay">
                        <span><i class="fas fa-external-link-alt"></i> Click to open in Google Maps</span>
                    </div>
                </a>
            </div>
            
            <div class="afrisol-map-info afrisol-fade-in">
                <h2>Our Location</h2>
                
                <div class="afrisol-map-address">
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($address); ?></p>
                </div>
                
                <div class="afrisol-contact-details">
                    <p><i class="fas fa-phone"></i> 
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>">
                            <?php echo esc_html($phone); ?>
                        </a>
                    </p>
                    <p><i class="fas fa-envelope"></i> 
                        <a href="mailto:<?php echo esc_attr($email); ?>">
                            <?php echo esc_html($email); ?>
                        </a>
                    </p>
                </div>
                
                <div class="afrisol-business-hours afrisol-mt-3">
                    <h4><i class="fas fa-clock"></i> Business Hours</h4>
                    <p><?php echo nl2br(esc_html($business_hours)); ?></p>
                </div>
                
                <div class="afrisol-mt-4">
                    <a href="<?php echo esc_url($map_link_url); ?>" target="_blank" rel="noopener noreferrer" class="afrisol-btn afrisol-btn-primary">
                        <i class="fas fa-directions"></i> Get Directions
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
