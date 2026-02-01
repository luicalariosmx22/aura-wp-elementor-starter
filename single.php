<?php
/**
 * Template for displaying single posts
 * 
 * @package AuraElementorStarter
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

                        <div class="entry-meta">
                            <span class="posted-on">
                                <?php echo get_the_date(); ?>
                            </span>
                            <span class="byline">
                                <?php _e('by', 'aura-elementor-starter'); ?> 
                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                    <?php echo get_the_author(); ?>
                                </a>
                            </span>
                            <?php if (has_category()) : ?>
                                <span class="cat-links">
                                    <?php _e('in', 'aura-elementor-starter'); ?> 
                                    <?php the_category(', '); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        the_content();
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . __('Pages:', 'aura-elementor-starter'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>

                    <footer class="entry-footer">
                        <?php if (has_tag()) : ?>
                            <div class="tags-links">
                                <?php _e('Tags:', 'aura-elementor-starter'); ?> 
                                <?php the_tags('', ', ', ''); ?>
                            </div>
                        <?php endif; ?>

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
                    </footer>
                </article>

                <?php
                the_post_navigation(array(
                    'prev_text' => '<span class="nav-subtitle">' . __('Previous:', 'aura-elementor-starter') . '</span> <span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">' . __('Next:', 'aura-elementor-starter') . '</span> <span class="nav-title">%title</span>',
                ));

                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>

            <?php endwhile; ?>
        </div>
    </main>
</div>

<?php
get_sidebar();
get_footer();