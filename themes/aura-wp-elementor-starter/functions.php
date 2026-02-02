<?php
/**
 * Theme Functions - WordPress Elementor Theme
 * 
 * @author Aura Marketing
 * @link https://agenciaaura.mx
 * @package AuraTheme
 * @version 0.1.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Include theme modules
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Theme setup and configuration
 */
function aura_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');
    
    // Let WordPress manage the document title
    add_theme_support('title-tag');
    
    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');
    
    // Add HTML5 theme support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    
    // Add custom logo support
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'aura-wp-elementor-starter'),
    ));
    
    // Elementor compatibility
    add_theme_support('elementor-header-footer');
}
add_action('after_setup_theme', 'aura_theme_setup');

/**
 * Set content width for media embeds and images
 */
function aura_content_width() {
    if (!isset($GLOBALS['content_width'])) {
        $GLOBALS['content_width'] = 1200;
    }
}
add_action('after_setup_theme', 'aura_content_width', 0);

/**
 * Enqueue scripts and styles
 */
function aura_scripts() {
    // Theme stylesheet
    wp_enqueue_style(
        'aura-wp-elementor-starter-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );
    
    // Main stylesheet
    wp_enqueue_style(
        'aura-wp-elementor-starter-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array('aura-wp-elementor-starter-style'),
        wp_get_theme()->get('Version')
    );
    
    // Add customizer CSS variables
    $logo_max_width_desktop = get_theme_mod('aura_aes_logo_max_width_desktop', 180);
    $logo_max_width_mobile = get_theme_mod('aura_aes_logo_max_width_mobile', 140);
    $header_padding_y = get_theme_mod('aura_aes_header_padding_y', 16);
    
    // Brand Colors
    $color_primary = get_theme_mod('aura_aes_brand_primary_color', '#007cba');
    $color_secondary = get_theme_mod('aura_aes_brand_secondary_color', '#005177');
    $color_bg = get_theme_mod('aura_aes_brand_background_color', '#ffffff');
    $color_surface = get_theme_mod('aura_aes_brand_surface_color', '#f8f9fa');
    $color_text = get_theme_mod('aura_aes_brand_text_color', '#333333');
    $color_muted = get_theme_mod('aura_aes_brand_muted_color', '#6c757d');
    $color_link = get_theme_mod('aura_aes_brand_link_color', '#007cba');
    $color_link_hover = get_theme_mod('aura_aes_brand_link_hover_color', '#005177');
    
    // Layout Settings
    $container_max_width = get_theme_mod('aura_aes_container_max_width', 1200);
    $global_radius = get_theme_mod('aura_aes_global_radius', 12);
    
    $custom_css = "
        :root {
            --aura-logo-max-desktop: {$logo_max_width_desktop}px;
            --aura-logo-max-mobile: {$logo_max_width_mobile}px;
            --aura-header-pad-y: {$header_padding_y}px;
            
            /* Brand Colors */
            --aura-color-primary: {$color_primary};
            --aura-color-secondary: {$color_secondary};
            --aura-color-bg: {$color_bg};
            --aura-color-surface: {$color_surface};
            --aura-color-text: {$color_text};
            --aura-color-muted: {$color_muted};
            --aura-color-link: {$color_link};
            --aura-color-link-hover: {$color_link_hover};
            
            /* Layout Variables */
            --aura-container-max: {$container_max_width}px;
            --aura-radius: {$global_radius}px;
        }
    ";
    wp_add_inline_style('aura-wp-elementor-starter-main', $custom_css);
    
    // Main JavaScript (no jQuery dependency unless needed)
    wp_enqueue_script(
        'aura-wp-elementor-starter-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(), // No dependencies
        wp_get_theme()->get('Version'),
        true
    );
    
    // Comment reply script when needed
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'aura_aes_scripts');

/**
 * Register widget areas
 */
function aura_aes_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'aura-wp-elementor-starter'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'aura-wp-elementor-starter'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    // Footer widget areas
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(esc_html__('Footer %d', 'aura-wp-elementor-starter'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(esc_html__('Footer widget area %d.', 'aura-wp-elementor-starter'), $i),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
    }
}
add_action('widgets_init', 'aura_aes_widgets_init');

/**
 * Custom excerpt length
 */
function aura_aes_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'aura_aes_excerpt_length');

/**
 * Custom excerpt more text
 */
function aura_aes_excerpt_more($more) {
    return '&hellip;';
}
add_filter('excerpt_more', 'aura_aes_excerpt_more');

/**
 * Add head scripts from customizer
 */
function aura_aes_head_scripts() {
    $head_scripts = get_theme_mod('aura_aes_head_scripts', '');
    if (!empty($head_scripts)) {
        echo $head_scripts . "\n";
    }
}
add_action('wp_head', 'aura_aes_head_scripts', 999);

/**
 * Add body open scripts from customizer
 */
function aura_aes_body_open_scripts() {
    $body_scripts = get_theme_mod('aura_aes_body_open_scripts', '');
    if (!empty($body_scripts)) {
        echo $body_scripts . "\n";
    }
}
add_action('wp_body_open', 'aura_aes_body_open_scripts', 1);