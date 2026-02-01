<?php
/**
 * Template for displaying single posts
 * 
 * @author Aura Marketing
 * @link https://agenciaaura.mx
 * @package AuraTheme
 */

get_header(); ?>

<div class="aura-container">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

                <?php if ('post' === get_post_type()) : ?>
                    <div class="entry-meta">
                        <span class="posted-on">
                            <time class="entry-date published updated" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <?php echo esc_html(get_the_date()); ?>
                            </time>
                        </span>
                        <span class="byline">
                            <?php esc_html_e('by', 'TEXT_DOMAIN_PLACEHOLDER'); ?> 
                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                <?php echo esc_html(get_the_author()); ?>
                            </a>
                        </span>
                        <?php if (has_category()) : ?>
                            <span class="cat-links">
                                <?php esc_html_e('in', 'TEXT_DOMAIN_PLACEHOLDER'); ?> 
                                <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
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
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'TEXT_DOMAIN_PLACEHOLDER'),
                    'after'  => '</div>',
                ));
                ?>
            </div>

            <footer class="entry-footer">
                <?php if (has_tag()) : ?>
                    <div class="tags-links">
                        <?php esc_html_e('Tags:', 'TEXT_DOMAIN_PLACEHOLDER'); ?> 
                        <?php the_tags('', ', ', ''); ?>
                    </div>
                <?php endif; ?>

                <?php
                edit_post_link(
                    sprintf(
                        wp_kses(
                            __('Edit <span class="screen-reader-text">%s</span>', 'TEXT_DOMAIN_PLACEHOLDER'),
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
            'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'TEXT_DOMAIN_PLACEHOLDER') . '</span> <span class="nav-title">%title</span>',
            'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'TEXT_DOMAIN_PLACEHOLDER') . '</span> <span class="nav-title">%title</span>',
        ));

        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>

    <?php endwhile; // End of the loop. ?>
</div>

<?php get_footer();