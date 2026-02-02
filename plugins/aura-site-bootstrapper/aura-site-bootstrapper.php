<?php
/**
 * Plugin Name: Aura Site Bootstrapper
 * Plugin URI: https://agenciaaura.mx
 * Description: Crea páginas y menú base (compatible con Elementor).
 * Version: 0.1.0
 * Author: Aura Marketing
 * Author URI: https://agenciaaura.mx
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: aura-site-bootstrapper
 * Domain Path: /languages
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

// Define plugin constants
define('ASB_VERSION', '0.1.0');
define('ASB_PATH', plugin_dir_path(__FILE__));
define('ASB_URL', plugin_dir_url(__FILE__));

// Include required files
require_once ASB_PATH . 'includes/activator.php';
require_once ASB_PATH . 'includes/pages.php';
require_once ASB_PATH . 'includes/menus.php';
require_once ASB_PATH . 'includes/elementor.php';

// Include test file only in debug mode
if (defined('WP_DEBUG') && WP_DEBUG) {
    require_once ASB_PATH . 'test-elementor.php';
}

// Plugin activation hook
register_activation_hook(__FILE__, 'asb_activate');

// Admin hooks
add_action('admin_menu', 'asb_admin_menu');
add_action('admin_post_asb_run', 'asb_handle_form_submission');
add_action('admin_notices', 'asb_admin_notices');

/**
 * Add admin menu
 */
function asb_admin_menu() {
    add_management_page(
        __('Aura Bootstrapper', 'aura-site-bootstrapper'),
        __('Aura Bootstrapper', 'aura-site-bootstrapper'),
        'manage_options',
        'aura-bootstrapper',
        'asb_admin_page'
    );
}

/**
 * Admin page callback
 */
