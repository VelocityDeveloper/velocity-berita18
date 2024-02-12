<?php

/**
 * The template for displaying archive pages
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
        <div class="col-md-8">	
            <h1 class="velocity-title"><?php wp_title(''); ?></h1>
			<?php velocity_posts_gallery(); ?>
        </div>
        <div class="col-md-4 mt-3 mt-md-0 order-md-3">
            <?php get_sidebar('main');?>
        </div>
    </div>
</div>

<?php
get_footer();