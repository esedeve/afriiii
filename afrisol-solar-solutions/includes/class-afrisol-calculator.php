<?php
/**
 * Solar Calculator functionality
 */
class Afrisol_Calculator {
    
    /**
     * Calculate solar system requirements
     */
    public static function calculate($data) {
        // Sanitize input
        $location = isset($data['location']) ? sanitize_text_field(wp_unslash($data['location'])) : '';
        $property_type = isset($data['property_type']) ? sanitize_text_field(wp_unslash($data['property_type'])) : 'residential';
        $monthly_bill = isset($data['monthly_bill']) ? floatval($data['monthly_bill']) : 0;
        $roof_type = isset($data['roof_type']) ? sanitize_text_field(wp_unslash($data['roof_type'])) : 'flat';
        $available_space = isset($data['available_space']) ? floatval($data['available_space']) : 0;
        
        // Get appliances if provided
        $appliances = isset($data['appliances']) ? $data['appliances'] : array();
        
        // Calculate daily energy consumption
        $daily_kwh = 0;
        
        if (!empty($appliances) && is_array($appliances)) {
            foreach ($appliances as $appliance) {
                $watts = floatval($appliance['watts']);
                $hours = floatval($appliance['hours']);
                $quantity = intval($appliance['quantity']);
                
                $daily_kwh += ($watts * $hours * $quantity) / 1000;
            }
        } elseif ($monthly_bill > 0) {
            // Estimate from monthly bill
            // Average electricity tariff in Nigeria: approximately ₦60-100 per kWh
            $tariff = 80; // NGN per kWh
            $monthly_kwh = $monthly_bill / $tariff;
            $daily_kwh = $monthly_kwh / 30;
        }
        
        // Calculate system size
        // Average sun hours in Nigeria: 4-6 hours
        $sun_hours = 5;
        
        // System losses: 25% (inverter efficiency, cable losses, dust, etc.)
        $system_efficiency = 0.75;
        
        // Required system size in kW
        $system_size_kw = ($daily_kwh / $sun_hours) / $system_efficiency;
        
        // Round up to nearest 0.5 kW
        $system_size_kw = ceil($system_size_kw * 2) / 2;
        
        // Minimum system size
        if ($system_size_kw < 1) {
            $system_size_kw = 1;
        }
        
        // Calculate components needed
        $panel_wattage = 450; // Watts per panel
        $num_panels = ceil(($system_size_kw * 1000) / $panel_wattage);
        
        // Battery sizing (for 24 hours backup)
        $battery_capacity_kwh = $daily_kwh * 1.5; // 1.5x for depth of discharge
        $battery_voltage = 48;
        $battery_ah = ($battery_capacity_kwh * 1000) / $battery_voltage;
        
        // Inverter sizing (system size + 20% overhead)
        $inverter_kva = ceil($system_size_kw * 1.2);
        
        // Cost estimation
        $cost_per_kw = self::get_cost_per_kw($property_type);
        $estimated_cost_low = $system_size_kw * $cost_per_kw * 0.85;
        $estimated_cost_high = $system_size_kw * $cost_per_kw * 1.15;
        
        // Monthly savings
        $monthly_savings = $monthly_bill > 0 ? $monthly_bill * 0.8 : $daily_kwh * 30 * 80 * 0.8;
        
        // ROI calculation
        $average_cost = ($estimated_cost_low + $estimated_cost_high) / 2;
        $annual_savings = $monthly_savings * 12;
        $roi_years = $annual_savings > 0 ? $average_cost / $annual_savings : 0;
        
        // Environmental impact
        // Average CO2 emission for grid electricity in Nigeria: 0.5 kg CO2/kWh
        $annual_kwh = $daily_kwh * 365;
        $co2_saved_kg = $annual_kwh * 0.5;
        $trees_equivalent = $co2_saved_kg / 22; // Average tree absorbs 22kg CO2/year
        
        return array(
            'system_size' => array(
                'kw' => $system_size_kw,
                'panels' => $num_panels,
                'panel_wattage' => $panel_wattage,
            ),
            'battery' => array(
                'capacity_kwh' => round($battery_capacity_kwh, 1),
                'ah' => round($battery_ah),
                'voltage' => $battery_voltage,
            ),
            'inverter' => array(
                'kva' => $inverter_kva,
            ),
            'energy' => array(
                'daily_kwh' => round($daily_kwh, 2),
                'monthly_kwh' => round($daily_kwh * 30, 2),
                'annual_kwh' => round($annual_kwh, 2),
            ),
            'cost' => array(
                'estimated_low' => round($estimated_cost_low),
                'estimated_high' => round($estimated_cost_high),
                'currency' => 'NGN',
            ),
            'savings' => array(
                'monthly' => round($monthly_savings),
                'annual' => round($annual_savings),
                'roi_years' => round($roi_years, 1),
            ),
            'environment' => array(
                'co2_saved_kg' => round($co2_saved_kg),
                'co2_saved_tons' => round($co2_saved_kg / 1000, 2),
                'trees_equivalent' => round($trees_equivalent),
            ),
            'recommendations' => self::get_recommendations($system_size_kw, $property_type),
        );
    }
    
    /**
     * Get cost per kW based on property type
     */
    private static function get_cost_per_kw($property_type) {
        $costs = array(
            'residential' => 800000, // NGN per kW
            'commercial' => 750000,
            'industrial' => 700000,
        );
        
        return isset($costs[$property_type]) ? $costs[$property_type] : $costs['residential'];
    }
    
