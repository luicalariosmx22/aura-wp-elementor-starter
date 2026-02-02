<?php
/**
 * Template for displaying archive pages
 * 
 * @author Aura Marketing
 * @link https://agenciaaura.mx
 * @package AuraTheme
 */

get_header(); ?>

<div class="aura-container">
    <?php if (have_posts()) : ?>
        
        <header class="page-header">
            <?php
            the_archive_title('<h1 class="page-title">', '</h1>');
            the_archive_description('<div class="archive-description">', '</div>');
            ?>
        </header>

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
                <h1 class="page-title"><?php esc_html_e('Nothing Found', 'aura-wp-elementor-starter'); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'aura-wp-elementor-starter'); ?></p>
                <?php get_search_form(); ?>
            </div>
        </section>

    <?php endif; ?>
</div>

<?php get_footer();