<?php

/**
 * The template for displaying single page
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package justg
 */

// Exit if accessed directly.

defined('ABSPATH') || exit;
get_header();
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 pt-2">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php the_title( '<h1 class="h4 lh-base secondary-font fw-bold color-theme mt-2 mb-3">', '</h1>' ); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
        </div>
        <div class="col-md-4 pt-2">
            <?php get_sidebar('main');?>
        </div>
    </div>
</div>

<?php
get_footer();