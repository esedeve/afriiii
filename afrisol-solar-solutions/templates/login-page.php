<?php
/**
 * Login Page Template
 */
if (!defined('ABSPATH')) exit;

if (is_user_logged_in()) {
    wp_redirect(home_url('/afrisol-portal/'));
    exit;
}
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
                    <h1><i class="fas fa-sign-in-alt"></i> Welcome Back</h1>
                    <p>Sign in to access your account</p>
                </div>
                
                <form class="afrisol-form afrisol-login-form" id="login-form">
                    <div class="afrisol-form-group">
                        <label for="login-username">
                            <i class="fas fa-user"></i> Username or Email <span class="required">*</span>
                        </label>
                        <input type="text" id="login-username" name="username" placeholder="Enter your username or email" required>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="login-password">
                            <i class="fas fa-lock"></i> Password <span class="required">*</span>
                        </label>
                        <div class="afrisol-password-field">
                            <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
                            <button type="button" class="afrisol-password-toggle" aria-label="Toggle password visibility">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="afrisol-flex afrisol-form-options">
                        <label class="afrisol-checkbox">
                            <input type="checkbox" name="remember">
                            <span class="afrisol-checkbox-mark"></span>
                            Remember me
                        </label>
                        <a href="#" style="font-size: 0.875rem;">Forgot password?</a>
                    </div>
                    
                    <button type="submit" class="afrisol-btn afrisol-btn-primary afrisol-btn-block">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                    
                    <div class="afrisol-form-footer">
                        <p>Don't have an account? <a href="<?php echo esc_url(home_url('/afrisol-register/')); ?>">Create one</a></p>
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
