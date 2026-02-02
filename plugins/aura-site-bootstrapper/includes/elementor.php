<?php
/**
 * Elementor integration functionality
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
 * Get supported tokens list for Discovery Mode
 * 
 * @return array List of supported tokens
 * @author Aura Marketing (https://agenciaaura.mx)
 */
function asb_get_supported_tokens() {
    return array(
        '{{AURA_BUSINESS_NAME}}',
        '{{AURA_BUSINESS_TAGLINE}}',
        '{{AURA_PHONE}}',
        '{{AURA_EMAIL}}',
        '{{AURA_WHATSAPP}}'
    );
}

/**
 * Scan for tokens recursively in data structure
 * 
 * @param mixed $data The data to scan
 * @param array $tokens List of tokens to search for
 * @param string $path Current path for tracking
 * @return array Matches with token, path, and sample
 * @author Aura Marketing (https://agenciaaura.mx)
 */
function asb_scan_tokens_recursive($data, array $tokens, $path = 'root') {
    $matches = array();
    
    if (is_string($data)) {
        foreach ($tokens as $token) {
            if (strpos($data, $token) !== false) {
                $sample = strlen($data) > 100 ? substr($data, 0, 97) . '...' : $data;
                $matches[] = array(
                    'token' => $token,
                    'path' => $path,
                    'sample' => $sample
                );
            }
        }
    } elseif (is_array($data)) {
        foreach ($data as $key => $value) {
            $current_path = $path . '.' . $key;
            $sub_matches = asb_scan_tokens_recursive($value, $tokens, $current_path);
            $matches = array_merge($matches, $sub_matches);
        }
    } elseif (is_object($data)) {
        foreach ($data as $key => $value) {
            $current_path = $path . '->' . $key;
            $sub_matches = asb_scan_tokens_recursive($value, $tokens, $current_path);
            $matches = array_merge($matches, $sub_matches);
        }
    }
    
    return $matches;
}

/**
 * Apply token replacement map recursively
 * 
 * @param mixed $data The data to process
 * @param array $map Token replacement map
 * @return mixed Processed data
 * @author Aura Marketing (https://agenciaaura.mx)
 */
function asb_apply_token_map_recursive($data, array $map) {
    if (is_string($data)) {
        return strtr($data, $map);
    } elseif (is_array($data)) {
        $result = array();
        foreach ($data as $key => $value) {
            // Don't replace in keys, only in values
            $result[$key] = asb_apply_token_map_recursive($value, $map);
        }
        return $result;
    } elseif (is_object($data)) {
        foreach ($data as $key => $value) {
            $data->$key = asb_apply_token_map_recursive($value, $map);
        }
        return $data;
    }
    
    return $data;
}

/**
 * Check if Elementor is active
 * 
 * @return bool True if Elementor is active, false otherwise
 */
function asb_is_elementor_active() {
    return class_exists('\Elementor\Plugin');
}

/**
 * Get detailed Elementor status
 * 
 * @return array Status information
 */
function asb_get_elementor_status() {
    $status = array(
        'active' => false,
        'installed' => false,
        'plugin_file' => 'elementor/elementor.php',
        'plugin_path' => WP_PLUGIN_DIR . '/elementor/elementor.php',
        'status_text' => '',
        'status_class' => '',
        'can_install' => false,
        'can_activate' => false,
        'action_url' => '',
        'action_text' => ''
    );
    
    // Check if user has permissions
    $status['can_install'] = current_user_can('install_plugins');
    $status['can_activate'] = current_user_can('activate_plugins');
    
    // Check if active
    if (class_exists('\Elementor\Plugin')) {
        $status['active'] = true;
        $status['installed'] = true;
        $status['status_text'] = __('Activo', 'aura-site-bootstrapper');
        $status['status_class'] = 'elementor-active';
    }
    // Check if installed but inactive
    elseif (file_exists($status['plugin_path'])) {
        $status['installed'] = true;
        $status['status_text'] = __('Instalado pero inactivo', 'aura-site-bootstrapper');
        $status['status_class'] = 'elementor-inactive';
        
        // Add activation link if user can activate
        if ($status['can_activate']) {
            $status['action_url'] = wp_nonce_url(
                self_admin_url('plugins.php?action=activate&plugin=' . $status['plugin_file']),
                'activate-plugin_' . $status['plugin_file']
            );
            $status['action_text'] = __('Activar Elementor', 'aura-site-bootstrapper');
        }
    }
    // Not installed
    else {
        $status['status_text'] = __('No instalado', 'aura-site-bootstrapper');
        $status['status_class'] = 'elementor-not-installed';
        
        // Add install link if user can install
        if ($status['can_install']) {
            $status['action_url'] = self_admin_url('update.php?action=install-plugin&plugin=elementor');
            $status['action_text'] = __('Instalar Elementor', 'aura-site-bootstrapper');
        }
    }
    
    return $status;
}

