<?php
/**
 * Hero Section Component
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$hero_heading = isset($settings['hero_heading']) ? $settings['hero_heading'] : 'Solar Solutions for a Sustainable Africa';
$hero_subheading = isset($settings['hero_subheading']) ? $settings['hero_subheading'] : 'Empowering homes and businesses with clean, affordable solar energy. Quality installations, expert maintenance, and innovative solar mobility solutions.';
$hero_image = isset($settings['hero_image']) ? $settings['hero_image'] : '';
$logo_url = isset($settings['logo']) ? $settings['logo'] : '';

// Function to wrap each character in a span for animation
function afrisol_animate_text($text) {
    $result = '';
    $chars = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($chars as $char) {
        if ($char === ' ') {
            $result .= ' ';
        } else {
            $result .= '<span class="letter">' . esc_html($char) . '</span>';
        }
    }
    return $result;
}
?>
<section class="afrisol-hero afrisol-section-lg" id="hero">
    <div class="afrisol-container">
        <div class="afrisol-hero-inner">
            <div class="afrisol-hero-content afrisol-fade-in">
                <div class="afrisol-hero-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="14" height="14"><path fill="currentColor" d="M177.8 63.2l10 17.4c2.8 4.8 4.2 10.3 4.2 15.9l0 41.4c0 3.9 1.6 7.7 4.3 10.4c6.2 6.2 16.5 5.7 22-1.2l13.6-17c4.7-5.9 12.9-7.7 19.6-4.3l15.2 7.6c3.4 1.7 7.2 2.6 11 2.6c6.5 0 12.8-2.6 17.4-7.2l3.9-3.9c2.9-2.9 7.3-3.6 11-1.8l29.2 14.6c7.8 3.9 12.6 11.8 12.6 20.5c0 10.5-7.1 19.6-17.3 22.2l-35.4 8.8c-7.4 1.8-15.1 1.5-22.3-.9l-13.9-4.6c-4.4-1.5-9.2-1.6-13.7-.3l-21.8 6.4c-4 1.2-7.6 3.5-10.4 6.7l-29.5 34.4c-2.5 2.9-5.6 5.1-9.2 6.4l-19.3 7.2c-7.3 2.7-11.7 10.2-10.2 17.8l.9 4.7c1.4 7.6-2.6 15.2-9.7 18.2l-7.5 3.1c-6 2.5-12.8 1.3-17.6-3l-7.5-6.8c-6-5.5-9.3-13.2-9.3-21.3l0-8c0-12.1 6.8-23.2 17.5-28.7l3.9-2c6-3 12.6-4.6 19.3-4.6l27.6 0c5.3 0 10.5-1.1 15.3-3.2l7-3c3.8-1.6 6.9-4.4 9-7.9l2.3-4c1.3-2.1 2-4.6 2-7c0-4.2-1.9-8.2-5.2-10.8l-4.8-3.8c-4.4-3.5-10.5-4.3-15.6-1.9L168 113c-4.5 2.1-9.5 3.2-14.6 3.2l-19.4 0c-6.2 0-12.2 2.5-16.6 6.9c-5.6 5.6-14.7 5.6-20.2 0c-5.8-5.8-5.5-15.4 .6-20.8l16.5-14.6c3.5-3.1 8.1-4.8 12.8-4.8l1.3 0c4 0 7.9-1.6 10.8-4.3l10.3-9.9c3.2-3 4.4-7.6 3.3-11.9L153 61c-.4-1.7-.8-3.4-1.1-5c-.8-4.1 1.3-8.3 5.1-10.1l18.4-8.9c3.7-1.8 8.2-.6 10.5 2.7zM256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512z"/></svg>
                    <span>#1 Solar Solutions in Africa</span>
                </div>
                
                <h1 class="afrisol-hero-animated-heading"><?php echo afrisol_animate_text($hero_heading); ?></h1>
                <p><?php echo esc_html($hero_subheading); ?></p>
                
                <div class="afrisol-hero-buttons">
                    <a href="<?php echo esc_url(home_url('/afrisol-quote/')); ?>" class="afrisol-btn afrisol-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="14" height="14" style="margin-right: 8px;"><path fill="currentColor" d="M349.4 44.6c5.9-13.7 1.5-29.7-10.6-38.5s-28.6-8-39.9 1.8l-256 224c-10 8.8-13.6 22.9-8.9 35.3S50.7 288 64 288l131.5 0L149.4 467.4c-5.9 13.7-1.5 29.7 10.6 38.5s28.6 8 39.9-1.8l256-224c10-8.8 13.6-22.9 8.9-35.3s-16.6-20.7-30-20.7l-131.5 0 46.1-179.4z"/></svg>
                        Get Free Quote
                    </a>
                    <a href="<?php echo esc_url(home_url('/afrisol-products/')); ?>" class="afrisol-btn afrisol-btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="14" height="14" style="margin-right: 8px;"><path fill="currentColor" d="M122.2 0C91.7 0 65.5 21.5 59.5 51.4L8.3 307.4C.4 347 30.6 384 71 384l217 0 0 64-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l192 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0 0-64 217 0c40.4 0 70.7-36.9 62.8-76.6l-51.2-256C574.5 21.5 548.3 0 517.8 0L122.2 0zM260.9 64l118.2 0 10.4 104-139 0 10.4-104zM202.3 168l-100.8 0L122.2 64l90.4 0L202.3 168zM91.4 232l105.6 0-8.3 83.2L81.1 315.2 91.4 232zm153.9 0l49.5 0 0 88-57.8 0 8.3-88zm113.5 0l49.5 0 8.3 88-57.8 0 0-88zm113.5 0l105.6 0 10.4 83.2-107.6 0-8.3-83.2zm96.1-64l-100.8 0-10.4-104 90.4 0 20.7 104z"/></svg>
                        Shop Products
                    </a>
                </div>
            </div>
            
            <div class="afrisol-hero-image afrisol-fade-in">
                <div class="afrisol-hero-image-wrapper">
                    <?php if ($hero_image): ?>
                        <img src="<?php echo esc_url($hero_image); ?>" alt="Solar Solutions" loading="lazy">
                    <?php elseif ($logo_url): ?>
                        <img src="<?php echo esc_url($logo_url); ?>" alt="Afrisol" loading="lazy" style="object-fit: contain; padding: 40px;">
                    <?php else: ?>
                        <div class="afrisol-image-placeholder">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="48" height="48"><path fill="currentColor" d="M0 96C0 60.7 28.7 32 64 32l384 0c35.3 0 64 28.7 64 64l0 320c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6l96 0 32 0 208 0c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/></svg>
                            <span>Hero Image Placeholder</span>
                            <small>(Admin uploads via frontend)</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
