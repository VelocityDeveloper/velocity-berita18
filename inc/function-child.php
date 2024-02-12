<?php
/**
 * Fuction yang digunakan di theme ini.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_action( 'after_setup_theme', 'velocitychild_theme_setup', 9 );

function velocitychild_theme_setup() {	

	if (class_exists('Kirki')) :

		Kirki::add_panel('panel_berita', [
			'priority'    => 10,
			'title'       => esc_html__('Berita', 'justg'),
			'description' => esc_html__('', 'justg'),
		]);

		///Section Color
		Kirki::add_section('section_colorberita', [
			'panel'    => 'panel_berita',
			'title'    => __('Warna', 'justg'),
			'priority' => 10,
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'color',
			'settings'    => 'color_theme',
			'label'       => __('Color Theme', 'kirki'),
			'description' => esc_html__('', 'kirki'),
			'section'     => 'section_colorberita',
			'default'     => '#222222',
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => ':root',
					'property'  => '--color-theme',
				],
				[
					'element'   => '.border-color-theme',
					'property'  => '--bs-border-color',
				]
			],
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'background',
			'settings'    => 'background_website',
			'label'       => esc_html__('Background', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_colorberita',
			'default'     => [
				'background-color'      => '#111111',
				'background-image'      => '',
				'background-repeat'     => 'repeat',
				'background-position'   => 'center center',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => ':root[data-bs-theme=light] body',
				],
			],
		]);

		///Section Iklan
		Kirki::add_section('section_iklanberita', [
			'panel'    => 'panel_berita',
			'title'    => __('Iklan', 'justg'),
			'priority' => 10,
		]);
		$fieldiklan = [
			'iklan_header1'  => [
				'label'			=> 'Iklan Header 1',
				'description'	=> 'Ukuran gambar 980x100',
			],
			'iklan_header2'  => [
				'label'			=> 'Iklan Header 2',
				'description'	=> 'Ukuran gambar 980x100',
			],
			'iklan_footer'  => [
				'label'			=> 'Iklan Footer',
				'description'	=> 'Ukuran gambar 980x100',
			],
			'iklan_single'  => [
				'label'			=> 'Iklan Halaman Berita',
				'description'	=> 'Iklan Halaman Berita 640x100',
			]
		];
		foreach ($fieldiklan as $idfield => $datafield) {
			Kirki::add_field('justg_config', [
				'type'        => 'image',
				'settings'    => 'image_' . $idfield,
				'label'       => esc_html__('Gambar ' . $datafield['label'], 'kirki'),
				'description' => esc_html__($datafield['description'], 'kirki'),
				'section'     => 'section_iklanberita',
				'default'     => '',
				'partial_refresh'	=> [
					'partial_' . $idfield => [
						'selector'        => '.part_' . $idfield,
						'render_callback' => '__return_false'
					]
				],
			]);
			Kirki::add_field('justg_config', [
				'type'     => 'link',
				'settings' => 'link_' . $idfield,
				'label'    => __('Link ' . $datafield['label'], 'kirki'),
				'section'  => 'section_iklanberita',
				'default'  => '',
				'priority' => 10,
			]);
		}

		///Section Home
		Kirki::add_section('section_homeberita', [
			'panel'    => 'panel_berita',
			'title'    => __('Home', 'justg'),
			'priority' => 10,
		]);

		///Section Kolom Kanan
		Kirki::add_section('section_sidebarberita', [
			'panel'    => 'panel_berita',
			'title'    => __('Kolom Kanan', 'justg'),
			'priority' => 10,
		]);

		///field set posts
		$fieldposts = [
			'pilihan_editor'  => [
				'label'		=> 'Pilihan Editor',
				'section'	=> 'section_homeberita',
			],
			'berita1'  => [
				'label'		=> 'Berita 1',
				'section'	=> 'section_homeberita',
			],
			'berita2'  => [
				'label'		=> 'Berita 2',
				'section'	=> 'section_homeberita',
			],
			'berita3'  => [
				'label'		=> 'Berita 3',
				'section'	=> 'section_homeberita',
			],
			'berita4'  => [
				'label'		=> 'Berita 4',
				'section'	=> 'section_homeberita',
			],
			'berita5'  => [
				'label'		=> 'Berita 5',
				'section'	=> 'section_homeberita',
			],
			'berita6'  => [
				'label'		=> 'Berita 6',
				'section'	=> 'section_homeberita',
			],
		];
		$categories = Kirki_Helper::get_terms('category');
		$categories[''] = 'Semua Kategori';
		unset($categories[1]);
		foreach ($fieldposts as $idfield => $datafield) {
			Kirki::add_field('justg_config', [
				'type'        => 'select',
				'settings'    => 'cat_' . $idfield,
				'label'       => esc_html__($datafield['label'], 'kirki'),
				'section'     => $datafield['section'],
				'default'     => '',
				'placeholder' => esc_html__('Pilih kategori', 'kirki'),
				'priority'    => 10,
				'multiple'    => 1,
				'choices'     => $categories,
				'partial_refresh'	=> [
					'partial_' . $idfield => [
						'selector'        => '.part_' . $idfield,
						'render_callback' => '__return_false'
					]
				],
			]);
		}

		// remove panel in customizer 
		Kirki::remove_panel('global_panel');
		Kirki::remove_panel('panel_footer');
		Kirki::remove_section('header_image');

		Kirki::remove_section('header_section');		
		//Kirki::remove_control('header_section');
		// Kirki::remove_control('display_header_text');

	endif;

	register_nav_menus(
		array(
			'secondary' => __('Secondary Menu', 'justg'),
		)
	);

	//remove action from Parent Theme
	remove_action('justg_header', 'justg_header_menu');
	remove_action('justg_do_footer', 'justg_the_footer_open');
	remove_action('justg_do_footer', 'justg_the_footer_content');
	remove_action('justg_do_footer', 'justg_the_footer_close');

}



// Unregister sidebars
function velocity_remove_widgets(){
	unregister_sidebar( 'footer-widget-1' );
	unregister_sidebar( 'footer-widget-2' );
	unregister_sidebar( 'footer-widget-3' );
	unregister_sidebar( 'footer-widget-4' );
}
add_action( 'widgets_init', 'velocity_remove_widgets', 11 );



///add action builder part
add_action('justg_before_header', 'wpberita_top_header');
function wpberita_top_header()
{
	require_once(get_stylesheet_directory() . '/inc/part-top-header.php');
}
add_action('justg_header', 'justg_header_berita');
function justg_header_berita()
{
	require_once(get_stylesheet_directory() . '/inc/part-header.php');
}
add_action('justg_do_footer', 'justg_footer_berita');
function justg_footer_berita()
{
	require_once(get_stylesheet_directory() . '/inc/part-footer.php');
}


// Fungsi untuk menambahkan kotak meta
function add_youtube_meta_box() {
    add_meta_box(
        'youtube_video_meta_box',
        'YouTube Video',
        'display_youtube_meta_box',
        'post', 
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_youtube_meta_box');

// Fungsi untuk menampilkan kotak meta
function display_youtube_meta_box($post) {
    $youtube_link = get_post_meta($post->ID, 'youtube_link', true);
    ?>
    <label for="youtube_link">YouTube Link:</label>
    <input type="text" id="youtube_link" name="youtube_link" value="<?php echo $youtube_link; ?>" style="width:100%;" />
    <?php
}

// Fungsi untuk menyimpan nilai meta
function save_youtube_meta_data($post_id) {
    if (array_key_exists('youtube_link', $_POST)) {
        update_post_meta(
            $post_id,
            'youtube_link',
            $_POST['youtube_link']
        );
    }
}
add_action('save_post', 'save_youtube_meta_data');


// Menampilkan banner iklan
function get_berita_iklan($idiklan)	{
	$iklan_content  = velocitytheme_option('image_' . $idiklan, '');
	echo '<div class="part_' . $idiklan . '">';
	if ($iklan_content) {
		$linkiklan = velocitytheme_option('link_' . $idiklan, '');
		echo $linkiklan ? '<a href="' . $linkiklan . '" target="_blank">' : '';
		echo '<img class="img-fluid" src="' . $iklan_content . '" loading="lazy">';
		echo $linkiklan ? '</a>' : '';
	}
	echo '</div>';
}



// Tanggal Pos
function velocity_post_date($post_id = null, $time = false) {
	global $post;
    if (empty($post_id)){
        $post_id = $post->ID;
    }
	$day = get_the_date('N',$post_id);
	$tgl = get_the_date('j',$post_id);
	$month = get_the_date('n',$post_id);
	$year = get_the_date('Y',$post_id);
	$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);			
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	if($time == true){
		$tampil_waktu = ' '.get_the_date('h:i',$post_id);
	} else {
		$tampil_waktu = '';
	}  
	$icon = '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="align-middle me-1 bi bi-clock" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
	<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/></svg>';
	echo $icon.$tgl.' '.$bulan[$month].' '.$year.$tampil_waktu;
}


// Display Post Categories
function velocity_post_categories($post_id = null) {
	global $post;
    if (empty($post_id)){
        $post_id = $post->ID;
    }
	$post_categories = wp_get_post_categories( $post_id, array( 'fields' => 'all' ) );
	if( $post_categories ){
		echo '<span class="velocity-post-categories">';
		foreach($post_categories as $cat){
			echo '<a class="fw-bold text-color-theme" href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a>';
		}
		echo '</span>';
	}
}


// Display Post Tags
function velocity_post_tags($post_id = null) {
	global $post;
    if (empty($post_id)){
        $post_id = $post->ID;
    }
	$terms = get_the_terms( $post_id, array( 'post_tag') );
	if($terms){
		echo '<div class="velocity-post-terms">Tags:';
		foreach($terms as $term){
			echo '<a class="d-inline-block py-1 px-4 bg-gray ms-2 mb-2" href="'.get_category_link($term->term_id).'">'.$term->name.'</a>';
		}
		echo '</div>';
	}
}


// Menampilkan post caousel
function velocity_post_carousel($cat_id = null, $column = 4, $show_title = false) {
    $args['post_type'] = 'post';
    $args['showposts'] = 5;
    if (!empty($cat_id)){
        $args['cat'] = $cat_id;
    } if(is_archive() && empty($cat_id)){
		$tax = get_queried_object();
		$args['meta_key'] = 'hit';
		$args['orderby'] = 'meta_value_num';
		$args['order'] = 'DESC';
		$args['tax_query'] = array(
			array(
				'taxonomy' => $tax->taxonomy,
				'field'    => 'slug',
				'terms'    => $tax->slug,
			)
		);
	}
    // The Query
    $the_query = new WP_Query($args);
    // The Loop
    if ($the_query->have_posts()) {
        echo '<div class="overflow-hidden position-relative">';
			if($show_title == true){
				velocity_cat_name($cat_id);
			}
			echo '<div class="velocity-post-carousel post-carousel-'.$column.'">';
				while ($the_query->have_posts()) {
					$the_query->the_post();
					echo '<div class="velocity-post-list p-1">';
						echo '<div class="position-relative velocity-post-thumbnail">';
							echo do_shortcode('[resize-thumbnail width="300" height="200" linked="true" class="w-100"]');
							echo '<a class="w-100 bg-dark p-2 d-block text-white bg-opacity-75 position-absolute bottom-0 start-0" href="'.get_the_permalink().'">'.get_the_title().'</a>';
						echo '</div>';			
					echo '</div>';			
				}
			echo '</div>';
        echo '</div>';
    }
    /* Restore original Post Data */
    wp_reset_postdata();
}


