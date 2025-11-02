<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

if (! function_exists( 'mytheme_setup' ) ) :
	/**
	 * テーマの基本的な設定を行います。
	 */
	function mytheme_setup() {
		/*
		 * テーマを翻訳可能にします。
		 * 翻訳ファイルは /languages/ ディレクトリに配置してください。
		 */
		load_theme_textdomain( 'mytheme', get_template_directory(). '/languages' );

		// <title>タグをWordPressに管理させるためにテーマサポートを追加します。
		add_theme_support( 'title-tag' );

		// 投稿と固定ページでアイキャッチ画像を有効にします。
		add_theme_support( 'post-thumbnails' );

		// RSSフィードのリンクを<head>に出力します。
		add_theme_support( 'automatic-feed-links' );

		/*
		 * 検索フォーム、コメントフォーム、コメントリストなどで
		 * 最新のHTML5マークアップを使用できるようにします。
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// このテーマで使用するナビゲーションメニューを登録します。
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'mytheme' ),
				'footer'  => esc_html__( 'Footer Menu', 'mytheme' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'mytheme_setup' );

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
        } else if (is_page_template('job-details.php')) {
                wp_enqueue_style('job-details-css', get_template_directory_uri() . '/css/job-details.css', array(), $current_time);
        } else if (is_page("thanks")) {
                wp_enqueue_style('master-css', get_template_directory_uri() . '/assets/css/master.css', array(), $current_time);
        }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

/**
 * ウィジェットエリア（サイドバー）を登録します。
 */
function mytheme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Main Sidebar', 'mytheme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'mytheme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'mytheme_widgets_init' );

// Structured data (JSON-LD) output.
require_once get_template_directory() . '/features/seo/structured-data/init.php';

// Security hardening helpers.
require_once get_template_directory() . '/features/security/init.php';