    /**
     * Get product recommendations
     */
    private static function get_recommendations($system_size_kw, $property_type) {
        $recommendations = array();
        
        // Get matching products from inventory
        $inverter_kva = ceil($system_size_kw * 1.2);
        
        // Find suitable inverter
        $inverters = get_posts(array(
            'post_type' => 'afrisol_product',
            'posts_per_page' => 3,
            'tax_query' => array(
                array(
                    'taxonomy' => 'afrisol_product_cat',
                    'field' => 'slug',
                    'terms' => 'inverters',
                ),
            ),
            'orderby' => 'meta_value_num',
            'meta_key' => '_afrisol_price',
            'order' => 'ASC',
        ));
        
        foreach ($inverters as $inverter) {
            $recommendations['inverters'][] = array(
                'id' => $inverter->ID,
                'title' => $inverter->post_title,
                'price' => get_post_meta($inverter->ID, '_afrisol_price', true),
                'power' => get_post_meta($inverter->ID, '_afrisol_power', true),
                'image' => get_the_post_thumbnail_url($inverter->ID, 'thumbnail'),
            );
        }
        
        // Find suitable panels
        $panels = get_posts(array(
            'post_type' => 'afrisol_product',
            'posts_per_page' => 3,
            'tax_query' => array(
                array(
                    'taxonomy' => 'afrisol_product_cat',
                    'field' => 'slug',
                    'terms' => 'solar-panels',
                ),
            ),
            'orderby' => 'meta_value_num',
            'meta_key' => '_afrisol_price',
            'order' => 'ASC',
        ));
        
        foreach ($panels as $panel) {
            $recommendations['panels'][] = array(
                'id' => $panel->ID,
                'title' => $panel->post_title,
                'price' => get_post_meta($panel->ID, '_afrisol_price', true),
                'power' => get_post_meta($panel->ID, '_afrisol_power', true),
                'image' => get_the_post_thumbnail_url($panel->ID, 'thumbnail'),
            );
        }
        
        // Find suitable batteries
        $batteries = get_posts(array(
            'post_type' => 'afrisol_product',
            'posts_per_page' => 3,
            'tax_query' => array(
                array(
                    'taxonomy' => 'afrisol_product_cat',
                    'field' => 'slug',
                    'terms' => 'batteries',
                ),
            ),
            'orderby' => 'meta_value_num',
            'meta_key' => '_afrisol_price',
            'order' => 'ASC',
        ));
        
        foreach ($batteries as $battery) {
            $recommendations['batteries'][] = array(
                'id' => $battery->ID,
                'title' => $battery->post_title,
                'price' => get_post_meta($battery->ID, '_afrisol_price', true),
                'power' => get_post_meta($battery->ID, '_afrisol_power', true),
                'image' => get_the_post_thumbnail_url($battery->ID, 'thumbnail'),
            );
        }
        
        return $recommendations;
    }
    
    /**
     * Get common appliances list
     */
    public static function get_appliances_list() {
        return array(
            array('name' => 'LED Bulb', 'watts' => 10, 'typical_hours' => 6),
            array('name' => 'CFL Bulb', 'watts' => 20, 'typical_hours' => 6),
            array('name' => 'Ceiling Fan', 'watts' => 75, 'typical_hours' => 8),
            array('name' => 'Standing Fan', 'watts' => 60, 'typical_hours' => 8),
            array('name' => 'TV (32" LED)', 'watts' => 50, 'typical_hours' => 6),
            array('name' => 'TV (50" LED)', 'watts' => 100, 'typical_hours' => 6),
            array('name' => 'Refrigerator', 'watts' => 150, 'typical_hours' => 24),
            array('name' => 'Deep Freezer', 'watts' => 200, 'typical_hours' => 24),
            array('name' => 'Air Conditioner (1HP)', 'watts' => 900, 'typical_hours' => 8),
            array('name' => 'Air Conditioner (1.5HP)', 'watts' => 1200, 'typical_hours' => 8),
            array('name' => 'Air Conditioner (2HP)', 'watts' => 1800, 'typical_hours' => 8),
            array('name' => 'Washing Machine', 'watts' => 500, 'typical_hours' => 1),
            array('name' => 'Microwave', 'watts' => 1000, 'typical_hours' => 0.5),
            array('name' => 'Electric Iron', 'watts' => 1000, 'typical_hours' => 0.5),
            array('name' => 'Water Heater', 'watts' => 2000, 'typical_hours' => 1),
            array('name' => 'Laptop', 'watts' => 65, 'typical_hours' => 8),
            array('name' => 'Desktop Computer', 'watts' => 200, 'typical_hours' => 8),
            array('name' => 'Phone Charger', 'watts' => 10, 'typical_hours' => 3),
            array('name' => 'Router/Modem', 'watts' => 15, 'typical_hours' => 24),
            array('name' => 'CCTV System', 'watts' => 50, 'typical_hours' => 24),
            array('name' => 'Security Light', 'watts' => 30, 'typical_hours' => 12),
            array('name' => 'Blender', 'watts' => 400, 'typical_hours' => 0.25),
            array('name' => 'Electric Kettle', 'watts' => 1500, 'typical_hours' => 0.5),
            array('name' => 'Printer', 'watts' => 50, 'typical_hours' => 1),
            array('name' => 'Water Pump', 'watts' => 750, 'typical_hours' => 2),
        );
    }
}