// Menampilkan post gallery
function velocity_posts_gallery() {
	if (have_posts()) {
		if($show_title == true){
			velocity_cat_name($cat_id);
		}
		echo '<div class="row velocity-post-gallery">';
			while (have_posts()) {
				the_post();
				echo '<div class="col-md-3 col-6 p-1">';
					echo '<div class="position-relative velocity-post-thumbnail">';
						echo do_shortcode('[resize-thumbnail width="350" height="350" linked="true" class="w-100"]');
						echo '<a class="w-100 bg-dark p-2 d-block text-white bg-opacity-75 position-absolute bottom-0 start-0" href="'.get_the_permalink().'">'.get_the_title().'</a>';
					echo '</div>';			
				echo '</div>';			
			}
		echo '</div>';
		echo '<div class="text-center pt-2">';
			justg_pagination();
		echo '</div>';
    } else {
		get_template_part( 'loop-templates/content', 'none' );
	}
    /* Restore original Post Data */
    wp_reset_postdata();
}


// Menampilkan post list
function velocity_posts_list($cat_id = null, $show_title = true) {
    $args['post_type'] = 'post';
    $args['showposts'] = 5;
    if (!empty($cat_id)){
        $args['cat'] = $cat_id;
    }
    // The Query
    $the_query = new WP_Query($args);
    // The Loop
    if ($the_query->have_posts()) {
		if($show_title == true){
			velocity_cat_name($cat_id);
		}
		echo '<div class="velocity-post-list">';
			while ($the_query->have_posts()) {
				$the_query->the_post();
				velocity_post_loop('',false);			
			}
		echo '</div>';
    }
    /* Restore original Post Data */
    wp_reset_postdata();
}



