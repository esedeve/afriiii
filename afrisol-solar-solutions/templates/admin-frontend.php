<?php
/**
 * Admin Frontend Page Template
 */
if (!defined('ABSPATH')) exit;

if (!current_user_can('manage_options')) {
    wp_redirect(home_url('/afrisol-home/'));
    exit;
}

$settings = get_option('afrisol_settings', array());
$tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-admin-frontend" style="padding-top: 120px;">
        <div class="afrisol-container">
            <div class="afrisol-section-header afrisol-fade-in">
                <h1><i class="fas fa-cog"></i> Site Settings</h1>
                <p>Manage your website content and settings from here</p>
            </div>
            
            <div class="afrisol-portal-layout">
                <!-- Sidebar -->
                <aside class="afrisol-portal-sidebar afrisol-fade-in">
                    <nav class="afrisol-portal-menu">
                        <a href="?tab=general" <?php echo $tab === 'general' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-sliders-h"></i> General Settings
                        </a>
                        <a href="?tab=images" <?php echo $tab === 'images' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-images"></i> Site Images
                        </a>
                        <a href="?tab=content" <?php echo $tab === 'content' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-edit"></i> Content
                        </a>
                        <a href="?tab=contact" <?php echo $tab === 'contact' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-address-book"></i> Contact Info
                        </a>
                        <a href="?tab=social" <?php echo $tab === 'social' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-share-alt"></i> Social Media
                        </a>
                        <a href="?tab=payments" <?php echo $tab === 'payments' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-credit-card"></i> Payment Settings
                        </a>
                        <a href="<?php echo esc_url(admin_url()); ?>">
                            <i class="fas fa-external-link-alt"></i> WP Admin
                        </a>
                    </nav>
                </aside>
                
                <!-- Content -->
                <div class="afrisol-portal-content afrisol-fade-in">
                    <form id="admin-settings-form" enctype="multipart/form-data">
                        
                        <?php if ($tab === 'general'): ?>
                            <div class="afrisol-card">
                                <div class="afrisol-card-header"><h3>General Settings</h3></div>
                                <div class="afrisol-card-body">
                                    <div class="afrisol-form-group">
                                        <label for="company_name"><i class="fas fa-building"></i> Company Name</label>
                                        <input type="text" id="company_name" name="company_name" value="<?php echo esc_attr($settings['company_name'] ?? 'Afrisol'); ?>">
                                    </div>
                                    
                                    <div class="afrisol-form-group">
                                        <label for="tagline"><i class="fas fa-quote-left"></i> Tagline</label>
                                        <input type="text" id="tagline" name="tagline" value="<?php echo esc_attr($settings['tagline'] ?? 'Solar Solutions for a Sustainable Africa'); ?>">
                                    </div>
                                    
                                    <div class="afrisol-form-row">
                                        <div class="afrisol-form-group">
                                            <label for="currency"><i class="fas fa-money-bill"></i> Currency</label>
                                            <select id="currency" name="currency">
                                                <option value="NGN" <?php selected($settings['currency'] ?? '', 'NGN'); ?>>Nigerian Naira (NGN)</option>
                                                <option value="USD" <?php selected($settings['currency'] ?? '', 'USD'); ?>>US Dollar (USD)</option>
                                            </select>
                                        </div>
                                        <div class="afrisol-form-group">
                                            <label for="currency_symbol"><i class="fas fa-dollar-sign"></i> Currency Symbol</label>
                                            <input type="text" id="currency_symbol" name="currency_symbol" value="<?php echo esc_attr($settings['currency_symbol'] ?? '₦'); ?>" style="width: 80px;">
                                        </div>
                                    </div>
                                    
                                    <div class="afrisol-form-group">
                                        <label class="afrisol-checkbox">
                                            <input type="checkbox" name="enable_pwa" <?php checked($settings['enable_pwa'] ?? true); ?>>
                                            <span class="afrisol-checkbox-mark"></span>
                                            Enable PWA (Install App Prompt)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        
                        <?php elseif ($tab === 'images'): ?>
                            <div class="afrisol-admin-grid">
                                <div class="afrisol-admin-card">
                                    <h3><i class="fas fa-image"></i> Logo</h3>
                                    <div class="afrisol-image-upload-zone" data-target="logo">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p>Upload Logo</p>
                                        <input type="file" name="logo" accept="image/*" style="display: none;">
                                    </div>
                                    <?php if (!empty($settings['logo'])): ?>
                                        <div class="afrisol-image-preview">
                                            <img src="<?php echo esc_url($settings['logo']); ?>" alt="Logo">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="afrisol-admin-card">
                                    <h3><i class="fas fa-image"></i> Hero Image</h3>
                                    <div class="afrisol-image-upload-zone" data-target="hero_image">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p>Upload Hero Image</p>
                                        <input type="file" name="hero_image" accept="image/*" style="display: none;">
                                    </div>
                                    <?php if (!empty($settings['hero_image'])): ?>
                                        <div class="afrisol-image-preview">
                                            <img src="<?php echo esc_url($settings['hero_image']); ?>" alt="Hero">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="afrisol-admin-card">
                                    <h3><i class="fas fa-image"></i> Why Choose Image</h3>
                                    <div class="afrisol-image-upload-zone" data-target="why_choose_image">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p>Upload Image</p>
                                        <input type="file" name="why_choose_image" accept="image/*" style="display: none;">
                                    </div>
                                    <?php if (!empty($settings['why_choose_image'])): ?>
                                        <div class="afrisol-image-preview">
                                            <img src="<?php echo esc_url($settings['why_choose_image']); ?>" alt="Why Choose">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        
                        <?php elseif ($tab === 'content'): ?>
                            <div class="afrisol-card">
                                <div class="afrisol-card-header"><h3>Hero Section</h3></div>
                                <div class="afrisol-card-body">
                                    <div class="afrisol-form-group">
                                        <label for="hero_heading"><i class="fas fa-heading"></i> Hero Heading</label>
                                        <input type="text" id="hero_heading" name="hero_heading" value="<?php echo esc_attr($settings['hero_heading'] ?? 'Solar Solutions for a Sustainable Africa'); ?>">
                                    </div>
                                    
                                    <div class="afrisol-form-group">
                                        <label for="hero_subheading"><i class="fas fa-paragraph"></i> Hero Subheading</label>
                                        <textarea id="hero_subheading" name="hero_subheading" rows="3"><?php echo esc_textarea($settings['hero_subheading'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        
                        <?php elseif ($tab === 'contact'): ?>
                            <div class="afrisol-card">
                                <div class="afrisol-card-header"><h3>Contact Information</h3></div>
                                <div class="afrisol-card-body">
                                    <div class="afrisol-form-group">
                                        <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                                        <textarea id="address" name="address" rows="2"><?php echo esc_textarea($settings['address'] ?? 'Suite 15C, Al-Noor Shopping Complex, Ahmadu Bello Way Wuse 2, Abuja.'); ?></textarea>
                                    </div>
                                    
                                    <div class="afrisol-form-row">
                                        <div class="afrisol-form-group">
                                            <label for="phone"><i class="fas fa-phone"></i> Phone</label>
                                            <input type="tel" id="phone" name="phone" value="<?php echo esc_attr($settings['phone'] ?? ''); ?>">
                                        </div>
                                        <div class="afrisol-form-group">
                                            <label for="email"><i class="fas fa-envelope"></i> Email</label>
                                            <input type="email" id="email" name="email" value="<?php echo esc_attr($settings['email'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="afrisol-form-group">
                                        <label for="whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp Number</label>
                                        <input type="tel" id="whatsapp" name="whatsapp" value="<?php echo esc_attr($settings['whatsapp'] ?? ''); ?>" placeholder="e.g., 2348012345678">
                                    </div>
                                    
                                    <div class="afrisol-form-group">
                                        <label for="business_hours"><i class="fas fa-clock"></i> Business Hours</label>
                                        <textarea id="business_hours" name="business_hours" rows="3"><?php echo esc_textarea($settings['business_hours'] ?? "Mon - Fri: 8:00 AM - 6:00 PM\nSat: 9:00 AM - 4:00 PM\nSun: Closed"); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        
                        <?php elseif ($tab === 'social'): ?>
                            <div class="afrisol-card">
                                <div class="afrisol-card-header"><h3>Social Media Links</h3></div>
                                <div class="afrisol-card-body">
                                    <div class="afrisol-form-group">
                                        <label for="facebook"><i class="fab fa-facebook"></i> Facebook</label>
                                        <input type="url" id="facebook" name="facebook" value="<?php echo esc_attr($settings['facebook'] ?? ''); ?>" placeholder="https://facebook.com/yourpage">
                                    </div>
                                    
                                    <div class="afrisol-form-group">
                                        <label for="instagram"><i class="fab fa-instagram"></i> Instagram</label>
                                        <input type="url" id="instagram" name="instagram" value="<?php echo esc_attr($settings['instagram'] ?? ''); ?>" placeholder="https://instagram.com/yourpage">
                                    </div>
                                    
                                    <div class="afrisol-form-group">
                                        <label for="tiktok"><i class="fab fa-tiktok"></i> TikTok</label>
                                        <input type="url" id="tiktok" name="tiktok" value="<?php echo esc_attr($settings['tiktok'] ?? ''); ?>" placeholder="https://tiktok.com/@yourpage">
                                    </div>
                                </div>
                            </div>
                        
                        <?php elseif ($tab === 'payments'): ?>
                            <div class="afrisol-card">
                                <div class="afrisol-card-header"><h3>Paystack Settings</h3></div>
                                <div class="afrisol-card-body">
                                    <div class="afrisol-form-group">
                                        <label for="paystack_public_key"><i class="fas fa-key"></i> Public Key</label>
                                        <input type="text" id="paystack_public_key" name="paystack_public_key" value="<?php echo esc_attr($settings['paystack_public_key'] ?? ''); ?>" placeholder="pk_live_xxxxx or pk_test_xxxxx">
                                    </div>
                                    
                                    <div class="afrisol-form-group">
                                        <label for="paystack_secret_key"><i class="fas fa-key"></i> Secret Key</label>
                                        <div class="afrisol-password-field">
                                            <input type="password" id="paystack_secret_key" name="paystack_secret_key" value="<?php echo esc_attr($settings['paystack_secret_key'] ?? ''); ?>" placeholder="sk_live_xxxxx or sk_test_xxxxx">
                                            <button type="button" class="afrisol-password-toggle">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="afrisol-mt-4">
                            <button type="submit" class="afrisol-btn afrisol-btn-primary">
                                <i class="fas fa-save"></i> Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
</div>
