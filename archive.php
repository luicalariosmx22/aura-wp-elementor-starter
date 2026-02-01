<?php
/**
 * Template for displaying archive pages
 * 
 * @package AuraElementorStarter
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
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
                    'prev_text' => __('&laquo; Older posts', 'aura-elementor-starter'),
                    'next_text' => __('Newer posts &raquo;', 'aura-elementor-starter'),
                ));
                ?>

            <?php else : ?>
                <p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'aura-elementor-starter'); ?></p>
                <?php get_search_form(); ?>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php
get_sidebar();
get_footer();