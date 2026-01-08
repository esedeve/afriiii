<?php
/**
 * Solar Calculator Page Template
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$currency_symbol = isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '₦';
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-section" style="padding-top: 120px;">
        <div class="afrisol-container">
            <div class="afrisol-section-header afrisol-fade-in">
                <span class="afrisol-badge afrisol-badge-primary"><i class="fas fa-calculator"></i> Interactive Tool</span>
                <h1>Solar Savings Calculator</h1>
                <p>Discover how much you can save by switching to solar energy</p>
            </div>
            
            <div class="afrisol-calculator-wrapper">
                <div class="afrisol-calculator-form afrisol-fade-in">
                    <form class="afrisol-form" id="solar-calculator-form">
                        <div class="afrisol-form-group">
                            <label for="calc-location">
                                <i class="fas fa-map-marker-alt"></i> Location
                            </label>
                            <select id="calc-location" name="location">
                                <option value="">Select your state</option>
                                <option value="abuja">Abuja FCT</option>
                                <option value="lagos">Lagos</option>
                                <option value="kano">Kano</option>
                                <option value="rivers">Rivers</option>
                                <option value="oyo">Oyo</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label for="calc-property">
                                <i class="fas fa-home"></i> Property Type
                            </label>
                            <select id="calc-property" name="property_type">
                                <option value="">Select property type</option>
                                <option value="residential_small">Small Residence (1-2 bedrooms)</option>
                                <option value="residential_medium">Medium Residence (3-4 bedrooms)</option>
                                <option value="residential_large">Large Residence (5+ bedrooms)</option>
                                <option value="commercial_small">Small Business</option>
                                <option value="commercial_medium">Medium Business</option>
                                <option value="commercial_large">Large Business/Industrial</option>
                            </select>
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label for="calc-bill">
                                <i class="fas fa-file-invoice-dollar"></i> Monthly Electricity Bill (<?php echo esc_html($currency_symbol); ?>)
                            </label>
                            <input type="number" id="calc-bill" name="monthly_bill" placeholder="e.g., 50000">
                            <span class="afrisol-form-hint">Or add appliances below</span>
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label><i class="fas fa-plug"></i> Appliances (Optional)</label>
                            <div class="afrisol-appliances-list" id="appliances-list">
                                <div class="afrisol-appliance-row">
                                    <select name="appliance[]">
                                        <option value="">Select appliance</option>
                                        <option value="ac_1hp" data-watts="1000">AC (1 HP)</option>
                                        <option value="ac_2hp" data-watts="2000">AC (2 HP)</option>
                                        <option value="fridge" data-watts="150">Refrigerator</option>
                                        <option value="freezer" data-watts="200">Freezer</option>
                                        <option value="tv" data-watts="100">TV</option>
                                        <option value="fan" data-watts="75">Fan</option>
                                        <option value="lights" data-watts="50">Lights (5 bulbs)</option>
                                        <option value="pump" data-watts="750">Water Pump</option>
                                        <option value="washer" data-watts="500">Washing Machine</option>
                                    </select>
                                    <input type="number" name="quantity[]" placeholder="Qty" min="1" value="1" style="width: 80px;">
                                    <input type="number" name="hours[]" placeholder="Hrs/day" min="1" max="24" value="4" style="width: 100px;">
                                </div>
                            </div>
                            <button type="button" class="afrisol-btn afrisol-btn-ghost afrisol-btn-sm afrisol-mt-2" id="add-appliance">
                                <i class="fas fa-plus"></i> Add Appliance
                            </button>
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label for="calc-roof">
                                <i class="fas fa-warehouse"></i> Roof Type
                            </label>
                            <select id="calc-roof" name="roof_type">
                                <option value="">Select roof type</option>
                                <option value="flat">Flat Roof</option>
                                <option value="sloped">Sloped/Pitched Roof</option>
                                <option value="metal">Metal Sheet Roof</option>
                                <option value="concrete">Concrete Roof</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="afrisol-btn afrisol-btn-primary afrisol-btn-block">
                            <i class="fas fa-calculator"></i> Calculate Savings
                        </button>
                    </form>
                </div>
                
                <div class="afrisol-calculator-results afrisol-fade-in" id="calculator-results">
                    <div class="afrisol-result-card">
                        <h4><i class="fas fa-solar-panel"></i> Recommended System</h4>
                        <div class="afrisol-result-value" id="result-system">--</div>
                    </div>
                    
                    <div class="afrisol-result-card">
                        <h4><i class="fas fa-tag"></i> Estimated Cost</h4>
                        <div class="afrisol-result-value" id="result-cost">--</div>
                    </div>
                    
                    <div class="afrisol-result-card">
                        <h4><i class="fas fa-piggy-bank"></i> Monthly Savings</h4>
                        <div class="afrisol-result-value" id="result-savings">--</div>
                    </div>
                    
                    <div class="afrisol-result-card">
                        <h4><i class="fas fa-chart-line"></i> ROI Timeline</h4>
                        <div class="afrisol-result-value" id="result-roi">--</div>
                    </div>
                    
                    <div class="afrisol-result-card">
                        <h4><i class="fas fa-leaf"></i> CO2 Saved Annually</h4>
                        <div class="afrisol-result-value" id="result-co2">--</div>
                    </div>
                    
                    <a href="<?php echo esc_url(home_url('/afrisol-quote/')); ?>" class="afrisol-btn afrisol-btn-primary afrisol-btn-block afrisol-mt-3" id="get-proposal-btn" style="display: none;">
                        <i class="fas fa-file-alt"></i> Get Detailed Proposal
                    </a>
                </div>
            </div>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
    <?php echo do_shortcode('[afrisol_whatsapp]'); ?>
</div>