// Menampilkan post loop 
function velocity_post_loop($post_id = null, $content = true, $width = 300, $height = 250) {
    global $post;
    if (empty($post_id)){
        $post_id = $post->ID;
    } 
	$class_col_left = 'col-4';
	$class_col_right = 'col-8';
	echo '<div class="velocity-post-content text-muted mb-2 ">';
	echo '<div class="row">';
		echo '<div class="col-left '.$class_col_left.' pe-0">';
			echo do_shortcode('[resize-thumbnail width="'.$width.'" height="'.$height.'" linked="true" class="w-100" post_id="'.$post_id.'"]');
		echo '</div>';
		echo '<div class="col-right '.$class_col_right.' ps-md-2">';
		    echo '<small class="d-block text-success mb-1">';
				echo velocity_post_date($post_id);
			echo '</small>';
			echo '<div class="mb-1">';
				echo '<a class="secondary-font fw-bold text-color-theme" href="'.get_the_permalink($post_id).'">'.get_the_title($post_id).'</a>';
			echo '</div>';
			if($content == true){
				echo '<div class="d-md-block d-none">';
					echo do_shortcode('[velocity-excerpt count="80" post_id="'.$post_id.'"]');
				echo '</div>';
			}
		echo '</div>';
	echo '</div>';
	echo '</div>';
}


