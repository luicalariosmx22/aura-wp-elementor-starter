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
    
    register_sidebar(array(
        'name'          => esc_html__('Footer 1', 'TEXT_DOMAIN_PLACEHOLDER'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Footer widget area 1.', 'TEXT_DOMAIN_PLACEHOLDER'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
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