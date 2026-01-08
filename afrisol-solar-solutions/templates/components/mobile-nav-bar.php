<?php
/**
 * Mobile Bottom Navigation Bar Component (PWA App-like)
 * Shows at the bottom on mobile devices for app-like experience
 */
if (!defined('ABSPATH')) exit;
$current_page = get_queried_object();
$current_slug = is_object($current_page) && isset($current_page->post_name) ? $current_page->post_name : '';
?>
<nav class="afrisol-mobile-bottom-nav" id="afrisol-mobile-bottom-nav">
    <a href="<?php echo esc_url(home_url('/afrisol-home/')); ?>" class="afrisol-bottom-nav-item <?php echo ($current_slug === 'afrisol-home' || is_front_page()) ? 'active' : ''; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="24" height="24"><path fill="currentColor" d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 0 160c0 35.3-28.7 64-64 64l-320 0c-35.3 0-64-28.7-64-64l0-160-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>
        <span>Home</span>
    </a>
    <a href="<?php echo esc_url(home_url('/afrisol-about/')); ?>" class="afrisol-bottom-nav-item <?php echo ($current_slug === 'afrisol-about') ? 'active' : ''; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24"><path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
        <span>About</span>
    </a>
    <a href="<?php echo esc_url(home_url('/afrisol-products/')); ?>" class="afrisol-bottom-nav-item <?php echo ($current_slug === 'afrisol-products') ? 'active' : ''; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="24" height="24"><path fill="currentColor" d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
        <span>Shop</span>
    </a>
    <a href="<?php echo esc_url(home_url('/afrisol-portal/')); ?>" class="afrisol-bottom-nav-item <?php echo ($current_slug === 'afrisol-portal') ? 'active' : ''; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24" height="24"><path fill="currentColor" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
        <span>Profile</span>
    </a>
</nav>
