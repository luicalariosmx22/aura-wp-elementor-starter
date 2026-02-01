/**
 * Aura Theme - Main JavaScript
 * 
 * @author Aura Marketing
 * @link https://agenciaaura.mx
 * @package AuraTheme
 */

(function() {
    'use strict';

    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Reserved for theme scripts
        // Add custom theme functionality here
        
        console.log('Aura Theme loaded successfully');
        
        // Theme utilities available globally
        window.AuraTheme = {
            version: '1.0.0',
            
            // Utility functions can be added here
            init: function() {
                console.log('AuraTheme initialized');
            }
        };
        
        // Initialize theme
        window.AuraTheme.init();
    });

})();