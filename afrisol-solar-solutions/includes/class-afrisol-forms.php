<?php
/**
 * Forms handling
 */
class Afrisol_Forms {
    
    /**
     * Render contact form
     */
    public static function render_contact_form($type = 'contact') {
        ob_start();
        ?>
        <form class="afrisol-form afrisol-contact-form" data-type="<?php echo esc_attr($type); ?>">
            <div class="afrisol-form-row">
                <div class="afrisol-form-group">
                    <label for="contact-name">
                        <i class="fas fa-user"></i>
                        <?php esc_html_e('Full Name', 'afrisol'); ?> <span class="required">*</span>
                    </label>
                    <input type="text" id="contact-name" name="name" required>
                </div>
                <div class="afrisol-form-group">
                    <label for="contact-email">
                        <i class="fas fa-envelope"></i>
                        <?php esc_html_e('Email Address', 'afrisol'); ?> <span class="required">*</span>
                    </label>
                    <input type="email" id="contact-email" name="email" required>
                </div>
            </div>
            
            <div class="afrisol-form-row">
                <div class="afrisol-form-group">
                    <label for="contact-phone">
                        <i class="fas fa-phone"></i>
                        <?php esc_html_e('Phone Number', 'afrisol'); ?>
                    </label>
                    <input type="tel" id="contact-phone" name="phone">
                </div>
                <div class="afrisol-form-group">
                    <label for="contact-subject">
                        <i class="fas fa-tag"></i>
                        <?php esc_html_e('Subject', 'afrisol'); ?>
                    </label>
                    <select id="contact-subject" name="subject">
                        <option value=""><?php esc_html_e('Select a subject', 'afrisol'); ?></option>
                        <option value="general"><?php esc_html_e('General Inquiry', 'afrisol'); ?></option>
                        <option value="complaint"><?php esc_html_e('Complaint', 'afrisol'); ?></option>
                        <option value="feedback"><?php esc_html_e('Feedback', 'afrisol'); ?></option>
                        <option value="suggestion"><?php esc_html_e('Suggestion', 'afrisol'); ?></option>
                        <option value="support"><?php esc_html_e('Technical Support', 'afrisol'); ?></option>
                    </select>
                </div>
            </div>
            
            <div class="afrisol-form-group">
                <label for="contact-message">
                    <i class="fas fa-comment"></i>
                    <?php esc_html_e('Message', 'afrisol'); ?> <span class="required">*</span>
                </label>
                <textarea id="contact-message" name="message" rows="5" required></textarea>
            </div>
            
            <input type="hidden" name="type" value="<?php echo esc_attr($type); ?>">
            
            <button type="submit" class="afrisol-btn afrisol-btn-primary">
                <i class="fas fa-paper-plane"></i>
                <?php esc_html_e('Send Message', 'afrisol'); ?>
            </button>
        </form>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Render login form
     */
    public static function render_login_form() {
        ob_start();
        ?>
        <form class="afrisol-form afrisol-login-form">
            <div class="afrisol-form-group">
                <label for="login-username">
                    <i class="fas fa-user"></i>
                    <?php esc_html_e('Username or Email', 'afrisol'); ?>
                </label>
                <input type="text" id="login-username" name="username" required>
            </div>
            
            <div class="afrisol-form-group">
                <label for="login-password">
                    <i class="fas fa-lock"></i>
                    <?php esc_html_e('Password', 'afrisol'); ?>
                </label>
                <div class="afrisol-password-field">
                    <input type="password" id="login-password" name="password" required>
                    <button type="button" class="afrisol-password-toggle" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="afrisol-form-row afrisol-form-options">
                <label class="afrisol-checkbox">
                    <input type="checkbox" name="remember" value="true">
                    <span class="afrisol-checkbox-mark"></span>
                    <?php esc_html_e('Remember me', 'afrisol'); ?>
                </label>
                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="afrisol-link">
                    <?php esc_html_e('Forgot password?', 'afrisol'); ?>
                </a>
            </div>
            
            <button type="submit" class="afrisol-btn afrisol-btn-primary afrisol-btn-block">
                <i class="fas fa-sign-in-alt"></i>
                <?php esc_html_e('Login', 'afrisol'); ?>
            </button>
            
            <p class="afrisol-form-footer">
                <?php esc_html_e("Don't have an account?", 'afrisol'); ?>
                <a href="<?php echo esc_url(home_url('/afrisol-register/')); ?>">
                    <?php esc_html_e('Create one', 'afrisol'); ?>
                </a>
            </p>
        </form>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Render registration form
     */
    public static function render_register_form() {
        ob_start();
        ?>
        <form class="afrisol-form afrisol-register-form">
            <div class="afrisol-form-row">
                <div class="afrisol-form-group">
                    <label for="register-firstname">
                        <i class="fas fa-user"></i>
                        <?php esc_html_e('First Name', 'afrisol'); ?> <span class="required">*</span>
                    </label>
                    <input type="text" id="register-firstname" name="first_name" required>
                </div>
                <div class="afrisol-form-group">
                    <label for="register-lastname">
                        <i class="fas fa-user"></i>
                        <?php esc_html_e('Last Name', 'afrisol'); ?> <span class="required">*</span>
                    </label>
                    <input type="text" id="register-lastname" name="last_name" required>
                </div>
            </div>
            
            <div class="afrisol-form-group">
                <label for="register-username">
                    <i class="fas fa-at"></i>
                    <?php esc_html_e('Username', 'afrisol'); ?> <span class="required">*</span>
                </label>
                <input type="text" id="register-username" name="username" required>
            </div>
            
            <div class="afrisol-form-group">
                <label for="register-email">
                    <i class="fas fa-envelope"></i>
                    <?php esc_html_e('Email Address', 'afrisol'); ?> <span class="required">*</span>
                </label>
                <input type="email" id="register-email" name="email" required>
            </div>
            
            <div class="afrisol-form-group">
                <label for="register-phone">
                    <i class="fas fa-phone"></i>
                    <?php esc_html_e('Phone Number', 'afrisol'); ?>
                </label>
                <input type="tel" id="register-phone" name="phone">
            </div>
            
            <div class="afrisol-form-group">
                <label for="register-password">
                    <i class="fas fa-lock"></i>
                    <?php esc_html_e('Password', 'afrisol'); ?> <span class="required">*</span>
                </label>
                <div class="afrisol-password-field">
                    <input type="password" id="register-password" name="password" required minlength="8">
                    <button type="button" class="afrisol-password-toggle" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <small class="afrisol-form-hint"><?php esc_html_e('Minimum 8 characters', 'afrisol'); ?></small>
            </div>
            
            <div class="afrisol-form-group">
                <label for="register-password-confirm">
                    <i class="fas fa-lock"></i>
                    <?php esc_html_e('Confirm Password', 'afrisol'); ?> <span class="required">*</span>
                </label>
                <div class="afrisol-password-field">
                    <input type="password" id="register-password-confirm" name="password_confirm" required>
                    <button type="button" class="afrisol-password-toggle" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="afrisol-form-group">
                <label for="register-referral">
                    <i class="fas fa-gift"></i>
                    <?php esc_html_e('Referral Code (Optional)', 'afrisol'); ?>
                </label>
                <input type="text" id="register-referral" name="referral">
            </div>
            
            <div class="afrisol-form-group">
                <label class="afrisol-checkbox">
                    <input type="checkbox" name="terms" required>
                    <span class="afrisol-checkbox-mark"></span>
                    <?php esc_html_e('I agree to the', 'afrisol'); ?>
                    <a href="#" class="afrisol-link"><?php esc_html_e('Terms and Conditions', 'afrisol'); ?></a>
                </label>
            </div>
            
            <button type="submit" class="afrisol-btn afrisol-btn-primary afrisol-btn-block">
                <i class="fas fa-user-plus"></i>
                <?php esc_html_e('Create Account', 'afrisol'); ?>
            </button>
            
            <p class="afrisol-form-footer">
                <?php esc_html_e('Already have an account?', 'afrisol'); ?>
                <a href="<?php echo esc_url(home_url('/afrisol-login/')); ?>">
                    <?php esc_html_e('Login', 'afrisol'); ?>
                </a>
            </p>
        </form>
        <?php
        return ob_get_clean();
    }
}
