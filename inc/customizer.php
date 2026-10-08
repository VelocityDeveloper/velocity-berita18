<?php

/**
 * Pengaturan Berita 18 di Customizer bawaan WordPress (tanpa Kirki).
 *
 * Nama theme mod sama dengan versi Kirki (color_theme, image_iklan_*, link_iklan_*, cat_*)
 * supaya nilai yang sudah tersimpan tetap terbaca sesudah tema diperbarui.
 * Latar website memakai menu Background induk (field Kirki lama `background_website`
 * dibaca induk sebagai latar lama).
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/** Warna & latar bawaan tema (bawaan field Kirki versi lama). */
define('VELOCITY_BERITA18_WARNA', '#222222');
define('VELOCITY_BERITA18_LATAR', '#111111');

/**
 * Slot iklan: id => [label, keterangan ukuran].
 * Ukuran "WxH" di keterangan dibaca installer untuk membuat banner "Ruang Iklan" seukuran slot.
 */
function velocity_berita18_slot_iklan()
{
    return array(
        'iklan_header1' => array('Iklan Header 1', 'Ukuran gambar 980x100'),
        'iklan_header2' => array('Iklan Header 2 (bawah menu)', 'Ukuran gambar 980x100'),
        'iklan_footer' => array('Iklan Footer', 'Ukuran gambar 980x100'),
        'iklan_single' => array('Iklan Halaman Berita', 'Iklan Halaman Berita 640x100'),
    );
}

/** Blok berita beranda: id => label. */
function velocity_berita18_blok()
{
    return array(
        'berita1' => 'Berita 1 (slider)',
        'berita2' => 'Berita 2 (carousel)',
        'berita3' => 'Berita 3 (carousel)',
    );
}

function velocity_berita18_sanitize_kategori($value)
{
    $value = (string) $value;
    return ($value !== '' && term_exists((int) $value, 'category')) ? (string) absint($value) : '';
}

add_action('customize_register', 'velocity_berita18_customize_register', 20);
function velocity_berita18_customize_register(WP_Customize_Manager $wp_customize)
{
    $wp_customize->add_panel('panel_berita', array(
        'priority' => 10,
        'title'    => esc_html__('Berita', 'justg'),
    ));

    // Warna.
    $wp_customize->add_section('section_colorberita', array(
        'panel'       => 'panel_berita',
        'title'       => esc_html__('Warna', 'justg'),
        'description' => esc_html__('Kosongkan untuk memakai warna utama tema (Primary Color) atau warna bawaan tema. Latar website diatur di menu Background.', 'justg'),
        'priority'    => 10,
    ));
    $wp_customize->add_setting('color_theme', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_theme', array(
        'label'   => esc_html__('Warna Tema', 'justg'),
        'section' => 'section_colorberita',
    )));

    // Iklan.
    $wp_customize->add_section('section_iklanberita', array(
        'panel'       => 'panel_berita',
        'title'       => esc_html__('Iklan', 'justg'),
        'description' => esc_html__('Slot tanpa gambar tidak ditampilkan.', 'justg'),
        'priority'    => 20,
    ));
    foreach (velocity_berita18_slot_iklan() as $id => $slot) {
        $wp_customize->add_setting('image_' . $id, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_' . $id, array(
            'label'       => sprintf(esc_html__('Gambar %s', 'justg'), $slot[0]),
            'description' => $slot[1],
            'section'     => 'section_iklanberita',
        )));
        $wp_customize->add_setting('link_' . $id, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('link_' . $id, array(
            'type'    => 'url',
            'label'   => sprintf(esc_html__('Link %s', 'justg'), $slot[0]),
            'section' => 'section_iklanberita',
        ));
    }

    // Blok berita beranda.
    $wp_customize->add_section('section_homeberita', array(
        'panel'       => 'panel_berita',
        'title'       => esc_html__('Home', 'justg'),
        'description' => esc_html__('Judul blok = nama kategori yang dipilih. Blok galeri di bawahnya selalu menampilkan berita terbaru.', 'justg'),
        'priority'    => 30,
    ));

    $kategori = array('' => esc_html__('Semua Kategori (terbaru)', 'justg'));
    foreach (get_categories(array('hide_empty' => false, 'exclude' => array(1))) as $term) {
        $kategori[(string) $term->term_id] = $term->name;
    }

    foreach (velocity_berita18_blok() as $id => $label) {
        $wp_customize->add_setting('cat_' . $id, array(
            'default'           => '',
            'sanitize_callback' => 'velocity_berita18_sanitize_kategori',
        ));
        $wp_customize->add_control('cat_' . $id, array(
            'type'    => 'select',
            'label'   => sprintf(esc_html__('Kategori %s', 'justg'), $label),
            'section' => 'section_homeberita',
            'choices' => $kategori,
        ));
    }
}

