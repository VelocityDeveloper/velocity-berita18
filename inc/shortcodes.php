<?php
/**
 * Kumpulan shortcode yang digunakan di theme ini.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
//[resize-thumbnail width="300" height="150" linked="true" class="w-100"]
add_shortcode('resize-thumbnail', 'resize_thumbnail');
function resize_thumbnail($atts) {
    ob_start();
	  global $post;
    $atribut = shortcode_atts( array(
        'output'	=> 'image', /// image or url
        'width'    	=> '300', ///width image
        'height'    => '150', ///height image
        'crop'      => 'false',
        'upscale'   => 'true',
        'linked'   	=> 'true', ///return link to post	
        'class'   	=> 'w-100', ///return class name to img	
        'attachment' => 'true',
        'post_id'   => $post->ID,
    ), $atts );

    $output			= $atribut['output'];
    $attach         = $atribut['attachment'];
    $width          = $atribut['width'];
    $height         = $atribut['height'];
    $crop           = $atribut['crop'];
    $upscale        = $atribut['upscale'];
    $linked        	= $atribut['linked'];
    $post_id        = $atribut['post_id'];
    $class        	= $atribut['class']?'class="'.$atribut['class'].'"':'';
	  $youtube_link		= get_post_meta($post_id,'youtube_link', true);
	  $urlimg			    = get_the_post_thumbnail_url($post_id,'full');
	
	if(empty($urlimg) && $attach == 'true'){
          $attachments = get_posts( array(
            'post_type' 		=> 'attachment',
            'posts_per_page' 	=> 1,
            'post_parent' 		=> $post_id,
        	'orderby'          => 'date',
        	'order'            => 'DESC',
          ) );
          if ( $attachments ) {
				$urlimg = wp_get_attachment_url( $attachments[0]->ID, 'full' );
          }
    }
  
    
  $video_icon = '';
  if($youtube_link):
    echo '<div class="position-relative">';
    $video_icon = '<div class="velocity-thumbnail-video"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16"><path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z"/></svg></div>';
  endif;
	if($urlimg):
		$urlresize      = aq_resize( $urlimg, $width, $height, $crop, true, $upscale );
		if($output=='image'):
			if($linked=='true'):
				echo '<a class="d-block position-relative" href="'.get_the_permalink($post_id).'" title="'.get_the_title($post_id).'">';
			endif;
      echo $video_icon;
			echo '<img src="'.$urlresize.'" width="'.$width.'" height="'.$height.'" loading="lazy" '.$class.'>';
			if($linked=='true'):
				echo '</a>';
			endif;
		else:
			echo $urlresize;
		endif;

	else:
		if($linked=='true'):
			echo '<a class="d-block position-relative" href="'.get_the_permalink($post_id).'" title="'.get_the_title($post_id).'">';
		endif;
    echo $video_icon;
		echo '<svg style="background-color: #ececec;width: 100%;height: auto;" width="'.$width.'" height="'.$height.'"></svg>';
		if($linked=='true'):
			echo '</a>';
		endif;
	endif;
  if($youtube_link):
    echo '</div>';
  endif;

	return ob_get_clean();
}

//[velocity-excerpt count="150" post_id=""]
add_shortcode('velocity-excerpt', 'vd_getexcerpt');
function vd_getexcerpt($atts){
    ob_start();
	global $post;
    $atribut = shortcode_atts( array(
        'count'	=> '150', /// count character
        'post_id'   => $post->ID,
    ), $atts );
    $post_id        = $atribut['post_id'];

    $count		= $atribut['count'];
    $excerpt	= get_the_excerpt($post_id);
    $excerpt 	= strip_tags($excerpt);
    $excerpt 	= substr($excerpt, 0, $count);
    $excerpt 	= substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt 	= ''.$excerpt.'...';

    echo $excerpt;

	return ob_get_clean();
}

// [vd-breadcrumbs]
add_shortcode('vd-breadcrumbs','vd_breadcrumbs');
function vd_breadcrumbs() {
    ob_start();
    echo justg_breadcrumb();
    return ob_get_clean();
}

//[ratio-thumbnail size="medium" ratio="16:9"]
add_shortcode('ratio-thumbnail', 'ratio_thumbnail');
function ratio_thumbnail($atts) {
    ob_start();
	global $post;

    $atribut = shortcode_atts( array(
        'size'      => 'medium', // thumbnail, medium, large, full
        'ratio'     => '16:9', // 16:9, 8:5, 4:3, 3:2, 1:1
    ), $atts );

    $size       = $atribut['size'];
    $ratio      = $atribut['ratio'];
    $ratio      = $ratio?str_replace(":","-",$ratio):'';
	$urlimg     = get_the_post_thumbnail_url($post->ID,$size);

    echo '<div class="ratio-thumbnail">';
        echo '<a class="ratio-thumbnail-link" href="'.get_the_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
            echo '<div class="ratio-thumbnail-box ratio-thumbnail-'.$ratio.'" style="background-image: url('.$urlimg.');">';
                echo '<img src="'.$urlimg.'" loading="lazy" class="ratio-thumbnail-image"/>';
            echo '</div>';
        echo '</a>';
    echo '</div>';

	return ob_get_clean();
}


// [velocity-post-tabs]
function velocity_post_tabs() {
    ob_start();
    $jumlah = 3; ?>

<ul class="nav nav-tabs velocity-post-tabs row p-0" role="tablist">
  <li class="nav-item pb-0 border-0 col p-0 text-center">
    <a class="nav-link active secondary-font fw-bold rounded-0" id="kategori1-tab" data-bs-toggle="tab" href="#kategori1" role="tab" aria-controls="kategori1" aria-selected="true">
	Popular</a>
  </li>
  <li class="nav-item pb-0 border-0 col p-0 text-center">
    <a class="nav-link secondary-font fw-bold rounded-0" id="kategori2-tab" data-bs-toggle="tab" href="#kategori2" role="tab" aria-controls="kategori2" aria-selected="false">
	Recent</a>
  </li>
  <li class="nav-item pb-0 border-0 col p-0 text-center">
    <a class="nav-link secondary-font fw-bold rounded-0" id="kategori3-tab" data-bs-toggle="tab" href="#kategori3" role="tab" aria-controls="kategori3" aria-selected="false">
	Comment</a>
  </li>
</ul>
<div class="tab-content py-2 border-left border-right border-bottom" id="myTabContent">
<div class="tab-pane fade show active" id="kategori1" role="tabpanel" aria-labelledby="kategori1-tab">
<?php $args = array(
	'posts_per_page' => $jumlah,
	'showposts' => $jumlah,
	'meta_key' => 'hit',
	'orderby' => 'meta_value_num',
	'order' => 'DESC',
);

$wp_query = new WP_Query($args); 
if($wp_query->have_posts ()): ?>
<div class="frame-kategori">
<?php while($wp_query->have_posts()): $wp_query->the_post();
        echo '<div class="row m-0 py-2">';
        echo '<div class="col-4 col-md-3 p-0">';
        if ( has_post_thumbnail() ){
          echo '<a href="'.get_the_permalink().'">';
            echo velocity_thumbnail('200','200','false','true','w-100 img-fluid',get_the_ID());
          echo '</a>';
        }
		echo '</div>';
		echo '<div class="col-8 col-md-9 py-1">';
		$vtitle= get_the_title();
		echo '<div class="vtitle"><a class="text-color-theme secondary-font fw-bold" href="'.get_the_permalink().'">'.substr($vtitle, 0, 60) . ' ...'.'</a></div>';
		echo '<div class="text-success"><small><i class="fa fa-calendar" aria-hidden="true"></i> ';
		  velocity_post_date(get_the_ID());
		echo ' / <i class="fa fa-eye" aria-hidden="true"></i> '.get_post_meta(get_the_ID(),'hit',true).'</small></div>';
		echo '</div>';
		echo '</div>';
?>
<?php endwhile; ?>
</div>
<?php else :
_e( '<p>Belum ada post.</p>' );
endif;
wp_reset_query (); ?>
</div>
<div class="tab-pane fade" id="kategori2" role="tabpanel" aria-labelledby="kategori2-tab">
<?php $args2 = array(
	'posts_per_page' => $jumlah,
	'showposts' => $jumlah, 
);

$wp_query2 = new WP_Query($args2); 
if($wp_query2->have_posts ()): ?>
<div class="frame-kategori">
<?php while($wp_query2->have_posts()): $wp_query2->the_post();
        echo '<div class="row m-0 py-2 px-1">';
        echo '<div class="col-4 col-md-3 p-0">';
        if ( has_post_thumbnail() ){
          echo '<a href="'.get_the_permalink().'">';
            echo velocity_thumbnail('200','200','false','true','w-100 img-fluid',get_the_ID());
          echo '</a>';
        }
		echo '</div>';
		echo '<div class="col-8 col-md-9 py-1">';
		$vtitle= get_the_title();
		echo '<div class="vtitle"><a class="text-color-theme secondary-font fw-bold" href="'.get_the_permalink().'">'.substr($vtitle, 0, 60) . ' ...'.'</a></div>';
		echo '<div class="text-success"><small><i class="fa fa-calendar" aria-hidden="true"></i> ';
		  velocity_post_date(get_the_ID());
		echo '</small></div>';
		echo '</div>';
		echo '</div>';
?>
<?php endwhile; ?>
</div>
<?php else :
_e( '<p>Belum ada post.</p>' );
endif;
wp_reset_query (); ?>
</div>
  
<div class="tab-pane fade" id="kategori3" role="tabpanel" aria-labelledby="kategori3-tab">
<?php $args3 = array(
	'posts_per_page' => $jumlah,
	'showposts' => $jumlah,
	'orderby' => 'comment_count',
	'order' => 'DESC',
);

$wp_query3 = new WP_Query($args3); 
if($wp_query3->have_posts ()): ?>
<div class="frame-kategori">
<?php while($wp_query3->have_posts()): $wp_query3->the_post();
        echo '<div class="row m-0 py-2 px-1">';
        echo '<div class="col-4 col-md-3 p-0">';
        if ( has_post_thumbnail() ){
          echo '<a href="'.get_the_permalink().'">';
            echo velocity_thumbnail('200','200','false','true','w-100 img-fluid',get_the_ID());
          echo '</a>';
        }
		echo '</div>';
		echo '<div class="col-8 col-md-9 py-1">';
		$vtitle= get_the_title();
		echo '<div class="vtitle"><a class="text-color-theme secondary-font fw-bold" href="'.get_the_permalink().'">'.substr($vtitle, 0, 60) . ' ...'.'</a></div>';
		echo '<div class="text-success"><small><i class="fa fa-calendar" aria-hidden="true"></i> ';
		  velocity_post_date(get_the_ID());
		echo ' / <i class="fa fa-comments" aria-hidden="true"></i> '.get_comments_number(get_the_ID()).'</small></div>';
		echo '</div>';
		echo '</div>';
?>
<?php endwhile; ?>
</div>
<?php else :
_e( '<p>Belum ada post.</p>' );
endif;
wp_reset_query (); ?>
</div>
</div>
    <?php
    return ob_get_clean();
}
add_shortcode ('velocity-post-tabs', 'velocity_post_tabs');


// [velocity-popular-posts]
function velocity_popular_posts(){
	ob_start();
	$args['post_type'] = 'post';
	$args['meta_key'] = 'hit';
	$args['orderby'] = 'meta_value_num';
	$args['order'] = 'DESC';
	$args['showposts'] = 10;
	$wpex_query = new wp_query( $args );
	if($wpex_query->have_posts()):
	echo '<div class="velocity-popular-posts">';
		while($wpex_query->have_posts()): $wpex_query->the_post(); ?>
		<div class="velocity-popular-list mb-3">
			<div class="fw-bold mb-0"><a class="text-color-theme" href="<?php echo get_the_permalink($post->ID); ?>"><b><?php echo get_the_title($post->ID); ?></b></a></div>
			<small class="text-success"><?php velocity_post_date(get_the_ID());?>  |  <?php echo get_post_meta(get_the_ID(), 'hit', true);?> dilihat</small>
		</div>
	<?php endwhile;
	echo '</div>';
	endif;
	wp_reset_postdata();
	return ob_get_clean();
}
add_shortcode('velocity-popular-posts', 'velocity_popular_posts');


// [velocity-recent-posts]
function velocity_recent_posts($atts){
	ob_start();
    $args = shortcode_atts( array(
        'style'   => 'list', // list, gallery, first_image
        'post_type'   => 'post',
        'category_name'   => '',
        'showposts'   => 4,
        'date'   => true,
    ), $atts );
    $style = $args['style'];
    $show_date = $args['date'];
	$wpex_query = new wp_query( $args );
	if($wpex_query->have_posts()):
    if($style == 'gallery'){
      $topclass = ' row row-vd';
      $colframe = ' col-6 mb-2 px-1';
      $col1 = ' mb-2';
      $col2 = '';
    } else {
      $topclass = '';
      $colframe = ' mb-3 row';
      $col1 = ' col-4 col-md-3 pe-0';
      $col2 = ' col-8 col-md-9';
    } 
	echo '<div class="velocity-recent-posts'.$topclass.'">';
    $i = 0;
		while($wpex_query->have_posts()): $wpex_query->the_post();
    $no = ++$i;
    $post_id = get_the_ID();
    if($style == 'first_image' && $no == '1'){
      $class = 'col-12 mb-2';
    } else {
      $class = $col1;
    } ?>
		<div class="velocity-recent-list<?php echo $colframe;?>">
      <div class="col-image<?php echo $class;?>">
        <?php echo do_shortcode('[resize-thumbnail width="400" height="280" linked="true" class="w-100" post_id="'.$post_id .'"]');?>
      </div>
      <div class="col-content<?php echo $col2;?>">
        <div class="v-post-title fw-bold mb-0"><a class="text-color-theme" href="<?php echo get_the_permalink($post_id ); ?>"><b><?php echo get_the_title($post_id ); ?></b></a></div>
        <?php if($show_date==true){ ?>
          <small class="v-post-date text-success"><?php velocity_post_date($post_id);?></small>
        <?php } ?>
		  </div>
		</div>
	<?php endwhile;
	echo '</div>';
	endif;
	wp_reset_postdata();
	return ob_get_clean();
}
add_shortcode('velocity-recent-posts', 'velocity_recent_posts');


// [velocity-categories]
add_shortcode('velocity-categories', function() {
	$parent_categories = get_categories(array(
		'parent'        => 0,
		'hide_empty'    => 0
	));
	$html = '<ul class="list-group list-group-flush mb-3">';
	foreach ($parent_categories as $category) {
		if ($category->slug !== 'uncategorized') {
			$html .= '<li class="list-group-item px-0"><a class="text-color-theme" href="'.get_category_link($category->term_id).'">'.$category->name.'</a></li>';
		}
	}
	$html .= '</ul>';
  return $html;
});