<?php
/**
 * WordPress Customizer Settings
 * 
 * @author Aura Marketing
 * @link https://agenciaaura.mx
 * @package AuraTheme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add customizer settings
 * 
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function aura_aes_customize_register($wp_customize) {
    
    // ========================================
    // SECTION: Header
    // ========================================
    $wp_customize->add_section('aura_aes_header_section', array(
        'title'    => __('Header', 'aura-wp-elementor-starter'),
        'priority' => 30,
    ));

    // Header Style
    $wp_customize->add_setting('aura_aes_header_style', array(
        'default'           => 'style-1',
        'sanitize_callback' => 'aura_aes_sanitize_select',
    ));
    $wp_customize->add_control('aura_aes_header_style', array(
        'label'   => __('Header Style', 'aura-wp-elementor-starter'),
        'section' => 'aura_aes_header_section',
        'type'    => 'select',
        'choices' => array(
            'style-1' => __('Style 1: Logo left, menu center/right, socials/CTA right', 'aura-wp-elementor-starter'),
            'style-2' => __('Style 2: Logo left, menu right, socials below on mobile', 'aura-wp-elementor-starter'),
            'style-3' => __('Style 3: Logo centered, menu below', 'aura-wp-elementor-starter'),
        ),
    ));

    // Logo Max Width Desktop
    $wp_customize->add_setting('aura_aes_logo_max_width_desktop', array(
        'default'           => 180,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('aura_aes_logo_max_width_desktop', array(
        'label'   => __('Logo Max Width Desktop (px)', 'aura-wp-elementor-starter'),
        'section' => 'aura_aes_header_section',
        'type'    => 'range',
        'input_attrs' => array(
            'min'  => 80,
            'max'  => 320,
            'step' => 1,
        ),
    ));

    // Logo Max Width Mobile
    $wp_customize->add_setting('aura_aes_logo_max_width_mobile', array(
        'default'           => 140,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('aura_aes_logo_max_width_mobile', array(
        'label'   => __('Logo Max Width Mobile (px)', 'aura-wp-elementor-starter'),
        'section' => 'aura_aes_header_section',
        'type'    => 'range',
        'input_attrs' => array(
            'min'  => 60,
            'max'  => 240,
            'step' => 1,
        ),
    ));

    // Header Padding Y
    $wp_customize->add_setting('aura_aes_header_padding_y', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('aura_aes_header_padding_y', array(
        'label'   => __('Header Vertical Padding (px)', 'aura-wp-elementor-starter'),
        'section' => 'aura_aes_header_section',
        'type'    => 'range',
        'input_attrs' => array(
            'min'  => 6,
            'max'  => 40,
            'step' => 1,
        ),
    ));

    // Header Sticky
    $wp_customize->add_setting('aura_aes_header_sticky', array(
        'default'           => false,
        'sanitize_callback' => 'aura_aes_sanitize_checkbox',
    ));
    $wp_customize->add_control('aura_aes_header_sticky', array(
        'label'   => __('Sticky Header', 'aura-wp-elementor-starter'),
        'section' => 'aura_aes_header_section',
        'type'    => 'checkbox',
    ));

    // Show Socials
    $wp_customize->add_setting('aura_aes_show_socials', array(
        'default'           => true,
        'sanitize_callback' => 'aura_aes_sanitize_checkbox',
    ));
    $wp_customize->add_control('aura_aes_show_socials', array(
        'label'   => __('Show Social Media Links', 'aura-wp-elementor-starter'),
        'section' => 'aura_aes_header_section',
        'type'    => 'checkbox',
    ));

    // Show CTA
    $wp_customize->add_setting('aura_aes_show_cta', array(
        'default'           => false,
        'sanitize_callback' => 'aura_aes_sanitize_checkbox',
    ));
    $wp_customize->add_control('aura_aes_show_cta', array(
        'label'   => __('Show CTA Button', 'aura-wp-elementor-starter'),
        'section' => 'aura_aes_header_section',
        'type'    => 'checkbox',
    ));

    // CTA Text
    $wp_customize->add_setting('aura_aes_cta_text', array(
        'default'           => __('Contáctanos', 'aura-wp-elementor-starter'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('aura_aes_cta_text', array(
        'label'   => __('CTA Button Text', 'aura-wp-elementor-starter'),
        'section' => 'aura_aes_header_section',
        'type'    => 'text',
    ));

    // CTA URL
    $wp_customize->add_setting('aura_aes_cta_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('aura_aes_cta_url', array(
        'label'   => __('CTA Button URL', 'aura-wp-elementor-starter'),
        'section' => 'aura_aes_header_section',
        'type'    => 'url',
    ));

    // Header Extra HTML
    $wp_customize->add_setting('aura_aes_header_extra_html', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('aura_aes_header_extra_html', array(
        'label'       => __('Header Extra HTML', 'aura-wp-elementor-starter'),
        'description' => __('Simple HTML/text to display in header (phone, promo, etc.)', 'aura-wp-elementor-starter'),
        'section'     => 'aura_aes_header_section',
        'type'        => 'textarea',
    ));

    // ========================================
    // SECTION: Social Media
    // ========================================
    $wp_customize->add_section('aura_aes_social_section', array(
        'title'    => __('Redes Sociales', 'aura-wp-elementor-starter'),
        'priority' => 31,
    ));

    // Social Media URLs
    $social_networks = array(
        'facebook'  => __('Facebook URL', 'aura-wp-elementor-starter'),
        'instagram' => __('Instagram URL', 'aura-wp-elementor-starter'),
        'tiktok'    => __('TikTok URL', 'aura-wp-elementor-starter'),
        'youtube'   => __('YouTube URL', 'aura-wp-elementor-starter'),
        'whatsapp'  => __('WhatsApp URL', 'aura-wp-elementor-starter'),
        'x'         => __('X (Twitter) URL', 'aura-wp-elementor-starter'),
    );

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting('aura_aes_social_' . $network, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('aura_aes_social_' . $network, array(
            'label'   => $label,
            'section' => 'aura_aes_social_section',
            'type'    => 'url',
        ));
    }

    // ========================================
    // SECTION: Scripts
    // ========================================
    $wp_customize->add_section('aura_aes_scripts_section', array(
        'title'    => __('Scripts', 'aura-wp-elementor-starter'),
        'priority' => 32,
    ));

    // Head Scripts
    $wp_customize->add_setting('aura_aes_head_scripts', array(
        'default'           => '',
        'sanitize_callback' => 'aura_aes_sanitize_scripts',
    ));
    $wp_customize->add_control('aura_aes_head_scripts', array(
        'label'       => __('Head Scripts', 'aura-wp-elementor-starter'),
        'description' => __('Scripts to add in &lt;head&gt; (Google Analytics, Facebook Pixel, etc.)', 'aura-wp-elementor-starter'),
        'section'     => 'aura_aes_scripts_section',
        'type'        => 'textarea',
    ));

    // Body Open Scripts
    $wp_customize->add_setting('aura_aes_body_open_scripts', array(
        'default'           => '',
        'sanitize_callback' => 'aura_aes_sanitize_scripts',
    ));
    $wp_customize->add_control('aura_aes_body_open_scripts', array(
        'label'       => __('Body Open Scripts', 'aura-wp-elementor-starter'),
        'description' => __('Scripts to add after &lt;body&gt; opens (noscript tags, tracking, etc.)', 'aura-wp-elementor-starter'),
        'section'     => 'aura_aes_scripts_section',
        'type'        => 'textarea',
    ));

    // ========================================
    // SECTION: Branding
    // ========================================
    $wp_customize->add_section('aura_aes_branding_section', array(
        'title'       => __('Branding', 'aura-wp-elementor-starter'),
        'description' => __('Configure your brand colors for consistent styling across your website.', 'aura-wp-elementor-starter'),
        'priority'    => 33,
    ));

    // Brand Colors Array with defaults
    $brand_colors = array(
        'brand_primary_color'     => array(
            'label'   => __('Primary Brand Color', 'aura-wp-elementor-starter'),
            'default' => '#007cba',
        ),
        'brand_secondary_color'   => array(
            'label'   => __('Secondary Brand Color', 'aura-wp-elementor-starter'),
            'default' => '#005177',
        ),
        'brand_background_color'  => array(
            'label'   => __('Background Color', 'aura-wp-elementor-starter'),
            'default' => '#ffffff',
        ),
        'brand_surface_color'     => array(
            'label'   => __('Surface Color', 'aura-wp-elementor-starter'),
            'default' => '#f8f9fa',
        ),
        'brand_text_color'        => array(
            'label'   => __('Text Color', 'aura-wp-elementor-starter'),
            'default' => '#333333',
        ),
        'brand_muted_color'       => array(
            'label'   => __('Muted Text Color', 'aura-wp-elementor-starter'),
            'default' => '#6c757d',
        ),
        'brand_accent_color'      => array(
            'label'   => __('Accent Color', 'aura-wp-elementor-starter'),
            'default' => '#28a745',
        ),
        'brand_link_color'        => array(
            'label'   => __('Link Color', 'aura-wp-elementor-starter'),
            'default' => '#007cba',
        ),
        'brand_link_hover_color'  => array(
            'label'   => __('Link Hover Color', 'aura-wp-elementor-starter'),
            'default' => '#005177',
        ),
    );

    // Generate color controls
    foreach ($brand_colors as $color_key => $color_data) {
        $wp_customize->add_setting('aura_aes_' . $color_key, array(
            'default'           => $color_data['default'],
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'aura_aes_' . $color_key, array(
            'label'   => $color_data['label'],
            'section' => 'aura_aes_branding_section',
        )));
    }

    // ========================================
    // SECTION: Layout
    // ========================================
    $wp_customize->add_section('aura_aes_layout_section', array(
        'title'       => __('Layout', 'aura-wp-elementor-starter'),
        'description' => __('Configure container widths and global design elements.', 'aura-wp-elementor-starter'),
        'priority'    => 34,
    ));

    // Container Max Width
    $wp_customize->add_setting('aura_aes_container_max_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('aura_aes_container_max_width', array(
        'label'       => __('Container Max Width (px)', 'aura-wp-elementor-starter'),
        'description' => __('Maximum width for content containers', 'aura-wp-elementor-starter'),
        'section'     => 'aura_aes_layout_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1440,
            'step' => 20,
        ),
    ));

    // Global Border Radius
    $wp_customize->add_setting('aura_aes_global_radius', array(
        'default'           => 12,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('aura_aes_global_radius', array(
        'label'       => __('Global Border Radius (px)', 'aura-wp-elementor-starter'),
        'description' => __('Border radius for buttons, cards, and other elements', 'aura-wp-elementor-starter'),
        'section'     => 'aura_aes_layout_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 24,
            'step' => 1,
        ),
    ));
}
add_action('customize_register', 'aura_aes_customize_register');

    // ========================================
    // SECTION: Footer
    // ========================================
    $wp_customize->add_section('aura_aes_footer_section', array(
        'title'       => __('Footer', 'aura-wp-elementor-starter'),
        'description' => __('Configure footer layout, content and social media display.', 'aura-wp-elementor-starter'),
        'priority'    => 35,
    ));

    // Footer Columns
    $wp_customize->add_setting('aura_aes_footer_columns', array(
        'default'           => 3,
        'sanitize_callback' => 'aura_aes_sanitize_select',
    ));
    $wp_customize->add_control('aura_aes_footer_columns', array(
        'label'   => __('Footer Columns', 'aura-wp-elementor-starter'),
        'section' => 'aura_aes_footer_section',
        'type'    => 'select',
        'choices' => array(
            '1' => __('1 Column', 'aura-wp-elementor-starter'),
            '2' => __('2 Columns', 'aura-wp-elementor-starter'),
            '3' => __('3 Columns', 'aura-wp-elementor-starter'),
            '4' => __('4 Columns', 'aura-wp-elementor-starter'),
        ),
    ));

    // Footer Text
    $wp_customize->add_setting('aura_aes_footer_text', array(
        'default'           => '© {year} Aura Elementor Starter. Todos los derechos reservados.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('aura_aes_footer_text', array(
        'label'       => __('Footer Text', 'aura-wp-elementor-starter'),
        'description' => __('Use {year} for current year replacement.', 'aura-wp-elementor-starter'),
        'section'     => 'aura_aes_footer_section',
        'type'        => 'textarea',
    ));

    // Show Footer Socials
    $wp_customize->add_setting('aura_aes_show_footer_socials', array(
        'default'           => true,
        'sanitize_callback' => 'aura_aes_sanitize_checkbox',
    ));
    $wp_customize->add_control('aura_aes_show_footer_socials', array(
        'label'   => __('Show Social Media in Footer', 'aura-wp-elementor-starter'),
        'section' => 'aura_aes_footer_section',
        'type'    => 'checkbox',
    ));
}
add_action('customize_register', 'aura_aes_customize_register');

/**
 * Sanitize select fields
 */
function aura_aes_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Sanitize checkbox fields
 */
function aura_aes_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize script fields based on user capabilities
 */
function aura_aes_sanitize_scripts($input) {
    // Allow unfiltered HTML for users with appropriate capabilities
    if (current_user_can('unfiltered_html')) {
        return $input;
    }
    
    // For other users, allow very limited HTML or return empty
    $allowed_tags = array(
        'script' => array(
            'src'   => array(),
            'type'  => array(),
            'async' => array(),
            'defer' => array(),
        ),
        'noscript' => array(),
        'meta'     => array(
            'name'     => array(),
            'content'  => array(),
            'property' => array(),
        ),
    );
    
    return wp_kses($input, $allowed_tags);
}