function asb_admin_page() {
    // Detect Elementor status
    $elementor_active = class_exists('\Elementor\Plugin');
    $elementor_installed = file_exists(WP_PLUGIN_DIR . '/elementor/elementor.php');
    
    // Check user permissions
    $can_install = current_user_can('install_plugins');
    $can_activate = current_user_can('activate_plugins');
    $has_permissions = $can_install && $can_activate;
    
    // Determine status and actions
    $status_text = '';
    $status_class = '';
    $action_button = '';
    
    if ($elementor_active) {
        $status_text = __('Activo', 'aura-site-bootstrapper');
        $status_class = 'asb-status-active';
    } elseif ($elementor_installed) {
        $status_text = __('Instalado pero inactivo', 'aura-site-bootstrapper');
        $status_class = 'asb-status-inactive';
        
        if ($has_permissions) {
            $activate_url = wp_nonce_url(
                self_admin_url('plugins.php?action=activate&plugin=elementor/elementor.php'),
                'activate-plugin_elementor/elementor.php'
            );
            $action_button = '<a href="' . esc_url($activate_url) . '" class="button button-secondary">' . 
                           esc_html__('Activar Elementor', 'aura-site-bootstrapper') . '</a>';
        }
    } else {
        $status_text = __('No instalado', 'aura-site-bootstrapper');
        $status_class = 'asb-status-not-installed';
        
        if ($has_permissions) {
            $install_url = self_admin_url('update.php?action=install-plugin&plugin=elementor');
            $action_button = '<a href="' . esc_url($install_url) . '" class="button button-secondary">' . 
                           esc_html__('Instalar Elementor', 'aura-site-bootstrapper') . '</a>';
        }
    }
    
    ?>
    <style>
        .asb-status-badge {
            padding: 4px 8px;
            border-radius: 3px;
            font-weight: 500;
            display: inline-block;
        }
        .asb-status-active {
            background-color: #d1f2eb;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .asb-status-inactive {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        .asb-status-not-installed {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .asb-admin-card {
            background: #fff;
            border: 1px solid #c3c4c7;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
            padding: 20px;
            margin-bottom: 20px;
        }
        .asb-admin-card h2 {
            margin-top: 0;
            color: #1d2327;
        }
    </style>
    
    <div class="wrap">
        <h1><?php _e('Aura Site Bootstrapper', 'aura-site-bootstrapper'); ?></h1>
        <p><?php _e('Crea páginas básicas y menú principal para acelerar el setup del sitio.', 'aura-site-bootstrapper'); ?></p>
        
        <div class="asb-admin-card" style="max-width: 700px;">
            <h2><?php _e('Estado del Sistema', 'aura-site-bootstrapper'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('Elementor:', 'aura-site-bootstrapper'); ?></th>
                    <td>
                        <span class="asb-status-badge <?php echo esc_attr($status_class); ?>">
                            <?php 
                            if ($elementor_active) {
                                echo '✓ ' . esc_html($status_text);
                            } elseif ($elementor_installed) {
                                echo '⚠ ' . esc_html($status_text);
                            } else {
                                echo '✗ ' . esc_html($status_text);
                            }
                            ?>
                        </span>
                        
                        <?php if (!empty($action_button)): ?>
                            <br><br>
                            <?php echo $action_button; ?>
                        <?php endif; ?>
                        
                        <?php if (!$has_permissions && !$elementor_active): ?>
                            <br><br>
                            <em style="color: #666;">
                                <?php _e('Pide a un administrador que instale/active Elementor.', 'aura-site-bootstrapper'); ?>
                            </em>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="asb-admin-card" style="max-width: 700px;">
            <h2><?php _e('Crear Estructura Base', 'aura-site-bootstrapper'); ?></h2>
            <p><?php _e('Esto creará las páginas esenciales y el menú principal del sitio.', 'aura-site-bootstrapper'); ?></p>
            
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('asb_create_base', 'asb_nonce'); ?>
                <input type="hidden" name="action" value="asb_run" />
                
                <table class="form-table">
                    <?php if ($elementor_active): ?>
                    <tr>
                        <th scope="row">
                            <label for="apply_elementor_meta"><?php _e('Preparar para Elementor', 'aura-site-bootstrapper'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="apply_elementor_meta" name="apply_elementor_meta" value="1" checked />
                            <label for="apply_elementor_meta"><?php _e('Agregar meta para edición con Elementor', 'aura-site-bootstrapper'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="reapply_elementor"><?php _e('Sobrescribir existentes', 'aura-site-bootstrapper'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="reapply_elementor" name="reapply_elementor" value="1" />
                            <label for="reapply_elementor"><?php _e('Re-aplicar configuración en páginas existentes', 'aura-site-bootstrapper'); ?></label>
                        </td>
                    </tr>
                    <?php endif; ?>
                    
                    <!-- Importar plantillas JSON - siempre visible -->
                    <tr>
                        <th scope="row">
                            <label for="import_elementor_json"><?php _e('Importar plantillas Elementor (JSON)', 'aura-site-bootstrapper'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="import_elementor_json" name="import_elementor_json" value="1" 
                                   <?php echo $elementor_active ? 'checked' : 'disabled'; ?> />
                            <label for="import_elementor_json"><?php _e('Importar plantillas Elementor (JSON) en las páginas', 'aura-site-bootstrapper'); ?></label>
                            <?php if (!$elementor_active): ?>
                                <p class="description" style="color: #856404;">
                                    <em><?php _e('Requiere Elementor activo', 'aura-site-bootstrapper'); ?></em>
                                </p>
                            <?php else: ?>
                                <p class="description"><?php _e('Esto cargará diseños predefinidos con contenido de ejemplo para cada página.', 'aura-site-bootstrapper'); ?></p>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button(__('Crear páginas y menú', 'aura-site-bootstrapper'), 'primary', 'submit', false); ?>
                
                <hr style="margin: 20px 0;">
                <p>Este proceso:</p>
                <ul>
                    <li>Creará las páginas principales (Inicio, Servicios, Acerca de, Contacto, Política de Privacidad)</li>
                    <li>Asignará la página de Inicio como portada estática</li>
                    <li>Creará los menús principales</li>
                    <?php if ($elementor_active): ?>
                    <li>Aplicará configuraciones de Elementor automáticamente (si se selecciona)</li>
                    <li>Importará plantillas JSON con diseños predefinidos (si se selecciona)</li>
                    <?php else: ?>
                    <li><em style="color: #856404;">Para funciones de Elementor: <?php echo esc_html($status_text); ?></em></li>
                    <?php endif; ?>
                </ul>
            </form>
        </div>
    </div>
    <?php
}

/**
 * Handle form submission
 */
function asb_handle_form_submission() {
    // Check user permissions
    if (!current_user_can('manage_options')) {
        wp_die(__('No tienes permisos para realizar esta acción.', 'aura-site-bootstrapper'));
    }
    
    // Verify nonce
    if (!isset($_POST['asb_nonce']) || !wp_verify_nonce($_POST['asb_nonce'], 'asb_create_base')) {
        wp_die(__('Error de seguridad. Por favor, inténtalo de nuevo.', 'aura-site-bootstrapper'));
    }
    
    // Get options
    $apply_meta = !empty($_POST['apply_elementor_meta']);
    $reapply = !empty($_POST['reapply_elementor']);
    $import_json = !empty($_POST['import_elementor_json']);
    
    $results = array();
    
    // Create base pages
    $page_ids = asb_create_base_pages();
    if (!empty($page_ids)) {
        $results[] = sprintf(__('Páginas procesadas: %d', 'aura-site-bootstrapper'), count($page_ids));
    }
    
    // Create primary menu
    $menu_result = asb_create_primary_menu($page_ids);
    if ($menu_result['menu_id'] > 0) {
        $menu_message = sprintf(__('Menú creado (ID: %d)', 'aura-site-bootstrapper'), $menu_result['menu_id']);
        if ($menu_result['items_added'] > 0) {
            $menu_message .= sprintf(__(' - Items agregados: %d', 'aura-site-bootstrapper'), $menu_result['items_added']);
        }
        if ($menu_result['assigned_primary']) {
            $menu_message .= __(' - Asignado como menú principal', 'aura-site-bootstrapper');
        }
        $results[] = $menu_message;
    }
    
    // Set home page
    if (isset($page_ids['inicio'])) {
        asb_set_front_page($page_ids['inicio']);
        $results[] = __('Página de inicio configurada', 'aura-site-bootstrapper');
    }
    
    // Counters for final report
    $meta_applied = 0;
    $meta_skipped = 0;
    $json_applied = 0;
    $json_skipped = 0;
    $errors = array();
    
    // Track which pages received JSON in this execution
    $pages_with_json = array();
    
    // Apply Elementor meta if requested
    if ($apply_meta && asb_is_elementor_active()) {
        $elementor_results = asb_apply_elementor_meta($page_ids, $reapply);
        if (isset($elementor_results['pages']) && !empty($elementor_results['pages'])) {
            foreach ($elementor_results['pages'] as $page_key => $page_result) {
                if ($page_result['status'] === 'applied') {
                    $meta_applied++;
                } else {
                    $meta_skipped++;
                }
            }
        }
    } elseif ($apply_meta && !asb_is_elementor_active()) {
        $errors[] = __('Meta de Elementor: Plugin no activo', 'aura-site-bootstrapper');
    }
    
    // Import Elementor JSON templates if requested
    if ($import_json && asb_is_elementor_active()) {
        $template_results = asb_import_elementor_json_templates($page_ids, $reapply);
        
        if (isset($template_results['elementor_active']) && $template_results['elementor_active']) {
            $json_applied = $template_results['templates_applied'];
            $json_skipped = $template_results['templates_skipped'];
            
            // Track pages that received JSON templates
            if (isset($template_results['pages'])) {
                foreach ($template_results['pages'] as $page_slug => $page_result) {
                    if (isset($page_result['template_applied']) && $page_result['template_applied']) {
                        $pages_with_json[] = $page_result['page_id'];
                    }
                }
            }
            
            // Collect any errors
            if (!empty($template_results['errors'])) {
                foreach ($template_results['errors'] as $error) {
                    $errors[] = $error;
                }
            }
        } else {
            $errors[] = __('Plantillas JSON: Error al importar', 'aura-site-bootstrapper');
        }
    } elseif ($import_json && !asb_is_elementor_active()) {
        $errors[] = __('Plantillas JSON: Plugin no activo', 'aura-site-bootstrapper');
    }
    
    // Build detailed results summary
    if ($meta_applied > 0) {
        $results[] = sprintf(__('Meta Elementor aplicada: %d páginas', 'aura-site-bootstrapper'), $meta_applied);
    }
    if ($meta_skipped > 0) {
        $results[] = sprintf(__('Meta Elementor omitida: %d páginas', 'aura-site-bootstrapper'), $meta_skipped);
    }
    if ($json_applied > 0) {
        $results[] = sprintf(__('JSON importado: %d páginas', 'aura-site-bootstrapper'), $json_applied);
    }
    if ($json_skipped > 0) {
        $results[] = sprintf(__('JSON omitido: %d páginas', 'aura-site-bootstrapper'), $json_skipped);
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            $results[] = __('Error: ', 'aura-site-bootstrapper') . $error;
        }
    }
    
    // Generate debug report for created pages
    $debug_report = '';
    if (!empty($page_ids)) {
        $debug_report .= '<h4>' . __('Debug Report - Páginas Creadas:', 'aura-site-bootstrapper') . '</h4>';
        $debug_report .= '<ul style="margin-left: 20px; font-family: monospace; font-size: 12px; line-height: 1.4;">';
        
        foreach ($page_ids as $slug => $page_id) {
            if ($page_id && is_numeric($page_id)) {
                $page_title = get_the_title($page_id);
                $edit_url = admin_url('post.php?post=' . $page_id . '&action=edit');
                
                // Check if has Elementor data
                $elementor_data = get_post_meta($page_id, '_elementor_data', true);
                $has_elementor_data = !empty($elementor_data) ? 
                    '<span style="color: green;">✓ Sí</span>' : 
                    '<span style="color: #999;">✗ No</span>';
                
                // Check if JSON was imported in this execution
                $json_imported = in_array($page_id, $pages_with_json) ? 
                    '<span style="color: green;">✓ Sí</span>' : 
                    '<span style="color: #999;">✗ No</span>';
                
                $debug_report .= sprintf(
                    '<li style="margin-bottom: 8px;"><strong>%s</strong> <span style="color: #666;">(ID: %d, slug: %s)</span><br>' .
                    '&nbsp;&nbsp;📝 <a href="%s" target="_blank" style="text-decoration: none;">%s</a><br>' .
                    '&nbsp;&nbsp;🎨 Elementor Data: %s<br>' .
                    '&nbsp;&nbsp;📄 JSON Importado: %s</li>',
                    esc_html($page_title),
                    $page_id,
                    esc_html($slug),
                    esc_url($edit_url),
                    __('Editar página', 'aura-site-bootstrapper'),
                    $has_elementor_data,
                    $json_imported
                );
            }
        }
        
        $debug_report .= '</ul>';
        
        // Add summary stats
        $debug_report .= '<div style="margin-top: 10px; padding: 8px; background: #fff; border: 1px solid #ddd; border-radius: 3px; font-size: 11px;">';
        $debug_report .= '<strong>' . __('Resumen:', 'aura-site-bootstrapper') . '</strong> ';
        $debug_report .= sprintf(
            __('%d páginas creadas, %d con JSON importado, %d con datos de Elementor', 'aura-site-bootstrapper'),
            count($page_ids),
            count($pages_with_json),
            count(array_filter($page_ids, function($page_id) {
                return !empty(get_post_meta($page_id, '_elementor_data', true));
            }))
        );
        $debug_report .= '</div>';
    }
    
    // Save results for display
    if (!empty($results)) {
        set_transient('asb_admin_notice', array(
            'type' => 'success',
            'message' => implode('. ', $results) . '.',
            'debug_report' => $debug_report
        ), 30);
    } else {
        set_transient('asb_admin_notice', array(
            'type' => 'warning',
            'message' => __('No se realizaron cambios. Las páginas y menús pueden ya existir.', 'aura-site-bootstrapper'),
            'debug_report' => $debug_report
        ), 30);
    }
    
    // Redirect back
    wp_redirect(admin_url('tools.php?page=aura-bootstrapper'));
    exit;
}

/**
 * Display admin notices
 */
function asb_admin_notices() {
    $notice = get_transient('asb_admin_notice');
    if ($notice) {
        delete_transient('asb_admin_notice');
        $class = $notice['type'] === 'success' ? 'notice-success' : 'notice-warning';
        echo '<div class="notice ' . esc_attr($class) . ' is-dismissible">';
        echo '<p>' . esc_html($notice['message']) . '</p>';
        
        // Show debug report if available
        if (!empty($notice['debug_report'])) {
            echo '<div style="margin-top: 15px; padding: 10px; background: #f0f0f1; border-left: 4px solid #72aee6; border-radius: 3px;">';
            echo $notice['debug_report']; // This is already escaped in generation
            echo '</div>';
        }
        
        echo '</div>';
    }
}

/**
 * Apply Elementor meta to pages
 * 
 * @param array $page_ids
 * @param bool $reapply
 */
function asb_apply_elementor_meta($page_ids, $reapply = false) {
    if (!$page_ids || !is_array($page_ids)) {
        return;
    }
    
    foreach ($page_ids as $page_id) {
        // Check if already has Elementor meta
        $existing_meta = get_post_meta($page_id, '_elementor_edit_mode', true);
        
        if (!$existing_meta || $reapply) {
            // Enable Elementor editing
            update_post_meta($page_id, '_elementor_edit_mode', 'builder');
            update_post_meta($page_id, '_elementor_template_type', 'wp-page');
            update_post_meta($page_id, '_elementor_version', '3.0.0');
        }
    }
}