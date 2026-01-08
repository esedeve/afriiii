<?php
/**
 * Contact Page Template
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$address = isset($settings['address']) ? $settings['address'] : 'Suite 15C, Al-Noor Shopping Complex, Al-Noor Mosque, Ahmadu Bello Way Wuse 2, Abuja.';
$phone = isset($settings['phone']) ? $settings['phone'] : '+234 XXX XXX XXXX';
$email = isset($settings['email']) ? $settings['email'] : 'info@afrisol.com';
$whatsapp = isset($settings['whatsapp']) ? $settings['whatsapp'] : '';
$business_hours = isset($settings['business_hours']) ? $settings['business_hours'] : "Mon - Fri: 8:00 AM - 6:00 PM\nSat: 9:00 AM - 4:00 PM\nSun: Closed";

$faqs = array(
    array('q' => 'What areas do you serve?', 'a' => 'We serve all major cities across Nigeria including Abuja, Lagos, Port Harcourt, Kano, and more. Contact us to confirm service availability in your area.'),
    array('q' => 'How long does installation take?', 'a' => 'Residential installations typically take 1-3 days, while commercial projects may take 1-2 weeks depending on the system size.'),
    array('q' => 'Do you offer financing options?', 'a' => 'Yes, we partner with various financial institutions to offer flexible payment plans. Contact us for more details.'),
    array('q' => 'What warranty do you provide?', 'a' => 'Our solar panels come with 25-year warranties, inverters with 5-10 year warranties, and batteries with 5-10 year warranties depending on the type.'),
    array('q' => 'Do you provide maintenance services?', 'a' => 'Yes, we offer comprehensive maintenance packages to ensure your system operates at peak efficiency.'),
);
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-section" style="padding-top: 120px;">
        <div class="afrisol-container">
            <div class="afrisol-section-header afrisol-fade-in">
                <h1>Contact Us</h1>
                <p>Get in touch with our team for inquiries, support, or partnership opportunities</p>
            </div>
            
            <div class="afrisol-contact-layout">
                <!-- Contact Info -->
                <div class="afrisol-contact-info afrisol-fade-in">
                    <div class="afrisol-contact-card">
                        <div class="afrisol-contact-card-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4>Visit Us</h4>
                            <p><?php echo esc_html($address); ?></p>
                        </div>
                    </div>
                    
                    <div class="afrisol-contact-card">
                        <div class="afrisol-contact-card-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h4>Call Us</h4>
                            <p><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></p>
                        </div>
                    </div>
                    
                    <?php if ($whatsapp): ?>
                        <div class="afrisol-contact-card">
                            <div class="afrisol-contact-card-icon" style="background: #25D366;">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <h4>WhatsApp</h4>
                                <p><a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>" target="_blank" rel="noopener noreferrer">Chat with us</a></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="afrisol-contact-card">
                        <div class="afrisol-contact-card-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h4>Email Us</h4>
                            <p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
                        </div>
                    </div>
                    
                    <div class="afrisol-contact-card">
                        <div class="afrisol-contact-card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h4>Business Hours</h4>
                            <p><?php echo nl2br(esc_html($business_hours)); ?></p>
                        </div>
                    </div>
                    
                    <!-- Map -->
                    <div class="afrisol-map-wrapper afrisol-mt-3" style="height: 250px;">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.1234567890123!2d7.4892!3d9.0643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sAl-Noor%20Shopping%20Complex!5e0!3m2!1sen!2sng!4v1234567890"
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Afrisol Location">
                        </iframe>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="afrisol-contact-form-wrapper afrisol-fade-in">
                    <form class="afrisol-form afrisol-contact-form" id="contact-page-form">
                        <input type="hidden" name="type" value="contact">
                        
                        <div class="afrisol-form-row">
                            <div class="afrisol-form-group">
                                <label for="cp-name"><i class="fas fa-user"></i> Full Name <span class="required">*</span></label>
                                <input type="text" id="cp-name" name="name" placeholder="Your full name" required>
                            </div>
                            
                            <div class="afrisol-form-group">
                                <label for="cp-email"><i class="fas fa-envelope"></i> Email <span class="required">*</span></label>
                                <input type="email" id="cp-email" name="email" placeholder="Your email" required>
                            </div>
                        </div>
                        
                        <div class="afrisol-form-row">
                            <div class="afrisol-form-group">
                                <label for="cp-phone"><i class="fas fa-phone"></i> Phone</label>
                                <input type="tel" id="cp-phone" name="phone" placeholder="Your phone number">
                            </div>
                            
                            <div class="afrisol-form-group">
                                <label for="cp-subject"><i class="fas fa-tag"></i> Subject</label>
                                <select id="cp-subject" name="subject">
                                    <option value="">Select subject</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                    <option value="Sales">Sales</option>
                                    <option value="Technical Support">Technical Support</option>
                                    <option value="Partnership">Partnership</option>
                                    <option value="Careers">Careers</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label for="cp-message"><i class="fas fa-comment-alt"></i> Message <span class="required">*</span></label>
                            <textarea id="cp-message" name="message" rows="5" placeholder="How can we help you?" required></textarea>
                        </div>
                        
                        <button type="submit" class="afrisol-btn afrisol-btn-primary afrisol-btn-block">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- FAQs -->
            <div class="afrisol-section afrisol-fade-in">
                <div class="afrisol-section-header">
                    <h2>Frequently Asked Questions</h2>
                </div>
                
                <div class="afrisol-accordion" style="max-width: 800px; margin: 0 auto;">
                    <?php foreach ($faqs as $index => $faq): ?>
                        <div class="afrisol-accordion-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="afrisol-accordion-header">
                                <h4><?php echo esc_html($faq['q']); ?></h4>
                                <i class="fas fa-chevron-down afrisol-accordion-icon"></i>
                            </div>
                            <div class="afrisol-accordion-content">
                                <div class="afrisol-accordion-body">
                                    <p><?php echo esc_html($faq['a']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
    <?php echo do_shortcode('[afrisol_whatsapp]'); ?>
</div>
