<?php
/**
 * Main template file
 * 
 * @author Aura Marketing
 * @link https://agenciaaura.mx
 * @package AuraTheme
 */

get_header(); ?>

<div class="aura-container">
    <?php if (have_posts()) : ?>
        
        <?php if (is_home() && !is_front_page()) : ?>
            <header class="page-header">
                <h1 class="page-title"><?php single_post_title(); ?></h1>
            </header>
        <?php endif; ?>

        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('template-parts/content', 'archive'); ?>
        <?php endwhile; ?>

        <?php
        the_posts_navigation(array(
            'prev_text' => esc_html__('&laquo; Older posts', 'aura-wp-elementor-starter'),
            'next_text' => esc_html__('Newer posts &raquo;', 'aura-wp-elementor-starter'),
        ));
        ?>

    <?php else : ?>
        
        <section class="no-results not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Nothing here', 'aura-wp-elementor-starter'); ?></h1>
            </header>

            <div class="page-content">
                <?php if (is_home() && current_user_can('publish_posts')) : ?>
                    <p>
                        <?php
                        printf(
                            wp_kses(
                                __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'aura-wp-elementor-starter'),
                                array(
                                    'a' => array(
                                        'href' => array(),
                                    ),
                                )
                            ),
                            esc_url(admin_url('post-new.php'))
                        );
                        ?>
                    </p>
                <?php else : ?>
                    <p><?php esc_html_e('It looks like nothing was found at this location.', 'aura-wp-elementor-starter'); ?></p>
                <?php endif; ?>
            </div>
        </section>

    <?php endif; ?>
</div>

<?php get_footer();