/**
 * Warna tema: pilihan Customizer Berita, lalu Primary Color induk (diisi installer dari
 * warna klien), lalu warna bawaan tema.
 */
function velocity_berita18_warna()
{
    $warna = sanitize_hex_color((string) get_theme_mod('color_theme', ''));
    if (!$warna) {
        $utama = sanitize_hex_color((string) get_theme_mod('primary_color', ''));
        $warna = ($utama && strtolower($utama) !== '#1e73be') ? $utama : VELOCITY_BERITA18_WARNA;
    }
    return $warna;
}

add_action('wp_head', 'velocity_berita18_css_warna', 100);
function velocity_berita18_css_warna()
{
    printf(
        '<style id="velocity-berita18-warna">:root{--color-theme:%1$s;}.border-color-theme{--bs-border-color:%1$s;}</style>' . "\n",
        esc_attr(velocity_berita18_warna())
    );
}

// Latar bawaan desain Berita 18 untuk menu Background induk.
add_filter('justg_theme_default_settings', 'velocity_berita18_default_settings');
function velocity_berita18_default_settings($defaults)
{
    $defaults['background_website_color'] = VELOCITY_BERITA18_LATAR;
    return $defaults;
}

/**
 * Migrasi sekali dari versi Kirki: latar Kirki `background_website` dipindah ke menu
 * Background induk; bila belum pernah disimpan, putih bawaan induk diganti latar bawaan tema.
 */
add_action('after_setup_theme', 'velocity_berita18_migrasi_kirki', 5);
function velocity_berita18_migrasi_kirki()
{
    if (get_theme_mod('velocity_berita18_migrasi')) {
        return;
    }

    $lama  = get_theme_mod('background_website', array());
    $warna = get_theme_mod('background_website_color', null);

    if (is_array($lama) && !empty($lama)) {
        $peta = array(
            'background-color'      => 'background_website_color',
            'background-image'      => 'background_website_image',
            'background-repeat'     => 'background_website_repeat',
            'background-position'   => 'background_website_position',
            'background-size'       => 'background_website_size',
            'background-attachment' => 'background_website_attachment',
        );
        foreach ($peta as $dari => $ke) {
            if (isset($lama[$dari]) && '' !== $lama[$dari]) {
                set_theme_mod($ke, 'background-image' === $dari ? esc_url_raw($lama[$dari]) : sanitize_text_field($lama[$dari]));
            }
        }
    } elseif (null === $warna || '#ffffff' === strtolower((string) $warna)) {
        set_theme_mod('background_website_color', VELOCITY_BERITA18_LATAR);
    }

    set_theme_mod('velocity_berita18_migrasi', 1);
}

/** URL gambar iklan; Kirki lama bisa menyimpan id lampiran atau array. */
function velocity_berita18_url_gambar($nilai)
{
    if (is_numeric($nilai)) {
        return (string) wp_get_attachment_url((int) $nilai);
    }
    if (is_array($nilai)) {
        $nilai = isset($nilai['url']) ? $nilai['url'] : (isset($nilai['id']) ? wp_get_attachment_url((int) $nilai['id']) : '');
    }
    return (string) $nilai;
}

/** Id kategori blok beranda untuk WP_Query ('' = semua kategori). */
function velocity_berita18_kategori($id)
{
    $cat = get_theme_mod('cat_' . $id, '');
    if (is_array($cat)) {
        $cat = reset($cat);
    }
    $cat = (string) $cat;
    return ($cat === '' || !term_exists((int) $cat, 'category')) ? '' : (string) absint($cat);
}
