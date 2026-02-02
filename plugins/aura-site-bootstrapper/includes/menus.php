<?php
/**
 * Menus management functionality
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
 * Create primary navigation menu
 * 
 * @param array $page_ids Array of page IDs created by asb_create_base_pages()
 * @return array Summary of menu creation process
 */
function asb_create_primary_menu($page_ids) {
    if (!$page_ids || !is_array($page_ids)) {
        return array(
            'menu_id' => 0,
            'items_added' => 0,
            'assigned_primary' => false
        );
    }
    
    $menu_name = 'Menú Principal';
    $items_added = 0;
    $assigned_primary = false;
    
    // Check if menu already exists or create new one
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    if ($menu_exists) {
        $menu_id = $menu_exists->term_id;
    } else {
        $menu_id = wp_create_nav_menu($menu_name);
        
        if (is_wp_error($menu_id)) {
            return array(
                'menu_id' => 0,
                'items_added' => 0,
                'assigned_primary' => false
            );
        }
    }
    
    // Get existing menu items to avoid duplicates
    $existing_items = wp_get_nav_menu_items($menu_id);
    $existing_object_ids = array();
    
    if ($existing_items) {
        foreach ($existing_items as $item) {
            if ($item->object === 'page' && $item->object_id) {
                $existing_object_ids[] = (int) $item->object_id;
            }
        }
    }
    
    // Define menu structure in order
    $menu_structure = array(
        'inicio' => __('Inicio', 'aura-site-bootstrapper'),
        'nosotros' => __('Nosotros', 'aura-site-bootstrapper'),
        'servicios' => __('Servicios', 'aura-site-bootstrapper'),
        'contacto' => __('Contacto', 'aura-site-bootstrapper')
    );
    
    $position = 1;
    
    // Add menu items, avoiding duplicates
    foreach ($menu_structure as $page_key => $page_title) {
        if (isset($page_ids[$page_key])) {
            $page_id = (int) $page_ids[$page_key];
            
            // Check if this page is already in the menu
            if (!in_array($page_id, $existing_object_ids)) {
                $result = wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => $page_title,
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $page_id,
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish',
                    'menu-item-position' => $position
                ));
                
                if (!is_wp_error($result)) {
                    $items_added++;
                }
            }
            
            $position++;
        }
    }
    
    // Assign to primary location if it exists
    $locations = get_nav_menu_locations();
    $theme_locations = get_registered_nav_menus();
    
    if (isset($theme_locations['primary'])) {
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
        $assigned_primary = true;
    }
    
    return array(
        'menu_id' => $menu_id,
        'items_added' => $items_added,
        'assigned_primary' => $assigned_primary
    );
}

/**
 * Add pages to navigation menu
 * 
 * @param int $menu_id Menu ID
 * @param array $page_ids Array of page IDs
 */
function asb_add_pages_to_menu($menu_id, $page_ids) {
    // Define menu structure
    $menu_items = array();
    
    // Add home first
    if (isset($page_ids['inicio'])) {
        $menu_items[] = array(
            'menu-item-title' => __('Inicio', 'aura-site-bootstrapper'),
            'menu-item-object' => 'page',
            'menu-item-object-id' => $page_ids['inicio'],
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-position' => 1
        );
    }
    
    // Add other pages in order
    $page_order = array(
        'nosotros' => array('title' => __('Nosotros', 'aura-site-bootstrapper'), 'position' => 2),
        'servicios' => array('title' => __('Servicios', 'aura-site-bootstrapper'), 'position' => 3),
        'contacto' => array('title' => __('Contacto', 'aura-site-bootstrapper'), 'position' => 4)
    );
    
    foreach ($page_order as $page_key => $page_info) {
        if (isset($page_ids[$page_key])) {
            $menu_items[] = array(
                'menu-item-title' => $page_info['title'],
                'menu-item-object' => 'page',
                'menu-item-object-id' => $page_ids[$page_key],
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish',
                'menu-item-position' => $page_info['position']
            );
        }
    }
    
    // Clear existing menu items (in case of re-running)
    $existing_items = wp_get_nav_menu_items($menu_id);
    if ($existing_items) {
        foreach ($existing_items as $item) {
            wp_delete_post($item->ID, true);
        }
    }
    
    // Add new menu items
    foreach ($menu_items as $item) {
        wp_update_nav_menu_item($menu_id, 0, $item);
    }
}

/**
 * Assign menu to theme location
 * 
 * @param int $menu_id Menu ID
 */
function asb_assign_menu_location($menu_id) {
    $locations = get_theme_mod('nav_menu_locations', array());
    
    // Try to assign to common menu locations
    $possible_locations = array('primary', 'main', 'header', 'main-menu', 'menu-1');
    $theme_locations = get_registered_nav_menus();
    
    foreach ($possible_locations as $location) {
        if (isset($theme_locations[$location])) {
            $locations[$location] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
            break;
        }
    }
    
    // If no common location found, assign to the first available
    if (empty($locations) && !empty($theme_locations)) {
        $first_location = array_keys($theme_locations)[0];
        $locations[$first_location] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}