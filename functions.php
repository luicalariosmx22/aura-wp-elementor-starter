<?php
/**
 * Aura Elementor Starter Theme Functions
 * 
 * @package AuraElementorStarter
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup and supports
 */
function aura_theme_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'aura-elementor-starter'),
        'footer' => __('Footer Menu', 'aura-elementor-starter'),
    ));
}
add_action('after_setup_theme', 'aura_theme_setup');

/**
 * Enqueue scripts and styles
 */
function aura_enqueue_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('aura-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_style('aura-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    
    // Enqueue main JavaScript
    wp_enqueue_script('aura-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // Enqueue comment reply script when needed
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'aura_enqueue_scripts');

/**
 * Elementor compatibility
 */
function aura_elementor_theme_support() {
    // Elementor theme location support
    add_theme_support('elementor-header-footer');
}
add_action('after_setup_theme', 'aura_elementor_theme_support');

/**
 * Register widget areas
 */
function aura_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'aura-elementor-starter'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'aura-elementor-starter'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('Footer 1', 'aura-elementor-starter'),
        'id'            => 'footer-1',
        'description'   => __('Footer widget area 1.', 'aura-elementor-starter'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'aura_widgets_init');

/**
 * Limit excerpt length
 */
function aura_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'aura_excerpt_length');