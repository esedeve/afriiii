<?php
/**
 * Fired during plugin deactivation
 */
class Afrisol_Deactivator {
    
    /**
     * Deactivate the plugin
     */
    public static function deactivate() {
        // Flush rewrite rules
        flush_rewrite_rules();
        
        // Clear any scheduled events
        wp_clear_scheduled_hook('afrisol_daily_cleanup');
    }
}