/**
 * Apply Elementor meta to pages
 * 
 * @param array $page_ids Array of page IDs to process
 * @param bool $reapply Whether to reapply meta to pages that already have Elementor data
 * @return array Summary of applied/skipped pages with reasons
 */
function asb_apply_elementor_meta($page_ids, $reapply = false) {
    // Check if Elementor is active
    if (!asb_is_elementor_active()) {
        return array(
            'elementor_active' => false,
            'skipped' => true,
            'reason' => 'Elementor plugin is not active'
        );
    }
    
    $results = array(
        'elementor_active' => true,
        'skipped' => false,
        'pages' => array()
    );
    
    // Get Elementor version
    $elementor_version = '';
    if (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance) {
        $elementor_version = (string) \Elementor\Plugin::$instance->get_version();
    }
    
    // Process each page
    foreach ($page_ids as $page_key => $page_id) {
        if (!$page_id || !is_numeric($page_id)) {
            $results['pages'][$page_key] = array(
                'status' => 'skipped',
                'reason' => 'Invalid page ID'
            );
            continue;
        }
        
        $page_id = (int) $page_id;
        
        // Check if page already has Elementor data and we shouldn't reapply
        if (!$reapply) {
            $existing_data = get_post_meta($page_id, '_elementor_data', true);
            if (!empty($existing_data)) {
                $results['pages'][$page_key] = array(
                    'status' => 'skipped',
                    'reason' => 'Page already has Elementor data (use reapply to override)'
                );
                continue;
            }
        }
        
        // Apply Elementor meta
        $meta_updates = array(
            '_elementor_edit_mode' => 'builder',
            '_elementor_template_type' => 'wp-page'
        );
        
        // Add version if available
        if (!empty($elementor_version)) {
            $meta_updates['_elementor_version'] = $elementor_version;
        }
        
        // Optionally set full width template
        $meta_updates['_wp_page_template'] = 'templates/template-fullwidth.php';
        
        // Update all meta fields
        $updated_count = 0;
        foreach ($meta_updates as $meta_key => $meta_value) {
            $update_result = update_post_meta($page_id, $meta_key, $meta_value);
            if ($update_result) {
                $updated_count++;
            }
        }
        
        $results['pages'][$page_key] = array(
            'status' => 'applied',
            'reason' => "Applied {$updated_count} meta fields for Elementor editing",
            'meta_applied' => array_keys($meta_updates),
            'page_id' => $page_id
        );
    }
    
    return $results;
}

/**
 * Replace placeholders recursively in arrays/strings
 * 
 * @param mixed $value Value to process (string, array, or other)
 * @param string $site_name Site name to replace AURA BUSINESS NAME
 * @param string $tagline Site tagline to replace AURA BUSINESS TAGLINE
 * @return mixed Processed value with replacements
 */
function asb_replace_placeholders_recursive($value, $site_name, $tagline) {
    if (is_string($value)) {
        // Replace placeholders in strings
        $value = str_replace('AURA BUSINESS NAME', $site_name, $value);
        $value = str_replace('AURA BUSINESS TAGLINE', $tagline, $value);
        return $value;
    } elseif (is_array($value)) {
        // Recursively process array values (not keys)
        $result = array();
        foreach ($value as $key => $item) {
            $result[$key] = asb_replace_placeholders_recursive($item, $site_name, $tagline);
        }
        return $result;
    } else {
        // Return other types unchanged
        return $value;
    }
}

/**
 * Load Elementor template data from JSON file
 * 
 * @param string $file_path Absolute path to JSON template file
 * @return array Template data array or empty array on failure
 */
