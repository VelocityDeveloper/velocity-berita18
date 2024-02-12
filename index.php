<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = velocitytheme_option('justg_container_type', 'container');
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php $args_slider = array(
                    'showposts' => 5,
                    'post_type' => array('post'),
                );
                $berita1 = velocitytheme_option('cat_berita1');
                if (!empty($berita1)){
                    $args_slider['cat'] = $berita1;
                }
                $slider_posts = get_posts($args_slider);
                $i = 1;
                if($slider_posts){
                    echo '<div class="py-2 px-3 fw-bold fs-6 bg-dark text-white mb-2 d-md-none d-block">TERBARU</div>';
                    echo '<div id="velocity-home-slider" class="mb-4 carousel slide" data-bs-ride="carousel">';
                        echo '<div class="carousel-inner">';
                            foreach($slider_posts as $post){
                                $no = $i++;
                                $class = $no == 1 ? ' active' : '';
                                $post_id = $post->ID;
                                echo '<div class="text-center carousel-item'.$class.'">';
                                    echo do_shortcode('[resize-thumbnail width="650" height="350" linked="true" class="w-100" post_id="'.$post_id.'"]');
                                    echo '<div class="text-white bg-dark bg-opacity-75 position-absolute bottom-0 start-0 w-100 p-3">';
                                        echo '<a href="'.get_the_permalink($post_id).'" class="d-inline-block text-white fw-bold velocity-title-archive">'.$post->post_title.'</a>';
                                    echo '</div>';
                                echo '</div>';
                            }
                            echo '<button class="carousel-control-prev" type="button" data-bs-target="#velocity-home-slider" data-bs-slide="prev">';
                                echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                                echo '<span class="visually-hidden">Previous</span>';
                            echo '</button>';
                            echo '<button class="carousel-control-next" type="button" data-bs-target="#velocity-home-slider" data-bs-slide="next">';
                                echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                                echo '<span class="visually-hidden">Next</span>';
                            echo '</button>';
                        echo '</div>';
                    echo '</div>';
                } ?>
            <div class="velocity-card mb-4"><?php velocity_post_carousel(velocitytheme_option('cat_berita2'),3,true); ?></div>
            <div class="velocity-card mb-4"><?php velocity_post_carousel(velocitytheme_option('cat_berita3'),3,true); ?></div>
            <div class="velocity-card mb-4">
                <?php velocity_cat_name(); ?>
                <?php velocity_posts_gallery(); ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php get_sidebar('main');?>
        </div>
    </div>
    
</div>

<?php
get_footer();
