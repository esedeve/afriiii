<?php
/**
 * Contact Form Section Component
 */
if (!defined('ABSPATH')) exit;
?>
<section class="afrisol-section" id="contact-form">
    <div class="afrisol-container afrisol-container-md">
        <div class="afrisol-section-header afrisol-fade-in">
            <h2>Get In Touch</h2>
            <p>Have a question, feedback, or suggestion? We'd love to hear from you.</p>
        </div>
        
        <div class="afrisol-form afrisol-fade-in">
            <form class="afrisol-contact-form" id="afrisol-contact-form">
                <input type="hidden" name="type" value="contact">
                
                <div class="afrisol-form-row">
                    <div class="afrisol-form-group">
                        <label for="contact-name">
                            <i class="fas fa-user"></i> Full Name <span class="required">*</span>
                        </label>
                        <input type="text" id="contact-name" name="name" placeholder="Enter your full name" required>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="contact-email">
                            <i class="fas fa-envelope"></i> Email Address <span class="required">*</span>
                        </label>
                        <input type="email" id="contact-email" name="email" placeholder="Enter your email" required>
                    </div>
                </div>
                
                <div class="afrisol-form-row">
                    <div class="afrisol-form-group">
                        <label for="contact-phone">
                            <i class="fas fa-phone"></i> Phone Number
                        </label>
                        <input type="tel" id="contact-phone" name="phone" placeholder="Enter your phone number">
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="contact-subject">
                            <i class="fas fa-tag"></i> Subject
                        </label>
                        <select id="contact-subject" name="subject">
                            <option value="">Select a subject</option>
                            <option value="General Inquiry">General Inquiry</option>
                            <option value="Product Question">Product Question</option>
                            <option value="Service Request">Service Request</option>
                            <option value="Complaint">Complaint</option>
                            <option value="Feedback">Feedback</option>
                            <option value="Suggestion">Suggestion</option>
                        </select>
                    </div>
                </div>
                
                <div class="afrisol-form-group">
                    <label for="contact-message">
                        <i class="fas fa-comment-alt"></i> Message <span class="required">*</span>
                    </label>
                    <textarea id="contact-message" name="message" placeholder="Write your message here..." rows="5" required></textarea>
                </div>
                
                <div class="afrisol-text-center">
                    <button type="submit" class="afrisol-btn afrisol-btn-primary">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
