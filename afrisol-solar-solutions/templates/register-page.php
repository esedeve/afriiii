<?php
/**
 * Register Page Template
 */
if (!defined('ABSPATH')) exit;

if (is_user_logged_in()) {
    wp_redirect(home_url('/afrisol-portal/'));
    exit;
}

$referral = isset($_GET['ref']) ? sanitize_text_field($_GET['ref']) : '';
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-auth-page">
        <div class="afrisol-container">
            <div class="afrisol-auth-container afrisol-fade-in">
                <div class="afrisol-auth-header">
                    <a href="<?php echo esc_url(home_url('/afrisol-home/')); ?>" class="afrisol-logo" style="justify-content: center; margin-bottom: 20px;">
                        <div class="afrisol-logo-icon">
                            <i class="fas fa-sun"></i>
                        </div>
                        <span class="afrisol-logo-text">AFRISOL</span>
                    </a>
                    <h1><i class="fas fa-user-plus"></i> Create Account</h1>
                    <p>Join Afrisol and start saving with solar energy</p>
                </div>
                
                <form class="afrisol-form afrisol-register-form" id="register-form">
                    <div class="afrisol-form-row">
                        <div class="afrisol-form-group">
                            <label for="reg-first-name">
                                <i class="fas fa-user"></i> First Name <span class="required">*</span>
                            </label>
                            <input type="text" id="reg-first-name" name="first_name" placeholder="First name" required>
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label for="reg-last-name">
                                <i class="fas fa-user"></i> Last Name <span class="required">*</span>
                            </label>
                            <input type="text" id="reg-last-name" name="last_name" placeholder="Last name" required>
                        </div>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="reg-username">
                            <i class="fas fa-at"></i> Username <span class="required">*</span>
                        </label>
                        <input type="text" id="reg-username" name="username" placeholder="Choose a username" required>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="reg-email">
                            <i class="fas fa-envelope"></i> Email <span class="required">*</span>
                        </label>
                        <input type="email" id="reg-email" name="email" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="reg-phone">
                            <i class="fas fa-phone"></i> Phone Number <span class="required">*</span>
                        </label>
                        <input type="tel" id="reg-phone" name="phone" placeholder="Enter your phone number" required>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="reg-password">
                            <i class="fas fa-lock"></i> Password <span class="required">*</span>
                        </label>
                        <div class="afrisol-password-field">
                            <input type="password" id="reg-password" name="password" placeholder="Create a password" required minlength="8">
                            <button type="button" class="afrisol-password-toggle" aria-label="Toggle password visibility">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <span class="afrisol-form-hint">Minimum 8 characters</span>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="reg-password-confirm">
                            <i class="fas fa-lock"></i> Confirm Password <span class="required">*</span>
                        </label>
                        <div class="afrisol-password-field">
                            <input type="password" id="reg-password-confirm" name="password_confirm" placeholder="Confirm your password" required>
                            <button type="button" class="afrisol-password-toggle" aria-label="Toggle password visibility">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="reg-referral">
                            <i class="fas fa-gift"></i> Referral Code (Optional)
                        </label>
                        <input type="text" id="reg-referral" name="referral" placeholder="Enter referral code if you have one" value="<?php echo esc_attr($referral); ?>">
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label class="afrisol-checkbox">
                            <input type="checkbox" name="agree_terms" required>
                            <span class="afrisol-checkbox-mark"></span>
                            I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>
                        </label>
                    </div>
                    
                    <button type="submit" class="afrisol-btn afrisol-btn-primary afrisol-btn-block">
                        <i class="fas fa-user-plus"></i> Create Account
                    </button>
                    
                    <div class="afrisol-form-footer">
                        <p>Already have an account? <a href="<?php echo esc_url(home_url('/afrisol-login/')); ?>">Sign in</a></p>
                    </div>
                </form>
                
                <div class="afrisol-text-center afrisol-mt-4">
                    <a href="<?php echo esc_url(home_url('/afrisol-home/')); ?>" class="afrisol-btn afrisol-btn-ghost">
                        <i class="fas fa-arrow-left"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
</div>
