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
function PREFIX_PHP_PLACEHOLDERtheme_setup() {
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
        'primary' => esc_html__('Primary Menu', 'TEXT_DOMAIN_PLACEHOLDER'),
    ));
    
    // Elementor compatibility
    add_theme_support('elementor-header-footer');
}
add_action('after_setup_theme', 'PREFIX_PHP_PLACEHOLDERtheme_setup');

/**
 * Set content width for media embeds and images
 */
function PREFIX_PHP_PLACEHOLDERcontent_width() {
    if (!isset($GLOBALS['content_width'])) {
        $GLOBALS['content_width'] = 1200;
    }
}
add_action('after_setup_theme', 'PREFIX_PHP_PLACEHOLDERcontent_width', 0);

/**
 * Enqueue scripts and styles
 */
function PREFIX_PHP_PLACEHOLDERscripts() {
    // Theme stylesheet
    wp_enqueue_style(
        'TEXT_DOMAIN_PLACEHOLDER-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );
    
    // Main stylesheet
    wp_enqueue_style(
        'TEXT_DOMAIN_PLACEHOLDER-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array('TEXT_DOMAIN_PLACEHOLDER-style'),
        wp_get_theme()->get('Version')
    );
    
    // Add customizer CSS variables
    $logo_max_width_desktop = get_theme_mod('PREFIX_PHP_PLACEHOLDERlogo_max_width_desktop', 180);
    $logo_max_width_mobile = get_theme_mod('PREFIX_PHP_PLACEHOLDERlogo_max_width_mobile', 140);
    $header_padding_y = get_theme_mod('PREFIX_PHP_PLACEHOLDERheader_padding_y', 16);
    
    // Brand Colors
    $color_primary = get_theme_mod('PREFIX_PHP_PLACEHOLDERbrand_primary_color', '#007cba');
    $color_secondary = get_theme_mod('PREFIX_PHP_PLACEHOLDERbrand_secondary_color', '#005177');
    $color_bg = get_theme_mod('PREFIX_PHP_PLACEHOLDERbrand_background_color', '#ffffff');
    $color_surface = get_theme_mod('PREFIX_PHP_PLACEHOLDERbrand_surface_color', '#f8f9fa');
    $color_text = get_theme_mod('PREFIX_PHP_PLACEHOLDERbrand_text_color', '#333333');
    $color_muted = get_theme_mod('PREFIX_PHP_PLACEHOLDERbrand_muted_color', '#6c757d');
    $color_link = get_theme_mod('PREFIX_PHP_PLACEHOLDERbrand_link_color', '#007cba');
    $color_link_hover = get_theme_mod('PREFIX_PHP_PLACEHOLDERbrand_link_hover_color', '#005177');
    
    // Layout Settings
    $container_max_width = get_theme_mod('PREFIX_PHP_PLACEHOLDERcontainer_max_width', 1200);
    $global_radius = get_theme_mod('PREFIX_PHP_PLACEHOLDERglobal_radius', 12);
    
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
    wp_add_inline_style('TEXT_DOMAIN_PLACEHOLDER-main', $custom_css);
    
    // Main JavaScript (no jQuery dependency unless needed)
    wp_enqueue_script(
        'TEXT_DOMAIN_PLACEHOLDER-main',
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
add_action('wp_enqueue_scripts', 'PREFIX_PHP_PLACEHOLDERscripts');

/**
 * Register widget areas
 */
function PREFIX_PHP_PLACEHOLDERwidgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'TEXT_DOMAIN_PLACEHOLDER'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'TEXT_DOMAIN_PLACEHOLDER'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    // Footer widget areas
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(esc_html__('Footer %d', 'TEXT_DOMAIN_PLACEHOLDER'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(esc_html__('Footer widget area %d.', 'TEXT_DOMAIN_PLACEHOLDER'), $i),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
    }
}
add_action('widgets_init', 'PREFIX_PHP_PLACEHOLDERwidgets_init');

/**
 * Custom excerpt length
 */
function PREFIX_PHP_PLACEHOLDERexcerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'PREFIX_PHP_PLACEHOLDERexcerpt_length');

/**
 * Custom excerpt more text
 */
function PREFIX_PHP_PLACEHOLDERexcerpt_more($more) {
    return '&hellip;';
}
add_filter('excerpt_more', 'PREFIX_PHP_PLACEHOLDERexcerpt_more');

/**
 * Add head scripts from customizer
 */
function PREFIX_PHP_PLACEHOLDERhead_scripts() {
    $head_scripts = get_theme_mod('PREFIX_PHP_PLACEHOLDERhead_scripts', '');
    if (!empty($head_scripts)) {
        echo $head_scripts . "\n";
    }
}
add_action('wp_head', 'PREFIX_PHP_PLACEHOLDERhead_scripts', 999);

/**
 * Add body open scripts from customizer
 */
function PREFIX_PHP_PLACEHOLDERbody_open_scripts() {
    $body_scripts = get_theme_mod('PREFIX_PHP_PLACEHOLDERbody_open_scripts', '');
    if (!empty($body_scripts)) {
        echo $body_scripts . "\n";
    }
}
add_action('wp_body_open', 'PREFIX_PHP_PLACEHOLDERbody_open_scripts', 1);