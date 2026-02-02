<?php
/**
 * Plugin activation handler
 * 
 * @package AuraSiteBootstrapper
 * @author Aura Marketing
 * @link https://agenciaaura.mx
 * @since 0.1.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Plugin activation function
 * 
 * @since 0.1.0
 */
function asb_activate() {
    // Create/update bootstrapper option with installation data
    $bootstrapper_data = array(
        'version' => ASB_VERSION,
        'installed_at' => current_time('mysql'),
    );
    
    update_option('asb_bootstrapper', $bootstrapper_data);
    
    // Flush rewrite rules
    flush_rewrite_rules();
}