function velocity_cat_name($cat_id = null) {
    if (!empty($cat_id)){
		echo '<div class="velocity-title">'.get_cat_name($cat_id).'</div>';
    } else {
		echo '<div class="velocity-title">Berita Terbaru</div>';
	}
}


function velocity_thumbnail($lebar,$tinggi,$krop,$upscl,$kelas,$postid) {
    global $post;
    $width = isset($lebar)? $lebar : '400';
    $height = isset($tinggi)? $tinggi : '300';
    $crop = isset($krop)? $krop : 'false';
    $upscale = isset($upscl)? $upscl : 'false';
    $class = isset($kelas)? $kelas : 'vel-image';
    $post_id = isset($postid)? $postid : $post->ID;	
	$youtube_link = get_post_meta($post_id,'youtube_link', true);

    echo '<a class="d-block position-relative" href="'.get_permalink($post_id).'">';
	if($youtube_link){
		echo '<div class="velocity-thumbnail-video"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16"><path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z"/></svg></div>';
	}
    if(has_post_thumbnail($post_id)){
      $url = get_the_post_thumbnail_url($post_id,'full');
      $urlresize = aq_resize( $url, $width, $height, $crop, true, $upscale );
      echo '<img class="'.$class.'" src="'.$urlresize.'">';
    } else {
      $first_img = '';
      $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
      if(isset($matches [1] [0])){
        $first_img = $matches [1] [0];
        $image = aq_resize( $first_img, $width, $height, $crop, true, $upscale );
        echo '<img class="'.$class.'" src="'.$image.'" width="'.$width.'" height="'.$height.'" />';
      } else {
        echo '<svg style="background-color: #ececec;width: 100%;height: auto;" width="'.$width.'" height="'.$height.'"></svg>';			
      } 
    }
    echo '</a>';
}




// Update jumlah pengunjung 
function velocity_allpage() {
    global $wpdb,$post;
    $postID = $post->ID;
    $count_key = 'hit';
    if(empty($post))
    return false;
        $user_ip = $_SERVER['REMOTE_ADDR']; //retrieve the current IP address of the visitor
        $key = $user_ip . 'x' . $postID; //combine post ID & IP to form unique key
        $value = array($user_ip, $postID); // store post ID & IP as separate values (see note)
        $visited = get_transient($key); //get transient and store in variable

        //check to see if the Post ID/IP ($key) address is currently stored as a transient
        if ( false === ( $visited ) ) {

            //store the unique key, Post ID & IP address for 12 hours if it does not exist
           set_transient( $key, $value, 60*60*12 );

            // now run post views function
            $count = get_post_meta($postID, $count_key, true);
            if($count==''){
                $count = 0;
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
            }else{
                $count++;
                update_post_meta($postID, $count_key, $count);
            }
        }
}
add_action( 'wp', 'velocity_allpage' );




