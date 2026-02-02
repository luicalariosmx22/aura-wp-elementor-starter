<?php
/**
 * Template for displaying search results pages
 * 
 * @author Aura Marketing
 * @link https://agenciaaura.mx
 * @package AuraTheme
 */

get_header(); ?>

<div class="aura-container">
    <header class="page-header">
        <h1 class="page-title">
            <?php
            printf(
                esc_html__('Search Results for: %s', 'TEXT_DOMAIN_PLACEHOLDER'),
                '<span>' . get_search_query() . '</span>'
            );
            ?>
        </h1>
    </header>

    <?php if (have_posts()) : ?>
        
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>

                    <?php if ('post' === get_post_type()) : ?>
                        <div class="entry-meta">
                            <span class="posted-on">
                                <a href="<?php echo esc_url(get_permalink()); ?>" rel="bookmark">
                                    <time class="entry-date published updated" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo esc_html(get_the_date()); ?>
                                    </time>
                                </a>
                            </span>
                            <span class="byline">
                                <?php esc_html_e('by', 'TEXT_DOMAIN_PLACEHOLDER'); ?> 
                                <span class="author vcard">
                                    <a class="url fn n" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                        <?php echo esc_html(get_the_author()); ?>
                                    </a>
                                </span>
                            </span>
                        </div>
                    <?php endif; ?>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <a href="<?php echo esc_url(get_permalink()); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="entry-summary">
                    <?php the_excerpt(); ?>
                </div>

                <footer class="entry-footer">
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="read-more">
                        <?php esc_html_e('Read More', 'TEXT_DOMAIN_PLACEHOLDER'); ?>
                    </a>
                </footer>
            </article>
        <?php endwhile; ?>

        <?php
        the_posts_navigation(array(
            'prev_text' => esc_html__('&laquo; Older posts', 'TEXT_DOMAIN_PLACEHOLDER'),
            'next_text' => esc_html__('Newer posts &raquo;', 'TEXT_DOMAIN_PLACEHOLDER'),
        ));
        ?>

    <?php else : ?>
        
        <section class="no-results not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Nothing Found', 'TEXT_DOMAIN_PLACEHOLDER'); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'TEXT_DOMAIN_PLACEHOLDER'); ?></p>
                <?php get_search_form(); ?>
            </div>
        </section>

    <?php endif; ?>
</div>

<?php get_footer();