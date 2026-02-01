<?php
/**
 * The main template file
 * 
 * @package AuraElementorStarter
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <?php if (have_posts()) : ?>
                <header class="page-header">
                    <h1 class="page-title">
                        <?php
                        if (is_home() && !is_front_page()) :
                            single_post_title();
                        else :
                            _e('Latest Posts', 'aura-elementor-starter');
                        endif;
                        ?>
                    </h1>
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
                <p><?php _e('No posts found.', 'aura-elementor-starter'); ?></p>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php
get_sidebar();
get_footer();