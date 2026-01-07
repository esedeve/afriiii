<?php
/**
 * WhatsApp Widget Component
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$whatsapp = isset($settings['whatsapp']) ? $settings['whatsapp'] : '';
$whatsapp_number = preg_replace('/[^0-9]/', '', $whatsapp);

if (empty($whatsapp_number)) {
    $whatsapp_number = '234XXXXXXXXXX';
}
?>
<a href="https://wa.me/<?php echo esc_attr($whatsapp_number); ?>?text=<?php echo urlencode('Hello Afrisol, I would like to inquire about your products/services.'); ?>" 
   class="afrisol-whatsapp-widget" 
   target="_blank" 
   rel="noopener noreferrer" 
   aria-label="Chat on WhatsApp"
   title="Chat with us on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>
