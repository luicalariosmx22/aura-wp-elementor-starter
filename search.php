<?php
/**
 * Template for displaying search results pages
 * 
 * @package AuraElementorStarter
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <header class="page-header">
                <h1 class="page-title">
                    <?php
                    printf(
                        esc_html__('Search Results for: %s', 'aura-elementor-starter'),
                        '<span>' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
            </header>

            <?php if (have_posts()) : ?>
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
                <section class="no-results not-found">
                    <header class="page-header">
                        <h1 class="page-title"><?php _e('Nothing here', 'aura-elementor-starter'); ?></h1>
                    </header>

                    <div class="page-content">
                        <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'aura-elementor-starter'); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php
get_sidebar();
get_footer();