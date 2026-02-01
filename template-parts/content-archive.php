<?php
/**
 * Template part for displaying posts in archives
 * 
 * @package AuraElementorStarter
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;
        ?>

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
                    <?php _e('by', 'aura-elementor-starter'); ?> 
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
                <?php _e('Posted in', 'aura-elementor-starter'); ?> <?php the_category(', '); ?>
            </span>
        <?php endif; ?>

        <?php if (has_tag()) : ?>
            <span class="tags-links">
                <?php the_tags('', ', ', ''); ?>
            </span>
        <?php endif; ?>

        <a href="<?php echo esc_url(get_permalink()); ?>" class="read-more">
            <?php _e('Read More', 'aura-elementor-starter'); ?>
        </a>
    </footer>
</article>