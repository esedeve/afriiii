<?php
/**
 * Quote Thank You Page Template
 */
if (!defined('ABSPATH')) exit;
$confirmation = isset($_GET['confirmation']) ? sanitize_text_field($_GET['confirmation']) : 'AFR-XXXXXXXX';
$settings = get_option('afrisol_settings', array());
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-section" style="padding-top: 120px;">
        <div class="afrisol-container afrisol-container-sm">
            <div class="afrisol-thank-you afrisol-fade-in">
                <div class="afrisol-thank-you-icon">
                    <i class="fas fa-check"></i>
                </div>
                
                <h1>Thank You!</h1>
                <p class="afrisol-text-muted">Your quote request has been submitted successfully.</p>
                
                <div class="afrisol-confirmation-number">
                    <label>Confirmation Number</label>
                    <code><?php echo esc_html($confirmation); ?></code>
                </div>
                
                <div class="afrisol-card afrisol-mt-4">
                    <div class="afrisol-card-body">
                        <h4><i class="fas fa-clock" style="color: var(--afrisol-primary);"></i> What Happens Next?</h4>
                        <ul style="text-align: left; list-style: none; padding: 0;">
                            <li style="padding: 10px 0; border-bottom: 1px solid var(--afrisol-glass-border);">
                                <i class="fas fa-check-circle" style="color: var(--afrisol-success); margin-right: 10px;"></i>
                                Our team will review your request within 24 hours
                            </li>
                            <li style="padding: 10px 0; border-bottom: 1px solid var(--afrisol-glass-border);">
                                <i class="fas fa-phone" style="color: var(--afrisol-primary); margin-right: 10px;"></i>
                                A specialist will contact you to discuss your needs
                            </li>
                            <li style="padding: 10px 0; border-bottom: 1px solid var(--afrisol-glass-border);">
                                <i class="fas fa-file-alt" style="color: var(--afrisol-primary); margin-right: 10px;"></i>
                                You'll receive a detailed quote via email
                            </li>
                            <li style="padding: 10px 0;">
                                <i class="fas fa-calendar-check" style="color: var(--afrisol-primary); margin-right: 10px;"></i>
                                Schedule a site visit if needed
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="afrisol-flex-center afrisol-gap-md afrisol-mt-4" style="flex-wrap: wrap;">
                    <a href="#" class="afrisol-btn afrisol-btn-secondary">
                        <i class="fas fa-download"></i> Download Brochure
                    </a>
                    <a href="<?php echo esc_url(home_url('/afrisol-home/')); ?>" class="afrisol-btn afrisol-btn-primary">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                </div>
                
                <div class="afrisol-mt-5">
                    <h4>Follow Us</h4>
                    <div class="afrisol-social-links" style="justify-content: center;">
                        <?php if (!empty($settings['facebook'])): ?>
                            <a href="<?php echo esc_url($settings['facebook']); ?>" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($settings['instagram'])): ?>
                            <a href="<?php echo esc_url($settings['instagram']); ?>" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($settings['tiktok'])): ?>
                            <a href="<?php echo esc_url($settings['tiktok']); ?>" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
    <?php echo do_shortcode('[afrisol_whatsapp]'); ?>
</div>
