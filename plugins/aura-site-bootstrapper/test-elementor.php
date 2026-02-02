<?php
/**
 * Test script for Elementor integration
 * This file should be removed in production
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Test Elementor integration functions
 */
function asb_test_elementor_integration() {
    echo "<h2>Testing Enhanced Elementor Integration</h2>";
    
    // Test 1: Check if functions exist
    echo "<h3>1. Function Availability</h3>";
    $functions_to_check = [
        'asb_get_elementor_status',
        'asb_replace_placeholders_recursive',
        'asb_load_elementor_template_data',
        'asb_import_elementor_json_templates'
    ];
    
    foreach ($functions_to_check as $func) {
        if (function_exists($func)) {
            echo "✓ {$func}() function exists<br>";
        } else {
            echo "✗ {$func}() function NOT found<br>";
        }
    }
    
    // Test 2: Test placeholder replacement
    echo "<h3>2. Placeholder Replacement Test</h3>";
    $test_data = array(
        'title' => 'Welcome to AURA BUSINESS NAME',
        'description' => 'AURA BUSINESS TAGLINE for success',
        'nested' => array(
            'content' => 'Contact AURA BUSINESS NAME today'
        )
    );
    
    $processed = asb_replace_placeholders_recursive($test_data, 'My Company', 'Excellence in Service');
    echo "<h4>Original Data:</h4><pre>" . print_r($test_data, true) . "</pre>";
    echo "<h4>After Replacement:</h4><pre>" . print_r($processed, true) . "</pre>";
    
    // Test 3: Test template loading
    echo "<h3>3. Template Loading Test</h3>";
    $template_files = array(
        'home.json',
        'about.json', 
        'services.json',
        'contact.json'
    );
    
    foreach ($template_files as $template) {
        $template_path = ASB_PATH . 'templates/elementor/' . $template;
        echo "<h4>Testing {$template}:</h4>";
        
        if (file_exists($template_path)) {
            echo "✓ File exists<br>";
            $result = asb_load_elementor_template_data($template_path);
            if ($result['success']) {
                echo "✓ JSON valid - " . count($result['data']) . " elements loaded<br>";
            } else {
                echo "✗ Error: " . $result['error'] . "<br>";
            }
        } else {
            echo "✗ File not found: {$template_path}<br>";
        }
    }
    
    // Test 4: Check Elementor status
    echo "<h3>4. Elementor Status Check</h3>";
    if (function_exists('asb_get_elementor_status')) {
        $status = asb_get_elementor_status();
        echo "<h4>Elementor Status Details:</h4>";
        echo "<pre>" . print_r($status, true) . "</pre>";
    }
    
    echo "<hr>";
    echo "<p><strong>Enhanced integration test completed!</strong></p>";
}

// Auto-run test if accessed directly (for debugging)
if (defined('WP_DEBUG') && WP_DEBUG && isset($_GET['test_elementor'])) {
    add_action('wp_footer', 'asb_test_elementor_integration');
    add_action('admin_footer', 'asb_test_elementor_integration');
}