// Share Buttons
function velocity_social_share() {
	global $post;
	if(is_singular() || is_home()){
		$post_id = $post->ID;
		// Get current URL 
		$sb_url = urlencode(get_permalink($post_id));
  
		// Get current web title
		$sb_title = str_replace( ' ', '%20', get_the_title($post_id));
		 
		// Construct sharing URL without using any script
		$twitterURL = 'https://twitter.com/intent/tweet?text='.$sb_title.'&amp;url='.$sb_url;
		$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$sb_url;
		$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$sb_url.'&amp;title='.$sb_title;
		$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$sb_url.'&amp;description='.$sb_title;
		$whatsappURL ='https://api.whatsapp.com/send?text='.$sb_title.' '.$sb_url;
		$telegramURL ='https://telegram.me/share/url?url='.$sb_url.'';
		$emailURL ='mailto:?subject=I wanted you to see this site&amp;body='.$sb_title.' '.$sb_url.' ';
		
		$twitter_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
		<path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
	  </svg>';
		$facebook_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
		<path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
	  </svg>';
		$linkedin_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
		<path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
	  </svg>';
		$pinterest_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pinterest" viewBox="0 0 16 16">
		<path d="M8 0a8 8 0 0 0-2.915 15.452c-.07-.633-.134-1.606.027-2.297.146-.625.938-3.977.938-3.977s-.239-.479-.239-1.187c0-1.113.645-1.943 1.448-1.943.682 0 1.012.512 1.012 1.127 0 .686-.437 1.712-.663 2.663-.188.796.4 1.446 1.185 1.446 1.422 0 2.515-1.5 2.515-3.664 0-1.915-1.377-3.254-3.342-3.254-2.276 0-3.612 1.707-3.612 3.471 0 .688.265 1.425.595 1.826a.24.24 0 0 1 .056.23c-.061.252-.196.796-.222.907-.035.146-.116.177-.268.107-1-.465-1.624-1.926-1.624-3.1 0-2.523 1.834-4.84 5.286-4.84 2.775 0 4.932 1.977 4.932 4.62 0 2.757-1.739 4.976-4.151 4.976-.811 0-1.573-.421-1.834-.919l-.498 1.902c-.181.695-.669 1.566-.995 2.097A8 8 0 1 0 8 0z"/>
	  </svg>';
		$whatsapp_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
		<path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
	  </svg>';
		$telegram_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telegram" viewBox="0 0 16 16">
		<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z"/>
	  </svg>';
		$email_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
		<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
	  </svg>';
  
		// Add sharing button at the end of page/page content
		echo '<a class="btn btn-sm bg-gray m-1 s-twitter postshare-button" href="'.$twitterURL.'" target="_blank" rel="nofollow">'.$twitter_icon.'</a>';
		echo '<a class="btn btn-sm bg-gray m-1 s-facebook postshare-button" href="'.$facebookURL.'" target="_blank" rel="nofollow">'.$facebook_icon.'</a>';
		echo '<a class="btn btn-sm bg-gray m-1 s-whatsapp postshare-button" href="'.$whatsappURL.'" target="_blank" rel="nofollow">'.$whatsapp_icon.'</a>';
		echo '<a class="btn btn-sm bg-gray m-1 s-pinterest postshare-button" href="'.$pinterestURL.'" data-pin-custom="true" target="_blank" rel="nofollow">'.$pinterest_icon.'</a>';
		echo '<a class="btn btn-sm bg-gray m-1 s-linkedin postshare-button" href="'.$linkedInURL.'" target="_blank" rel="nofollow">'.$linkedin_icon.'</a>';
		echo '<a class="btn btn-sm bg-gray m-1 s-telegram postshare-button" href="'.$telegramURL.'" target="_blank" rel="nofollow">'.$telegram_icon.'</a>';
		echo '<a class="btn btn-sm bg-gray m-1 s-email postshare-button" href="'.$emailURL.'" target="_blank" rel="nofollow">'.$email_icon.'</a>';
	}
}

