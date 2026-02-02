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
function PREFIX_PHP_PLACEHOLDERcustomize_register($wp_customize) {
    
    // ========================================
    // SECTION: Header
    // ========================================
    $wp_customize->add_section('PREFIX_PHP_PLACEHOLDERheader_section', array(
        'title'    => __('Header', 'TEXT_DOMAIN_PLACEHOLDER'),
        'priority' => 30,
    ));

    // Header Style
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERheader_style', array(
        'default'           => 'style-1',
        'sanitize_callback' => 'PREFIX_PHP_PLACEHOLDERsanitize_select',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERheader_style', array(
        'label'   => __('Header Style', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section' => 'PREFIX_PHP_PLACEHOLDERheader_section',
        'type'    => 'select',
        'choices' => array(
            'style-1' => __('Style 1: Logo left, menu center/right, socials/CTA right', 'TEXT_DOMAIN_PLACEHOLDER'),
            'style-2' => __('Style 2: Logo left, menu right, socials below on mobile', 'TEXT_DOMAIN_PLACEHOLDER'),
            'style-3' => __('Style 3: Logo centered, menu below', 'TEXT_DOMAIN_PLACEHOLDER'),
        ),
    ));

    // Logo Max Width Desktop
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERlogo_max_width_desktop', array(
        'default'           => 180,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERlogo_max_width_desktop', array(
        'label'   => __('Logo Max Width Desktop (px)', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section' => 'PREFIX_PHP_PLACEHOLDERheader_section',
        'type'    => 'range',
        'input_attrs' => array(
            'min'  => 80,
            'max'  => 320,
            'step' => 1,
        ),
    ));

    // Logo Max Width Mobile
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERlogo_max_width_mobile', array(
        'default'           => 140,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERlogo_max_width_mobile', array(
        'label'   => __('Logo Max Width Mobile (px)', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section' => 'PREFIX_PHP_PLACEHOLDERheader_section',
        'type'    => 'range',
        'input_attrs' => array(
            'min'  => 60,
            'max'  => 240,
            'step' => 1,
        ),
    ));

    // Header Padding Y
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERheader_padding_y', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERheader_padding_y', array(
        'label'   => __('Header Vertical Padding (px)', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section' => 'PREFIX_PHP_PLACEHOLDERheader_section',
        'type'    => 'range',
        'input_attrs' => array(
            'min'  => 6,
            'max'  => 40,
            'step' => 1,
        ),
    ));

    // Header Sticky
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERheader_sticky', array(
        'default'           => false,
        'sanitize_callback' => 'PREFIX_PHP_PLACEHOLDERsanitize_checkbox',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERheader_sticky', array(
        'label'   => __('Sticky Header', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section' => 'PREFIX_PHP_PLACEHOLDERheader_section',
        'type'    => 'checkbox',
    ));

    // Show Socials
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERshow_socials', array(
        'default'           => true,
        'sanitize_callback' => 'PREFIX_PHP_PLACEHOLDERsanitize_checkbox',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERshow_socials', array(
        'label'   => __('Show Social Media Links', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section' => 'PREFIX_PHP_PLACEHOLDERheader_section',
        'type'    => 'checkbox',
    ));

    // Show CTA
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERshow_cta', array(
        'default'           => false,
        'sanitize_callback' => 'PREFIX_PHP_PLACEHOLDERsanitize_checkbox',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERshow_cta', array(
        'label'   => __('Show CTA Button', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section' => 'PREFIX_PHP_PLACEHOLDERheader_section',
        'type'    => 'checkbox',
    ));

    // CTA Text
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERcta_text', array(
        'default'           => __('Contáctanos', 'TEXT_DOMAIN_PLACEHOLDER'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERcta_text', array(
        'label'   => __('CTA Button Text', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section' => 'PREFIX_PHP_PLACEHOLDERheader_section',
        'type'    => 'text',
    ));

    // CTA URL
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERcta_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERcta_url', array(
        'label'   => __('CTA Button URL', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section' => 'PREFIX_PHP_PLACEHOLDERheader_section',
        'type'    => 'url',
    ));

    // Header Extra HTML
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERheader_extra_html', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERheader_extra_html', array(
        'label'       => __('Header Extra HTML', 'TEXT_DOMAIN_PLACEHOLDER'),
        'description' => __('Simple HTML/text to display in header (phone, promo, etc.)', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section'     => 'PREFIX_PHP_PLACEHOLDERheader_section',
        'type'        => 'textarea',
    ));

    // ========================================
    // SECTION: Social Media
    // ========================================
    $wp_customize->add_section('PREFIX_PHP_PLACEHOLDERsocial_section', array(
        'title'    => __('Redes Sociales', 'TEXT_DOMAIN_PLACEHOLDER'),
        'priority' => 31,
    ));

    // Social Media URLs
    $social_networks = array(
        'facebook'  => __('Facebook URL', 'TEXT_DOMAIN_PLACEHOLDER'),
        'instagram' => __('Instagram URL', 'TEXT_DOMAIN_PLACEHOLDER'),
        'tiktok'    => __('TikTok URL', 'TEXT_DOMAIN_PLACEHOLDER'),
        'youtube'   => __('YouTube URL', 'TEXT_DOMAIN_PLACEHOLDER'),
        'whatsapp'  => __('WhatsApp URL', 'TEXT_DOMAIN_PLACEHOLDER'),
        'x'         => __('X (Twitter) URL', 'TEXT_DOMAIN_PLACEHOLDER'),
    );

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERsocial_' . $network, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERsocial_' . $network, array(
            'label'   => $label,
            'section' => 'PREFIX_PHP_PLACEHOLDERsocial_section',
            'type'    => 'url',
        ));
    }

    // ========================================
    // SECTION: Scripts
    // ========================================
    $wp_customize->add_section('PREFIX_PHP_PLACEHOLDERscripts_section', array(
        'title'    => __('Scripts', 'TEXT_DOMAIN_PLACEHOLDER'),
        'priority' => 32,
    ));

    // Head Scripts
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERhead_scripts', array(
        'default'           => '',
        'sanitize_callback' => 'PREFIX_PHP_PLACEHOLDERsanitize_scripts',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERhead_scripts', array(
        'label'       => __('Head Scripts', 'TEXT_DOMAIN_PLACEHOLDER'),
        'description' => __('Scripts to add in &lt;head&gt; (Google Analytics, Facebook Pixel, etc.)', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section'     => 'PREFIX_PHP_PLACEHOLDERscripts_section',
        'type'        => 'textarea',
    ));

    // Body Open Scripts
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERbody_open_scripts', array(
        'default'           => '',
        'sanitize_callback' => 'PREFIX_PHP_PLACEHOLDERsanitize_scripts',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERbody_open_scripts', array(
        'label'       => __('Body Open Scripts', 'TEXT_DOMAIN_PLACEHOLDER'),
        'description' => __('Scripts to add after &lt;body&gt; opens (noscript tags, tracking, etc.)', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section'     => 'PREFIX_PHP_PLACEHOLDERscripts_section',
        'type'        => 'textarea',
    ));

    // ========================================
    // SECTION: Branding
    // ========================================
    $wp_customize->add_section('PREFIX_PHP_PLACEHOLDERbranding_section', array(
        'title'       => __('Branding', 'TEXT_DOMAIN_PLACEHOLDER'),
        'description' => __('Configure your brand colors for consistent styling across your website.', 'TEXT_DOMAIN_PLACEHOLDER'),
        'priority'    => 33,
    ));

    // Brand Colors Array with defaults
    $brand_colors = array(
        'brand_primary_color'     => array(
            'label'   => __('Primary Brand Color', 'TEXT_DOMAIN_PLACEHOLDER'),
            'default' => '#007cba',
        ),
        'brand_secondary_color'   => array(
            'label'   => __('Secondary Brand Color', 'TEXT_DOMAIN_PLACEHOLDER'),
            'default' => '#005177',
        ),
        'brand_background_color'  => array(
            'label'   => __('Background Color', 'TEXT_DOMAIN_PLACEHOLDER'),
            'default' => '#ffffff',
        ),
        'brand_surface_color'     => array(
            'label'   => __('Surface Color', 'TEXT_DOMAIN_PLACEHOLDER'),
            'default' => '#f8f9fa',
        ),
        'brand_text_color'        => array(
            'label'   => __('Text Color', 'TEXT_DOMAIN_PLACEHOLDER'),
            'default' => '#333333',
        ),
        'brand_muted_color'       => array(
            'label'   => __('Muted Text Color', 'TEXT_DOMAIN_PLACEHOLDER'),
            'default' => '#6c757d',
        ),
        'brand_accent_color'      => array(
            'label'   => __('Accent Color', 'TEXT_DOMAIN_PLACEHOLDER'),
            'default' => '#28a745',
        ),
        'brand_link_color'        => array(
            'label'   => __('Link Color', 'TEXT_DOMAIN_PLACEHOLDER'),
            'default' => '#007cba',
        ),
        'brand_link_hover_color'  => array(
            'label'   => __('Link Hover Color', 'TEXT_DOMAIN_PLACEHOLDER'),
            'default' => '#005177',
        ),
    );

    // Generate color controls
    foreach ($brand_colors as $color_key => $color_data) {
        $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDER' . $color_key, array(
            'default'           => $color_data['default'],
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'PREFIX_PHP_PLACEHOLDER' . $color_key, array(
            'label'   => $color_data['label'],
            'section' => 'PREFIX_PHP_PLACEHOLDERbranding_section',
        )));
    }

    // ========================================
    // SECTION: Layout
    // ========================================
    $wp_customize->add_section('PREFIX_PHP_PLACEHOLDERlayout_section', array(
        'title'       => __('Layout', 'TEXT_DOMAIN_PLACEHOLDER'),
        'description' => __('Configure container widths and global design elements.', 'TEXT_DOMAIN_PLACEHOLDER'),
        'priority'    => 34,
    ));

    // Container Max Width
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERcontainer_max_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERcontainer_max_width', array(
        'label'       => __('Container Max Width (px)', 'TEXT_DOMAIN_PLACEHOLDER'),
        'description' => __('Maximum width for content containers', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section'     => 'PREFIX_PHP_PLACEHOLDERlayout_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1440,
            'step' => 20,
        ),
    ));

    // Global Border Radius
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERglobal_radius', array(
        'default'           => 12,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERglobal_radius', array(
        'label'       => __('Global Border Radius (px)', 'TEXT_DOMAIN_PLACEHOLDER'),
        'description' => __('Border radius for buttons, cards, and other elements', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section'     => 'PREFIX_PHP_PLACEHOLDERlayout_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 24,
            'step' => 1,
        ),
    ));
}
add_action('customize_register', 'PREFIX_PHP_PLACEHOLDERcustomize_register');

    // ========================================
    // SECTION: Footer
    // ========================================
    $wp_customize->add_section('PREFIX_PHP_PLACEHOLDERfooter_section', array(
        'title'       => __('Footer', 'TEXT_DOMAIN_PLACEHOLDER'),
        'description' => __('Configure footer layout, content and social media display.', 'TEXT_DOMAIN_PLACEHOLDER'),
        'priority'    => 35,
    ));

    // Footer Columns
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERfooter_columns', array(
        'default'           => 3,
        'sanitize_callback' => 'PREFIX_PHP_PLACEHOLDERsanitize_select',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERfooter_columns', array(
        'label'   => __('Footer Columns', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section' => 'PREFIX_PHP_PLACEHOLDERfooter_section',
        'type'    => 'select',
        'choices' => array(
            '1' => __('1 Column', 'TEXT_DOMAIN_PLACEHOLDER'),
            '2' => __('2 Columns', 'TEXT_DOMAIN_PLACEHOLDER'),
            '3' => __('3 Columns', 'TEXT_DOMAIN_PLACEHOLDER'),
            '4' => __('4 Columns', 'TEXT_DOMAIN_PLACEHOLDER'),
        ),
    ));

    // Footer Text
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERfooter_text', array(
        'default'           => '© {year} AURA BUSINESS NAME. Todos los derechos reservados.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERfooter_text', array(
        'label'       => __('Footer Text', 'TEXT_DOMAIN_PLACEHOLDER'),
        'description' => __('Use {year} for current year replacement.', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section'     => 'PREFIX_PHP_PLACEHOLDERfooter_section',
        'type'        => 'textarea',
    ));

    // Show Footer Socials
    $wp_customize->add_setting('PREFIX_PHP_PLACEHOLDERshow_footer_socials', array(
        'default'           => true,
        'sanitize_callback' => 'PREFIX_PHP_PLACEHOLDERsanitize_checkbox',
    ));
    $wp_customize->add_control('PREFIX_PHP_PLACEHOLDERshow_footer_socials', array(
        'label'   => __('Show Social Media in Footer', 'TEXT_DOMAIN_PLACEHOLDER'),
        'section' => 'PREFIX_PHP_PLACEHOLDERfooter_section',
        'type'    => 'checkbox',
    ));
}
add_action('customize_register', 'PREFIX_PHP_PLACEHOLDERcustomize_register');

/**
 * Sanitize select fields
 */
function PREFIX_PHP_PLACEHOLDERsanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Sanitize checkbox fields
 */
function PREFIX_PHP_PLACEHOLDERsanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize script fields based on user capabilities
 */
function PREFIX_PHP_PLACEHOLDERsanitize_scripts($input) {
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