function asb_load_elementor_template_data($file_path) {
    try {
        // Check if file exists
        if (!file_exists($file_path)) {
            return array(
                'success' => false,
                'error' => 'Template file not found: ' . basename($file_path)
            );
        }
        
        // Read file content
        $json_content = file_get_contents($file_path);
        if ($json_content === false) {
            return array(
                'success' => false,
                'error' => 'Could not read template file: ' . basename($file_path)
            );
        }
        
        // Decode JSON
        $data = json_decode($json_content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return array(
                'success' => false,
                'error' => 'Invalid JSON in template file: ' . json_last_error_msg()
            );
        }
        
        // Check if data has 'content' key (some templates might be wrapped)
        if (is_array($data) && isset($data['content']) && is_array($data['content'])) {
            return array(
                'success' => true,
                'data' => $data['content']
            );
        }
        
        // If data is already an array, return it
        if (is_array($data)) {
            return array(
                'success' => true,
                'data' => $data
            );
        }
        
        return array(
            'success' => false,
            'error' => 'Template data is not in expected array format'
        );
        
    } catch (Exception $e) {
        return array(
            'success' => false,
            'error' => 'Exception loading template: ' . $e->getMessage()
        );
    }
}

/**
 * Import Elementor JSON templates to pages with Discovery Mode support
 * 
 * @param array $page_ids Array of page IDs mapped by slug
 * @param bool $reapply Whether to reapply templates even if data exists
 * @return array Results summary with success/failure details and Discovery Mode data
 * @author Aura Marketing (https://agenciaaura.mx)
 */
