<?php
/**
 * Template Name: Full Width
 * Template for full-width pages without sidebar
 * 
 * @package AuraElementorStarter
 */

get_header(); ?>

<div id="primary" class="content-area full-width">
    <main id="main" class="site-main">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if (!is_front_page()) : ?>
                    <header class="entry-header">
                        <div class="container">
                            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                        </div>
                    </header>
                <?php endif; ?>

                <div class="entry-content">
                    <div class="container">
                        <?php
                        the_content();
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . __('Pages:', 'aura-elementor-starter'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </div>

                <?php if (get_edit_post_link()) : ?>
                    <footer class="entry-footer">
                        <div class="container">
                            <?php
                            edit_post_link(
                                sprintf(
                                    wp_kses(
                                        __('Edit <span class="screen-reader-text">%s</span>', 'aura-elementor-starter'),
                                        array(
                                            'span' => array(
                                                'class' => array(),
                                            ),
                                        )
                                    ),
                                    get_the_title()
                                ),
                                '<span class="edit-link">',
                                '</span>'
                            );
                            ?>
                        </div>
                    </footer>
                <?php endif; ?>
            </article>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
            ?>
                <div class="container">
                    <?php comments_template(); ?>
                </div>
            <?php endif; ?>

        <?php endwhile; ?>
    </main>
</div>

<?php get_footer();