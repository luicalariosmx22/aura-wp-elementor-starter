<?php
/**
 * Theme Header
 * 
 * @author Aura Marketing
 * @link https://agenciaaura.mx
 * @package AuraTheme
 */

// Get customizer options
$header_style = get_theme_mod('PREFIX_PHP_PLACEHOLDERheader_style', 'style-1');
$header_sticky = get_theme_mod('PREFIX_PHP_PLACEHOLDERheader_sticky', false);
$show_socials = get_theme_mod('PREFIX_PHP_PLACEHOLDERshow_socials', true);
$show_cta = get_theme_mod('PREFIX_PHP_PLACEHOLDERshow_cta', false);
$cta_text = get_theme_mod('PREFIX_PHP_PLACEHOLDERcta_text', __('Contáctanos', 'TEXT_DOMAIN_PLACEHOLDER'));
$cta_url = get_theme_mod('PREFIX_PHP_PLACEHOLDERcta_url', '');
$header_extra_html = get_theme_mod('PREFIX_PHP_PLACEHOLDERheader_extra_html', '');

// Social media URLs
$social_networks = array(
    'facebook'  => get_theme_mod('PREFIX_PHP_PLACEHOLDERsocial_facebook', ''),
    'instagram' => get_theme_mod('PREFIX_PHP_PLACEHOLDERsocial_instagram', ''),
    'tiktok'    => get_theme_mod('PREFIX_PHP_PLACEHOLDERsocial_tiktok', ''),
    'youtube'   => get_theme_mod('PREFIX_PHP_PLACEHOLDERsocial_youtube', ''),
    'whatsapp'  => get_theme_mod('PREFIX_PHP_PLACEHOLDERsocial_whatsapp', ''),
    'x'         => get_theme_mod('PREFIX_PHP_PLACEHOLDERsocial_x', ''),
);

// Check if we have at least one social URL
$has_social_urls = false;
foreach ($social_networks as $url) {
    if (!empty($url)) {
        $has_social_urls = true;
        break;
    }
}

// Build header classes
$header_classes = array('aura-header', 'aura-header--' . $header_style);
if ($header_sticky) {
    $header_classes[] = 'aura-header--sticky';
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="<?php echo esc_attr(implode(' ', $header_classes)); ?>">
    <div class="aura-container">
        <div class="aura-header__inner">
            
            <!-- Logo/Branding -->
            <div class="aura-header__branding">
                <?php if (has_custom_logo()) : ?>
                    <div class="aura-header__logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <div class="aura-header__site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                        <?php
                        $description = get_bloginfo('description', 'display');
                        if ($description || is_customize_preview()) :
                        ?>
                            <p class="aura-header__site-description"><?php echo $description; ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Extra HTML Content -->
            <?php if (!empty($header_extra_html)) : ?>
                <div class="aura-header__extra">
                    <?php echo $header_extra_html; ?>
                </div>
            <?php endif; ?>

            <!-- Mobile Menu Toggle -->
            <button class="aura-header__toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'TEXT_DOMAIN_PLACEHOLDER'); ?>">
                <span class="aura-header__toggle-bar"></span>
                <span class="aura-header__toggle-bar"></span>
                <span class="aura-header__toggle-bar"></span>
            </button>

            <!-- Navigation Container -->
            <div class="aura-header__nav-container" id="aura-header-nav-container">
                
                <!-- Primary Navigation -->
                <nav class="aura-header__navigation" id="primary-navigation" aria-label="<?php esc_attr_e('Primary Menu', 'TEXT_DOMAIN_PLACEHOLDER'); ?>">
                    <?php
                    wp_nav_menu(array(
                        'theme_location'  => 'primary',
                        'menu_id'         => 'primary-menu',
                        'container'       => false,
                        'menu_class'      => 'aura-header__menu',
                        'fallback_cb'     => 'wp_page_menu',
                        'fallback_args'   => array(
                            'menu_class' => 'aura-header__menu',
                        ),
                    ));
                    ?>
                </nav>

                <!-- Header Actions -->
                <div class="aura-header__actions">
                    
                    <!-- Social Media Links -->
                    <?php if ($show_socials && $has_social_urls) : ?>
                        <div class="aura-header__social">
                            <?php foreach ($social_networks as $network => $url) : ?>
                                <?php if (!empty($url)) : ?>
                                    <a href="<?php echo esc_url($url); ?>" 
                                       class="aura-header__social-link aura-header__social-link--<?php echo esc_attr($network); ?>"
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       aria-label="<?php echo esc_attr(sprintf(__('Visit our %s', 'TEXT_DOMAIN_PLACEHOLDER'), ucfirst($network))); ?>">
                                        <span class="aura-header__social-icon aura-header__social-icon--<?php echo esc_attr($network); ?>"></span>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- CTA Button -->
                    <?php if ($show_cta && !empty($cta_url) && !empty($cta_text)) : ?>
                        <div class="aura-header__cta">
                            <a href="<?php echo esc_url($cta_url); ?>" class="aura-header__cta-button">
                                <?php echo esc_html($cta_text); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</header>

<main id="primary" class="site-main">