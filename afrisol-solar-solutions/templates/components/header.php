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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="20" height="20"><path fill="currentColor" d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
                    <?php if ($cart_count > 0): ?>
                        <span class="afrisol-cart-count"><?php echo esc_html($cart_count); ?></span>
                    <?php endif; ?>
                </a>
                
                <?php if (is_user_logged_in()): ?>
                    <a href="<?php echo esc_url(home_url('/afrisol-portal/')); ?>" class="afrisol-btn afrisol-btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="14" height="14" style="margin-right: 6px;"><path fill="currentColor" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
                        Portal
                    </a>
                <?php else: ?>
                    <a href="<?php echo esc_url(home_url('/afrisol-login/')); ?>" class="afrisol-btn afrisol-btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="14" height="14" style="margin-right: 6px;"><path fill="currentColor" d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"/></svg>
                        Login
                    </a>
                <?php endif; ?>
                
                <a href="<?php echo esc_url(home_url('/afrisol-quote/')); ?>" class="afrisol-btn afrisol-btn-primary afrisol-btn-sm">
                    Get Quote
                </a>
                
                <button class="afrisol-mobile-toggle" aria-label="Toggle menu">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24" height="24"><path fill="currentColor" d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/></svg>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Navigation -->
<nav class="afrisol-mobile-nav">
    <button class="afrisol-mobile-close" aria-label="Close menu">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24"><path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
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
