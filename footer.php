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
?>
<footer class="site-footer">
    <div class="aura-container">
        <div class="site-info">
            <p>
                <?php
                printf(
                    esc_html__('Theme by %1$s • %2$s', 'TEXT_DOMAIN_PLACEHOLDER'),
                    '<a href="https://agenciaaura.mx" target="_blank" rel="noopener">Aura Marketing</a>',
                    '<a href="https://agenciaaura.mx" target="_blank" rel="noopener">agenciaaura.mx</a>'
                );
                ?>
            </p>
        </div>
    </div>
</footer>
<?php
}
?>

<?php wp_footer(); ?>

</body>
</html>