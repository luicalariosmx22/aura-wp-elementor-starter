<?php
/**
 * Template for displaying footer
 * 
 * @author Aura Marketing
 * @link https://agenciaaura.mx
 * @package AuraTheme
 */
?>
</main>

<?php 
if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('footer')) {
    // Elementor Footer Template
} else {
    // Default Footer
    $footer_columns = get_theme_mod('PREFIX_PHP_PLACEHOLDERfooter_columns', 3);
    $footer_text = get_theme_mod('PREFIX_PHP_PLACEHOLDERfooter_text', '© {year} AURA BUSINESS NAME. Todos los derechos reservados.');
    $show_footer_socials = get_theme_mod('PREFIX_PHP_PLACEHOLDERshow_footer_socials', true);
?>
<footer class="site-footer">
    <div class="aura-container">
        
        <?php if ($footer_columns > 0) : ?>
        <div class="footer-widgets footer-columns-<?php echo esc_attr($footer_columns); ?>">
            <?php for ($i = 1; $i <= $footer_columns; $i++) : ?>
                <?php if (is_active_sidebar('footer-' . $i)) : ?>
                <div class="footer-widget-area footer-widget-<?php echo esc_attr($i); ?>">
                    <?php dynamic_sidebar('footer-' . $i); ?>
                </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
        
        <div class="site-info">
            <?php if ($footer_text) : ?>
                <div class="footer-text">
                    <p><?php echo wp_kses_post(str_replace('{year}', date('Y'), $footer_text)); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ($show_footer_socials) : ?>
                <div class="footer-socials">
                    <?php
                    // Social networks array
                    $social_networks = array(
                        'facebook' => __('Facebook', 'TEXT_DOMAIN_PLACEHOLDER'),
                        'instagram' => __('Instagram', 'TEXT_DOMAIN_PLACEHOLDER'),
                        'tiktok' => __('TikTok', 'TEXT_DOMAIN_PLACEHOLDER'),
                        'youtube' => __('YouTube', 'TEXT_DOMAIN_PLACEHOLDER'),
                        'whatsapp' => __('WhatsApp', 'TEXT_DOMAIN_PLACEHOLDER'),
                        'x' => __('X (Twitter)', 'TEXT_DOMAIN_PLACEHOLDER'),
                    );
                    
                    foreach ($social_networks as $network => $label) {
                        $social_url = get_theme_mod('PREFIX_PHP_PLACEHOLDERsocial_' . $network, '');
                        if ($social_url) {
                            printf(
                                '<a href="%s" target="_blank" rel="noopener" class="footer-social-link footer-social-%s" aria-label="%s">📱</a>',
                                esc_url($social_url),
                                esc_attr($network),
                                esc_attr($label)
                            );
                        }
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</footer>
<?php
}
?>

<?php wp_footer(); ?>

</body>
</html>