<?php
/**
 * Repair Request Page Template
 */
if (!defined('ABSPATH')) exit;
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-section" style="padding-top: 120px;">
        <div class="afrisol-container afrisol-container-md">
            <div class="afrisol-section-header afrisol-fade-in">
                <span class="afrisol-badge"><i class="fas fa-tools"></i> Repair Service</span>
                <h1>Request a Repair</h1>
                <p>Let our expert technicians fix your solar or security equipment</p>
            </div>
            
            <form class="afrisol-form afrisol-fade-in" id="repair-form">
                <div class="afrisol-form-row">
                    <div class="afrisol-form-group">
                        <label for="repair-equipment"><i class="fas fa-cog"></i> Equipment Type <span class="required">*</span></label>
                        <select id="repair-equipment" name="equipment_type" required>
                            <option value="">Select equipment</option>
                            <option value="solar_panel">Solar Panel</option>
                            <option value="inverter">Inverter</option>
                            <option value="battery">Battery</option>
                            <option value="charge_controller">Charge Controller</option>
                            <option value="cctv">CCTV Camera</option>
                            <option value="dvr_nvr">DVR/NVR</option>
                            <option value="access_control">Access Control System</option>
                            <option value="electric_scooter">Electric Scooter/Bike</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="repair-brand"><i class="fas fa-tag"></i> Brand</label>
                        <input type="text" id="repair-brand" name="brand" placeholder="e.g., Growatt, Felicity">
                    </div>
                </div>
                
                <div class="afrisol-form-group">
                    <label for="repair-model"><i class="fas fa-info-circle"></i> Model Number</label>
                    <input type="text" id="repair-model" name="model" placeholder="Enter model number if known">
                </div>
                
                <div class="afrisol-form-group">
                    <label for="repair-problem"><i class="fas fa-exclamation-triangle"></i> Problem Description <span class="required">*</span></label>
                    <textarea id="repair-problem" name="problem" rows="4" required placeholder="Describe the issue you're experiencing..."></textarea>
                </div>
                
                <div class="afrisol-form-group">
                    <label><i class="fas fa-camera"></i> Upload Photos/Videos (Optional)</label>
                    <div class="afrisol-image-upload-zone" id="repair-upload-zone">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Click to upload photos or videos of the issue</p>
                        <input type="file" name="media[]" multiple accept="image/*,video/*" style="display: none;" id="repair-media-input">
                    </div>
                    <div class="afrisol-image-preview" id="repair-preview"></div>
                </div>
                
                <div class="afrisol-form-row">
                    <div class="afrisol-form-group">
                        <label><i class="fas fa-shield-alt"></i> Under Warranty?</label>
                        <div class="afrisol-flex afrisol-gap-lg">
                            <label class="afrisol-checkbox">
                                <input type="radio" name="warranty" value="yes">
                                <span class="afrisol-checkbox-mark"></span>
                                Yes
                            </label>
                            <label class="afrisol-checkbox">
                                <input type="radio" name="warranty" value="no" checked>
                                <span class="afrisol-checkbox-mark"></span>
                                No
                            </label>
                            <label class="afrisol-checkbox">
                                <input type="radio" name="warranty" value="unsure">
                                <span class="afrisol-checkbox-mark"></span>
                                Not Sure
                            </label>
                        </div>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label><i class="fas fa-truck"></i> Service Type</label>
                        <div class="afrisol-flex afrisol-gap-lg">
                            <label class="afrisol-checkbox">
                                <input type="radio" name="service_type" value="on_site" checked>
                                <span class="afrisol-checkbox-mark"></span>
                                On-site Repair
                            </label>
                            <label class="afrisol-checkbox">
                                <input type="radio" name="service_type" value="drop_off">
                                <span class="afrisol-checkbox-mark"></span>
                                Drop-off at Center
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="afrisol-form-group">
                    <label for="repair-urgency"><i class="fas fa-clock"></i> Urgency Level</label>
                    <select id="repair-urgency" name="urgency">
                        <option value="normal">Normal (Within 1 week)</option>
                        <option value="urgent">Urgent (Within 48 hours)</option>
                        <option value="emergency">Emergency (Same day)</option>
                    </select>
                </div>
                
                <hr style="border-color: var(--afrisol-glass-border); margin: 30px 0;">
                
                <h3><i class="fas fa-user"></i> Contact Information</h3>
                
                <div class="afrisol-form-row">
                    <div class="afrisol-form-group">
                        <label for="repair-name"><i class="fas fa-user"></i> Full Name <span class="required">*</span></label>
                        <input type="text" id="repair-name" name="name" required placeholder="Enter your full name">
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="repair-email"><i class="fas fa-envelope"></i> Email <span class="required">*</span></label>
                        <input type="email" id="repair-email" name="email" required placeholder="Enter your email">
                    </div>
                </div>
                
                <div class="afrisol-form-row">
                    <div class="afrisol-form-group">
                        <label for="repair-phone"><i class="fas fa-phone"></i> Phone <span class="required">*</span></label>
                        <input type="tel" id="repair-phone" name="phone" required placeholder="Enter your phone number">
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label for="repair-address"><i class="fas fa-map-marker-alt"></i> Address</label>
                        <input type="text" id="repair-address" name="address" placeholder="For on-site service">
                    </div>
                </div>
                
                <button type="submit" class="afrisol-btn afrisol-btn-primary afrisol-btn-block">
                    <i class="fas fa-paper-plane"></i> Submit Repair Request
                </button>
            </form>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
    <?php echo do_shortcode('[afrisol_whatsapp]'); ?>
</div>
