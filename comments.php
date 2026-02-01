<?php
/**
 * The template for displaying comments
 * 
 * @package AuraElementorStarter
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    _x('One thought on &ldquo;%1$s&rdquo;', 'comments title', 'aura-elementor-starter'),
                    get_the_title()
                );
            } else {
                printf(
                    _nx(
                        '%1$s thought on &ldquo;%2$s&rdquo;',
                        '%1$s thoughts on &ldquo;%2$s&rdquo;',
                        $comment_count,
                        'comments title',
                        'aura-elementor-starter'
                    ),
                    number_format_i18n($comment_count),
                    get_the_title()
                );
            }
            ?>
        </h2>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if (!comments_open()) :
        ?>
            <p class="no-comments"><?php _e('Comments are closed.', 'aura-elementor-starter'); ?></p>
        <?php
        endif;

    endif;

    comment_form();
    ?>
</div>