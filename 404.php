<?php
/**
 * The template for displaying 404 pages (not found)
 * 
 * @package AuraElementorStarter
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <section class="error-404 not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php _e('Oops! That page can&rsquo;t be found.', 'aura-elementor-starter'); ?></h1>
                </header>

                <div class="page-content">
                    <p><?php _e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'aura-elementor-starter'); ?></p>

                    <?php get_search_form(); ?>

                    <div class="widget-area">
                        <div class="widget widget_recent_entries">
                            <h2 class="widget-title"><?php _e('Most Used Categories', 'aura-elementor-starter'); ?></h2>
                            <ul>
                                <?php
                                wp_list_categories(array(
                                    'orderby'    => 'count',
                                    'order'      => 'DESC',
                                    'show_count' => 1,
                                    'title_li'   => '',
                                    'number'     => 10,
                                ));
                                ?>
                            </ul>
                        </div>

                        <?php
                        $archive_content = '<p>' . sprintf(esc_html__('Try looking in the monthly archives. %1$s', 'aura-elementor-starter'), convert_smilies(':)')) . '</p>';
                        the_widget('WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content");

                        the_widget('WP_Widget_Tag_Cloud');
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>

<?php
get_footer();