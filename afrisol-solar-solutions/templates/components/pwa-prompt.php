<?php
/**
 * PWA Install Prompt Component
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$logo_url = isset($settings['logo']) ? $settings['logo'] : '';
?>
<div class="afrisol-pwa-prompt" id="afrisol-pwa-prompt">
    <div class="afrisol-pwa-prompt-content">
        <div class="afrisol-pwa-icon">
            <?php if ($logo_url): ?>
                <img src="<?php echo esc_url($logo_url); ?>" alt="Afrisol">
            <?php else: ?>
                <i class="fas fa-sun" style="font-size: 24px; color: white;"></i>
            <?php endif; ?>
        </div>
        <div class="afrisol-pwa-text">
            <h4>Install Afrisol App</h4>
            <p>Add to your home screen for quick access</p>
        </div>
    </div>
    <div class="afrisol-pwa-buttons">
        <button class="afrisol-btn afrisol-btn-secondary" id="afrisol-pwa-dismiss">
            Not Now
        </button>
        <button class="afrisol-btn afrisol-btn-primary" id="afrisol-pwa-install">
            <i class="fas fa-download"></i> Install
        </button>
    </div>
</div>
