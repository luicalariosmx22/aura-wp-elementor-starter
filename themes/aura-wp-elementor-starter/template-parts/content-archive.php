<?php
/**
 * Template part for displaying posts in archives and index
 * 
 * @author Aura Marketing
 * @link https://agenciaaura.mx
 * @package AuraTheme
 */
?>

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
                    <?php esc_html_e('by', 'aura-wp-elementor-starter'); ?> 
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
                <?php the_post_thumbnail('medium_large'); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>

    <footer class="entry-footer">
        <?php if (has_category()) : ?>
            <span class="cat-links">
                <?php esc_html_e('Posted in', 'aura-wp-elementor-starter'); ?> <?php the_category(', '); ?>
            </span>
        <?php endif; ?>

        <a href="<?php echo esc_url(get_permalink()); ?>" class="read-more">
            <?php esc_html_e('Read More', 'aura-wp-elementor-starter'); ?>
        </a>
    </footer>
</article>