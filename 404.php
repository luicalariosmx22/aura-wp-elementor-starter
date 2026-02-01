<?php
/**
 * The template for displaying 404 pages (not found)
 * 
 * @author Aura Marketing
 * @link https://agenciaaura.mx
 * @package AuraTheme
 */

get_header(); ?>

<div class="aura-container">
    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'TEXT_DOMAIN_PLACEHOLDER'); ?></h1>
        </header>

        <div class="page-content">
            <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the options below?', 'TEXT_DOMAIN_PLACEHOLDER'); ?></p>

            <div class="error-404-actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="button">
                    <?php esc_html_e('Back to Homepage', 'TEXT_DOMAIN_PLACEHOLDER'); ?>
                </a>
            </div>

            <div class="search-section">
                <h2><?php esc_html_e('Try searching for what you need:', 'TEXT_DOMAIN_PLACEHOLDER'); ?></h2>
                <?php get_search_form(); ?>
            </div>
        </div>
    </section>
</div>

<?php get_footer();