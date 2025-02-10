<?php
namespace etto_Theme;

class Data {

    use \etto_Theme\Data\Default_Data;

    /**
     * DB名
     */
    private const DB_NAMES = array(
        'customizer'  => 'etto_settings',
        'licence_key' => 'etto_licence_key',
    );

    /**
     * データ通信先
     */
    private const CDN_URL = 'https://#####';

    /**
     * テーマバージョン
     */
    private static $theme_ver = '';
    private static $file_ver  = '';

    /**
     * カスタマイザーの設定データ
     */
    private static $settings         = array();
    private static $default_settings = array();

    /**
     * プラグインのデータ
     */
    private static $plugin_data = array();

    /**
     * lazyload種別
     */
    private static $lazy_type = 'lazy';

    /**
     * ライセンス系
     */
    private static $licence_key     = '';
    private static $licence_data    = array();
    private static $has_pro_licence = false;
    private static $ex_update_path  = false;

    /**
     * 日本語かどうか
     */
    private static $is_ja = false;

    /**
     * テキスト系HTMLを許可する時にwp_ksesに渡す配列
     */
    private static $allowed_html = array(
        'a'      => array(
            'href'   => true,
            'rel'    => true,
            'target' => true,
        ),
        'strong' => array(),
        'em'     => array(),
        'p'      => array(),
    );

    /**
     * init()
     */
    public static function init() {
        // テーマセットアップ
        add_action( 'after_setup_theme', array( self::class, 'setup_theme' ), 1 );
    }

    /**
     * テーマセットアップ処理
     */
    public static function setup_theme() {
        self::set_theme_version();
        self::set_licence_data();
        self::set_default_data();
    }

    /**
     * テーマバージョンをセット
     */
    private static function set_theme_version() {
        $theme_data      = wp_get_theme( 'arkhe' );
        self::$theme_ver = sanitize_text_field( $theme_data->get( 'Version' ) );

        // キャッシュバスティング用のバージョン
        self::$file_ver = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? time() : self::$theme_ver;
    }

    /**
     * ライセンス情報をセット
     */
    private static function set_licence_data() {
        // ライセンスキーを取得
        $licence_key = get_option( self::DB_NAMES['licence_key'] );
        self::$licence_key = sanitize_text_field( $licence_key );

        if ( self::$licence_key ) {
            $licence_data = \etto_Theme::get_licence_data( self::$licence_key );
            if ( is_array( $licence_data ) ) {
                self::$licence_data = array_map( 'sanitize_text_field', $licence_data );
                self::$has_pro_licence = in_array( (int) $licence_data['status'], array( 1, 2 ), true );
                self::$ex_update_path = $licence_data['path'] ?? '';
            }
        }
    }

    /**
     * 設定データのデフォルト値をセット
     */
    private static function set_default_data() {
        self::$default_settings = self::get_default_settings();
    }

    /**
     * HTML許可リストを取得
     */
    public static function get_allowed_html() {
        return self::$allowed_html;
    }
}
