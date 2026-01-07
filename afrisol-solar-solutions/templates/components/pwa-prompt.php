<?php
/**
 * PWA Install Prompt Component - Browser Specific
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$logo_url = isset($settings['logo']) ? $settings['logo'] : AFRISOL_PLUGIN_URL . 'assets/images/afrisol-logo.webp';
?>
<div class="afrisol-pwa-prompt" id="afrisol-pwa-prompt">
    <button class="afrisol-pwa-close" id="afrisol-pwa-close" aria-label="Close">
        <i class="fas fa-times"></i>
    </button>
    <div class="afrisol-pwa-prompt-content">
        <div class="afrisol-pwa-icon">
            <img src="<?php echo esc_url($logo_url); ?>" alt="Afrisol" onerror="this.style.display='none';this.parentElement.innerHTML='<i class=\'fas fa-sun\' style=\'font-size: 32px; color: #ff6b35;\'></i>';">
        </div>
        <div class="afrisol-pwa-text">
            <h4>Install Afrisol App</h4>
            <p class="afrisol-pwa-browser-msg">Get quick access to solar solutions!</p>
        </div>
    </div>
    
    <!-- Browser-specific instructions -->
    <div class="afrisol-pwa-instructions" id="afrisol-pwa-instructions">
        <!-- Chrome/Edge (Standard PWA) -->
        <div class="afrisol-pwa-browser chrome-edge" style="display:none;">
            <p><i class="fab fa-chrome"></i> Click <strong>Install</strong> to add Afrisol to your device</p>
        </div>
        
        <!-- Safari iOS -->
        <div class="afrisol-pwa-browser safari-ios" style="display:none;">
            <p><i class="fab fa-safari"></i> Tap <i class="fas fa-share-square"></i> then <strong>"Add to Home Screen"</strong></p>
        </div>
        
        <!-- Safari macOS -->
        <div class="afrisol-pwa-browser safari-mac" style="display:none;">
            <p><i class="fab fa-safari"></i> Click <strong>File → Add to Dock</strong> or use the share button</p>
        </div>
        
        <!-- Firefox -->
        <div class="afrisol-pwa-browser firefox" style="display:none;">
            <p><i class="fab fa-firefox"></i> Click <i class="fas fa-ellipsis-v"></i> then <strong>"Install"</strong> or <strong>"Add to Home Screen"</strong></p>
        </div>
        
        <!-- Opera -->
        <div class="afrisol-pwa-browser opera" style="display:none;">
            <p><i class="fab fa-opera"></i> Click <i class="fas fa-ellipsis-v"></i> then <strong>"Add to..."</strong></p>
        </div>
        
        <!-- Samsung Internet -->
        <div class="afrisol-pwa-browser samsung" style="display:none;">
            <p><i class="fas fa-mobile-alt"></i> Tap <i class="fas fa-bars"></i> then <strong>"Add page to" → "Home screen"</strong></p>
        </div>
        
        <!-- Generic fallback -->
        <div class="afrisol-pwa-browser generic" style="display:none;">
            <p><i class="fas fa-download"></i> Add this app to your home screen for quick access</p>
        </div>
    </div>
    
    <div class="afrisol-pwa-buttons">
        <button class="afrisol-btn afrisol-btn-secondary afrisol-pwa-dismiss" id="afrisol-pwa-dismiss">
            Later
        </button>
        <button class="afrisol-btn afrisol-btn-primary afrisol-pwa-install" id="afrisol-pwa-install">
            <i class="fas fa-download"></i> <span>Install App</span>
        </button>
    </div>
</div>
