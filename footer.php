    </div><!-- #page -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-widgets">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-widget-area">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="site-info">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 
                <?php _e('Powered by', 'aura-elementor-starter'); ?> 
                <a href="<?php echo esc_url(__('https://wordpress.org/')); ?>">WordPress</a> 
                <?php _e('& Elementor', 'aura-elementor-starter'); ?>.</p>
            </div>

            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer',
                'menu_class'     => 'footer-menu',
                'fallback_cb'    => false,
            ));
            ?>
        </div>
    </footer>

<?php wp_footer(); ?>

</body>
</html>