<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

function enqueue_custom_scripts() {
	// キャッシュクリア用
	$current_time = date('YmdHis');
	// リセットCSS
	wp_enqueue_style('style', get_template_directory_uri() . '/css/reset.min.css', array());
	// SwiperのJSファイルとCSSファイルをCDNで読み込み
	wp_enqueue_style('swiper', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css', array(), '11.0');
	wp_enqueue_script('swiper', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js', array(), '11.0', false);

	// 共通スタイルの読み込み
	wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(), $current_time);
	wp_enqueue_style('header-css', get_template_directory_uri() . '/css/header.css', array(), $current_time);
	wp_enqueue_style('footer-css', get_template_directory_uri() . '/css/footer.css', array(), $current_time);

	// 条件分岐によるスタイルの読み込み（ここは構成によって変えてください。）
	if (is_front_page()) {
		wp_enqueue_style('master-css', get_template_directory_uri() . '/assets/css/master.css', array(), $current_time);
		wp_enqueue_style('front-page-css', get_template_directory_uri() . '/assets/css/front-page.css', array('master-css'), $current_time);
	} elseif (is_post_type_archive('members')) {
		wp_enqueue_style('master-css', get_template_directory_uri() . '/assets/css/master.css', array(), $current_time);
		wp_enqueue_style('archive-members-css', get_template_directory_uri() . '/assets/css/archive-members.css', array(), $current_time);
	} else if (is_page('company')) {
		wp_enqueue_style('master-css', get_template_directory_uri() . '/assets/css/master.css', array(), $current_time);
		wp_enqueue_style('company-css', get_template_directory_uri() . '/assets/css/page-company.css', array(), $current_time);
	} else if (is_page("thanks")) {
		wp_enqueue_style('master-css', get_template_directory_uri() . '/assets/css/master.css', array(), $current_time);
	}
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