function asb_import_elementor_json_templates($page_ids, $reapply = false) {
    // Check if Elementor is active
    if (!asb_is_elementor_active()) {
        return array(
            'elementor_active' => false,
            'skipped' => true,
            'reason' => 'Elementor plugin is not active'
        );
    }
    
    // Template mapping: page slug => template file
    $template_mapping = array(
        'inicio' => 'home.json',
        'nosotros' => 'about.json',
        'acerca-de' => 'about.json', // Alternative slug
        'servicios' => 'services.json',
        'contacto' => 'contact.json'
    );
    
    $results = array(
        'elementor_active' => true,
        'skipped' => false,
        'pages' => array(),
        'templates_applied' => 0,
        'templates_skipped' => 0,
        'errors' => array(),
        // Discovery Mode data
        'tokens_found_before' => array(),
        'tokens_found_after' => array(),
        'unresolved_paths' => array()
    );
    
    // Get site info for placeholder replacement
    $site_name = get_bloginfo('name');
    $tagline = get_bloginfo('description');
    
    // Get Elementor version
    $elementor_version = '3.0.0'; // Default fallback
    if (defined('ELEMENTOR_VERSION')) {
        $elementor_version = ELEMENTOR_VERSION;
    }
    
    // Get templates directory
    $templates_dir = ASB_PATH . 'templates/elementor/';
    
    // Get supported tokens for Discovery Mode
    $supported_tokens = asb_get_supported_tokens();
    
    // Initialize Discovery Mode counters
    foreach ($supported_tokens as $token) {
        $results['tokens_found_before'][$token] = 0;
        $results['tokens_found_after'][$token] = 0;
    }
    
    foreach ($page_ids as $page_slug => $page_id) {
        $page_result = array(
            'page_id' => $page_id,
            'page_slug' => $page_slug,
            'template_applied' => false,
            'skipped' => false,
            'error' => false,
            'message' => ''
        );
        
        // Skip invalid page IDs
        if (!$page_id || !is_numeric($page_id)) {
            $page_result['skipped'] = true;
            $page_result['message'] = 'Invalid page ID';
            $results['pages'][$page_slug] = $page_result;
            $results['templates_skipped']++;
            continue;
        }
        
        $page_id = (int) $page_id;
        $post = get_post($page_id);
        if (!$post) {
            $page_result['skipped'] = true;
            $page_result['message'] = 'Page not found';
            $results['pages'][$page_slug] = $page_result;
            $results['templates_skipped']++;
            continue;
        }
        
        // Check if we have a template for this page
        if (!isset($template_mapping[$page_slug])) {
            $page_result['skipped'] = true;
            $page_result['message'] = 'No template available for this page';
            $results['pages'][$page_slug] = $page_result;
            $results['templates_skipped']++;
            continue;
        }
        
        // Check if page already has Elementor data (unless reapplying)
        if (!$reapply) {
            $existing_data = get_post_meta($page_id, '_elementor_data', true);
            if (!empty($existing_data)) {
                $page_result['skipped'] = true;
                $page_result['message'] = 'Page already has Elementor data (use reapply to override)';
                $results['pages'][$page_slug] = $page_result;
                $results['templates_skipped']++;
                continue;
            }
        }
        
        // Load template data
        $template_file = $templates_dir . $template_mapping[$page_slug];
        $template_data = asb_load_elementor_template_data($template_file);
        
        if (!$template_data['success']) {
            $page_result['error'] = true;
            $page_result['message'] = $template_data['error'];
            $results['pages'][$page_slug] = $page_result;
            $results['errors'][] = "Page {$page_slug}: " . $template_data['error'];
            continue;
        }
        
        // Discovery Mode: Scan before replacement
        $scan_before = asb_scan_tokens_recursive($template_data['data'], $supported_tokens, $page_slug);
        foreach ($scan_before as $match) {
            $results['tokens_found_before'][$match['token']]++;
        }
        
        // Create token replacement map with new format
        $token_map = array(
            '{{AURA_BUSINESS_NAME}}' => $site_name,
            '{{AURA_BUSINESS_TAGLINE}}' => $tagline,
            '{{AURA_PHONE}}' => get_option('asb_business_phone', ''),
            '{{AURA_EMAIL}}' => get_option('asb_business_email', ''),
            '{{AURA_WHATSAPP}}' => get_option('asb_business_whatsapp', '')
        );
        
        // Apply token replacement using new system
        $processed_data = asb_apply_token_map_recursive($template_data['data'], $token_map);
        
        // Discovery Mode: Scan after replacement
        $scan_after = asb_scan_tokens_recursive($processed_data, $supported_tokens, $page_slug);
        foreach ($scan_after as $match) {
            $results['tokens_found_after'][$match['token']]++;
            // Collect unresolved paths (limit to 50)
            if (count($results['unresolved_paths']) < 50) {
                $results['unresolved_paths'][] = $match['path'] . ' -> ' . $match['token'];
            }
        }
        
        // Save template data using Elementor's DB manager
        try {
            if (class_exists('\Elementor\Plugin') && 
                \Elementor\Plugin::$instance && 
                \Elementor\Plugin::$instance->db) {
                
                $save_result = \Elementor\Plugin::$instance->db->save_builder($page_id, $processed_data);
                
                if ($save_result) {
                    // Ensure minimum meta fields
                    update_post_meta($page_id, '_elementor_edit_mode', 'builder');
                    update_post_meta($page_id, '_elementor_template_type', 'wp-page');
                    update_post_meta($page_id, '_elementor_version', $elementor_version);
                    
                    $page_result['template_applied'] = true;
                    $page_result['message'] = 'Template imported successfully from ' . $template_mapping[$page_slug];
                    $results['templates_applied']++;
                } else {
                    $page_result['error'] = true;
                    $page_result['message'] = 'Failed to save Elementor data';
                    $results['errors'][] = "Page {$page_slug}: Failed to save Elementor data";
                }
            } else {
                throw new Exception('Elementor DB manager not available');
            }
            
        } catch (Exception $e) {
            $page_result['error'] = true;
            $page_result['message'] = 'Exception during save: ' . $e->getMessage();
            $results['errors'][] = "Page {$page_slug}: " . $e->getMessage();
        }
        
        $results['pages'][$page_slug] = $page_result;
    }
    
    // Clear Elementor cache if possible
    try {
        if (class_exists('\Elementor\Plugin') && 
            \Elementor\Plugin::$instance && 
            \Elementor\Plugin::$instance->files_manager &&
            method_exists(\Elementor\Plugin::$instance->files_manager, 'clear_cache')) {
            \Elementor\Plugin::$instance->files_manager->clear_cache();
        }
    } catch (Exception $e) {
        // Don't fail if cache clearing fails
        error_log('ASB: Could not clear Elementor cache: ' . $e->getMessage());
    }
    
    return $results;
}