<?php
/**
 * Quote Request Page Template (Multi-step form)
 */
if (!defined('ABSPATH')) exit;
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-section" style="padding-top: 120px;">
        <div class="afrisol-container afrisol-container-md">
            <div class="afrisol-section-header afrisol-fade-in">
                <h1>Request a Quote</h1>
                <p>Get a customized quote for your solar or security needs</p>
            </div>
            
            <!-- Progress Steps -->
            <div class="afrisol-quote-steps afrisol-fade-in" id="quote-steps">
                <div class="afrisol-step active" data-step="1">
                    <span class="afrisol-step-number">1</span>
                    <span class="afrisol-step-label">Service Type</span>
                </div>
                <div class="afrisol-step-line"></div>
                <div class="afrisol-step" data-step="2">
                    <span class="afrisol-step-number">2</span>
                    <span class="afrisol-step-label">Category</span>
                </div>
                <div class="afrisol-step-line"></div>
                <div class="afrisol-step" data-step="3">
                    <span class="afrisol-step-number">3</span>
                    <span class="afrisol-step-label">Details</span>
                </div>
                <div class="afrisol-step-line"></div>
                <div class="afrisol-step" data-step="4">
                    <span class="afrisol-step-number">4</span>
                    <span class="afrisol-step-label">Contact</span>
                </div>
                <div class="afrisol-step-line"></div>
                <div class="afrisol-step" data-step="5">
                    <span class="afrisol-step-number">5</span>
                    <span class="afrisol-step-label">Confirm</span>
                </div>
            </div>
            
            <form class="afrisol-form afrisol-fade-in" id="quote-form" enctype="multipart/form-data">
                <!-- Step 1: Service Type -->
                <div class="afrisol-quote-step-content active" data-step="1">
                    <h3 class="afrisol-text-center afrisol-mb-4">What type of service do you need?</h3>
                    <div class="afrisol-quote-options">
                        <div class="afrisol-quote-option" data-value="new_installation">
                            <i class="fas fa-plus-circle"></i>
                            <h4>New Installation</h4>
                            <p>Fresh solar or security system setup</p>
                        </div>
                        <div class="afrisol-quote-option" data-value="product_purchase">
                            <i class="fas fa-shopping-cart"></i>
                            <h4>Product Purchase</h4>
                            <p>Buy equipment with optional installation</p>
                        </div>
                        <div class="afrisol-quote-option" data-value="repair_service">
                            <i class="fas fa-tools"></i>
                            <h4>Repair Service</h4>
                            <p>Fix or maintain existing equipment</p>
                        </div>
                    </div>
                    <input type="hidden" name="service_type" id="service_type">
                </div>
                
                <!-- Step 2: Category Selection -->
                <div class="afrisol-quote-step-content" data-step="2">
                    <h3 class="afrisol-text-center afrisol-mb-4">Select a category</h3>
                    <div class="afrisol-quote-options" id="category-options">
                        <div class="afrisol-quote-option" data-value="solar_residential">
                            <i class="fas fa-home"></i>
                            <h4>Residential Solar</h4>
                            <p>Home solar systems</p>
                        </div>
                        <div class="afrisol-quote-option" data-value="solar_commercial">
                            <i class="fas fa-building"></i>
                            <h4>Commercial Solar</h4>
                            <p>Business & industrial</p>
                        </div>
                        <div class="afrisol-quote-option" data-value="security">
                            <i class="fas fa-shield-alt"></i>
                            <h4>Security Systems</h4>
                            <p>CCTV & access control</p>
                        </div>
                    </div>
                    <input type="hidden" name="category" id="category">
                </div>
                
                <!-- Step 3: Project Details -->
                <div class="afrisol-quote-step-content" data-step="3">
                    <h3 class="afrisol-text-center afrisol-mb-4">Project Details</h3>
                    
                    <div class="afrisol-form-group">
                        <label for="quote-location"><i class="fas fa-map-marker-alt"></i> Location/State</label>
                        <input type="text" id="quote-location" name="location" placeholder="e.g., Abuja, Lagos">
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="quote-address"><i class="fas fa-home"></i> Full Address</label>
                        <textarea id="quote-address" name="address" rows="2" placeholder="Enter your complete address"></textarea>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="quote-property"><i class="fas fa-building"></i> Property Type</label>
                        <select id="quote-property" name="property_type">
                            <option value="">Select property type</option>
                            <option value="bungalow">Bungalow</option>
                            <option value="duplex">Duplex</option>
                            <option value="apartment">Apartment/Flat</option>
                            <option value="office">Office Building</option>
                            <option value="warehouse">Warehouse/Factory</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label><i class="fas fa-camera"></i> Property Photos (Optional)</label>
                        <div class="afrisol-image-upload-zone" id="photo-upload-zone">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Click to upload or drag photos here</p>
                            <input type="file" name="photos[]" multiple accept="image/*" style="display: none;" id="photo-input">
                        </div>
                        <div class="afrisol-image-preview" id="photo-preview"></div>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="quote-budget"><i class="fas fa-wallet"></i> Budget Range</label>
                        <select id="quote-budget" name="budget_range">
                            <option value="">Select budget range</option>
                            <option value="under_500k">Under ₦500,000</option>
                            <option value="500k_1m">₦500,000 - ₦1,000,000</option>
                            <option value="1m_3m">₦1,000,000 - ₦3,000,000</option>
                            <option value="3m_5m">₦3,000,000 - ₦5,000,000</option>
                            <option value="above_5m">Above ₦5,000,000</option>
                            <option value="flexible">Flexible</option>
                        </select>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="quote-notes"><i class="fas fa-sticky-note"></i> Additional Notes</label>
                        <textarea id="quote-notes" name="notes" rows="3" placeholder="Any specific requirements or questions?"></textarea>
                    </div>
                </div>
                
                <!-- Step 4: Contact Information -->
                <div class="afrisol-quote-step-content" data-step="4">
                    <h3 class="afrisol-text-center afrisol-mb-4">Contact Information</h3>
                    
                    <div class="afrisol-form-row">
                        <div class="afrisol-form-group">
                            <label for="quote-name"><i class="fas fa-user"></i> Full Name <span class="required">*</span></label>
                            <input type="text" id="quote-name" name="name" required placeholder="Enter your full name">
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label for="quote-email"><i class="fas fa-envelope"></i> Email <span class="required">*</span></label>
                            <input type="email" id="quote-email" name="email" required placeholder="Enter your email">
                        </div>
                    </div>
                    
                    <div class="afrisol-form-row">
                        <div class="afrisol-form-group">
                            <label for="quote-phone"><i class="fas fa-phone"></i> Phone <span class="required">*</span></label>
                            <input type="tel" id="quote-phone" name="phone" required placeholder="Enter your phone number">
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label for="quote-whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp (if different)</label>
                            <input type="tel" id="quote-whatsapp" name="whatsapp" placeholder="Enter WhatsApp number">
                        </div>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label><i class="fas fa-comments"></i> Preferred Contact Method</label>
                        <div class="afrisol-flex afrisol-gap-lg">
                            <label class="afrisol-checkbox">
                                <input type="radio" name="preferred_contact" value="phone" checked>
                                <span class="afrisol-checkbox-mark"></span>
                                Phone Call
                            </label>
                            <label class="afrisol-checkbox">
                                <input type="radio" name="preferred_contact" value="whatsapp">
                                <span class="afrisol-checkbox-mark"></span>
                                WhatsApp
                            </label>
                            <label class="afrisol-checkbox">
                                <input type="radio" name="preferred_contact" value="email">
                                <span class="afrisol-checkbox-mark"></span>
                                Email
                            </label>
                        </div>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="quote-best-time"><i class="fas fa-clock"></i> Best Time to Call</label>
                        <select id="quote-best-time" name="best_time">
                            <option value="">Select preferred time</option>
                            <option value="morning">Morning (8AM - 12PM)</option>
                            <option value="afternoon">Afternoon (12PM - 4PM)</option>
                            <option value="evening">Evening (4PM - 7PM)</option>
                            <option value="anytime">Anytime</option>
                        </select>
                    </div>
                </div>
                
                <!-- Step 5: Confirmation -->
                <div class="afrisol-quote-step-content" data-step="5">
                    <h3 class="afrisol-text-center afrisol-mb-4">Review & Submit</h3>
                    
                    <div class="afrisol-card">
                        <div class="afrisol-card-body" id="quote-summary">
                            <!-- Summary will be populated by JavaScript -->
                        </div>
                    </div>
                    
                    <div class="afrisol-form-group afrisol-mt-4">
                        <label class="afrisol-checkbox">
                            <input type="checkbox" name="agree_terms" required>
                            <span class="afrisol-checkbox-mark"></span>
                            I agree to the terms and conditions and privacy policy
                        </label>
                    </div>
                </div>
                
                <!-- Navigation Buttons -->
                <div class="afrisol-quote-buttons">
                    <button type="button" class="afrisol-btn afrisol-btn-secondary" id="quote-prev" style="display: none;">
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    <button type="button" class="afrisol-btn afrisol-btn-primary" id="quote-next">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                    <button type="submit" class="afrisol-btn afrisol-btn-primary" id="quote-submit" style="display: none;">
                        <i class="fas fa-paper-plane"></i> Submit Quote Request
                    </button>
                </div>
            </form>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
    <?php echo do_shortcode('[afrisol_whatsapp]'); ?>
</div>
