<?php
/**
 * Template Name: Blank (No Header/Footer)
 * Template Post Type: page
 * 
 * @author Aura Marketing
 * @link https://agenciaaura.mx
 * @package AuraTheme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class('template-blank'); ?>>
<?php wp_body_open(); ?>

<main id="primary" class="site-main">
    <?php
    while (have_posts()) : the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php wp_footer(); ?>

</body>
</html>