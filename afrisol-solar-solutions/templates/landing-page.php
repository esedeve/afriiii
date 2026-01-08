<?php
/**
 * Landing Page Template
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <?php echo do_shortcode('[afrisol_hero]'); ?>
    
    <?php echo do_shortcode('[afrisol_services]'); ?>
    
    <?php echo do_shortcode('[afrisol_why_choose]'); ?>
    
    <?php echo do_shortcode('[afrisol_featured_products]'); ?>
    
    <?php echo do_shortcode('[afrisol_testimonials]'); ?>
    
    <?php echo do_shortcode('[afrisol_map]'); ?>
    
    <?php echo do_shortcode('[afrisol_contact_form]'); ?>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
    <?php echo do_shortcode('[afrisol_whatsapp]'); ?>
    <?php echo do_shortcode('[afrisol_pwa_prompt]'); ?>
    <?php echo do_shortcode('[afrisol_mobile_nav]'); ?>
</div>
