<?php
/**
 * Pages management functionality
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
 * Create base pages for the site
 * 
 * @return array Array of created page IDs
 */
function asb_create_base_pages() {
    $page_templates = array(
        'inicio' => array(
            'title' => __('Inicio', 'aura-site-bootstrapper'),
            'slug' => 'inicio',
            'content' => asb_get_page_content('inicio')
        ),
        'nosotros' => array(
            'title' => __('Nosotros', 'aura-site-bootstrapper'),
            'slug' => 'nosotros',
            'content' => asb_get_page_content('nosotros')
        ),
        'servicios' => array(
            'title' => __('Servicios', 'aura-site-bootstrapper'),
            'slug' => 'servicios',
            'content' => asb_get_page_content('servicios')
        ),
        'contacto' => array(
            'title' => __('Contacto', 'aura-site-bootstrapper'),
            'slug' => 'contacto',
            'content' => asb_get_page_content('contacto')
        )
    );
    
    $created_pages = array();
    
    foreach ($page_templates as $key => $page_data) {
        // Check if page already exists by slug
        $existing_page = get_page_by_path($page_data['slug']);
        
        if (!$existing_page) {
            // Create new page
            $page_id = wp_insert_post(array(
                'post_title' => $page_data['title'],
                'post_name' => $page_data['slug'],
                'post_content' => $page_data['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_author' => get_current_user_id(),
                'meta_input' => array(
                    '_wp_page_template' => 'default'
                )
            ));
            
            if (!is_wp_error($page_id)) {
                $created_pages[$key] = $page_id;
            }
        } else {
            // Page exists, use existing ID
            $created_pages[$key] = $existing_page->ID;
        }
    }
    
    // Save created pages for audit
    if (!empty($created_pages)) {
        update_option('asb_created_pages', $created_pages);
    }
    
    return $created_pages;
}

/**
 * Set front page configuration
 * 
 * @param int $page_id Page ID to set as front page
 * @return void
 */
function asb_set_front_page($page_id) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $page_id);
}

/**
 * Get content for specific page type
 * 
 * @param string $page_type
 * @return string
 */
function asb_get_page_content($page_type) {
    $content_templates = array(
        'inicio' => '<p>Bienvenido a nuestro sitio web. Esta es la página de inicio donde puedes agregar información destacada sobre tu negocio.</p><p>Puedes editar este contenido usando el editor de WordPress o Elementor.</p>',
        
        'nosotros' => '<p>Somos una empresa comprometida con brindar servicios de excelencia y construir relaciones duraderas con nuestros clientes.</p><p>Nuestro equipo cuenta con años de experiencia para ayudarte a alcanzar tus objetivos.</p>',
        
        'servicios' => '<p>Ofrecemos una amplia gama de servicios diseñados para satisfacer las necesidades de nuestros clientes.</p><p>Contáctanos para conocer más sobre nuestras soluciones personalizadas.</p>',
        
        'contacto' => '<p>Estamos aquí para ayudarte. Ponte en contacto con nosotros para cualquier consulta o solicitud de información.</p><p>Email: info@tuempresa.com | Teléfono: (55) 1234-5678</p>'
    );
    
    return isset($content_templates[$page_type]) ? $content_templates[$page_type] : '';
}