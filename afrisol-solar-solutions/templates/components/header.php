<?php
/**
 * Header Component
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$logo_url = isset($settings['logo']) && !empty($settings['logo']) ? $settings['logo'] : AFRISOL_PLUGIN_URL . 'assets/images/afrisol-logo.webp';
$company_name = isset($settings['company_name']) ? $settings['company_name'] : 'Afrisol';
$cart_count = class_exists('Afrisol_Cart') ? Afrisol_Cart::get_count() : 0;
?>
<header class="afrisol-header" id="afrisol-header">
    <div class="afrisol-container">
        <div class="afrisol-header-inner">
            <a href="<?php echo esc_url(home_url('/afrisol-home/')); ?>" class="afrisol-logo">
                <div class="afrisol-logo-icon">
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($company_name); ?>">
                </div>
                <span class="afrisol-logo-text"><?php echo esc_html(strtoupper($company_name)); ?></span>
            </a>
            
            <nav class="afrisol-nav">
                <a href="<?php echo esc_url(home_url('/afrisol-home/')); ?>" <?php echo is_page('afrisol-home') ? 'class="active"' : ''; ?>>Home</a>
                <a href="<?php echo esc_url(home_url('/afrisol-products/')); ?>" <?php echo is_page('afrisol-products') ? 'class="active"' : ''; ?>>Products</a>
                <a href="<?php echo esc_url(home_url('/afrisol-services/')); ?>" <?php echo is_page('afrisol-services') ? 'class="active"' : ''; ?>>Services</a>
                <a href="<?php echo esc_url(home_url('/afrisol-calculator/')); ?>" <?php echo is_page('afrisol-calculator') ? 'class="active"' : ''; ?>>Calculator</a>
                <a href="<?php echo esc_url(home_url('/afrisol-about/')); ?>" <?php echo is_page('afrisol-about') ? 'class="active"' : ''; ?>>About</a>
                <a href="<?php echo esc_url(home_url('/afrisol-contact/')); ?>" <?php echo is_page('afrisol-contact') ? 'class="active"' : ''; ?>>Contact</a>
            </nav>
            
            <div class="afrisol-header-actions">
                <a href="<?php echo esc_url(home_url('/afrisol-cart/')); ?>" class="afrisol-cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <?php if ($cart_count > 0): ?>
                        <span class="afrisol-cart-count"><?php echo esc_html($cart_count); ?></span>
                    <?php endif; ?>
                </a>
                
                <?php if (is_user_logged_in()): ?>
                    <a href="<?php echo esc_url(home_url('/afrisol-portal/')); ?>" class="afrisol-btn afrisol-btn-ghost">
                        <i class="fas fa-user"></i> Portal
                    </a>
                <?php else: ?>
                    <a href="<?php echo esc_url(home_url('/afrisol-login/')); ?>" class="afrisol-btn afrisol-btn-ghost">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                <?php endif; ?>
                
                <a href="<?php echo esc_url(home_url('/afrisol-quote/')); ?>" class="afrisol-btn afrisol-btn-primary afrisol-btn-sm">
                    Get Quote
                </a>
                
                <button class="afrisol-mobile-toggle" aria-label="Toggle menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Navigation -->
<nav class="afrisol-mobile-nav">
    <button class="afrisol-mobile-close" aria-label="Close menu">
        <i class="fas fa-times"></i>
    </button>
    <a href="<?php echo esc_url(home_url('/afrisol-home/')); ?>">Home</a>
    <a href="<?php echo esc_url(home_url('/afrisol-products/')); ?>">Products</a>
    <a href="<?php echo esc_url(home_url('/afrisol-services/')); ?>">Services</a>
    <a href="<?php echo esc_url(home_url('/afrisol-calculator/')); ?>">Calculator</a>
    <a href="<?php echo esc_url(home_url('/afrisol-about/')); ?>">About</a>
    <a href="<?php echo esc_url(home_url('/afrisol-blog/')); ?>">Blog</a>
    <a href="<?php echo esc_url(home_url('/afrisol-contact/')); ?>">Contact</a>
    <?php if (is_user_logged_in()): ?>
        <a href="<?php echo esc_url(home_url('/afrisol-portal/')); ?>">My Portal</a>
        <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>">Logout</a>
    <?php else: ?>
        <a href="<?php echo esc_url(home_url('/afrisol-login/')); ?>">Login</a>
        <a href="<?php echo esc_url(home_url('/afrisol-register/')); ?>">Register</a>
    <?php endif; ?>
</nav>
<div class="afrisol-overlay"></div>
